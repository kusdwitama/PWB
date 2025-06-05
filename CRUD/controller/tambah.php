<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Mahasiswa</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <div class="container">
    <h1>Tambah Mahasiswa</h1>

    <form action="tambah.php" method="POST">
      <label for="nim">NIM</label>
      <input type="text" id="nim" name="nim" required placeholder="Contoh: G.211.24.0001">

      <label for="nama">Nama</label>
      <input type="text" id="nama" name="nama" required>

      <label for="prodi">Program Studi</label>
      <select id="prodi" name="prodi" required>
        <option value="">-- Pilih Program Studi --</option>
        <option value="Teknik Informatika">Teknik Informatika</option>
        <option value="Sistem Informasi">Sistem Informasi</option>
        <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
        <option value="Pariwisata">Pariwisata</option>
      </select>

      <label for="semester">Semester</label>
      <select id="semester" name="semester" required>
        <option value="" disabled selected>-- Pilih Semester --</option>
        <?php
          for ($i = 1; $i <= 14; $i++) {
            echo "<option value=\"$i\">$i</option>";
          }
        ?>
      </select>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" required>
      <div style="display: flex; gap: 10px;">
        <button type="submit" name="submit" class="button">Tambah Data</button>
        <a href="../index.php" class="button btn-danger">Cancel</a>
      </div>
    </form>

    <?php
    include '../koneksi.php';

    if (isset($_POST['submit'])) {
      $nim = $_POST['nim'];
      $nama = $_POST['nama'];
      $prodi = $_POST['prodi'];
      $semester = $_POST['semester'];
      $email = $_POST['email'];

      if (tambahMahasiswa($nim, $nama, $prodi, $semester, $email)) {
        echo "<p>Data berhasil ditambahkan.</p>";
        header("Location: ../index.php"); // Redirect ke halaman index
        exit;
      } else {
        echo "<p>Gagal menambahkan data.</p>";
      }
    }
    ?>
  </div>

</body>
</html>
