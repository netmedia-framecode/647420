<?php require_once("../controller/pegawai.php");
$_SESSION["project_penggajian_pegawai"]["name_page"] = "Pegawai";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_penggajian_pegawai"]["name_page"] ?></h1>
    <div>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#tambah"><i class="bi bi-plus-lg"></i> Tambah</a>
      <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm" data-toggle="modal" data-target="#export"><i class="bi bi-download"></i> Export</a>
    </div>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center">Nama</th>
              <th class="text-center">NIP</th>
              <th class="text-center">Pangkat/Gol Ruang</th>
              <th class="text-center">Jabatan</th>
              <th class="text-center" style="width: 200px;">Aksi</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th class="text-center">Nama</th>
              <th class="text-center">NIP</th>
              <th class="text-center">Pangkat/Gol Ruang</th>
              <th class="text-center">Jabatan</th>
              <th class="text-center">Aksi</th>
            </tr>
          </tfoot>
          <tbody>
            <?php foreach ($views_pegawai as $data) { ?>
              <tr>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['nip'] ?></td>
                <td><?= $data['nama_pangkat'] ?></td>
                <td><?= $data['nama_jabatan'] ?></td>
                <td class="text-center">
                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_pegawai'] ?>">
                    <i class="bi bi-pencil-square"></i> Ubah
                  </button>
                  <div class="modal fade" id="ubah<?= $data['id_pegawai'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $data['nama'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_pegawai" value="<?= $data['id_pegawai'] ?>">
                          <input type="hidden" name="namaOld" value="<?= $data['nama'] ?>">
                          <div class="modal-body">
                            <div class="form-group">
                              <label for="nama">Nama</label>
                              <input type="text" name="nama" value="<?= $data['nama'] ?>" class="form-control" id="nama" required>
                            </div>
                            <div class="form-group">
                              <label for="nip">NIP</label>
                              <input type="number" name="nip" value="<?= $data['nip'] ?>" class="form-control" id="nip" required>
                            </div>
                            <div class="form-group">
                              <label for="id_pangkat">Pangkat</label>
                              <select name="id_pangkat" class="form-control" id="id_pangkat" required>
                                <option value="" selected>Pilih Pangkat</option>
                                <?php $id_pangkat = $data['id_pangkat'];
                                foreach ($views_pangkat_pegawai as $data_select_pangkat_pegawai) {
                                  $selected = ($data_select_pangkat_pegawai['id_pangkat'] == $id_pangkat) ? 'selected' : ''; ?>
                                  <option value="<?= $data_select_pangkat_pegawai['id_pangkat'] ?>" <?= $selected ?>><?= $data_select_pangkat_pegawai['nama_pangkat'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="id_jabatan">Jabatan</label>
                              <select name="id_jabatan" class="form-control" id="id_jabatan" required>
                                <option value="" selected>Pilih Jabatan</option>
                                <?php $id_jabatan = $data['id_jabatan'];
                                foreach ($views_jabatan_pegawai as $data_select_jabatan_pegawai) {
                                  $selected = ($data_select_jabatan_pegawai['id_jabatan'] == $id_jabatan) ? 'selected' : ''; ?>
                                  <option value="<?= $data_select_jabatan_pegawai['id_jabatan'] ?>" <?= $selected ?>><?= $data_select_jabatan_pegawai['nama_jabatan'] ?></option>
                                <?php } ?>
                              </select>
                            </div>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="edit_pegawai" class="btn btn-warning btn-sm">Ubah</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                  <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_pegawai'] ?>">
                    <i class="bi bi-trash3"></i> Hapus
                  </button>
                  <div class="modal fade" id="hapus<?= $data['id_pegawai'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header border-bottom-0 shadow">
                          <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $data['nama'] ?></h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <form action="" method="post">
                          <input type="hidden" name="id_pegawai" value="<?= $data['id_pegawai'] ?>">
                          <input type="hidden" name="nama" value="<?= $data['nama'] ?>">
                          <div class="modal-body">
                            <p>Jika anda yakin ingin menghapus data ini, klik Hapus!</p>
                          </div>
                          <div class="modal-footer justify-content-center border-top-0">
                            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                            <button type="submit" name="delete_pegawai" class="btn btn-danger btn-sm">hapus</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 shadow">
          <h5 class="modal-title" id="tambahLabel">Tambah Pegawai</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="form-group">
              <label for="nama">Nama</label>
              <input type="text" name="nama" class="form-control" id="nama" required>
            </div>
            <div class="form-group">
              <label for="nip">NIP</label>
              <input type="number" name="nip" class="form-control" id="nip" required>
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="form-group">
              <label for="id_pangkat">Pangkat</label>
              <select name="id_pangkat" class="form-control" id="id_pangkat" required>
                <option value="" selected>Pilih Pangkat</option>
                <?php foreach ($views_pangkat_pegawai as $data_select_pangkat_pegawai) { ?>
                  <option value="<?= $data_select_pangkat_pegawai['id_pangkat'] ?>"><?= $data_select_pangkat_pegawai['nama_pangkat'] ?></option>
                <?php } ?>
              </select>
            </div>
            <div class="form-group">
              <label for="id_jabatan">Jabatan</label>
              <select name="id_jabatan" class="form-control" id="id_jabatan" required>
                <option value="" selected>Pilih Jabatan</option>
                <?php foreach ($views_jabatan_pegawai as $data_select_jabatan_pegawai) { ?>
                  <option value="<?= $data_select_jabatan_pegawai['id_jabatan'] ?>"><?= $data_select_jabatan_pegawai['nama_jabatan'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-top-0">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" name="add_pegawai" class="btn btn-primary btn-sm">Tambah</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="export" tabindex="-1" aria-labelledby="exportLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header border-bottom-0 shadow">
          <h5 class="modal-title" id="exportLabel">Export Pegawai</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="form-group">
              <label for="format_file">Format</label>
              <select name="format_file" id="format_file" class="form-select form-control" required>
                <option selected value="">Pilih Format</option>
                <option value="pdf">PDF</option>
                <option value="excel">Excel</option>
              </select>
            </div>
          </div>
          <div class="modal-footer justify-content-center border-top-0">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
            <button type="submit" name="export" class="btn btn-primary btn-sm">Export</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>
<!-- /.container-fluid -->

<?php require_once("../templates/views_bottom.php") ?>