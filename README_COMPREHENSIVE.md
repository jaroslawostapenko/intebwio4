# Intebwio - Comprehensive Documentation

## Project Overview

**Intebwio** is an AI-powered web browser that generates professional landing pages for any search topic. Each unique topic receives exactly one permanently cached landing page, automatically updated weekly.

### Core Features
- 🤖 **AI-Powered Generation**: Uses OpenAI GPT-4, Google Gemini, or Anthropic Claude
- 📄 **One Page Per Topic**: Deduplication ensures no duplicate pages
- ⚡ **Lightning Fast**: Multi-layer caching with APCu, Redis support
- 🎨 **Professional Design**: Responsive HTML with tables, images, diagrams
- 📊 **Analytics**: Comprehensive user behavior tracking
- 🔄 **Auto-Updates**: Weekly content refresh with change detection
- 💬 **Community**: Comments and discussions on pages
- 📱 **Mobile Optimized**: Fully responsive design
- 🔍 **SEO Optimized**: Auto-generated meta tags and structured data

## Project Statistics

- **Total New Code**: ~2,500+ production lines
- **Language**: PHP 7.4+, JavaScript (ES6), HTML5, CSS3
- **Database**: MySQL 5.7+ / MariaDB 10.3+
- **API Endpoints**: 15+ RESTful endpoints
- **Database Tables**: 10+ normalized tables
- **Features**: 20+ major features with extensive utilities

## Installation & Setup

### Prerequisites

- PHP 7.4+ with extensions:
  - PDO (MySQL)
  - JSON
  - cURL
  - OpenSSL
  - APCu (optional, for caching)

- MySQL 5.7+ or MariaDB 10.3+

- Web Server (Apache/Nginx)

### Quick Start

1. **Install using provided script:**
   ```bash
   php public_html/install.php
   ```

2. **Configure API Keys:**
   Edit `public_html/includes/config.php`:
   ```php
   define('AI_PROVIDER', 'openai');
   define('AI_API_KEY', 'sk-...');
   ```

3. **Access Application:**
   - Homepage: `http://localhost/index-ai.html`
   - Health Check: `http://localhost/api/health.php`
   - Analytics: `http://localhost/api/insights.php?type=summary`

### Database Schema

The application uses 10+ tables:

- **pages**: Main content table with AI-generated pages
- **search_results**: Search query tracking and ranking
- **page_comments**: User comments and discussions
- **user_activity**: User behavior analytics
- **cache_metadata**: Cache performance tracking
- **api_requests**: API usage logging
- **page_stats**: Daily statistics aggregation
- **update_history**: Version history of page updates
- **similar_pages**: Tracks related/similar pages
- **page_versions**: Content version management

## API Reference

### Search API
**Endpoint**: `POST /api/ai-search.php`

Implements core "one page per topic" logic.

```bash
curl -X POST http://localhost/api/ai-search.php \
  -H "Content-Type: application/json" \
  -d '{"query":"machine learning"}'
```

**Response**:
```json
{
  "page_id": 123,
  "is_new": false,
  "search_query": "machine learning",
  "similarity_score": 0.95
}
```

### Analytics API
**Endpoint**: `GET /api/insights.php?type=summary&days=30`

Available types:
- `summary` - Overview statistics
- `daily-trend` - Daily trend analysis
- `ai-providers` - AI provider performance
- `search-patterns` - Popular search terms
- `engagement` - User engagement metrics
- `growth` - Growth analytics

### Health Check API
**Endpoint**: `GET /api/health.php`

Comprehensive system health status including:
- Database connectivity
- Table existence
- Disk space
- Memory usage
- Cache status
- Performance metrics

### Comments API
**Endpoint**: `POST /api/comments.php`

Manage page comments and discussions.

```bash
curl -X POST http://localhost/api/comments.php \
  -d "action=post&page_id=123&name=John&email=john@example.com&content=Great page!"
```

### Dashboard API
**Endpoint**: `GET /api/dashboard.php?action=overview`

