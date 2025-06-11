<?php
session_start();
session_destroy();

// Jika Anda menggunakan cookie 'remember_me', hapus juga cookienya
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/'); // Atur waktu kadaluarsa di masa lalu
    // Opsional: Hapus juga token dari database jika Anda menyimpannya di sana
    // include 'koneksi.php'; // Pastikan koneksi tersedia
    // $user_id = $_SESSION['user_id_sebelum_destroy']; // Jika user id disimpan di session sebelum destroy
    // mysqli_query($conn, "UPDATE users SET remember_token = NULL WHERE id = '$user_id'");
}

// Mencegah caching (opsional tapi disarankan)
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

header("Location: login.php");
exit;
?>