<?php

namespace App\Core;

use PDO;

/**
 * Koneksi database dengan pola Singleton:
 * seluruh aplikasi memakai satu koneksi PDO yang sama.
 */
class Database
{
    private static ?PDO $instance = null;

    // Constructor private agar tidak bisa di-new dari luar
    private function __construct()
    {
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            $config = require dirname(__DIR__, 2) . '/config/database.php';

            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

            self::$instance = new PDO($dsn, $config['username'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }

        return self::$instance;
    }
}
