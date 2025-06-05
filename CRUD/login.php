<?php
session_start();
include 'koneksi.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek ke database
    $query = "SELECT * FROM users WHERE BINARY username='$username' AND BINARY password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $_SESSION['login'] = true;
        header("Location: index.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="container">
    <h1>Login</h1>
    <form method="POST" action="">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" required>

      <label for="password">Password</label>
      <input type="password" name="password" id="password" required>

      <button type="submit" name="login">Login</button>
    </form>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
  </div>
</body>
</html>
