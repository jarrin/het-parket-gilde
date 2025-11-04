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
        const formData = new FormData();
        formData.append('image', file);
        
        // Show loading state
        const targetInput = document.getElementById(inputId);
        const originalValue = targetInput.value;
        targetInput.value = 'Uploading...';
        targetInput.disabled = true;
        
        fetch('/admin/upload.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                targetInput.value = data.path;
                alert('Afbeelding succesvol geüpload: ' + data.filename);
            } else {
                targetInput.value = originalValue;
                alert('Upload mislukt: ' + data.message);
            }
        })
        .catch(error => {
            targetInput.value = originalValue;
            alert('Upload mislukt: ' + error.message);
        })
        .finally(() => {
            targetInput.disabled = false;
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
