<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Mahasiswa;
use App\Repositories\ProdiRepository;
use App\Repositories\MahasiswaRepository;
use InvalidArgumentException;
use PDOException;

/**
 * Controller TIDAK lagi membuat koneksi database sendiri.
 * MahasiswaRepository diterima lewat constructor (Dependency Injection).
 */
class MahasiswaController extends Controller
{
    public function __construct(
        private MahasiswaRepository $repo,
        private ProdiRepository $prodiRepo
    ) {
    }

    public function index(): void
    {
        $keyword = trim($_GET['keyword'] ?? '');

        $mahasiswa = $keyword !== ''
            ? $this->repo->search($keyword)
            : $this->repo->all();

        $this->view('mahasiswa/index', compact('mahasiswa', 'keyword'));
    }

    public function create(): void
    {
        $prodiList = $this->prodiRepo->all();

        $this->view('mahasiswa/create', compact('prodiList'));
    }

    public function store(): void
    {
        $mhs = $this->buildEntity('/mahasiswa/create');

        try {
            $this->repo->create($mhs);
        } catch (PDOException $e) {
            $this->backWithError('/mahasiswa/create', $this->databaseMessage($e));
        }

        $this->flash('success', 'Data mahasiswa berhasil ditambahkan.');
        $this->redirect('/mahasiswa');
    }

    public function edit(int $id): void
    {
        $mhs = $this->findOrFail($id);
        $prodiList = $this->prodiRepo->all();

        $this->view('mahasiswa/edit', compact('mhs', 'prodiList'));
    }

    public function update(int $id): void
    {
        $this->findOrFail($id);
        $mhs = $this->buildEntity("/mahasiswa/{$id}/edit");

        try {
            $this->repo->update($id, $mhs);
        } catch (PDOException $e) {
            $this->backWithError("/mahasiswa/{$id}/edit", $this->databaseMessage($e));
        }

        $this->flash('success', 'Data mahasiswa berhasil diperbarui.');
        $this->redirect('/mahasiswa');
    }

    public function destroy(int $id): void
    {
        $this->findOrFail($id);
        $this->repo->delete($id);

        $this->flash('success', 'Data mahasiswa berhasil dihapus.');
        $this->redirect('/mahasiswa');
    }

    private function findOrFail(int $id): object
    {
        $mhs = $this->repo->find($id);

        if (!$mhs) {
            $this->flash('danger', 'Data mahasiswa tidak ditemukan.');
            $this->redirect('/mahasiswa');
        }

        return $mhs;
    }

    /**
     * Bentuk entity dari input form. Validasi dilakukan oleh SETTER di
     * class Mahasiswa; jika gagal, kembali ke form dengan pesan errornya.
     */
    private function buildEntity(string $backTo): Mahasiswa
    {
        try {
            $mhs = Mahasiswa::fromArray($_POST);
        } catch (InvalidArgumentException $e) {
            $this->backWithError($backTo, $e->getMessage());
        }

        if (!$this->prodiRepo->find($mhs->getProdiId())) {
            $this->backWithError($backTo, 'Program studi tidak valid.');
        }

        return $mhs;
    }

    private function databaseMessage(PDOException $e): string
    {
        if (($e->errorInfo[1] ?? 0) === 1062) {
            return 'NIM sudah terdaftar, gunakan NIM lain.';
        }

        throw $e;
    }
}
