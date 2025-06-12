<?php
session_start();
include 'koneksi.php';
if (isset($_POST['register'])) {
    $u = mysqli_real_escape_string($conn, $_POST['username']);
    $p = mysqli_real_escape_string($conn, $_POST['password']);
    $p2 = mysqli_real_escape_string($conn, $_POST['password2']);
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users WHERE username='$u'")) > 0) {
        $error = "Username sudah digunakan!";
    } elseif ($p !== $p2) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        $hp = password_hash($p, PASSWORD_DEFAULT);
        if (mysqli_query($conn, "INSERT INTO users (username,password) VALUES ('$u','$hp')")) {
            $_SESSION['login']=true;
            header("Location:index.php"); exit;
        } else $error="Gagal mendaftar. Coba lagi.";
    }
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Register</title><script src="https://cdn.tailwindcss.com"></script></head><body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Register</h1>
    <?php if (isset($error)): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"><?php echo $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <label class="block mb-1 text-gray-700">Username</label><input type="text" name="username" required class="w-full mb-4 px-3 py-2 border rounded">
      <label class="block mb-1 text-gray-700">Password</label><input type="password" name="password" required class="w-full mb-4 px-3 py-2 border rounded">
      <label class="block mb-1 text-gray-700">Konfirmasi Password</label><input type="password" name="password2" required class="w-full mb-6 px-3 py-2 border rounded">
      <button type="submit" name="register" class="w-full bg-gray-800 text-white py-2 rounded hover:bg-gray-700 transition">Daftar</button>
    </form>
    <p class="mt-4 text-center text-gray-600">Sudah punya akun? <a href="login.php" class="text-blue-600 hover:underline">Login di sini</a></p>
  </div>
</body></html>
