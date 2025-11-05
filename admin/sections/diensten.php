<div class="form-section">
    <div class="page-title">
        <h2>Onze Diensten</h2>
        <a href="/diensten.php" target="_blank" class="preview-link">Bekijk Pagina</a>
    </div>
    <div class="info-box">
        <p>Bewerk de diensten die u aanbiedt. Momenteel zijn er <?php echo count($content['diensten']['services']); ?> dienst(en) zichtbaar op de website.</p>
    </div>
    
    <form method="POST" id="diensten-form">
        <input type="hidden" name="section" value="diensten">
        <input type="hidden" name="service_count" id="service_count" value="<?php echo count($content['diensten']['services']); ?>">
        
        <h3>Hero Sectie</h3>
        
        <div class="form-group">
            <label>Hero Titel</label>
            <input type="text" name="hero_title" value="<?php echo h($content['diensten']['hero']['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Hero Ondertitel</label>
            <input type="text" name="hero_subtitle" value="<?php echo h($content['diensten']['hero']['subtitle']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Hero Achtergrond Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="hero_image" id="diensten_hero_image" value="<?php echo h($content['diensten']['hero']['image']); ?>" required>
                <button type="button" class="btn btn-secondary" data-media-input="diensten_hero_image">Bladeren</button>
            </div>
            <small>Pad: assets/images/hero-diensten.jpg</small>
        </div>
        
        <h3>Diensten <button type="button" class="btn btn-success btn-sm" id="add-service-btn" style="margin-left: 10px;">+ Nieuwe Dienst Toevoegen</button></h3>
        
        <div id="services-container">
        <?php foreach ($content['diensten']['services'] as $index => $service): ?>
            <div class="service-block" data-service-index="<?php echo $index; ?>" style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 5px; position: relative;">
                <button type="button" class="btn btn-danger btn-sm remove-service-btn" style="position: absolute; top: 10px; right: 10px;">✕ Verwijderen</button>
                <h4>Dienst <?php echo $index + 1; ?>: <?php echo h($service['title']); ?></h4>
            
                <div class="form-group">
                    <label>Dienst Naam</label>
                    <input type="text" name="service_title_<?php echo $index; ?>" value="<?php echo h($service['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Dienst Beschrijving</label>
                    <textarea name="service_desc_<?php echo $index; ?>" required><?php echo h($service['description']); ?></textarea>
                    <small>Uitleg over deze dienst</small>
                </div>
                
                <div class="form-group">
                    <label>Dienst Afbeelding</label>
                    <div class="image-input-group">
                        <input type="text" name="service_image_<?php echo $index; ?>" id="service_image_<?php echo $index; ?>" value="<?php echo h($service['image']); ?>" required>
                        <button type="button" class="btn btn-secondary" data-media-input="service_image_<?php echo $index; ?>">Bladeren</button>
                    </div>
                    <small>Pad: assets/images/service-<?php echo $index + 1; ?>.jpg</small>
                </div>
                
                <div class="form-group">
                    <label>Features (één per regel)</label>
                    <textarea name="service_features_<?php echo $index; ?>" rows="4"><?php echo implode("\n", $service['features']); ?></textarea>
                    <small>Voer elke feature op een nieuwe regel in</small>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
            <button type="reset" class="btn btn-secondary">Annuleren</button>
        </div>
    </form>
    
    <form method="POST" style="margin-top: 30px;">
        <input type="hidden" name="section" value="diensten_colors">
        
        <h3>Sectie Kleuren (Diensten Pagina)</h3>
        <div class="info-box" style="margin-bottom: 20px;">
            <p>Pas de kleuren aan per sectie op de Diensten pagina.</p>
        </div>
        
        <h4>Algemene Pagina Instellingen</h4>
        <div class="form-group">
            <label>Pagina Achtergrond Kleur</label>
            <div class="color-input-group">
                <input type="color" name="page_bg" value="<?php echo h($content['diensten']['colors']['page_background'] ?? '#ffffff'); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['diensten']['colors']['page_background'] ?? '#ffffff'); ?>" readonly class="color-text-input">
            </div>
            <small>De algemene achtergrondkleur van de Diensten pagina</small>
        </div>
        
        <h4>Hero Sectie (Banner Bovenaan)</h4>
        <div class="form-group">
            <label>Hero Achtergrond</label>
            <div class="color-input-group">
                <input type="color" name="hero_bg" value="<?php echo h($content['diensten']['hero']['colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['diensten']['hero']['colors']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Hero Tekst Kleur</label>
            <div class="color-input-group">
                <input type="color" name="hero_text" value="<?php echo h($content['diensten']['hero']['colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['diensten']['hero']['colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Hero Overlay</label>
            <input type="text" name="hero_overlay" value="<?php echo h($content['diensten']['hero']['colors']['overlay']); ?>" placeholder="rgba(0, 0, 0, 0.5)">
        </div>
        
        <?php foreach ($content['diensten']['services'] as $index => $service): ?>
            <h4>Dienst <?php echo $index + 1; ?>: <?php echo h($service['title']); ?></h4>
            
            <div class="form-group">
                <label>Achtergrond Kleur</label>
                <div class="color-input-group">
                    <input type="color" name="service_bg_<?php echo $index; ?>" value="<?php echo h($service['colors']['background']); ?>" class="color-picker-input">
                    <input type="text" value="<?php echo h($service['colors']['background']); ?>" readonly class="color-text-input">
                </div>
            </div>
            
            <div class="form-group">
                <label>Tekst Kleur</label>
                <div class="color-input-group">
                    <input type="color" name="service_text_<?php echo $index; ?>" value="<?php echo h($service['colors']['text']); ?>" class="color-picker-input">
                    <input type="text" value="<?php echo h($service['colors']['text']); ?>" readonly class="color-text-input">
                </div>
            </div>
            
            <div class="form-group">
                <label>Titel Kleur</label>
                <div class="color-input-group">
                    <input type="color" name="service_title_<?php echo $index; ?>" value="<?php echo h($service['colors']['title']); ?>" class="color-picker-input">
                    <input type="text" value="<?php echo h($service['colors']['title']); ?>" readonly class="color-text-input">
                </div>
            </div>
        <?php endforeach; ?>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Kleuren Opslaan</button>
        </div>
    </form>
</div>
