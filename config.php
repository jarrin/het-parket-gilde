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

// Security settings
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 15); // minutes
define('SESSION_LIFETIME', 7200); // 2 hours in seconds

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
