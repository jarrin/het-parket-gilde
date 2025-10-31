# Code Documentatie - Het Parket Gilde

## Overzicht
Dit is een 4-pagina PHP website voor Het Parket Gilde met een admin panel voor contentbeheer. De website gebruikt JSON voor content opslag en een MySQL database voor authenticatie.

## Bestandsstructuur

```
het-parket-gilde/
├── admin/              # Admin panel bestanden
│   ├── index.php       # Hoofdpagina admin panel (content bewerken)
│   ├── login.php       # Login pagina
│   ├── logout.php      # Uitlog functionaliteit
│   └── setup_admin.php # Eerste admin account aanmaken
├── assets/             # Frontend bestanden
│   ├── css/
│   │   ├── style.css   # Frontend styling
│   │   ├── admin.css   # Admin panel styling
│   │   └── login.css   # Login pagina styling
│   ├── js/
│   │   └── main.js     # JavaScript voor frontend
│   └── images/         # Geüploade afbeeldingen
├── data/
│   └── content.json    # Alle website content
├── database/
│   └── setup.sql       # Database schema
├── includes/
│   ├── header.php      # Site header
│   └── footer.php      # Site footer
├── config.php          # Configuratie instellingen
├── functions.php       # Herbruikbare PHP functies
├── index.php           # Home pagina
├── diensten.php        # Diensten pagina
├── over-ons.php        # Over Ons pagina
├── contact.php         # Contact pagina
├── docker-compose.yml  # Docker configuratie
└── Dockerfile          # Docker image definitie
```

## Belangrijkste Functies (functions.php)

### Content Management

#### `loadContent()`
Laadt de website content uit het JSON bestand.

**Return:** `array` - Gedecodeerde JSON content

**Gebruik:**
```php
$content = loadContent();
echo $content['home']['hero']['title'];
```

#### `saveContent($data)`
Slaat content op naar het JSON bestand.

**Parameters:**
- `$data` (array) - Content om op te slaan

**Return:** `bool` - True als succesvol, false bij fout

**Gebruik:**
```php
$content['home']['hero']['title'] = 'Nieuwe titel';
saveContent($content);
```

### Database

#### `getDB()`
Maakt verbinding met de MySQL database.

**Return:** `PDO` - Database connectie object

**Exceptions:** Gooit exception bij connectie fout

**Gebruik:**
```php
$pdo = getDB();
$stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
```

### Authenticatie

#### `loginAdmin($username, $password)`
Authenticeert een admin gebruiker.

**Parameters:**
- `$username` (string) - Gebruikersnaam
- `password` (string) - Wachtwoord (plain text)

**Return:** `bool` - True als login succesvol

**Features:**
- Rate limiting (5 pogingen per 15 minuten)
- Bcrypt wachtwoord verificatie
- Session token generatie
- IP address tracking
- User agent logging

**Gebruik:**
```php
if (loginAdmin($_POST['username'], $_POST['password'])) {
    header('Location: /admin/');
}
```

#### `isAdmin()`
Controleert of gebruiker is ingelogd.

**Return:** `bool` - True als ingelogd

**Gebruik:**
```php
if (isAdmin()) {
    // Admin functionaliteit
}
```

#### `requireAdmin()`
Forceert admin login, redirect naar login anders.

**Return:** `void`

**Gebruik:**
```php
requireAdmin();
// Code hieronder alleen voor ingelogde admins
```

#### `logoutAdmin()`
Logt gebruiker uit en verwijdert sessie.

**Return:** `void`

**Gebruik:**
```php
logoutAdmin();
header('Location: /admin/login.php');
```

#### `cleanExpiredSessions()`
Verwijdert verlopen sessies uit de database (onderhoud).

**Return:** `void`

**Gebruik:**
```php
cleanExpiredSessions();
```

### Image Upload

#### `handleImageUpload($fileInputName)`
Verwerkt afbeelding uploads met validatie.

**Parameters:**
- `$fileInputName` (string) - Naam van het file input veld

**Return:** `array` - Resultaat met keys:
- `success` (bool) - Of upload gelukt is
- `path` (string) - Pad naar geüploade afbeelding (alleen bij success)
- `message` (string) - Status bericht

**Validatie:**
- Max bestandsgrootte: 5MB
- Toegestane types: JPEG, PNG, WebP
- MIME type verificatie
- Unieke bestandsnaam generatie

**Gebruik:**
```php
$result = handleImageUpload('hero_image_upload');
if ($result['success']) {
    $content['home']['hero']['image'] = $result['path'];
}
```

#### `deleteImage($imagePath)`
Verwijdert een afbeelding van de server.

