<?php
$rata_rata = 0;
$error = '';
$step = 1;
$jumlah_nilai = 0;
$nilai_mahasiswa = [];

// Tahap 1: Ambil jumlah nilai
if (isset($_POST['step']) && $_POST['step'] == 1) {
    $jumlah_nilai = (int) $_POST['jumlah_nilai'];
    $step = 2;
}

// Tahap 2: Hitung rata-rata
if (isset($_POST['step']) && $_POST['step'] == 2) {
    $jumlah_nilai = (int) $_POST['jumlah_nilai'];
    $step = 2;
    $total = 0;

    for ($i = 0; $i < $jumlah_nilai; $i++) {
        $nilai_input = $_POST["nilai_$i"] ?? '';

        if (!is_numeric($nilai_input)) {
            $error = "Nilai ke-" . ($i + 1) . " tidak valid.";
            break;
        }

        $nilai_mahasiswa[] = (float) $nilai_input;
        $total += (float) $nilai_input;
    }

    if (!$error) {
        $rata_rata = $total / $jumlah_nilai;
        $step = 3;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Rata-rata Nilai Mahasiswa</title>
</head>
<body>
    <h2>Hitung Rata-rata Nilai Mahasiswa</h2>

    <?php if ($step == 1): ?>
        <!-- Form Tahap 1: Input jumlah nilai -->
        <form method="post">
            <input type="hidden" name="step" value="1">
            <label>Masukkan jumlah nilai yang ingin dihitung:</label><br>
            <input type="number" name="jumlah_nilai" min="1" required>
            <button type="submit">Lanjut</button>
        </form>
    <?php elseif ($step == 2): ?>
        <!-- Form Tahap 2: Input nilai-nilai -->
        <form method="post">
            <input type="hidden" name="step" value="2">
            <input type="hidden" name="jumlah_nilai" value="<?= $jumlah_nilai ?>">
            <?php for ($i = 0; $i < $jumlah_nilai; $i++): ?>
                <label>Nilai ke-<?= $i + 1 ?>:</label>
                <input type="text" name="nilai_<?= $i ?>" required><br>
            <?php endfor; ?>
            <button type="submit">Hitung Rata-rata</button>
        </form>
        <?php if ($error): ?>
            <p style="color:red"><?= $error ?></p>
        <?php endif; ?>
    <?php elseif ($step == 3): ?>
        <!-- Hasil -->
        <h3>Rata-rata nilai mahasiswa: <?= number_format($rata_rata, 2) ?></h3>
        <a href="<?= $_SERVER['PHP_SELF'] ?>">Hitung Lagi</a>
    <?php endif; ?>
</body>
</html>
