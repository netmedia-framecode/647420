<?php require_once("../controller/daftar-tpp.php");
$_SESSION["project_penggajian_pegawai"]["name_page"] = "Daftar TPP";
require_once("../templates/views_top.php"); ?>

<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?= $_SESSION["project_penggajian_pegawai"]["name_page"] ?></h1>
    <div class="d-flex">
      <?php if ($id_role <= 2) { ?>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm mr-2" data-toggle="modal" data-target="#tambah"><i class="bi bi-plus-lg"></i> Tambah</a>
      <?php } ?>
      <form action="" method="post">
        <input type="hidden" name="format_file" value="pdf">
        <button type="submit" name="export" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="bi bi-download"></i> Export</button>
      </form>
    </div>
  </div>

  <div class="card shadow mb-4 border-0">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered text-dark" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th class="text-center" rowspan="4">Nama Pejabat / Pegawai</th>
              <th class="text-center" rowspan="4">Jabatan</th>
              <th class="text-center" rowspan="4">Kelas Jabatan</th>
              <th class="text-center" rowspan="4">Besaran TPP</th>
              <th class="text-center" colspan="4">Komponen Produktifitas Kerja</th>
              <th class="text-center" colspan="4">Komponen Disiplin Kerja</th>
              <th class="text-center">Jumlah TPP</th>
              <th class="text-center" colspan="8">Komponen Pengurangan Aspek</th>
              <th class="text-center">Jumlah TPP</th>
              <th class="text-center" rowspan="4">Pasal 21</th>
              <th class="text-center" rowspan="4">Jumlah TPP Setelah Pajak (Rp)</th>
              <?php if ($id_role <= 2) { ?>
                <th class="text-center" rowspan="4" style="width: 200px;">Aksi</th>
              <?php } ?>
            </tr>
            <tr>
              <th class="text-center" rowspan="3">Besaran (Rp)</th>
              <th class="text-center" colspan="2">Pengurangan (Rp)</th>
              <th class="text-center" rowspan="3">Jumlah (Rp)</th>
              <th class="text-center" rowspan="3">Besaran (Rp)</th>
              <th class="text-center" colspan="2">Pengurangan (Rp)</th>
              <th class="text-center" rowspan="3">Jumlah (Rp)</th>
              <th class="text-center">Sblm Pengurangan</th>
              <th class="text-center" colspan="2">Laporan Gratifikasi</th>
              <th class="text-center" colspan="2">Ketepatan Waktu</th>
              <th class="text-center" colspan="2">TPTGR</th>
              <th class="text-center" colspan="2">JHKPN</th>
              <th class="text-center">Sebelum Pajak</th>
            </tr>
            <tr>
              <th class="text-center" rowspan="2">Persen</th>
              <th class="text-center" rowspan="2">Nilai</th>
              <th class="text-center" rowspan="2">Persen</th>
              <th class="text-center" rowspan="2">Nilai</th>
              <th class="text-center" rowspan="2">Aspek Lainnya</th>
              <th class="text-center" rowspan="2">Persen</th>
              <th class="text-center" rowspan="2">Nilai</th>
              <th class="text-center" colspan="2">Pengembalian</th>
              <th class="text-center" rowspan="2">Persen</th>
              <th class="text-center" rowspan="2">Nilai</th>
              <th class="text-center" rowspan="2">Persen</th>
              <th class="text-center" rowspan="2">Nilai</th>
              <th class="text-center" rowspan="2">PPh</th>
            </tr>
            <tr>
              <th class="text-center">Persen</th>
              <th class="text-center">Nilai</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($views_tpp as $data) { ?>
              <tr>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['nama_jabatan'] ?></td>
                <td><?= $data['kelas_jabatan'] ?></td>
                <td>Rp.<?= number_format($data['besaran_tpp_kpk']) ?></td>
                <td>Rp.<?= number_format($data['besaran_kpk']) ?></td>
                <td><?= $data['persen_kpk'] ?>%</td>
                <td>Rp.<?= $data['nilai_kpk'] ?></td>
                <td>Rp.<?= number_format($data['jumlah_kpk']) ?></td>
                <td>Rp.<?= number_format($data['besaran_kdk']) ?></td>
                <td><?= $data['persen_kdk'] ?>%</td>
                <td>Rp.<?= number_format($data['nilai_kdk']) ?></td>
                <td>Rp.<?= number_format($data['jumlah_kdk']) ?></td>
                <td>Rp.<?= number_format($data['jumlah_tpp_sblm_kpal']) ?></td>
                <td><?= $data['persen_lap_gratifikasi'] ?>%</td>
                <td>Rp.<?= number_format($data['nilai_lap_gratifikasi']) ?></td>
                <td><?= $data['persen_pengembalian_bmd'] ?>%</td>
                <td>Rp.<?= number_format($data['nilai_pengembalian_bmd']) ?></td>
                <td><?= $data['persen_tptgr'] ?>%</td>
                <td>Rp.<?= number_format($data['nilai_tptgr']) ?></td>
                <td><?= $data['persen_jhkpn'] ?>%</td>
                <td>Rp.<?= number_format($data['nilai_jhkpn']) ?></td>
                <td>Rp.<?= number_format($data['jumlah_tpp_sblm_pajak']) ?></td>
                <td>Rp.<?= number_format($data['pasal_21']) ?></td>
                <td>Rp.<?= number_format($data['jumlah_tpp_setelah_pajak']) ?></td>
                <?php if ($id_role <= 2) { ?>
                  <td class="text-center">
                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#ubah<?= $data['id_tpp'] ?>">
                      <i class="bi bi-pencil-square"></i> Ubah
                    </button>
                    <div class="modal fade" id="ubah<?= $data['id_tpp'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom-0 shadow">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah <?= $data['nama'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="" method="post">
                            <input type="hidden" name="id_tpp" value="<?= $data['id_tpp'] ?>">
                            <input type="hidden" name="namaOld" value="<?= $data['nama'] ?>">
                            <div class="modal-body">
                              <div class="form-group">
                                <label for="id_pegawai">Pegawai</label>
                                <select name="id_pegawai" class="form-control" id="id_pegawai" required>
                                  <option value="" selected>Pilih Pegawai</option>
                                  <?php $id_pegawai = $data['id_pegawai'];
                                  foreach ($views_pegawai as $data_select_pegawai) {
                                    $selected = ($data_select_pegawai['id_pegawai'] == $id_pegawai) ? 'selected' : ''; ?>
                                    <option value="<?= $data_select_pegawai['id_pegawai'] ?>" <?= $selected ?>><?= $data_select_pegawai['nama'] ?></option>
                                  <?php } ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="kelas_jabatan">Kelas Jabatan</label>
                                <input type="number" name="kelas_jabatan" value="<?= $data['kelas_jabatan'] ?>" class="form-control" id="kelas_jabatan" required>
                              </div>
                              <div class="form-group">
                                <label for="besaran_tpp_kpk">Besaran TPP</label>
                                <input type="number" name="besaran_tpp_kpk" value="<?= $data['besaran_tpp_kpk'] ?>" class="form-control" id="besaran_tpp_kpk" required>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-md-12">
                                  <h5><b>Komponen Produktifitas Kerja</b></h5>
                                  <div class="form-group">
                                    <label for="besaran_kpk">Besaran (Rp)</label>
                                    <input type="number" name="besaran_kpk" value="<?= $data['besaran_kpk'] ?>" class="form-control" id="besaran_kpk" required>
                                  </div>
                                  <h6><b>Pengurangan (Rp)</b></h6>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="persen_kpk">Persen</label>
                                        <input type="number" name="persen_kpk" value="<?= $data['persen_kpk'] ?>" class="form-control" id="persen_kpk" required step="1" max="100">
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="nilai_kpk">Nilai</label>
                                        <input type="number" name="nilai_kpk" value="<?= $data['nilai_kpk'] ?>" class="form-control" id="nilai_kpk" required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="jumlah_kpk">Jumlah (Rp)</label>
                                    <input type="number" name="jumlah_kpk" value="<?= $data['jumlah_kpk'] ?>" class="form-control" id="jumlah_kpk" required>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-md-12">
                                  <h5><b>Komponen Disiplin Kerja</b></h5>
                                  <div class="form-group">
                                    <label for="besaran_kdk">Besaran (Rp)</label>
                                    <input type="number" name="besaran_kdk" value="<?= $data['besaran_kdk'] ?>" class="form-control" id="besaran_kdk" required>
                                  </div>
                                  <h6><b>Pengurangan (Rp)</b></h6>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="persen_kdk">Persen</label>
                                        <input type="number" name="persen_kdk" value="<?= $data['persen_kdk'] ?>" class="form-control" id="persen_kdk" required step="1" max="100">
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="nilai_kdk">Nilai</label>
                                        <input type="number" name="nilai_kdk" value="<?= $data['nilai_kdk'] ?>" class="form-control" id="nilai_kdk" required>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="jumlah_kdk">Jumlah (Rp)</label>
                                    <input type="number" name="jumlah_kdk" value="<?= $data['jumlah_kdk'] ?>" class="form-control" id="jumlah_kdk" required>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="form-group">
                                <label for="jumlah_tpp_sblm_kpal">Jumlah Sebelum Pengurangan Aspek Lainnya</label>
                                <input type="number" name="jumlah_tpp_sblm_kpal" value="<?= $data['jumlah_tpp_sblm_kpal'] ?>" class="form-control" id="jumlah_tpp_sblm_kpal" required>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-md-12">
                                  <h5><b>Komponen Pengurangan Aspek</b></h5>
                                  <h6><b>Laporan Gratifikasi</b></h6>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="persen_lap_gratifikasi">Persen</label>
                                        <input type="number" name="persen_lap_gratifikasi" value="<?= $data['persen_lap_gratifikasi'] ?>" class="form-control" id="persen_lap_gratifikasi" required step="1" max="100">
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="nilai_lap_gratifikasi">Nilai</label>
                                        <input type="number" name="nilai_lap_gratifikasi" value="<?= $data['nilai_lap_gratifikasi'] ?>" class="form-control" id="nilai_lap_gratifikasi" required>
                                      </div>
                                    </div>
                                  </div>
                                  <h6><b>Ketepatan Waktu Pengembalian</b></h6>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="persen_pengembalian_bmd">Persen</label>
                                        <input type="number" name="persen_pengembalian_bmd" value="<?= $data['persen_pengembalian_bmd'] ?>" class="form-control" id="persen_pengembalian_bmd" required step="1" max="100">
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="nilai_pengembalian_bmd">Nilai</label>
                                        <input type="number" name="nilai_pengembalian_bmd" value="<?= $data['nilai_pengembalian_bmd'] ?>" class="form-control" id="nilai_pengembalian_bmd" required>
                                      </div>
                                    </div>
                                  </div>
                                  <h6><b>TPTGR</b></h6>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="persen_tptgr">Persen</label>
                                        <input type="number" name="persen_tptgr" value="<?= $data['persen_tptgr'] ?>" class="form-control" id="persen_tptgr" required step="1" max="100">
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="nilai_tptgr">Nilai</label>
                                        <input type="number" name="nilai_tptgr" value="<?= $data['nilai_tptgr'] ?>" class="form-control" id="nilai_tptgr" required>
                                      </div>
                                    </div>
                                  </div>
                                  <h6><b>JHKPN</b></h6>
                                  <div class="row">
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="persen_jhkpn">Persen</label>
                                        <input type="number" name="persen_jhkpn" value="<?= $data['persen_jhkpn'] ?>" class="form-control" id="persen_jhkpn" required step="1" max="100">
                                      </div>
                                    </div>
                                    <div class="col-lg-6">
                                      <div class="form-group">
                                        <label for="nilai_jhkpn">Nilai</label>
                                        <input type="number" name="nilai_jhkpn" value="<?= $data['nilai_jhkpn'] ?>" class="form-control" id="nilai_jhkpn" required>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <hr>
                              <div class="form-group">
                                <label for="jumlah_tpp_sblm_pajak">Jumlah TPP Sebelum Pajak PPh</label>
                                <input type="number" name="jumlah_tpp_sblm_pajak" value="<?= $data['jumlah_tpp_sblm_pajak'] ?>" class="form-control" id="jumlah_tpp_sblm_pajak" required>
                              </div>
                              <div class="form-group">
                                <label for="pasal_21">Pasal 21</label>
                                <input type="number" name="pasal_21" value="<?= $data['pasal_21'] ?>" class="form-control" id="pasal_21" required>
                              </div>
                              <div class="form-group">
                                <label for="jumlah_tpp_setelah_pajak">Jumlah TPP Setelah Pajak (Rp)</label>
                                <input type="number" name="jumlah_tpp_setelah_pajak" value="<?= $data['jumlah_tpp_setelah_pajak'] ?>" class="form-control" id="jumlah_tpp_setelah_pajak" required>
                              </div>
                            </div>
                            <div class="modal-footer justify-content-center border-top-0">
                              <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Batal</button>
                              <button type="submit" name="edit" class="btn btn-warning btn-sm">Ubah</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus<?= $data['id_tpp'] ?>">
                      <i class="bi bi-trash3"></i> Hapus
                    </button>
                    <div class="modal fade" id="hapus<?= $data['id_tpp'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header border-bottom-0 shadow">
                            <h5 class="modal-title" id="exampleModalLabel">Hapus <?= $data['nama'] ?></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form action="" method="post">
                            <input type="hidden" name="id_tpp" value="<?= $data['id_tpp'] ?>">
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
            <h5 class="modal-title" id="tambahLabel">Tambah Pegawai</h5>
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
                    <option value="<?= $data_select_pegawai['id_pegawai'] ?>"><?= $data_select_pegawai['nama'] ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="kelas_jabatan">Kelas Jabatan</label>
                <input type="number" name="kelas_jabatan" class="form-control" id="kelas_jabatan" required>
              </div>
              <div class="form-group">
                <label for="besaran_tpp_kpk">Besaran TPP</label>
                <input type="number" name="besaran_tpp_kpk" class="form-control" id="besaran_tpp_kpk" required>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <h5><b>Komponen Produktifitas Kerja</b></h5>
                  <div class="form-group">
                    <label for="besaran_kpk">Besaran (Rp)</label>
                    <input type="number" name="besaran_kpk" class="form-control" id="besaran_kpk" required>
                  </div>
                  <h6><b>Pengurangan (Rp)</b></h6>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="persen_kpk">Persen</label>
                        <input type="number" name="persen_kpk" class="form-control" id="persen_kpk" required step="1" max="100">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="nilai_kpk">Nilai</label>
                        <input type="number" name="nilai_kpk" class="form-control" id="nilai_kpk" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="jumlah_kpk">Jumlah (Rp)</label>
                    <input type="number" name="jumlah_kpk" class="form-control" id="jumlah_kpk" required>
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <h5><b>Komponen Disiplin Kerja</b></h5>
                  <div class="form-group">
                    <label for="besaran_kdk">Besaran (Rp)</label>
                    <input type="number" name="besaran_kdk" class="form-control" id="besaran_kdk" required>
                  </div>
                  <h6><b>Pengurangan (Rp)</b></h6>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="persen_kdk">Persen</label>
                        <input type="number" name="persen_kdk" class="form-control" id="persen_kdk" required step="1" max="100">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="nilai_kdk">Nilai</label>
                        <input type="number" name="nilai_kdk" class="form-control" id="nilai_kdk" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="jumlah_kdk">Jumlah (Rp)</label>
                    <input type="number" name="jumlah_kdk" class="form-control" id="jumlah_kdk" required>
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label for="jumlah_tpp_sblm_kpal">Jumlah Sebelum Pengurangan Aspek Lainnya</label>
                <input type="number" name="jumlah_tpp_sblm_kpal" class="form-control" id="jumlah_tpp_sblm_kpal" required>
              </div>
              <hr>
              <div class="row">
                <div class="col-md-12">
                  <h5><b>Komponen Pengurangan Aspek</b></h5>
                  <h6><b>Laporan Gratifikasi</b></h6>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="persen_lap_gratifikasi">Persen</label>
                        <input type="number" name="persen_lap_gratifikasi" class="form-control" id="persen_lap_gratifikasi" required step="1" max="100">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="nilai_lap_gratifikasi">Nilai</label>
                        <input type="number" name="nilai_lap_gratifikasi" class="form-control" id="nilai_lap_gratifikasi" required>
                      </div>
                    </div>
                  </div>
                  <h6><b>Ketepatan Waktu Pengembalian</b></h6>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="persen_pengembalian_bmd">Persen</label>
                        <input type="number" name="persen_pengembalian_bmd" class="form-control" id="persen_pengembalian_bmd" required step="1" max="100">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="nilai_pengembalian_bmd">Nilai</label>
                        <input type="number" name="nilai_pengembalian_bmd" class="form-control" id="nilai_pengembalian_bmd" required>
                      </div>
                    </div>
                  </div>
                  <h6><b>TPTGR</b></h6>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="persen_tptgr">Persen</label>
                        <input type="number" name="persen_tptgr" class="form-control" id="persen_tptgr" required step="1" max="100">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="nilai_tptgr">Nilai</label>
                        <input type="number" name="nilai_tptgr" class="form-control" id="nilai_tptgr" required>
                      </div>
                    </div>
                  </div>
                  <h6><b>JHKPN</b></h6>
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="persen_jhkpn">Persen</label>
                        <input type="number" name="persen_jhkpn" class="form-control" id="persen_jhkpn" required step="1" max="100">
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group">
                        <label for="nilai_jhkpn">Nilai</label>
                        <input type="number" name="nilai_jhkpn" class="form-control" id="nilai_jhkpn" required>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="form-group">
                <label for="jumlah_tpp_sblm_pajak">Jumlah TPP Sebelum Pajak PPh</label>
                <input type="number" name="jumlah_tpp_sblm_pajak" class="form-control" id="jumlah_tpp_sblm_pajak" required>
              </div>
              <div class="form-group">
                <label for="pasal_21">Pasal 21</label>
                <input type="number" name="pasal_21" class="form-control" id="pasal_21" required>
              </div>
              <div class="form-group">
                <label for="jumlah_tpp_setelah_pajak">Jumlah TPP Setelah Pajak (Rp)</label>
                <input type="number" name="jumlah_tpp_setelah_pajak" class="form-control" id="jumlah_tpp_setelah_pajak" required>
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

<?php require_once("../templates/views_bottom.php") ?>