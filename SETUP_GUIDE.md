# Intebwio - Quick Setup Guide

## ⚡ 5-Minute Quick Start

### Step 1: Install Files
```bash
cd /path/to/project
php public_html/install.php
```

### Step 2: Configure Database
Edit `public_html/includes/config.php`:
```php
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'u757840095_Intebwio');
define('DB_USER', 'u757840095_Yaroslav');
define('DB_PASS', 'l1@ArIsM');
```

### Step 3: Set AI Provider
```php
define('AI_PROVIDER', 'openai'); // or 'gemini', 'anthropic'
define('AI_API_KEY', 'your-key-here');
```

### Step 4: Test Installation
```bash
curl http://localhost/api/health.php
```

## 📁 Project Structure

```
intebwio4/
├── README.md
├── README_COMPREHENSIVE.md
├── SETUP_GUIDE.md (this file)
└── public_html/
    ├── index.html (old homepage)
    ├── index-ai.html (new AI-enhanced homepage)
    ├── install.php (installation wizard)
    │
    ├── includes/ (PHP Classes)
    │   ├── config.php (configuration)
    │   ├── Database.php (DB abstraction)
    │   ├── AIService.php (AI integration)
    │   ├── AdvancedPageGenerator.php (page generation)
    │   ├── AdvancedConfig.php (advanced settings)
    │   ├── CacheManager.php (caching)
    │   ├── ContentAggregator.php (content gathering)
    │   ├── ContentUpdateService.php (auto-updates)
    │   ├── DatabaseMigration.php (schema creation)
    │   ├── ImageOptimizer.php (image processing)
    │   ├── IntebwioUtils.php (utility functions)
    │   ├── PageGenerator.php (basic generator)
    │   └── SearchOptimizer.php (search optimization)
    │
    ├── api/ (REST Endpoints)
    │   ├── ai-search.php (main search - one page per topic)
    │   ├── analytics.php (analytics data)
    │   ├── backup.php (backup management)
    │   ├── comments.php (comment handling)
    │   ├── dashboard.php (admin dashboard)
    │   ├── export.php (data export)
    │   ├── health.php (system health check)
    │   ├── insights.php (advanced analytics)
    │   ├── pages.php (page CRUD operations)
    │   └── settings.php (system settings)
    │
    ├── css/ (Stylesheets)
    │   ├── ai-page.css (AI page styling)
    │   └── intebwio-page.css (general styling)
    │
    ├── js/ (JavaScript)
    │   ├── ai-page.js (page interactivity)
    │   ├── intebwio.js (basic search)
    │   └── intebwio-enhanced.js (enhanced browser)
    │
    ├── logs/ (error/activity logs)
    ├── uploads/ (user uploads)
    ├── backups/ (database backups)
    └── cache/ (image cache)
```

## 📊 Code Statistics

| Component | Lines | Purpose |
|-----------|-------|---------|
| AIService.php | 300 | AI API integration |
| AdvancedPageGenerator.php | 400 | HTML page generation |
| api/ai-search.php | 250 | Core search endpoint |
| CacheManager.php | 200 | Multi-layer caching |
| css/ai-page.css | 350 | Page styling |
| js/ai-page.js | 300 | Page interactivity |
| ContentUpdateService.php | 200 | Auto-updates |
| SearchOptimizer.php | 200 | Search optimization |
| ImageOptimizer.php | 180 | Image processing |
| DatabaseMigration.php | 250 | Schema management |
| IntebwioUtils.php | 200 | Utilities |
| api/health.php | 200 | Health monitoring |
| api/insights.php | 220 | Advanced analytics |
| api/backup.php | 180 | Backup system |
| api/pages.php | 200 | Page management |
| api/settings.php | 180 | Settings API |
| install.php (wizard) | 250 | Installation script |
| js/intebwio-enhanced.js | 250 | Enhanced browser |
| index-ai.html | 350 | AI homepage |
| README_COMPREHENSIVE.md | 400 | Full documentation |
| **TOTAL** | **4,595+** | **Production code** |

## 🔌 API Endpoints

### Search & Discovery
- `POST /api/ai-search.php` - AI-powered search (one page per topic)
- `POST /api/pages.php?action=search` - Search existing pages
- `GET /api/pages.php?action=list` - List all pages

### Page Management
- `GET /api/pages.php?action=get&id=123` - Get page details
- `POST /api/pages.php?action=update` - Update page
- `POST /api/pages.php?action=delete` - Delete page
- `POST /api/pages.php?action=duplicate` - Clone page
- `POST /api/pages.php?action=archive` - Archive page

### Comments & Discussion
- `POST /api/comments.php` - Post comment
- `GET /api/comments.php?page_id=123` - Get comments
- `POST /api/comments.php?action=like` - Like comment

### Analytics & Insights
- `GET /api/insights.php?type=summary&days=30` - Summary stats
- `GET /api/insights.php?type=daily-trend` - Daily trends
- `GET /api/insights.php?type=search-patterns` - Popular searches
- `GET /api/insights.php?type=growth` - Growth analytics
- `GET /api/analytics.php` - Page analytics (legacy)

