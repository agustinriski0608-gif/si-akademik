<?php

namespace App\Models;

use InvalidArgumentException;

/**
 * Entity Mahasiswa.
 * Semua atribut PRIVATE; akses hanya lewat getter/setter.
 * Setter memvalidasi data (nama tidak boleh kosong, NIM harus angka, dst.).
 */
class Mahasiswa
{
    private ?int $id = null;
    private string $nim = '';
    private string $nama = '';
    private string $email = '';
    private int $prodiId = 0;
    private int $angkatan = 0;
    private string $status = 'aktif';

    public const STATUS = ['aktif', 'cuti', 'lulus'];

    /** Membuat object dari array (mis. dari $_POST) lewat setter, jadi otomatis tervalidasi */
    public static function fromArray(array $data): self
    {
        $mhs = new self();
        $mhs->setNim($data['nim'] ?? '');
        $mhs->setNama($data['nama'] ?? '');
        $mhs->setEmail($data['email'] ?? '');
        $mhs->setProdiId((int) ($data['prodi_id'] ?? 0));
        $mhs->setAngkatan((int) ($data['angkatan'] ?? 0));
        $mhs->setStatus($data['status'] ?? 'aktif');

        return $mhs;
    }

    // ---------------- Getter ----------------

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNim(): string
    {
        return $this->nim;
    }

    public function getNama(): string
    {
        return $this->nama;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getProdiId(): int
    {
        return $this->prodiId;
    }

    public function getAngkatan(): int
    {
        return $this->angkatan;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    // ---------------- Setter + validasi ----------------

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setNim(string $nim): self
    {
        $nim = trim($nim);

        if ($nim === '') {
            throw new InvalidArgumentException('NIM tidak boleh kosong.');
        }

        if (!ctype_digit($nim)) {
            throw new InvalidArgumentException('NIM harus berupa angka.');
        }

        if (strlen($nim) > 20) {
            throw new InvalidArgumentException('NIM maksimal 20 digit.');
        }

        $this->nim = $nim;

        return $this;
    }

    public function setNama(string $nama): self
    {
        $nama = trim($nama);

        if ($nama === '') {
            throw new InvalidArgumentException('Nama mahasiswa tidak boleh kosong.');
        }

        if (mb_strlen($nama) > 100) {
            throw new InvalidArgumentException('Nama maksimal 100 karakter.');
        }

        $this->nama = $nama;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $email = trim($email);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Format email tidak valid.');
        }

        $this->email = $email;

        return $this;
    }

    public function setProdiId(int $prodiId): self
    {
        if ($prodiId <= 0) {
            throw new InvalidArgumentException('Program studi wajib dipilih.');
        }

        $this->prodiId = $prodiId;

        return $this;
    }

    public function setAngkatan(int $angkatan): self
    {
        if ($angkatan < 2000 || $angkatan > 2100) {
            throw new InvalidArgumentException('Angkatan harus antara 2000 dan 2100.');
        }

        $this->angkatan = $angkatan;

        return $this;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, self::STATUS, true)) {
            throw new InvalidArgumentException('Status tidak valid.');
        }

        $this->status = $status;

        return $this;
    }
}
