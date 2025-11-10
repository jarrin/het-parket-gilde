// Admin Panel JavaScript

// Custom styled confirm dialog
function showCustomConfirm(message, onConfirm) {
    // Create overlay
    const overlay = document.createElement('div');
    overlay.style.cssText = 'position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 10000; display: flex; align-items: center; justify-content: center;';
    
    // Create dialog
    const dialog = document.createElement('div');
    dialog.style.cssText = 'background: white; border-radius: 8px; padding: 30px; max-width: 400px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);';
    
    dialog.innerHTML = `
        <h3 style="margin: 0 0 20px 0; color: #2c3e50; font-size: 18px;">Bevestiging</h3>
        <p style="margin: 0 0 25px 0; color: #555; line-height: 1.6;">${message}</p>
        <div style="display: flex; gap: 10px; justify-content: flex-end;">
            <button class="custom-cancel-btn" style="padding: 10px 24px; border: 2px solid #95a5a6; background: white; color: #555; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600;">Annuleren</button>
            <button class="custom-confirm-btn" style="padding: 10px 24px; border: none; background: #e74c3c; color: white; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600;">Verwijderen</button>
        </div>
    `;
    
    overlay.appendChild(dialog);
    document.body.appendChild(overlay);
    
    // Handle buttons
    dialog.querySelector('.custom-cancel-btn').onclick = function() {
        document.body.removeChild(overlay);
    };
    
    dialog.querySelector('.custom-confirm-btn').onclick = function() {
        document.body.removeChild(overlay);
        onConfirm();
    };
    
    // Close on overlay click
    overlay.onclick = function(e) {
        if (e.target === overlay) {
            document.body.removeChild(overlay);
        }
    };
}

// Custom styled alert
function showCustomAlert(message) {
    const overlay = document.createElement('div');
    overlay.style.cssText = 'position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 10000; display: flex; align-items: center; justify-content: center;';
    
    const dialog = document.createElement('div');
    dialog.style.cssText = 'background: white; border-radius: 8px; padding: 30px; max-width: 400px; box-shadow: 0 10px 40px rgba(0,0,0,0.3);';
    
    dialog.innerHTML = `
        <h3 style="margin: 0 0 20px 0; color: #2c3e50; font-size: 18px;">Let op</h3>
        <p style="margin: 0 0 25px 0; color: #555; line-height: 1.6;">${message}</p>
        <div style="display: flex; justify-content: flex-end;">
            <button class="custom-ok-btn" style="padding: 10px 24px; border: none; background: #3498db; color: white; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600;">OK</button>
        </div>
    `;
    
    overlay.appendChild(dialog);
    document.body.appendChild(overlay);
    
    dialog.querySelector('.custom-ok-btn').onclick = function() {
        document.body.removeChild(overlay);
    };
    
    overlay.onclick = function(e) {
        if (e.target === overlay) {
            document.body.removeChild(overlay);
        }
    };
}

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
    
    // Contact items management
    window.addContactItem = addContactItem;
    window.removeContactItem = removeContactItem;
});

// Contact box management functions
function addContactItem() {
    const container = document.getElementById('contactItemsContainer');
    const countInput = document.getElementById('contactItemsCount');
    const currentCount = parseInt(countInput.value) || 0;
    const newIndex = currentCount;
    
    const newItem = document.createElement('div');
    newItem.className = 'contact-item-group';
    newItem.setAttribute('data-index', newIndex);
    
    newItem.innerHTML = `
        <div class="contact-item-header">
            <h4>Contact Box ${newIndex + 1}</h4>
            <button type="button" class="btn btn-danger btn-sm" onclick="removeContactItem(${newIndex})">Verwijderen</button>
        </div>
        
        <div class="form-group">
            <label>Label</label>
            <input type="text" name="contact_item_label_${newIndex}" value="" required>
            <small>Bijvoorbeeld: Telefoon, E-mail, Adres</small>
        </div>
        
        <div class="form-group">
            <label>Icoon</label>
            <input type="text" name="contact_item_icon_${newIndex}" value="📱" required>
            <small>Emoji of karakter voor het icoon (bijvoorbeeld: ☎, @, ⌂, 📱, 🏢)</small>
        </div>
        
        <div class="form-group">
            <label>Waarde</label>
            <textarea name="contact_item_value_${newIndex}" rows="2" required></textarea>
            <small>De inhoud die wordt weergegeven. Gebruik Enter voor meerdere regels.</small>
        </div>
        
        <div class="form-group">
            <label>Link (optioneel)</label>
            <input type="text" name="contact_item_link_${newIndex}" value="">
            <small>Bijvoorbeeld: tel:+31612345678, mailto:info@example.nl, of laat leeg voor geen link</small>
        </div>
    `;
    
    container.appendChild(newItem);
    countInput.value = newIndex + 1;
    
    showSaveReminder();
}

