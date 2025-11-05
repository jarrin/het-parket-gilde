// Admin Panel JavaScript

// Direct file upload functionality
function openMediaBrowser(inputId) {
    // Create a temporary file input
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*,.svg';
    
    fileInput.onchange = function(e) {
        const file = e.target.files[0];
        if (!file) return;
        
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Alleen afbeeldingen zijn toegestaan');
            return;
        }
        
        // Validate file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            alert('Bestand te groot (max 5MB): ' + file.name);
            return;
        }
        
        // Upload the file
        const targetInput = document.getElementById(inputId);
        const originalValue = targetInput.value;
        
        const formData = new FormData();
        formData.append('image', file);
        formData.append('old_image', originalValue); // Send old image path for deletion
        
        // Show loading state
        targetInput.value = 'Uploading...';
        targetInput.disabled = true;
        
        fetch('/admin/upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log('Upload response:', data); // Debug logging
            targetInput.disabled = false;
            if (data.startsWith('SUCCESS:')) {
                const imagePath = data.replace('SUCCESS:', '');
                targetInput.value = imagePath;
                alert('Afbeelding succesvol geüpload! Vergeet niet op "Wijzigingen Opslaan" te klikken.');
            } else if (data.startsWith('ERROR:')) {
                targetInput.value = originalValue;
                const errorMsg = data.replace('ERROR:', '').trim();
                alert('Upload mislukt: ' + errorMsg);
            } else {
                targetInput.value = originalValue;
                console.error('Unexpected response:', data);
                alert('Upload mislukt: Onbekende response. Zie console voor details.');
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            targetInput.disabled = false;
            targetInput.value = originalValue;
            alert('Upload mislukt: ' + error.message);
        });
    };
    
    // Trigger the file picker
    fileInput.click();
}

// Initialize media browser buttons with data-attributes
function initMediaBrowsers() {
    document.querySelectorAll('[data-media-input]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            openMediaBrowser(this.dataset.mediaInput);
        });
    });
}

// Color picker live updates
document.addEventListener('DOMContentLoaded', function() {
    // Initialize media browsers
    initMediaBrowsers();
    
    // Per-page color live updates
    const pageColorMappings = [
        // Home colors
        { colorId: 'home_color_header', textId: 'home_text_header' },
        { colorId: 'home_color_hero_text', textId: 'home_text_hero_text' },
        { colorId: 'home_color_section_bg', textId: 'home_text_section_bg' },
        // Diensten colors
        { colorId: 'diensten_color_header', textId: 'diensten_text_header' },
        { colorId: 'diensten_color_hero_text', textId: 'diensten_text_hero_text' },
        { colorId: 'diensten_color_section_bg', textId: 'diensten_text_section_bg' },
        // Over Ons colors
        { colorId: 'over_ons_color_header', textId: 'over_ons_text_header' },
        { colorId: 'over_ons_color_hero_text', textId: 'over_ons_text_hero_text' },
        { colorId: 'over_ons_color_section_bg', textId: 'over_ons_text_section_bg' },
        // Contact colors
        { colorId: 'contact_color_header', textId: 'contact_text_header' },
        { colorId: 'contact_color_hero_text', textId: 'contact_text_hero_text' },
        { colorId: 'contact_color_section_bg', textId: 'contact_text_section_bg' }
    ];
    
    pageColorMappings.forEach(mapping => {
        const colorInput = document.getElementById(mapping.colorId);
        const textInput = document.getElementById(mapping.textId);
        
        if (colorInput && textInput) {
            colorInput.addEventListener('input', function() {
                textInput.value = this.value.toUpperCase();
            });
        }
    });
    
    // Dynamic diensten management
    initDienstenManager();
});

