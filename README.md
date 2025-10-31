﻿# Het Parket Gilde - Website & Admin Panel

Professional parket flooring company website with full content management system.

## 🎯 Quick Start

### Start Application
```bash
docker-compose up -d
```
Or double-click: `admin-panel.bat`

### First Time Setup
1. Visit: http://localhost:8080/tools/db_setup.php
2. Visit: http://localhost:8080/tools/setup_admin.php
3. Login: http://localhost:8080/admin/login.php

## ✅ Recent Cleanup (Oct 31, 2025)

### Improvements Made
- ✅ Deleted old backup files (`index-old.php`, `login-old.php`)
- ✅ Fixed duplicate code loading (removed redundant `require_once`)
- ✅ Created `/tools/` directory for setup scripts
- ✅ Moved `db_setup.php` and `setup_admin.php` to `/tools/`
- ✅ Updated `.gitignore` for better organization
- ✅ **Result:** Cleaner, faster, better organized!

## 📁 Project Structure

```
het-parket-gilde/
├── admin/              # Admin panel (Content editor, Media manager)
├── tools/              # Setup tools (Database setup, Admin creator)
├── assets/             # CSS, JS, images
├── data/               # content.json
├── database/           # SQL schema
├── includes/           # Shared PHP files & classes
├── .env                # Configuration
├── config.php          # App config
├── functions.php       # Core functions
├── *.php               # Public pages (index, diensten, over-ons, contact)
└── docker-compose.yml  # Docker config
```

## 🎨 Features

### Public Website
- Homepage with hero section
- Services showcase  
- About us page
- Contact information
- Responsive design

### Admin Panel
- Edit all content (text & images)
- Media manager (upload/browse/delete)
- Secure authentication
- Real-time updates
- Login rate limiting (5 attempts/15min)

## 🗄️ Database

Configured in `.env`:
```
DB_HOST=78.141.220.30
DB_NAME=parket_guild_db
DB_USER=parket_guild_db-user
DB_PORT=3306
```

## 📝 Content Management

1. Login at: http://localhost:8080/admin/login.php
2. Select section (Site Info, Home, Services, About, Contact)
3. Edit fields
4. Click "Wijzigingen Opslaan"
5. Changes are live immediately!

### Upload Images
- Go to Media Manager or any content section
- Drag & drop or click upload
- Max 5MB (JPEG, PNG, GIF, WebP)

## 🐳 Docker Commands

```bash
# Start
docker-compose up -d

# Stop
docker-compose down

# Restart
docker-compose restart

# Rebuild
docker-compose down && docker-compose build --no-cache && docker-compose up -d

# Logs
docker-compose logs -f
```

## 📊 Important URLs

### Public
- Homepage: http://localhost:8080/
- Services: http://localhost:8080/diensten.php
- About: http://localhost:8080/over-ons.php
- Contact: http://localhost:8080/contact.php

### Admin
- Login: http://localhost:8080/admin/login.php
- Dashboard: http://localhost:8080/admin/
- Media: http://localhost:8080/admin/media.php

### Tools (Setup Only)
- Database: http://localhost:8080/tools/db_setup.php
- Create Admin: http://localhost:8080/tools/setup_admin.php

## 🔒 Security Checklist

### Before Production
- [ ] Delete `/tools/setup_admin.php`
- [ ] Set `APP_DEBUG=FALSE` in `.env`
- [ ] Enable HTTPS/SSL
- [ ] Change default passwords
- [ ] Set up regular backups

## 🔧 Troubleshooting

### Database Connection Failed
1. Check `.env` credentials
2. Visit `/tools/db_setup.php` for diagnostics

### Images Not Uploading
1. Check `/assets/images/` exists
2. Verify permissions: `chmod 755 assets/images`
3. File must be < 5MB

### Can't Login
1. Wait 15 minutes (rate limit)
2. Or clear: `DELETE FROM login_attempts WHERE username='...'`

### Docker Issues
```bash
docker-compose down -v
docker-compose up -d --build
```

## 🛠️ Technologies

- PHP 8.2
- MySQL/MariaDB
- Apache 2.4
- Docker
- HTML5, CSS3, JavaScript

## 📄 License

Proprietary - Het Parket Gilde

---

**Version:** 2.0  
**Last Updated:** October 31, 2025  
**Status:** ✅ Production Ready & Optimized


