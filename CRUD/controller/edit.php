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
  <title>Edit Mahasiswa</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>

  <div class="container">
    <h1>Edit Mahasiswa</h1>

    <?php
    include '../koneksi.php';

    if (isset($_GET['nim'])) {
      $nim = $_GET['nim'];
      $mahasiswa = getMahasiswa($nim);

      if ($mahasiswa) {
    ?>

    <form action="edit.php?nim=<?php echo $nim; ?>" method="POST">
      <label for="nim">NIM</label>
      <input type="text" id="nim" name="nim" value="<?php echo htmlspecialchars($mahasiswa['nim']); ?>" readonly>

      <label for="nama">Nama</label>
      <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($mahasiswa['nama']); ?>" required>

      <label for="prodi">Program Studi</label>
        <select id="prodi" name="prodi" required>
          <option value="">-- Pilih Program Studi --</option>
          <option value="Teknik Informatika" <?php if($mahasiswa['prodi'] == "Teknik Informatika") echo "selected"; ?>>Teknik Informatika</option>
          <option value="Sistem Informasi" <?php if($mahasiswa['prodi'] == "Sistem Informasi") echo "selected"; ?>>Sistem Informasi</option>
          <option value="Ilmu Komunikasi" <?php if($mahasiswa['prodi'] == "Ilmu Komunikasi") echo "selected"; ?>>Ilmu Komunikasi</option>
          <option value="Pariwisata" <?php if($mahasiswa['prodi'] == "Pariwisata") echo "selected"; ?>>Pariwisata</option>
        </select>

      <label for="semester">Semester</label>
        <select id="semester" name="semester" required>
          <option value="" disabled>-- Pilih Semester --</option>
          <?php
            for ($i = 1; $i <= 14; $i++) {
              $selected = ($mahasiswa['semester'] == $i) ? 'selected' : '';
              echo "<option value=\"$i\" $selected>$i</option>";
            }
          ?>
        </select>

      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($mahasiswa['email']); ?>" required>

      <div style="display: flex; gap: 10px;">
        <button type="submit" name="submit" class="button">Update</button>
        <a href="../index.php" class="button btn-danger">Cancel</a>
      </div>
    </form>

    <?php
      } else {
        echo "<p>Data tidak ditemukan.</p>";
      }
    }

    if (isset($_POST['submit'])) {
      $nim = $_POST['nim'];
      $nama = $_POST['nama'];
      $prodi = $_POST['prodi'];
      $semester = $_POST['semester'];
      $email = $_POST['email'];

      if (updateMahasiswa($nim, $nama, $prodi, $semester, $email)) {
        echo "<p>Data berhasil diupdate.</p>";
        header("Location: ../index.php"); // Redirect ke halaman index
        exit;
      } else {
        echo "<p>Gagal mengupdate data.</p>";
      }
    }
    ?>

  </div>

</body>
</html>
