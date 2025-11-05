<?php
session_start();
require_once __DIR__ . '/../functions.php';

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) && !isset($_SESSION['admin_user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Niet ingelogd']);
    exit;
}

// Get JSON input
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);

// Debug logging
error_log("Live Edit - Raw input: " . $rawInput);
error_log("Live Edit - Parsed input: " . print_r($input, true));

if (!$input || !isset($input['page']) || !isset($input['path']) || !isset($input['value'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'error' => 'Ongeldige input',
        'debug' => [
            'has_input' => !empty($input),
            'has_page' => isset($input['page']),
            'has_path' => isset($input['path']),
            'has_value' => isset($input['value']),
            'received' => $input
        ]
    ]);
    exit;
}

$page = $input['page'];
$path = $input['path'];
$value = $input['value'];

// Load content
$content = loadContent();

// Update content based on path
// Path format: "hero.title", "services.0.title", etc.
$pathParts = explode('.', $path);

// Navigate to correct location and update
$current = &$content[$page];

for ($i = 0; $i < count($pathParts) - 1; $i++) {
    $part = $pathParts[$i];
    
    // Handle array indices
    if (is_numeric($part)) {
        $part = (int)$part;
    }
    
    if (!isset($current[$part])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => 'Pad niet gevonden']);
        exit;
    }
    
    $current = &$current[$part];
}

// Set the final value
$lastKey = end($pathParts);
if (is_numeric($lastKey)) {
    $lastKey = (int)$lastKey;
}

$current[$lastKey] = $value;

// Save content
if (saveContent($content)) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Kon niet opslaan']);
}
