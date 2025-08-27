<?php
require_once __DIR__ . '/../app/bootstrap.php';

use Core\Auth;
use Core\View;
use Core\Dashboard;

// Vérifie si l’utilisateur est connecté
Auth::requireLogin();

// Récupérer les stats de l’entreprise par défaut (ex : Saloon Strawberry)
$stats = Dashboard::getStats();

// Afficher la vue Dashboard
View::render('dashboard/index.php', [
    'title'    => 'Tableau de bord',
    'revenus'  => $stats['revenus'],
    'depenses' => $stats['depenses'],
    'benefice' => $stats['benefice'],
]);
