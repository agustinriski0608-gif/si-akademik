<?php

namespace App\Controllers;

use App\Models\ProdiModel;
use PDOException;

class ProdiController
{
    private ProdiModel $model;

    public function __construct()
    {
        $this->model = new ProdiModel();
    }

    public function index(): void
    {
        $prodi = $this->model->all();

        view('prodi/index', compact('prodi'));
    }

    public function create(): void
    {
        view('prodi/create');
    }

    public function store(): void
    {
        $data = $this->input();

        if ($data['kode'] === '' || $data['nama'] === '') {
            back_with_error('/prodi/create', 'Kode dan nama program studi wajib diisi.');
        }

        try {
            $this->model->create($data);
        } catch (PDOException $e) {
            back_with_error('/prodi/create', $this->databaseMessage($e));
        }

        flash('success', 'Program studi berhasil ditambahkan.');
        redirect('/prodi');
    }

    public function edit(int $id): void
    {
        $prodi = $this->findOrFail($id);

        view('prodi/edit', compact('prodi'));
    }

    public function update(int $id): void
    {
        $this->findOrFail($id);
        $data = $this->input();

        if ($data['kode'] === '' || $data['nama'] === '') {
            back_with_error("/prodi/{$id}/edit", 'Kode dan nama program studi wajib diisi.');
        }

        try {
            $this->model->update($id, $data);
        } catch (PDOException $e) {
            back_with_error("/prodi/{$id}/edit", $this->databaseMessage($e));
        }

        flash('success', 'Program studi berhasil diperbarui.');
        redirect('/prodi');
    }

    public function destroy(int $id): void
    {
        $this->findOrFail($id);

        try {
            $this->model->delete($id);
        } catch (PDOException $e) {
            // Foreign key: prodi masih dipakai mahasiswa / mata kuliah
            flash('danger', 'Program studi tidak dapat dihapus karena masih dipakai data mahasiswa atau mata kuliah.');
            redirect('/prodi');
        }

        flash('success', 'Program studi berhasil dihapus.');
        redirect('/prodi');
    }

    private function findOrFail(int $id): object
    {
        $prodi = $this->model->find($id);

        if (!$prodi) {
            flash('danger', 'Data program studi tidak ditemukan.');
            redirect('/prodi');
        }

        return $prodi;
    }

    private function input(): array
    {
        return [
            'kode' => strtoupper(trim($_POST['kode'] ?? '')),
            'nama' => trim($_POST['nama'] ?? ''),
        ];
    }

    private function databaseMessage(PDOException $e): string
    {
        if (($e->errorInfo[1] ?? 0) === 1062) {
            return 'Kode program studi sudah dipakai.';
        }

        throw $e;
    }
}
