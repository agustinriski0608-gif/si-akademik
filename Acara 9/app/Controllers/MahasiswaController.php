<?php

namespace App\Controllers;

use App\Models\Mahasiswa;
use App\Models\ProdiModel;
use App\Repositories\MahasiswaRepository;
use InvalidArgumentException;
use PDOException;

/**
 * Controller TIDAK lagi membuat koneksi database sendiri.
 * MahasiswaRepository diterima lewat constructor (Dependency Injection).
 */
class MahasiswaController
{
    public function __construct(
        private MahasiswaRepository $repo,
        private ProdiModel $prodiModel
    ) {
    }

    public function index(): void
    {
        $keyword = trim($_GET['keyword'] ?? '');

        $mahasiswa = $keyword !== ''
            ? $this->repo->search($keyword)
            : $this->repo->all();

        view('mahasiswa/index', compact('mahasiswa', 'keyword'));
    }

    public function create(): void
    {
        $prodiList = $this->prodiModel->all();

        view('mahasiswa/create', compact('prodiList'));
    }

    public function store(): void
    {
        $mhs = $this->buildEntity('/mahasiswa/create');

        try {
            $this->repo->create($mhs);
        } catch (PDOException $e) {
            back_with_error('/mahasiswa/create', $this->databaseMessage($e));
        }

        flash('success', 'Data mahasiswa berhasil ditambahkan.');
        redirect('/mahasiswa');
    }

    public function edit(int $id): void
    {
        $mhs = $this->findOrFail($id);
        $prodiList = $this->prodiModel->all();

        view('mahasiswa/edit', compact('mhs', 'prodiList'));
    }

    public function update(int $id): void
    {
        $this->findOrFail($id);
        $mhs = $this->buildEntity("/mahasiswa/{$id}/edit");

        try {
            $this->repo->update($id, $mhs);
        } catch (PDOException $e) {
            back_with_error("/mahasiswa/{$id}/edit", $this->databaseMessage($e));
        }

        flash('success', 'Data mahasiswa berhasil diperbarui.');
        redirect('/mahasiswa');
    }

    public function destroy(int $id): void
    {
        $this->findOrFail($id);
        $this->repo->delete($id);

        flash('success', 'Data mahasiswa berhasil dihapus.');
        redirect('/mahasiswa');
    }

    private function findOrFail(int $id): object
    {
        $mhs = $this->repo->find($id);

        if (!$mhs) {
            flash('danger', 'Data mahasiswa tidak ditemukan.');
            redirect('/mahasiswa');
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
            back_with_error($backTo, $e->getMessage());
        }

        if (!$this->prodiModel->find($mhs->getProdiId())) {
            back_with_error($backTo, 'Program studi tidak valid.');
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
