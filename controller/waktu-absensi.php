<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$waktu_absensi = "SELECT * FROM waktu_absensi ORDER BY id_waktu_absensi DESC LIMIT 1";
$views_waktu_absensi = mysqli_query($conn, $waktu_absensi);
if (isset($_POST["add"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (waktu_absensi($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Waktu absensi baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: waktu-absensi");
    exit();
  }
}
if (isset($_POST["edit"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (waktu_absensi($conn, $validated_post, $action = 'update') > 0) {
    $message = "Waktu absensi berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: waktu-absensi");
    exit();
  }
}
