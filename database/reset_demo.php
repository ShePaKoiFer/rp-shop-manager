<?php
require __DIR__ . '/../app/bootstrap.php';

$db = Database::get();

// Nettoyage des données (on garde le super admin)
$db->exec("DELETE FROM enterprises");
$db->exec("DELETE FROM members");
$db->exec("DELETE FROM articles");
$db->exec("DELETE FROM categories");
$db->exec("DELETE FROM transactions");
$db->exec("DELETE FROM stock");
$db->exec("DELETE FROM enterprise_reports");

// Réinjection des seeds
require __DIR__ . '/seed_demo.php';
require __DIR__ . '/seed_enterprises.php';

echo "Base réinitialisée avec les données démo.\n";

// Suppression du fichier après exécution
unlink(__FILE__);
