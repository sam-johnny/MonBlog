<?php

namespace App;

use App\Security\ForbiddenException;

class Auth
{
    public static function loginAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SESSION['auth']['role'] !== 'admin'){
            throw new ForbiddenException();
        }

        if (!isset($_SESSION['auth'])) {
            throw new ForbiddenException();
        }
    }

    public static function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }


}