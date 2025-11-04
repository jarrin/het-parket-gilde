// Media Manager JavaScript
document.addEventListener('DOMContentLoaded', function() {
    initMediaManager();
});

function initMediaManager() {
    const uploadZone = document.getElementById('uploadZone');
    const fileInput = document.getElementById('fileInput');

    if (!uploadZone || !fileInput) return;

    // Drag and drop events
    uploadZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadZone.classList.add('dragover');
    });

    uploadZone.addEventListener('dragleave', () => {
        uploadZone.classList.remove('dragover');
    });

    uploadZone.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadZone.classList.remove('dragover');
        handleFiles(e.dataTransfer.files);
    });

    // File input change
    fileInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    // Close modal on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            hideModal();
        }
    });

    // Copy buttons
    document.querySelectorAll('.btn-copy').forEach(btn => {
        btn.addEventListener('click', function() {
            copyPath(this.dataset.path);
        });
    });

    // Delete forms with confirmation
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm(this.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });

    // Modal images
    document.querySelectorAll('.media-thumbnail').forEach(img => {
        img.addEventListener('click', function() {
            showModal(this.dataset.modalUrl);
        });
    });

    // Modal close button and background
    const modal = document.getElementById('imageModal');
    if (modal) {
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                hideModal();
            }
        });
        
        const closeBtn = modal.querySelector('.modal-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', hideModal);
        }
    }
}

function handleFiles(files) {
    Array.from(files).forEach(uploadFile);
}

function uploadFile(file) {
    if (!file.type.startsWith('image/')) {
        alert('Alleen afbeeldingen zijn toegestaan');
        return;
    }

    if (file.size > 5 * 1024 * 1024) {
        alert('Bestand te groot: ' + file.name);
        return;
    }

    const formData = new FormData();
    formData.append('image', file);

    fetch('/admin/upload.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Upload mislukt: ' + data.message);
        }
    })
    .catch(error => {
        alert('Upload mislukt: ' + error.message);
    });
}

function copyPath(path) {
    navigator.clipboard.writeText(path).then(() => {
        alert('Pad gekopieerd naar klembord: ' + path);
    });
}

function showModal(url) {
    document.getElementById('modalImage').src = url;
    document.getElementById('imageModal').classList.add('show');
}

function hideModal() {
    document.getElementById('imageModal').classList.remove('show');
}