Admin statistics and metrics:
- `overview` - General statistics
- `pages` - Page listings
- `search_trends` - Trending topics
- `page_performance` - Page metrics
- `system_health` - System status

### Backup API
**Endpoint**: `GET /api/backup.php?action=list`

Backup management:
- `list` - List all backups
- `create` - Create new backup
- `download` - Download backup file
- `delete` - Delete backup
- `status` - Backup status

## Core Classes

### AIService.php (~300 lines)
Handles AI integration with multiple providers:

```php
$aiService = new AIService();
$content = $aiService->generatePageContent(
    'machine learning',
    ['source_data' => $aggregatedData]
);
```

**Key Methods**:
- `generatePageContent()` - Main generation
- `callOpenAI()`, `callGemini()`, `callAnthropic()` - Provider APIs
- `analyzeRelevance()` - Content quality scoring
- `generateSEOMetadata()` - Meta tag generation

### AdvancedPageGenerator.php (~400 lines)
Professional HTML page generation:

```php
$generator = new AdvancedPageGenerator();
$html = $generator->generateAIPage(
    'machine learning',
    $contentData
);
```

**Key Features**:
- Table of contents with smooth scrolling
- Hero section with gradient
- Rich content formatting
- Responsive image system
- Related topics suggestions
- Source attribution

### CacheManager.php (~200 lines)
Multi-layer caching system:

```php
$cache = new CacheManager();
$page = $cache->getPageFromCache('machine learning');
$cache->cachePageData('machine learning', $htmlContent, 7 * 24 * 60 * 60);
```

**Backends**:
- APCu (primary)
- Redis (secondary)
- Database (fallback)

### ContentUpdateService.php (~200 lines)
Automatic content updates:

```php
$updater = new ContentUpdateService($pdo, $aiService, $aggregator, $generator);
$updates = $updater->updateOutdatedPages(604800); // 7 days
$duplicates = $updater->mergeDuplicatePages();
```

### SearchOptimizer.php (~200 lines)
Search optimization and analytics:

```php
$optimizer = new SearchOptimizer($pdo);
$stats = $optimizer->getSearchStatistics();
$suggestions = $optimizer->analyzeSuggestions();
$metrics = $optimizer->calculateSearchMetrics($pageId);
```

### ImageOptimizer.php (~180 lines)
Image processing and optimization:

```php
$imageOptimizer = new ImageOptimizer();
$result = $imageOptimizer->processUploadedImage($file);
$thumb = $imageOptimizer->generateThumbnail($imagePath, 200, 200);
```

### IntebwioUtils.php (~200 lines)
Common utility functions:

```php
IntebwioUtils::generateSlug('Machine Learning');
IntebwioUtils::sanitizeInput($userInput);
IntebwioUtils::calculateSimilarity($str1, $str2);
IntebwioUtils::formatBytes($bytes);
```

## Configuration Guide

### Environment Variables

Create `.env` file:

```env
AI_PROVIDER=openai
AI_API_KEY=sk-...
AI_MODEL=gpt-4

CACHE_DRIVER=apcu
CACHE_TTL=604800

AUTO_UPDATE_ENABLED=true
AUTO_UPDATE_INTERVAL=604800

RATE_LIMIT_ENABLED=true
DEBUG_MODE=false
```

### AI Provider Setup

#### OpenAI
```php
define('AI_PROVIDER', 'openai');
define('AI_API_KEY', 'sk-...');
define('AI_MODEL', 'gpt-4');
```

#### Google Gemini
```php
define('AI_PROVIDER', 'gemini');
define('AI_API_KEY', 'AIza...');
define('AI_MODEL', 'gemini-pro');
```

#### Anthropic Claude
```php
define('AI_PROVIDER', 'anthropic');
define('AI_API_KEY', 'sk-ant-...');
define('AI_MODEL', 'claude-3-opus');
```

## Deployment

### Local Development (XAMPP)

1. Place project in `htdocs/`
2. Configure database in `config.php`
3. Run installer: `php install.php`
4. Access: `http://localhost/intebwio4`

### Production (Hostinger)

