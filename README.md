# Het Parket Gilde – PHP JSON Website

🎯 **Complete 4-page PHP website with JSON-based content management and admin panel**

---

## 🌐 About This Project

Het Parket Gilde is a professional website for a flooring specialist company. The entire site content is stored in a JSON file (`/data/content.json`) and can be easily edited through a password-protected admin panel.

**Key Features:**
- ✅ 4 fully functional pages (Home, Onze Diensten, Over Ons, Contact)
- ✅ All content loaded dynamically from JSON
- ✅ Simple admin panel for content editing
- ✅ Session-based authentication (no database required)
- ✅ Responsive design
- ✅ Clean, modern UI

---

## 📁 Project Structure

```
het-parket-gilde/
├── admin/
│   ├── index.php          # Admin panel for editing content
│   ├── login.php          # Admin login page
│   └── logout.php         # Logout functionality
├── assets/
│   ├── css/
│   │   └── style.css      # Main stylesheet
│   ├── js/
│   │   └── main.js        # JavaScript for interactivity
│   └── images/            # Image folder (add your images here)
├── data/
│   └── content.json       # All website content (editable via admin)
├── includes/
│   ├── header.php         # Site header with navigation
│   └── footer.php         # Site footer
├── config.php             # Configuration & admin credentials
├── functions.php          # Helper functions
├── index.php              # Home page
├── diensten.php           # Services page
├── over-ons.php           # About page
├── contact.php            # Contact page
├── docker-compose.yml     # Docker Compose configuration
├── Dockerfile             # Docker container setup
└── README.md              # This file
```

---

## 🚀 Installation & Setup

### Option 1: Docker (Recommended) 🐳

The easiest way to run the website is using Docker:

