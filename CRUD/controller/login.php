<?php
session_start();
include '../koneksi.php';
if (isset($_COOKIE['remember_me']) && !isset($_SESSION['login'])) {
    $t = $_COOKIE['remember_me'];
    $r = mysqli_query($conn, "SELECT id,username FROM users WHERE remember_token='$t'");
    if ($r && mysqli_num_rows($r)==1) {
        $_SESSION['login']=true;
        header("Location:index.php"); exit;
    } else setcookie('remember_me','',time()-3600,'/');
}
if (isset($_POST['login'])) {
    $u=$_POST['username'];
    $p=$_POST['password'];
    $rm=isset($_POST['remember_me']);
    $q=mysqli_query($conn,"SELECT id,username,password FROM users WHERE username='$u'");
    if ($q && mysqli_num_rows($q)==1 && password_verify($p, mysqli_fetch_assoc($q)['password'])) {
        $user=mysqli_fetch_assoc($q);
        $_SESSION['login']=true;
        if ($rm) {
            $tkn=bin2hex(random_bytes(32));
            mysqli_query($conn,"UPDATE users SET remember_token='$tkn' WHERE id='{$user['id']}'");
            setcookie('remember_me',$tkn, time()+86400*30,'/');
        } else {
            setcookie('remember_me','',time()-3600,'/');
            mysqli_query($conn,"UPDATE users SET remember_token=NULL WHERE id='{$user['id']}'");
        }
        header("Location:../index.php"); exit;
    }
    $error="Username atau password salah!";
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>Login</title><script src="https://cdn.tailwindcss.com"></script></head><body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">Login</h1>
    <?php if (isset($error)): ?>
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"><?php echo $error ?></div>
    <?php endif; ?>
    <form method="POST">
      <label class="block mb-1 text-gray-700">Username</label><input type="text" name="username" required class="w-full mb-4 px-3 py-2 border rounded" autocomplete="username">
      <label class="block mb-1 text-gray-700">Password</label><input type="password" name="password" required class="w-full mb-4 px-3 py-2 border rounded" autocomplete="current-password">
      <div class="flex items-center mb-6">
        <input type="checkbox" name="remember_me" id="remember_me" class="mr-2">
        <label for="remember_me" class="text-gray-700">Ingat Saya</label>
      </div>
      <button type="submit" name="login" class="w-full bg-gray-800 text-white py-2 rounded hover:bg-gray-700 transition">Login</button>
    </form>
    <p class="mt-4 text-center text-gray-600">Belum punya akun? <a href="register.php" class="text-blue-600 hover:underline">Daftar di sini</a></p>
  </div>
</body></html>
