<?php
require_once '../functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $result = loginAdmin($username, $password);
    
    if ($result['success']) {
        header('Location: /admin/');
        exit;
    } else {
        $error = $result['message'];
    }
}

if (isAdmin()) {
    header('Location: /admin/');
    exit;
}

cleanExpiredSessions();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Het Parket Gilde</title>
    <link rel="stylesheet" href="/assets/css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>Admin Login</h1>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo h($error); ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="login-form-group">
                    <label for="username">Gebruikersnaam</label>
                    <input type="text" id="username" name="username" required autofocus autocomplete="username">
                </div>
                
                <div class="login-form-group">
                    <label for="password">Wachtwoord</label>
                    <input type="password" id="password" name="password" required autocomplete="current-password">
                </div>
                
                <button type="submit" class="btn-login">Inloggen</button>
            </form>
            
            <div class="back-link">
                <a href="/">Terug naar website</a>
            </div>
        </div>
    </div>
</body>
</html>
