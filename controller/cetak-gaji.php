<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$rekap_gaji = "SELECT rekap_gaji.*, pegawai.nama, pegawai.nip, pangkat_pegawai.nama_pangkat, jabatan_pegawai.nama_jabatan 
FROM rekap_gaji 
JOIN pegawai ON rekap_gaji.id_pegawai = pegawai.id_pegawai
JOIN pangkat_pegawai ON pegawai.id_pangkat = pangkat_pegawai.id_pangkat
JOIN jabatan_pegawai ON pegawai.id_jabatan = jabatan_pegawai.id_jabatan
";
$views_rekap_gaji = mysqli_query($conn, $rekap_gaji);
if (isset($_POST["unduh"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (cetak_gaji($conn, $validated_post, $action = 'unduh') > 0) {
    $message = "Rekap gaji telah diunduh.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: cetak-gaji");
    exit();
  }
}
if (isset($_POST["cetak"])) {
  $id_rekap_gaji = valid($conn, $_POST['id_rekap_gaji']);
  $_SESSION["project_penggajian_pegawai"]["rekap_gaji"] = ['cetak' => $id_rekap_gaji];
  header("Location: cetak");
  exit();
}
