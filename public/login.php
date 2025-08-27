<?php
require_once __DIR__ . '/../app/bootstrap.php';

use Core\Auth;
use Core\CSRF;

// Vérification si l'utilisateur est déjà connecté
if (Auth::check()) {
    header('Location: index.php');
    exit;
}

// Traitement du formulaire de connexion
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification du token CSRF
    if (!CSRF::validateToken($_POST['csrf_token'] ?? '')) {
        $error = "Sécurité CSRF : formulaire invalide.";
    } else {
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (Auth::attempt($email, $password)) {
            header('Location: index.php');
            exit;
        } else {
            $error = "Identifiants invalides.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="login-page">
    <div class="login-box">
        <h2>Connexion</h2>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <?= \Core\CSRF::getTokenInput() ?>

            <div class="form-group">
                <label>Email :</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Mot de passe :</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>
