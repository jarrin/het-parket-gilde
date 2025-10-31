<?php
require_once '../functions.php';
requireAdmin();

$content = loadContent();
$saved = false;
$error = null;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Update content based on submitted form data
        if (isset($_POST['section'])) {
            $section = $_POST['section'];
            
            switch ($section) {
                case 'site':
                    $content['site']['title'] = $_POST['site_title'] ?? '';
                    $content['site']['description'] = $_POST['site_description'] ?? '';
                    $content['site']['contact']['phone'] = $_POST['contact_phone'] ?? '';
                    $content['site']['contact']['email'] = $_POST['contact_email'] ?? '';
                    $content['site']['contact']['address'] = $_POST['contact_address'] ?? '';
                    $content['site']['contact']['city'] = $_POST['contact_city'] ?? '';
                    $content['site']['contact']['zipcode'] = $_POST['contact_zipcode'] ?? '';
                    break;
                    
                case 'home':
                    $content['home']['hero']['title'] = $_POST['hero_title'] ?? '';
                    $content['home']['hero']['subtitle'] = $_POST['hero_subtitle'] ?? '';
                    $content['home']['hero']['description'] = $_POST['hero_description'] ?? '';
                    $content['home']['hero']['image'] = $_POST['hero_image'] ?? '';
                    
                    $content['home']['intro']['title'] = $_POST['intro_title'] ?? '';
                    $content['home']['intro']['text'] = $_POST['intro_text'] ?? '';
                    $content['home']['intro']['image'] = $_POST['intro_image'] ?? '';
                    
                    $content['home']['vakmanschap']['title'] = $_POST['vak_title'] ?? '';
                    $content['home']['vakmanschap']['subtitle'] = $_POST['vak_subtitle'] ?? '';
                    $content['home']['vakmanschap']['text'] = $_POST['vak_text'] ?? '';
                    break;
                    
                case 'diensten':
                    $content['diensten']['hero']['title'] = $_POST['hero_title'] ?? '';
                    $content['diensten']['hero']['subtitle'] = $_POST['hero_subtitle'] ?? '';
                    $content['diensten']['hero']['image'] = $_POST['hero_image'] ?? '';
                    
                    // Update services
                    for ($i = 0; $i < 3; $i++) {
                        if (isset($_POST['service_title_' . $i])) {
                            $content['diensten']['services'][$i]['title'] = $_POST['service_title_' . $i];
                            $content['diensten']['services'][$i]['description'] = $_POST['service_desc_' . $i] ?? '';
                            $content['diensten']['services'][$i]['image'] = $_POST['service_image_' . $i] ?? '';
                        }
                    }
                    break;
                    
                case 'over_ons':
                    $content['over_ons']['hero']['title'] = $_POST['hero_title'] ?? '';
                    $content['over_ons']['hero']['subtitle'] = $_POST['hero_subtitle'] ?? '';
                    $content['over_ons']['hero']['image'] = $_POST['hero_image'] ?? '';
                    
                    $content['over_ons']['story']['title'] = $_POST['story_title'] ?? '';
                    $content['over_ons']['story']['paragraphs'][0] = $_POST['story_p1'] ?? '';
                    $content['over_ons']['story']['paragraphs'][1] = $_POST['story_p2'] ?? '';
                    $content['over_ons']['story']['paragraphs'][2] = $_POST['story_p3'] ?? '';
                    
                    $content['over_ons']['founder']['name'] = $_POST['founder_name'] ?? '';
                    $content['over_ons']['founder']['title'] = $_POST['founder_title'] ?? '';
                    $content['over_ons']['founder']['quote'] = $_POST['founder_quote'] ?? '';
                    $content['over_ons']['founder']['image'] = $_POST['founder_image'] ?? '';
                    break;
                    
                case 'contact':
                    $content['contact']['hero']['title'] = $_POST['hero_title'] ?? '';
                    $content['contact']['hero']['subtitle'] = $_POST['hero_subtitle'] ?? '';
                    $content['contact']['hero']['image'] = $_POST['hero_image'] ?? '';
                    
                    $content['contact']['intro']['title'] = $_POST['intro_title'] ?? '';
                    $content['contact']['intro']['text'] = $_POST['intro_text'] ?? '';
                    
                    $content['contact']['info']['phone']['value'] = $_POST['phone_value'] ?? '';
                    $content['contact']['info']['email']['value'] = $_POST['email_value'] ?? '';
                    $content['contact']['info']['address']['street'] = $_POST['address_street'] ?? '';
                    $content['contact']['info']['address']['city'] = $_POST['address_city'] ?? '';
                    break;
            }
            
            if (saveContent($content)) {
                $saved = true;
                // Reload content to show updated values
                $content = loadContent();
            } else {
                $error = 'Kon de wijzigingen niet opslaan';
            }
        }
    } catch (Exception $e) {
        $error = 'Fout: ' . $e->getMessage();
    }
}

