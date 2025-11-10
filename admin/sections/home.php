<div class="form-section">
    <div class="page-title">
        <h2>Home Pagina</h2>
        <a href="/index.php" target="_blank" class="preview-link">Bekijk Pagina</a>
    </div>
    <div class="info-box">
        <p>Bewerk de content van de home pagina. Dit is de eerste pagina die bezoekers zien.</p>
    </div>
    
    <form method="POST">
        <input type="hidden" name="section" value="home">
        
        <h3>Hero Sectie (Grote Banner Bovenaan)</h3>
        
        <div class="form-group">
            <label>Hero Titel</label>
            <input type="text" name="hero_title" value="<?php echo h($content['home']['hero']['title']); ?>" required>
            <small>De grote kop bovenaan de pagina</small>
        </div>
        
        <div class="form-group">
            <label>Hero Ondertitel</label>
            <input type="text" name="hero_subtitle" value="<?php echo h($content['home']['hero']['subtitle']); ?>" required>
            <small>Tekst onder de hoofdtitel</small>
        </div>
        
        <div class="form-group">
            <label>Hero Beschrijving</label>
            <textarea name="hero_description" required><?php echo h($content['home']['hero']['description']); ?></textarea>
            <small>Extra informatie onder de ondertitel</small>
        </div>
        
        <div class="form-group">
            <label>Hero Achtergrond Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="hero_image" id="hero_image" value="<?php echo h($content['home']['hero']['image']); ?>" required>
                <button type="button" class="btn btn-secondary" data-media-input="hero_image">Bladeren</button>
            </div>
            <small>Pad: assets/images/hero-home.jpg</small>
        </div>
        
        <h3>Intro Sectie (Welkom Sectie)</h3>
        
        <div class="form-group">
            <label>Intro Titel</label>
            <input type="text" name="intro_title" value="<?php echo h($content['home']['intro']['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Intro Tekst</label>
            <textarea name="intro_text" required><?php echo h($content['home']['intro']['text']); ?></textarea>
            <small>Uitgebreide welkomst tekst</small>
        </div>
        
        <div class="form-group">
            <label>Intro Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="intro_image" id="intro_image" value="<?php echo h($content['home']['intro']['image']); ?>" required>
                <button type="button" class="btn btn-secondary" data-media-input="intro_image">Bladeren</button>
            </div>
            <small>Pad: assets/images/intro.jpg</small>
        </div>
        
        <h3>Vakmanschap Sectie</h3>
        
        <div class="form-group">
            <label>Vakmanschap Titel</label>
            <input type="text" name="vak_title" value="<?php echo h($content['home']['vakmanschap']['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Vakmanschap Ondertitel</label>
            <input type="text" name="vak_subtitle" value="<?php echo h($content['home']['vakmanschap']['subtitle']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Vakmanschap Tekst</label>
            <textarea name="vak_text" required><?php echo h($content['home']['vakmanschap']['text']); ?></textarea>
        </div>
        
        <h3>Feature Boxes</h3>
        <div class="info-box">
            <p>Beheer de feature boxes in de vakmanschap sectie. U kunt boxes toevoegen, bewerken of verwijderen.</p>
        </div>
        
        <div id="feature-boxes-container">
            <?php foreach ($content['home']['vakmanschap']['features'] as $index => $feature): ?>
                <div class="feature-box-item" style="border: 2px solid #e0e0e0; padding: 20px; margin-bottom: 20px; border-radius: 8px; background: #f9f9f9;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h4 style="margin: 0;">Feature Box <?php echo $index + 1; ?>: <?php echo h($feature['title']); ?></h4>
                        <button type="button" class="btn btn-secondary" onclick="removeFeatureBox(<?php echo $index; ?>)" style="background: #dc3545; color: white; padding: 5px 15px;">Verwijderen</button>
                    </div>
                    
                    <input type="hidden" name="feature_<?php echo $index; ?>_exists" value="1">
                    
                    <div class="form-group">
                        <label>Titel</label>
                        <input type="text" name="feature_<?php echo $index; ?>_title" value="<?php echo h($feature['title']); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Beschrijving</label>
                        <textarea name="feature_<?php echo $index; ?>_description" required><?php echo h($feature['description']); ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Icon</label>
                        <input type="text" name="feature_<?php echo $index; ?>_icon" value="<?php echo h($feature['icon'] ?? '+'); ?>" placeholder="+">
                        <small>Een enkel teken of emoji</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Afbeelding</label>
                        <div class="image-input-group">
                            <input type="text" name="feature_<?php echo $index; ?>_image" id="feature_<?php echo $index; ?>_image" value="<?php echo h($feature['image'] ?? ''); ?>">
                            <button type="button" class="btn btn-secondary" data-media-input="feature_<?php echo $index; ?>_image">Bladeren</button>
                        </div>
                        <small>Optioneel - afbeelding voor deze feature box</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Tekstkleur</label>
                        <div class="color-input-group">
                            <input type="color" name="feature_<?php echo $index; ?>_text_color" value="<?php echo h($feature['text_color'] ?? '#333333'); ?>" class="color-picker-input">
                            <input type="text" value="<?php echo h($feature['text_color'] ?? '#333333'); ?>" readonly class="color-text-input">
                        </div>
                        <small>Kleur van de beschrijvingstekst in deze feature box</small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <button type="button" class="btn btn-secondary" onclick="addFeatureBox()" style="margin-bottom: 30px;">
            + Nieuwe Feature Box Toevoegen
        </button>
        
        <input type="hidden" name="feature_count" id="feature_count" value="<?php echo count($content['home']['vakmanschap']['features']); ?>">
        
        <script>
        let featureCount = <?php echo count($content['home']['vakmanschap']['features']); ?>;
        
        function addFeatureBox() {
            const container = document.getElementById('feature-boxes-container');
            const newIndex = featureCount;
            
            const boxHtml = `
                <div class="feature-box-item" style="border: 2px solid #e0e0e0; padding: 20px; margin-bottom: 20px; border-radius: 8px; background: #f9f9f9;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h4 style="margin: 0;">Feature Box ${newIndex + 1}: Nieuw</h4>
                        <button type="button" class="btn btn-secondary" onclick="removeFeatureBox(${newIndex})" style="background: #dc3545; color: white; padding: 5px 15px;">Verwijderen</button>
                    </div>
                    
                    <input type="hidden" name="feature_${newIndex}_exists" value="1">
                    
                    <div class="form-group">
                        <label>Titel</label>
                        <input type="text" name="feature_${newIndex}_title" value="" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Beschrijving</label>
                        <textarea name="feature_${newIndex}_description" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>Icon</label>
                        <input type="text" name="feature_${newIndex}_icon" value="+" placeholder="+">
                        <small>Een enkel teken of emoji</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Afbeelding</label>
                        <div class="image-input-group">
                            <input type="text" name="feature_${newIndex}_image" id="feature_${newIndex}_image" value="">
                            <button type="button" class="btn btn-secondary" data-media-input="feature_${newIndex}_image">Bladeren</button>
                        </div>
                        <small>Optioneel - afbeelding voor deze feature box</small>
                    </div>
                    
                    <div class="form-group">
                        <label>Tekstkleur</label>
                        <div class="color-input-group">
                            <input type="color" name="feature_${newIndex}_text_color" value="#333333" class="color-picker-input">
                            <input type="text" value="#333333" readonly class="color-text-input">
                        </div>
                        <small>Kleur van de beschrijvingstekst in deze feature box</small>
                    </div>
                </div>
            `;
            
            container.insertAdjacentHTML('beforeend', boxHtml);
            featureCount++;
            document.getElementById('feature_count').value = featureCount;
            
            // Re-initialize media browser buttons
            if (typeof initMediaBrowsers === 'function') {
                initMediaBrowsers();
            }
        }
        
        function removeFeatureBox(index) {
            if (confirm('Weet u zeker dat u deze feature box wilt verwijderen?')) {
                const boxes = document.querySelectorAll('.feature-box-item');
                if (boxes.length > 1) {
                    boxes[index].remove();
                    // Renumber remaining boxes
                    updateFeatureBoxNumbers();
                } else {
                    alert('U moet minimaal 1 feature box behouden.');
                }
            }
        }
        
        function updateFeatureBoxNumbers() {
            const boxes = document.querySelectorAll('.feature-box-item');
            boxes.forEach((box, idx) => {
                const title = box.querySelector('h4');
                const titleText = title.textContent.split(':')[1] || 'Nieuw';
                title.textContent = `Feature Box ${idx + 1}:${titleText}`;
            });
        }
        </script>
        
        <h3>CTA Sectie (Contact Oproep Onderaan)</h3>
        
        <div class="form-group">
            <label>CTA Titel</label>
            <input type="text" name="cta_title" value="<?php echo h($content['home']['cta']['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>CTA Ondertitel</label>
            <input type="text" name="cta_subtitle" value="<?php echo h($content['home']['cta']['subtitle']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>CTA Knop Tekst</label>
            <input type="text" name="cta_button_text" value="<?php echo h($content['home']['cta']['button_text']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>CTA Knop Link</label>
            <input type="text" name="cta_button_link" value="<?php echo h($content['home']['cta']['button_link']); ?>" required>
            <small>Bijvoorbeeld: /contact.php</small>
        </div>
        
        <div class="form-group">
            <label>CTA Achtergrond Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="cta_image" id="cta_image" value="<?php echo h($content['home']['cta']['image'] ?? ''); ?>">
                <button type="button" class="btn btn-secondary" data-media-input="cta_image">Bladeren</button>
            </div>
            <small>Optioneel - achtergrondafbeelding voor de CTA sectie (aanbevolen: 1920x400px)</small>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
            <button type="reset" class="btn btn-secondary">Annuleren</button>
        </div>
    </form>
    
    <form method="POST" style="margin-top: 30px;">
        <input type="hidden" name="section" value="home_colors">
        
        <h3>Sectie Kleuren (Home Pagina)</h3>
        <div class="info-box" style="margin-bottom: 20px;">
            <p>Pas de kleuren aan per sectie op de Home pagina.</p>
        </div>
        
        <h4>Pagina Achtergrond</h4>
        <div class="form-group">
            <label for="home_page_bg">Pagina Achtergrondkleur</label>
            <div class="color-input-group">
                <input id="home_page_bg" type="color" name="page_bg" value="<?php echo h($content['home']['colors']['sectionBg']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['colors']['sectionBg']); ?>" readonly class="color-text-input">
            </div>
            <small>De algemene achtergrondkleur van de hele pagina</small>
        </div>
        
        <h4>Hero Sectie (Banner Bovenaan)</h4>
        <div class="form-group">
            <label for="home_hero_bg">Hero Achtergrond</label>
            <div class="color-input-group">
                <input id="home_hero_bg" type="color" name="hero_bg" value="<?php echo h($content['home']['hero']['colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['hero']['colors']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label for="home_hero_text">Hero Tekst Kleur</label>
            <div class="color-input-group">
                <input id="home_hero_text" type="color" name="hero_text" value="<?php echo h($content['home']['hero']['colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['hero']['colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label for="home_hero_overlay">Hero Overlay (donkere laag)</label>
            <input id="home_hero_overlay" type="text" name="hero_overlay" value="<?php echo h($content['home']['hero']['colors']['overlay']); ?>" placeholder="rgba(0, 0, 0, 0.5)">
            <small>Bijvoorbeeld: rgba(0, 0, 0, 0.5) voor 50% zwart</small>
        </div>
        
        <h4>Intro Sectie (Welkom Tekst)</h4>
        <div class="form-group">
            <label for="home_intro_bg">Intro Achtergrond</label>
            <div class="color-input-group">
                <input id="home_intro_bg" type="color" name="intro_bg" value="<?php echo h($content['home']['intro']['colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['intro']['colors']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label for="home_intro_text">Intro Tekst Kleur</label>
            <div class="color-input-group">
                <input id="home_intro_text" type="color" name="intro_text" value="<?php echo h($content['home']['intro']['colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['intro']['colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label for="home_intro_title">Intro Titel Kleur</label>
            <div class="color-input-group">
                <input id="home_intro_title" type="color" name="intro_title" value="<?php echo h($content['home']['intro']['colors']['title']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['intro']['colors']['title']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <h4>Vakmanschap Sectie</h4>
        <div class="form-group">
            <label for="home_vak_bg">Vakmanschap Achtergrond</label>
            <div class="color-input-group">
                <input id="home_vak_bg" type="color" name="vak_bg" value="<?php echo h($content['home']['vakmanschap']['colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['vakmanschap']['colors']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label for="home_vak_text">Vakmanschap Tekst Kleur</label>
            <div class="color-input-group">
                <input id="home_vak_text" type="color" name="vak_text" value="<?php echo h($content['home']['vakmanschap']['colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['vakmanschap']['colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label for="home_vak_title">Vakmanschap Titel Kleur</label>
            <div class="color-input-group">
                <input id="home_vak_title" type="color" name="vak_title" value="<?php echo h($content['home']['vakmanschap']['colors']['title']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['vakmanschap']['colors']['title']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <h4>CTA Sectie (Contact Oproep)</h4>
        <div class="form-group">
            <label for="home_cta_bg">CTA Achtergrond Kleur</label>
            <div class="color-input-group">
                <input id="home_cta_bg" type="color" name="cta_bg" value="<?php echo h($content['home']['cta']['colors']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['cta']['colors']['background']); ?>" readonly class="color-text-input">
            </div>
            <small>Wordt gebruikt als fallback als er geen afbeelding is</small>
        </div>
        
        <div class="form-group">
            <label for="home_cta_text">CTA Tekst Kleur</label>
            <div class="color-input-group">
                <input id="home_cta_text" type="color" name="cta_text" value="<?php echo h($content['home']['cta']['colors']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['home']['cta']['colors']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label for="home_cta_overlay">CTA Overlay</label>
            <input id="home_cta_overlay" type="text" name="cta_overlay" value="<?php echo h($content['home']['cta']['colors']['overlay']); ?>" placeholder="rgba(0, 0, 0, 0.5)">
            <small>Donkere laag over de afbeelding voor betere leesbaarheid</small>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Kleuren Opslaan</button>
        </div>
    </form>
    
    <form method="POST" style="margin-top: 30px;">
        <input type="hidden" name="section" value="home_cta">
        
        <h3>CTA Sectie Bewerken</h3>
        <div class="info-box" style="margin-bottom: 20px;">
            <p>Pas de Call-to-Action sectie onderaan de pagina aan.</p>
        </div>
        
        <div class="form-group">
            <label>Titel</label>
            <input type="text" name="cta_title" value="<?php echo h($content['home']['cta']['title'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label>Ondertitel</label>
            <textarea name="cta_subtitle" rows="3"><?php echo h($content['home']['cta']['subtitle'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Button Tekst</label>
            <input type="text" name="cta_button_text" value="<?php echo h($content['home']['cta']['button_text'] ?? ''); ?>">
        </div>
        
        <div class="form-group">
            <label>Button Link</label>
            <input type="text" name="cta_button_link" value="<?php echo h($content['home']['cta']['button_link'] ?? ''); ?>">
            <small>Gebruik /contact.php voor contact pagina, tel:+31612345678 voor telefoon, of mailto:email@voorbeeld.nl</small>
        </div>
        
        <div class="form-group">
            <label>CTA Achtergrond Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="cta_image" id="home_cta_image" value="<?php echo h($content['home']['cta']['image'] ?? ''); ?>">
                <button type="button" class="btn btn-secondary" data-media-input="home_cta_image">Bladeren</button>
            </div>
            <small>Optioneel - achtergrondafbeelding voor de CTA sectie (aanbevolen: 1920x400px)</small>
        </div>
        
        <h4>Kleuren</h4>
        <div class="form-group">
            <label>Achtergrondkleur</label>
            <input type="color" name="cta_bg" value="<?php echo h($content['home']['cta']['colors']['background'] ?? '#222e40'); ?>">
        </div>
        
        <div class="form-group">
            <label>Tekstkleur</label>
            <input type="color" name="cta_text" value="<?php echo h($content['home']['cta']['colors']['text'] ?? '#ffffff'); ?>">
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">CTA Wijzigingen Opslaan</button>
        </div>
    </form>
</div>
