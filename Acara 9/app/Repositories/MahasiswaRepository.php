<?php

namespace App\Repositories;

use App\Core\Database;
use App\Models\Mahasiswa;
use PDO;

/**
 * MahasiswaRepository "memiliki" object Database (Object Composition)
 * yang diterima lewat constructor (Dependency Injection).
 * Seluruh query CRUD mahasiswa ada di sini, bukan di Controller.
 */
class MahasiswaRepository
{
    private PDO $pdo;

    private const SELECT = 'SELECT mahasiswa.id, mahasiswa.nim, mahasiswa.nama, mahasiswa.email,
                                   mahasiswa.prodi_id, mahasiswa.angkatan, mahasiswa.status,
                                   prodi.nama AS nama_prodi
                            FROM mahasiswa
                            JOIN prodi ON mahasiswa.prodi_id = prodi.id';

    public function __construct(private Database $database)
    {
        $this->pdo = $this->database->getConnection();
    }

    public function all(): array
    {
        $stmt = $this->pdo->prepare(self::SELECT . ' ORDER BY mahasiswa.nim ASC');
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function search(string $keyword): array
    {
        $stmt = $this->pdo->prepare(
            self::SELECT . ' WHERE mahasiswa.nama LIKE :nama OR mahasiswa.nim LIKE :nim
                             ORDER BY mahasiswa.nim ASC'
        );

        $like = '%' . $keyword . '%';
        $stmt->execute(['nama' => $like, 'nim' => $like]);

        return $stmt->fetchAll();
    }

    public function find(int $id): ?object
    {
        $stmt = $this->pdo->prepare(self::SELECT . ' WHERE mahasiswa.id = :id');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch() ?: null;
    }

    /** Simpan entity Mahasiswa baru, kembalikan ID barunya */
    public function create(Mahasiswa $mhs): int
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan, status)
             VALUES (:nim, :nama, :email, :prodi_id, :angkatan, :status)'
        );
        $stmt->execute($this->toParams($mhs));

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, Mahasiswa $mhs): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE mahasiswa
             SET nim = :nim, nama = :nama, email = :email,
                 prodi_id = :prodi_id, angkatan = :angkatan, status = :status
             WHERE id = :id'
        );

        return $stmt->execute($this->toParams($mhs) + ['id' => $id]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM mahasiswa WHERE id = :id');

        return $stmt->execute(['id' => $id]);
    }

    public function count(): int
    {
        return (int) $this->pdo->query('SELECT COUNT(*) FROM mahasiswa')->fetchColumn();
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
