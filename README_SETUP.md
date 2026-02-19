# 🚀 Intebwio - AI-Powered Web Browser & Content Aggregation Platform

A revolutionary web application that generates intelligent landing pages by aggregating content from multiple sources. Pages are cached permanently and automatically updated once per week.

## 📋 Quick Start Guide

### Prerequisites
- **Hostinger Account** with Hostinger with cPanel/phpMyAdmin access
- **XAMPP** (for local development) with PHP 7.4+
- **MySQL Database** ready (public_html folder as root)

### Step 1: Database Setup

1. Go to **phpMyAdmin** in your Hostinger control panel
2. Create a new database (or use your existing one): `u757840095_Intebwio`
3. Import the SQL file:
   - Select the database
   - Click **SQL** tab
   - Copy & paste contents of `intebwio.sql`
   - Click **Execute**

**OR** via command line:
```bash
mysql -h 127.0.0.1 -u u757840095_Yaroslav -p u757840095_Intebwio < intebwio.sql
```

**Database Credentials (from your config):**
```
Host: 127.0.0.1:3306
Database: u757840095_Intebwio
User: u757840095_Yaroslav
Password: l1@ArIsM
```

### Step 2: Configure Application

Edit `/public_html/includes/config.php` and verify:
```php
define('DB_HOST', '127.0.0.1:3306');
define('DB_USER', 'u757840095_Yaroslav');
define('DB_PASS', 'l1@ArIsM');
define('DB_DATABASE', 'u757840095_Intebwio');
```

### Step 3: Run Setup

**Option A - Using Browser (Recommended):**
1. Go to `http://yourdomain.com/setup.php`
2. Click **Initialize Database & Setup**
3. Done! ✓

**Option B - Using Command Line:**
```bash
php /path/to/public_html/setup.php
```

### Step 4: Test the Application

1. **Homepage**: `http://yourdomain.com/index.html`
2. **Admin Dashboard**: `http://yourdomain.com/admin.php`
   - Password: `intebwio_admin_2026`
   - ⚠️ **Change this password immediately!**

3. **Try a search**: Type a topic in the search box
   - First search: Generates a new page (takes 10-30 seconds)
   - Same search again: Shows cached page instantly
   - Similar searches: Reuses existing pages

---

## 📁 Project File Structure

```
public_html/
├── index.html              # Homepage with search interface
├── page.php                # Displays generated pages
├── admin.php               # Admin dashboard
├── setup.php               # Database setup wizard
├── intebwio.sql            # Database schema (SQL import file)
│
├── includes/               # PHP backend classes
│   ├── config.php          # Database & app configuration
│   ├── Database.php        # Database operations & caching
│   ├── ContentAggregator.php # Pulls content from sources
│   └── PageGenerator.php    # Generates HTML pages
│
├── api/                    # REST API endpoints
│   ├── search.php          # Main search API
│   ├── autocomplete.php    # Search suggestions
│   ├── track.php           # Analytics tracking
│   ├── latest.php          # Get recent pages
│   ├── analytics.php       # Statistics API
│   └── history.php         # Search history
│
├── js/                     # JavaScript files
│   ├── intebwio.js         # Main frontend logic
│   └── advanced.js         # Advanced features
│
├── css/                    # Stylesheets
│   ├── intebwio-page.css   # Page-specific styles
│   └── main.css            # Main styles
│
├── cron/                   # Scheduled tasks
│   └── update.php          # Weekly page updater
│
└── logs/                   # Application logs
    └── intebwio.log        # Debug logs
```

---

## 🗄️ Database Tables

| Table | Purpose |
|-------|---------|
| `pages` | Cached landing pages |
| `search_results` | Aggregated content from sources |
| `page_elements` | Images, tables, diagrams |
| `update_queue` | Weekly update scheduling |
| `user_activity` | Analytics & search tracking |
| `similar_pages` | Duplicate page detection |
| `content_sources` | External API configuration |
| `system_logs` | Debugging logs |
| `cache_stats` | Performance metrics |
| `featured_pages` | Homepage featured content |

