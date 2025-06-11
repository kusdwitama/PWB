<?php
session_start();
// Memeriksa apakah pengguna sudah login, jika belum arahkan ke halaman login.php
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Mengimpor file koneksi database
include 'koneksi.php'; 

// --- Logika Pagination ---
$data_per_halaman = 5; // Menentukan berapa data yang akan ditampilkan per halaman

// Mendapatkan nomor halaman saat ini dari parameter URL 'halaman'. Defaultnya adalah 1.
$halaman_saat_ini = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;

// Memastikan nomor halaman tidak kurang dari 1
if ($halaman_saat_ini <= 0) {
    $halaman_saat_ini = 1; 
}

// Menghitung total data mahasiswa di database
$query_total = "SELECT COUNT(*) AS total FROM mahasiswa";
$result_total = mysqli_query($conn, $query_total);

// Menangani kasus jika query total gagal
if (!$result_total) {
    die("Error mengambil total data: " . mysqli_error($conn));
}

$row_total = mysqli_fetch_assoc($result_total);
$total_data = $row_total['total'];

// Menghitung total halaman yang diperlukan
$total_halaman = ceil($total_data / $data_per_halaman);

// Menghitung offset (jumlah baris yang akan dilewati sebelum mengambil data)
$offset = ($halaman_saat_ini - 1) * $data_per_halaman;

// Mengambil data mahasiswa dari database dengan LIMIT dan OFFSET untuk pagination
$sql = "SELECT * FROM mahasiswa LIMIT $data_per_halaman OFFSET $offset";
$result = mysqli_query($conn, $sql);

// Memeriksa jika query data gagal
if (!$result) {
    die("Error mengambil data mahasiswa: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container">
        <h1>Data Mahasiswa</h1>

        <div class="toolbar">
            <a href="controller/tambah.php" class="button">Tambah</a>
            <button class="button" onclick="showPrintOptions()">Print</button>
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
                // Memeriksa apakah ada hasil dari query
                if (mysqli_num_rows($result) > 0) {
                    // Mengulang setiap baris data dan menampilkannya dalam tabel
                    while ($row = mysqli_fetch_assoc($result)) {
                        // Menggunakan htmlspecialchars untuk mencegah XSS
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
                    // Jika tidak ada data ditemukan
                    echo "<tr><td colspan='6'>Data tidak ditemukan.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="pagination">
            <?php if ($total_halaman > 1): // Tampilkan pagination jika ada lebih dari 1 halaman ?>
                <?php if ($halaman_saat_ini > 1): // Tombol Previous ?>
                    <a href="?halaman=<?php echo $halaman_saat_ini - 1; ?>">Previous</a>
                <?php endif; ?>

                <?php 
                // Tampilkan link untuk setiap halaman
                for ($i = 1; $i <= $total_halaman; $i++): 
                ?>
                    <a href="?halaman=<?php echo $i; ?>" class="<?php echo ($i == $halaman_saat_ini) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($halaman_saat_ini < $total_halaman): // Tombol Next ?>
                    <a href="?halaman=<?php echo $halaman_saat_ini + 1; ?>">Next</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php 
        // Menutup koneksi database setelah semua operasi selesai
        mysqli_close($conn); 
        ?>

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

        <div id="printModal" class="modal">
            <div class="modal-content" style="width: 300px;">
                <span class="close" onclick="closePrintOptions()">&times;</span>
                <h2>Pilih Format Cetak</h2>
                <p><a href="cetak_pdf.php" class="button" style="width: 100%;" target="_blank">Download PDF</a></p>
                <p><a href="cetak_excel.php" class="button" style="width: 100%;" target="_blank">Download Excel</a></p>
            </div>
        </div>

        <script>
            // Fungsi untuk menampilkan modal detail mahasiswa
            function showModal(nim, nama, prodi, semester, email) {
                document.getElementById('modal-nim').innerText = nim;
                document.getElementById('modal-nama').innerText = nama;
                document.getElementById('modal-prodi').innerText = prodi;
                document.getElementById('modal-semester').innerText = semester;
                document.getElementById('modal-email').innerText = email;
                document.getElementById('myModal').style.display = 'block';
            }

            // Fungsi untuk menutup modal detail mahasiswa
            function closeModal() {
                document.getElementById('myModal').style.display = 'none';
            }

            // Fungsi untuk menampilkan modal pilihan print
            function showPrintOptions() {
                document.getElementById('printModal').style.display = 'block';
            }

            // Fungsi untuk menutup modal pilihan print
            function closePrintOptions() {
                document.getElementById('printModal').style.display = 'none';
            }

            // Menutup modal jika area di luar modal diklik
            window.onclick = function(event) {
                const modal = document.getElementById('myModal');
                const printModal = document.getElementById('printModal');

                if (event.target == modal) {
                    modal.style.display = 'none';
                }
                if (event.target == printModal) {
                    printModal.style.display = 'none';
                }
            }
        </script>
    </div>
</body>
</html>