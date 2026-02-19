# Intebwio - Common Issues & Solutions

## ❌ Issue 1: "Call to undefined function" errors

**Problem:** PHP throws "Call to undefined function" errors

**Solution:**
1. Clear PHP opcache:
```bash
php -r "opcache_reset();"
```
2. Or restart PHP-FPM:
```bash
systemctl restart php-fpm
# or
service php-fpm restart
```

---

## ❌ Issue 2: "Database table doesn't exist"

**Problem:** Pages table or other tables not found

**Solution:**
1. Verify tables exist:
```bash
mysql -h 127.0.0.1 -u u757840095_Yaroslav -p u757840095_Intebwio -e "SHOW TABLES;"
```

2. If missing, import SQL:
```bash
mysql -h 127.0.0.1 -u u757840095_Yaroslav -p u757840095_Intebwio < intebwio.sql
```

3. Or run setup.php:
```
Visit http://yourdomain.com/setup.php
```

---

## ❌ Issue 3: "CORS Error" when searching

**Problem:** JavaScript fetch request blocked

**Solution:**
1. Verify CORS headers in `config.php` (should be there)
2. If still failing, ensure `api/search.php` has:
```php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
```

---

## ❌ Issue 4: "Page not found" (404 on generated pages)

**Problem:** Display page returns 404

**Solution:**
1. Verify database has pages:
```bash
mysql -h 127.0.0.1 -u u757840095_Yaroslav -p u757840095_Intebwio -e "SELECT * FROM pages LIMIT 1;"
```

2. Check page.php exists and has permission:
```bash
ls -la public_html/page.php
chmod 644 public_html/page.php
```

3. Verify PDO is installed:
```bash
php -m | grep pdo
```

---

## ❌ Issue 5: "Blank page" when searching

**Problem:** Search completes but shows blank/white page

**Solution:**
1. Check browser console for JavaScript errors (F12)
2. Check PHP error log:
```bash
tail -f /var/log/php-errors.log
```

3. Enable debug mode in `config.php`:
```php
define('DEBUG_MODE', true);
```

4. Check logs:
```bash
tail -f public_html/logs/intebwio.log
```

---

## ❌ Issue 6: "Cron job not executing"

**Problem:** Weekly updates not running

**Solution:**

1. **Verify cron is installed:**
```bash
service cron status
# or
systemctl status cron
```

2. **Check crontab syntax:**
```bash
crontab -l
```
Should look like:
```
0 0 * * 0 /usr/bin/php /home/user/public_html/cron/update.php
```

3. **Test manually:**
```bash
php /path/to/public_html/cron/update.php
```

4. **Check cron logs:**
```bash
grep CRON /var/log/syslog
```

5. **For Hostinger, use cPanel:**
   - Go to cPanel → Cron Jobs
   - Add: `php /home/username/public_html/cron/update.php`
   - Set time: 00:00 (midnight) Sunday

---

## ❌ Issue 7: "Search takes too long"

**Problem:** First search takes more than 1 minute

**Solution:**
1. Check if APIs are responding:
```bash
curl -s "https://en.wikipedia.org/w/api.php?action=query&list=search&srsearch=test&format=json" | head -20
```

2. Disable slow APIs temporarily in `cron/update.php`:
   - Comment out Google Search
   - Keep Wikipedia & GitHub

3. Check server resources:
```bash
free -h  # Check RAM
df -h   # Check disk space
top     # Check CPU
```

---

## ❌ Issue 8: "Admin login doesn't work"

**Problem:** Admin password rejected

**Solution:**
1. Verify default password: `intebwio_admin_2026`
2. Check if changed in admin.php:
```bash
grep 'adminPassword' public_html/admin.php
```

3. Reset to default:
```bash
# Find this line in admin.php:
$adminPassword = 'intebwio_admin_2026';
```

4. Clear browser cookies:
   - Press Ctrl+Shift+Delete
   - Clear all cookies for your domain

---

## ❌ Issue 9: "CSS/JS files not loading"

**Problem:** Page loads but looks unstyled

**Solution:**
1. Check file exists:
```bash
ls -la public_html/css/intebwio-page.css
ls -la public_html/js/intebwio.js
```

