<?php
session_start();
require 'koneksi.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
  $user = $result->fetch_assoc();

  // Untuk produksi gunakan password_hash, ini hanya contoh
  if ($password === $user['password']) {
    $_SESSION['username'] = $user['username'];
    header("Location: index2.php");
    exit();
  }
}

echo "<script>alert('Login failed! Check your credentials.'); window.location.href='login.php';</script>";
