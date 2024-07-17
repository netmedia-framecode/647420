-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Jul 2024 pada 11.48
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penggajian_pegawai`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi`
--

CREATE TABLE `absensi` (
  `id_absensi` int(11) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `waktu_masuk` time DEFAULT NULL,
  `waktu_pulang` time DEFAULT NULL,
  `status_absensi` varchar(35) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `absensi`
--

INSERT INTO `absensi` (`id_absensi`, `id_pegawai`, `waktu_masuk`, `waktu_pulang`, `status_absensi`, `created_at`, `updated_at`) VALUES
(4, 7, '17:41:08', '17:41:08', 'Pulang terlambat', '2024-07-17 17:41:12', '2024-07-17 17:41:12'),
(5, 7, '17:42:12', '17:42:12', 'Pulang terlambat', '2024-07-17 17:42:15', '2024-07-17 17:42:15'),
(6, 7, '17:42:35', '17:42:35', 'Hadir', '2024-07-17 17:42:36', '2024-07-17 17:42:36');

-- --------------------------------------------------------

--
-- Struktur dari tabel `auth`
--

CREATE TABLE `auth` (
  `id` int(11) NOT NULL,
  `image` varchar(50) DEFAULT NULL,
  `bg` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `auth`
--

INSERT INTO `auth` (`id`, `image`, `bg`) VALUES
(1, '2915011424.png', '#071e64');

-- --------------------------------------------------------

--
-- Struktur dari tabel `golongan_pegawai`
--

CREATE TABLE `golongan_pegawai` (
  `id_golongan` int(11) NOT NULL,
  `nama_golongan` varchar(35) DEFAULT NULL,
  `upah_golongan` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `golongan_pegawai`
--

INSERT INTO `golongan_pegawai` (`id_golongan`, `nama_golongan`, `upah_golongan`) VALUES
(1, 'Pembina', '2560000'),
(2, 'Penata', '2400000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jabatan_pegawai`
--

CREATE TABLE `jabatan_pegawai` (
  `id_jabatan` int(11) NOT NULL,
  `nama_jabatan` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jabatan_pegawai`
--

INSERT INTO `jabatan_pegawai` (`id_jabatan`, `nama_jabatan`) VALUES
(2, 'Camat'),
(3, 'Sekcam');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pangkat_pegawai`
--

CREATE TABLE `pangkat_pegawai` (
  `id_pangkat` int(11) NOT NULL,
  `nama_pangkat` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pangkat_pegawai`
--

INSERT INTO `pangkat_pegawai` (`id_pangkat`, `nama_pangkat`) VALUES
(1, 'Pembina'),
(2, 'Penata');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pegawai`
--

CREATE TABLE `pegawai` (
  `id_pegawai` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `id_pangkat` int(11) DEFAULT NULL,
  `id_jabatan` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pegawai`
--

INSERT INTO `pegawai` (`id_pegawai`, `nama`, `nip`, `id_pangkat`, `id_jabatan`, `created_at`, `updated_at`) VALUES
(6, 'Putri', '0871319313134', 1, 3, '2024-06-24 04:09:26', '2024-06-24 04:09:26'),
(7, 'Arlan', '23118036', 2, 2, '2024-06-24 04:09:55', '2024-06-24 04:09:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekap_gaji`
--

CREATE TABLE `rekap_gaji` (
  `id_rekap_gaji` int(11) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `gaji` char(40) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekap_gaji`
--

INSERT INTO `rekap_gaji` (`id_rekap_gaji`, `id_pegawai`, `gaji`, `created_at`, `updated_at`) VALUES
(1, 6, '2560000', '2024-06-24 04:40:47', '2024-06-24 04:40:47'),
(2, 7, '2400000', '2024-06-24 04:44:33', '2024-06-24 04:44:33');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekap_gaji_tunj`
--

CREATE TABLE `rekap_gaji_tunj` (
  `id_rekap_gaji_tunj` int(11) NOT NULL,
  `id_rekap_gaji` int(11) DEFAULT NULL,
  `id_tunjangan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekap_gaji_tunj`
--

INSERT INTO `rekap_gaji_tunj` (`id_rekap_gaji_tunj`, `id_rekap_gaji`, `id_tunjangan`) VALUES
(4, 1, 1),
(5, 1, 2),
(6, 1, 3),
(10, 2, 1),
(11, 2, 2),
(12, 2, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tpp`
--

CREATE TABLE `tpp` (
  `id_tpp` int(11) NOT NULL,
  `id_pegawai` int(11) DEFAULT NULL,
  `kelas_jabatan` int(11) DEFAULT NULL,
  `besaran_tpp_kpk` char(40) DEFAULT NULL,
  `besaran_kpk` char(40) DEFAULT NULL,
  `persen_kpk` int(11) DEFAULT NULL,
  `nilai_kpk` float DEFAULT NULL,
  `jumlah_kpk` char(40) DEFAULT NULL,
  `besaran_kdk` char(40) DEFAULT NULL,
  `persen_kdk` int(11) DEFAULT NULL,
  `nilai_kdk` float DEFAULT NULL,
  `jumlah_kdk` char(40) DEFAULT NULL,
  `jumlah_tpp_sblm_kpal` char(40) DEFAULT NULL,
  `persen_lap_gratifikasi` int(11) DEFAULT NULL,
  `nilai_lap_gratifikasi` int(11) DEFAULT NULL,
  `persen_pengembalian_bmd` int(11) DEFAULT NULL,
  `nilai_pengembalian_bmd` int(11) DEFAULT NULL,
  `persen_tptgr` int(11) DEFAULT NULL,
  `nilai_tptgr` int(11) DEFAULT NULL,
  `persen_jhkpn` int(11) DEFAULT NULL,
  `nilai_jhkpn` int(11) DEFAULT NULL,
  `jumlah_tpp_sblm_pajak` char(40) DEFAULT NULL,
  `pasal_21` char(40) NOT NULL,
  `jumlah_tpp_setelah_pajak` char(40) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tunjangan_pegawai`
--

CREATE TABLE `tunjangan_pegawai` (
  `id_tunjangan` int(11) NOT NULL,
  `nama_tunjangan` char(40) DEFAULT NULL,
  `upah_tunjangan` char(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tunjangan_pegawai`
--

INSERT INTO `tunjangan_pegawai` (`id_tunjangan`, `nama_tunjangan`, `upah_tunjangan`) VALUES
(1, 'Tunjangan Istri/Suami, Anak', '3500000'),
(2, 'Tunjangan Jabatan Umum', '4760000'),
(3, 'Tunjangan Profesi', '7000000');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_active` int(11) DEFAULT 2,
  `en_user` varchar(75) DEFAULT NULL,
  `token` char(6) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT 'default.svg',
  `email` varchar(75) DEFAULT NULL,
  `password` varchar(75) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `id_role`, `id_active`, `en_user`, `token`, `name`, `image`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, 'developer', 'default.svg', 'developer@gmail.com', '$2y$10$//KMATh3ibPoI3nHFp7x/u7vnAbo2WyUgmI4x0CVVrH8ajFhMvbjG', '2024-06-19 12:41:33', '2024-06-19 12:41:33'),
(2, 2, 1, NULL, NULL, 'admin', 'default.svg', 'admin@gmail.com', '$2y$10$//KMATh3ibPoI3nHFp7x/u7vnAbo2WyUgmI4x0CVVrH8ajFhMvbjG', '2024-06-19 12:41:33', '2024-06-19 12:41:33'),
(8, 3, 1, '2y10YnnJEyfPHbLdhuvsLd0L5OORp9saMgAde85nF0qhqThwB818EGy', '814492', 'Putri', 'default.svg', 'putriraki240800@gmail.com', '$2y$10$J73777FuxofDPW2dDAyoxe1ChpcF84FLXs4JLDgh6GVq9NJAK/eB2', '2024-06-24 04:09:26', '2024-06-24 04:09:26'),
(9, 3, 1, '2y10Z3wXglqppcsET7cRGToXhOGJKdIkDsuzUr1eAlXb22Se6wZoojy', '734143', 'Arlan', 'default.svg', 'arlan270899@gmail.com', '$2y$10$//KMATh3ibPoI3nHFp7x/u7vnAbo2WyUgmI4x0CVVrH8ajFhMvbjG', '2024-06-24 04:09:54', '2024-06-24 04:09:54');

--
-- Trigger `users`
--
DELIMITER $$
CREATE TRIGGER `insert_users` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    SET NEW.id_role = (
        SELECT id_role
        FROM `user_role`
        ORDER BY id_role DESC
        LIMIT 1
    );
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_menu`
--

CREATE TABLE `user_access_menu` (
  `id_access_menu` int(11) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_access_menu`
--

INSERT INTO `user_access_menu` (`id_access_menu`, `id_role`, `id_menu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 2, 3),
(6, 1, 4),
(7, 1, 5),
(8, 2, 4),
(9, 2, 5),
(10, 3, 4),
(11, 3, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_access_sub_menu`
--

CREATE TABLE `user_access_sub_menu` (
  `id_access_sub_menu` int(11) NOT NULL,
  `id_role` int(11) DEFAULT NULL,
  `id_sub_menu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_access_sub_menu`
--

INSERT INTO `user_access_sub_menu` (`id_access_sub_menu`, `id_role`, `id_sub_menu`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(11, 1, 10),
(12, 1, 11),
(13, 1, 12),
(14, 2, 7),
(15, 2, 8),
(16, 2, 9),
(17, 2, 10),
(18, 2, 11),
(19, 2, 12),
(22, 3, 11),
(23, 3, 12),
(24, 1, 16),
(25, 1, 17),
(26, 2, 16),
(27, 2, 17),
(28, 3, 16),
(29, 3, 17),
(30, 1, 15),
(31, 2, 15),
(32, 1, 14),
(33, 2, 14);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_menu`
--

CREATE TABLE `user_menu` (
  `id_menu` int(11) NOT NULL,
  `menu` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_menu`
--

INSERT INTO `user_menu` (`id_menu`, `menu`) VALUES
(1, 'User Management'),
(2, 'Menu Management'),
(3, 'Data Pegawai'),
(4, 'Data Absensi'),
(5, 'Data Penggajian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_role`
--

CREATE TABLE `user_role` (
  `id_role` int(11) NOT NULL,
  `role` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_role`
--

INSERT INTO `user_role` (`id_role`, `role`) VALUES
(1, 'Developer'),
(2, 'Administrator'),
(3, 'Pegawai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_status`
--

CREATE TABLE `user_status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(35) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_status`
--

INSERT INTO `user_status` (`id_status`, `status`) VALUES
(1, 'Active'),
(2, 'No Active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user_sub_menu`
--

CREATE TABLE `user_sub_menu` (
  `id_sub_menu` int(11) NOT NULL,
  `id_menu` int(11) DEFAULT NULL,
  `id_active` int(11) DEFAULT 2,
  `title` varchar(50) DEFAULT NULL,
  `url` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `user_sub_menu`
--

INSERT INTO `user_sub_menu` (`id_sub_menu`, `id_menu`, `id_active`, `title`, `url`, `icon`) VALUES
(1, 1, 1, 'Users', 'users', 'fas fa-users'),
(2, 1, 1, 'Role', 'role', 'fas fa-user-cog'),
(3, 2, 1, 'Menu', 'menu', 'fas fa-fw fa-folder'),
(4, 2, 1, 'Sub Menu', 'sub-menu', 'fas fa-fw fa-folder-open'),
(5, 2, 1, 'Menu Access', 'menu-access', 'fas fa-user-lock'),
(6, 2, 1, 'Sub Menu Access', 'sub-menu-access', 'fas fa-user-lock'),
(7, 3, 1, 'Pangkat Pegawai', 'pangkat-pegawai', 'fas fa-list'),
(8, 3, 1, 'Jabatan Pegawai', 'jabatan-pegawai', 'fas fa-list'),
(9, 3, 1, 'Pegawai', 'pegawai', 'fas fa-users'),
(10, 4, 1, 'Waktu Absensi', 'waktu-absensi', 'fas fa-clock'),
(11, 4, 1, 'Absensi', 'absensi', 'fas fa-user-check'),
(12, 5, 1, 'Daftar TPP', 'daftar-tpp', 'fas fa-list'),
(13, 4, 1, 'Radius Absen', 'radius-absen', 'fas fa-broadcast-tower'),
(14, 5, 1, 'Golongan Pegawai', 'golongan-pegawai', 'fas fa-user-cog'),
(15, 5, 1, 'Tunjangan Pegawai', 'tunjangan-pegawai', 'fas fa-hand-holding-usd'),
(16, 5, 1, 'Rekap Gaji', 'rekap-gaji', 'fas fa-coins'),
(17, 5, 1, 'Cetak Gaji', 'cetak-gaji', 'fas fa-receipt');

-- --------------------------------------------------------

--
-- Struktur dari tabel `waktu_absensi`
--

CREATE TABLE `waktu_absensi` (
  `id_waktu_absensi` int(11) NOT NULL,
  `waktu_masuk` time DEFAULT NULL,
  `waktu_pulang` time DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `waktu_absensi`
--

INSERT INTO `waktu_absensi` (`id_waktu_absensi`, `waktu_masuk`, `waktu_pulang`, `created_at`, `updated_at`) VALUES
(1, '07:30:00', '17:00:00', '2024-06-21 10:11:22', '2024-07-17 17:42:55');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id_absensi`),
  ADD KEY `absensi_ibfk_1` (`id_pegawai`);

--
-- Indeks untuk tabel `auth`
--
ALTER TABLE `auth`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `golongan_pegawai`
--
ALTER TABLE `golongan_pegawai`
  ADD PRIMARY KEY (`id_golongan`);

--
-- Indeks untuk tabel `jabatan_pegawai`
--
ALTER TABLE `jabatan_pegawai`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indeks untuk tabel `pangkat_pegawai`
--
ALTER TABLE `pangkat_pegawai`
  ADD PRIMARY KEY (`id_pangkat`);

--
-- Indeks untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD PRIMARY KEY (`id_pegawai`),
  ADD KEY `id_pangkat` (`id_pangkat`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indeks untuk tabel `rekap_gaji`
--
ALTER TABLE `rekap_gaji`
  ADD PRIMARY KEY (`id_rekap_gaji`),
  ADD KEY `id_pegawai` (`id_pegawai`);

--
-- Indeks untuk tabel `rekap_gaji_tunj`
--
ALTER TABLE `rekap_gaji_tunj`
  ADD PRIMARY KEY (`id_rekap_gaji_tunj`),
  ADD KEY `id_rekap_gaji` (`id_rekap_gaji`),
  ADD KEY `id_tunjangan` (`id_tunjangan`);

--
-- Indeks untuk tabel `tpp`
--
ALTER TABLE `tpp`
  ADD PRIMARY KEY (`id_tpp`),
  ADD KEY `tpp_ibfk_1` (`id_pegawai`);

--
-- Indeks untuk tabel `tunjangan_pegawai`
--
ALTER TABLE `tunjangan_pegawai`
  ADD PRIMARY KEY (`id_tunjangan`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_active` (`id_active`);

--
-- Indeks untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD PRIMARY KEY (`id_access_menu`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `user_access_sub_menu`
--
ALTER TABLE `user_access_sub_menu`
  ADD PRIMARY KEY (`id_access_sub_menu`),
  ADD KEY `id_role` (`id_role`),
  ADD KEY `id_sub_menu` (`id_sub_menu`);

--
-- Indeks untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `user_role`
--
ALTER TABLE `user_role`
  ADD PRIMARY KEY (`id_role`);

--
-- Indeks untuk tabel `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indeks untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD PRIMARY KEY (`id_sub_menu`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_active` (`id_active`);

--
-- Indeks untuk tabel `waktu_absensi`
--
ALTER TABLE `waktu_absensi`
  ADD PRIMARY KEY (`id_waktu_absensi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `auth`
--
ALTER TABLE `auth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `golongan_pegawai`
--
ALTER TABLE `golongan_pegawai`
  MODIFY `id_golongan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `jabatan_pegawai`
--
ALTER TABLE `jabatan_pegawai`
  MODIFY `id_jabatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pangkat_pegawai`
--
ALTER TABLE `pangkat_pegawai`
  MODIFY `id_pangkat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  MODIFY `id_pegawai` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `rekap_gaji`
--
ALTER TABLE `rekap_gaji`
  MODIFY `id_rekap_gaji` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `rekap_gaji_tunj`
--
ALTER TABLE `rekap_gaji_tunj`
  MODIFY `id_rekap_gaji_tunj` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `tpp`
--
ALTER TABLE `tpp`
  MODIFY `id_tpp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tunjangan_pegawai`
--
ALTER TABLE `tunjangan_pegawai`
  MODIFY `id_tunjangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  MODIFY `id_access_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `user_access_sub_menu`
--
ALTER TABLE `user_access_sub_menu`
  MODIFY `id_access_sub_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `user_menu`
--
ALTER TABLE `user_menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `user_role`
--
ALTER TABLE `user_role`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `user_status`
--
ALTER TABLE `user_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  MODIFY `id_sub_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `waktu_absensi`
--
ALTER TABLE `waktu_absensi`
  MODIFY `id_waktu_absensi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pegawai`
--
ALTER TABLE `pegawai`
  ADD CONSTRAINT `pegawai_ibfk_1` FOREIGN KEY (`id_pangkat`) REFERENCES `pangkat_pegawai` (`id_pangkat`) ON UPDATE CASCADE,
  ADD CONSTRAINT `pegawai_ibfk_2` FOREIGN KEY (`id_jabatan`) REFERENCES `jabatan_pegawai` (`id_jabatan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekap_gaji`
--
ALTER TABLE `rekap_gaji`
  ADD CONSTRAINT `rekap_gaji_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rekap_gaji_tunj`
--
ALTER TABLE `rekap_gaji_tunj`
  ADD CONSTRAINT `rekap_gaji_tunj_ibfk_1` FOREIGN KEY (`id_rekap_gaji`) REFERENCES `rekap_gaji` (`id_rekap_gaji`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `rekap_gaji_tunj_ibfk_2` FOREIGN KEY (`id_tunjangan`) REFERENCES `tunjangan_pegawai` (`id_tunjangan`) ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tpp`
--
ALTER TABLE `tpp`
  ADD CONSTRAINT `tpp_ibfk_1` FOREIGN KEY (`id_pegawai`) REFERENCES `pegawai` (`id_pegawai`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`id_active`) REFERENCES `user_status` (`id_status`);

--
-- Ketidakleluasaan untuk tabel `user_access_menu`
--
ALTER TABLE `user_access_menu`
  ADD CONSTRAINT `user_access_menu_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`),
  ADD CONSTRAINT `user_access_menu_ibfk_2` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_access_sub_menu`
--
ALTER TABLE `user_access_sub_menu`
  ADD CONSTRAINT `user_access_sub_menu_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `user_role` (`id_role`),
  ADD CONSTRAINT `user_access_sub_menu_ibfk_2` FOREIGN KEY (`id_sub_menu`) REFERENCES `user_sub_menu` (`id_sub_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user_sub_menu`
--
ALTER TABLE `user_sub_menu`
  ADD CONSTRAINT `user_sub_menu_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `user_menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_sub_menu_ibfk_2` FOREIGN KEY (`id_active`) REFERENCES `user_status` (`id_status`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
