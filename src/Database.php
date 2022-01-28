<?php

namespace App;

use \PDO;

class Database
{

    /**
     * Connection à la base de données
     *
     * @return PDO
     */
    public static function getPDO(): PDO
    {
        $db_name = 'db_myblog';
        $db_user = 'root';
        $db_pass = 'root';
        $db_host = 'localhost';

        return new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}