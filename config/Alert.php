<?php

$messageTypes = ["success", "info", "warning", "danger", "dark"];

if (!isset($_SESSION["project_penggajian_pegawai"]["users"])) {
  if (isset($_SESSION["project_penggajian_pegawai"]["time_message"]) && (time() - $_SESSION["project_penggajian_pegawai"]["time_message"]) > 2) {
    foreach ($messageTypes as $type) {
      if (isset($_SESSION["project_penggajian_pegawai"]["message_$type"])) {
        unset($_SESSION["project_penggajian_pegawai"]["message_$type"]);
      }
    }
    unset($_SESSION["project_penggajian_pegawai"]["time_message"]);
  }
} else if (isset($_SESSION["project_penggajian_pegawai"]["users"])) {
  if (isset($_SESSION["project_penggajian_pegawai"]["users"]["time_message"]) && (time() - $_SESSION["project_penggajian_pegawai"]["users"]["time_message"]) > 2) {
    foreach ($messageTypes as $type) {
      if (isset($_SESSION["project_penggajian_pegawai"]["users"]["message_$type"])) {
        unset($_SESSION["project_penggajian_pegawai"]["users"]["message_$type"]);
      }
    }
    unset($_SESSION["project_penggajian_pegawai"]["users"]["time_message"]);
  }
}