2. Check permissions:
```bash
chmod 644 public_html/css/*.css
chmod 644 public_html/js/*.js
```

3. Clear browser cache:
   - Ctrl+F5 (hard refresh)
   - Or Ctrl+Shift+Delete

4. Check for file path issues in browser console (F12)

---

## ❌ Issue 10: "Memory limit exceeded"

**Problem:** PHP throws "Allowed memory size" error

**Solution:**
1. Increase PHP memory limit in `php.ini`:
```ini
memory_limit = 256M
```

2. Or add to `.htaccess`:
```
php_value memory_limit 256M
```

3. Restart PHP:
```bash
systemctl restart php-fpm
```

---

## ❌ Issue 11: "File upload failed"

**Problem:** Can't upload files to public_html

**Solution:**
1. Check directory permissions:
```bash
chmod 755 public_html
chmod 644 public_html/*.php
chmod 644 public_html/*.html
```

2. Check ownership:
```bash
ls -la public_html | head
# Should show your username
```

3. Check disk quota:
```bash
quota username
```

---

## ❌ Issue 12: "Database connection timeout"

**Problem:** "Connection refused" or timeout error

**Solution:**
1. Verify MySQL is running:
```bash
systemctl status mysql
# or
service mysql status
```

2. Test connection:
```bash
mysql -h 127.0.0.1 -u u757840095_Yaroslav -p
# Enter password when prompted
```

3. Check firewall:
```bash
sudo ufw status
sudo ufw allow 3306
```

4. Verify config.php has correct host:
```php
define('DB_HOST', '127.0.0.1:3306');  // Correct
// NOT: 'localhost' (sometimes causes issues)
```

---

## ✅ Quick Verification Checklist

1. **Database Connection:**
```bash
mysql -h 127.0.0.1 -u u757840095_Yaroslav -p u757840095_Intebwio -e "SELECT COUNT(*) FROM pages;"
```
Should return: `0` or a number (not error)

2. **File Permissions:**
```bash
ls -la public_html/*.php | head
# Should show: -rw-r--r-- or similar
```

3. **PHP Version:**
```bash
php -v
# Should be 7.4+
```

4. **Extensions:**
```bash
php -m | grep -E "curl|pdo|mysql"
# Should show: curl, pdo, pdo_mysql
```

5. **Error Log:**
```bash
tail -20 public_html/logs/intebwio.log
tail -50 /var/log/php-errors.log
```

---

## 🔧 Command Reference

### Restart Services
```bash
# MySQL
systemctl restart mysql
service mysql restart

# PHP
systemctl restart php-fpm
service php-fpm restart
systemctl restart apache2
systemctl restart nginx

# Cron
systemctl restart cron
service cron restart
```

### Database Operations
```bash
# Login
mysql -h 127.0.0.1 -u u757840095_Yaroslav -p

# List databases
SHOW DATABASES;

# List tables
USE u757840095_Intebwio;
SHOW TABLES;

# Check row count
SELECT COUNT(*) FROM pages;

# Backup
mysqldump -h 127.0.0.1 -u u757840095_Yaroslav -p u757840095_Intebwio > backup.sql

# Restore
mysql -h 127.0.0.1 -u u757840095_Yaroslav -p u757840095_Intebwio < backup.sql
```

### File Operations
```bash
# Fix permissions
chmod 755 public_html
chmod 644 public_html/*.php
chmod 644 public_html/*.html
chmod 755 public_html/api
chmod 755 public_html/cron
chmod 755 public_html/logs

# Create logs directory if missing
mkdir -p public_html/logs
chmod 755 public_html/logs
touch public_html/logs/intebwio.log
chmod 644 public_html/logs/intebwio.log
```

---

## 📞 Getting More Help

**Check these log files:**
1. `/public_html/logs/intebwio.log` - Application logs
2. `/var/log/php-errors.log` - PHP errors
3. `/var/log/mysql/error.log` - MySQL errors

**Enable debug mode temporarily:**
```php
// In config.php, change:
define('DEBUG_MODE', true);
```

**Get PHP info:**
```php
// Create file: test.php
<?php phpinfo(); ?>

// Access: http://yourdomain.com/test.php
// DELETE after testing!
```

---

**Last Updated:** February 19, 2026
