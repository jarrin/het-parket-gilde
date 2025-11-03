<?php
ob_start(); // Start output buffering
require_once '../functions.php';
requireAdmin();
ob_end_clean(); // Clear buffer before sending JSON

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

if (!isset($_FILES['image'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'No file uploaded']);
    exit;
}

$file = $_FILES['image'];

// Validate file
if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'File upload error: ' . $file['error']]);
    exit;
}

// Check file size
if ($file['size'] > MAX_FILE_SIZE) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'File too large. Max size: ' . (MAX_FILE_SIZE / 1024 / 1024) . 'MB']);
    exit;
}

// Check file type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, ALLOWED_IMAGE_TYPES)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid file type. Allowed: JPEG, PNG, GIF, WebP']);
    exit;
}

// Generate unique filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid('img_') . '_' . time() . '.' . $extension;
$destination = UPLOAD_PATH . '/' . $filename;

// Ensure upload directory exists
if (!file_exists(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755, true);
}

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $destination)) {
    $relativePath = 'assets/images/' . $filename;
    echo json_encode([
        'success' => true,
        'message' => 'File uploaded successfully',
        'path' => $relativePath,
        'filename' => $filename
    ]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to move uploaded file']);
}

