<?php
require_once '../functions.php';
requireAdmin();

$content = loadContent();
$saved = false;
$error = null;

// Handle form submission
try {
    include __DIR__ . '/handlers.php';
} catch (Exception $e) {
    $error = 'Fout: ' . $e->getMessage();
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
                        <?php include __DIR__ . '/sections/home.php'; ?>
                    <?php endif; ?>
                    
                    <?php if ($currentSection === 'diensten'): ?>
                        <?php include __DIR__ . '/sections/diensten.php'; ?>
                    <?php endif; ?>
                    
                    <?php if ($currentSection === 'over_ons'): ?>
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
                                    <div class="image-input-group">
                                        <input type="text" name="hero_image" id="over_ons_hero_image" value="<?php echo h($content['over_ons']['hero']['image']); ?>" required>
                                        <button type="button" class="btn btn-secondary" data-media-input="over_ons_hero_image">Bladeren</button>
                                    </div>
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
                                    <div class="image-input-group">
                                        <input type="text" name="founder_image" id="founder_image" value="<?php echo h($content['over_ons']['founder']['image']); ?>" required>
                                        <button type="button" class="btn btn-secondary" data-media-input="founder_image">Bladeren</button>
                                    </div>
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
                                
                                <h4>Pagina Achtergrond</h4>
                                <div class="form-group">
                                    <label>Pagina Achtergrondkleur</label>
                                    <div class="color-input-group">
                                        <input type="color" name="page_bg" value="<?php echo h($content['over_ons']['colors']['sectionBg']); ?>" class="color-picker-input">
                                        <input type="text" value="<?php echo h($content['over_ons']['colors']['sectionBg']); ?>" readonly class="color-text-input">
                                    </div>
                                    <small>De algemene achtergrondkleur van de hele pagina</small>
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
                            
                            <form method="POST" style="margin-top: 30px;">
                                <input type="hidden" name="section" value="over_ons_cta">
                                
                                <h3>CTA Sectie Bewerken</h3>
                                <div class="info-box" style="margin-bottom: 20px;">
                                    <p>Pas de Call-to-Action sectie onderaan de pagina aan.</p>
                                </div>
                                
                                <div class="form-group">
                                    <label>CTA Achtergrond Afbeelding</label>
                                    <div class="image-input-group">
                                        <input type="text" name="cta_image" id="over_ons_cta_image" value="<?php echo h($content['over_ons']['cta']['image'] ?? ''); ?>">
                                        <button type="button" class="btn btn-secondary" data-media-input="over_ons_cta_image">Bladeren</button>
                                    </div>
                                    <small>Optioneel - achtergrondafbeelding voor de CTA sectie (aanbevolen: 1920x400px)</small>
                                </div>
                                
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary">CTA Afbeelding Opslaan</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($currentSection === 'contact'): ?>
                        <?php include __DIR__ . '/sections/contact.php'; ?>
                    <?php endif; ?>
                </main>
            </div>
        </div>
    </div>
    <script src="/assets/js/admin.js?v=<?php echo time(); ?>"></script>
</body>
</html>