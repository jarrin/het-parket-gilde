<?php
require_once '../functions.php';
requireAdmin();

// Get all images
$images = [];
if (file_exists(UPLOAD_PATH)) {
    $files = scandir(UPLOAD_PATH);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..' && $file !== 'README.md') {
            $filepath = UPLOAD_PATH . '/' . $file;
            if (is_file($filepath) && @getimagesize($filepath)) {
                $images[] = [
                    'filename' => $file,
                    'path' => 'assets/images/' . $file,
                    'url' => '/assets/images/' . $file,
                    'size' => filesize($filepath),
                    'modified' => filemtime($filepath)
                ];
            }
        }
    }
    
    usort($images, function($a, $b) {
        return $b['modified'] - $a['modified'];
    });
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selecteer Afbeelding</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f5f5f5;
        }
        
        .browser-header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .browser-header h1 {
            margin: 0 0 10px 0;
            font-size: 24px;
            color: #2c3e50;
        }
        
        .browser-header p {
            margin: 0;
            color: #7f8c8d;
        }
        
        .upload-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .upload-zone {
            border: 3px dashed #d0d0d0;
            border-radius: 8px;
            padding: 30px;
            text-align: center;
            background: #fafafa;
            transition: all 0.3s;
        }
        
        .upload-zone:hover, .upload-zone.dragover {
            border-color: #3498db;
            background: #e3f2fd;
        }
        
        .upload-zone input[type="file"] {
            display: none;
        }
        
        .upload-zone label {
            display: inline-block;
            padding: 12px 30px;
            background: #3498db;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        
        .upload-zone label:hover {
            background: #2980b9;
        }
        
        .upload-hint {
            margin-top: 10px;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .images-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 15px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .image-item {
            border: 3px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }
        
        .image-item:hover {
            border-color: #3498db;
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(52, 152, 219, 0.3);
        }
        
        .image-item img {
            width: 100%;
            height: 140px;
            object-fit: cover;
            display: block;
        }
        
        .image-info {
            padding: 10px;
            background: #f8f9fa;
        }
        
        .image-name {
            font-size: 11px;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .image-size {
            font-size: 10px;
            color: #95a5a6;
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #95a5a6;
            background: white;
            border-radius: 8px;
        }
        
        .empty-state svg {
            width: 80px;
            height: 80px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
        
        .actions {
            margin-top: 20px;
            text-align: center;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .btn-cancel {
            background: #95a5a6;
            color: white;
        }
        
        .btn-cancel:hover {
            background: #7f8c8d;
        }
    </style>
</head>
<body>
    <div class="browser-header">
        <h1>📁 Selecteer Afbeelding</h1>
        <p>Klik op een afbeelding om deze te selecteren, of upload een nieuwe</p>
    </div>
    
    <div class="upload-section">
        <div class="upload-zone" id="uploadZone">
            <input type="file" id="fileInput" accept="image/*" multiple>
            <label for="fileInput">📤 Nieuwe Afbeelding Uploaden</label>
            <p class="upload-hint">Of sleep afbeeldingen hierheen • Max 5MB • JPEG, PNG, GIF, WebP</p>
        </div>
    </div>
    
    <?php if (empty($images)): ?>
        <div class="empty-state">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <h3>Nog geen afbeeldingen</h3>
            <p>Upload uw eerste afbeelding om te beginnen</p>
        </div>
    <?php else: ?>
        <div class="images-grid">
            <?php foreach ($images as $image): ?>
                <div class="image-item" onclick="selectImage('<?php echo h($image['path']); ?>')">
                    <img src="<?php echo h($image['url']); ?>" alt="<?php echo h($image['filename']); ?>">
                    <div class="image-info">
                        <div class="image-name" title="<?php echo h($image['filename']); ?>">
                            <?php echo h($image['filename']); ?>
                        </div>
                        <div class="image-size">
                            <?php echo number_format($image['size'] / 1024, 1); ?> KB
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div class="actions">
        <button class="btn btn-cancel" onclick="window.close()">Annuleren</button>
    </div>
    
    <script>
        function selectImage(imagePath) {
            if (window.opener && window.opener.selectImage) {
                window.opener.selectImage(imagePath);
                window.close();
            }
        }
        
        // Upload functionality
        const uploadZone = document.getElementById('uploadZone');
        const fileInput = document.getElementById('fileInput');

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

        fileInput.addEventListener('change', (e) => {
            handleFiles(e.target.files);
        });

        function handleFiles(files) {
            Array.from(files).forEach(uploadFile);
        }

        function uploadFile(file) {
            if (!file.type.startsWith('image/')) {
                alert('Alleen afbeeldingen zijn toegestaan');
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('Bestand te groot: ' + file.name + ' (max 5MB)');
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
                    // Reload to show new image
                    location.reload();
                } else {
                    alert('Upload mislukt: ' + data.message);
                }
            })
            .catch(error => {
                alert('Upload mislukt: ' + error.message);
            });
        }
    </script>
</body>
</html>
