<div class="form-section">
    <div class="page-title">
        <h2>Site Informatie</h2>
    </div>
    <div class="info-box">
        <p>Deze informatie wordt gebruikt op alle pagina's van de website (footer, contact info, etc.).</p>
    </div>
    
    <form method="POST">
        <input type="hidden" name="section" value="site">
        
        <div class="form-group">
            <label>Website Titel</label>
            <input type="text" name="site_title" value="<?php echo h($content['site']['title']); ?>" required>
            <small>De hoofdnaam van uw bedrijf</small>
        </div>
        
        <div class="form-group">
            <label>Website Beschrijving</label>
            <input type="text" name="site_description" value="<?php echo h($content['site']['description']); ?>" required>
            <small>Korte omschrijving van uw bedrijf</small>
        </div>
        
        <div class="form-group">
            <label>Logo</label>
            <div class="image-input-group">
                <input type="text" name="site_logo" id="site_logo" value="<?php echo h($content['site']['logo'] ?? ''); ?>" placeholder="assets/images/logo.png">
                <button type="button" class="btn btn-secondary" data-media-input="site_logo">Bladeren</button>
            </div>
            <small>Upload uw bedrijfslogo (formaten: PNG, SVG, JPG - aanbevolen: SVG of PNG met transparante achtergrond, max 200px hoog)</small>
            <?php if (!empty($content['site']['logo'])): ?>
                <div style="margin-top: 10px;">
                    <img src="/<?php echo h($content['site']['logo']); ?>" alt="Logo preview" style="max-height: 80px; border: 1px solid #ddd; padding: 5px; background: #f5f5f5;">
                </div>
            <?php endif; ?>
        </div>
        
        <h3>Contact Gegevens</h3>
        
        <div class="form-group">
            <label>Telefoon</label>
            <input type="text" name="contact_phone" value="<?php echo h($content['site']['contact']['phone']); ?>" required>
            <small>Bijvoorbeeld: +31 6 12345678</small>
        </div>
        
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="contact_email" value="<?php echo h($content['site']['contact']['email']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Straat en Huisnummer</label>
            <input type="text" name="contact_address" value="<?php echo h($content['site']['contact']['address']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Stad</label>
            <input type="text" name="contact_city" value="<?php echo h($content['site']['contact']['city']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Postcode</label>
            <input type="text" name="contact_zipcode" value="<?php echo h($content['site']['contact']['zipcode']); ?>" required>
        </div>
        
        <h3>Globale Kleuren (Header & Footer)</h3>
        <div class="info-box" style="margin-bottom: 20px;">
            <p>Deze kleuren worden gebruikt voor de header en footer op alle pagina's.</p>
        </div>
        
        <h4>Header Kleuren</h4>
        <div class="form-group">
            <label>Header Achtergrond</label>
            <div class="color-input-group">
                <input type="color" name="header_bg" value="<?php echo h($content['site']['colors']['header']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['site']['colors']['header']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Header Tekst</label>
            <div class="color-input-group">
                <input type="color" name="header_text" value="<?php echo h($content['site']['colors']['header']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['site']['colors']['header']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Header Logo/Links</label>
            <div class="color-input-group">
                <input type="color" name="header_logo" value="<?php echo h($content['site']['colors']['header']['logo']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['site']['colors']['header']['logo']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <h4>Footer Kleuren</h4>
        <div class="form-group">
            <label>Footer Achtergrond</label>
            <div class="color-input-group">
                <input type="color" name="footer_bg" value="<?php echo h($content['site']['colors']['footer']['background']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['site']['colors']['footer']['background']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Footer Tekst</label>
            <div class="color-input-group">
                <input type="color" name="footer_text" value="<?php echo h($content['site']['colors']['footer']['text']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['site']['colors']['footer']['text']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-group">
            <label>Footer Links</label>
            <div class="color-input-group">
                <input type="color" name="footer_links" value="<?php echo h($content['site']['colors']['footer']['links']); ?>" class="color-picker-input">
                <input type="text" value="<?php echo h($content['site']['colors']['footer']['links']); ?>" readonly class="color-text-input">
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
            <button type="reset" class="btn btn-secondary">Annuleren</button>
        </div>
    </form>
</div>
