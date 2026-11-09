<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\MataKuliahRepository;
use App\Repositories\ProdiRepository;
use PDOException;

class MataKuliahController extends Controller
{
    public function __construct(
        private MataKuliahRepository $repo,
        private ProdiRepository $prodiRepo
    ) {
    }

    public function index(): void
    {
        $matakuliah = $this->repo->all();

        $this->view('matakuliah/index', compact('matakuliah'));
    }

    public function create(): void
    {
        $prodiList = $this->prodiRepo->all();

        $this->view('matakuliah/create', compact('prodiList'));
    }

    public function store(): void
    {
        $data = $this->input();

        if ($error = $this->validate($data)) {
            $this->backWithError('/matakuliah/create', $error);
        }

        try {
            $this->repo->create($data);
        } catch (PDOException $e) {
            $this->backWithError('/matakuliah/create', $this->databaseMessage($e));
        }

        $this->flash('success', 'Mata kuliah berhasil ditambahkan.');
        $this->redirect('/matakuliah');
    }

    public function edit(int $id): void
    {
        $mk = $this->findOrFail($id);
        $prodiList = $this->prodiRepo->all();

        $this->view('matakuliah/edit', compact('mk', 'prodiList'));
    }

    public function update(int $id): void
    {
        $this->findOrFail($id);
        $data = $this->input();

        if ($error = $this->validate($data)) {
            $this->backWithError("/matakuliah/{$id}/edit", $error);
        }

        try {
            $this->repo->update($id, $data);
        } catch (PDOException $e) {
            $this->backWithError("/matakuliah/{$id}/edit", $this->databaseMessage($e));
        }

        $this->flash('success', 'Mata kuliah berhasil diperbarui.');
        $this->redirect('/matakuliah');
    }

    public function destroy(int $id): void
    {
        $this->findOrFail($id);
        $this->repo->delete($id);

        $this->flash('success', 'Mata kuliah berhasil dihapus.');
        $this->redirect('/matakuliah');
    }

    private function findOrFail(int $id): object
    {
        $mk = $this->repo->find($id);

        if (!$mk) {
            $this->flash('danger', 'Data mata kuliah tidak ditemukan.');
            $this->redirect('/matakuliah');
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

        if (!$this->prodiRepo->find($d['prodi_id'])) {
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
