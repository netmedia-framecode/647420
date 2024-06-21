<?php require_once("../controller/absensi.php");
$_SESSION["project_penggajian_pegawai"]["name_page"] = "Absensi";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_penggajian_pegawai"]["name_page"] ?></h1>
  </div>

  <div class="card shadow mb-4 border-0">
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
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>