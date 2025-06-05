<?php
include '../koneksi.php';

if (isset($_GET['nim'])) {
  $nim = $_GET['nim'];

  if (hapusMahasiswa($nim)) {
    echo "<p>Data berhasil dihapus.</p>";
  } else {
    echo "<p>Gagal menghapus data.</p>";
  }

  header("Location: ../index.php"); // Redirect ke halaman index
  exit;
} else {
  echo "<p>Data tidak ditemukan.</p>";
}
?>
