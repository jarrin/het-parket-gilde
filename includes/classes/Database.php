<?php

namespace classes;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection = null;
    private $config = [];

    /**
     * Private constructor to prevent direct instantiation
     */
    private function __construct()
    {
        $this->loadEnvironmentVariables();
        $this->setConfig();
    }

    /**
     * Load environment variables from .env file
     */
    private function loadEnvironmentVariables()
    {
        $envFile = __DIR__ . '/../../.env';
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
    }

    /**
     * Set database configuration
     */
    private function setConfig()
    {
        $this->config = [
            'host' => getenv('DB_HOST') ?: 'localhost',
            'database' => getenv('DB_NAME') ?: 'parket_guild_db',
            'username' => getenv('DB_USER') ?: 'root',
            'password' => getenv('DB_PASS') ?: '',
            'port' => getenv('DB_PORT') ?: '3306',
            'charset' => 'utf8mb4'
        ];
    }

    /**
     * Get singleton instance
     *
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get PDO connection
     *
     * @return PDO
     */
    public function getConnection()
    {
        if ($this->connection === null) {
            try {
                $dsn = sprintf(
                    "mysql:host=%s;dbname=%s;port=%s;charset=%s",
                    $this->config['host'],
                    $this->config['database'],
                    $this->config['port'],
                    $this->config['charset']
                );

                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];

                $this->connection = new PDO(
                    $dsn,
                    $this->config['username'],
                    $this->config['password'],
                    $options
                );
            } catch (PDOException $e) {
                http_response_code(500);
                $error_message = 'Database connection failed: ' . $e->getMessage();

                // Additional debugging info (only in development)
                if (getenv('APP_DEBUG') == 'true') {
                    $error_message .= sprintf(
                        "\nAttempted to connect to: Host: %s, DB: %s, User: %s, Port: %s",
                        $this->config['host'],
                        $this->config['database'],
                        $this->config['username'],
                        $this->config['port']
                    );
                }

                error_log($error_message);
                die(json_encode([
                    'error' => $error_message,
                    'status' => 'error'
                ]));
            }
        }

        return $this->connection;
    }

    /**
     * Get database configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Test database connection
     *
     * @return bool
     */
    public function testConnection()
    {
        try {
            $pdo = $this->getConnection();
            $pdo->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            error_log('Database connection test failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Prevent cloning of the instance
     */
    private function __clone() {}

    /**
     * Prevent unserialization of the instance
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize singleton");
    }
}