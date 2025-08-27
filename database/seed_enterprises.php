<?php
require __DIR__ . '/../app/bootstrap.php';

$db = Database::get();

// Création entreprise Saloon Strawberry
$db->exec("INSERT INTO enterprises (name, logo, capital, tax_rate, rp_year) 
    VALUES ('Saloon Strawberry', 'logo-saloon.png', 500, 0.10, 1899)");
$enterprise_id = $db->lastInsertId();

// Création admin de l’entreprise
$db->exec("INSERT INTO members (enterprise_id, name, role, salary) 
    VALUES ($enterprise_id, 'Patron', 'ADMIN', 20)");

// Ajout de stock initial
$db->exec("INSERT INTO stock (enterprise_id, name, quantity) VALUES 
    ($enterprise_id, 'Whisky bouteille', 50),
    ($enterprise_id, 'Viande de bison', 20)");

// Transactions démo
$db->exec("INSERT INTO transactions (enterprise_id, type, description, amount) VALUES 
    ($enterprise_id, 'VENTE', 'Vente 5 Whisky', 50),
    ($enterprise_id, 'ACHAT', 'Achat viande bison', 20)");

echo "Entreprise démo créée : Saloon Strawberry\n";

// Suppression du fichier après exécution
unlink(__FILE__);
