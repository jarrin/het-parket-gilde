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
            <input type="text" name="hero_image" id="contact_hero_image" value="<?php echo h($content['contact']['hero']['image']); ?>">
            <button type="button" class="btn btn-secondary" data-media-input="contact_hero_image">Bladeren</button>
        </div>
        <small>Upload een afbeelding via de Media Manager (aanbevolen: 1920x500px)</small>
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
    
    <h3>Contactgegevens</h3>
    
    <div class="info-box">
        <p>Beheer de contactinformatie boxen. Voeg boxen toe, bewerk of verwijder ze.</p>
    </div>
    
    <div id="contactItemsContainer">
        <?php 
        $items = $content['contact']['info']['items'] ?? [];
        foreach ($items as $index => $item): 
        ?>
        <div class="contact-item-group" data-index="<?php echo $index; ?>">
            <div class="contact-item-header">
                <h4>Contact Box <?php echo $index + 1; ?></h4>
                <button type="button" class="btn btn-danger btn-sm" onclick="removeContactItem(<?php echo $index; ?>)">Verwijderen</button>
            </div>
            
            <div class="form-group">
                <label>Label</label>
                <input type="text" name="contact_item_label_<?php echo $index; ?>" value="<?php echo h($item['label']); ?>" required>
                <small>Bijvoorbeeld: Telefoon, E-mail, Adres</small>
            </div>
            
            <div class="form-group">
                <label>Icoon</label>
                <input type="text" name="contact_item_icon_<?php echo $index; ?>" value="<?php echo h($item['icon']); ?>" required>
                <small>Emoji of karakter voor het icoon (bijvoorbeeld: ☎, @, ⌂, 📱, 🏢)</small>
            </div>
            
            <div class="form-group">
                <label>Waarde</label>
                <textarea name="contact_item_value_<?php echo $index; ?>" rows="2" required><?php echo h($item['value']); ?></textarea>
                <small>De inhoud die wordt weergegeven. Gebruik Enter voor meerdere regels.</small>
            </div>
            
            <div class="form-group">
                <label>Link (optioneel)</label>
                <input type="text" name="contact_item_link_<?php echo $index; ?>" value="<?php echo h($item['link'] ?? ''); ?>">
                <small>Bijvoorbeeld: tel:+31612345678, mailto:info@example.nl, of laat leeg voor geen link</small>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <input type="hidden" name="contact_items_count" id="contactItemsCount" value="<?php echo count($items); ?>">
    
    <div class="form-group">
        <button type="button" class="btn btn-secondary" onclick="addContactItem()">+ Voeg Contact Box Toe</button>
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
            <label>Pagina Achtergrondkleur</label>
            <div class="color-input-group">
                <input type="color" id="contact_color_section_bg" name="color_section_bg" value="<?php echo h($content['contact']['colors']['sectionBg']); ?>">
                <input type="text" id="contact_text_section_bg" value="<?php echo h($content['contact']['colors']['sectionBg']); ?>" readonly>
            </div>
            <small>De algemene achtergrondkleur van de hele pagina</small>
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

<form method="POST" style="margin-top: 30px;">
    <input type="hidden" name="section" value="contact_cta">
    
    <h3>CTA Sectie Bewerken</h3>
    <div class="info-box" style="margin-bottom: 20px;">
        <p>Pas de Call-to-Action sectie onderaan de pagina aan.</p>
    </div>
    
    <div class="form-group">
        <label>Titel</label>
        <input type="text" name="cta_title" value="<?php echo h($content['contact']['cta']['title'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label>Ondertitel</label>
        <textarea name="cta_subtitle" rows="3"><?php echo h($content['contact']['cta']['subtitle'] ?? ''); ?></textarea>
    </div>
    
    <div class="form-group">
        <label>Button Tekst</label>
        <input type="text" name="cta_button_text" value="<?php echo h($content['contact']['cta']['button_text'] ?? ''); ?>">
    </div>
    
    <div class="form-group">
        <label>Button Link</label>
        <input type="text" name="cta_button_link" value="<?php echo h($content['contact']['cta']['button_link'] ?? ''); ?>">
        <small>Gebruik tel:+31612345678 voor telefoonlink of mailto:email@voorbeeld.nl voor email</small>
    </div>
    
    <div class="form-group">
        <label>CTA Achtergrond Afbeelding</label>
        <div class="image-input-group">
            <input type="text" name="cta_image" id="contact_cta_image" value="<?php echo h($content['contact']['cta']['image'] ?? ''); ?>">
            <button type="button" class="btn btn-secondary" data-media-input="contact_cta_image">Bladeren</button>
        </div>
        <small>Optioneel - achtergrondafbeelding voor de CTA sectie (aanbevolen: 1920x400px)</small>
    </div>
    
    <h4>Kleuren</h4>
    <div class="form-group">
        <label>Achtergrondkleur</label>
        <input type="color" name="cta_bg" value="<?php echo h($content['contact']['cta']['colors']['background'] ?? '#222e40'); ?>">
    </div>
    
    <div class="form-group">
        <label>Tekstkleur</label>
        <input type="color" name="cta_text" value="<?php echo h($content['contact']['cta']['colors']['text'] ?? '#ffffff'); ?>">
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">CTA Wijzigingen Opslaan</button>
    </div>
</form>
