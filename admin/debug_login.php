<?php
require_once '../functions.php';

// Enable error display for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Login Debug Information</h1>";
echo "<style>body{font-family:sans-serif;padding:20px;}pre{background:#f4f4f4;padding:15px;border-radius:5px;}</style>";

// Test database connection
echo "<h2>1. Database Connection Test</h2>";
try {
    echo "<pre>";
    echo "DB_HOST: " . DB_HOST . "\n";
    echo "DB_NAME: " . DB_NAME . "\n";
    echo "DB_USER: " . DB_USER . "\n";
    echo "DB_PORT: " . DB_PORT . "\n";
    echo "</pre>";

    $db = getDB();
    echo "<p style='color:green;'>✓ Database connection successful!</p>";

    // Test query
    $stmt = $db->query("SELECT 1 as test");
    $result = $stmt->fetch();
    if ($result['test'] == 1) {
        echo "<p style='color:green;'>✓ Database query test successful!</p>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

// Check if tables exist
echo "<h2>2. Database Tables Check</h2>";
try {
    $db = getDB();
    $tables = ['admin_users', 'admin_sessions', 'login_attempts'];

    foreach ($tables as $table) {
        $stmt = $db->query("SHOW TABLES LIKE '$table'");
        if ($stmt->rowCount() > 0) {
            echo "<p style='color:green;'>✓ Table '$table' exists</p>";

            // Count rows
            $stmt = $db->query("SELECT COUNT(*) as count FROM $table");
            $result = $stmt->fetch();
            echo "<p style='margin-left:20px;'>→ Contains {$result['count']} row(s)</p>";
        } else {
            echo "<p style='color:red;'>✗ Table '$table' is missing!</p>";
        }
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>Error checking tables: " . $e->getMessage() . "</p>";
}

// List admin users
echo "<h2>3. Admin Users</h2>";
try {
    $db = getDB();
    $stmt = $db->query("SELECT id, username, email, is_active, created_at, last_login FROM admin_users");
    $users = $stmt->fetchAll();

    if (empty($users)) {
        echo "<p style='color:orange;'>⚠ No admin users found in database!</p>";
        echo "<p>You need to create an admin user at: <a href='/tools/setup_admin.php'>/tools/setup_admin.php</a></p>";
    } else {
        echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Active</th><th>Created</th><th>Last Login</th></tr>";
        foreach ($users as $user) {
            $active_color = $user['is_active'] ? 'green' : 'red';
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td><strong>{$user['username']}</strong></td>";
            echo "<td>{$user['email']}</td>";
            echo "<td style='color:$active_color;'>" . ($user['is_active'] ? 'Yes' : 'No') . "</td>";
            echo "<td>{$user['created_at']}</td>";
            echo "<td>{$user['last_login']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>Error fetching users: " . $e->getMessage() . "</p>";
}

// Test login with POST data
echo "<h2>4. Test Login</h2>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    echo "<h3>Login Attempt for: " . htmlspecialchars($username) . "</h3>";

    try {
        $db = getDB();

        // Check if user exists
        $stmt = $db->prepare("SELECT * FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if (!$user) {
            echo "<p style='color:red;'>✗ User '$username' not found in database</p>";
        } else {
            echo "<p style='color:green;'>✓ User found!</p>";
            echo "<pre>";
            echo "User ID: {$user['id']}\n";
            echo "Username: {$user['username']}\n";
            echo "Email: {$user['email']}\n";
            echo "Is Active: " . ($user['is_active'] ? 'Yes' : 'No') . "\n";
            echo "Password Hash: {$user['password_hash']}\n";
            echo "</pre>";

            // Validate password hash format
            $isValidHash = (strlen($user['password_hash']) == 60 && strpos($user['password_hash'], '$2y$') === 0);
            if (!$isValidHash) {
                echo "<div style='background:#fff3cd;padding:15px;border-left:4px solid #ffc107;margin:15px 0;'>";
                echo "<p style='color:#856404;margin:0;'><strong>⚠ WARNING: Invalid Password Hash!</strong></p>";
                echo "<p style='color:#856404;margin:5px 0 0 0;'>The password hash is not a valid bcrypt hash. It should start with '$2y$' and be 60 characters long.</p>";
                echo "<p style='color:#856404;margin:5px 0 0 0;'><strong>Fix this:</strong> Visit <a href='/admin/fix_password.php' style='color:#856404;text-decoration:underline;'>Password Fix Tool</a></p>";
                echo "</div>";
            }

            // Check if active
            if (!$user['is_active']) {
                echo "<p style='color:red;'>✗ User account is not active!</p>";
            } else {
                echo "<p style='color:green;'>✓ User account is active</p>";
            }

            // Test password
            if (password_verify($password, $user['password_hash'])) {
                echo "<p style='color:green;'>✓ Password is correct!</p>";

                // Try full login
                $result = loginAdmin($username, $password);
                if ($result['success']) {
                    echo "<p style='color:green;'>✓ Login function returned success!</p>";
                    echo "<p>Session variables set:</p>";
                    echo "<pre>";
                    print_r($_SESSION);
                    echo "</pre>";
                } else {
                    echo "<p style='color:red;'>✗ Login function failed: {$result['message']}</p>";
                }
            } else {
                echo "<p style='color:red;'>✗ Password is incorrect!</p>";
                echo "<p>Note: The password you entered does not match the hash in the database.</p>";
                echo "<div style='background:#f8d7da;padding:15px;border-left:4px solid #dc3545;margin:15px 0;'>";
                echo "<p style='color:#721c24;margin:0;'><strong>Password Issue Detected!</strong></p>";
                echo "<p style='color:#721c24;margin:5px 0;'>The password hash might be invalid or the password is wrong.</p>";
                echo "<p style='color:#721c24;margin:5px 0;'><strong>Quick Fix:</strong></p>";
                echo "<ul style='color:#721c24;margin:5px 0;'>";
                echo "<li>Visit <a href='/admin/fix_password.php' style='color:#721c24;text-decoration:underline;'>Password Fix Tool</a> to update the password hash</li>";
                echo "<li>Or verify you're using the correct password</li>";
                echo "</ul>";
                echo "</div>";
            }
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>Error during login test: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<form method='POST'>";
    echo "<p><label>Username: <input type='text' name='username' required></label></p>";
    echo "<p><label>Password: <input type='password' name='password' required></label></p>";
    echo "<p><button type='submit'>Test Login</button></p>";
    echo "</form>";
}

// Check recent login attempts
echo "<h2>5. Recent Login Attempts</h2>";
try {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM login_attempts ORDER BY attempted_at DESC LIMIT 10");
    $attempts = $stmt->fetchAll();

    if (empty($attempts)) {
        echo "<p>No login attempts recorded yet.</p>";
    } else {
        echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
        echo "<tr><th>Username</th><th>IP</th><th>Success</th><th>Time</th></tr>";
        foreach ($attempts as $attempt) {
            $success_color = $attempt['success'] ? 'green' : 'red';
            echo "<tr>";
            echo "<td>{$attempt['username']}</td>";
            echo "<td>{$attempt['ip_address']}</td>";
            echo "<td style='color:$success_color;'>" . ($attempt['success'] ? 'Yes' : 'No') . "</td>";
            echo "<td>{$attempt['attempted_at']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
} catch (Exception $e) {
    echo "<p style='color:red;'>Error fetching login attempts: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><a href='login.php'>← Back to Login Page</a></p>";
?>