**Prerequisites:**
- Docker Desktop installed ([Download here](https://www.docker.com/products/docker-desktop))

**Steps:**

1. **Navigate to project directory:**
   ```bash
   cd het-parket-gilde
   ```

2. **Start the containers:**
   ```bash
   docker-compose up -d
   ```
   This will start both the web server and MySQL database.

3. **Wait for database initialization:**
   First time startup takes ~30 seconds for MySQL to initialize and create tables.
   
   Check status:
   ```bash
   docker-compose logs -f
   ```

4. **Create your admin account:**
   - Visit: `http://localhost:8080/admin/setup_admin.php`
   - Create your username and password
   - **Important**: Delete `admin/setup_admin.php` after creating your account

5. **Access the website:**
   - Website: `http://localhost:8080/`
   - Admin Panel: `http://localhost:8080/admin/`
   - Login with the account you just created

6. **Stop the containers:**
   ```bash
   docker-compose down
   ```

**Docker Commands:**
```bash
# View logs
docker-compose logs -f

# Rebuild after changes
docker-compose up -d --build

# Stop and remove containers
docker-compose down

# Access container shell
docker exec -it het-parket-gilde bash
```

---

### Option 2: Traditional Setup (XAMPP/WAMP/MAMP)

### Requirements
- PHP 8.0 or higher with PDO MySQL extension
- MySQL 5.7+ or MariaDB
- Local server (XAMPP, WAMP, MAMP, or similar)
- Web browser

### Step 1: Clone or Download
Place the `het-parket-gilde` folder in your web server directory:
- **XAMPP**: `C:\xampp\htdocs\`
- **WAMP**: `C:\wamp64\www\`
- **MAMP**: `/Applications/MAMP/htdocs/`

### Step 2: Setup Database
1. Start Apache and MySQL
2. Open phpMyAdmin: `http://localhost/phpmyadmin/`
3. Import the database setup:
   - Create database: `het_parket_gilde`
   - Import: `/database/setup.sql`

### Step 3: Configure Database Connection
Edit `config.php` and update these values if needed:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'het_parket_gilde');
define('DB_USER', 'root');
define('DB_PASS', ''); // Your MySQL password
```

### Step 4: Create Admin Account
1. Visit: `http://localhost/het-parket-gilde/admin/setup_admin.php`
2. Create your admin username and password
3. **Delete** `admin/setup_admin.php` after account creation

### Step 5: Access the Website
- Website: `http://localhost/het-parket-gilde/`
- Admin Panel: `http://localhost/het-parket-gilde/admin/`
- Login with your created account

---

## 🔐 Admin Panel Features

The admin panel allows you to edit all website content without touching code:

1. **Login**: Use admin credentials to access `/admin/`
2. **Edit Content**: Modify the JSON directly in the textarea
3. **Validate**: Click "Valideer JSON" to check syntax before saving
4. **Format**: Click "Formatteer JSON" to auto-format the JSON
5. **Save**: Click "Opslaan" to save changes
6. **Quick Navigation**: Use tabs to jump to specific sections

### Changing Admin Credentials

Edit `config.php` and modify these lines:
```php
define('ADMIN_USERNAME', 'admin');        // Change username
define('ADMIN_PASSWORD', 'parket2024');   // Change password
```

---

## 📝 Editing Content

### Via Admin Panel (Recommended)
1. Log in to `/admin/`
2. Edit the JSON content
3. Click "Valideer JSON" to check for errors
4. Click "Opslaan" to save

### Via File Editor
You can also directly edit `/data/content.json` with any text editor. The file is well-structured and uses proper JSON formatting.

**Content Structure:**
```json
{
  "site": { ... },        // Global site info
  "home": { ... },        // Home page content
  "diensten": { ... },    // Services page content
  "over_ons": { ... },    // About page content
  "contact": { ... }      // Contact page content
}
```

---

## 🎨 Adding Images

Place your images in `/assets/images/` and reference them in the JSON:

**Required images:**
- `hero-home.jpg` - Home page hero
- `intro.jpg` - Introduction section
- `hero-diensten.jpg` - Services page hero
- `service-leggen.jpg` - Flooring service
- `service-herstel.jpg` - Repair service
- `service-raam.jpg` - Window decoration service
- `hero-over-ons.jpg` - About page hero
- `mathijs.jpg` - Founder photo
- `hero-contact.jpg` - Contact page hero

**Recommended sizes:**
- Hero images: 1920x500px
- Service images: 800x600px
- Profile images: 400x400px

---

## 🛠️ Customization

### Changing Colors
Edit `/assets/css/style.css` and modify the CSS variables:
```css
:root {
    --primary-color: #8B4513;    /* Main brown color */
    --secondary-color: #D2691E;  /* Secondary brown */
    --accent-color: #CD853F;     /* Accent color */
}
```

### Adding New Pages
1. Create a new PHP file (e.g., `gallery.php`)
2. Add content to `/data/content.json` under a new key
3. Use the existing pages as templates
4. Add navigation link in `functions.php` → `getNavigation()`

### Modifying Layout
- Edit `/includes/header.php` for header changes
- Edit `/includes/footer.php` for footer changes
- Edit `/assets/css/style.css` for styling

---

## 🌟 Features Overview

### Frontend Features
- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Smooth scroll animations
- ✅ Mobile-friendly navigation menu
- ✅ SEO-friendly structure
- ✅ Fast loading times

### Admin Features
- ✅ Session-based authentication
- ✅ JSON validation before saving
- ✅ Auto-formatting tool
- ✅ Warning for unsaved changes
- ✅ Quick section navigation
- ✅ Logout functionality

### Technical Features
- ✅ No database required
- ✅ Clean PHP code
- ✅ Modular structure
- ✅ Easy to maintain
- ✅ Well-documented
- ✅ Docker support for easy deployment
- ✅ Containerized environment

---

## 🔒 Security Best Practices

1. **Change Default Password**: Modify `config.php` immediately
2. **Use Strong Password**: Use a complex password for production
3. **HTTPS**: Use SSL certificate in production
4. **File Permissions**: Set proper permissions on `/data/content.json` (644)
5. **Error Reporting**: Disable in production (set in `config.php`)

---

## 🐛 Troubleshooting

### Issue: Pages show "404 Not Found"
**Solution**: Make sure you're accessing via `http://localhost/het-parket-gilde/` with the correct folder name.

### Issue: Admin panel doesn't save
**Solution**: Check file permissions on `/data/content.json`. It should be writable (644 on Linux/Mac).

### Issue: JSON errors after editing
**Solution**: Use the "Valideer JSON" button in admin panel to find syntax errors. Common issues:
- Missing commas between items
- Unescaped quotes in text
- Missing closing brackets

### Issue: Images not showing
**Solution**: Make sure images are in `/assets/images/` and paths in JSON match exactly (case-sensitive).

---

## 📚 Technology Stack

- **PHP 8.2+** - Server-side scripting
- **JSON** - Data storage
- **HTML5** - Markup
- **CSS3** - Styling (with CSS Grid & Flexbox)
- **JavaScript (ES6)** - Interactivity
- **Session Management** - Authentication
- **Docker** - Containerization
- **Apache** - Web server

---

## 📄 License

This project is created for Het Parket Gilde. Modify as needed for your purposes.

---

## 👨‍💻 Support

For questions or issues:
1. Check the troubleshooting section above
2. Review the code comments in PHP files
3. Validate your JSON using online tools like jsonlint.com

---

## 🎉 Quick Start Checklist

### Docker (Recommended):
- [ ] Install Docker Desktop
- [ ] Run `docker-compose up -d`
- [ ] Access site at `http://localhost:8080/`
- [ ] Login to admin at `/admin/` (admin / parket2024)
- [ ] Change password in `config.php`
- [ ] Add your images to `/assets/images/`
- [ ] Edit content via admin panel
- [ ] Customize colors in `style.css`
- [ ] Test all pages

### Traditional Setup:
- [ ] Install PHP server (XAMPP/WAMP/MAMP)
- [ ] Place project in web server folder
- [ ] Start Apache
- [ ] Access site at `http://localhost/het-parket-gilde/`
- [ ] Login to admin at `/admin/` (admin / parket2024)
- [ ] Change password in `config.php`
- [ ] Add your images to `/assets/images/`
- [ ] Edit content via admin panel
- [ ] Customize colors in `style.css`
- [ ] Test all pages
- [ ] Deploy to production server

---

**Enjoy your new website! 🎊**