---

## 🔧 Configuration

### Database Connection (`includes/config.php`)
```php
define('DB_HOST', '127.0.0.1:3306');
define('DB_USER', 'u757840095_Yaroslav');
define('DB_PASS', 'l1@ArIsM');
define('DB_DATABASE', 'u757840095_Intebwio');
```

### Admin Password (`admin.php`)
**Default:** `intebwio_admin_2026`
**⚠️ Change this!**
```php
$adminPassword = 'YOUR_NEW_SECURE_PASSWORD';
```

### API Keys (`config.php`)
To enable advanced features:
```php
define('GOOGLE_API_KEY', 'YOUR_KEY_HERE');
define('SERPAPI_KEY', 'YOUR_KEY_HERE');
```

---

## 🚀 Features & How They Work

### 1. **Instant Page Generation**
```
User Search → Check Database → Page Exists?
  ├─ YES → Show Cached Page (Instant)
  └─ NO → Aggregate Content → Generate HTML → Cache → Show
```

### 2. **Smart Content Aggregation**
Pulls from multiple sources:
- ✅ Wikipedia
- ✅ Google Search Results
- ✅ GitHub Repositories
- ✅ News Articles
- ✅ Medium Posts

### 3. **Similarity Detection**
- Detects similar searches (e.g., "AI" vs "Artificial Intelligence")
- Reuses existing pages instead of creating duplicates
- **Threshold:** 75% similarity

### 4. **Automatic Weekly Updates**
- Pages update automatically every 7 days
- Content refreshed from all sources
- Manual update available in admin dashboard

### 5. **Rich Page Elements**
Generated pages include:
- 🖼️ Images with lazy loading
- 📊 Statistics tables
- 📈 Diagrams & visualizations
- 🔗 Source links & attribution
- 📱 Fully responsive design

### 6. **Search Analytics**
Track:
- Total pages created
- Total views
- Trending topics
- User search patterns
- Page load times

---

## 📊 Admin Dashboard

**Access:** `http://yourdomain.com/admin.php`

### Features:
- 📈 Real-time statistics
- 🔄 Manual update trigger
- 📋 Page management
- 🎯 Trending topics
- 🔧 System configuration
- 📝 Update logs

---

## 🔄 Setting Up Automatic Weekly Updates

### Option 1: cPanel Cron Jobs (Recommended for Hostinger)
1. Login to cPanel
2. Go to **Cron Jobs**
3. Add new cron job:
```bash
0 0 * * 0 /usr/bin/php /home/username/public_html/cron/update.php
```
4. This runs every Sunday at midnight

### Option 2: Manual Update
1. Go to Admin Dashboard
2. Click "Run Weekly Update Now"

### Option 3: Command Line
```bash
php /path/to/public_html/cron/update.php
```

---

## 🐛 Troubleshooting

### Issue 1: "Database Connection Failed"
**Solution:**
1. Verify credentials in `includes/config.php`
2. Check MySQL is running
3. Ensure database exists in phpMyAdmin
4. Test connection:
```bash
mysql -h 127.0.0.1 -u u757840095_Yaroslav -p
```

### Issue 2: "Setup page doesn't execute"
**Solution:**
1. Check file permissions:
```bash
chmod 755 /path/to/public_html/setup.php
chmod 755 /path/to/public_html/cron/update.php
```
2. Create logs directory:
```bash
mkdir -p /path/to/public_html/logs
chmod 755 /path/to/public_html/logs
```

### Issue 3: "Search returns no results"
**Solution:**
1. Check if database tables were created (run setup again)
2. Check logs: `/public_html/logs/intebwio.log`
3. Verify API connectivity (if using external APIs)

