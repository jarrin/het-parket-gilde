<?php
/**
 * Admin User Creation Script
 * Run this file once to create a new admin user
 */

require_once '../config.php';
require_once '../functions.php';

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $email = trim($_POST['email'] ?? '');
    
    if (empty($username) || empty($password)) {
        $message = 'Gebruikersnaam en wachtwoord zijn verplicht';
    } elseif (strlen($password) < 8) {
        $message = 'Wachtwoord moet minimaal 8 karakters bevatten';
    } else {
        try {
            $db = getDB();
            
            // Check if username already exists
            $stmt = $db->prepare("SELECT id FROM admin_users WHERE username = ?");
            $stmt->execute([$username]);
            
            if ($stmt->fetch()) {
                $message = 'Deze gebruikersnaam bestaat al';
            } else {
                // Create user
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $db->prepare("INSERT INTO admin_users (username, password_hash, email) VALUES (?, ?, ?)");
                $stmt->execute([$username, $passwordHash, $email]);
                
                $success = true;
                $message = 'Admin gebruiker succesvol aangemaakt! U kunt nu inloggen.';
            }
        } catch (PDOException $e) {
            $message = 'Database fout: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Gebruiker Aanmaken - Het Parket Gilde</title>
    <link rel="stylesheet" href="/assets/css/login.css">
    <style>
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            border: 1px solid #c3e6cb;
        }
        .info-text {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 4px solid #3498db;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Admin Gebruiker Aanmaken</h1>
            
            <div class="info-text">
                <strong>Let op:</strong> Verwijder dit bestand (setup_admin.php) na het aanmaken van uw admin account voor de veiligheid.
            </div>
            
            <?php if ($message): ?>
                <div class="<?php echo $success ? 'success-message' : 'error-message'; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="back-link">
                    <a href="/admin/login.php">Ga naar login pagina</a>
                </div>
            <?php else: ?>
                <form method="POST">
                    <div class="login-form-group">
                        <label for="username">Gebruikersnaam *</label>
                        <input type="text" id="username" name="username" required autofocus>
                    </div>
                    
                    <div class="login-form-group">
                        <label for="password">Wachtwoord * (minimaal 8 karakters)</label>
                        <input type="password" id="password" name="password" required minlength="8">
                    </div>
                    
                    <div class="login-form-group">
                        <label for="email">E-mail (optioneel)</label>
                        <input type="email" id="email" name="email">
                    </div>
                    
                    <button type="submit" class="btn-login">Admin Aanmaken</button>
                </form>
                
                <div class="back-link">
                    <a href="/admin/login.php">Terug naar login</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
