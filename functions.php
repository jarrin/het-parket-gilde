<?php


require_once 'config.php';

/**
 * @return array|null
 */
function loadContent() {
    if (!file_exists(CONTENT_FILE)) {
        return null;
    }
    
    $json = file_get_contents(CONTENT_FILE);
    return json_decode($json, true);
}

/**
 * @param array $content
 * @return bool
 */
function saveContent($content) {
    $json = json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    return file_put_contents(CONTENT_FILE, $json) !== false;
}

/**
 * @param string $section
 * @return array|null
 */
function getSection($section) {
    $content = loadContent();
    return $content[$section] ?? null;
}

/**
 * @return PDO
 */
function getDB() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            die("Database connection failed. Please check your configuration. Error: " . $e->getMessage());
        }
    }
    
    return $pdo;
}

/**
 * @return bool
 */
function isAdmin() {
    if (!isset($_SESSION['admin_user_id']) || !isset($_SESSION['session_token'])) {
        return false;
    }
    
    // Verify session in database
    try {
        $db = getDB();
        $stmt = $db->prepare("
            SELECT s.*, u.is_active 
            FROM admin_sessions s
            JOIN admin_users u ON s.user_id = u.id
            WHERE s.session_token = ? 
            AND s.user_id = ? 
            AND s.expires_at > NOW()
            AND u.is_active = 1
        ");
        $stmt->execute([$_SESSION['session_token'], $_SESSION['admin_user_id']]);
        $session = $stmt->fetch();
        
        return $session !== false;
    } catch (PDOException $e) {
        error_log("Session verification failed: " . $e->getMessage());
        return false;
    }
}


function requireAdmin() {
    if (!isAdmin()) {
        header('Location: /admin/login.php');
        exit;
    }
}

/**
 * @param string $username
 * @param string $password
 * @return array ['success' => bool, 'message' => string]
 */
function loginAdmin($username, $password) {
    $db = getDB();
    $ip = $_SERVER['REMOTE_ADDR'];
    
    $stmt = $db->prepare("
        SELECT COUNT(*) as attempts 
        FROM login_attempts 
        WHERE username = ? 
        AND ip_address = ?
        AND attempted_at > DATE_SUB(NOW(), INTERVAL ? MINUTE)
        AND success = 0
    ");
    $stmt->execute([$username, $ip, LOGIN_TIMEOUT]);
    $result = $stmt->fetch();
    
    if ($result['attempts'] >= MAX_LOGIN_ATTEMPTS) {
        return [
            'success' => false, 
            'message' => 'Te veel mislukte pogingen. Probeer het over ' . LOGIN_TIMEOUT . ' minuten opnieuw.'
        ];
    }
    
    $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ? AND is_active = 1");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    $success = false;
    if ($user && password_verify($password, $user['password_hash'])) {
        $success = true;
    }
    
    $stmt = $db->prepare("INSERT INTO login_attempts (username, ip_address, success) VALUES (?, ?, ?)");
    $stmt->execute([$username, $ip, $success ? 1 : 0]);
    
    if (!$success) {
        return ['success' => false, 'message' => 'Ongeldige gebruikersnaam of wachtwoord'];
    }
    
    $sessionToken = bin2hex(random_bytes(32));
    $expiresAt = date('Y-m-d H:i:s', time() + SESSION_LIFETIME);
    
    $stmt = $db->prepare("
        INSERT INTO admin_sessions (user_id, session_token, ip_address, user_agent, expires_at) 
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $user['id'], 
        $sessionToken, 
        $ip, 
        $_SERVER['HTTP_USER_AGENT'] ?? '', 
        $expiresAt
    ]);
    
    // Update last login
    $stmt = $db->prepare("UPDATE admin_users SET last_login = NOW() WHERE id = ?");
    $stmt->execute([$user['id']]);
    
    // Set session variables
    $_SESSION['admin_user_id'] = $user['id'];
    $_SESSION['admin_username'] = $user['username'];
    $_SESSION['session_token'] = $sessionToken;
    
    return ['success' => true, 'message' => 'Succesvol ingelogd'];
}

/**
 * Logout admin user
 */
function logoutAdmin() {
    if (isset($_SESSION['session_token'])) {
        try {
            $db = getDB();
            $stmt = $db->prepare("DELETE FROM admin_sessions WHERE session_token = ?");
            $stmt->execute([$_SESSION['session_token']]);
        } catch (PDOException $e) {
            error_log("Logout error: " . $e->getMessage());
        }
    }
    
    $_SESSION = [];
    session_destroy();
}

/**
 * Clean expired sessions
 */
function cleanExpiredSessions() {
    try {
        $db = getDB();
        $stmt = $db->prepare("DELETE FROM admin_sessions WHERE expires_at < NOW()");
        $stmt->execute();
    } catch (PDOException $e) {
        error_log("Session cleanup error: " . $e->getMessage());
    }
}

/**
 * Get current page name
 * @return string
 */
function getCurrentPage() {
    $page = basename($_SERVER['PHP_SELF'], '.php');
    return $page === 'index' ? 'home' : $page;
}

/**
 * Check if current page is active
 * @param string $page
 * @return bool
 */
function isActivePage($page) {
    return getCurrentPage() === $page;
}

/**
 * Sanitize output
 * @param string $text
 * @return string
 */
function h($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

/**
 * Get navigation items
 * @return array
 */
function getNavigation() {
    return [
        ['url' => '/index.php', 'label' => 'Home', 'page' => 'home'],
        ['url' => '/diensten.php', 'label' => 'Onze Diensten', 'page' => 'diensten'],
        ['url' => '/over-ons.php', 'label' => 'Over Ons', 'page' => 'over-ons'],
        ['url' => '/contact.php', 'label' => 'Contact', 'page' => 'contact']
    ];
}
