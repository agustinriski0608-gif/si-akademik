<?php

namespace App\Controllers;

use App\Models\MahasiswaModel;
use App\Models\ProdiModel;
use PDOException;

class MahasiswaController
{
    private MahasiswaModel $model;
    private ProdiModel $prodiModel;

    public function __construct()
    {
        $this->model = new MahasiswaModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index(): void
    {
        $keyword = trim($_GET['keyword'] ?? '');

        $mahasiswa = $keyword !== ''
            ? $this->model->search($keyword)
            : $this->model->all();

        view('mahasiswa/index', compact('mahasiswa', 'keyword'));
    }

    public function create(): void
    {
        $prodiList = $this->prodiModel->all();

        view('mahasiswa/create', compact('prodiList'));
    }

    public function store(): void
    {
        $data = $this->input();

        if ($error = $this->validate($data)) {
            back_with_error('/mahasiswa/create', $error);
        }

        try {
            $this->model->create($data);
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
        $data = $this->input();

        if ($error = $this->validate($data)) {
            back_with_error("/mahasiswa/{$id}/edit", $error);
        }

        try {
            $this->model->update($id, $data);
        } catch (PDOException $e) {
            back_with_error("/mahasiswa/{$id}/edit", $this->databaseMessage($e));
        }

        flash('success', 'Data mahasiswa berhasil diperbarui.');
        redirect('/mahasiswa');
    }

    public function destroy(int $id): void
    {
        $this->findOrFail($id);
        $this->model->delete($id);

        flash('success', 'Data mahasiswa berhasil dihapus.');
        redirect('/mahasiswa');
    }

    private function findOrFail(int $id): object
    {
        $mhs = $this->model->find($id);

        if (!$mhs) {
            flash('danger', 'Data mahasiswa tidak ditemukan.');
            redirect('/mahasiswa');
        }

        return $mhs;
    }

    private function input(): array
    {
        return [
            'nim' => trim($_POST['nim'] ?? ''),
            'nama' => trim($_POST['nama'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'prodi_id' => (int) ($_POST['prodi_id'] ?? 0),
            'angkatan' => (int) ($_POST['angkatan'] ?? 0),
            'status' => $_POST['status'] ?? 'aktif',
        ];
    }

    /** Kembalikan pesan error, atau null jika data valid */
    private function validate(array $d): ?string
    {
        if ($d['nim'] === '' || $d['nama'] === '') {
            return 'NIM dan nama wajib diisi.';
        }

        if (!filter_var($d['email'], FILTER_VALIDATE_EMAIL)) {
            return 'Format email tidak valid.';
        }

        if (!$this->prodiModel->find($d['prodi_id'])) {
            return 'Program studi tidak valid.';
        }

        if ($d['angkatan'] < 2000 || $d['angkatan'] > 2100) {
            return 'Angkatan harus antara 2000 dan 2100.';
        }

        if (!in_array($d['status'], ['aktif', 'cuti', 'lulus'], true)) {
            return 'Status tidak valid.';
        }

        return null;
    }

    private function databaseMessage(PDOException $e): string
    {
        // 1062 = duplicate entry (NIM sudah dipakai)
        if (($e->errorInfo[1] ?? 0) === 1062) {
            return 'NIM sudah terdaftar, gunakan NIM lain.';
        }

        throw $e;
    }
}