function initDienstenManager() {
    const addBtn = document.getElementById('add-service-btn');
    const container = document.getElementById('services-container');
    const countInput = document.getElementById('service_count');
    
    if (!addBtn || !container) return;
    
    // Add new service
    addBtn.addEventListener('click', function() {
        const currentCount = container.querySelectorAll('.service-block').length;
        const newIndex = currentCount;
        
        const newBlock = document.createElement('div');
        newBlock.className = 'service-block';
        newBlock.setAttribute('data-service-index', newIndex);
        newBlock.style.cssText = 'border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 5px; position: relative;';
        
        newBlock.innerHTML = `
            <button type="button" class="btn btn-danger btn-sm remove-service-btn" style="position: absolute; top: 10px; right: 10px;">✕ Verwijderen</button>
            <h4>Dienst ${newIndex + 1}: Nieuwe Dienst</h4>
            <div class="form-group">
                <label>Dienst Naam</label>
                <input type="text" name="service_title_${newIndex}" value="" required>
            </div>
            <div class="form-group">
                <label>Dienst Beschrijving</label>
                <textarea name="service_desc_${newIndex}" required></textarea>
                <small>Uitleg over deze dienst</small>
            </div>
            <div class="form-group">
                <label>Dienst Afbeelding</label>
                <div class="image-input-group">
                    <input type="text" name="service_image_${newIndex}" id="service_image_${newIndex}" value="" required>
                    <button type="button" class="btn btn-secondary" data-media-input="service_image_${newIndex}">Bladeren</button>
                </div>
                <small>Pad: assets/images/service-${newIndex + 1}.jpg</small>
            </div>
            <div class="form-group">
                <label>Features (één per regel)</label>
                <textarea name="service_features_${newIndex}" rows="4"></textarea>
                <small>Voer elke feature op een nieuwe regel in</small>
            </div>
        `;
        
        container.appendChild(newBlock);
        countInput.value = newIndex + 1;
        
        // Reinitialize media browsers
        initMediaBrowsers();
        
        // Add remove listener
        newBlock.querySelector('.remove-service-btn').addEventListener('click', function() {
            removeService(newBlock);
        });
    });
    
    // Remove service handlers for existing services
    container.querySelectorAll('.remove-service-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Remove button clicked');
            removeService(this.closest('.service-block'));
        });
    });
}

function removeService(block) {
    console.log('removeService called', block);
    const totalServices = document.querySelectorAll('.service-block').length;
    console.log('Total services:', totalServices);
    
    if (totalServices <= 1) {
        alert('Je moet minimaal 1 dienst hebben!');
        return;
    }
    
    if (confirm('Weet je zeker dat je deze dienst wilt verwijderen?')) {
        console.log('User confirmed removal');
        block.remove();
        
        // Renumber remaining services
        document.querySelectorAll('.service-block').forEach((block, idx) => {
            block.setAttribute('data-service-index', idx);
            const heading = block.querySelector('h4');
            if (heading) {
                const titleInput = block.querySelector('input[name^="service_title_"]');
                const title = titleInput ? titleInput.value || 'Nieuwe Dienst' : 'Nieuwe Dienst';
                heading.textContent = `Dienst ${idx + 1}: ${title}`;
            }
            
            // Update field names
            block.querySelectorAll('input, textarea').forEach(field => {
                const name = field.getAttribute('name');
                if (name && name.includes('_')) {
                    const parts = name.split('_');
                    parts[parts.length - 1] = idx;
                    field.setAttribute('name', parts.join('_'));
                }
                if (field.id && field.id.includes('_')) {
                    const parts = field.id.split('_');
                    parts[parts.length - 1] = idx;
                    field.id = parts.join('_');
                }
            });
            
            // Update media browser buttons
            block.querySelectorAll('[data-media-input]').forEach(btn => {
                const inputId = btn.getAttribute('data-media-input');
                if (inputId && inputId.includes('_')) {
                    const parts = inputId.split('_');
                    parts[parts.length - 1] = idx;
                    btn.setAttribute('data-media-input', parts.join('_'));
                }
            });
        });
        
        // Update count
        document.getElementById('service_count').value = document.querySelectorAll('.service-block').length;
    }
}
