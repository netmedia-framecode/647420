<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$tunjangan_pegawai = "SELECT * FROM tunjangan_pegawai";
$views_tunjangan_pegawai = mysqli_query($conn, $tunjangan_pegawai);
if (isset($_POST["add"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (tunjangan_pegawai($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Tunjangan pegawai baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: tunjangan-pegawai");
    exit();
  }
}
if (isset($_POST["edit"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (tunjangan_pegawai($conn, $validated_post, $action = 'update') > 0) {
    $message = "Tunjangan pegawai " . $_POST['nama_tunjanganOld'] . " berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: tunjangan-pegawai");
    exit();
  }
}
if (isset($_POST["delete"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (tunjangan_pegawai($conn, $validated_post, $action = 'delete') > 0) {
    $message = "Tunjangan pegawai " . $_POST['nama_tunjangan'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: tunjangan-pegawai");
    exit();
  }
}
