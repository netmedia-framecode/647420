<?php require_once("../controller/cetak-gaji.php");
$_SESSION["project_penggajian_pegawai"]["name_page"] = "Cetak Gaji";
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
              <th class="text-center">No.</th>
              <th class="text-center">Nama</th>
              <th class="text-center">NIP</th>
              <th class="text-center">Tgl rekap</th>
              <th class="text-center" style="width: 200px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($views_rekap_gaji as $data) { ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['nip'] ?></td>
                <td><?php $created_at = date_create($data["created_at"]);
                    echo date_format($created_at, "d M Y h:i a"); ?></td>
                <?php if ($id_role <= 2) { ?>
                  <td class="text-center">
                    <form action="" method="post">
                      <input type="hidden" name="id_rekap_gaji" value="<?= $data['id_rekap_gaji'] ?>">
                      <button type="submit" name="unduh" class="btn btn-success btn-sm">
                        <i class="bi bi-download"></i> Unduh
                      </button>
                      <button type="submit" name="cetak" class="btn btn-success btn-sm">
                        <i class="bi bi-printer"></i> Cetak
                      </button>
                    </form>
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