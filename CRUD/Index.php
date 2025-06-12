<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$data_per_halaman = 5;
$halaman_saat_ini = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
if ($halaman_saat_ini <= 0) $halaman_saat_ini = 1;

$query_total = "SELECT COUNT(*) AS total FROM mahasiswa";
$result_total = mysqli_query($conn, $query_total);
if (!$result_total) die("Error: " . mysqli_error($conn));

$row_total = mysqli_fetch_assoc($result_total);
$total_data = $row_total['total'];
$total_halaman = ceil($total_data / $data_per_halaman);
$offset = ($halaman_saat_ini - 1) * $data_per_halaman;

$sql = "SELECT * FROM mahasiswa LIMIT $data_per_halaman OFFSET $offset";
$result = mysqli_query($conn, $sql);
if (!$result) die("Error: " . mysqli_error($conn));
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans">

<div class="max-w-6xl mx-auto p-4">
    <h1 class="text-3xl font-semibold mb-6 text-gray-900">Data Mahasiswa</h1>

    <div class="flex flex-wrap gap-2 items-center justify-between mb-4">
        <a href="controller/tambah.php" class="bg-gray-800 text-white text-sm px-4 py-2 rounded hover:bg-gray-700">Tambah</a>
        <button onclick="showPrintOptions()" class="bg-gray-800 text-white text-sm px-4 py-2 rounded hover:bg-gray-700">Print</button>
        <a href="logout.php" class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded">Logout</a>
    </div>

    <table class="w-full bg-white border border-gray-200 rounded-lg shadow-sm text-sm">
        <thead>
            <tr class="bg-gray-100 text-gray-700">
                <th class="text-left px-4 py-3 border-b border-gray-300">NIM</th>
                <th class="text-left px-4 py-3 border-b border-gray-300">Nama</th>
                <th class="text-left px-4 py-3 border-b border-gray-300">Program Studi</th>
                <th class="text-left px-4 py-3 border-b border-gray-300">Semester</th>
                <th class="text-left px-4 py-3 border-b border-gray-300">Email</th>
                <th class="text-left px-4 py-3 border-b border-gray-300">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): 
                    $nim = htmlspecialchars($row['nim']);
                    $nama = htmlspecialchars($row['nama']);
                    $prodi = htmlspecialchars($row['prodi']);
                    $semester = htmlspecialchars($row['semester']);
                    $email = htmlspecialchars($row['email']);
                ?>
                    <tr class="hover:bg-gray-50 cursor-pointer" onclick="showModal('<?php echo $nim ?>','<?php echo $nama ?>','<?php echo $prodi ?>','<?php echo $semester ?>','<?php echo $email ?>')">
                        <td class="px-4 py-3 border-b border-gray-200"><?php echo $nim ?></td>
                        <td class="px-4 py-3 border-b border-gray-200"><?php echo $nama ?></td>
                        <td class="px-4 py-3 border-b border-gray-200"><?php echo $prodi ?></td>
                        <td class="px-4 py-3 border-b border-gray-200"><?php echo $semester ?></td>
                        <td class="px-4 py-3 border-b border-gray-200"><?php echo $email ?></td>
                        <td class="px-4 py-3 border-b border-gray-200">
                            <a href="controller/edit.php?nim=<?php echo $nim ?>" onclick="event.stopPropagation()" class="text-sm text-white bg-gray-800 px-3 py-1 rounded hover:bg-gray-700">Edit</a>
                            <a href="controller/hapus.php?nim=<?php echo $nim ?>" onclick="event.stopPropagation(); return confirm('Yakin ingin menghapus data ini?')" class="text-sm text-white bg-red-600 px-3 py-1 rounded hover:bg-red-700">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6" class="px-4 py-3 text-center text-gray-500">Data tidak ditemukan.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="flex justify-center items-center mt-6 gap-2">
        <?php if ($halaman_saat_ini > 1): ?>
            <a href="?halaman=<?php echo $halaman_saat_ini - 1 ?>" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200">Previous</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_halaman; $i++): ?>
            <a href="?halaman=<?php echo $i ?>" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200 <?php echo ($i == $halaman_saat_ini) ? 'bg-gray-800 text-white border-gray-800' : ''; ?>"><?php echo $i ?></a>
        <?php endfor; ?>
        <?php if ($halaman_saat_ini < $total_halaman): ?>
            <a href="?halaman=<?php echo $halaman_saat_ini + 1 ?>" class="px-3 py-1 border border-gray-300 rounded hover:bg-gray-200">Next</a>
        <?php endif; ?>
    </div>

    <?php mysqli_close($conn); ?>

    <!-- Modal Detail -->
    <div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
            <span class="float-right text-xl font-bold cursor-pointer text-gray-500 hover:text-gray-800" onclick="closeModal()">&times;</span>
            <h2 class="text-xl font-semibold mb-4">Detail Mahasiswa</h2>
            <p><strong>NIM:</strong> <span id="modal-nim"></span></p>
            <p><strong>Nama:</strong> <span id="modal-nama"></span></p>
            <p><strong>Prodi:</strong> <span id="modal-prodi"></span></p>
            <p><strong>Semester:</strong> <span id="modal-semester"></span></p>
            <p><strong>Email:</strong> <span id="modal-email"></span></p>
        </div>
    </div>

    <!-- Modal Print -->
    <div id="printModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-[300px]">
            <span class="float-right text-xl font-bold cursor-pointer text-gray-500 hover:text-gray-800" onclick="closePrintOptions()">&times;</span>
            <h2 class="text-xl font-semibold mb-4">Pilih Format Cetak</h2>
            <p><a href="cetak_pdf.php" class="block w-full bg-gray-800 text-white text-center py-2 rounded hover:bg-gray-700 mb-2" target="_blank">Download PDF</a></p>
            <p><a href="cetak_excel.php" class="block w-full bg-gray-800 text-white text-center py-2 rounded hover:bg-gray-700" target="_blank">Download Excel</a></p>
        </div>
    </div>

    <script>
        function showModal(nim, nama, prodi, semester, email) {
            document.getElementById('modal-nim').innerText = nim;
            document.getElementById('modal-nama').innerText = nama;
            document.getElementById('modal-prodi').innerText = prodi;
            document.getElementById('modal-semester').innerText = semester;
            document.getElementById('modal-email').innerText = email;
            document.getElementById('myModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
        }

        function showPrintOptions() {
            document.getElementById('printModal').style.display = 'flex';
        }

        function closePrintOptions() {
            document.getElementById('printModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target.id === "myModal") closeModal();
            if (event.target.id === "printModal") closePrintOptions();
        }
    </script>
</div>

</body>
</html>
