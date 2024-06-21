<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$pegawai = "SELECT* FROM pegawai ORDER BY pegawai.id_pegawai DESC";
$views_pegawai = mysqli_query($conn, $pegawai);
$tpp = "SELECT tpp.*, pegawai.nama, jabatan_pegawai.nama_jabatan 
  FROM tpp 
  JOIN pegawai ON tpp.id_pegawai=pegawai.id_pegawai 
  JOIN jabatan_pegawai ON pegawai.id_jabatan=jabatan_pegawai.id_jabatan 
  ORDER BY tpp.id_tpp DESC";
$views_tpp = mysqli_query($conn, $tpp);
if (isset($_POST["add"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (tpp($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Data TPP pegawai berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: daftar-tpp");
    exit();
  }
}
if (isset($_POST["edit"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (tpp($conn, $validated_post, $action = 'update') > 0) {
    $message = "Data TPP pegawai " . $_POST['nama'] . " berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: daftar-tpp");
    exit();
  }
}
if (isset($_POST["delete"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (tpp($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Data TPP pegawai " . $_POST['nama'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: daftar-tpp");
    exit();
  }
}
if (isset($_POST["export"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (tpp($conn, $validated_post, $action = 'export') > 0) {
    $message = "Data TPP berhasil di export.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: daftar-tpp");
    exit();
  }
}
