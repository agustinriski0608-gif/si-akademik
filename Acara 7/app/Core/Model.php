<?php

namespace App\Core;

use PDO;

/**
 * Model dasar: membuka koneksi PDO dari config/database.php.
 * (Acara 8 akan memindahkan koneksi ini ke class Database singleton.)
 */
class Model
{
    protected PDO $db;

    public function __construct()
    {
        $config = require dirname(__DIR__, 2) . '/config/database.php';

        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

        $this->db = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        ]);
    }
}
