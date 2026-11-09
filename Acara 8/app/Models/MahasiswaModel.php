<?php

namespace App\Models;

use App\Core\Model;

class MahasiswaModel extends Model
{
    /** Kolom SELECT yang dipakai bersama (JOIN ke prodi untuk nama prodi) */
    private const SELECT = 'SELECT mahasiswa.id, mahasiswa.nim, mahasiswa.nama, mahasiswa.email,
                                   mahasiswa.prodi_id, mahasiswa.angkatan, mahasiswa.status,
                                   prodi.nama AS nama_prodi
                            FROM mahasiswa
                            JOIN prodi ON mahasiswa.prodi_id = prodi.id';

    public function all(): array
    {
        $stmt = $this->db->prepare(self::SELECT . ' ORDER BY mahasiswa.nim ASC');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /** Pencarian berdasarkan nama atau NIM (tugas mandiri Acara 8) */
    public function search(string $keyword): array
    {
        $stmt = $this->db->prepare(
            self::SELECT . ' WHERE mahasiswa.nama LIKE :nama OR mahasiswa.nim LIKE :nim
                             ORDER BY mahasiswa.nim ASC'
        );

        $like = '%' . $keyword . '%';
        $stmt->execute(['nama' => $like, 'nim' => $like]);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?object
    {
        $stmt = $this->db->prepare(self::SELECT . ' WHERE mahasiswa.id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan, status)
             VALUES (:nim, :nama, :email, :prodi_id, :angkatan, :status)'
        );

        return $stmt->execute($this->fields($data));
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE mahasiswa
             SET nim = :nim, nama = :nama, email = :email,
                 prodi_id = :prodi_id, angkatan = :angkatan, status = :status
             WHERE id = :id'
        );

        return $stmt->execute($this->fields($data) + ['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM mahasiswa WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return $this->countTable('mahasiswa');
    }

    private function fields(array $data): array
    {
        return [
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'email' => $data['email'],
            'prodi_id' => $data['prodi_id'],
            'angkatan' => $data['angkatan'],
            'status' => $data['status'],
        ];
    }
}
