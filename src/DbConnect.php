<?php

namespace App;

use \PDO;

class DbConnect
{
    public static function getPDO(): PDO
    {
        return new PDO('mysql:host=localhost;dbname=db_myblog', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}