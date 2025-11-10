// Live Edit Mode voor Het Parket Gilde
let editMode = false;
let currentPage = '';

// Initialize edit mode
document.addEventListener('DOMContentLoaded', function() {
    // Bepaal huidige pagina
    const path = window.location.pathname;
    if (path.includes('diensten')) currentPage = 'diensten';
    else if (path.includes('over-ons')) currentPage = 'over_ons';
    else if (path.includes('contact')) currentPage = 'contact';
    else currentPage = 'home';
    
    // Voeg edit mode button toe als je ingelogd bent
    checkLoginStatus();
});

// Check of gebruiker ingelogd is
function checkLoginStatus() {
    fetch('/admin/check-session.php')
        .then(r => r.json())
        .then(data => {
            if (data.loggedIn) {
                addEditModeButton();
            }
        })
        .catch(() => {});
}

// Voeg edit mode knop toe
function addEditModeButton() {
    const btn = document.createElement('button');
    btn.id = 'edit-mode-toggle';
    btn.innerHTML = '<i class="fas fa-edit"></i> Bewerk Pagina';
    btn.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #D4AF7A;
        color: #2B3A52;
        border: none;
        padding: 15px 25px;
        border-radius: 50px;
        cursor: pointer;
        font-weight: bold;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 9999;
        font-size: 14px;
        transition: all 0.3s;
    `;
    
    btn.onmouseover = () => {
        btn.style.transform = 'scale(1.05)';
        btn.style.boxShadow = '0 6px 16px rgba(0,0,0,0.4)';
    };
    btn.onmouseout = () => {
        btn.style.transform = 'scale(1)';
        btn.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
    };
    
    btn.onclick = toggleEditMode;
    document.body.appendChild(btn);
}

// Toggle edit mode aan/uit
function toggleEditMode() {
    editMode = !editMode;
    const btn = document.getElementById('edit-mode-toggle');
    
    if (editMode) {
        btn.innerHTML = '<i class="fas fa-times"></i> Sluit Bewerken';
        btn.style.background = '#e74c3c';
        btn.style.color = '#fff';
        enableEditMode();
    } else {
        btn.innerHTML = '<i class="fas fa-edit"></i> Bewerk Pagina';
        btn.style.background = '#D4AF7A';
        btn.style.color = '#2B3A52';
        disableEditMode();
    }
}

// Activeer edit mode
function enableEditMode() {
    // Maak alle teksten bewerkbaar
    const editableElements = document.querySelectorAll('h1, h2, h3, h4, h5, h6, p, li, a, span');
    
    editableElements.forEach(el => {
        // Skip header/footer navigatie
        if (el.closest('nav') || el.closest('header nav') || el.closest('footer')) {
            return;
        }
        
        el.classList.add('live-editable');
        el.style.cursor = 'pointer';
        el.style.outline = '2px dashed transparent';
        el.style.transition = 'outline 0.2s';
        
        el.addEventListener('mouseenter', handleHover);
        el.addEventListener('mouseleave', handleHoverOut);
        el.addEventListener('click', handleEdit);
    });
    
    // Maak afbeeldingen bewerkbaar
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        if (img.closest('nav') || img.closest('header nav') || img.closest('footer')) {
            return;
        }
        
        img.classList.add('live-editable-image');
        img.style.cursor = 'pointer';
        img.style.outline = '2px dashed transparent';
        img.addEventListener('mouseenter', handleImageHover);
        img.addEventListener('mouseleave', handleHoverOut);
        img.addEventListener('click', handleImageEdit);
    });
    
    // Voeg save indicator toe
    addSaveIndicator();
    
    // Toon instructies
    showInstructions();
}

// Deactiveer edit mode
function disableEditMode() {
    document.querySelectorAll('.live-editable').forEach(el => {
        el.classList.remove('live-editable');
        el.style.cursor = '';
        el.style.outline = '';
        el.removeEventListener('mouseenter', handleHover);
        el.removeEventListener('mouseleave', handleHoverOut);
        el.removeEventListener('click', handleEdit);
    });
    
    document.querySelectorAll('.live-editable-image').forEach(img => {
        img.classList.remove('live-editable-image');
        img.style.cursor = '';
        img.style.outline = '';
        img.removeEventListener('mouseenter', handleImageHover);
        img.removeEventListener('mouseleave', handleHoverOut);
        img.removeEventListener('click', handleImageEdit);
    });
    
    // Verwijder save indicator
    const indicator = document.getElementById('save-indicator');
    if (indicator) indicator.remove();
    
    const instructions = document.getElementById('edit-instructions');
    if (instructions) instructions.remove();
}

// Hover effecten
function handleHover(e) {
    e.target.style.outline = '2px dashed #D4AF7A';
    e.target.style.background = 'rgba(212, 175, 122, 0.1)';
}

function handleImageHover(e) {
    e.target.style.outline = '2px dashed #D4AF7A';
    e.target.style.filter = 'brightness(1.1)';
}

function handleHoverOut(e) {
    e.target.style.outline = '2px dashed transparent';
    e.target.style.background = '';
    e.target.style.filter = '';
}

// Bewerk tekst
function handleEdit(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const element = e.target;
    const originalText = element.textContent;
    const tagName = element.tagName.toLowerCase();
    
    // Maak modal voor bewerken
    const modal = createEditModal(originalText, tagName, (newText) => {
        if (newText !== originalText) {
            element.textContent = newText;
            saveChanges(element, newText);
        }
    });
    
    document.body.appendChild(modal);
}

// Bewerk afbeelding
function handleImageEdit(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const img = e.target;
    
    // Maak file input
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    
    input.onchange = async () => {
        const file = input.files[0];
        if (!file) return;
        
        showSaveIndicator('Afbeelding uploaden...');
        
        const formData = new FormData();
        formData.append('image', file);
        
        try {
            const response = await fetch('/admin/upload.php', {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                img.src = '/' + data.path;
                saveImageChange(img, data.path);
                showSaveIndicator('Afbeelding opgeslagen!', true);
            } else {
                showSaveIndicator('Fout bij uploaden', false);
            }
        } catch (error) {
            showSaveIndicator('Fout bij uploaden', false);
        }
    };
    
    input.click();
}

// Maak edit modal
function createEditModal(text, tagName, onSave) {
    const modal = document.createElement('div');
    modal.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.7);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
    `;
    
    const box = document.createElement('div');
    box.style.cssText = `
        background: white;
        padding: 30px;
        border-radius: 10px;
        max-width: 600px;
        width: 90%;
        box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    `;
    
    const title = document.createElement('h3');
    title.textContent = 'Tekst bewerken';
    title.style.cssText = 'margin: 0 0 20px 0; color: #2B3A52;';
    
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.cssText = `
        width: 100%;
        min-height: 150px;
        padding: 15px;
        border: 2px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
        font-family: inherit;
        resize: vertical;
        margin-bottom: 20px;
    `;
    
    const buttonContainer = document.createElement('div');
    buttonContainer.style.cssText = 'display: flex; gap: 10px; justify-content: flex-end;';
    
    const saveBtn = document.createElement('button');
    saveBtn.textContent = 'Opslaan';
    saveBtn.style.cssText = `
        background: #D4AF7A;
        color: #2B3A52;
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
    `;
    
    const cancelBtn = document.createElement('button');
    cancelBtn.textContent = 'Annuleren';
    cancelBtn.style.cssText = `
        background: #ddd;
        color: #333;
        border: none;
        padding: 12px 30px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    `;
    
    saveBtn.onclick = () => {
        onSave(textarea.value);
        modal.remove();
    };
    
    cancelBtn.onclick = () => modal.remove();
    
    modal.onclick = (e) => {
        if (e.target === modal) modal.remove();
    };
    
    buttonContainer.appendChild(cancelBtn);
    buttonContainer.appendChild(saveBtn);
    
    box.appendChild(title);
    box.appendChild(textarea);
    box.appendChild(buttonContainer);
    modal.appendChild(box);
    
    setTimeout(() => textarea.focus(), 100);
    
    return modal;
}

