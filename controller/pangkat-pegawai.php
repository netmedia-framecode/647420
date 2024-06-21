<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$pangkat_pegawai = "SELECT * FROM pangkat_pegawai";
$views_pangkat_pegawai = mysqli_query($conn, $pangkat_pegawai);
if (isset($_POST["add_pangkat_pegawai"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pangkat_pegawai($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Pangkat pegawai baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pangkat-pegawai");
    exit();
  }
}
if (isset($_POST["edit_pangkat_pegawai"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pangkat_pegawai($conn, $validated_post, $action = 'update') > 0) {
    $message = "Pangkat pegawai " . $_POST['nama_pangkatOld'] . " berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pangkat-pegawai");
    exit();
  }
}
if (isset($_POST["delete_pangkat_pegawai"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (pangkat_pegawai($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Pangkat pegawai " . $_POST['nama_pangkat'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: pangkat-pegawai");
    exit();
  }
}
