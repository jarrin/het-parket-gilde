<?php
require_once 'functions.php';
$content = loadContent();
$contact = $content['contact'];
$pageTitle = 'Contact';
include 'includes/header.php';
?>

<section class="hero" style="<?php if (!empty($contact['hero']['image']) && file_exists($contact['hero']['image'])): ?>background-image: url('<?php echo h($contact['hero']['image']); ?>');<?php endif; ?> background-color: <?php echo h($contact['hero']['colors']['background']); ?>;" data-edit-image="hero.image">
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
        
        <div class="contact-info-wrapper">
            <?php if (!empty($contact['info']['items']) && count($contact['info']['items']) > 3): ?>
            <button class="contact-scroll-btn contact-scroll-left" onclick="scrollContactCards('left')" aria-label="Scroll links">‹</button>
            <button class="contact-scroll-btn contact-scroll-right" onclick="scrollContactCards('right')" aria-label="Scroll rechts">›</button>
            <?php endif; ?>
            
            <div class="contact-info-scroll" id="contactInfoScroll" style="background-color: <?php echo h($contact['info']['colors']['background']); ?>; color: <?php echo h($contact['info']['colors']['text']); ?>;">
                <?php if (!empty($contact['info']['items'])): ?>
                    <?php foreach ($contact['info']['items'] as $item): ?>
                        <div class="contact-card">
                            <div class="contact-icon"><?php echo h($item['icon']); ?></div>
                            <h3 style="color: <?php echo h($contact['info']['colors']['title']); ?>;"><?php echo h($item['label']); ?></h3>
                            <p>
                                <?php if (!empty($item['link'])): ?>
                                    <a href="<?php echo h($item['link']); ?>" style="color: <?php echo h($contact['info']['colors']['text']); ?> !important;">
                                        <?php echo nl2br(h($item['value'])); ?>
                                    </a>
                                <?php else: ?>
                                    <span style="color: <?php echo h($contact['info']['colors']['text']); ?> !important;">
                                        <?php echo nl2br(h($item['value'])); ?>
                                    </span>
                                <?php endif; ?>
                            </p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
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

<section class="section cta-section" style="background-image: url('<?php echo h($contact['cta']['image']); ?>'); background-color: <?php echo h($contact['cta']['colors']['background']); ?>;" data-edit-image="cta.image">
    <div class="container text-center">
        <h2 style="color: <?php echo h($contact['cta']['colors']['text']); ?>;" data-edit-path="cta.title"><?php echo h($contact['cta']['title']); ?></h2>
        <p style="color: <?php echo h($contact['cta']['colors']['text']); ?>;" data-edit-path="cta.subtitle"><?php echo h($contact['cta']['subtitle']); ?></p>
        <a href="<?php echo h($contact['cta']['button_link']); ?>" class="btn btn-primary"><?php echo h($contact['cta']['button_text']); ?></a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
