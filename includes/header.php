<?php
// Functions are already loaded by the main page files
// No need to require_once again here
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
    <link rel="stylesheet" href="/assets/css/dynamic-colors.php?page=<?php echo urlencode($currentPage); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="site-header" style="background-color: <?php echo h($site['colors']['header']['background']); ?>; color: <?php echo h($site['colors']['header']['text']); ?>;">
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <h1><a href="/index.php" style="color: <?php echo h($site['colors']['header']['logo']); ?>;"><?php echo h($site['title']); ?></a></h1>
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
                                   class="<?php echo isActivePage($nav['page']) ? 'active' : ''; ?>"
                                   style="color: <?php echo h($site['colors']['header']['logo']); ?>;">
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
