<?php
// manage_absensi.php
session_start();
if (!isset($_SESSION['tingkat_akses']) || $_SESSION['tingkat_akses'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php'; // Pastikan koneksi ke database sudah benar

// Tambah data absensi
if (isset($_POST['add_absensi'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];

    $query = "INSERT INTO absensi (id_karyawan, tanggal, status_kehadiran) VALUES ('$id_karyawan', '$tanggal', '$status')";
    mysqli_query($koneksi, $query);
    header("Location: manage_absensi.php");
}

// Update data absensi
if (isset($_POST['update_absensi'])) {
    $id_absensi = $_POST['id_absensi'];
    $id_karyawan = $_POST['id_karyawan'];
    $tanggal = $_POST['tanggal'];
    $status = $_POST['status'];

    $query = "UPDATE absensi SET id_karyawan='$id_karyawan', tanggal='$tanggal', status_kehadiran='$status' WHERE id_absensi='$id_absensi'";
    mysqli_query($koneksi, $query);
    header("Location: manage_absensi.php");
}

// Hapus data absensi
if (isset($_GET['delete_absensi'])) {
    $id_absensi = $_GET['delete_absensi'];
    $query = "DELETE FROM absensi WHERE id_absensi='$id_absensi'";
    mysqli_query($koneksi, $query);
    header("Location: manage_absensi.php");
}

// Ambil data absensi untuk ditampilkan di tabel
$absensi_data = mysqli_query($koneksi, "SELECT absensi.*, karyawan.nama FROM absensi JOIN karyawan ON absensi.id_karyawan = karyawan.id_karyawan");

// Ambil data absensi untuk form edit jika tombol Edit diklik
$edit_data = null;
if (isset($_GET['edit_absensi'])) {
    $id_absensi = $_GET['edit_absensi'];
    $edit_data = mysqli_query($koneksi, "SELECT * FROM absensi WHERE id_absensi='$id_absensi'");
    $edit_data = mysqli_fetch_assoc($edit_data);
}

// Ambil data karyawan untuk pilihan di form absensi
$karyawan_list = mysqli_query($koneksi, "SELECT id_karyawan, nama FROM karyawan");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Data Absensi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>

        .navbar-brand {
            color: #ec7d4b !important; /* oren */
        }
        body {
            background-color: #ece8e5; /* white cream */
            color: #443f3c; /* coklat */
        }
        .navbar {
            background-color: #f6f6f6; /* white */
        }
        .navbar-nav .nav-link {
            color: #443f3c; /* coklat */
        }
        .navbar-nav .nav-link:hover {
            color: #ec7d4b; /* oren */
        }
        .container {
            background-color: #ffffff; /* white */
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #ec7d4b; /* oren */
            border-color: #ec7d4b; /* oren */
        }
        .btn-warning {
            background-color: #ec7d4b; /* oren */
            border-color: #ec7d4b; /* oren */
        }
        .btn-danger {
            background-color: #f44336; /* red */
            border-color: #f44336; /* red */
        }
        .table th {
            background-color: #f6f6f6; /* white */
        }
        .table-bordered {
            border-color: #ec7d4b; /* oren */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_admin.php">Hikaru Garment</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard_admin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="manage_karyawan.php">Data Karyawan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="manage_absensi.php">Data Absensi</a>
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
<div class="container mt-4">
    <h2 class="mt-4">Manage Data Absensi</h2>

    <!-- Form Tambah/Edit Absensi -->
    <form method="POST" class="mb-4">
        <input type="hidden" name="id_absensi" value="<?php echo isset($edit_data['id_absensi']) ? $edit_data['id_absensi'] : ''; ?>">
        <div class="mb-3">
            <label>Nama Karyawan</label>
            <select name="id_karyawan" class="form-select" required>
                <?php while ($karyawan = mysqli_fetch_assoc($karyawan_list)) { ?>
                    <option value="<?php echo $karyawan['id_karyawan']; ?>" <?php echo isset($edit_data['id_karyawan']) && $edit_data['id_karyawan'] == $karyawan['id_karyawan'] ? 'selected' : ''; ?>>
                        <?php echo $karyawan['nama']; ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required value="<?php echo isset($edit_data['tanggal']) ? $edit_data['tanggal'] : ''; ?>">
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-select" required>
                <option value="Hadir" <?php echo isset($edit_data['status']) && $edit_data['status'] == 'Hadir' ? 'selected' : ''; ?>>Hadir</option>
                <option value="Izin" <?php echo isset($edit_data['status']) && $edit_data['status'] == 'Izin' ? 'selected' : ''; ?>>Izin</option>
                <option value="Sakit" <?php echo isset($edit_data['status']) && $edit_data['status'] == 'Sakit' ? 'selected' : ''; ?>>Sakit</option>
                <option value="Alpa" <?php echo isset($edit_data['status']) && $edit_data['status'] == 'Alpa' ? 'selected' : ''; ?>>Alpa</option>
            </select>
        </div>
        <button type="submit" name="<?php echo isset($edit_data) ? 'update_absensi' : 'add_absensi'; ?>" class="btn btn-primary">
            <?php echo isset($edit_data) ? 'Update Absensi' : 'Tambah Absensi'; ?>
        </button>
    </form>

    <!-- Tabel Data Absensi -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Karyawan</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($absensi_data)) { ?>
                <tr>
                    <td><?php echo $row['nama']; ?></td>
                    <td><?php echo $row['tanggal']; ?></td>
                    <td><?php echo $row['status_kehadiran']; ?></td>
                    <td>
                        <a href="manage_absensi.php?edit_absensi=<?php echo $row['id_absensi']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="manage_absensi.php?delete_absensi=<?php echo $row['id_absensi']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
