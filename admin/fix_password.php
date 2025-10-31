<?php
require_once '../functions.php';

// Enable error display
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>Password Hash Fixer</h1>";
echo "<style>body{font-family:sans-serif;padding:20px;}pre{background:#f4f4f4;padding:15px;border-radius:5px;}.success{color:green;}.error{color:red;}</style>";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $newPassword = $_POST['password'] ?? '';

    if (empty($username) || empty($newPassword)) {
        echo "<p class='error'>Please provide both username and password.</p>";
    } else {
        try {
            $db = getDB();

            // Check if user exists
            $stmt = $db->prepare("SELECT id, username FROM admin_users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if (!$user) {
                echo "<p class='error'>✗ User '$username' not found!</p>";
            } else {
                // Generate proper bcrypt hash
                $passwordHash = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the user's password
                $stmt = $db->prepare("UPDATE admin_users SET password_hash = ? WHERE username = ?");
                $stmt->execute([$passwordHash, $username]);

                echo "<div style='background:#d4edda;padding:20px;border-radius:5px;border-left:4px solid #28a745;'>";
                echo "<h2 class='success'>✓ Password Updated Successfully!</h2>";
                echo "<p><strong>Username:</strong> $username</p>";
                echo "<p><strong>New Password:</strong> $newPassword</p>";
                echo "<p><strong>Password Hash:</strong> $passwordHash</p>";
                echo "<p>You can now login with these credentials at: <a href='/admin/login.php'>/admin/login.php</a></p>";
                echo "</div>";

                // Verify it works
                echo "<h3>Verification Test:</h3>";
                if (password_verify($newPassword, $passwordHash)) {
                    echo "<p class='success'>✓ Password verification test passed!</p>";
                } else {
                    echo "<p class='error'>✗ Password verification test failed!</p>";
                }
            }
        } catch (Exception $e) {
            echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
        }
    }

    echo "<hr>";
    echo "<p><a href='fix_password.php'>← Fix Another Password</a> | <a href='login.php'>Go to Login</a></p>";

} else {
    echo "<p>This tool will fix invalid password hashes in your database by generating proper bcrypt hashes.</p>";

    // Show users with invalid hashes
    try {
        $db = getDB();
        $stmt = $db->query("SELECT id, username, password_hash FROM admin_users");
        $users = $stmt->fetchAll();

        echo "<h2>Current Admin Users:</h2>";
        echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
        echo "<tr><th>ID</th><th>Username</th><th>Password Hash</th><th>Status</th></tr>";

        foreach ($users as $user) {
            $isValid = (strlen($user['password_hash']) == 60 && strpos($user['password_hash'], '$2y$') === 0);
            $status = $isValid ? "<span class='success'>✓ Valid</span>" : "<span class='error'>✗ Invalid</span>";

            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td><strong>{$user['username']}</strong></td>";
            echo "<td style='font-family:monospace;font-size:11px;'>{$user['password_hash']}</td>";
            echo "<td>$status</td>";
            echo "</tr>";
        }
        echo "</table>";

    } catch (Exception $e) {
        echo "<p class='error'>Error fetching users: " . $e->getMessage() . "</p>";
    }

    echo "<hr>";
    echo "<h2>Fix Password for User:</h2>";
    echo "<form method='POST'>";
    echo "<p><label><strong>Username:</strong><br><input type='text' name='username' required style='padding:8px;width:300px;'></label></p>";
    echo "<p><label><strong>New Password:</strong><br><input type='text' name='password' required style='padding:8px;width:300px;'></label></p>";
    echo "<p><small>Note: Use 'text' type so you can see the password you're setting</small></p>";
    echo "<p><button type='submit' style='padding:10px 20px;background:#667eea;color:white;border:none;border-radius:4px;cursor:pointer;'>Update Password</button></p>";
    echo "</form>";

    echo "<hr>";
    echo "<h3>Quick Fix for 'test' User:</h3>";
    echo "<form method='POST'>";
    echo "<input type='hidden' name='username' value='test'>";
    echo "<input type='hidden' name='password' value='test-12345'>";
    echo "<button type='submit' style='padding:10px 20px;background:#28a745;color:white;border:none;border-radius:4px;cursor:pointer;'>Fix 'test' user password (set to: test-12345)</button>";
    echo "</form>";
}
?>

