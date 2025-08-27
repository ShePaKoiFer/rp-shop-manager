<?php
namespace Core;

use PDO;
use PDOException;

class Database
{
    private static $instance;

    public static function init($config)
    {
        if (!self::$instance) {
            $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']}";

            try {
                self::$instance = new PDO($dsn, $config['db_user'], $config['db_pass'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);

                // ⚡ Forcer l'encodage UTF-8 classique (compatible MariaDB 10.x et MySQL 5.x)
                self::$instance->exec("SET NAMES 'utf8'");
                self::$instance->exec("SET CHARACTER SET utf8");

            } catch (PDOException $e) {
                die("Erreur connexion DB : " . $e->getMessage());
            }
        }
    }

    public static function get()
    {
        return self::$instance;
    }
}