**Parameters:**
- `$imagePath` (string) - Relatief pad naar afbeelding

**Return:** `bool` - True als verwijderd

**Gebruik:**
```php
deleteImage('assets/images/old-image.jpg');
```

#### `getUploadedImages()`
Haalt lijst van alle geüploade afbeeldingen op.

**Return:** `array` - Array van afbeeldingen met:
- `filename` (string) - Bestandsnaam
- `path` (string) - Relatief pad
- `size` (int) - Bestandsgrootte in bytes
- `modified` (int) - Unix timestamp laatste wijziging

**Gebruik:**
```php
$images = getUploadedImages();
foreach ($images as $image) {
    echo $image['path'];
}
```

### Utility Functions

#### `h($string)`
HTML-safe output (escape special characters).

**Parameters:**
- `$string` (string) - Te escapen tekst

**Return:** `string` - Geëscapete tekst

**Gebruik:**
```php
echo '<input value="' . h($userInput) . '">';
```

#### `getNavigation()`
Retourneert navigatie items.

**Return:** `array` - Array van navigatie items

**Gebruik:**
```php
foreach (getNavigation() as $item) {
    echo '<a href="' . $item['url'] . '">' . $item['label'] . '</a>';
}
```

## Database Schema

### Tabel: admin_users
Opslag van admin gebruikers.

| Kolom | Type | Beschrijving |
|-------|------|--------------|
| id | INT PRIMARY KEY | Unieke gebruiker ID |
| username | VARCHAR(50) UNIQUE | Gebruikersnaam |
| password_hash | VARCHAR(255) | Bcrypt gehashed wachtwoord |
| email | VARCHAR(100) | Email adres |
| created_at | TIMESTAMP | Account aanmaak datum |
| last_login | TIMESTAMP | Laatste login tijd |
| is_active | BOOLEAN | Of account actief is |

### Tabel: admin_sessions
Sessie tracking.

| Kolom | Type | Beschrijving |
|-------|------|--------------|
| id | INT PRIMARY KEY | Sessie ID |
| user_id | INT FOREIGN KEY | Referentie naar admin_users |
| session_token | VARCHAR(64) UNIQUE | Unieke sessie token |
| ip_address | VARCHAR(45) | IP adres van gebruiker |
| user_agent | TEXT | Browser info |
| created_at | TIMESTAMP | Sessie start |
| expires_at | TIMESTAMP | Sessie verloop tijd |

### Tabel: login_attempts
Login poging tracking (rate limiting).

| Kolom | Type | Beschrijving |
|-------|------|--------------|
| id | INT PRIMARY KEY | Poging ID |
| username | VARCHAR(50) | Geprobeerde gebruikersnaam |
| ip_address | VARCHAR(45) | IP adres |
| attempted_at | TIMESTAMP | Tijd van poging |
| success | BOOLEAN | Of login succesvol was |

## Configuratie (config.php)

### Paden
```php
ROOT_PATH           # Root directory van de applicatie
CONTENT_FILE        # Pad naar content.json
UPLOAD_DIR          # Directory voor uploads (assets/images/)
```

### Database
```php
DB_HOST             # MySQL host (default: mysql)
DB_NAME             # Database naam (default: hetparketgilde)
DB_USER             # Database gebruiker (default: root)
DB_PASS             # Database wachtwoord (default: root_password)
```

### Security
```php
SESSION_LIFETIME    # 7200 seconden (2 uur)
MAX_LOGIN_ATTEMPTS  # 5 pogingen
LOGIN_TIMEOUT       # 900 seconden (15 minuten)
```

### Upload Settings
```php
MAX_FILE_SIZE       # 5242880 bytes (5MB)
ALLOWED_IMAGE_TYPES # ['image/jpeg', 'image/png', 'image/jpg', 'image/webp']
```

## Admin Panel Gebruik

### Eerste Admin Aanmaken
1. Ga naar `/admin/setup_admin.php`
2. Vul gebruikersnaam, email en wachtwoord in
3. Klik "Admin Aanmaken"
4. Verwijder `setup_admin.php` na gebruik (veiligheid)

### Inloggen
1. Ga naar `/admin/login.php`
2. Vul credentials in
3. Na succesvolle login wordt u doorgestuurd naar admin panel

### Content Bewerken
1. Selecteer pagina in zijbalk (Site, Kleuren & Styling, Home, Diensten, Over Ons, Contact)
2. Bewerk de formulier velden
3. Upload nieuwe afbeeldingen indien gewenst
4. Klik "Wijzigingen Opslaan"
5. Wijzigingen zijn direct zichtbaar op de website

