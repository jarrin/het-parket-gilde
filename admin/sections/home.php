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
        
        <h4>Feature Box 1 - Ervaring</h4>
        
        <div class="form-group">
            <label>Ervaring Titel</label>
            <input type="text" name="feature1_title" value="<?php echo h($content['home']['vakmanschap']['features'][0]['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Ervaring Beschrijving</label>
            <textarea name="feature1_description" required><?php echo h($content['home']['vakmanschap']['features'][0]['description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Ervaring Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="feature1_image" id="feature1_image" value="<?php echo h($content['home']['vakmanschap']['features'][0]['image'] ?? ''); ?>">
                <button type="button" class="btn btn-secondary" data-media-input="feature1_image">Bladeren</button>
            </div>
            <small>Optioneel - afbeelding voor de Ervaring box</small>
        </div>
        
        <h4>Feature Box 2 - Kwaliteit</h4>
        
        <div class="form-group">
            <label>Kwaliteit Titel</label>
            <input type="text" name="feature2_title" value="<?php echo h($content['home']['vakmanschap']['features'][1]['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Kwaliteit Beschrijving</label>
            <textarea name="feature2_description" required><?php echo h($content['home']['vakmanschap']['features'][1]['description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Kwaliteit Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="feature2_image" id="feature2_image" value="<?php echo h($content['home']['vakmanschap']['features'][1]['image'] ?? ''); ?>">
                <button type="button" class="btn btn-secondary" data-media-input="feature2_image">Bladeren</button>
            </div>
            <small>Optioneel - afbeelding voor de Kwaliteit box</small>
        </div>
        
        <h4>Feature Box 3 - Maatwerk</h4>
        
        <div class="form-group">
            <label>Maatwerk Titel</label>
            <input type="text" name="feature3_title" value="<?php echo h($content['home']['vakmanschap']['features'][2]['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Maatwerk Beschrijving</label>
            <textarea name="feature3_description" required><?php echo h($content['home']['vakmanschap']['features'][2]['description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label>Maatwerk Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="feature3_image" id="feature3_image" value="<?php echo h($content['home']['vakmanschap']['features'][2]['image'] ?? ''); ?>">
                <button type="button" class="btn btn-secondary" data-media-input="feature3_image">Bladeren</button>
            </div>
            <small>Optioneel - afbeelding voor de Maatwerk box</small>
        </div>
        
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
            <label>CTA Achtergrond Afbeelding</label>
            <div class="image-input-group">
                <input type="text" name="cta_image" id="home_cta_image" value="<?php echo h($content['home']['cta']['image'] ?? ''); ?>">
                <button type="button" class="btn btn-secondary" data-media-input="home_cta_image">Bladeren</button>
            </div>
            <small>Optioneel - achtergrondafbeelding voor de CTA sectie (aanbevolen: 1920x400px)</small>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">CTA Afbeelding Opslaan</button>
        </div>
    </form>
</div>
