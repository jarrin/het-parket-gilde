<?php
require_once 'functions.php';
$content = loadContent();
$contact = $content['contact'];
$pageTitle = 'Contact';
include 'includes/header.php';
?>

<section class="hero" style="background-image: url('<?php echo h($contact['hero']['image']); ?>'); background-color: <?php echo h($contact['hero']['colors']['background']); ?>;" data-edit-image="hero.image">
    <div class="hero-overlay" style="background: <?php echo h($contact['hero']['colors']['overlay']); ?>;">
        <div class="container">
            <div class="hero-content" style="color: <?php echo h($contact['hero']['colors']['text']); ?>;">
                <h1 class="hero-title" data-edit-path="hero.title"><?php echo h($contact['hero']['title']); ?></h1>
                <p class="hero-subtitle" data-edit-path="hero.subtitle"><?php echo h($contact['hero']['subtitle']); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="section contact-section" style="background-color: <?php echo h($contact['intro']['colors']['background']); ?>; color: <?php echo h($contact['intro']['colors']['text']); ?>;">
    <div class="container">
        <div class="section-header text-center">
            <h2 style="color: <?php echo h($contact['intro']['colors']['title']); ?>;" data-edit-path="intro.title"><?php echo h($contact['intro']['title']); ?></h2>
            <p data-edit-path="intro.text"><?php echo h($contact['intro']['text']); ?></p>
        </div>
        
        <div class="row contact-info" style="background-color: <?php echo h($contact['info']['colors']['background']); ?>; color: <?php echo h($contact['info']['colors']['text']); ?>;">
            <div class="col-md-4">
                <div class="contact-card">
                    <div class="contact-icon">☎</div>
                    <h3 style="color: <?php echo h($contact['info']['colors']['title']); ?>;"><?php echo h($contact['info']['phone']['label']); ?></h3>
                    <p>
                        <a href="<?php echo h($contact['info']['phone']['link']); ?>">
                            <?php echo h($contact['info']['phone']['value']); ?>
                        </a>
                    </p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="contact-card">
                    <div class="contact-icon">@</div>
                    <h3 style="color: <?php echo h($contact['info']['colors']['title']); ?>;"><?php echo h($contact['info']['email']['label']); ?></h3>
                    <p>
                        <a href="<?php echo h($contact['info']['email']['link']); ?>">
                            <?php echo h($contact['info']['email']['value']); ?>
                        </a>
                    </p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="contact-card">
                    <div class="contact-icon">⌂</div>
                    <h3 style="color: <?php echo h($contact['info']['colors']['title']); ?>;"><?php echo h($contact['info']['address']['label']); ?></h3>
                    <p>
                        <?php echo h($contact['info']['address']['street']); ?><br>
                        <?php echo h($contact['info']['address']['city']); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section hours-section" style="background-color: <?php echo h($contact['hours']['colors']['background']); ?>; color: <?php echo h($contact['hours']['colors']['text']); ?>;">
    <div class="container">
        <h2 class="text-center" style="color: <?php echo h($contact['hours']['colors']['title']); ?>;" data-edit-path="hours.title"><?php echo h($contact['hours']['title']); ?></h2>
        <div class="hours-list">
            <?php foreach ($contact['hours']['schedule'] as $hIndex => $schedule): ?>
                <p data-edit-path="hours.schedule.<?php echo $hIndex; ?>"><?php echo h($schedule); ?></p>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
