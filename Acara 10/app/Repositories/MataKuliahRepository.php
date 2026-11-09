<?php

namespace App\Repositories;

use App\Core\Model;

/**
 * MataKuliahRepository: seluruh query SQL ada di sini.
 * Mewarisi Model dasar (extends) untuk mendapatkan koneksi $this->db.
 */
class MataKuliahRepository extends Model
{
    public function all(): array
    {
        $stmt = $this->db->prepare(
            'SELECT matakuliah.id, matakuliah.kode, matakuliah.nama, matakuliah.sks,
                    matakuliah.prodi_id, prodi.nama AS nama_prodi
             FROM matakuliah
             JOIN prodi ON matakuliah.prodi_id = prodi.id
             ORDER BY matakuliah.kode ASC'
        );
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find(int $id): ?object
    {
        $stmt = $this->db->prepare('SELECT * FROM matakuliah WHERE id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO matakuliah (kode, nama, sks, prodi_id) VALUES (:kode, :nama, :sks, :prodi_id)'
        );

        return $stmt->execute($this->fields($data));
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE matakuliah SET kode = :kode, nama = :nama, sks = :sks, prodi_id = :prodi_id WHERE id = :id'
        );

        return $stmt->execute($this->fields($data) + ['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM matakuliah WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return $this->countTable('matakuliah');
    }

    private function fields(array $data): array
    {
        return [
            'kode' => $data['kode'],
            'nama' => $data['nama'],
            'sks' => $data['sks'],
            'prodi_id' => $data['prodi_id'],
        ];
    }
}
