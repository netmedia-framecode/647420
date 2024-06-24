<?php require_once("../controller/dashboard.php");
$_SESSION["project_penggajian_pegawai"]["name_page"] = "";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
  </div>

  <div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                Pegawai</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($count_pegawai); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                Absensi</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($count_absensi); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-user-check fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <?php if ($id_role <= 2) { ?>
      <div class="col-xl-12 col-lg-7">
      <?php } else if ($id_role == 3) { ?>
        <div class="col-xl-8 col-lg-7">
        <?php } ?>
        <div class="card shadow mb-4">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Data Absensi</h6>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
                <thead>
                  <tr>
                    <th class="text-center">Nama</th>
                    <th class="text-center">NIP</th>
                    <th class="text-center">Waktu Absen</th>
                    <th class="text-center">Tgl masuk</th>
                    <th class="text-center">Status</th>
                    <?php if ($id_role <= 2) { ?>
                      <th class="text-center" style="width: 200px;">Aksi</th>
                    <?php } ?>
                  </tr>
                </thead>
                <tfoot>
                  <tr>
                    <th class="text-center">Nama</th>
                    <th class="text-center">NIP</th>
                    <th class="text-center">Waktu Absen</th>
                    <th class="text-center">Tgl masuk</th>
                    <th class="text-center">Status</th>
                    <?php if ($id_role <= 2) { ?>
                      <th class="text-center">Aksi</th>
                    <?php } ?>
                  </tr>
                </tfoot>
                <tbody>
                  <?php foreach ($views_absensi as $data) { ?>
                    <tr>
                      <td><?= $data['nama'] ?></td>
                      <td><?= $data['nip'] ?></td>
                      <td><?php $waktu_masuk = date_create($data["waktu_masuk"]);
                          echo date_format($waktu_masuk, "h:i a"); ?></td>
                      <td><?php $created_at = date_create($data["created_at"]);
                          echo date_format($created_at, "d M Y"); ?></td>
                      <td><?= $data['status_absensi'] ?></td>
                      <?php if ($id_role <= 2) { ?>
                        <td class="text-center">
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_absensi'] ?>">
                            <i class="bi bi-trash3"></i> Hapus
                          </button>
                          <div class="modal fade" id="hapus<?= $data['id_absensi'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header border-bottom-0 shadow">
                                  <h5 class="modal-title" id="exampleModalLabel">Hapus absensi <?= $data['nama'] ?></h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <form action="" method="post">
                                  <input type="hidden" name="id_absensi" value="<?= $data['id_absensi'] ?>">
                                  <input type="hidden" name="nama" value="<?= $data['nama'] ?>">
                                  <div class="modal-body">
                                    <p>Jika anda yakin ingin menghapus data ini, klik Hapus!</p>
                                  </div>
                                  <div class="modal-footer justify-content-center border-top-0">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                                    <button type="submit" name="delete" class="btn btn-danger btn-sm">hapus</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </td>
                      <?php } ?>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        </div>

        <?php if ($id_role == 3) { ?>
          <style>
            .time-display {
              font-size: 24px;
              font-weight: bold;
              text-align: center;
              margin-bottom: 20px;
            }
          </style>
          <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Absen</h6>
              </div>
              <div class="card-body">
                <div class="time-display" id="timeDisplay"></div>
                <?php if (mysqli_num_rows($take_pegawai)) {
                  $data_pegawai = mysqli_fetch_assoc($take_pegawai); ?>
                  <form action="" method="post">
                    <?php
                    date_default_timezone_set('Asia/Makassar');
                    $current_time = date('H:i:s');
                    ?>
                    <input type="hidden" name="id_pegawai" value="<?= $data_pegawai['id_pegawai'] ?>">
                    <input type="hidden" name="waktu_masuk" value="<?= $current_time ?>">
                    <input type="hidden" name="waktu_pulang" value="<?= $current_time ?>">
                    <button type="submit" name="add" class="btn btn-primary btn-block" onclick="setWaktuAbsen()">Absen</button>
                  </form>
                <?php } ?>
              </div>
            </div>
          </div>
          <script>
            function updateTime() {
              const timeDisplay = document.getElementById('timeDisplay');
              const now = new Date();
              timeDisplay.textContent = now.toLocaleTimeString();
            }

            function setWaktuAbsen() {
              const now = new Date();
              const waktuMasukInput = document.getElementById('waktuMasuk');
              const waktuPulangInput = document.getElementById('waktuPulang');
              const formattedTime = now.toISOString().slice(0, 19).replace('T', ' ');

              waktuMasukInput.value = formattedTime;
              waktuPulangInput.value = formattedTime;
            }

            setInterval(updateTime, 1000);
            updateTime();
          </script>
        <?php } ?>
      </div>

  </div>
  <!-- /.container-fluid -->

  <?php require_once("../templates/views_bottom.php") ?>