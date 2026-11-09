<?php

namespace App\Models;

class Mahasiswa
{
    private string $nim;
    private string $nama;
    private string $prodi;

    public function __construct(string $nim, string $nama, string $prodi)
    {
        $this->nim = $nim;
        $this->nama = $nama;
        $this->prodi = $prodi;
    }

    public function getNim(): string
    {
        return $this->nim;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getProdi(): string
    {
        return $this->prodi;
    }

    /** Angkatan diambil dari 2 digit awal NIM (tugas mandiri Acara 4) */
    public function getAngkatan(): string
    {
        return (string) (2000 + (int) substr($this->nim, 0, 2));
    }
}
