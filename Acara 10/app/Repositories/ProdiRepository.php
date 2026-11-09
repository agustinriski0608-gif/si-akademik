<?php

namespace App\Repositories;

use App\Core\Model;

/**
 * ProdiRepository: seluruh query SQL ada di sini.
 * Mewarisi Model dasar (extends) untuk mendapatkan koneksi $this->db.
 */
class ProdiRepository extends Model
{
    public function all(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM prodi ORDER BY id ASC');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find(int $id): ?object
    {
        $stmt = $this->db->prepare('SELECT * FROM prodi WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare('INSERT INTO prodi (kode, nama) VALUES (:kode, :nama)');

        return $stmt->execute(['kode' => $data['kode'], 'nama' => $data['nama']]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare('UPDATE prodi SET kode = :kode, nama = :nama WHERE id = :id');

        return $stmt->execute(['kode' => $data['kode'], 'nama' => $data['nama'], 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM prodi WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return $this->countTable('prodi');
    }
}
