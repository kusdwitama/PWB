<?php
include '../../koneksi.php';

if (!isset($_GET['prodi'])) {
    echo '';
    exit;
}

$prodi = $_GET['prodi'];

// Mapping prodi ke kode
$kode_prodi = [
    'Teknik Informatika' => 'G.211',
    'Sistem Informasi'   => 'G.111',
    'Ilmu Komunikasi'    => 'G.311',
    'Pariwisata'         => 'G.411'
];

// Validasi prodi
if (!isset($kode_prodi[$prodi])) {
    echo '';
    exit;
}

$kode = $kode_prodi[$prodi];

// Tahun akademik (hardcoded)
$tahun = '24';
$prefix = $kode . '.' . $tahun . '.';

// Cari NIM terakhir berdasarkan prefix
$q = mysqli_query($conn, "SELECT nim FROM mahasiswa WHERE nim LIKE '$prefix%' ORDER BY nim DESC LIMIT 1");

if ($d = mysqli_fetch_assoc($q)) {
    $last_nim = $d['nim'];
    $last_num = (int)substr($last_nim, -4); // ambil 4 digit terakhir
    $next_num = str_pad($last_num + 1, 4, '0', STR_PAD_LEFT);
} else {
    $next_num = '0001';
}

echo $prefix . $next_num;
