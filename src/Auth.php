<?php

namespace App;

use App\Security\ForbiddenException;

class Auth
{

    /**
     * Accès administrateur
     *
     * @throws ForbiddenException
     */
    public static function loginAdmin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['auth'])) {
            header('Location: ' . "/login?forbidden=1");
            exit();
        }

        if ($_SESSION['auth']['role'] !== 'admin') {
            header('Location: ' . "/login?forbidden=1");
            exit();
        }
    }

    /**
     * Pour lançer session_start
     *
     */
    public static function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


}
