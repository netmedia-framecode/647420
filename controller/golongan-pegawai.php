<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

$golongan_pegawai = "SELECT * FROM golongan_pegawai";
$views_golongan_pegawai = mysqli_query($conn, $golongan_pegawai);
if (isset($_POST["edit"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (golongan_pegawai($conn, $validated_post, $action = 'update') > 0) {
    $message = "Upah golongan " . $_POST['nama_golonganOld'] . " berhasil diubah.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: golongan-pegawai");
    exit();
  }
}
