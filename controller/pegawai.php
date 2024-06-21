<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$pangkat_pegawai = "SELECT * FROM pangkat_pegawai";
$views_pangkat_pegawai = mysqli_query($conn, $pangkat_pegawai);
$jabatan_pegawai = "SELECT * FROM jabatan_pegawai";
$views_jabatan_pegawai = mysqli_query($conn, $jabatan_pegawai);
$pegawai = "SELECT pegawai.*, pangkat_pegawai.nama_pangkat, jabatan_pegawai.nama_jabatan 
  FROM pegawai 
  JOIN pangkat_pegawai ON pegawai.id_pangkat = pangkat_pegawai.id_pangkat
  JOIN jabatan_pegawai ON pegawai.id_jabatan = jabatan_pegawai.id_jabatan
  ORDER BY pegawai.id_pegawai DESC
";
$views_pegawai = mysqli_query($conn, $pegawai);
if (isset($_POST["add_pegawai"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pegawai($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Pegawai baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pegawai");
    exit();
  }
}
if (isset($_POST["edit_pegawai"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pegawai($conn, $validated_post, $action = 'update') > 0) {
    $message = "Pegawai " . $_POST['namaOld'] . " berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pegawai");
    exit();
  }
}
if (isset($_POST["delete_pegawai"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pegawai($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Pegawai " . $_POST['nama'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pegawai");
    exit();
  }
}
if (isset($_POST["export"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pegawai($conn, $validated_post, $action = 'export') > 0) {
    $message = "Data pegawai berhasil di export.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pegawai");
    exit();
  }
}
