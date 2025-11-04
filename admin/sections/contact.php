<!-- Contact Page Section -->
<div class="page-title">
    <h2>Contact Pagina</h2>
    <a href="/contact.php" target="_blank" class="preview-link">Bekijk Pagina</a>
</div>

<div class="info-box">
    <p>Beheer de contactpagina. Voor live bewerking: ga naar de pagina en klik rechtsonder op "Bewerk Pagina".</p>
</div>

<form method="POST">
    <input type="hidden" name="section" value="contact">
    
    <h3>Hero Sectie</h3>
    
    <div class="form-group">
        <label>Hero Titel</label>
        <input type="text" name="hero_title" value="<?php echo h($content['contact']['hero']['title']); ?>" required>
    </div>
    
    <div class="form-group">
        <label>Hero Ondertitel</label>
        <input type="text" name="hero_subtitle" value="<?php echo h($content['contact']['hero']['subtitle']); ?>" required>
    </div>
    
    <div class="form-group">
        <label>Hero Achtergrond Afbeelding</label>
        <div class="image-input-group">
            <input type="text" name="hero_image" id="contact_hero_image" value="<?php echo h($content['contact']['hero']['image']); ?>" required>
            <button type="button" class="btn btn-secondary" data-media-input="contact_hero_image">Bladeren</button>
        </div>
        <small>Pad: assets/images/hero-contact.jpg</small>
    </div>
    
    <h3>Intro Tekst</h3>
    
    <div class="form-group">
        <label>Intro Titel</label>
        <input type="text" name="intro_title" value="<?php echo h($content['contact']['intro']['title']); ?>" required>
    </div>
    
    <div class="form-group">
        <label>Intro Tekst</label>
        <textarea name="intro_text" rows="3" required><?php echo h($content['contact']['intro']['text']); ?></textarea>
    </div>
    
    <h3>Openingstijden</h3>
    
    <div class="form-group">
        <label>Openingstijden Titel</label>
        <input type="text" name="hours_title" value="<?php echo h($content['contact']['hours']['title']); ?>" required>
    </div>
    
    <?php foreach ($content['contact']['hours']['schedule'] as $index => $schedule): ?>
        <div class="form-group">
            <label>Openingstijd <?php echo $index + 1; ?></label>
            <input type="text" name="schedule_<?php echo $index; ?>" value="<?php echo h($schedule); ?>" required>
        </div>
    <?php endforeach; ?>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Opslaan</button>
    </div>
</form>

<!-- Contact Colors Form -->
<div class="section-divider"></div>

<form method="POST" class="color-form">
    <input type="hidden" name="section" value="contact_colors">
    
    <h3>Contact Pagina Kleuren</h3>
    
    <div class="info-box">
        <p>Pas de kleuren aan voor de contact pagina.</p>
    </div>
    
    <div class="color-grid">
        <!-- Page Colors -->
        <div class="form-group">
            <label>Header Kleur</label>
            <div class="color-input-group">
                <input type="color" id="contact_color_header" name="color_header" value="<?php echo h($content['contact']['colors']['header']); ?>">
                <input type="text" id="contact_text_header" value="<?php echo h($content['contact']['colors']['header']); ?>" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label>Hero Tekst Kleur</label>
            <div class="color-input-group">
                <input type="color" id="contact_color_hero_text" name="color_hero_text" value="<?php echo h($content['contact']['colors']['heroText']); ?>">
                <input type="text" id="contact_text_hero_text" value="<?php echo h($content['contact']['colors']['heroText']); ?>" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label>Sectie Achtergrond</label>
            <div class="color-input-group">
                <input type="color" id="contact_color_section_bg" name="color_section_bg" value="<?php echo h($content['contact']['colors']['sectionBg']); ?>">
                <input type="text" id="contact_text_section_bg" value="<?php echo h($content['contact']['colors']['sectionBg']); ?>" readonly>
            </div>
        </div>
        
        <!-- Hero Colors -->
        <div class="form-group">
            <label>Hero Achtergrond</label>
            <div class="color-input-group">
                <input type="color" name="hero_bg" value="<?php echo h($content['contact']['hero']['colors']['background']); ?>">
                <input type="text" value="<?php echo h($content['contact']['hero']['colors']['background']); ?>" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label>Hero Tekst</label>
            <div class="color-input-group">
                <input type="color" name="hero_text" value="<?php echo h($content['contact']['hero']['colors']['text']); ?>">
                <input type="text" value="<?php echo h($content['contact']['hero']['colors']['text']); ?>" readonly>
            </div>
        </div>
        
        <!-- Intro Colors -->
        <div class="form-group">
            <label>Intro Achtergrond</label>
            <div class="color-input-group">
                <input type="color" name="intro_bg" value="<?php echo h($content['contact']['intro']['colors']['background']); ?>">
                <input type="text" value="<?php echo h($content['contact']['intro']['colors']['background']); ?>" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label>Intro Tekst</label>
            <div class="color-input-group">
                <input type="color" name="intro_text" value="<?php echo h($content['contact']['intro']['colors']['text']); ?>">
                <input type="text" value="<?php echo h($content['contact']['intro']['colors']['text']); ?>" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label>Intro Titel</label>
            <div class="color-input-group">
                <input type="color" name="intro_title" value="<?php echo h($content['contact']['intro']['colors']['title']); ?>">
                <input type="text" value="<?php echo h($content['contact']['intro']['colors']['title']); ?>" readonly>
            </div>
        </div>
        
        <!-- Info Colors -->
        <div class="form-group">
            <label>Info Achtergrond</label>
            <div class="color-input-group">
                <input type="color" name="info_bg" value="<?php echo h($content['contact']['info']['colors']['background']); ?>">
                <input type="text" value="<?php echo h($content['contact']['info']['colors']['background']); ?>" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label>Info Tekst</label>
            <div class="color-input-group">
                <input type="color" name="info_text" value="<?php echo h($content['contact']['info']['colors']['text']); ?>">
                <input type="text" value="<?php echo h($content['contact']['info']['colors']['text']); ?>" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label>Info Titel</label>
            <div class="color-input-group">
                <input type="color" name="info_title" value="<?php echo h($content['contact']['info']['colors']['title']); ?>">
                <input type="text" value="<?php echo h($content['contact']['info']['colors']['title']); ?>" readonly>
            </div>
        </div>
        
        <!-- Hours Colors -->
        <div class="form-group">
            <label>Openingstijden Achtergrond</label>
            <div class="color-input-group">
                <input type="color" name="hours_bg" value="<?php echo h($content['contact']['hours']['colors']['background']); ?>">
                <input type="text" value="<?php echo h($content['contact']['hours']['colors']['background']); ?>" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label>Openingstijden Tekst</label>
            <div class="color-input-group">
                <input type="color" name="hours_text" value="<?php echo h($content['contact']['hours']['colors']['text']); ?>">
                <input type="text" value="<?php echo h($content['contact']['hours']['colors']['text']); ?>" readonly>
            </div>
        </div>
        
        <div class="form-group">
            <label>Openingstijden Titel</label>
            <div class="color-input-group">
                <input type="color" name="hours_title" value="<?php echo h($content['contact']['hours']['colors']['title']); ?>">
                <input type="text" value="<?php echo h($content['contact']['hours']['colors']['title']); ?>" readonly>
            </div>
        </div>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Kleuren Opslaan</button>
    </div>
</form>
