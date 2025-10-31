<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define paths
define('ROOT_PATH', __DIR__);
define('DATA_PATH', ROOT_PATH . '/data');
define('CONTENT_FILE', DATA_PATH . '/content.json');

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'het_parket_gilde');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_CHARSET', 'utf8mb4');

// Site settings
define('SITE_NAME', 'Het Parket Gilde');
define('BASE_URL', '/');

// Image upload settings
define('UPLOAD_DIR', ROOT_PATH . '/assets/images/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024);
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/jpg', 'image/webp']);

// Security settings
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 15);
define('SESSION_LIFETIME', 7200);

error_reporting(E_ALL);
ini_set('display_errors', 1);