// Sla wijzigingen op
async function saveChanges(element, newText) {
    showSaveIndicator('Opslaan...');
    
    // Bepaal wat er gewijzigd is op basis van context
    const dataPath = determineDataPath(element);
    
    console.log('Save Changes:', {
        element: element,
        page: currentPage,
        path: dataPath,
        value: newText
    });
    
    if (!dataPath) {
        showSaveIndicator('Kon locatie niet bepalen', false);
        console.error('Geen data path gevonden voor element');
        return;
    }
    
    const payload = {
        page: currentPage,
        path: dataPath,
        value: newText
    };
    
    console.log('Sending to server:', payload);
    
    try {
        const response = await fetch('/admin/live-edit.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify(payload)
        });
        
        const data = await response.json();
        console.log('Server response:', data);
        
        if (data.success) {
            showSaveIndicator('Opgeslagen!', true);
        } else {
            showSaveIndicator('Fout: ' + (data.error || 'Onbekend'), false);
            console.error('Save error:', data);
        }
    } catch (error) {
        showSaveIndicator('Fout bij opslaan', false);
        console.error('Network error:', error);
    }
}

// Sla afbeelding wijziging op
async function saveImageChange(img, newPath) {
    const dataPath = determineImagePath(img);
    
    if (!dataPath) return;
    
    try {
        await fetch('/admin/live-edit.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                page: currentPage,
                path: dataPath,
                value: newPath
            })
        });
    } catch (error) {
        console.error('Fout bij opslaan afbeelding:', error);
    }
}

