<?php
require('../../fpdf/fpdf.php'); // Pastikan folder fpdf ada
include '../../koneksi.php';

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(190,10,'Daftar Mahasiswa',0,1,'C');
$pdf->Ln(5);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(10,10,'No',1);
$pdf->Cell(30,10,'NIM',1);
$pdf->Cell(50,10,'Nama',1);
$pdf->Cell(50,10,'Prodi',1);
$pdf->Cell(20,10,'Smt',1);
$pdf->Cell(30,10,'Email',1);
$pdf->Ln();

$pdf->SetFont('Arial','',10);
$no = 1;
$result = mysqli_query($conn, "SELECT * FROM mahasiswa");

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(10,8,$no++,1);
    $pdf->Cell(30,8,$row['nim'],1);
    $pdf->Cell(50,8,$row['nama'],1);
    $pdf->Cell(50,8,$row['prodi'],1);
    $pdf->Cell(20,8,$row['semester'],1);
    $pdf->Cell(30,8,$row['email'],1);
    $pdf->Ln();
}

$pdf->Output();
