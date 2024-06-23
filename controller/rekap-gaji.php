<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$pegawai = "SELECT * 
  FROM pegawai
  JOIN golongan_pegawai ON pegawai.id_pangkat = golongan_pegawai.id_golongan
";
$views_pegawai = mysqli_query($conn, $pegawai);
$tunj = "SELECT * FROM tunjangan_pegawai";
$count_tunj = mysqli_query($conn, $tunj);
$tunjangan_pegawai = "SELECT * FROM tunjangan_pegawai";
$views_tunjangan_pegawai = mysqli_query($conn, $tunjangan_pegawai);
$tunjangan_pegawai_insert = "SELECT * FROM tunjangan_pegawai";
$views_tunjangan_pegawai_insert = mysqli_query($conn, $tunjangan_pegawai_insert);
$rekap_gaji = "SELECT rekap_gaji.*, pegawai.nama, pegawai.nip, pangkat_pegawai.nama_pangkat, jabatan_pegawai.nama_jabatan 
  FROM rekap_gaji 
  JOIN pegawai ON rekap_gaji.id_pegawai=pegawai.id_pegawai
  JOIN pangkat_pegawai ON pegawai.id_pangkat = pangkat_pegawai.id_pangkat
  JOIN jabatan_pegawai ON pegawai.id_jabatan = jabatan_pegawai.id_jabatan
";
$views_rekap_gaji = mysqli_query($conn, $rekap_gaji);
if (isset($_POST["add"])) {
  // $validated_post = array_map(function ($value) use ($conn) {
  //   return valid($conn, $value);
  // }, $_POST);
  if (rekap_gaji($conn, $_POST, $action = 'insert') > 0) {
    $message = "Rekap gaji pegawai baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: rekap-gaji");
    exit();
  }
}
if (isset($_POST["delete"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (rekap_gaji($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Rekap gaji pegawai " . $_POST['nama'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: rekap-gaji");
    exit();
  }
}
