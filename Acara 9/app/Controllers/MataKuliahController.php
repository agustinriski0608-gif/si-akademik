<?php

namespace App\Controllers;

use App\Models\MataKuliahModel;
use App\Models\ProdiModel;
use PDOException;

class MataKuliahController
{
    public function __construct(
        private MataKuliahModel $model,
        private ProdiModel $prodiModel
    ) {
    }

    public function index(): void
    {
        $matakuliah = $this->model->all();

        view('matakuliah/index', compact('matakuliah'));
    }

    public function create(): void
    {
        $prodiList = $this->prodiModel->all();

        view('matakuliah/create', compact('prodiList'));
    }

    public function store(): void
    {
        $data = $this->input();

        if ($error = $this->validate($data)) {
            back_with_error('/matakuliah/create', $error);
        }

        try {
            $this->model->create($data);
        } catch (PDOException $e) {
            back_with_error('/matakuliah/create', $this->databaseMessage($e));
        }

        flash('success', 'Mata kuliah berhasil ditambahkan.');
        redirect('/matakuliah');
    }

    public function edit(int $id): void
    {
        $mk = $this->findOrFail($id);
        $prodiList = $this->prodiModel->all();

        view('matakuliah/edit', compact('mk', 'prodiList'));
    }

    public function update(int $id): void
    {
        $this->findOrFail($id);
        $data = $this->input();

        if ($error = $this->validate($data)) {
            back_with_error("/matakuliah/{$id}/edit", $error);
        }

        try {
            $this->model->update($id, $data);
        } catch (PDOException $e) {
            back_with_error("/matakuliah/{$id}/edit", $this->databaseMessage($e));
        }

        flash('success', 'Mata kuliah berhasil diperbarui.');
        redirect('/matakuliah');
    }

    public function destroy(int $id): void
    {
        $this->findOrFail($id);
        $this->model->delete($id);

        flash('success', 'Mata kuliah berhasil dihapus.');
        redirect('/matakuliah');
    }

    private function findOrFail(int $id): object
    {
        $mk = $this->model->find($id);

        if (!$mk) {
            flash('danger', 'Data mata kuliah tidak ditemukan.');
            redirect('/matakuliah');
        }

        return $mk;
    }

    private function input(): array
    {
        return [
            'kode' => strtoupper(trim($_POST['kode'] ?? '')),
            'nama' => trim($_POST['nama'] ?? ''),
            'sks' => (int) ($_POST['sks'] ?? 0),
            'prodi_id' => (int) ($_POST['prodi_id'] ?? 0),
        ];
    }

    private function validate(array $d): ?string
    {
        if ($d['kode'] === '' || $d['nama'] === '') {
            return 'Kode dan nama mata kuliah wajib diisi.';
        }

        if ($d['sks'] < 1 || $d['sks'] > 6) {
            return 'SKS harus antara 1 dan 6.';
        }

        if (!$this->prodiModel->find($d['prodi_id'])) {
            return 'Program studi tidak valid.';
        }

        return null;
    }

    private function databaseMessage(PDOException $e): string
    {
        if (($e->errorInfo[1] ?? 0) === 1062) {
            return 'Kode mata kuliah sudah dipakai.';
        }

        throw $e;
    }
}
