<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi.php sudah ada dan benar

// --- Cek Cookie "Ingat Saya" ---
// Jika ada cookie 'remember_me' dan session 'login' belum diatur
if (isset($_COOKIE['remember_me']) && !isset($_SESSION['login'])) {
    $token_cookie = $_COOKIE['remember_me'];

    // Cari pengguna berdasarkan token cookie di database
    // Pastikan kolom 'remember_token' ada di tabel 'users' Anda
    $query_token = "SELECT id, username FROM users WHERE remember_token = '$token_cookie'";
    $result_token = mysqli_query($conn, $query_token);

    if ($result_token && mysqli_num_rows($result_token) == 1) {
        $user_from_cookie = mysqli_fetch_assoc($result_token);
        $_SESSION['login'] = true; // Set session login
        // Anda bisa juga menyimpan data user lain di session jika diperlukan
        // $_SESSION['user_id'] = $user_from_cookie['id'];
        // $_SESSION['username'] = $user_from_cookie['username'];
        header("Location: index.php");
        exit;
    } else {
        // Jika token tidak valid atau tidak ditemukan, hapus cookie yang usang
        setcookie('remember_me', '', time() - 3600, '/'); // Atur waktu kadaluarsa di masa lalu untuk menghapus
    }
}

// --- Proses Login Form ---
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $remember_me = isset($_POST['remember_me']); // Cek apakah checkbox "Ingat Saya" dicentang

    $query = "SELECT id, username, password FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password yang di-hash
        if (password_verify($password, $user['password'])) {
            $_SESSION['login'] = true;
            // Anda bisa menyimpan data user lain di session jika diperlukan
            // $_SESSION['user_id'] = $user['id'];
            // $_SESSION['username'] = $user['username'];

            // Jika checkbox "Ingat Saya" dicentang
            if ($remember_me) {
                // Generate token unik yang aman
                $token = bin2hex(random_bytes(32)); // Menghasilkan 64 karakter heksadesimal acak
                
                // Simpan token ke database untuk user ini
                $user_id = $user['id']; 
                $update_token_query = "UPDATE users SET remember_token = '$token' WHERE id = '$user_id'";
                mysqli_query($conn, $update_token_query);

                // Set cookie dengan token dan waktu kadaluarsa (misal: 30 hari)
                // Pastikan domain dan path sesuai dengan aplikasi Anda
                setcookie('remember_me', $token, time() + (86400 * 1), '/'); // 86400 = 1 hari
            } else {
                // Jika tidak dicentang, pastikan cookie 'remember_me' dihapus jika ada
                setcookie('remember_me', '', time() - 3600, '/');
                // Dan juga hapus token dari database jika ada (disarankan untuk keamanan)
                $user_id = $user['id'];
                mysqli_query($conn, "UPDATE users SET remember_token = NULL WHERE id = '$user_id'");
            }

            header("Location: index.php"); // Arahkan ke halaman utama setelah login berhasil
            exit;
        }
    }

    // Jika username atau password salah
    $error = "Username atau password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST" action="">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" required autocomplete="username">

            <label for="password">Password</label>
            <input type="password" name="password" id="password" required autocomplete="current-password">

            <div class="remember-me">
                <input type="checkbox" name="remember_me" id="remember_me">
                <label for="remember_me">Ingat Saya</label>
            </div>

            <button type="submit" name="login">Login</button>
        </form>
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>

        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
    </div>
</body>
</html>