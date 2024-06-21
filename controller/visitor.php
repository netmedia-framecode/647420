<?php

require_once("config/Base.php");
require_once("config/Alert.php");

$tpp = "SELECT tpp.*, pegawai.nama, jabatan_pegawai.nama_jabatan 
  FROM tpp 
  JOIN pegawai ON tpp.id_pegawai=pegawai.id_pegawai 
  JOIN jabatan_pegawai ON pegawai.id_jabatan=jabatan_pegawai.id_jabatan 
  ORDER BY tpp.id_tpp DESC";
$views_tpp = mysqli_query($conn, $tpp);