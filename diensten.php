<?php
require_once 'functions.php';
$content = loadContent();
$diensten = $content['diensten'];
$pageTitle = 'Onze Diensten';
include 'includes/header.php';
?>

<section class="hero" style="background-image: url('<?php echo h($diensten['hero']['image']); ?>'); background-color: <?php echo h($diensten['hero']['colors']['background']); ?>;" data-edit-image="hero.image">
    <div class="hero-overlay" style="background: <?php echo h($diensten['hero']['colors']['overlay']); ?>;">
        <div class="container">
            <div class="hero-content" style="color: <?php echo h($diensten['hero']['colors']['text']); ?>;">
                <h1 class="hero-title" data-edit-path="hero.title"><?php echo h($diensten['hero']['title']); ?></h1>
                <p class="hero-subtitle" data-edit-path="hero.subtitle"><?php echo h($diensten['hero']['subtitle']); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="section services-section">
    <div class="container">
        <?php foreach ($diensten['services'] as $index => $service): ?>
            <div class="service-item <?php echo $index % 2 === 0 ? 'service-left' : 'service-right'; ?>" style="background-color: <?php echo h($service['colors']['background']); ?>; color: <?php echo h($service['colors']['text']); ?>;">
                <div class="row">
                    <div class="col-md-6 <?php echo $index % 2 === 0 ? '' : 'order-md-2'; ?>">
                        <img src="<?php echo h($service['image']); ?>" 
                             alt="<?php echo h($service['title']); ?>" 
                             class="service-image"
                             data-edit-image="services.<?php echo $index; ?>.image">
                    </div>
                    <div class="col-md-6 <?php echo $index % 2 === 0 ? '' : 'order-md-1'; ?>">
                        <div class="service-content">
                            <h2 style="color: <?php echo h($service['colors']['title']); ?>;" data-edit-path="services.<?php echo $index; ?>.title"><?php echo h($service['title']); ?></h2>
                            <p data-edit-path="services.<?php echo $index; ?>.description"><?php echo h($service['description']); ?></p>
                            <ul class="service-features">
                                <?php foreach ($service['features'] as $fIndex => $feature): ?>
                                    <li data-edit-path="services.<?php echo $index; ?>.features.<?php echo $fIndex; ?>"><?php echo h($feature); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section cta-section">
    <div class="container text-center">
        <h2>Interesse in onze diensten?</h2>
        <p>Neem vrijblijvend contact met ons op voor meer informatie of een offerte op maat.</p>
        <a href="/contact.php" class="btn btn-primary">Contact opnemen</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
