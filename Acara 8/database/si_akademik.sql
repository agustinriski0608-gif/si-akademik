-- ============================================================
--  Database SI Akademik (Acara 7 - 10)
--  Cara pakai: phpMyAdmin -> tab Import -> pilih file ini -> Go
--  Aman diimport berulang: tabel/data yang sudah ada tidak ditimpa.
-- ============================================================

CREATE DATABASE IF NOT EXISTS `si_akademik`
  DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `si_akademik`;

-- Tabel prodi
CREATE TABLE IF NOT EXISTS `prodi` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kode` VARCHAR(10) NOT NULL UNIQUE,
  `nama` VARCHAR(100) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel mahasiswa (kolom `status` = tugas mandiri Acara 7)
CREATE TABLE IF NOT EXISTS `mahasiswa` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nim` VARCHAR(20) NOT NULL UNIQUE,
  `nama` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `prodi_id` INT NOT NULL,
  `angkatan` YEAR NOT NULL,
  `status` ENUM('aktif','cuti','lulus') NOT NULL DEFAULT 'aktif',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_mahasiswa_prodi` FOREIGN KEY (`prodi_id`) REFERENCES `prodi`(`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabel matakuliah
CREATE TABLE IF NOT EXISTS `matakuliah` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `kode` VARCHAR(10) NOT NULL UNIQUE,
  `nama` VARCHAR(150) NOT NULL,
  `sks` TINYINT NOT NULL,
  `prodi_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CONSTRAINT `fk_matakuliah_prodi` FOREIGN KEY (`prodi_id`) REFERENCES `prodi`(`id`)
    ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data awal (seeding)
INSERT IGNORE INTO `prodi` (`id`, `kode`, `nama`) VALUES
(1, 'TI', 'Teknik Informatika'),
(2, 'SI', 'Sistem Informasi'),
(3, 'TK', 'Teknik Komputer'),
(4, 'MI', 'Manajemen Informatika');

INSERT IGNORE INTO `mahasiswa` (`id`, `nim`, `nama`, `email`, `prodi_id`, `angkatan`, `status`) VALUES
(1, '23001', 'Mingyu',   'mingyu@email.com',   1, 2023, 'aktif'),
(2, '23002', 'Wonwoo',   'wonwoo@email.com',   4, 2023, 'aktif'),
(3, '23003', 'Seungmin', 'seungmin@email.com', 3, 2023, 'aktif');

INSERT IGNORE INTO `matakuliah` (`id`, `kode`, `nama`, `sks`, `prodi_id`) VALUES
(1, 'TI101', 'Pemrograman Dasar', 3, 1),
(2, 'TI102', 'Basis Data',        3, 1),
(3, 'SI101', 'Pengantar SI',      2, 2);