### Kleuren Aanpassen
1. Ga naar "Kleuren & Styling" in het admin panel
2. Gebruik de kleurkiezers om kleuren te selecteren
3. Bekijk een live preview van de geselecteerde kleuren
4. Klik "Kleuren Opslaan" om wijzigingen toe te passen
5. Alle pagina's gebruiken automatisch de nieuwe kleuren

**Beschikbare kleuren:**
- **Primaire Kleur**: Knoppen, links en belangrijke accenten
- **Secundaire Kleur**: Hover effecten en secundaire elementen
- **Accent Kleur**: Speciale highlights en call-to-actions
- **Tekst Kleur**: Hoofdtekst door de hele website
- **Lichte Tekst**: Subtekst en minder belangrijke informatie
- **Lichte Achtergrond**: Achtergrond voor specifieke secties
- **Witte Achtergrond**: Hoofd achtergrondkleur
- **Rand Kleur**: Randen rondom elementen en kaarten

### Afbeeldingen Uploaden
- Klik op "Choose File" bij een afbeelding veld
- Selecteer JPG, PNG of WebP bestand (max 5MB)
- Bij opslaan wordt de afbeelding automatisch geüpload
- Het pad wordt automatisch bijgewerkt in de content

## Security Features

### Wachtwoord Beveiliging
- Bcrypt hashing met cost factor 10
- Minimum 8 karakters vereist
- Nooit plain text opgeslagen

### Session Management
- Unieke 64-karakter tokens
- 2 uur automatische verloop tijd
- IP en User Agent tracking
- Secure session cleanup

### Rate Limiting
- Maximum 5 login pogingen per 15 minuten
- Per IP adres en gebruikersnaam
- Automatische cleanup van oude pogingen

### File Upload Security
- MIME type verificatie
- Bestandsgrootte limiet
- Toegestane extensie controle
- Unieke bestandsnamen (voorkomt overschrijven)

## Docker Configuratie

### Services
- **web**: PHP 8.2-apache met PDO MySQL
- **mysql**: MySQL 8.0 database

### Poorten
- Web: http://localhost:8080
- MySQL: localhost:3306

### Volumes
- `mysql_data`: Persistente database opslag
- `.:/var/www/html`: Live code mounting

### Starten
```bash
docker-compose up -d
```

### Stoppen
```bash
docker-compose down
```

### Logs bekijken
```bash
docker-compose logs -f
```

## Kleurenschema

Het admin panel gebruikt een blauw/grijs thema:

- **Primair Blauw**: #3498db
- **Donker Blauw**: #2980b9
- **Donker Grijs**: #2c3e50
- **Midden Grijs**: #34495e
- **Licht Grijs**: #7f8c8d

## Troubleshooting

### Database Connectie Fout
- Controleer of MySQL container draait: `docker-compose ps`
- Verifieer database credentials in `config.php`
- Check database logs: `docker-compose logs mysql`

### Upload Fout
- Controleer schrijfrechten op `assets/images/` directory
- Verifieer bestandsgrootte onder 5MB
- Check MIME type is toegestaan (JPEG, PNG, WebP)

### Login Lukt Niet
- Wacht 15 minuten na 5 mislukte pogingen (rate limit)
- Controleer of gebruiker actief is in database
- Check browser cookies zijn ingeschakeld

### Wijzigingen Niet Zichtbaar
- Verifieer `data/content.json` heeft schrijfrechten
- Check browser cache (hard refresh met Ctrl+F5)
- Bekijk browser console voor JavaScript errors

## Best Practices

### Content Beheer
- Maak regelmatig backups van `data/content.json`
- Test wijzigingen op de live site na opslaan
- Gebruik duidelijke, beschrijvende bestandsnamen voor afbeeldingen

### Beveiliging
- Verwijder `admin/setup_admin.php` na eerste gebruik
- Gebruik sterke wachtwoorden (min. 12 karakters)
- Wijzig database credentials in productie
- Enable HTTPS in productie omgeving

### Performance
- Optimaliseer afbeeldingen voor web (TinyPNG, Squoosh)
- Gebruik WebP formaat voor kleinere bestandsgroottes
- Verwijder oude ongebruikte afbeeldingen regelmatig

### Onderhoud
- Run `cleanExpiredSessions()` periodiek (bijv. via cron)
- Monitor disk space voor afbeelding uploads
- Backup database regelmatig

## Support & Documentatie

Voor vragen of problemen:
1. Raadpleeg eerst deze documentatie
2. Check README.md voor setup instructies
3. Bekijk UPGRADE_NOTES.md voor security features
4. Check docker-compose logs voor errors

---

**Laatste update:** 2024
**Versie:** 2.0 (met database authenticatie en image uploads)
