<?php
    // dashboard_admin.php
    session_start();
    if (!isset($_SESSION['tingkat_akses']) || $_SESSION['tingkat_akses'] != 'admin') {
        header("Location: login.php");
        exit;
    }

    // Koneksi ke database
    include 'config.php';

    // Query untuk mendapatkan data absensi per hari
    $query_absensi = "SELECT DATE(tanggal) AS tanggal, COUNT(*) AS total_absen 
                      FROM absensi 
                      GROUP BY DATE(tanggal)
                      ORDER BY tanggal DESC"; // Urutkan berdasarkan tanggal terbaru
    $result_absensi = mysqli_query($koneksi, $query_absensi);

    // Mengecek apakah query berhasil
    if (!$result_absensi) {
        die('Query failed: ' . mysqli_error($koneksi));
    }

    // Menyiapkan data untuk grafik
    $tanggal_absensi = [];
    $total_absensi = [];
    while ($row = mysqli_fetch_assoc($result_absensi)) {
        $tanggal_absensi[] = $row['tanggal'];
        $total_absensi[] = $row['total_absen'];
    }

    // Menutup koneksi
    mysqli_close($koneksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Menambahkan Chart.js -->
    <style>

        .navbar-brand {
            color: #ec7d4b !important; /* oren */
        }

        body {
            background-color: #f6f6f6; /* white */
        }
        .navbar {
            background-color: #ece8e5; /* white cream */
        }
        
        .navbar-brand{
            color: #ec7d4b; /* oren */
        }

        .nav-link {
            color: #443f3c; /* coklat */
        }
        .nav-link:hover {
            color: #ec7d4b; /* oren */
        }
        .container {
            margin-top: 50px;
            text-align: center;
            color: #443f3c; /* coklat */
        }
        .btn-logout {
            background-color: #ec7d4b; /* oren */
            color: white;
            border: none;
        }
        .btn-logout:hover {
            background-color: #d66a3b; /* darker oren */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_admin.php">Hikaru Garmen</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                <a class="nav-link active" href="dashboard_admin.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="manage_karyawan.php">Data Karyawan</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="manage_absensi.php">Data Absensi</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="calculate_salary.php">Gaji</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2>Selamat datang, <?php echo $_SESSION['user_name']; ?>!</h2>

        <h3 class="mt-5">Grafik Absensi Karyawan Per Hari</h3>
        <canvas id="absensiChart" width="300" height="100"></canvas> <!-- Canvas untuk Grafik -->

        <script>
            // Mengambil data PHP ke JavaScript
            const tanggalAbsensi = <?php echo json_encode($tanggal_absensi); ?>;
            const totalAbsensi = <?php echo json_encode($total_absensi); ?>;

            // Membuat Grafik Absensi
            const ctx = document.getElementById('absensiChart').getContext('2d');
            const absensiChart = new Chart(ctx, {
                type: 'bar', // Jenis grafik bar
                data: {
                    labels: tanggalAbsensi, // Tanggal sebagai label
                    datasets: [{
                        label: 'Total Absensi per Hari', 
                        data: totalAbsensi, // Total absensi per hari
                        backgroundColor: '#ec7d4b', // Warna grafik
                        borderColor: '#443f3c', // Warna border grafik
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        x: {
                            ticks: {
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    </div>
</body>
</html>


