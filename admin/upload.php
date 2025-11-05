<?php
// Prevent any output before headers
error_reporting(0);
ini_set('display_errors', 0);

// Start output buffering to catch any unwanted output
ob_start();

// Start session first before any output
if (session_status() === PHP_SESSION_NONE) {
    @session_start();
}

// Clear any output that might have occurred
ob_clean();

// Set header
header('Content-Type: text/plain');

// Check authentication
if (!isset($_SESSION['admin_user_id']) && !isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    die('ERROR: Unauthorized - Please login first');
}

// Define constants
define('ROOT_PATH', dirname(__DIR__));
define('UPLOAD_PATH', ROOT_PATH . '/assets/images');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    die('ERROR: Method not allowed');
}

if (!isset($_FILES['image'])) {
    http_response_code(400);
    die('ERROR: No file uploaded');
}

$file = $_FILES['image'];
$oldImagePath = $_POST['old_image'] ?? '';

// Validate file
if ($file['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    die('ERROR: File upload error: ' . $file['error']);
}

// Check file size (10MB)
$maxSize = 10 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    http_response_code(400);
    die('ERROR: File too large. Max size: 10MB');
}

// Check file type
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $file['tmp_name']);
finfo_close($finfo);

if (!in_array($mimeType, $allowedTypes)) {
    http_response_code(400);
    die('ERROR: Invalid file type. Allowed: JPEG, PNG, GIF, WebP');
}

// Generate unique filename
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
if (empty($extension)) {
    $extension = 'jpg';
}
$filename = uniqid('img_') . '_' . time() . '.' . $extension;
$destination = UPLOAD_PATH . '/' . $filename;

// Ensure upload directory exists
if (!file_exists(UPLOAD_PATH)) {
    mkdir(UPLOAD_PATH, 0755, true);
}

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $destination)) {
    // Delete old image if provided and it's in assets/images
    if (!empty($oldImagePath) && strpos($oldImagePath, 'assets/images/') === 0) {
        $oldImageFullPath = ROOT_PATH . '/' . $oldImagePath;
        if (file_exists($oldImageFullPath) && is_file($oldImageFullPath)) {
            // Only delete uploaded images (start with img_)
            $oldFilename = basename($oldImagePath);
            if (strpos($oldFilename, 'img_') === 0) {
                @unlink($oldImageFullPath);
            }
        }
    }
    
    $relativePath = 'assets/images/' . $filename;
    echo 'SUCCESS:' . $relativePath;
} else {
    http_response_code(500);
    die('ERROR: Failed to move uploaded file');
}