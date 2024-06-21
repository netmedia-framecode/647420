<?php
if (isset($_SESSION["project_penggajian_pegawai"]["users"])) {
  header("Location: ../views/");
  exit;
}
