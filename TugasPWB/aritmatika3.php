<?php
$bmi = '';
$kategori = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $berat = (float) $_POST['berat'];
    $tinggi_cm = (float) $_POST['tinggi'];

    if ($tinggi_cm > 0) {
        $tinggi_m = $tinggi_cm / 100; // konversi ke meter
        $bmi = $berat / ($tinggi_m * $tinggi_m);
        $bmi = number_format($bmi, 2);

        // Menentukan kategori
        if ($bmi < 18.5) {
            $kategori = "Kurus";
        } elseif ($bmi < 25) {
            $kategori = "Normal";
        } elseif ($bmi < 30) {
            $kategori = "Kelebihan Berat Badan";
        } else {
            $kategori = "Obesitas";
        }
    } else {
        $bmi = "Tinggi tidak valid!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator BMI</title>
</head>
<body>
    <h2>Kalkulator BMI (Body Mass Index)</h2>

    <form method="post">
        <label>Berat Badan (kg):</label><br>
        <input type="number" name="berat" step="0.1" required><br><br>

        <label>Tinggi Badan (cm):</label><br>
        <input type="number" name="tinggi" step="0.1" required><br><br>

        <button type="submit">Hitung BMI</button>
    </form>

    <?php if ($bmi): ?>
        <h3>Hasil:</h3>
        <p><strong>BMI:</strong> <?= $bmi ?></p>
        <p><strong>Kategori:</strong> <?= $kategori ?></p>
    <?php endif; ?>
</body>
</html>
