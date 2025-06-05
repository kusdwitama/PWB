<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kampus";

// Koneksi ke database
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk mengecek apakah NIM sudah ada di database
function cekNimExist($nim) {
  global $conn;
  $stmt = mysqli_prepare($conn, "SELECT * FROM mahasiswa WHERE nim = ?");
  mysqli_stmt_bind_param($stmt, "s", $nim);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $exists = mysqli_num_rows($result) > 0;
  mysqli_stmt_close($stmt);
  return $exists;
}

// Fungsi Tambah Mahasiswa
function tambahMahasiswa($nim, $nama, $prodi, $semester, $email) {
  global $conn;
  
  // Mengecek apakah NIM sudah ada
  if (cekNimExist($nim)) {
    return false;  // Jika NIM sudah ada, return false
  }
  
  // Jika NIM belum ada, lakukan insert data mahasiswa
  $stmt = mysqli_prepare($conn, "INSERT INTO mahasiswa (nim, nama, prodi, semester, email) 
                                  VALUES (?, ?, ?, ?, ?)");
  mysqli_stmt_bind_param($stmt, "sssss", $nim, $nama, $prodi, $semester, $email);
  
  $result = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  
  return $result;  // Mengembalikan hasil eksekusi query (true jika berhasil, false jika gagal)
}

// Fungsi Ambil Semua Data Mahasiswa
function getAllMahasiswa() {
  global $conn;
  $result = mysqli_query($conn, "SELECT * FROM mahasiswa");
  return $result;
}

// Fungsi Ambil Satu Mahasiswa
function getMahasiswa($nim) {
  global $conn;
  $stmt = mysqli_prepare($conn, "SELECT * FROM mahasiswa WHERE nim = ?");
  mysqli_stmt_bind_param($stmt, "s", $nim);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return mysqli_fetch_assoc($result);
}

// Fungsi Update Mahasiswa
function updateMahasiswa($nim, $nama, $prodi, $semester, $email) {
  global $conn;
  $stmt = mysqli_prepare($conn, "UPDATE mahasiswa SET nama = ?, prodi = ?, semester = ?, email = ? WHERE nim = ?");
  mysqli_stmt_bind_param($stmt, "sssss", $nama, $prodi, $semester, $email, $nim);
  $result = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  return $result;
}

// Fungsi Hapus Mahasiswa
function hapusMahasiswa($nim) {
  global $conn;
  $stmt = mysqli_prepare($conn, "DELETE FROM mahasiswa WHERE nim = ?");
  mysqli_stmt_bind_param($stmt, "s", $nim);
  $result = mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  return $result;
}
?>