### System Management
- `GET /api/health.php` - System health check
- `GET /api/dashboard.php?action=overview` - Admin dashboard
- `GET /api/dashboard.php?action=search_trends` - Trending searches
- `GET /api/backup.php?action=list` - List backups
- `POST /api/backup.php?action=create` - Create backup
- `GET /api/settings.php?action=get-all` - All settings
- `POST /api/settings.php?action=set` - Update setting

## 🗄️ Database Schema

### Core Tables
- **pages** - Main page content and metadata
- **search_results** - Search query tracking
- **page_comments** - User comments with moderation
- **user_activity** - User behavior analytics

### Support Tables
- **cache_metadata** - Cache performance tracking
- **api_requests** - API usage logging
- **update_history** - Version history
- **page_stats** - Daily statistics
- **similar_pages** - Related page tracking
- **page_versions** - Content versions

## 🎓 Key Features Explained

### "One Page Per Topic"
The `ai-search.php` endpoint ensures:
1. **Exact match check** - Returns existing page if found
2. **Similarity detection** - Prevents near-duplicates
3. **New generation** - Creates page only if truly novel topic
4. **Permanent caching** - Never regenerated, only updated weekly

### AI Integration
Three providers supported:
- **OpenAI** - GPT-4 (premium quality)
- **Google Gemini** - Pro model (fast)
- **Anthropic Claude** - Opus (advanced reasoning)

### Multi-Layer Caching
1. **APCu** - In-memory (fastest, 30 seconds)
2. **Redis** - Distributed (medium speed, days)
3. **Database** - Persistent (slowest, permanent)

### Auto-Updates
- Pages checked weekly (configurable)
- Content regenerated if outdated
- Change history maintained
- Performance monitored

## 📈 Monitoring

### Health Check
```bash
curl http://localhost/api/health.php
```

Returns:
- Database connectivity
- Table status
- Disk space
- Memory usage
- Cache performance

### Analytics Dashboard
```bash
curl http://localhost/api/dashboard.php?action=overview
```

Shows:
- Total pages and views
- Unique visitors
- Popular pages
- Trending searches
- System metrics

## 🔒 Security

### Pre-configured Protection
- Input sanitization (XSS prevention)
- Prepared statements (SQL injection prevention)
- Rate limiting (configurable)
- File upload validation
- API token requirements

### Recommended Setup
1. Enable HTTPS in production
2. Set environment variables (not in config)
3. Restrict API access by IP if needed
4. Regular backups (automated via cron)
5. Monitor logs for suspicious activity

## 🚀 Performance Tips

### Production Optimization
1. **Enable APCu** - For in-memory caching
2. **Setup Redis** - For distributed caching
3. **Use CDN** - For static assets
4. **Enable Gzip** - In web server
5. **Optimize images** - Automated by system
6. **Setup cron** - For auto-updates and backups

### Server Requirements
- **PHP**: 7.4+ (8.0+ recommended)
- **MySQL**: 5.7+ or MariaDB 10.3+
- **Memory**: 256MB+ (more for high traffic)
- **Disk**: 1GB+ (depends on content volume)
- **Extensions**: PDO, JSON, cURL (APCu optional)

## 📝 Common Tasks

### Create Manual Backup
```bash
curl -H "Authorization: Bearer token" \
  http://localhost/api/backup.php?action=create
```

### Export All Pages
```bash
curl http://localhost/api/export.php?action=export-pages
```

### Optimize Database
```bash
curl http://localhost/api/health.php # Shows optimization status
```

### Search for Pages
```bash
curl -X POST http://localhost/api/pages.php?action=search \
  -d "q=machine learning"
```

### Get Page Statistics
```bash
curl http://localhost/api/pages.php?action=stats&id=123
```

## 🆘 Troubleshooting

### Problem: Pages not appearing
- Check database connection: `curl http://localhost/api/health.php`
- Verify tables exist
- Check file permissions on `uploads/` directory

### Problem: AI not generating content
- Verify API key in config
- Check API provider status
- Review error logs in `/logs/`

### Problem: Cache not working
- Check if APCu installed: `php -m | grep apcu`
- Verify cache directory writable
- Check CACHE_ENABLED setting

### Problem: High memory usage
- Reduce CACHE_TTL
- Disable unnecessary extensions
- Clear old cache files

## 📚 Documentation Files

- **README.md** - Original project overview
- **README_COMPREHENSIVE.md** - Complete technical documentation
- **SETUP_GUIDE.md** - This file (quick reference)

## 📞 Support

For issues:
1. Check `/logs/` directory for errors
2. Run health check: `curl http://localhost/api/health.php`
3. Review configuration in `includes/config.php`
4. Check database connection credentials
5. Verify file permissions on uploads/cache directories

## 🎉 You're Ready!

Your Intebwio installation is configured and ready to use.

**Next Steps:**
1. Access the browser: `http://localhost/index-ai.html`
2. Search for your first topic
3. Visit the admin dashboard: `http://localhost/api/dashboard.php`
4. Explore the comprehensive documentation
5. Configure advanced features as needed

Happy searching! 🚀

