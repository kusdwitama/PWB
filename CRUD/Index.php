<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

// Pagination setup
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Filter setup
$where = [];
if (!empty($_GET['nim_prefix'])) {
    $nim_prefix = mysqli_real_escape_string($conn, $_GET['nim_prefix']);
    $where[] = "nim LIKE '$nim_prefix%'";
}
if (!empty($_GET['prodi'])) {
    $prodi = mysqli_real_escape_string($conn, $_GET['prodi']);
    $where[] = "prodi = '$prodi'";
}
if (!empty($_GET['semester'])) {
    $semester = (int)$_GET['semester'];
    $where[] = "semester = $semester";
}
$whereSql = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Hitung total data untuk pagination
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM mahasiswa $whereSql");
$totalRow = mysqli_fetch_assoc($totalQuery)['total'];
$totalPages = ceil($totalRow / $limit);

// Ambil data
$data = mysqli_query($conn, "SELECT * FROM mahasiswa $whereSql LIMIT $offset, $limit");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Data Mahasiswa</h1>
            <div class="space-x-2">
                <a href="controller/action/tambah.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Tambah</a>
                <button onclick="showPrintOptions()" class="bg-gray-800 text-white text-sm px-4 py-2 rounded hover:bg-gray-700">Print</button>
                <a href="controller/logout.php" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Logout</a>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" class="bg-white p-4 rounded shadow mb-6 flex flex-wrap gap-4">
            <div>
                <label class="block text-sm text-gray-700 mb-1">NIM Awalan</label>
                <input type="text" name="nim_prefix" value="<?php echo @htmlspecialchars($_GET['nim_prefix']) ?>" placeholder="Contoh: G.311" class="border px-2 py-1 rounded">
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Program Studi</label>
                <select name="prodi" class="border px-2 py-1 rounded">
                    <option value="">-- Semua --</option>
                    <option <?php if (@$_GET['prodi'] == 'Teknik Informatika') echo 'selected'; ?>>Teknik Informatika</option>
                    <option <?php if (@$_GET['prodi'] == 'Sistem Informasi') echo 'selected'; ?>>Sistem Informasi</option>
                    <option <?php if (@$_GET['prodi'] == 'Ilmu Komunikasi') echo 'selected'; ?>>Ilmu Komunikasi</option>
                    <option <?php if (@$_GET['prodi'] == 'Pariwisata') echo 'selected'; ?>>Pariwisata</option>
                </select>
            </div>
            <div>
                <label class="block text-sm text-gray-700 mb-1">Semester</label>
                <select name="semester" class="border px-2 py-1 rounded">
                    <option value="">-- Semua --</option>
                    <?php for ($i = 1; $i <= 14; $i++): ?>
                        <option value="<?= $i ?>" <?php if (@$_GET['semester'] == $i) echo 'selected'; ?>><?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Terapkan Filter</button>
            </div>
        </form>

        <!-- Table -->
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="w-full table-auto text-left">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-3">NIM</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Program Studi</th>
                        <th class="p-3">Semester</th>
                        <th class="p-3">Email</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($data)): ?>
                        <tr class="border-t hover:bg-gray-50 cursor-pointer" onclick="showModal('<?php echo $row['nim'] ?>', '<?php echo addslashes($row['nama']) ?>', '<?php echo addslashes($row['prodi']) ?>', '<?php echo $row['semester'] ?>', '<?php echo addslashes($row['email']) ?>')">
                            <td class="p-3"><?php echo $row['nim']; ?></td>
                            <td class="p-3"><?php echo $row['nama']; ?></td>
                            <td class="p-3"><?php echo $row['prodi']; ?></td>
                            <td class="p-3"><?php echo $row['semester']; ?></td>
                            <td class="p-3"><?php echo $row['email']; ?></td>
                            <td class="p-3 flex gap-2" onclick="event.stopPropagation()">
                                <a href="edit.php?nim=<?php echo $row['nim']; ?>" class="bg-gray-800 text-white px-3 py-1 rounded hover:bg-gray-700">Edit</a>
                                <a href="hapus.php?nim=<?php echo $row['nim']; ?>" onclick="return confirm('Yakin hapus data ini?')" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6 space-x-1">
            <?php $params = $_GET; ?>
            <?php if ($page > 1): $params['page'] = $page - 1; ?>
                <a href="?<?php echo http_build_query($params); ?>" class="px-3 py-1 border rounded bg-white hover:bg-gray-200">Prev</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): $params['page'] = $i; ?>
                <a href="?<?php echo http_build_query($params); ?>" class="px-3 py-1 border rounded <?php echo ($i == $page) ? 'bg-gray-800 text-white' : 'bg-white hover:bg-gray-200'; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($page < $totalPages): $params['page'] = $page + 1; ?>
                <a href="?<?php echo http_build_query($params); ?>" class="px-3 py-1 border rounded bg-white hover:bg-gray-200">Next</a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal Detail Mahasiswa -->
    <div id="myModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
            <span class="absolute top-3 right-4 text-xl font-bold cursor-pointer text-gray-500 hover:text-gray-800" onclick="closeModal()">&times;</span>
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
        <div class="bg-white rounded-lg shadow-lg p-6 w-[300px] relative">
            <span class="absolute top-3 right-4 text-xl font-bold cursor-pointer text-gray-500 hover:text-gray-800" onclick="closePrintOptions()">&times;</span>
            <h2 class="text-xl font-semibold mb-4">Pilih Format Cetak</h2>
            <a href="controller/print/cetak_pdf.php" target="_blank" class="block bg-gray-800 text-white text-center py-2 rounded hover:bg-gray-700 mb-2">Download PDF</a>
            <a href="controller/print/cetak_excel.php" target="_blank" class="block bg-gray-800 text-white text-center py-2 rounded hover:bg-gray-700">Download Excel</a>
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
</body>
</html>
