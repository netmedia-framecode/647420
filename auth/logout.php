<?php if (!isset($_SESSION)) {
  session_start();
}
require_once("../controller/auth.php");
if (isset($_SESSION["project_penggajian_pegawai"])) {
  unset($_SESSION["project_penggajian_pegawai"]);
  header("Location: ./");
  exit();
}
