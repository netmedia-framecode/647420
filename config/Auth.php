<?php

$id_user = valid($conn, $_SESSION["project_penggajian_pegawai"]["users"]["id"]);
$id_role = valid($conn, $_SESSION["project_penggajian_pegawai"]["users"]["id_role"]);
$role = valid($conn, $_SESSION["project_penggajian_pegawai"]["users"]["role"]);
$email = valid($conn, $_SESSION["project_penggajian_pegawai"]["users"]["email"]);
$name = valid($conn, $_SESSION["project_penggajian_pegawai"]["users"]["name"]);
$image = valid($conn, $_SESSION["project_penggajian_pegawai"]["users"]["image"]);
