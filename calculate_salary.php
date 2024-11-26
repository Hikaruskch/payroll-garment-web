<?php
session_start();

// Periksa apakah pengguna sudah login dan memiliki akses sebagai admin
if (!isset($_SESSION['tingkat_akses']) || $_SESSION['tingkat_akses'] != 'admin') {
    header("Location: login.php");
    exit;
}

// Koneksi ke database
include 'config.php';

// Mengambil data karyawan
$query_karyawan = "SELECT * FROM karyawan";
$karyawan_data = mysqli_query($koneksi, $query_karyawan);

// Periksa apakah query berhasil dijalankan
if (!$karyawan_data) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Parameter penggajian
$gaji_per_hari = 100000;
$pengurangan_alfa = 30000;
$hari_kerja_wajib = 20;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perhitungan Gaji</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <script>
        function printPage() {
            window.print();
        }
    </script>
    <style>
        .navbar-brand {
            color: #ec7d4b !important; /* oren */
        }
        body {
            background-color: #ece8e5; /* white cream */
        }
        .navbar {
            background-color: #ec7d4b; /* oren */
        }
        .navbar-brand, .nav-link {
            color: #f6f6f6; /* white */
        }
        .navbar-nav .nav-link:hover {
            color: #443f3c; /* coklat */
        }
        .container {
            background-color: #f6f6f6; /* white */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        table {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            text-align: center;
            padding: 12px;
            vertical-align: middle;
        }
        th {
            background-color: #ec7d4b; /* oren */
            color: #000; /* Hitam */
        }
        .btn-primary {
            background-color: #ec7d4b; /* oren */
            border-color: #ec7d4b;
        }
        .btn-primary:hover {
            background-color: #443f3c; /* coklat */
            border-color: #443f3c;
        }
        .btn-sm {
            font-size: 0.875rem;
        }
        .table-bordered {
            border: 1px solid #ddd;
        }
        .table-bordered th, .table-bordered td {
            border-color: #ece8e5; /* white cream */
        }
    </style>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard_admin.php">Hikaru Garment</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="dashboard_admin.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_karyawan.php">Data Karyawan</a></li>
                    <li class="nav-item"><a class="nav-link" href="manage_absensi.php">Data Absensi</a></li>
                    <li class="nav-item"><a class="nav-link active" href="calculate_salary.php">Gaji</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center mb-4" style="color: #443f3c;">Perhitungan Gaji Karyawan</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Bagian</th>
                    <th>Hadir</th>
                    <th>Izin</th>
                    <th>Sakit</th>
                    <th>Alfa</th>
                    <th>Total Gaji</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($karyawan = mysqli_fetch_assoc($karyawan_data)) {
                    $id_karyawan = $karyawan['id_karyawan'];
                    
                    // Menghitung jumlah kehadiran
                    $query_absensi = "SELECT 
                        SUM(status_kehadiran = 'Hadir') AS hadir,
                        SUM(status_kehadiran = 'Izin') AS izin,
                        SUM(status_kehadiran = 'Sakit') AS sakit,
                        SUM(status_kehadiran = 'Alfa') AS alfa
                    FROM absensi WHERE id_karyawan = '$id_karyawan'";
                    $absensi = mysqli_fetch_assoc(mysqli_query($koneksi, $query_absensi));

                    // Default nilai absensi jika tidak ada data
                    $total_hadir = $absensi['hadir'] ?? 0;
                    $total_izin = $absensi['izin'] ?? 0;
                    $total_sakit = $absensi['sakit'] ?? 0;
                    $total_alfa = $absensi['alfa'] ?? 0;

                    // Menghitung total gaji
                    $total_potongan_alfa = $total_alfa * $pengurangan_alfa;
                    $total_gaji = ($total_hadir * $gaji_per_hari) - $total_potongan_alfa;

                    echo "<tr>
                        <td>" . $no++ . "</td>
                        <td>" . htmlspecialchars($karyawan['nama']) . "</td>
                        <td>" . htmlspecialchars($karyawan['bagian']) . "</td>
                        <td>" . $total_hadir . "</td>
                        <td>" . $total_izin . "</td>
                        <td>" . $total_sakit . "</td>
                        <td>" . $total_alfa . "</td>
                        <td>Rp " . number_format($total_gaji, 2, ',', '.') . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Tombol Print -->
        <div class="text-center mt-4">
            <button class="btn btn-primary" onclick="printPage()">Print Halaman</button>
        </div>
    </div>
</body>
</html>
