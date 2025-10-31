<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Load environment variables from .env file
$envFile = __DIR__ . '/.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            putenv("$name=$value");
            $_ENV[$name] = $value;
        }
    }
}

// Define paths
define('ROOT_PATH', __DIR__);
define('DATA_PATH', ROOT_PATH . '/data');
define('CONTENT_FILE', DATA_PATH . '/content.json');
define('UPLOAD_PATH', ROOT_PATH . '/assets/images');

// Database configuration
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'parket_guild_db');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_CHARSET', 'utf8mb4');

// Site settings
define('SITE_NAME', 'Het Parket Gilde');
define('BASE_URL', '/');

// Security settings
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 15); // minutes
define('SESSION_LIFETIME', 7200); // 2 hours in seconds

// Upload settings
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
