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
  <title>Data Mahasiswa</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="container">
  <h1>Data Mahasiswa</h1>
    <div class="toolbar">
      <a href="controller/tambah.php" class="button">Tambah</a>
      <a href="logout.php" class="button btn-danger logout">Logout</a>
    </div>

    <table>
      <thead>
        <tr>
          <th>NIM</th>
          <th>Nama</th>
          <th>Program Studi</th>
          <th>Semester</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        include 'koneksi.php';

        if (!$conn) {
          echo "<tr><td colspan='6'>Koneksi ke database gagal.</td></tr>";
        } else {
          $sql = "SELECT * FROM mahasiswa";
          $result = mysqli_query($conn, $sql);

          if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              $nim = htmlspecialchars($row['nim']);
              $nama = htmlspecialchars($row['nama']);
              $prodi = htmlspecialchars($row['prodi']);
              $semester = htmlspecialchars($row['semester']);
              $email = htmlspecialchars($row['email']);

              echo "<tr onclick=\"showModal('$nim', '$nama', '$prodi', '$semester', '$email')\">
                      <td>$nim</td>
                      <td>$nama</td>
                      <td>$prodi</td>
                      <td>$semester</td>
                      <td>$email</td>
                      <td class='actions'>
                        <a class='button' href='controller/edit.php?nim=$nim' onclick='event.stopPropagation()'>Edit</a>
                        <a class='button btn-danger' href='controller/hapus.php?nim=$nim' onclick='event.stopPropagation(); return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</a>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='6'>Data tidak ditemukan.</td></tr>";
          }

          mysqli_close($conn);
        }
        ?>
      </tbody>
    </table>  
    <!-- Modal -->
    <div id="myModal" class="modal">
      <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Detail Mahasiswa</h2>
        <p><strong>NIM:</strong> <span id="modal-nim"></span></p>
        <p><strong>Nama:</strong> <span id="modal-nama"></span></p>
        <p><strong>Prodi:</strong> <span id="modal-prodi"></span></p>
        <p><strong>Semester:</strong> <span id="modal-semester"></span></p>
        <p><strong>Email:</strong> <span id="modal-email"></span></p>
      </div>
    </div>

    <script>
      function showModal(nim, nama, prodi, semester, email) {
        document.getElementById('modal-nim').innerText = nim;
        document.getElementById('modal-nama').innerText = nama;
        document.getElementById('modal-prodi').innerText = prodi;
        document.getElementById('modal-semester').innerText = semester;
        document.getElementById('modal-email').innerText = email;
        document.getElementById('myModal').style.display = 'block';
      }

      function closeModal() {
        document.getElementById('myModal').style.display = 'none';
      }

      // Tutup modal jika klik di luar area kontennya
      window.onclick = function(event) {
        let modal = document.getElementById('myModal');
        if (event.target == modal) {
          modal.style.display = 'none';
        }
      }
    </script>
  </div>
</body>
</html> 
