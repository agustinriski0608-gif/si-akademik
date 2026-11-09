<?php

namespace App\Repositories;

use App\Core\Model;
use App\Models\Mahasiswa;

/**
 * MahasiswaRepository menangani SELURUH operasi database mahasiswa
 * (tampil, cari, tambah, ubah, hapus). Controller tidak menulis SQL.
 * Class ini mewarisi Model dasar sehingga langsung punya koneksi $this->db.
 */
class MahasiswaRepository extends Model
{
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

    /** Simpan entity Mahasiswa baru, kembalikan ID barunya */
    public function create(Mahasiswa $mhs): int
    {
        $stmt = $this->db->prepare(
            'INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan, status)
             VALUES (:nim, :nama, :email, :prodi_id, :angkatan, :status)'
        );
        $stmt->execute($this->toParams($mhs));

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, Mahasiswa $mhs): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE mahasiswa
             SET nim = :nim, nama = :nama, email = :email,
                 prodi_id = :prodi_id, angkatan = :angkatan, status = :status
             WHERE id = :id'
        );

        return $stmt->execute($this->toParams($mhs) + ['id' => $id]);
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

    /** Ambil nilai dari entity lewat GETTER (atributnya private) */
    private function toParams(Mahasiswa $mhs): array
    {
        return [
            'nim' => $mhs->getNim(),
            'nama' => $mhs->getNama(),
            'email' => $mhs->getEmail(),
            'prodi_id' => $mhs->getProdiId(),
            'angkatan' => $mhs->getAngkatan(),
            'status' => $mhs->getStatus(),
        ];
    }
}
