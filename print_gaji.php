<?php
session_start();

// Cek akses admin
if (!isset($_SESSION['tingkat_akses']) || $_SESSION['tingkat_akses'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Koneksi ke database dan load FPDF
include 'config.php';
require 'fpdf.php';

// Pengaturan gaji
$gaji_per_hari = 100000;
$pengurangan_alfa = 30000;

class PDF extends FPDF
{
    // Header PDF
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Laporan Gaji Karyawan - Hikaru Garment', 0, 1, 'C');
        $this->Ln(5);
    }

    // Footer PDF
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Inisialisasi PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Tabel Header
$pdf->Cell(10, 10, 'No', 1);
$pdf->Cell(50, 10, 'Nama Karyawan', 1);
$pdf->Cell(30, 10, 'Bagian', 1);
$pdf->Cell(20, 10, 'Hadir', 1);
$pdf->Cell(20, 10, 'Izin', 1);
$pdf->Cell(20, 10, 'Sakit', 1);
$pdf->Cell(20, 10, 'Alfa', 1);
$pdf->Cell(30, 10, 'Total Gaji', 1);
$pdf->Ln();

// Ambil data karyawan
$query_karyawan = "SELECT * FROM karyawan";
$karyawan_data = mysqli_query($koneksi, $query_karyawan);
$no = 1;

while ($karyawan = mysqli_fetch_assoc($karyawan_data)) {
    $id_karyawan = $karyawan['id_karyawan'];
    
    // Ambil data absensi karyawan
    $query_absensi = "SELECT 
        SUM(status_kehadiran = 'Hadir') AS hadir,
        SUM(status_kehadiran = 'Izin') AS izin,
        SUM(status_kehadiran = 'Sakit') AS sakit,
        SUM(status_kehadiran = 'Alfa') AS alfa
    FROM absensi WHERE id_karyawan = '$id_karyawan'";
    $absensi = mysqli_fetch_assoc(mysqli_query($koneksi, $query_absensi));

    // Hitung total gaji
    $total_hadir = $absensi['hadir'];
    $total_alfa = $absensi['alfa'];
    $total_potongan_alfa = $total_alfa * $pengurangan_alfa;
    $total_gaji = ($total_hadir * $gaji_per_hari) - $total_potongan_alfa;

    // Isi Data ke dalam Tabel PDF
    $pdf->Cell(10, 10, $no++, 1);
    $pdf->Cell(50, 10, $karyawan['nama'], 1);
    $pdf->Cell(30, 10, $karyawan['bagian'], 1);
    $pdf->Cell(20, 10, $total_hadir, 1);
    $pdf->Cell(20, 10, $absensi['izin'], 1);
    $pdf->Cell(20, 10, $absensi['sakit'], 1);
    $pdf->Cell(20, 10, $total_alfa, 1);
    $pdf->Cell(30, 10, 'Rp ' . number_format($total_gaji, 2, ',', '.'), 1);
    $pdf->Ln();
}

// Output PDF
$pdf->Output('D', 'Laporan_Gaji_Karyawan.pdf');
?>
