<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Repositories\ProdiRepository;
use PDOException;

class ProdiController extends Controller
{
    // Dependency di-inject lewat constructor (dibuat otomatis oleh Container)
    public function __construct(private ProdiRepository $repo)
    {
    }

    public function index(): void
    {
        $prodi = $this->repo->all();

        $this->view('prodi/index', compact('prodi'));
    }

    public function create(): void
    {
        $this->view('prodi/create');
    }

    public function store(): void
    {
        $data = $this->input();

        if ($data['kode'] === '' || $data['nama'] === '') {
            $this->backWithError('/prodi/create', 'Kode dan nama program studi wajib diisi.');
        }

        try {
            $this->repo->create($data);
        } catch (PDOException $e) {
            $this->backWithError('/prodi/create', $this->databaseMessage($e));
        }

        $this->flash('success', 'Program studi berhasil ditambahkan.');
        $this->redirect('/prodi');
    }

    public function edit(int $id): void
    {
        $prodi = $this->findOrFail($id);

        $this->view('prodi/edit', compact('prodi'));
    }

    public function update(int $id): void
    {
        $this->findOrFail($id);
        $data = $this->input();

        if ($data['kode'] === '' || $data['nama'] === '') {
            $this->backWithError("/prodi/{$id}/edit", 'Kode dan nama program studi wajib diisi.');
        }

        try {
            $this->repo->update($id, $data);
        } catch (PDOException $e) {
            $this->backWithError("/prodi/{$id}/edit", $this->databaseMessage($e));
        }

        $this->flash('success', 'Program studi berhasil diperbarui.');
        $this->redirect('/prodi');
    }

    public function destroy(int $id): void
    {
        $this->findOrFail($id);

        try {
            $this->repo->delete($id);
        } catch (PDOException $e) {
            // Foreign key: prodi masih dipakai mahasiswa / mata kuliah
            $this->flash('danger', 'Program studi tidak dapat dihapus karena masih dipakai data mahasiswa atau mata kuliah.');
            $this->redirect('/prodi');
        }

        $this->flash('success', 'Program studi berhasil dihapus.');
        $this->redirect('/prodi');
    }

    private function findOrFail(int $id): object
    {
        $prodi = $this->repo->find($id);

        if (!$prodi) {
            $this->flash('danger', 'Data program studi tidak ditemukan.');
            $this->redirect('/prodi');
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
