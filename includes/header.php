<?php
require_once 'functions.php';
$content = loadContent();
$site = $content['site'];
$currentPage = getCurrentPage();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo h($site['title']); ?> - <?php echo ucfirst(str_replace('-', ' ', $currentPage)); ?></title>
    <meta name="description" content="<?php echo h($site['description']); ?>">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?php if (isset($site['colors'])): ?>
    <style>
        :root {
            --primary-color: <?php echo h($site['colors']['primary']); ?>;
            --secondary-color: <?php echo h($site['colors']['secondary']); ?>;
            --accent-color: <?php echo h($site['colors']['accent']); ?>;
            --text-color: <?php echo h($site['colors']['text']); ?>;
            --text-light: <?php echo h($site['colors']['textLight']); ?>;
            --bg-light: <?php echo h($site['colors']['bgLight']); ?>;
            --white: <?php echo h($site['colors']['white']); ?>;
            --border-color: <?php echo h($site['colors']['border']); ?>;
        }
    </style>
    <?php endif; ?>
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1><a href="/index.php"><?php echo h($site['title']); ?></a></h1>
                </div>
                <nav class="main-nav">
                    <button class="mobile-menu-toggle" aria-label="Menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <ul class="nav-menu">
                        <?php foreach (getNavigation() as $nav): ?>
                            <li>
                                <a href="<?php echo h($nav['url']); ?>" 
                                   class="<?php echo isActivePage($nav['page']) ? 'active' : ''; ?>">
                                    <?php echo h($nav['label']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <main class="site-main">
