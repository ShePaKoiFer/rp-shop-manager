<?php
namespace Core;

class Auth
{
    public static function requireLogin()
    {
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: login.php");
            exit;
        }
    }

    public static function login($user)
    {
        session_start();
        $_SESSION['user'] = $user;
    }

    public static function logout()
    {
        session_start();
        session_destroy();
    }

    public static function user()
    {
        session_start();
        return $_SESSION['user'] ?? null;
    }
}
