<?php

namespace App\Core;

use PDO;

/**
 * Class Database bertugas mengelola koneksi ke database memakai PDO.
 * Object ini TIDAK dibuat sendiri oleh Repository/Model, tetapi
 * disuntikkan (constructor injection) dari luar lewat Container.
 */
class Database
{
    private PDO $connection;

    public function __construct(?array $config = null)
    {
        $config ??= require dirname(__DIR__, 2) . '/config/database.php';

        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";

        $this->connection = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
