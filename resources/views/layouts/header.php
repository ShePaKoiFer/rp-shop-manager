<?php
if (!isset($title)) $title = "RP Shop Manager";
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/rp-shop-manager/public/assets/css/style.css">
    <script src="/rp-shop-manager/public/assets/js/app.js" defer></script>
    <link rel="icon" href="/rp-shop-manager/public/assets/img/favicon.ico">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="/rp-shop-manager/public/dashboard/index.php">RP Shop Manager</a>
            </div>
            <ul>
                <li><a href="/rp-shop-manager/public/dashboard/index.php">Accueil</a></li>
                <li><a href="/rp-shop-manager/public/articles/index.php">Articles</a></li>
                <li><a href="/rp-shop-manager/public/categories/index.php">Catégories</a></li>
                <li><a href="/rp-shop-manager/public/transactions/index.php">Transactions</a></li>
                <li><a href="/rp-shop-manager/public/stock/index.php">Stock</a></li>
                <li><a href="/rp-shop-manager/public/stats/index.php">Statistiques</a></li>
                <li><a href="/rp-shop-manager/public/members/index.php">Membres</a></li>
                <li><a href="/rp-shop-manager/public/enterprises/index.php">Entreprises</a></li>
                <li><a href="/rp-shop-manager/public/logout.php">Déconnexion</a></li>
            </ul>
        </nav>
    </header>
    <main>
