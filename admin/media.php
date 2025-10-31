﻿<?php
require_once '../functions.php';
requireAdmin();

// Handle delete request
if (isset($_POST['delete']) && isset($_POST['filename'])) {
    $filename = basename($_POST['filename']); // Security: prevent directory traversal
    $filepath = UPLOAD_PATH . '/' . $filename;

    if (file_exists($filepath) && unlink($filepath)) {
        $message = ['type' => 'success', 'text' => 'Afbeelding succesvol verwijderd'];
    } else {
        $message = ['type' => 'error', 'text' => 'Kon afbeelding niet verwijderen'];
    }
}

// Get all images
$images = [];
if (file_exists(UPLOAD_PATH)) {
    $files = scandir(UPLOAD_PATH);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $filepath = UPLOAD_PATH . '/' . $file;
            if (is_file($filepath) && @getimagesize($filepath)) {
                $images[] = [
                    'filename' => $file,
                    'path' => 'assets/images/' . $file,
                    'size' => filesize($filepath),
                    'modified' => filemtime($filepath),
                    'url' => '/assets/images/' . $file
                ];
            }
        }
    }

    // Sort by modified date, newest first
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
    <title>Media Manager - Het Parket Gilde</title>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <style>
        .media-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }
        .media-item {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            overflow: hidden;
            background: white;
            transition: all 0.3s;
        }
        .media-item:hover {
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-2px);
        }
        .media-thumbnail {
            width: 100%;
            height: 150px;
            object-fit: cover;
            cursor: pointer;
        }
        .media-info {
            padding: 12px;
        }
        .media-filename {
            font-size: 12px;
            color: #2c3e50;
            margin-bottom: 8px;
            word-break: break-all;
            font-weight: 600;
        }
        .media-meta {
            font-size: 11px;
            color: #7f8c8d;
            margin-bottom: 10px;
        }
        .media-actions {
            display: flex;
            gap: 8px;
        }
        .btn-copy {
            flex: 1;
            padding: 6px 12px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-copy:hover {
            background: #2980b9;
        }
        .btn-delete {
            padding: 6px 12px;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 12px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-delete:hover {
            background: #c0392b;
        }
        .upload-zone {
            border: 3px dashed #d0d0d0;
            border-radius: 8px;
            padding: 40px;
            text-align: center;
            background: #fafafa;
            margin-bottom: 30px;
            transition: all 0.3s;
        }
        .upload-zone:hover, .upload-zone.dragover {
            border-color: #667eea;
            background: #f0f0ff;
        }
        .upload-zone input[type="file"] {
            display: none;
        }
        .upload-zone label {
            display: inline-block;
            padding: 12px 30px;
            background: #667eea;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s;
        }
        .upload-zone label:hover {
            background: #5568d3;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 10000;
            justify-content: center;
            align-items: center;
        }
        .modal.show {
            display: flex;
        }
        .modal-content {
            max-width: 90%;
            max-height: 90%;
        }
        .modal img {
            max-width: 100%;
            max-height: 90vh;
            border-radius: 8px;
        }
        .modal-close {
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 40px;
            color: white;
            cursor: pointer;
            background: none;
            border: none;
        }
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
        }
        .empty-state svg {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
            opacity: 0.3;
        }
    </style>
</head>
<body>
    <header class="admin-header">
        <div class="container">
            <h1>Media Manager - Het Parket Gilde</h1>
            <nav class="admin-nav">
                <a href="/admin/">Terug naar Admin</a>
                <a href="/">Website Bekijken</a>
                <a href="/admin/logout.php">Uitloggen</a>
            </nav>
        </div>
    </header>

    <div class="admin-container">
        <div class="admin-panel">
            <div class="content-area" style="max-width: 1400px; margin: 0 auto;">
                <?php if (isset($message)): ?>
                    <div class="message <?php echo $message['type']; ?>">
                        <?php echo h($message['text']); ?>
                    </div>
                <?php endif; ?>

                <h2>Upload Nieuwe Afbeeldingen</h2>
                <div class="upload-zone" id="uploadZone">
                    <input type="file" id="fileInput" accept="image/*" multiple>
                    <label for="fileInput">📁 Selecteer Afbeeldingen</label>
                    <p style="margin-top: 15px; color: #7f8c8d;">Of sleep afbeeldingen hierheen</p>
                    <p style="font-size: 13px; color: #95a5a6; margin-top: 10px;">
                        Maximaal 5MB per bestand • JPEG, PNG, GIF, WebP
                    </p>
                </div>

                <h2>Geüploade Afbeeldingen (<?php echo count($images); ?>)</h2>

                <?php if (empty($images)): ?>
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h3>Nog geen afbeeldingen</h3>
                        <p>Upload afbeeldingen om ze te beheren en te gebruiken op uw website.</p>
                    </div>
                <?php else: ?>
                    <div class="media-grid">
                        <?php foreach ($images as $image): ?>
                            <div class="media-item">
                                <img src="<?php echo h($image['url']); ?>"
                                     alt="<?php echo h($image['filename']); ?>"
                                     class="media-thumbnail"
                                     onclick="showModal('<?php echo h($image['url']); ?>')">
                                <div class="media-info">
                                    <div class="media-filename" title="<?php echo h($image['filename']); ?>">
                                        <?php echo h(strlen($image['filename']) > 30 ? substr($image['filename'], 0, 27) . '...' : $image['filename']); ?>
                                    </div>
                                    <div class="media-meta">
                                        <?php echo number_format($image['size'] / 1024, 1); ?> KB •
                                        <?php echo date('d-m-Y H:i', $image['modified']); ?>
                                    </div>
                                    <div class="media-actions">
                                        <button class="btn-copy" onclick="copyPath('<?php echo h($image['path']); ?>')">
                                            📋 Kopieer Pad
                                        </button>
                                        <form method="POST" style="display: inline;" onsubmit="return confirm('Weet u zeker dat u deze afbeelding wilt verwijderen?');">
                                            <input type="hidden" name="filename" value="<?php echo h($image['filename']); ?>">
                                            <button type="submit" name="delete" class="btn-delete">🗑️</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="modal" id="imageModal" onclick="hideModal()">
        <button class="modal-close" onclick="hideModal()">×</button>
        <div class="modal-content">
            <img id="modalImage" src="" alt="Full size">
        </div>
    </div>

    <script>
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
                alert('✓ Pad gekopieerd naar klembord: ' + path);
            });
        }

        function showModal(url) {
            document.getElementById('modalImage').src = url;
            document.getElementById('imageModal').classList.add('show');
        }

        function hideModal() {
            document.getElementById('imageModal').classList.remove('show');
        }

        // Close modal on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                hideModal();
            }
        });
    </script>
</body>
</html>
