<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location:login.php");
    exit;
}
include '../../koneksi.php';

if (isset($_POST['submit'])) {
    $n = $_POST['nim'];
    $nm = $_POST['nama'];
    $pr = $_POST['prodi'];
    $sm = $_POST['semester'];
    $em = $_POST['email'];

    $q = "INSERT INTO mahasiswa (nim, nama, prodi, semester, email, created_at) 
          VALUES ('$n', '$nm', '$pr', '$sm', '$em', NOW())";

    if (mysqli_query($conn, $q)) {
        header("Location:../../index.php");
        exit;
    }
    $err = "Gagal menambahkan data.";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">Tambah Mahasiswa</h1>
        <?php if (isset($err)): ?>
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"><?php echo $err ?></div>
        <?php endif; ?>
        <form method="POST">
            <label class="block mb-1 text-gray-700">Program Studi</label>
            <select name="prodi" id="prodi" required class="w-full mb-4 px-3 py-2 border rounded">
                <option value="">-- Pilih Program Studi --</option>
                <option value="Teknik Informatika">Teknik Informatika</option>
                <option value="Sistem Informasi">Sistem Informasi</option>
                <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                <option value="Pariwisata">Pariwisata</option>
            </select>

            <label class="block mb-1 text-gray-700">NIM</label>
            <input type="text" name="nim" id="nim" readonly required class="w-full mb-4 px-3 py-2 border rounded bg-gray-100">

            <label class="block mb-1 text-gray-700">Nama</label>
            <input type="text" name="nama" required class="w-full mb-4 px-3 py-2 border rounded">

            <label class="block mb-1 text-gray-700">Semester</label>
            <select name="semester" required class="w-full mb-4 px-3 py-2 border rounded">
                <option disabled selected>-- Pilih Semester --</option>
                <?php for ($i = 1; $i <= 14; $i++): ?>
                    <option value="<?php echo $i ?>"><?php echo $i ?></option>
                <?php endfor; ?>
            </select>

            <label class="block mb-1 text-gray-700">Email</label>
            <input type="email" name="email" readonly required class="w-full mb-6 px-3 py-2 border rounded bg-gray-100">

            <div class="flex gap-4">
                <button type="submit" name="submit" class="flex-1 bg-gray-800 text-white py-2 rounded hover:bg-gray-700 transition">Tambah Data</button>
                <a href="../../index.php" class="flex-1 bg-red-600 text-white py-2 rounded hover:bg-red-700 text-center">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('prodi').addEventListener('change', function () {
            const prodi = this.value;
            if (!prodi) return;

            fetch('get_nim.php?prodi=' + encodeURIComponent(prodi))
                .then(res => res.text())
                .then(nim => {
                    document.getElementById('nim').value = nim;

                    // Email otomatis: nim tanpa titik dan huruf kecil
                    const email = nim.replace(/\./g, '').toLowerCase() + '@student.usm.ac.id';
                    document.querySelector('input[name="email"]').value = email;
                })
                .catch(err => {
                    console.error(err);
                    document.getElementById('nim').value = 'Gagal generate NIM';
                });
        });
    </script>
</body>
</html>