function removeContactItem(index) {
    const items = document.querySelectorAll('.contact-item-group');
    
    if (items.length <= 1) {
        showCustomAlert('Je moet minimaal 1 contact box hebben!');
        return;
    }
    
    showCustomConfirm('Weet je zeker dat je deze contact box wilt verwijderen?', function() {
        const item = document.querySelector(`.contact-item-group[data-index="${index}"]`);
        if (item) {
            item.remove();
            
            // Renumber remaining items
            const remainingItems = document.querySelectorAll('.contact-item-group');
            remainingItems.forEach((item, idx) => {
                item.setAttribute('data-index', idx);
                
                // Update header
                const header = item.querySelector('.contact-item-header h4');
                if (header) {
                    header.textContent = `Contact Box ${idx + 1}`;
                }
                
                // Update button onclick
                const removeBtn = item.querySelector('.btn-danger');
                if (removeBtn) {
                    removeBtn.setAttribute('onclick', `removeContactItem(${idx})`);
                }
                
                // Update field names
                item.querySelectorAll('input, textarea').forEach(field => {
                    const name = field.getAttribute('name');
                    if (name) {
                        const baseName = name.replace(/_\d+$/, '');
                        field.setAttribute('name', `${baseName}_${idx}`);
                    }
                });
            });
            
            // Update count
            const countInput = document.getElementById('contactItemsCount');
            if (countInput) {
                countInput.value = remainingItems.length;
            }
            
            showSaveReminder();
        }
    });
}

function initDienstenManager() {
    const addBtn = document.getElementById('add-service-btn');
    const container = document.getElementById('services-container');
    const countInput = document.getElementById('service_count');
    
    if (!addBtn || !container) {
        console.log('Diensten manager niet geinitialiseerd - elementen niet gevonden');
        return;
    }
    
    console.log('Diensten manager geinitialiseerd');
    
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
    });
    
    // Use event delegation for remove buttons (works for existing and new buttons)
    container.addEventListener('click', function(e) {
        // Check if clicked element or its parent is a remove button
        const removeBtn = e.target.closest('.remove-service-btn');
        if (removeBtn) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Remove button clicked via delegation');
            const block = removeBtn.closest('.service-block');
            if (block) {
                removeService(block);
            }
        }
    });
    
    console.log('Event delegation ingesteld voor remove buttons');
}

function removeService(block) {
    console.log('removeService called', block);
    const totalServices = document.querySelectorAll('.service-block').length;
    console.log('Total services:', totalServices);
    
    if (totalServices <= 1) {
        showCustomAlert('Je moet minimaal 1 dienst hebben!');
        return;
    }
    
    showCustomConfirm('Weet je zeker dat je deze dienst wilt verwijderen?', function() {
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
        const countInput = document.getElementById('service_count');
        if (countInput) {
            countInput.value = document.querySelectorAll('.service-block').length;
        }
        
        // Show save reminder
        showSaveReminder();
    });
}

function showSaveReminder() {
    // Check if reminder already exists
    if (document.getElementById('save-reminder')) return;
    
    const reminder = document.createElement('div');
    reminder.id = 'save-reminder';
    reminder.style.cssText = 'position: fixed; bottom: 20px; right: 20px; background: #f39c12; color: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.3); z-index: 9999; font-weight: 600; animation: slideIn 0.3s ease;';
    reminder.innerHTML = '⚠️ Vergeet niet op "Wijzigingen Opslaan" te klikken!';
    
    document.body.appendChild(reminder);
    
    // Add animation
    const style = document.createElement('style');
    style.textContent = '@keyframes slideIn { from { transform: translateX(400px); opacity: 0; } to { transform: translateX(0); opacity: 1; } }';
    document.head.appendChild(style);
    
    // Remove after form submit or 10 seconds
    setTimeout(() => {
        if (reminder.parentNode) {
            reminder.style.animation = 'slideOut 0.3s ease';
            style.textContent += '@keyframes slideOut { from { transform: translateX(0); opacity: 1; } to { transform: translateX(400px); opacity: 0; } }';
            setTimeout(() => {
                if (reminder.parentNode) {
                    document.body.removeChild(reminder);
                }
            }, 300);
        }
    }, 10000);
    
    // Remove on form submit
    const form = document.getElementById('diensten-form');
    if (form) {
        form.addEventListener('submit', function() {
            if (reminder.parentNode) {
                document.body.removeChild(reminder);
            }
        }, { once: true });
    }
}
