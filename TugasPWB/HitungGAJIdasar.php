<?php

$nama_gue = "Muh Naufal Kusdwitama";
$bagian = "Web Developer";
$gaji = 5000000;
$jml_anak = 10;
$tunjangan_per_anak = 200000;

$total_tunjangan = $jml_anak * $tunjangan_per_anak;
$total_gaji = $gaji + $total_tunjangan;

echo "Nama Pegawai : " . $nama_gue . "<br>";
echo "Bagian : " . $bagian . "<br>";
echo "Gaji Pokok : Rp" . number_format($gaji, 0, ',', '.') . "<br>";
echo "Jumlah Anak : " . $jml_anak . "<br>";
echo "Total Tunjangan Anak : Rp" . number_format($total_tunjangan, 0, ",", ".") . "<br>";
echo "Total Gaji : Rp" . number_format($total_gaji, 0, ",", ".") . "<br>";

?>