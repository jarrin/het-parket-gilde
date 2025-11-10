<?php
session_start();

header('Content-Type: application/json');

// Check multiple session variables to ensure compatibility
$loggedIn = false;

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    $loggedIn = true;
}

if (isset($_SESSION['admin_user_id'])) {
    $loggedIn = true;
}

echo json_encode([
    'loggedIn' => $loggedIn
]);
