<?php
ob_start(); // Start output buffering to prevent header warnings
require_once '../functions.php';
requireAdmin();
ob_end_flush(); // Flush the buffer after authentication

// Handle delete all request
if (isset($_POST['delete_all']) && $_POST['delete_all'] === 'confirm') {
    $deletedCount = 0;
    $errorCount = 0;
    
    if (file_exists(UPLOAD_PATH)) {
        $files = scandir(UPLOAD_PATH);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && $file !== 'README.md') {
                $filepath = UPLOAD_PATH . '/' . $file;
                if (is_file($filepath)) {
                    if (unlink($filepath)) {
                        $deletedCount++;
                    } else {
                        $errorCount++;
                    }
                }
            }
        }
    }
    
    if ($deletedCount > 0) {
        $message = ['type' => 'success', 'text' => "$deletedCount afbeelding(en) succesvol verwijderd"];
    } elseif ($errorCount > 0) {
        $message = ['type' => 'error', 'text' => "Kon $errorCount afbeelding(en) niet verwijderen"];
    } else {
        $message = ['type' => 'info', 'text' => 'Geen afbeeldingen om te verwijderen'];
    }
}

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
    <link rel="stylesheet" href="/assets/css/media.css">
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
                    <label for="fileInput">Selecteer Afbeeldingen</label>
                    <p class="upload-hint">Of sleep afbeeldingen hierheen</p>
                    <p class="upload-info">
                        Maximaal 5MB per bestand - JPEG, PNG, GIF, WebP
                    </p>
                </div>

                <div class="images-header">
                    <h2>Geüploade Afbeeldingen (<?php echo count($images); ?>)</h2>
                    <?php if (!empty($images)): ?>
                        <form method="POST" class="delete-all-form" onsubmit="return confirm('WAARSCHUWING: Weet u ZEKER dat u ALLE <?php echo count($images); ?> afbeeldingen wilt verwijderen? Dit kan NIET ongedaan worden gemaakt!');">
                            <input type="hidden" name="delete_all" value="confirm">
                            <button type="submit" class="btn-delete-all">
                                Verwijder Alle Afbeeldingen
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

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
                                     data-modal-url="<?php echo h($image['url']); ?>">
                                <div class="media-info">
                                    <div class="media-filename" title="<?php echo h($image['filename']); ?>">
                                        <?php echo h(strlen($image['filename']) > 30 ? substr($image['filename'], 0, 27) . '...' : $image['filename']); ?>
                                    </div>
                                    <div class="media-meta">
                                        <?php echo number_format($image['size'] / 1024, 1); ?> KB •
                                        <?php echo date('d-m-Y H:i', $image['modified']); ?>
                                    </div>
                                    <div class="media-actions">
                                        <button class="btn-copy" data-path="<?php echo h($image['path']); ?>">
                                            Kopieer Pad
                                        </button>
                                        <form method="POST" class="delete-form" data-confirm="Weet u zeker dat u deze afbeelding wilt verwijderen?">
                                            <input type="hidden" name="filename" value="<?php echo h($image['filename']); ?>">
                                            <button type="submit" name="delete" class="btn-delete">Verwijder</button>
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

    <div class="modal" id="imageModal">
        <button class="modal-close">×</button>
        <div class="modal-content">
            <img id="modalImage" src="" alt="Full size">
        </div>
    </div>

    <script src="/assets/js/media.js"></script>
</body>
</html>