### Issue 4: "Pages not updating after 7 days"
**Solution:**
1. Check if cron job is scheduled
2. Check logs for errors
3. Manually trigger update in admin dashboard
4. Contact Hostinger support about cron job execution

### Issue 5: "Admin page shows blank or error"
**Solution:**
1. Clear browser cache
2. Check PHP error logs
3. Verify password hasn't changed
4. Try private/incognito mode

---

## 📈 Usage Statistics

The system tracks:
- Total pages generated
- Views per page
- Search queries
- Trending topics
- Update frequency
- Cache hit rates
- User geographic data

Access via: `/api/analytics.php`

---

## 🔐 Security Recommendations

1. **Change admin password** immediately after setup
2. **Update credentials** in `config.php` for production
3. **Use HTTPS** (SSL certificate from Hostinger)
4. **Restrict admin.php** access by IP:
```apache
<Files "admin.php">
    Order Allow,Deny
    Allow from YOUR_IP
</Files>
```
5. **Regular backups** of database

---

## 📞 Support & Troubleshooting URLs

- **Setup Wizard:** `/setup.php`
- **Admin Dashboard:** `/admin.php`
- **API Endpoints:**
  - Search: `/api/search.php` (POST)
  - Autocomplete: `/api/autocomplete.php` (GET)
  - Analytics: `/api/analytics.php` (GET)
  - Latest Pages: `/api/latest.php` (GET)

---

## 🎯 Next Steps

1. ✅ Import SQL file to database
2. ✅ Run setup.php
3. ✅ Change admin password
4. ✅ Test search functionality
5. ✅ Setup cron for weekly updates
6. ✅ Configure API keys (optional)
7. ✅ Monitor analytics dashboard

---

## 📝 Default Credentials

**Remember to change these!**
- Admin URL: `/admin.php`
- Password: `intebwio_admin_2026`

---

## 💡 Tips & Best Practices

1. **Search Optimization:**
   - More specific searches = better results
   - Multi-word searches work better than single words

2. **Performance:**
   - First search takes 10-30 seconds
   - Subsequent same searches are instant
   - Similar searches reuse cached pages

3. **Content Quality:**
   - Wikipedia content is prioritized for reliability
   - Multiple sources ensure comprehensive coverage
   - Automatic weekly updates keep information fresh

4. **Monitoring:**
   - Check admin dashboard regularly
   - Monitor trending topics
   - Review error logs weekly

---

## 📄 Code Statistics

- **Total Files:** 15+
- **PHP Lines:** 2000+
- **HTML Lines:** 1000+
- **CSS Lines:** 600+
- **JavaScript Lines:** 400+
- **SQL Schema:** 10 tables, 3 views
- **Database Storage:** Unlimited (SQLite/MySQL)

---

## 🌟 Features at a Glance

✅ Intelligent page generation & caching
✅ Multi-source content aggregation
✅ Automatic weekly updates
✅ Smart duplicate detection
✅ Rich UI with images & tables
✅ Full-text search capability
✅ User analytics & tracking
✅ Admin dashboard
✅ Responsive design
✅ SEO-friendly
✅ Offline support (with Service Worker)
✅ Performance optimization

---

## 📖 Additional Resources

- **Database Schema:** `intebwio.sql`
- **Configuration:** `includes/config.php`
- **Log File:** `logs/intebwio.log`
- **API Documentation:** See individual files in `/api/` folder

---

## 🚀 Deployment Checklist

- [ ] Database created & schema imported
- [ ] `config.php` credentials verified
- [ ] `setup.php` executed successfully
- [ ] Admin password changed
- [ ] First search test completed
- [ ] Cron job configured
- [ ] SSL/HTTPS enabled
- [ ] Backup strategy in place
- [ ] Logs monitored
- [ ] API keys configured (if needed)

---

**Intebwio v1.0.0** | Built with ❤️ for intelligent content aggregation

---

**Last Updated:** February 19, 2026