$currentSection = $_GET['section'] ?? 'site';
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Het Parket Gilde</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Admin Panel - Het Parket Gilde</h1>
            <nav class="admin-nav">
                <a href="/">Website Bekijken</a>
                <a href="/admin/logout.php">Uitloggen</a>
            </nav>
        </div>
    </header>
        body {
            background: #f5f5f5;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        .admin-header {
            background: #333;
            color: white;
            padding: 20px 0;
            margin-bottom: 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .admin-header .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .admin-header h1 {
            margin: 0;
            font-size: 22px;
        }
        .admin-nav a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            padding: 8px 16px;
            background: rgba(255,255,255,0.1);
            border-radius: 4px;
            transition: background 0.3s;
            font-size: 14px;
        }
        .admin-nav a:hover {
            background: rgba(255,255,255,0.2);
        }
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .admin-panel {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            min-height: calc(100vh - 80px);
        }
        .sidebar {
            background: #2c3e50;
            color: white;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-menu a {
            display: block;
            padding: 18px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 15px;
        }
        .sidebar-menu a:hover {
            background: rgba(255,255,255,0.1);
            padding-left: 25px;
        }
        .sidebar-menu a.active {
            background: #667eea;
            color: white;
            font-weight: 600;
            border-left: 4px solid #fff;
        }
        .content-area {
            padding: 30px 40px;
        }
        .message {
            padding: 15px 20px;
            border-radius: 6px;
            margin-bottom: 25px;
            font-size: 15px;
        }
        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-left: 4px solid #28a745;
        }
        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-left: 4px solid #dc3545;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .form-section h2 {
            margin-bottom: 10px;
            padding-bottom: 15px;
            border-bottom: 3px solid #667eea;
            color: #2c3e50;
            font-size: 26px;
        }
        .form-section h3 {
            margin-top: 35px;
            margin-bottom: 20px;
            color: #34495e;
            font-size: 18px;
            padding-left: 10px;
            border-left: 3px solid #667eea;
        }
        .form-group {
            margin-bottom: 25px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 14px;
        }
        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 15px;
            font-family: inherit;
            transition: border-color 0.3s;
        }
        .form-group textarea {
            min-height: 120px;
            resize: vertical;
            line-height: 1.6;
        }
        .form-group input:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .form-group small {
            display: block;
            margin-top: 6px;
            color: #7f8c8d;
            font-size: 13px;
            font-style: italic;
        }
        .btn {
            padding: 12px 28px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
        }
        .btn-secondary {
            background: #95a5a6;
            color: white;
            margin-left: 10px;
        }
        .btn-secondary:hover {
            background: #7f8c8d;
        }
        .form-actions {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 2px solid #ecf0f1;
            display: flex;
            gap: 10px;
        }
        .admin-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 0;
        }
        @media (max-width: 768px) {
            .admin-layout {
                grid-template-columns: 1fr;
            }
            .sidebar {
                border-right: none;
                border-bottom: 1px solid #ddd;
            }
            .content-area {
                padding: 20px;
            }
        }
        .info-box {
            background: #e8f4fd;
            border-left: 4px solid #3498db;
            padding: 15px 20px;
            margin-bottom: 30px;
            border-radius: 4px;
        }
        .info-box p {
            margin: 0;
            color: #2c3e50;
            font-size: 14px;
        }
        .page-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .preview-link {
            background: #3498db;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s;
        }
        .preview-link:hover {

    
    <div class="admin-container">
        <div class="admin-panel">
            <div class="admin-layout">
                <aside class="sidebar">
                    <ul class="sidebar-menu">
                        <li><a href="?section=site" class="<?php echo $currentSection === 'site' ? 'active' : ''; ?>">Site Informatie</a></li>
                        <li><a href="?section=home" class="<?php echo $currentSection === 'home' ? 'active' : ''; ?>">Home Pagina</a></li>
                        <li><a href="?section=diensten" class="<?php echo $currentSection === 'diensten' ? 'active' : ''; ?>">Onze Diensten</a></li>
                        <li><a href="?section=over_ons" class="<?php echo $currentSection === 'over_ons' ? 'active' : ''; ?>">Over Ons</a></li>
                        <li><a href="?section=contact" class="<?php echo $currentSection === 'contact' ? 'active' : ''; ?>">Contact</a></li>
                    </ul>
                </aside>
                
                <main class="content-area">
                    <?php if ($saved): ?>
                        <div class="message success">
                            <strong>Succes!</strong> Wijzigingen zijn opgeslagen en direct zichtbaar op de website.
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($error): ?>
                        <div class="message error">
                            <strong>Error:</strong> <?php echo h($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($currentSection === 'site'): ?>
                        <div class="form-section">
                            <div class="page-title">
                                <h2>Site Informatie</h2>
                            </div>
                            <div class="info-box">
                                <p>Deze informatie wordt gebruikt op alle pagina's van de website (footer, contact info, etc.).</p>
                            </div>
                            
                            <form method="POST">
                                <input type="hidden" name="section" value="site">
                                
                                <div class="form-group">
                                    <label>Website Titel</label>
                                    <input type="text" name="site_title" value="<?php echo h($content['site']['title']); ?>" required>
                                    <small>De hoofdnaam van uw bedrijf</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Website Beschrijving</label>
                                    <input type="text" name="site_description" value="<?php echo h($content['site']['description']); ?>" required>
                                    <small>Korte omschrijving van uw bedrijf</small>
                                </div>
                                
                                <h3>Contact Gegevens</h3>
                                
                                <div class="form-group">
                                    <label>Telefoon</label>
                                    <input type="text" name="contact_phone" value="<?php echo h($content['site']['contact']['phone']); ?>" required>
                                    <small>Bijvoorbeeld: +31 6 12345678</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email" name="contact_email" value="<?php echo h($content['site']['contact']['email']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Straat en Huisnummer</label>
                                    <input type="text" name="contact_address" value="<?php echo h($content['site']['contact']['address']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Stad</label>
                                    <input type="text" name="contact_city" value="<?php echo h($content['site']['contact']['city']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Postcode</label>
                                    <input type="text" name="contact_zipcode" value="<?php echo h($content['site']['contact']['zipcode']); ?>" required>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
                                    <button type="reset" class="btn btn-secondary">Annuleren</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($currentSection === 'home'): ?>
                        <div class="form-section">
                            <div class="page-title">
                                <h2>Home Pagina</h2>
                                <a href="/index.php" target="_blank" class="preview-link">Bekijk Pagina</a>
                            </div>
                            <div class="info-box">
                                <p>Bewerk de content van de home pagina. Dit is de eerste pagina die bezoekers zien.</p>
                            </div>
                            
                            <form method="POST">
                                <input type="hidden" name="section" value="home">
                                
                                <h3>Hero Sectie (Grote Banner Bovenaan)</h3>
                                
                                <div class="form-group">
                                    <label>Hero Titel</label>
                                    <input type="text" name="hero_title" value="<?php echo h($content['home']['hero']['title']); ?>" required>
                                    <small>De grote kop bovenaan de pagina</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Ondertitel</label>
                                    <input type="text" name="hero_subtitle" value="<?php echo h($content['home']['hero']['subtitle']); ?>" required>
                                    <small>Tekst onder de hoofdtitel</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Beschrijving</label>
                                    <textarea name="hero_description" required><?php echo h($content['home']['hero']['description']); ?></textarea>
                                    <small>Extra informatie onder de ondertitel</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Achtergrond Afbeelding</label>
                                    <input type="text" name="hero_image" value="<?php echo h($content['home']['hero']['image']); ?>" required>
                                    <small>Pad: assets/images/hero-home.jpg</small>
                                </div>
                                
                                <h3>Intro Sectie (Welkom Sectie)</h3>
                                
                                <div class="form-group">
                                    <label>Intro Titel</label>
                                    <input type="text" name="intro_title" value="<?php echo h($content['home']['intro']['title']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Intro Tekst</label>
                                    <textarea name="intro_text" required><?php echo h($content['home']['intro']['text']); ?></textarea>
                                    <small>Uitgebreide welkomst tekst</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Intro Afbeelding</label>
                                    <input type="text" name="intro_image" value="<?php echo h($content['home']['intro']['image']); ?>" required>
                                    <small>Pad: assets/images/intro.jpg</small>
                                </div>
                                
                                <h3>Vakmanschap Sectie</h3>
                                
                                <div class="form-group">
                                    <label>Vakmanschap Titel</label>
                                    <input type="text" name="vak_title" value="<?php echo h($content['home']['vakmanschap']['title']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Vakmanschap Ondertitel</label>
                                    <input type="text" name="vak_subtitle" value="<?php echo h($content['home']['vakmanschap']['subtitle']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Vakmanschap Tekst</label>
                                    <textarea name="vak_text" required><?php echo h($content['home']['vakmanschap']['text']); ?></textarea>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
                                    <button type="reset" class="btn btn-secondary">Annuleren</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($currentSection === 'diensten'): ?>
                        <div class="form-section">
                            <div class="page-title">
                                <h2>Onze Diensten</h2>
                                <a href="/diensten.php" target="_blank" class="preview-link">Bekijk Pagina</a>
                            </div>
                            <div class="info-box">
                                <p>Bewerk de diensten die u aanbiedt. Momenteel zijn er 3 diensten zichtbaar op de website.</p>
                            </div>
                            
                            <form method="POST">
                                <input type="hidden" name="section" value="diensten">
                                
                                <h3>Hero Sectie</h3>
                                
                                <div class="form-group">
                                    <label>Hero Titel</label>
                                    <input type="text" name="hero_title" value="<?php echo h($content['diensten']['hero']['title']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Ondertitel</label>
                                    <input type="text" name="hero_subtitle" value="<?php echo h($content['diensten']['hero']['subtitle']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Achtergrond Afbeelding</label>
                                    <input type="text" name="hero_image" value="<?php echo h($content['diensten']['hero']['image']); ?>" required>
                                    <small>Pad: assets/images/hero-diensten.jpg</small>
                                </div>
                                
                                <?php foreach ($content['diensten']['services'] as $index => $service): ?>
                                    <h3>Dienst <?php echo $index + 1; ?>: <?php echo h($service['title']); ?></h3>
                                    
                                    <div class="form-group">
                                        <label>Dienst Naam</label>
                                        <input type="text" name="service_title_<?php echo $index; ?>" value="<?php echo h($service['title']); ?>" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Dienst Beschrijving</label>
                                        <textarea name="service_desc_<?php echo $index; ?>" required><?php echo h($service['description']); ?></textarea>
                                        <small>Uitleg over deze dienst</small>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Dienst Afbeelding</label>
                                        <input type="text" name="service_image_<?php echo $index; ?>" value="<?php echo h($service['image']); ?>" required>
                                        <small>Pad: assets/images/service-<?php echo $index + 1; ?>.jpg</small>
                                    </div>
                                <?php endforeach; ?>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
                                    <button type="reset" class="btn btn-secondary">Annuleren</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($currentSection === 'over_ons'): ?>
                        <div class="form-section">
                            <div class="page-title">
                                <h2>Over Ons</h2>
                                <a href="/over-ons.php" target="_blank" class="preview-link">Bekijk Pagina</a>
                            </div>
                            <div class="info-box">
                                <p>Vertel uw verhaal. Laat klanten kennismaken met uw bedrijf en de mensen erachter.</p>
                            </div>
                            
                            <form method="POST">
                                <input type="hidden" name="section" value="over_ons">
                                
                                <h3>Hero Sectie</h3>
                                
                                <div class="form-group">
                                    <label>Hero Titel</label>
                                    <input type="text" name="hero_title" value="<?php echo h($content['over_ons']['hero']['title']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Ondertitel</label>
                                    <input type="text" name="hero_subtitle" value="<?php echo h($content['over_ons']['hero']['subtitle']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Achtergrond Afbeelding</label>
                                    <input type="text" name="hero_image" value="<?php echo h($content['over_ons']['hero']['image']); ?>" required>
                                    <small>Pad: assets/images/hero-over-ons.jpg</small>
                                </div>
                                
                                <h3>Bedrijfsverhaal</h3>
                                
                                <div class="form-group">
                                    <label>Verhaal Titel</label>
                                    <input type="text" name="story_title" value="<?php echo h($content['over_ons']['story']['title']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Eerste Alinea</label>
                                    <textarea name="story_p1" required><?php echo h($content['over_ons']['story']['paragraphs'][0]); ?></textarea>
                                    <small>Begin van uw verhaal</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Tweede Alinea</label>
                                    <textarea name="story_p2" required><?php echo h($content['over_ons']['story']['paragraphs'][1]); ?></textarea>
                                    <small>Vervolg van uw verhaal</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Derde Alinea</label>
                                    <textarea name="story_p3" required><?php echo h($content['over_ons']['story']['paragraphs'][2]); ?></textarea>
                                    <small>Afsluiting van uw verhaal</small>
                                </div>
                                
                                <h3>Oprichter / Eigenaar</h3>
                                
                                <div class="form-group">
                                    <label>Naam</label>
                                    <input type="text" name="founder_name" value="<?php echo h($content['over_ons']['founder']['name']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Functie / Rol</label>
                                    <input type="text" name="founder_title" value="<?php echo h($content['over_ons']['founder']['title']); ?>" required>
                                    <small>Bijvoorbeeld: Oprichter & Vakman</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Persoonlijke Quote</label>
                                    <textarea name="founder_quote" required><?php echo h($content['over_ons']['founder']['quote']); ?></textarea>
                                    <small>Een inspirerende quote of motto</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>Foto van Oprichter</label>
                                    <input type="text" name="founder_image" value="<?php echo h($content['over_ons']['founder']['image']); ?>" required>
                                    <small>Pad: assets/images/mathijs.jpg</small>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
                                    <button type="reset" class="btn btn-secondary">Annuleren</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($currentSection === 'contact'): ?>
                        <div class="form-section">
                            <div class="page-title">
                                <h2>Contact Pagina</h2>
                                <a href="/contact.php" target="_blank" class="preview-link">Bekijk Pagina</a>
                            </div>
                            <div class="info-box">
                                <p>Zorg dat klanten weten hoe ze contact met u kunnen opnemen.</p>
                            </div>
                            
                            <form method="POST">
                                <input type="hidden" name="section" value="contact">
                                
                                <h3>Hero Sectie</h3>
                                
                                <div class="form-group">
                                    <label>Hero Titel</label>
                                    <input type="text" name="hero_title" value="<?php echo h($content['contact']['hero']['title']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Ondertitel</label>
                                    <input type="text" name="hero_subtitle" value="<?php echo h($content['contact']['hero']['subtitle']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Achtergrond Afbeelding</label>
                                    <input type="text" name="hero_image" value="<?php echo h($content['contact']['hero']['image']); ?>" required>
                                    <small>Pad: assets/images/hero-contact.jpg</small>
                                </div>
                                
                                <h3>Intro Tekst</h3>
                                
                                <div class="form-group">
                                    <label>Intro Titel</label>
                                    <input type="text" name="intro_title" value="<?php echo h($content['contact']['intro']['title']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Intro Tekst</label>
                                    <textarea name="intro_text" required><?php echo h($content['contact']['intro']['text']); ?></textarea>
                                    <small>Uitnodigende tekst voor contact</small>
                                </div>
                                
                                <h3>Contact Informatie</h3>
                                
                                <div class="form-group">
                                    <label>Telefoon</label>
                                    <input type="text" name="phone_value" value="<?php echo h($content['contact']['info']['phone']['value']); ?>" required>
                                    <small>Bijvoorbeeld: +31 6 12345678</small>
                                </div>
                                
                                <div class="form-group">
                                    <label>E-mail</label>
                                    <input type="email" name="email_value" value="<?php echo h($content['contact']['info']['email']['value']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Straat en Huisnummer</label>
                                    <input type="text" name="address_street" value="<?php echo h($content['contact']['info']['address']['street']); ?>" required>
                                </div>
                                
                                <div class="form-group">
                                    <label>Postcode en Stad</label>
                                    <input type="text" name="address_city" value="<?php echo h($content['contact']['info']['address']['city']); ?>" required>
                                    <small>Bijvoorbeeld: 1234 AB Amsterdam</small>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
                                    <button type="reset" class="btn btn-secondary">Annuleren</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </main>
            </div>
        </div>
    </div>
</body>
</html>
