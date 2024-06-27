<?php require_once("../controller/cetak-gaji.php");

require_once __DIR__ . '/../assets/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

if (!isset($_SESSION["project_penggajian_pegawai"]["rekap_gaji"])) {
  header("Location: cetak-gaji");
  exit();
} else {
  $id_rekap_gaji = valid($conn, $_SESSION["project_penggajian_pegawai"]["rekap_gaji"]["cetak"]);
  $query = "SELECT rekap_gaji.*, pegawai.nama, pegawai.nip, pangkat_pegawai.nama_pangkat, jabatan_pegawai.nama_jabatan 
  FROM rekap_gaji 
  JOIN pegawai ON rekap_gaji.id_pegawai = pegawai.id_pegawai
  JOIN pangkat_pegawai ON pegawai.id_pangkat = pangkat_pegawai.id_pangkat
  JOIN jabatan_pegawai ON pegawai.id_jabatan = jabatan_pegawai.id_jabatan
  WHERE rekap_gaji.id_rekap_gaji = '$id_rekap_gaji'";
  $result = mysqli_query($conn, $query);
  $data = mysqli_fetch_assoc($result);
  $mpdf = new \Mpdf\Mpdf();
  $html = '<p style="text-align: center; text-decoration: underline;"><b>SURAT KETERANGAN PERINCIAN GAJI<b></p>';
  $html .= '<p style="text-align: center;"><b>UNTUK BULAN ' . strtoupper(date('M Y')) . '<b></p>';
  $html .= '<table style="border-collapse: collapse; width: 100%; margin: auto;">
  <tbody>
    <tr>
      <td style="width: 150px; ">Nama</td>
      <td style="width: 10px; ">:</td>
      <td>' . $data['nama'] . '</td>
    </tr>
    <tr>
      <td>NIP</td>
      <td>:</td>
      <td>' . $data['nip'] . '</td>
    </tr>
    <tr>
      <td>Pangkat / Golongan</td>
      <td>:</td>
      <td>' . $data['nama_pangkat'] . '</td>
    </tr>
    <tr>
      <td>Jabatan</td>
      <td>:</td>
      <td>' . $data['nama_jabatan'] . '</td>
    </tr>
  </tbody>
  </table>';
  $html .= '<p style="text-align: left;margin-top: 50px;"><b>PERINCIAN : <b></p>';
  $html .= '<table style="border-collapse: collapse; width: 100%; margin: auto;">
  <tbody>
  <tr>
    <th style="width: 250px; text-align: left;" colspan="3">Total Kehadiran</th>
    <td style="width: 10px; ">:</td>
    <td>Rp.' . $data['total_absensi'] . ' hari</td>
  </tr>
  <tr>
    <th style="width: 250px; text-align: left;" colspan="3">Total Hari Kerja</th>
    <td style="width: 10px; ">:</td>
    <td>Rp.' . $data['total_hari_kerja'] . ' hari</td>
  </tr>
  <tr>
    <th style="width: 250px; text-align: left;" colspan="3">Penghasilan :</th>
  </tr>
  <tr>
    <td style="width: 250px; ">Gaji Pokok</td>
    <td style="width: 10px; ">:</td>
    <td>Rp.' . number_format($data['gaji']) . '</td>
  </tr>';
  $id_rekap_gaji = $data['id_rekap_gaji'];
  $rekap_gaji_tunj = "SELECT * FROM rekap_gaji_tunj JOIN tunjangan_pegawai ON rekap_gaji_tunj.id_tunjangan=tunjangan_pegawai.id_tunjangan WHERE rekap_gaji_tunj.id_rekap_gaji='$id_rekap_gaji'";
  $views_rekap_gaji_tunj = mysqli_query($conn, $rekap_gaji_tunj);
  $total_tunjangan = 0;
  if (mysqli_num_rows($views_rekap_gaji_tunj) > 0) {
    while ($data_rgt = mysqli_fetch_assoc($views_rekap_gaji_tunj)) {
      $html .= '<tr>
    <td>' . $data_rgt['nama_tunjangan'] . '</td>
    <td>:</td>
    <td>Rp.' . number_format($data_rgt['upah_tunjangan']) . '</td>
  </tr>';
    }
  }
  $html .= '<tr>
      <th style="width: 250px; ">Jumlah</th>
      <th style="width: 10px; ">:</th>
      <th style="text-align: left;">Rp.' . number_format($data['jumlah_bruto']) . '</th>
    </tr></tbody>
  </table>';
  $html .= '<table style="border-collapse: collapse; width: 100%; margin: auto;">
  <tbody>
  <tr>
    <th style="width: 250px;text-align: left;" colspan="3">Potongan :</th>
  </tr>';
  $rekap_gaji_potongan = "SELECT * FROM rekap_gaji_potongan JOIN potongan_pegawai ON rekap_gaji_potongan.id_potongan=potongan_pegawai.id_potongan WHERE rekap_gaji_potongan.id_rekap_gaji='$id_rekap_gaji'";
  $views_rekap_gaji_potongan = mysqli_query($conn, $rekap_gaji_potongan);
  $total_potongan = 0;
  if (mysqli_num_rows($views_rekap_gaji_potongan) > 0) {
    while ($data_rgp = mysqli_fetch_assoc($views_rekap_gaji_potongan)) {
      $html .= '<tr>
    <td>' . $data_rgp['nama_potongan'] . '</td>
    <td>:</td>
    <td>Rp.' . number_format($data_rgp['upah_potongan']) . '</td>
  </tr>';
    }
  }
  $html .= '<tr>
      <th style="width: 250px; ">Jumlah</th>
      <th style="width: 10px; ">:</th>
      <th style="text-align: left;">Rp.' . number_format($data['jumlah_potongan']) . '</th>
    </tr>
    <tr>
      <th style="width: 250px; ">Jumlah yang Dibayarkan</th>
      <th style="width: 10px; ">:</th>
      <th style="text-align: left;">Rp.' . number_format($data['jumlah_dibayarkan']) . '</th>
    </tr></tbody>
  </table>';
  $html .= '<div style="width: 300px; margin-top: 20px; float: right; text-align: right;">
    <p style="text-align: center;">Kec. Koting, ' . date("d M Y") . '</p>
    <p style="text-align: center; padding-top: -15px;">Sekretariat</p>
    <h4 style="padding-top: 50px; text-decoration: underline; text-align: center;"></h4>
  </div>';
  $mpdf->WriteHTML($html);

  $mpdf->Output();
  // $mpdf->OutputHttpDownload('Data_Izin.pdf');
  // header("Location: surat-izin");
  // exit;
}
