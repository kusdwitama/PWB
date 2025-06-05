<?php

$nama_gue = "Muh Naufal Kusdwitama";
$bagian = "Web Developer";
$gaji = 5000000;
$jml_anak = 10;
$tunjangan_per_anak = 200000;

$total_tunjangan = $jml_anak * $tunjangan_per_anak;
$total_gaji = $gaji + $total_tunjangan;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #2193b0, #6dd5ed);
            text-align: center;
            margin: 50px;
            color: #fff;
        }
        .container {
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 10px;
            width: 50%;
            margin: auto;
            box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.5);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
            border-radius: 5px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }
        th {
            background: rgba(255, 255, 255, 0.4);
            color: #000;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Slip Gaji Pegawai</h2>
    <table>
        <tr>
            <th>Keterangan</th>
            <th>Detail</th>
        </tr>
        <tr>
            <td>Nama Pegawai</td>
            <td><?php echo $nama_gue; ?></td>
        </tr>
        <tr>
            <td>Bagian</td>
            <td><?php echo $bagian; ?></td>
        </tr>
        <tr>
            <td>Gaji Pokok</td>
            <td>Rp<?php echo number_format($gaji, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td>Jumlah Anak</td>
            <td><?php echo $jml_anak; ?></td>
        </tr>
        <tr>
            <td>Total Tunjangan Anak</td>
            <td>Rp<?php echo number_format($total_tunjangan, 0, ',', '.'); ?></td>
        </tr>
        <tr>
            <td><b>Total Gaji</b></td>
            <td><b>Rp<?php echo number_format($total_gaji, 0, ',', '.'); ?></b></td>
        </tr>
    </table>
</div>

</body>
</html>
