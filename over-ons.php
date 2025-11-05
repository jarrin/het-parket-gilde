<?php
require_once 'functions.php';
$content = loadContent();
$overOns = $content['over_ons'];
$pageTitle = 'Over Ons';
include 'includes/header.php';
?>

<section class="hero" style="background-image: url('<?php echo h($overOns['hero']['image']); ?>'); background-color: <?php echo h($overOns['hero']['colors']['background']); ?>;" data-edit-image="hero.image">
    <div class="hero-overlay" style="background: <?php echo h($overOns['hero']['colors']['overlay']); ?>;">
        <div class="container">
            <div class="hero-content" style="color: <?php echo h($overOns['hero']['colors']['text']); ?>;">
                <h1 class="hero-title" data-edit-path="hero.title"><?php echo h($overOns['hero']['title']); ?></h1>
                <p class="hero-subtitle" data-edit-path="hero.subtitle"><?php echo h($overOns['hero']['subtitle']); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="section story-section" style="background-color: <?php echo h($overOns['story']['colors']['background']); ?>; color: <?php echo h($overOns['story']['colors']['text']); ?>;">
    <div class="container">
        <h2 style="color: <?php echo h($overOns['story']['colors']['title']); ?>;" data-edit-path="story.title"><?php echo h($overOns['story']['title']); ?></h2>
        <?php foreach ($overOns['story']['paragraphs'] as $pIndex => $paragraph): ?>
            <p data-edit-path="story.paragraphs.<?php echo $pIndex; ?>"><?php echo h($paragraph); ?></p>
        <?php endforeach; ?>
    </div>
</section>

<section class="section founder-section" style="background-color: <?php echo h($overOns['founder']['colors']['background']); ?>; color: <?php echo h($overOns['founder']['colors']['text']); ?>;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <img src="<?php echo h($overOns['founder']['image']); ?>" 
                     alt="<?php echo h($overOns['founder']['name']); ?>" 
                     class="founder-image"
                     data-edit-image="founder.image">
            </div>
            <div class="col-md-8">
                <h2 style="color: <?php echo h($overOns['founder']['colors']['title']); ?>;" data-edit-path="founder.name"><?php echo h($overOns['founder']['name']); ?></h2>
                <p class="founder-title" data-edit-path="founder.title"><?php echo h($overOns['founder']['title']); ?></p>
                <blockquote class="founder-quote" data-edit-path="founder.quote">
                    "<?php echo h($overOns['founder']['quote']); ?>"
                </blockquote>
            </div>
        </div>
    </div>
</section>

<section class="section values-section" style="background-color: <?php echo h($overOns['values_colors']['background']); ?>; color: <?php echo h($overOns['values_colors']['text']); ?>;">
    <div class="container">
        <h2 class="text-center" style="color: <?php echo h($overOns['values_colors']['title']); ?>;">Onze Waarden</h2>
        <div class="values-grid">
            <?php foreach ($overOns['values'] as $vIndex => $value): ?>
                <div class="value-card">
                    <h3 style="color: <?php echo h($overOns['values_colors']['title']); ?>;" data-edit-path="values.<?php echo $vIndex; ?>.title"><?php echo h($value['title']); ?></h3>
                    <p data-edit-path="values.<?php echo $vIndex; ?>.description"><?php echo h($value['description']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section cta-section" style="background-image: url('<?php echo h($overOns['cta']['image']); ?>'); background-color: <?php echo h($overOns['cta']['colors']['background']); ?>;" data-edit-image="cta.image">
    <div class="container text-center">
        <h2 style="color: <?php echo h($overOns['cta']['colors']['text']); ?>;" data-edit-path="cta.title"><?php echo h($overOns['cta']['title']); ?></h2>
        <p style="color: <?php echo h($overOns['cta']['colors']['text']); ?>;" data-edit-path="cta.subtitle"><?php echo h($overOns['cta']['subtitle']); ?></p>
        <a href="<?php echo h($overOns['cta']['button_link']); ?>" class="btn btn-primary"><?php echo h($overOns['cta']['button_text']); ?></a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