1. Upload via FTP to `public_html/`
2. Create database via cPanel
3. Update credentials in `config.php`
4. Run migrations via database import
5. Set file permissions: `chmod 755 uploads/`
6. Configure SSL certificate
7. Update `APP_URL` in config

### Docker Deployment

```dockerfile
FROM php:8.0-apache
RUN docker-php-ext-install pdo pdo_mysql json
COPY . /var/www/html
RUN chmod -R 755 uploads/ logs/
```

## Performance Optimization

### Caching Strategy

1. **APCu Cache** (5-30 seconds)
   - Hot pages and frequently accessed data
   - In-memory, fastest performance

2. **Redis Cache** (optional, 1-7 days)
   - Medium-term storage
   - Shared across servers
   - Survives restarts

3. **Database Cache** (7+ days)
   - Persistent storage
   - Fallback mechanism
   - Historical tracking

### Query Optimization

- Indexed searches using FULLTEXT indexes
- Denormalized statistics for fast aggregation
- Prepared statements for all DB queries
- Connection pooling support

### Content Delivery

- Gzip compression enabled
- Image optimization (WebP fallback)
- CSS/JS minification ready
- Lazy loading for images
- CDN-ready URL structure

## Monitoring & Analytics

### Key Metrics

- Page view counts and unique visitors
- Average reading time and scroll depth
- User device and location tracking
- Search query analytics
- Cache hit rates
- API response times

### Admin Dashboard

Access: `/api/dashboard.php?action=overview`

Shows:
- Total pages and views
- Traffic trends
- Top performing pages
- User behavior patterns
- System health status

## Security Features

### Input Validation
- XSS prevention with htmlspecialchars()
- SQL injection prevention with prepared statements
- CSRF token support
- Rate limiting (configurable)

### Authentication
- API token-based access
- Optional admin session management
- Header-based authorization

### Data Protection
- Database encryption-ready
- HTTPS enforcement
- Secure password handling
- Audit logging

## Backup & Recovery

### Automated Backups
```bash
curl -H "Authorization: Bearer token" \
  http://localhost/api/backup.php?action=create
```

### Manual Backup
```bash
mysqldump -u user -p database > backup.sql
```

### Restore
```bash
mysql -u user -p database < backup.sql
```

## Troubleshooting

### Common Issues

**Issue**: Pages not generating
**Solution**: Check AI_API_KEY and provider configuration

**Issue**: Cache not working
**Solution**: Verify APCu extension is loaded: `php -m | grep apcu`

**Issue**: High memory usage
**Solution**: Reduce CACHE_TTL or disable APCu for large datasets

**Issue**: Slow searches
**Solution**: Run `php manage.php optimize-index` and verify FULLTEXT indexes

## Development

### File Structure
```
public_html/
├── includes/          # PHP classes and utilities
│   ├── config.php
│   ├── Database.php
│   ├── AIService.php
│   ├── CacheManager.php
│   ├── ImageOptimizer.php
│   └── ... (10+ more classes)
├── api/              # REST endpoints
│   ├── ai-search.php
│   ├── comments.php
│   ├── health.php
│   └── ... (10+ more endpoints)
├── js/               # Frontend JavaScript
│   ├── intebwio-enhanced.js
│   └── ai-page.js
├── css/              # Stylesheets
│   ├── ai-page.css
│   └── intebwio-page.css
└── index-ai.html     # Main landing page
```

### Adding New Features

1. Create service class in `includes/`
2. Add API endpoint in `api/`
3. Create database table if needed
4. Add migration in `DatabaseMigration.php`
5. Update documentation

### Testing

```php
// Test cache
$cache = new CacheManager();
var_dump($cache->getCacheStats());

// Test search
$search = new SearchOptimizer($pdo);
var_dump($search->getSearchStatistics());

// Test health
curl http://localhost/api/health.php
```

## License

Copyright © 2026 Intebwio. All rights reserved.

## Support

- Documentation: `/README.md`
- Issues: Check health endpoint
- Logs: Check `/logs/` directory
- Admin Dashboard: `/api/dashboard.php`

