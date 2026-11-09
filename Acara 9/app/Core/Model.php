<?php

namespace App\Core;

use PDO;

/** Model dasar: Database disuntikkan lewat constructor */
class Model
{
    protected PDO $db;

    public function __construct(Database $database)
    {
        $this->db = $database->getConnection();
    }

    protected function countTable(string $table): int
    {
        return (int) $this->db->query("SELECT COUNT(*) FROM `{$table}`")->fetchColumn();
    }
}
