<?php
require_once 'functions.php';
$content = loadContent();
$overOns = $content['over_ons'];
$pageTitle = 'Over Ons';
include 'includes/header.php';
?>

<section class="hero" style="background-image: url('<?php echo h($overOns['hero']['image']); ?>');">
    <div class="hero-overlay">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title"><?php echo h($overOns['hero']['title']); ?></h1>
                <p class="hero-subtitle"><?php echo h($overOns['hero']['subtitle']); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="section story-section">
    <div class="container">
        <h2><?php echo h($overOns['story']['title']); ?></h2>
        <?php foreach ($overOns['story']['paragraphs'] as $paragraph): ?>
            <p><?php echo h($paragraph); ?></p>
        <?php endforeach; ?>
    </div>
</section>

<section class="section founder-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo h($overOns['founder']['image']); ?>" 
                     alt="<?php echo h($overOns['founder']['name']); ?>" 
                     class="founder-image">
            </div>
            <div class="col-md-8">
                <h2><?php echo h($overOns['founder']['name']); ?></h2>
                <p class="founder-title"><?php echo h($overOns['founder']['title']); ?></p>
                <blockquote class="founder-quote">
                    "<?php echo h($overOns['founder']['quote']); ?>"
                </blockquote>
            </div>
        </div>
    </div>
</section>

<section class="section values-section">
    <div class="container">
        <h2 class="text-center">Onze Waarden</h2>
        <div class="values-grid">
            <?php foreach ($overOns['values'] as $value): ?>
                <div class="value-card">
                    <h3><?php echo h($value['title']); ?></h3>
                    <p><?php echo h($value['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section cta-section">
    <div class="container text-center">
        <h2>Wilt u ons beter leren kennen?</h2>
        <p>Neem contact met ons op voor een vrijblijvend gesprek.</p>
        <a href="/contact.php" class="btn btn-primary">Neem contact op</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
