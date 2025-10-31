<?php
require_once 'functions.php';
$content = loadContent();
$contact = $content['contact'];
$pageTitle = 'Contact';
include 'includes/header.php';
?>

<section class="hero" style="background-image: url('<?php echo h($contact['hero']['image']); ?>');">
    <div class="hero-overlay">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo h($contact['hero']['title']); ?></h1>
                <p class="hero-subtitle"><?php echo h($contact['hero']['subtitle']); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="section contact-section">
    <div class="container">
        <div class="section-header text-center">
            <h2><?php echo h($contact['intro']['title']); ?></h2>
            <p><?php echo h($contact['intro']['text']); ?></p>
        </div>
        
        <div class="row contact-info">
            <div class="col-md-4">
                <div class="contact-card">
                    <div class="contact-icon">📞</div>
                    <h3><?php echo h($contact['info']['phone']['label']); ?></h3>
                    <p>
                        <a href="<?php echo h($contact['info']['phone']['link']); ?>">
                            <?php echo h($contact['info']['phone']['value']); ?>
                        </a>
                    </p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="contact-card">
                    <div class="contact-icon">✉️</div>
                    <h3><?php echo h($contact['info']['email']['label']); ?></h3>
                    <p>
                        <a href="<?php echo h($contact['info']['email']['link']); ?>">
                            <?php echo h($contact['info']['email']['value']); ?>
                        </a>
                    </p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="contact-card">
                    <div class="contact-icon">📍</div>
                    <h3><?php echo h($contact['info']['address']['label']); ?></h3>
                    <p>
                        <?php echo h($contact['info']['address']['street']); ?><br>
                        <?php echo h($contact['info']['address']['city']); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section hours-section">
    <div class="container">
        <h2 class="text-center"><?php echo h($contact['hours']['title']); ?></h2>
        <div class="hours-list">
            <?php foreach ($contact['hours']['schedule'] as $schedule): ?>
                <p><?php echo h($schedule); ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
