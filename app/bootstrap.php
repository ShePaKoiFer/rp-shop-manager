<?php
// Charger config
$config = require __DIR__ . '/config/.env.php';

// Autoload des classes Core\
spl_autoload_register(function ($class) {
    if (strpos($class, 'Core\\') === 0) {
        $path = __DIR__ . '/core/' . str_replace('Core\\', '', $class) . '.php';
        if (file_exists($path)) {
            require $path;
        }
    }
});

// Helpers globaux
function dd($var) {
    echo "<pre>";
    var_dump($var);
    echo "</pre>";
    die();
}

// Initialiser la connexion DB
use Core\Database;
Database::init($config);
