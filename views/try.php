<?php
// Fungsi untuk menghitung pendapatan bersih
function hitungPendapatanBersih($gajiPokok, $tunjanganArray, $potonganArray, $totalKehadiran, $hariKerja)
{
  // Menghitung total tunjangan
  $totalTunjangan = array_sum($tunjanganArray);

  // Menghitung total potongan
  $totalPotongan = array_sum($potonganArray);

  // Menghitung persentase kehadiran
  $absensi = ($totalKehadiran / $hariKerja) * 100;

  // Menghitung gaji pokok berdasarkan persentase kehadiran
  $gajiPokokAbsensi = $gajiPokok * ($absensi / 100);

  // Menghitung pendapatan bersih
  $pendapatanBersih = ($gajiPokokAbsensi + $totalTunjangan) - $totalPotongan;

  return $pendapatanBersih;
}

// Fungsi untuk menghitung jumlah hari kerja dalam bulan saat ini
function hitungHariKerja($bulan, $tahun)
{
  $totalHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
  $hariKerja = 0;

  for ($i = 1; $i <= $totalHari; $i++) {
    $tanggal = sprintf('%04d-%02d-%02d', $tahun, $bulan, $i);
    $hariDalamMinggu = date('N', strtotime($tanggal));

    // Hitung hanya hari kerja (Senin-Jumat)
    if ($hariDalamMinggu < 6) {
      $hariKerja++;
    }
  }

  return $hariKerja;
}

// Input data
$gajiPokok = 5000000; // Gaji Pokok
$tunjanganArray = [500000, 300000, 200000]; // Array Tunjangan
$potonganArray = [200000, 150000, 150000];  // Array Potongan
$totalKehadiran = 20; // Total kehadiran dalam sebulan

// Dapatkan bulan dan tahun saat ini
$bulanSaatIni = date('n');
$tahunSaatIni = date('Y');

// Hitung jumlah hari kerja dalam bulan saat ini
$hariKerja = hitungHariKerja($bulanSaatIni, $tahunSaatIni);

// Hitung pendapatan bersih
$pendapatanBersih = hitungPendapatanBersih($gajiPokok, $tunjanganArray, $potonganArray, $totalKehadiran, $hariKerja);

// Output hasil
echo "Pendapatan Bersih: Rp " . number_format($pendapatanBersih, 0, ',', '.') . "\n";
echo "Persentase Kehadiran: " . number_format(($totalKehadiran / $hariKerja) * 100, 2) . "%\n";
echo "Jumlah Hari Kerja: " . $hariKerja . "\n";
