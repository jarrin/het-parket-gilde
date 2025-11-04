<?php
// Start session first
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Error reporting settings to suppress deprecation notices
error_reporting(E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED);

// Autoloader for classes
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);

    $parts = explode('/', $class);
    $classFile = end($parts) . '.php';

    $path = __DIR__ . '/' . $classFile;

    if (file_exists($path)) {
        require_once $path;
    } else {
        $classesPath = __DIR__ . '/classes/' . $classFile;
        if (file_exists($classesPath)) {
            require_once $classesPath;
        }
    }
});

// Initialize Database connection using the singleton pattern
use classes\Database;

try {
    $database = Database::getInstance();
    $db = $database->getConnection();
} catch (Exception $e) {
    error_log("Database initialization failed: " . $e->getMessage());
    // Continue without database if it fails
    $database = null;
    $db = null;
}

