<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$radius_absen = "SELECT * FROM radius_absen ORDER BY id_radius DESC LIMIT 1";
$views_radius_absen = mysqli_query($conn, $radius_absen);
if (isset($_POST["add"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (radius_absen($conn, $validated_post, $action = 'insert') > 0) {
    $message = "Radius absen baru berhasil ditambahkan.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: radius-absen");
    exit();
  }
}
if (isset($_POST["edit"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (radius_absen($conn, $validated_post, $action = 'update') > 0) {
    $message = "Radius absen berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: radius-absen");
    exit();
  }
}
