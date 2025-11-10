<?php
// Dynamic color CSS generator
header('Content-Type: text/css');
require_once __DIR__ . '/../../functions.php';

$content = loadContent();
$site = $content['site'];

// Determine current page
$currentPage = 'home';
if (isset($_GET['page'])) {
    $currentPage = $_GET['page'];
}

// Map page names
$pageKey = str_replace('-', '_', $currentPage);
if ($pageKey === 'index') $pageKey = 'home';
?>
:root {
<?php if (isset($site['colors'])): ?>
    --primary-color: <?php echo $site['colors']['primary']; ?>;
    --secondary-color: <?php echo $site['colors']['secondary']; ?>;
    --accent-color: <?php echo $site['colors']['accent']; ?>;
    --text-color: <?php echo $site['colors']['text']; ?>;
    --text-light: <?php echo $site['colors']['textLight']; ?>;
    --bg-light: <?php echo $site['colors']['bgLight']; ?>;
    --white: <?php echo $site['colors']['white']; ?>;
    --border-color: <?php echo $site['colors']['border']; ?>;
<?php endif; ?>
<?php
// Add page-specific colors
if (isset($content[$pageKey]['colors'])) {
    $pageColors = $content[$pageKey]['colors'];
    if (isset($pageColors['header'])) {
        echo "    --page-header-bg: {$pageColors['header']};\n";
    }
    if (isset($pageColors['heroText'])) {
        echo "    --page-hero-text: {$pageColors['heroText']};\n";
    }
    if (isset($pageColors['sectionBg'])) {
        echo "    --page-section-bg: {$pageColors['sectionBg']};\n";
    }
}
?>
}
