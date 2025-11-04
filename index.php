<?php
require_once 'functions.php';
$content = loadContent();
$home = $content['home'];
$pageTitle = 'Home';
include 'includes/header.php';
?>

<section class="hero" style="background-image: url('<?php echo h($home['hero']['image']); ?>'); background-color: <?php echo h($home['hero']['colors']['background']); ?>;" data-edit-image="hero.image">
    <div class="hero-overlay" style="background: <?php echo h($home['hero']['colors']['overlay']); ?>;">
        <div class="container">
            <div class="hero-content" style="color: <?php echo h($home['hero']['colors']['text']); ?>;">
                <h1 class="hero-title" data-edit-path="hero.title"><?php echo h($home['hero']['title']); ?></h1>
                <p class="hero-subtitle" data-edit-path="hero.subtitle"><?php echo h($home['hero']['subtitle']); ?></p>
                <p class="hero-description" data-edit-path="hero.description"><?php echo h($home['hero']['description']); ?></p>
                <a href="/diensten.php" class="btn btn-primary">Bekijk onze diensten</a>
            </div>
        </div>
    </div>
</section>

<section class="section intro-section" style="background-color: <?php echo h($home['intro']['colors']['background']); ?>; color: <?php echo h($home['intro']['colors']['text']); ?>;">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h2 style="color: <?php echo h($home['intro']['colors']['title']); ?>;" data-edit-path="intro.title"><?php echo h($home['intro']['title']); ?></h2>
                <p data-edit-path="intro.text"><?php echo h($home['intro']['text']); ?></p>
                <a href="/over-ons.php" class="btn btn-secondary">Meer over ons</a>
            </div>
            <div class="col-md-6">
                <img src="<?php echo h($home['intro']['image']); ?>" 
                     alt="<?php echo h($home['intro']['title']); ?>" 
                     class="intro-image"
                     data-edit-image="intro.image">
            </div>
        </div>
    </div>
</section>

<section class="section vakmanschap-section" style="background-color: <?php echo h($home['vakmanschap']['colors']['background']); ?>; color: <?php echo h($home['vakmanschap']['colors']['text']); ?>;">
    <div class="container">
        <div class="section-header text-center">
            <h2 style="color: <?php echo h($home['vakmanschap']['colors']['title']); ?>;" data-edit-path="vakmanschap.title"><?php echo h($home['vakmanschap']['title']); ?></h2>
            <p class="section-subtitle" data-edit-path="vakmanschap.subtitle"><?php echo h($home['vakmanschap']['subtitle']); ?></p>
            <p data-edit-path="vakmanschap.text"><?php echo h($home['vakmanschap']['text']); ?></p>
        </div>
        
        <div class="features">
            <?php foreach ($home['vakmanschap']['features'] as $index => $feature): ?>
                <div class="feature-card">
                    <div class="feature-icon"><?php echo h($feature['icon']); ?></div>
                    <h3 style="color: <?php echo h($home['vakmanschap']['colors']['title']); ?>;" data-edit-path="vakmanschap.features.<?php echo $index; ?>.title"><?php echo h($feature['title']); ?></h3>
                    <p data-edit-path="vakmanschap.features.<?php echo $index; ?>.description"><?php echo h($feature['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section cta-section">
    <div class="container text-center">
        <h2>Neem contact met ons op</h2>
        <p>Wilt u meer weten of een vrijblijvende offerte aanvragen?</p>
        <a href="/contact.php" class="btn btn-primary">Contacteer ons</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
