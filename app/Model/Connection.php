<?php

namespace app\Model;

class Connection
{
    private static $conn = NULL;

    private function __constructor(){}

    static function getConnection()
    {
        if (is_null(self::$conn)){
            self::$conn = new \PDO('mysql:host=localhost;dbname=socialnet_db;charset=UTF8', 'root', '');
        }

        return self::$conn;
    }
}