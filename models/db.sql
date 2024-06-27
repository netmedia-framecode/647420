-- Active: 1711937588478@@127.0.0.1@3306@penggajian_pegawai
CREATE TABLE auth(
  id INT AUTO_INCREMENT PRIMARY KEY,
  image VARCHAR(50),
  bg VARCHAR(35)
);

CREATE TABLE user_role(
  id_role INT AUTO_INCREMENT PRIMARY KEY,
  role VARCHAR(35)
);

INSERT INTO
  user_role(role)
VALUES
  ('Administrator'),
  ('Owner'),
  ('Member');

CREATE TABLE user_status(
  id_status INT AUTO_INCREMENT PRIMARY KEY,
  status VARCHAR(35)
);

INSERT INTO
  user_status(status)
VALUES
  ('Active'),
  ('No Active');

CREATE TABLE users(
  id_user INT AUTO_INCREMENT PRIMARY KEY,
  id_role INT,
  id_active INT,
  en_user VARCHAR(75),
  token CHAR(6),
  name VARCHAR(100),
  image VARCHAR(100),
  email VARCHAR(75),
  password VARCHAR(100),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_role) REFERENCES user_role(id_role) ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (id_active) REFERENCES user_status(id_active) ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE user_menu(
  id_menu INT AUTO_INCREMENT PRIMARY KEY,
  menu VARCHAR(50)
);

CREATE TABLE user_sub_menu(
  id_sub_menu INT AUTO_INCREMENT PRIMARY KEY,
  id_menu INT,
  id_active INT,
  title VARCHAR(50),
  url VARCHAR(50),
  icon VARCHAR(50),
  FOREIGN KEY (id_menu) REFERENCES user_menu(id_menu) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (id_active) REFERENCES user_status(id_active) ON UPDATE NO ACTION ON DELETE NO ACTION
);

CREATE TABLE user_access_menu(
  id_access_menu INT AUTO_INCREMENT PRIMARY KEY,
  id_role INT,
  id_menu INT,
  FOREIGN KEY (id_role) REFERENCES user_role(id_role) ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (id_menu) REFERENCES user_menu(id_menu) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE user_access_sub_menu(
  id_access_sub_menu INT AUTO_INCREMENT PRIMARY KEY,
  id_role INT,
  id_sub_menu INT,
  FOREIGN KEY (id_role) REFERENCES user_role(id_role) ON UPDATE NO ACTION ON DELETE NO ACTION,
  FOREIGN KEY (id_sub_menu) REFERENCES user_sub_menu(id_sub_menu) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE pangkat_pegawai(
  id_pangkat INT AUTO_INCREMENT PRIMARY KEY,
  nama_pangkat VARCHAR(35)
);

CREATE TABLE jabatan_pegawai(
  id_jabatan INT AUTO_INCREMENT PRIMARY KEY,
  nama_jabatan VARCHAR(35)
);

CREATE TABLE pegawai(
  id_pegawai INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  nip VARCHAR(50),
  id_pangkat INT,
  id_jabatan INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_pangkat) REFERENCES pangkat_pegawai(id_pangkat) ON UPDATE CASCADE ON DELETE NO ACTION,
  FOREIGN KEY (id_jabatan) REFERENCES jabatan_pegawai(id_jabatan) ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE tpp(
  id_tpp INT AUTO_INCREMENT PRIMARY KEY,
  id_pegawai INT,
  kelas_jabatan INT,
  besaran_tpp_kpk CHAR(40),
  besaran_kpk CHAR(40),
  persen_kpk INT,
  nilai_kpk FLOAT,
  jumlah_kpk CHAR(40),
  besaran_kdk CHAR(40),
  persen_kdk INT,
  nilai_kdk FLOAT,
  jumlah_kdk CHAR(40),
  jumlah_tpp_sblm_kpal CHAR(40),
  persen_lap_gratifikasi INT,
  nilai_lap_gratifikasi INT,
  persen_pengembalian_bmd INT,
  nilai_pengembalian_bmd INT,
  persen_tptgr INT,
  nilai_tptgr INT,
  persen_jhkpn INT,
  nilai_jhkpn INT,
  jumlah_tpp_sblm_pajak CHAR(40),
  pasal_21 INT,
  jumlah_tpp_setelah_pajak CHAR(40),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_pegawai) REFERENCES pegawai(id_pegawai) ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE waktu_absensi(
  id_waktu_absensi INT AUTO_INCREMENT PRIMARY KEY,
  waktu_masuk DATETIME,
  waktu_pulang DATETIME,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE radius_absen(
  id_radius INT AUTO_INCREMENT PRIMARY KEY,
  radius INT,
  latitude VARCHAR(50),
  longitude VARCHAR(50),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE absensi(
  id_absensi INT AUTO_INCREMENT PRIMARY KEY,
  id_pegawai INT,
  waktu_masuk DATETIME,
  waktu_pulang DATETIME,
  status_absensi VARCHAR(35),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_pegawai) REFERENCES pegawai(id_pegawai) ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE golongan_pegawai(
  id_golongan INT AUTO_INCREMENT PRIMARY KEY,
  nama_golongan VARCHAR(35),
  upah_golongan CHAR(40)
);

CREATE TABLE tunjangan_pegawai(
  id_tunjangan INT AUTO_INCREMENT PRIMARY KEY,
  nama_tunjangan CHAR(40),
  upah_tunjangan CHAR(40)
);

CREATE TABLE rekap_gaji(
  id_rekap_gaji INT AUTO_INCREMENT PRIMARY KEY,
  id_pegawai INT,
  gaji CHAR(40),
  total_absensi INT,
  presentasi_absensi INT,
  total_hari_kerja INT,
  jumlah_bruto CHAR(40),
  jumlah_potongan CHAR(40),
  jumlah_dibayarkan CHAR(40),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (id_pegawai) REFERENCES pegawai(id_pegawai) ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE rekap_gaji_tunj(
  id_rekap_gaji_tunj INT AUTO_INCREMENT PRIMARY KEY,
  id_rekap_gaji INT,
  id_tunjangan INT,
  FOREIGN KEY (id_rekap_gaji) REFERENCES rekap_gaji(id_rekap_gaji) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (id_tunjangan) REFERENCES tunjangan_pegawai(id_tunjangan) ON UPDATE CASCADE ON DELETE NO ACTION
);

CREATE TABLE potongan_pegawai(
  id_potongan INT AUTO_INCREMENT PRIMARY KEY,
  nama_potongan CHAR(40),
  upah_potongan CHAR(40)
);

CREATE TABLE rekap_gaji_potongan(
  id_rekap_gaji_potongan INT AUTO_INCREMENT PRIMARY KEY,
  id_rekap_gaji INT,
  id_potongan INT,
  upah_dipotong CHAR(40),
  FOREIGN KEY (id_rekap_gaji) REFERENCES rekap_gaji(id_rekap_gaji) ON UPDATE CASCADE ON DELETE CASCADE,
  FOREIGN KEY (id_potongan) REFERENCES potongan_pegawai(id_potongan) ON UPDATE CASCADE ON DELETE NO ACTION
);