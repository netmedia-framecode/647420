<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$potongan_pegawai = "SELECT * FROM potongan_pegawai";
$views_potongan_pegawai = mysqli_query($conn, $potongan_pegawai);
if (isset($_POST["add"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (potongan_pegawai($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Potongan pegawai baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: potongan-pegawai");
    exit();
  }
}
if (isset($_POST["edit"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (potongan_pegawai($conn, $validated_post, $action = 'update') > 0) {
    $message = "Potongan pegawai " . $_POST['nama_potonganOld'] . " berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: potongan-pegawai");
    exit();
  }
}
if (isset($_POST["delete"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (potongan_pegawai($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Potongan pegawai " . $_POST['nama_potongan'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: potongan-pegawai");
    exit();
  }
}