// Bepaal data path voor element
function determineDataPath(element) {
    // Zoek data-edit-path attribuut
    let current = element;
    while (current && current !== document.body) {
        if (current.hasAttribute('data-edit-path')) {
            return current.getAttribute('data-edit-path');
        }
        current = current.parentElement;
    }
    
    // Fallback: probeer automatisch te detecteren op basis van klasse/sectie
    const text = element.textContent.trim();
    const tagName = element.tagName.toLowerCase();
    
    // Detecteer op basis van parent sectie
    let section = element.closest('section, .hero, .intro, .story, .services, .founder, .values, .contact-info, .hours');
    
    if (!section) {
        console.warn('Kon geen sectie vinden voor element', element);
        return null;
    }
    
    // Probeer te detecteren welke sectie en veld
    if (section.classList.contains('hero') || section.querySelector('.hero-content')) {
        if (tagName === 'h1') return 'hero.title';
        if (tagName === 'h2' || tagName === 'p') return 'hero.subtitle';
    }
    
    if (section.classList.contains('intro')) {
        if (tagName === 'h2') return 'intro.title';
        if (tagName === 'p') return 'intro.text';
    }
    
    if (section.classList.contains('story')) {
        if (tagName === 'h2') return 'story.title';
        if (tagName === 'p') {
            const paragraphs = section.querySelectorAll('p');
            const index = Array.from(paragraphs).indexOf(element);
            return `story.paragraphs.${index}`;
        }
    }
    
    console.warn('Kon geen data path bepalen voor', element);
    return null;
}

// Bepaal data path voor afbeelding
function determineImagePath(img) {
    let current = img;
    while (current && current !== document.body) {
        if (current.hasAttribute('data-edit-image')) {
            return current.getAttribute('data-edit-image');
        }
        current = current.parentElement;
    }
    return null;
}

// Voeg save indicator toe
function addSaveIndicator() {
    const indicator = document.createElement('div');
    indicator.id = 'save-indicator';
    indicator.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: white;
        padding: 15px 20px;
        border-radius: 5px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 9998;
        display: none;
        font-size: 14px;
        font-weight: bold;
    `;
    document.body.appendChild(indicator);
}

// Toon save indicator
function showSaveIndicator(message, success = null) {
    const indicator = document.getElementById('save-indicator');
    if (!indicator) return;
    
    indicator.textContent = message;
    indicator.style.display = 'block';
    
    if (success === true) {
        indicator.style.background = '#27ae60';
        indicator.style.color = 'white';
    } else if (success === false) {
        indicator.style.background = '#e74c3c';
        indicator.style.color = 'white';
    } else {
        indicator.style.background = 'white';
        indicator.style.color = '#2B3A52';
    }
    
    if (success !== null) {
        setTimeout(() => {
            indicator.style.display = 'none';
        }, 3000);
    }
}

// Toon instructies
function showInstructions() {
    const instructions = document.createElement('div');
    instructions.id = 'edit-instructions';
    instructions.innerHTML = `
        <div style="margin-bottom: 10px;">
            <i class="fas fa-info-circle"></i> <strong>Bewerk Mode Actief</strong>
        </div>
        <div style="font-size: 13px; opacity: 0.9;">
            • Klik op tekst om te bewerken<br>
            • Klik op afbeelding om te vervangen<br>
            • Wijzigingen worden direct opgeslagen
        </div>
    `;
    instructions.style.cssText = `
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        background: #2B3A52;
        color: white;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        z-index: 9998;
        max-width: 400px;
    `;
    
    document.body.appendChild(instructions);
    
    setTimeout(() => {
        instructions.style.transition = 'opacity 0.5s';
        instructions.style.opacity = '0';
        setTimeout(() => instructions.remove(), 500);
    }, 5000);
}
