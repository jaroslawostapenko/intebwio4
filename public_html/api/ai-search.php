<?php
/**
 * Intebwio - Advanced Search API with AI
 * One landing page per topic - AI-powered search and generation
 * ~250 lines
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/Database.php';
require_once __DIR__ . '/../includes/ContentAggregator.php';
require_once __DIR__ . '/../includes/AIService.php';
require_once __DIR__ . '/../includes/AdvancedPageGenerator.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['query']) || empty(trim($data['query']))) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Query is required']);
        exit;
    }
    
    $searchQuery = trim($data['query']);
    
    // Normalize query (lowercase, remove extra spaces)
    $normalizedQuery = strtolower(preg_replace('/\s+/', ' ', $searchQuery));
    
    // Input validation
    if (strlen($normalizedQuery) < 2 || strlen($normalizedQuery) > 500) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Query must be between 2 and 500 characters']);
        exit;
    }
    
    // Initialize services
    $db = new Database($pdo);
    
    // Check for exact match first
    $stmt = $pdo->prepare("
        SELECT id, relevance_score, view_count, last_scan_date 
        FROM pages 
        WHERE LOWER(search_query) = LOWER(?)
        LIMIT 1
    ");
    $stmt->execute([$normalizedQuery]);
    $existing = $stmt->fetch();
    
    if ($existing) {
        // Page exists - return it
        $db->recordActivity($existing['id'], $searchQuery, 'search');
        $db->updateViewCount($existing['id']);
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'exists' => true,
            'page_id' => $existing['id'],
            'is_new' => false,
            'message' => 'Found existing page',
            'metadata' => [
                'views' => $existing['view_count'],
                'relevance' => $existing['relevance_score'],
                'updated' => $existing['last_scan_date']
            ]
        ]);
        exit;
    }
    
    // Check for similar pages (reduce duplication)
    $stmt = $pdo->prepare("
        SELECT id, search_query 
        FROM pages 
        WHERE status = 'active'
        AND (
            LOWER(search_query) LIKE LOWER(CONCAT('%', ?, '%')) OR
            LOWER(?) LIKE LOWER(CONCAT('%', search_query, '%'))
        )
        ORDER BY view_count DESC
        LIMIT 5
    ");
    $stmt->execute([$normalizedQuery, $normalizedQuery]);
    $similar = $stmt->fetchAll();
    
    if (!empty($similar)) {
        // Found similar page, use it instead
        $similarId = $similar[0]['id'];
        $db->recordActivity($similarId, $searchQuery, 'search');
        $db->updateViewCount($similarId);
        
        // Store mapping
        $mapStmt = $pdo->prepare("
            INSERT IGNORE INTO similar_pages (page_id, similar_page_id, similarity_score)
            VALUES (?, ?, 0.85)
        ");
        $mapStmt->execute([$similarId, $similarId]);
        
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'exists' => true,
            'page_id' => $similarId,
            'is_similar' => true,
            'is_new' => false,
            'message' => 'Found similar page'
        ]);
        exit;
    }
    
    // NEW PAGE - Generate with AI
    $db->recordActivity(null, $searchQuery, 'search');
    
    // Step 1: Aggregate content
    $aggregator = new ContentAggregator($pdo);
    $aggregatedResults = $aggregator->aggregateContent($normalizedQuery, 0);
    
    if (empty($aggregatedResults)) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Unable to aggregate content'
        ]);
        exit;
    }
    
    // Step 2: Generate AI content
    $aiService = new AIService(
        getenv('AI_PROVIDER') ?? 'openai',
        getenv('AI_API_KEY') ?? ''
    );
    
    $advancedGenerator = new AdvancedPageGenerator($pdo, $aiService);
    $htmlContent = $advancedGenerator->generateAIPage($normalizedQuery, $aggregatedResults);
    
    if (!$htmlContent) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to generate page'
        ]);
        exit;
    }
    
    // Step 3: Extract metadata
    $title = ucfirst($normalizedQuery);
    $descriptionMatch = [];
    preg_match('/<p>(.*?)<\/p>/s', $htmlContent, $descriptionMatch);
    $description = isset($descriptionMatch[1]) ? strip_tags($descriptionMatch[1]) : 'AI-generated page about ' . $normalizedQuery;
    $description = substr($description, 0, 200);
    
    // Get thumbnail
    $thumbnailImage = null;
    foreach ($aggregatedResults as $result) {
        if (!empty($result['image_url'])) {
            $thumbnailImage = $result['image_url'];
            break;
        }
    }
    
    // Step 4: Store in database
    $pageId = $db->createOrGetPage($normalizedQuery, $title, $description, $htmlContent);
    
    if (!$pageId) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to save page'
        ]);
        exit;
    }
    
    // Step 5: Store aggregated results
    foreach ($aggregatedResults as $index => $result) {
        $result['position_index'] = $index;
        $db->addSearchResult($pageId, $result);
    }
    
    // Step 6: Store in cache
    $cacheKey = 'page_' . md5($normalizedQuery);
    apcu_store($cacheKey, [
        'page_id' => $pageId,
        'query' => $normalizedQuery,
        'timestamp' => time()
    ], 604800); // 7 days
    
    http_response_code(201); // Created
    echo json_encode([
        'success' => true,
        'exists' => false,
        'is_new' => true,
        'page_id' => $pageId,
        'message' => 'Page generated successfully',
        'metadata' => [
            'sources_count' => count($aggregatedResults),
            'generated_by' => 'AI',
            'title' => $title
        ]
    ]);
    
} catch (Exception $e) {
    error_log("Search API error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}

?>
