<?php

namespace App\Models;

use App\Core\Model;

class MahasiswaModel extends Model
{
    /** Ambil semua mahasiswa beserta nama prodinya */
    public function all(): array
    {
        $sql = 'SELECT mahasiswa.id, mahasiswa.nim, mahasiswa.nama, mahasiswa.email,
                       mahasiswa.angkatan, mahasiswa.status, prodi.nama AS nama_prodi
                FROM mahasiswa
                JOIN prodi ON mahasiswa.prodi_id = prodi.id
                ORDER BY mahasiswa.nim';

        return $this->db->query($sql)->fetchAll();
    }
}
