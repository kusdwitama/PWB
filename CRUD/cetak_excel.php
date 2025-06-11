<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=data_mahasiswa.xls");

include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Export Excel - Data Mahasiswa</title>
</head>
<body>

<h2 style="text-align: center;">Daftar Mahasiswa</h2>

<table border="1" cellpadding="10" cellspacing="0" style="border-collapse: collapse; width: 100%;">
  <thead>
    <tr style="background-color: #2980b9; color: white;">
      <th>No</th>
      <th>NIM</th>
      <th>Nama</th>
      <th>Program Studi</th>
      <th>Semester</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $no = 1;
    $query = "SELECT * FROM mahasiswa";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nim']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['prodi']}</td>
                    <td>{$row['semester']}</td>
                    <td>{$row['email']}</td>
                  </tr>";
            $no++;
        }
    } else {
        echo "<tr><td colspan='6'>Data tidak tersedia.</td></tr>";
    }

    mysqli_close($conn);
    ?>
  </tbody>
</table>

</body>
</html>
