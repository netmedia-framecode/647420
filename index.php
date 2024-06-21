<?php require_once("controller/visitor.php");
$_SESSION["project_penggajian_pegawai"]["name_page"] = "";
require_once("templates/top.php"); ?>

<!-- slideshow content begin -->
<div class="uk-section uk-padding-remove-vertical in-slideshow-gradient">
  <div class="in-slideshow" data-uk-slideshow>
    <ul class="uk-slideshow-items uk-light">
      <li>
        <div class="uk-position-cover">
          <img src="assets/img/62Foto_1.jpg" data-src="assets/img/62Foto_1.jpg" alt="slideshow-image" data-uk-cover width="1920" height="700" style="object-fit: cover;" data-uk-img>
        </div>
        <span></span>
        <div class="uk-container">
          <div class="uk-grid" data-uk-grid>
            <div class="uk-width-3-5@m">
              <div class="uk-overlay">
                <h1>Kecamatan Koting Kabupaten Sikka</h1>
                <p class="uk-text-lead uk-visible@m">Kecamatan Koting merupakan salah satu lembaga pemerintahan yang membantu Kabupaten Sikka dalam menunjang data administrasi pemerintahan.</p>
              </div>
            </div>
          </div>
        </div>
      </li>
    </ul>
    <div class="uk-container uk-light">
      <ul class="uk-slideshow-nav uk-dotnav uk-position-bottom-center"></ul>
    </div>
  </div>
</div>
<!-- slideshow content end -->

<!-- section content begin -->
<div class="uk-section uk-section-muted uk-background-contain uk-background-center in-wave-3" style="background-image: url(img/in-wave-background-1.png);" data-uk-parallax="bgy: -200">
  <div class="uk-container">
    <div class="uk-grid-large uk-flex uk-flex-middle" data-uk-grid>
      <div class="uk-width-1-2@m" style="width: 100%;">
        <h1 class="uk-margin-remove">Daftar <span class="in-highlight">TPP</span></h1>
        <div class="uk-grid-medium uk-text-center uk-margin-medium-top" data-uk-grid>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
          <div class="table-responsive" style="width: 100%;">
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
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- section content end -->

<?php require_once("templates/bottom.php"); ?>