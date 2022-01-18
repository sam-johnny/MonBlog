<?php

namespace App;

use \PDO;

class Database
{

    public static function getPDO(): PDO
    {
        $db_name = getenv('DB_NAME');
        $db_user = getenv('DB_USER');
        $db_pass = getenv('DB_PASS');
        $db_host = getenv('DB_HOST');

        return new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}