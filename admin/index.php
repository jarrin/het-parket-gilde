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
                    
                    // Header kleuren
                    $content['site']['colors']['header']['background'] = $_POST['header_bg'] ?? '';
                    $content['site']['colors']['header']['text'] = $_POST['header_text'] ?? '';
                    $content['site']['colors']['header']['logo'] = $_POST['header_logo'] ?? '';
                    
                    // Footer kleuren
                    $content['site']['colors']['footer']['background'] = $_POST['footer_bg'] ?? '';
                    $content['site']['colors']['footer']['text'] = $_POST['footer_text'] ?? '';
                    $content['site']['colors']['footer']['links'] = $_POST['footer_links'] ?? '';
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
                    
                case 'home_colors':
                    // Hero sectie kleuren
                    $content['home']['hero']['colors']['background'] = $_POST['hero_bg'] ?? '';
                    $content['home']['hero']['colors']['text'] = $_POST['hero_text'] ?? '';
                    $content['home']['hero']['colors']['overlay'] = $_POST['hero_overlay'] ?? '';
                    
                    // Intro sectie kleuren
                    $content['home']['intro']['colors']['background'] = $_POST['intro_bg'] ?? '';
                    $content['home']['intro']['colors']['text'] = $_POST['intro_text'] ?? '';
                    $content['home']['intro']['colors']['title'] = $_POST['intro_title'] ?? '';
                    
                    // Vakmanschap sectie kleuren
                    $content['home']['vakmanschap']['colors']['background'] = $_POST['vak_bg'] ?? '';
                    $content['home']['vakmanschap']['colors']['text'] = $_POST['vak_text'] ?? '';
                    $content['home']['vakmanschap']['colors']['title'] = $_POST['vak_title'] ?? '';
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
                    
                case 'diensten_colors':
                    // Hero sectie kleuren
                    $content['diensten']['hero']['colors']['background'] = $_POST['hero_bg'] ?? '';
                    $content['diensten']['hero']['colors']['text'] = $_POST['hero_text'] ?? '';
                    $content['diensten']['hero']['colors']['overlay'] = $_POST['hero_overlay'] ?? '';
                    
                    // Service secties kleuren
                    for ($i = 0; $i < 3; $i++) {
                        if (isset($_POST['service_bg_' . $i])) {
                            $content['diensten']['services'][$i]['colors']['background'] = $_POST['service_bg_' . $i];
                            $content['diensten']['services'][$i]['colors']['text'] = $_POST['service_text_' . $i] ?? '';
                            $content['diensten']['services'][$i]['colors']['title'] = $_POST['service_title_' . $i] ?? '';
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
                    
                case 'over_ons_colors':
                    // Hero sectie
                    $content['over_ons']['hero']['colors']['background'] = $_POST['hero_bg'] ?? '';
                    $content['over_ons']['hero']['colors']['text'] = $_POST['hero_text'] ?? '';
                    $content['over_ons']['hero']['colors']['overlay'] = $_POST['hero_overlay'] ?? '';
                    
                    // Story sectie
                    $content['over_ons']['story']['colors']['background'] = $_POST['story_bg'] ?? '';
                    $content['over_ons']['story']['colors']['text'] = $_POST['story_text'] ?? '';
                    $content['over_ons']['story']['colors']['title'] = $_POST['story_title'] ?? '';
                    
                    // Founder sectie
                    $content['over_ons']['founder']['colors']['background'] = $_POST['founder_bg'] ?? '';
                    $content['over_ons']['founder']['colors']['text'] = $_POST['founder_text'] ?? '';
                    $content['over_ons']['founder']['colors']['title'] = $_POST['founder_title'] ?? '';
                    
                    // Values sectie
                    $content['over_ons']['values_colors']['background'] = $_POST['values_bg'] ?? '';
                    $content['over_ons']['values_colors']['text'] = $_POST['values_text'] ?? '';
                    $content['over_ons']['values_colors']['title'] = $_POST['values_title'] ?? '';
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
                    
                case 'contact_colors':
                    // Hero sectie
                    $content['contact']['hero']['colors']['background'] = $_POST['hero_bg'] ?? '';
                    $content['contact']['hero']['colors']['text'] = $_POST['hero_text'] ?? '';
                    $content['contact']['hero']['colors']['overlay'] = $_POST['hero_overlay'] ?? '';
                    
                    // Intro sectie
                    $content['contact']['intro']['colors']['background'] = $_POST['intro_bg'] ?? '';
                    $content['contact']['intro']['colors']['text'] = $_POST['intro_text'] ?? '';
                    $content['contact']['intro']['colors']['title'] = $_POST['intro_title'] ?? '';
                    
                    // Info sectie
                    $content['contact']['info']['colors']['background'] = $_POST['info_bg'] ?? '';
                    $content['contact']['info']['colors']['text'] = $_POST['info_text'] ?? '';
                    $content['contact']['info']['colors']['title'] = $_POST['info_title'] ?? '';
                    
                    // Hours sectie
                    $content['contact']['hours']['colors']['background'] = $_POST['hours_bg'] ?? '';
                    $content['contact']['hours']['colors']['text'] = $_POST['hours_text'] ?? '';
                    $content['contact']['hours']['colors']['title'] = $_POST['hours_title'] ?? '';
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
                        <li><a href="media-manager.php" style="border-top: 1px solid #ddd; margin-top: 10px; padding-top: 10px;">📁 Media Manager</a></li>
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
                        <?php include __DIR__ . '/sections/site.php'; ?>
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
                            
                            <form method="POST" style="margin-top: 30px;">
                                <input type="hidden" name="section" value="home_colors">
                                
                                <h3>Sectie Kleuren (Home Pagina)</h3>
                                <div class="info-box" style="margin-bottom: 20px;">
                                    <p>Pas de kleuren aan per sectie op de Home pagina.</p>
                                </div>
                                
                                <h4>Hero Sectie (Banner Bovenaan)</h4>
                                <div class="form-group">
                                    <label for="home_hero_bg">Hero Achtergrond</label>
                                    <div class="color-input-group">
                                        <input id="home_hero_bg" type="color" name="hero_bg" value="<?php echo h($content['home']['hero']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['home']['hero']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="home_hero_text">Hero Tekst Kleur</label>
                                    <div class="color-input-group">
                                        <input id="home_hero_text" type="color" name="hero_text" value="<?php echo h($content['home']['hero']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['home']['hero']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="home_hero_overlay">Hero Overlay (donkere laag)</label>
                                    <input id="home_hero_overlay" type="text" name="hero_overlay" value="<?php echo h($content['home']['hero']['colors']['overlay']); ?>" placeholder="rgba(0, 0, 0, 0.5)">
                                    <small>Bijvoorbeeld: rgba(0, 0, 0, 0.5) voor 50% zwart</small>
                                </div>
                                
                                <h4>Intro Sectie (Welkom Tekst)</h4>
                                <div class="form-group">
                                    <label for="home_intro_bg">Intro Achtergrond</label>
                                    <div class="color-input-group">
                                        <input id="home_intro_bg" type="color" name="intro_bg" value="<?php echo h($content['home']['intro']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['home']['intro']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="home_intro_text">Intro Tekst Kleur</label>
                                    <div class="color-input-group">
                                        <input id="home_intro_text" type="color" name="intro_text" value="<?php echo h($content['home']['intro']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['home']['intro']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="home_intro_title">Intro Titel Kleur</label>
                                    <div class="color-input-group">
                                        <input id="home_intro_title" type="color" name="intro_title" value="<?php echo h($content['home']['intro']['colors']['title']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['home']['intro']['colors']['title']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <h4>Vakmanschap Sectie</h4>
                                <div class="form-group">
                                    <label for="home_vak_bg">Vakmanschap Achtergrond</label>
                                    <div class="color-input-group">
                                        <input id="home_vak_bg" type="color" name="vak_bg" value="<?php echo h($content['home']['vakmanschap']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['home']['vakmanschap']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="home_vak_text">Vakmanschap Tekst Kleur</label>
                                    <div class="color-input-group">
                                        <input id="home_vak_text" type="color" name="vak_text" value="<?php echo h($content['home']['vakmanschap']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['home']['vakmanschap']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="home_vak_title">Vakmanschap Titel Kleur</label>
                                    <div class="color-input-group">
                                        <input id="home_vak_title" type="color" name="vak_title" value="<?php echo h($content['home']['vakmanschap']['colors']['title']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['home']['vakmanschap']['colors']['title']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Kleuren Opslaan</button>
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
                            
                            <form method="POST" style="margin-top: 30px;">
                                <input type="hidden" name="section" value="diensten_colors">
                                
                                <h3>Sectie Kleuren (Diensten Pagina)</h3>
                                <div class="info-box" style="margin-bottom: 20px;">
                                    <p>Pas de kleuren aan per sectie op de Diensten pagina.</p>
                                </div>
                                
                                <h4>Hero Sectie (Banner Bovenaan)</h4>
                                <div class="form-group">
                                    <label>Hero Achtergrond</label>
                                    <div class="color-input-group">
                                        <input type="color" name="hero_bg" value="<?php echo h($content['diensten']['hero']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['diensten']['hero']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Tekst Kleur</label>
                                    <div class="color-input-group">
                                        <input type="color" name="hero_text" value="<?php echo h($content['diensten']['hero']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['diensten']['hero']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Overlay</label>
                                    <input type="text" name="hero_overlay" value="<?php echo h($content['diensten']['hero']['colors']['overlay']); ?>" placeholder="rgba(0, 0, 0, 0.5)">
                                </div>
                                
                                <?php foreach ($content['diensten']['services'] as $index => $service): ?>
                                    <h4>Dienst <?php echo $index + 1; ?>: <?php echo h($service['title']); ?></h4>
                                    
                                    <div class="form-group">
                                        <label>Achtergrond Kleur</label>
                                        <div class="color-input-group">
                                            <input type="color" name="service_bg_<?php echo $index; ?>" value="<?php echo h($service['colors']['background']); ?>" class="color-picker-input">
                                            <input type="text" value="<?php echo h($service['colors']['background']); ?>" readonly class="color-text-input">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Tekst Kleur</label>
                                        <div class="color-input-group">
                                            <input type="color" name="service_text_<?php echo $index; ?>" value="<?php echo h($service['colors']['text']); ?>" class="color-picker-input">
                                            <input type="text" value="<?php echo h($service['colors']['text']); ?>" readonly class="color-text-input">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label>Titel Kleur</label>
                                        <div class="color-input-group">
                                            <input type="color" name="service_title_<?php echo $index; ?>" value="<?php echo h($service['colors']['title']); ?>" class="color-picker-input">
                                            <input type="text" value="<?php echo h($service['colors']['title']); ?>" readonly class="color-text-input">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Kleuren Opslaan</button>
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
                            
                            <form method="POST" style="margin-top: 30px;">
                                <input type="hidden" name="section" value="over_ons_colors">
                                
                                <h3>Sectie Kleuren (Over Ons Pagina)</h3>
                                <div class="info-box" style="margin-bottom: 20px;">
                                    <p>Pas de kleuren aan per sectie op de Over Ons pagina.</p>
                                </div>
                                
                                <h4>Hero Sectie</h4>
                                <div class="form-group">
                                    <label>Hero Achtergrond</label>
                                    <div class="color-input-group">
                                        <input type="color" name="hero_bg" value="<?php echo h($content['over_ons']['hero']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['hero']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Tekst</label>
                                    <div class="color-input-group">
                                        <input type="color" name="hero_text" value="<?php echo h($content['over_ons']['hero']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['hero']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Overlay</label>
                                    <input type="text" name="hero_overlay" value="<?php echo h($content['over_ons']['hero']['colors']['overlay']); ?>" placeholder="rgba(0, 0, 0, 0.5)">
                                </div>
                                
                                <h4>Verhaal Sectie</h4>
                                <div class="form-group">
                                    <label>Verhaal Achtergrond</label>
                                    <div class="color-input-group">
                                        <input type="color" name="story_bg" value="<?php echo h($content['over_ons']['story']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['story']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Verhaal Tekst</label>
                                    <div class="color-input-group">
                                        <input type="color" name="story_text" value="<?php echo h($content['over_ons']['story']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['story']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Verhaal Titel</label>
                                    <div class="color-input-group">
                                        <input type="color" name="story_title" value="<?php echo h($content['over_ons']['story']['colors']['title']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['story']['colors']['title']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <h4>Oprichter Sectie</h4>
                                <div class="form-group">
                                    <label>Oprichter Achtergrond</label>
                                    <div class="color-input-group">
                                        <input type="color" name="founder_bg" value="<?php echo h($content['over_ons']['founder']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['founder']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Oprichter Tekst</label>
                                    <div class="color-input-group">
                                        <input type="color" name="founder_text" value="<?php echo h($content['over_ons']['founder']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['founder']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Oprichter Titel</label>
                                    <div class="color-input-group">
                                        <input type="color" name="founder_title" value="<?php echo h($content['over_ons']['founder']['colors']['title']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['founder']['colors']['title']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <h4>Waarden Sectie</h4>
                                <div class="form-group">
                                    <label>Waarden Achtergrond</label>
                                    <div class="color-input-group">
                                        <input type="color" name="values_bg" value="<?php echo h($content['over_ons']['values_colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['values_colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Waarden Tekst</label>
                                    <div class="color-input-group">
                                        <input type="color" name="values_text" value="<?php echo h($content['over_ons']['values_colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['values_colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Waarden Titel</label>
                                    <div class="color-input-group">
                                        <input type="color" name="values_title" value="<?php echo h($content['over_ons']['values_colors']['title']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['values_colors']['title']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Kleuren Opslaan</button>
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
                            
                            <form method="POST" style="margin-top: 30px;">
                                <input type="hidden" name="section" value="contact_colors">
                                
                                <h3>Sectie Kleuren (Contact Pagina)</h3>
                                <div class="info-box" style="margin-bottom: 20px;">
                                    <p>Pas de kleuren aan per sectie op de Contact pagina.</p>
                                </div>
                                
                                <h4>Hero Sectie</h4>
                                <div class="form-group">
                                    <label>Hero Achtergrond</label>
                                    <div class="color-input-group">
                                        <input type="color" name="hero_bg" value="<?php echo h($content['contact']['hero']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['hero']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Tekst</label>
                                    <div class="color-input-group">
                                        <input type="color" name="hero_text" value="<?php echo h($content['contact']['hero']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['hero']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Hero Overlay</label>
                                    <input type="text" name="hero_overlay" value="<?php echo h($content['contact']['hero']['colors']['overlay']); ?>" placeholder="rgba(0, 0, 0, 0.5)">
                                </div>
                                
                                <h4>Intro Sectie</h4>
                                <div class="form-group">
                                    <label>Intro Achtergrond</label>
                                    <div class="color-input-group">
                                        <input type="color" name="intro_bg" value="<?php echo h($content['contact']['intro']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['intro']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Intro Tekst</label>
                                    <div class="color-input-group">
                                        <input type="color" name="intro_text" value="<?php echo h($content['contact']['intro']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['intro']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Intro Titel</label>
                                    <div class="color-input-group">
                                        <input type="color" name="intro_title" value="<?php echo h($content['contact']['intro']['colors']['title']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['intro']['colors']['title']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <h4>Contact Info Sectie</h4>
                                <div class="form-group">
                                    <label>Info Achtergrond</label>
                                    <div class="color-input-group">
                                        <input type="color" name="info_bg" value="<?php echo h($content['contact']['info']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['info']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Info Tekst</label>
                                    <div class="color-input-group">
                                        <input type="color" name="info_text" value="<?php echo h($content['contact']['info']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['info']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Info Titel</label>
                                    <div class="color-input-group">
                                        <input type="color" name="info_title" value="<?php echo h($content['contact']['info']['colors']['title']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['info']['colors']['title']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <h4>Openingstijden Sectie</h4>
                                <div class="form-group">
                                    <label>Openingstijden Achtergrond</label>
                                    <div class="color-input-group">
                                        <input type="color" name="hours_bg" value="<?php echo h($content['contact']['hours']['colors']['background']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['hours']['colors']['background']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Openingstijden Tekst</label>
                                    <div class="color-input-group">
                                        <input type="color" name="hours_text" value="<?php echo h($content['contact']['hours']['colors']['text']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['hours']['colors']['text']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label>Openingstijden Titel</label>
                                    <div class="color-input-group">
                                        <input type="color" name="hours_title" value="<?php echo h($content['contact']['hours']['colors']['title']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['contact']['hours']['colors']['title']); ?>" readonly class="color-text-input">
                                    </div>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">Kleuren Opslaan</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                </main>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Per-page color live updates
            const pageColorMappings = [
                // Home colors
                { colorId: 'home_color_header', textId: 'home_text_header' },
                { colorId: 'home_color_hero_text', textId: 'home_text_hero_text' },
                { colorId: 'home_color_section_bg', textId: 'home_text_section_bg' },
                // Diensten colors
                { colorId: 'diensten_color_header', textId: 'diensten_text_header' },
                { colorId: 'diensten_color_hero_text', textId: 'diensten_text_hero_text' },
                { colorId: 'diensten_color_section_bg', textId: 'diensten_text_section_bg' },
                // Over Ons colors
                { colorId: 'over_ons_color_header', textId: 'over_ons_text_header' },
                { colorId: 'over_ons_color_hero_text', textId: 'over_ons_text_hero_text' },
                { colorId: 'over_ons_color_section_bg', textId: 'over_ons_text_section_bg' },
                // Contact colors
                { colorId: 'contact_color_header', textId: 'contact_text_header' },
                { colorId: 'contact_color_hero_text', textId: 'contact_text_hero_text' },
                { colorId: 'contact_color_section_bg', textId: 'contact_text_section_bg' }
            ];
            
            pageColorMappings.forEach(mapping => {
                const colorInput = document.getElementById(mapping.colorId);
                const textInput = document.getElementById(mapping.textId);
                
                if (colorInput && textInput) {
                    colorInput.addEventListener('input', function() {
                        textInput.value = this.value.toUpperCase();
                    });
                }
            });
        });
    </script>
</body>
</html>