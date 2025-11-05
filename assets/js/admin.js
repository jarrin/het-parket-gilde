// Admin Panel JavaScript

// Direct file upload functionality
function openMediaBrowser(inputId) {
    // Create a temporary file input
    const fileInput = document.createElement('input');
    fileInput.type = 'file';
    fileInput.accept = 'image/*';
    
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
});
