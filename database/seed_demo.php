<?php
require __DIR__ . '/../app/bootstrap.php';

$db = Database::get();

$db->exec("INSERT INTO categories (name) VALUES ('Boissons'),('Nourriture')");
$db->exec("INSERT INTO articles (category_id, name, price) VALUES 
    (1, 'Whisky bouteille', 10.00),
    (2, 'Viande de bison', 5.00)");

echo "Articles démo insérés.\n";

// Suppression du fichier après exécution
unlink(__FILE__);
