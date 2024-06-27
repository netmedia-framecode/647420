<?php require_once("../controller/rekap-gaji.php");
$_SESSION["project_penggajian_pegawai"]["name_page"] = "Rekap Gaji";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_penggajian_pegawai"]["name_page"] ?></h1>
    <?php if ($id_role <= 2) { ?>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah"><i class="bi bi-plus-lg"></i> Tambah</a>
    <?php } ?>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center" rowspan="2">Nama</th>
              <th class="text-center" rowspan="2">NIP</th>
              <th class="text-center" rowspan="2">Golongan</th>
              <th class="text-center" rowspan="2">Jabatan</th>
              <th class="text-center" rowspan="2">Total Absensi</th>
              <th class="text-center" rowspan="2">Jumlah Hari Kerja</th>
              <th class="text-center" colspan="<?= mysqli_num_rows($count_tunj) + 2; ?>">Penghasilan</th>
              <th class="text-center" colspan="<?= mysqli_num_rows($count_potongan) + 1; ?>">Potongan</th>
              <th class="text-center" rowspan="2">Jumlah Yang Dibayarkan</th>
              <th class="text-center" rowspan="2">Tgl rekap</th>
              <?php if ($id_role <= 2) { ?>
                <th class="text-center" rowspan="2" style="width: 200px;">Aksi</th>
              <?php } ?>
            </tr>
            <tr>
              <th class="text-center">Gaji Pokok</th>
              <?php if (mysqli_num_rows($views_tunjangan_pegawai) > 0) {
                while ($data_tunj = mysqli_fetch_assoc($views_tunjangan_pegawai)) { ?>
                  <th class="text-center"><?= $data_tunj['nama_tunjangan'] ?></th>
              <?php }
              } ?>
              <th class="text-center">Jumlah Bruto</th>
              <?php if (mysqli_num_rows($views_potongan_pegawai) > 0) {
                while ($data_tunj = mysqli_fetch_assoc($views_potongan_pegawai)) { ?>
                  <th class="text-center"><?= $data_tunj['nama_potongan'] ?></th>
              <?php }
              } ?>
              <th class="text-center">Jumlah Potongan</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($views_rekap_gaji as $data) { ?>
              <tr>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['nip'] ?></td>
                <td><?= $data['nama_pangkat'] ?></td>
                <td><?= $data['nama_jabatan'] ?></td>
                <td><?= $data['total_absensi'] ?> <br>
                  <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: <?= $data['presentasi_absensi'] ?>%;" aria-valuenow="<?= $data['presentasi_absensi'] ?>" aria-valuemin="0" aria-valuemax="100"><?= $data['presentasi_absensi'] ?>%</div>
                  </div>
                </td>
                <td><?= $data['total_hari_kerja'] ?></td>
                <td>Rp.<?= number_format($data['gaji']) ?></td>
                <?php $id_rekap_gaji = $data['id_rekap_gaji'];
                $rekap_gaji_tunj = "SELECT * FROM rekap_gaji_tunj JOIN tunjangan_pegawai ON rekap_gaji_tunj.id_tunjangan=tunjangan_pegawai.id_tunjangan WHERE rekap_gaji_tunj.id_rekap_gaji='$id_rekap_gaji'";
                $views_rekap_gaji_tunj = mysqli_query($conn, $rekap_gaji_tunj);
                if (mysqli_num_rows($views_rekap_gaji_tunj) > 0) {
                  while ($data_rgt = mysqli_fetch_assoc($views_rekap_gaji_tunj)) { ?>
                    <td>Rp.<?= number_format($data_rgt['upah_tunjangan']) ?></td>
                <?php }
                } ?>
                <td>Rp.<?= number_format($data['jumlah_bruto']) ?></td>
                <?php $rekap_gaji_potongan = "SELECT * FROM rekap_gaji_potongan WHERE id_rekap_gaji='$id_rekap_gaji'";
                $views_rekap_gaji_potongan = mysqli_query($conn, $rekap_gaji_potongan);
                if (mysqli_num_rows($views_rekap_gaji_potongan) > 0) {
                  while ($data_rgp = mysqli_fetch_assoc($views_rekap_gaji_potongan)) { ?>
                    <td>Rp.<?= number_format($data_rgp['upah_dipotong']) ?></td>
                <?php }
                } ?>
                <td>Rp.<?= number_format($data['jumlah_potongan']) ?></td>
                <td>Rp.<?= number_format($data['jumlah_dibayarkan']) ?></td>
                <td><?php $created_at = date_create($data["created_at"]);
                    echo date_format($created_at, "d M Y h:i a"); ?></td>
                <?php if ($id_role <= 2) { ?>
                  <td class="text-center">
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_rekap_gaji'] ?>">
                      <i class="bi bi-trash3"></i> Hapus
                    </button>
                    <div class="modal fade" id="hapus<?= $data['id_rekap_gaji'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom-0 shadow">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus rekap gaji <?= $data['nama'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="" method="post">
                            <input type="hidden" name="id_rekap_gaji" value="<?= $data['id_rekap_gaji'] ?>">
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

  <?php if ($id_role <= 2) { ?>
    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header border-bottom-0 shadow">
            <h5 class="modal-title" id="tambahLabel">Tambah Rekap Gaji Pegawai</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="" method="post">
            <div class="modal-body">
              <div class="form-group">
                <label for="id_pegawai">Pegawai</label>
                <select name="id_pegawai" class="form-control" id="id_pegawai" required>
                  <option value="" selected>Pilih Pegawai</option>
                  <?php foreach ($views_pegawai as $data_select_pegawai) { ?>
                    <option value="<?= $data_select_pegawai['id_pegawai'] ?>" data-upah="<?= $data_select_pegawai['upah_golongan'] ?>"><?= $data_select_pegawai['nama'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div id="gaji_tunjangan_section" style="display: none;">
                <div class="form-group">
                  <label for="upah_golongan">Gaji</label>
                  <input type="number" name="upah_golongan" class="form-control" id="upah_golongan" required readonly>
                </div>
                <?php if (mysqli_num_rows($views_tunjangan_pegawai_insert) > 0) {
                  while ($data_tunj = mysqli_fetch_assoc($views_tunjangan_pegawai_insert)) { ?>
                    <div class="form-group">
                      <label for="id_tunjangan"><?= $data_tunj['nama_tunjangan'] ?></label>
                      <input type="hidden" name="id_tunjangan[]" value="<?= $data_tunj['id_tunjangan'] ?>" required>
                      <input type="number" name="upah_tunjangan[]" value="<?= $data_tunj['upah_tunjangan'] ?>" class="form-control" id="id_tunjangan" required>
                    </div>
                  <?php }
                }

                if (mysqli_num_rows($views_potongan_pegawai_insert) > 0) {
                  while ($data_tunj = mysqli_fetch_assoc($views_potongan_pegawai_insert)) { ?>
                    <div class="form-group">
                      <label for="id_potongan"><?= $data_tunj['nama_potongan'] ?></label>
                      <input type="hidden" name="id_potongan[]" value="<?= $data_tunj['id_potongan'] ?>" required>
                      <input type="number" name="upah_potongan[]" value="<?= $data_tunj['upah_potongan'] ?>" class="form-control" id="id_potongan" required>
                    </div>
                <?php }
                } ?>
              </div>
            </div>
            <div class="modal-footer justify-content-center border-top-0">
              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
              <button type="submit" name="add" class="btn btn-primary btn-sm">Tambah</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php } ?>

</div>
<!-- /.container-fluid -->

<script>
  document.getElementById('id_pegawai').addEventListener('change', function() {
    var gajiTunjanganSection = document.getElementById('gaji_tunjangan_section');
    var upahGolonganInput = document.getElementById('upah_golongan');
    var selectedOption = this.options[this.selectedIndex];
    var upah = selectedOption.getAttribute('data-upah');

    if (this.value) {
      upahGolonganInput.value = upah;
      gajiTunjanganSection.style.display = 'block';
    } else {
      upahGolonganInput.value = '';
      gajiTunjanganSection.style.display = 'none';
    }
  });
</script>
<?php require_once("../templates/views_bottom.php") ?>