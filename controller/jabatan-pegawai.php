<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$jabatan_pegawai = "SELECT * FROM jabatan_pegawai";
$views_jabatan_pegawai = mysqli_query($conn, $jabatan_pegawai);
if (isset($_POST["add_jabatan_pegawai"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (jabatan_pegawai($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Jabatan pegawai baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: jabatan-pegawai");
    exit();
  }
}
if (isset($_POST["edit_jabatan_pegawai"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (jabatan_pegawai($conn, $validated_post, $action = 'update') > 0) {
    $message = "Jabatan pegawai " . $_POST['nama_jabatanOld'] . " berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: jabatan-pegawai");
    exit();
  }
}
if (isset($_POST["delete_jabatan_pegawai"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (jabatan_pegawai($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Jabatan pegawai " . $_POST['nama_jabatan'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: jabatan-pegawai");
    exit();
  }
}
