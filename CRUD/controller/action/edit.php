<?php
session_start(); if (!isset($_SESSION['login'])) { header("Location:login.php"); exit; }
include '../../koneksi.php';
if (isset($_GET['nim'])) {
    $n=$_GET['nim'];
    $r=mysqli_query($conn,"SELECT * FROM mahasiswa WHERE nim='$n'");
    $m=mysqli_num_rows($r)==1?mysqli_fetch_assoc($r):null;
    if (!$m) { echo "Data tidak ditemukan."; exit; }
}
if (isset($_POST['submit'])) {
    $n=$_POST['nim']; $nm=$_POST['nama']; $pr=$_POST['prodi']; $sm=$_POST['semester']; $em=$_POST['email'];
    $q="UPDATE mahasiswa SET nama='$nm',prodi='$pr',semester='$sm',email='$em' WHERE nim='$n'";
    mysqli_query($conn,$q);
    header("Location:../../index.php"); exit;
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Edit Mahasiswa</title><script src="https://cdn.tailwindcss.com"></script></head><body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Edit Mahasiswa</h1>
    <form method="POST">
      <label class="block mb-1 text-gray-700">NIM</label><input type="text" name="nim" value="<?php echo htmlspecialchars($m['nim']) ?>" readonly class="w-full mb-4 px-3 py-2 border rounded bg-gray-100">
      <label class="block mb-1 text-gray-700">Nama</label><input type="text" name="nama" value="<?php echo htmlspecialchars($m['nama']) ?>" required class="w-full mb-4 px-3 py-2 border rounded">
      <label class="block mb-1 text-gray-700">Program Studi</label><select name="prodi" required class="w-full mb-4 px-3 py-2 border rounded">
        <option value="">-- Pilih Program Studi --</option>
        <?php foreach(['Teknik Informatika','Sistem Informasi','Ilmu Komunikasi','Pariwisata'] as $prg): ?>
          <option <?php echo $m['prodi']==$prg?'selected':'' ?>><?php echo $prg ?></option>
        <?php endforeach; ?>
      </select>
      <label class="block mb-1 text-gray-700">Semester</label><select name="semester" required class="w-full mb-4 px-3 py-2 border rounded">
        <?php for($i=1;$i<=14;$i++): ?>
          <option value="<?php echo $i ?>" <?php echo $m['semester']==$i?'selected':'' ?>><?php echo $i ?></option>
        <?php endfor; ?>
      </select>
      <label class="block mb-1 text-gray-700">Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($m['email']) ?>" required class="w-full mb-6 px-3 py-2 border rounded">
      <div class="flex gap-4">
        <button type="submit" name="submit" class="flex-1 bg-gray-800 text-white py-2 rounded hover:bg-gray-700 transition">Update</button>
        <a href="../../index.php" class="flex-1 bg-red-600 text-white py-2 rounded hover:bg-red-700 text-center">Cancel</a>
      </div>
    </form>
  </div>
</body></html>
          