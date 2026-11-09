<?php

namespace App\Core;

use PDO;

/** Model dasar: menyediakan koneksi PDO dari Database singleton */
class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /** Hitung jumlah baris suatu tabel (untuk dashboard) */
    protected function countTable(string $table): int
    {
        // Nama tabel hanya dari kode kita sendiri, bukan dari input pengguna
        return (int) $this->db->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
    }
}
