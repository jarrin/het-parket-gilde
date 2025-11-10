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
                        <?php include __DIR__ . '/sections/over-ons.php'; ?>
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