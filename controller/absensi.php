<?php

require_once("../config/Base.php");
require_once("../config/Auth.php");
require_once("../config/Alert.php");

// $ip = $_SERVER['REMOTE_ADDR'];
$ip = "180.249.166.60";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://ipinfo.io/' . $ip . '/json?token=7ac8e9c9be73ba');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
if (curl_errno($ch)) {
  echo 'Error:' . curl_error($ch);
}
curl_close($ch);
$data_geolocation = json_decode($result);

$latitude = $data_geolocation->loc ? explode(',', $data_geolocation->loc)[0] : null;
$longitude = $data_geolocation->loc ? explode(',', $data_geolocation->loc)[1] : null;

if ($id_role <= 2) {
  $absensi = "SELECT absensi.*, pegawai.nama, pegawai.nip 
    FROM absensi 
    JOIN pegawai ON absensi.id_pegawai=pegawai.id_pegawai
    ORDER BY absensi.id_absensi DESC
  ";
} else if ($id_role == 3) {
  $absensi = "SELECT absensi.*, pegawai.nama, pegawai.nip 
    FROM absensi 
    JOIN pegawai ON absensi.id_pegawai=pegawai.id_pegawai
    JOIN users ON pegawai.nama=users.name
    WHERE users.name='$name'
    ORDER BY absensi.id_absensi DESC
  ";
}
$views_absensi = mysqli_query($conn, $absensi);
if (isset($_POST["delete"])) {
  $validated_post = array_map(function ($value) use ($conn) {
    return valid($conn, $value);
  }, $_POST);
  if (absensi($conn, $validated_post, $latitude, $longitude, $action = 'delete') > 0) {
    $message = "Absensi pegawai atas nama " . $_POST['nama'] . " berhasil dihapus.";
    $message_type = "success";
    alert($message, $message_type);
    header("Location: absensi");
    exit();
  }
}
