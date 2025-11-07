<div class="form-section">
    <div class="page-title">
        <h2>Over Ons</h2>
        <a href="/over-ons.php" target="_blank" class="preview-link">Bekijk Pagina</a>
    </div>
    <div class="info-box">
        <p>Vertel uw verhaal. Laat klanten kennismaken met uw bedrijf en de mensen erachter.</p>
    </div>
    
    <form method="POST" id="over-ons-form">
        <input type="hidden" name="section" value="over_ons">
        <input type="hidden" name="value_count" id="value_count" value="<?php echo count($content['over_ons']['values']); ?>">
        
        <h3>Hero Sectie</h3>
        
        <div class="form-group">
            <label>Hero Titel</label>
            <input type="text" name="hero_title" value="<?php echo h($content['over_ons']['hero']['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Hero Ondertitel</label>
            <input type="text" name="hero_subtitle" value="<?php echo h($content['over_ons']['hero']['subtitle']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Hero Achtergrond Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="hero_image" id="over_ons_hero_image" value="<?php echo h($content['over_ons']['hero']['image']); ?>" required>
                <button type="button" class="btn btn-secondary" data-media-input="over_ons_hero_image">Bladeren</button>
            </div>
            <small>Pad: assets/images/hero-over-ons.jpg</small>
        </div>
        
        <h3>Het Verhaal</h3>
        
        <div class="form-group">
            <label>Verhaal Titel</label>
            <input type="text" name="story_title" value="<?php echo h($content['over_ons']['story']['title']); ?>" required>
        </div>
        
        <?php foreach ($content['over_ons']['story']['paragraphs'] as $pIndex => $paragraph): ?>
        <div class="form-group">
            <label>Paragraaf <?php echo $pIndex + 1; ?></label>
            <textarea name="story_paragraph_<?php echo $pIndex; ?>" rows="4" required><?php echo h($paragraph); ?></textarea>
        </div>
        <?php endforeach; ?>
        
        <h3>Oprichter Sectie</h3>
        
        <div class="form-group">
            <label>Naam</label>
            <input type="text" name="founder_name" value="<?php echo h($content['over_ons']['founder']['name']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Functie</label>
            <input type="text" name="founder_title" value="<?php echo h($content['over_ons']['founder']['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Persoonlijke Quote</label>
            <textarea name="founder_quote" rows="3" required><?php echo h($content['over_ons']['founder']['quote']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Oprichter Foto</label>
            <div class="image-input-group">
                <input type="text" name="founder_image" id="founder_image" value="<?php echo h($content['over_ons']['founder']['image']); ?>" required>
                <button type="button" class="btn btn-secondary" data-media-input="founder_image">Bladeren</button>
            </div>
            <small>Aanbevolen: portretfoto (bijv. 400x400px)</small>
        </div>
        
        <h3>Onze Waarden <button type="button" class="btn btn-success btn-sm" id="add-value-btn" style="margin-left: 10px;">+ Nieuwe Waarde Toevoegen</button></h3>
        
        <div id="values-container">
        <?php foreach ($content['over_ons']['values'] as $index => $value): ?>
            <div class="value-block" data-value-index="<?php echo $index; ?>" style="border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 5px; position: relative;">
                <button type="button" class="btn btn-danger btn-sm remove-value-btn" style="position: absolute; top: 10px; right: 10px;">✕ Verwijderen</button>
                <h4>Waarde <?php echo $index + 1; ?>: <?php echo h($value['title']); ?></h4>
            
                <div class="form-group">
                    <label>Waarde Titel</label>
                    <input type="text" name="value_title_<?php echo $index; ?>" value="<?php echo h($value['title']); ?>" required>
                </div>
                
                <div class="form-group">
                    <label>Waarde Beschrijving</label>
                    <textarea name="value_description_<?php echo $index; ?>" rows="3" required><?php echo h($value['description']); ?></textarea>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
        
        <h3>CTA Sectie</h3>
        
        <div class="form-group">
            <label>CTA Titel</label>
            <input type="text" name="cta_title" value="<?php echo h($content['over_ons']['cta']['title']); ?>">
        </div>
        
        <div class="form-group">
            <label>CTA Ondertitel</label>
            <textarea name="cta_subtitle" rows="3"><?php echo h($content['over_ons']['cta']['subtitle']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Button Tekst</label>
            <input type="text" name="cta_button_text" value="<?php echo h($content['over_ons']['cta']['button_text']); ?>">
        </div>
        
        <div class="form-group">
            <label>Button Link</label>
            <input type="text" name="cta_button_link" value="<?php echo h($content['over_ons']['cta']['button_link']); ?>">
            <small>Gebruik /contact.php voor contact pagina</small>
        </div>
        
        <div class="form-group">
            <label>CTA Achtergrond Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="cta_image" id="over_ons_cta_image" value="<?php echo h($content['over_ons']['cta']['image']); ?>">
                <button type="button" class="btn btn-secondary" data-media-input="over_ons_cta_image">Bladeren</button>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
            <button type="reset" class="btn btn-secondary">Annuleren</button>
        </div>
    </form>
    
    <form method="POST" style="margin-top: 30px;">
        <input type="hidden" name="section" value="over_ons_colors">
        
        <h3>Sectie Kleuren (Over Ons Pagina)</h3>
        <div class="info-box" style="margin-bottom: 20px;">
            <p>Pas de kleuren aan per sectie op de Over Ons pagina.</p>
        </div>
        
        <h4>Hero Sectie</h4>
        <div class="form-group">
            <label>Hero Achtergrond</label>
            <div class="color-input-group">
                <input type="color" name="hero_bg" value="<?php echo h($content['over_ons']['hero']['colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['hero']['colors']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Hero Tekst Kleur</label>
            <div class="color-input-group">
                <input type="color" name="hero_text" value="<?php echo h($content['over_ons']['hero']['colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['hero']['colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Hero Overlay</label>
            <input type="text" name="hero_overlay" value="<?php echo h($content['over_ons']['hero']['colors']['overlay']); ?>" placeholder="rgba(0, 0, 0, 0.5)">
        </div>
        
        <h4>Verhaal Sectie</h4>
        <div class="form-group">
            <label>Achtergrond Kleur</label>
            <div class="color-input-group">
                <input type="color" name="story_bg" value="<?php echo h($content['over_ons']['story']['colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['story']['colors']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Tekst Kleur</label>
            <div class="color-input-group">
                <input type="color" name="story_text" value="<?php echo h($content['over_ons']['story']['colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['story']['colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Titel Kleur</label>
            <div class="color-input-group">
                <input type="color" name="story_title" value="<?php echo h($content['over_ons']['story']['colors']['title']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['story']['colors']['title']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <h4>Oprichter Sectie</h4>
        <div class="form-group">
            <label>Achtergrond Kleur</label>
            <div class="color-input-group">
                <input type="color" name="founder_bg" value="<?php echo h($content['over_ons']['founder']['colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['founder']['colors']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Tekst Kleur</label>
            <div class="color-input-group">
                <input type="color" name="founder_text" value="<?php echo h($content['over_ons']['founder']['colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['founder']['colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Titel Kleur</label>
            <div class="color-input-group">
                <input type="color" name="founder_title" value="<?php echo h($content['over_ons']['founder']['colors']['title']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['founder']['colors']['title']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <h4>Waarden Sectie</h4>
        <div class="form-group">
            <label>Achtergrond Kleur</label>
            <div class="color-input-group">
                <input type="color" name="values_bg" value="<?php echo h($content['over_ons']['values_colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['values_colors']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Tekst Kleur</label>
            <div class="color-input-group">
                <input type="color" name="values_text" value="<?php echo h($content['over_ons']['values_colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['values_colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Titel Kleur</label>
            <div class="color-input-group">
                <input type="color" name="values_title" value="<?php echo h($content['over_ons']['values_colors']['title']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['values_colors']['title']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <h4>CTA Sectie</h4>
        <div class="form-group">
            <label>Achtergrondkleur</label>
            <div class="color-input-group">
                <input type="color" name="cta_bg" value="<?php echo h($content['over_ons']['cta']['colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['cta']['colors']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Tekstkleur</label>
            <div class="color-input-group">
                <input type="color" name="cta_text" value="<?php echo h($content['over_ons']['cta']['colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['over_ons']['cta']['colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Kleuren Opslaan</button>
        </div>
    </form>
</div>

<script>
// Add new value functionality
let valueIndex = <?php echo count($content['over_ons']['values']); ?>;

document.getElementById('add-value-btn').addEventListener('click', function() {
    const container = document.getElementById('values-container');
    const newBlock = document.createElement('div');
    newBlock.className = 'value-block';
    newBlock.setAttribute('data-value-index', valueIndex);
    newBlock.style.cssText = 'border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 5px; position: relative;';
    
    newBlock.innerHTML = `
        <button type="button" class="btn btn-danger btn-sm remove-value-btn" style="position: absolute; top: 10px; right: 10px;">✕ Verwijderen</button>
        <h4>Waarde ${valueIndex + 1}: Nieuwe Waarde</h4>
        
        <div class="form-group">
            <label>Waarde Titel</label>
            <input type="text" name="value_title_${valueIndex}" value="" required>
        </div>
        
        <div class="form-group">
            <label>Waarde Beschrijving</label>
            <textarea name="value_description_${valueIndex}" rows="3" required></textarea>
        </div>
    `;
    
    container.appendChild(newBlock);
    valueIndex++;
    document.getElementById('value_count').value = valueIndex;
});

// Remove value functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-value-btn')) {
        if (confirm('Weet u zeker dat u deze waarde wilt verwijderen?')) {
            e.target.closest('.value-block').remove();
            // Update value count
            const remainingValues = document.querySelectorAll('.value-block').length;
            document.getElementById('value_count').value = remainingValues;
        }
    }
});
</script>
