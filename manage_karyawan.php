<?php
// manage_karyawan.php
session_start();
if (!isset($_SESSION['tingkat_akses']) || $_SESSION['tingkat_akses'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'config.php'; // Pastikan koneksi ke database sudah benar

// Tambah data karyawan
if (isset($_POST['add_karyawan'])) {
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $status_karyawan = $_POST['status_karyawan'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $nomor_rekening = $_POST['nomor_rekening'];

    $query = "INSERT INTO karyawan (nama, bagian, tanggal_masuk, status_karyawan, gaji_pokok, nomor_rekening) VALUES ('$nama', '$bagian', '$tanggal_masuk', '$status_karyawan', '$gaji_pokok', '$nomor_rekening')";
    mysqli_query($koneksi, $query);
    header("Location: manage_karyawan.php");
}

// Update data karyawan
if (isset($_POST['update_karyawan'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $nama = $_POST['nama'];
    $bagian = $_POST['bagian'];
    $tanggal_masuk = $_POST['tanggal_masuk'];
    $status_karyawan = $_POST['status_karyawan'];
    $gaji_pokok = $_POST['gaji_pokok'];
    $nomor_rekening = $_POST['nomor_rekening'];

    $query = "UPDATE karyawan SET nama='$nama', bagian='$bagian', tanggal_masuk='$tanggal_masuk', status_karyawan='$status_karyawan', gaji_pokok='$gaji_pokok', nomor_rekening='$nomor_rekening' WHERE id_karyawan='$id_karyawan'";
    mysqli_query($koneksi, $query);
    header("Location: manage_karyawan.php");
}

// Ambil data karyawan untuk ditampilkan di tabel
$karyawan_data = mysqli_query($koneksi, "SELECT * FROM karyawan");

// Ambil data karyawan untuk form edit jika tombol Edit diklik
$edit_data = null;
if (isset($_GET['edit_karyawan'])) {
    $id_karyawan = $_GET['edit_karyawan'];
    $edit_data = mysqli_query($koneksi, "SELECT * FROM karyawan WHERE id_karyawan='$id_karyawan'");
    $edit_data = mysqli_fetch_assoc($edit_data);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Data Karyawan</title>
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
        .navbar-brand {
            color: #ec7d4b; /* oren */
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
                <a class="nav-link active" href="manage_karyawan.php">Data Karyawan</a>
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
    <div class="container mt-4">
        <h2 class="mt-4">Manage Data Karyawan</h2>

        <!-- Form Tambah/Edit Karyawan -->
        <form method="POST" class="mb-4">
            <input type="hidden" name="id_karyawan" value="<?php echo isset($edit_data['id_karyawan']) ? $edit_data['id_karyawan'] : ''; ?>">
            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required value="<?php echo isset($edit_data['nama']) ? $edit_data['nama'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label>Bagian</label>
                <select name="bagian" class="form-select" required>
                    <option value="Cutting" <?php echo isset($edit_data['bagian']) && $edit_data['bagian'] == 'Cutting' ? 'selected' : ''; ?>>Cutting</option>
                    <option value="Sewing" <?php echo isset($edit_data['bagian']) && $edit_data['bagian'] == 'Sewing' ? 'selected' : ''; ?>>Sewing</option>
                    <option value="Finishing" <?php echo isset($edit_data['bagian']) && $edit_data['bagian'] == 'Finishing' ? 'selected' : ''; ?>>Finishing</option>
                    <option value="QC" <?php echo isset($edit_data['bagian']) && $edit_data['bagian'] == 'QC' ? 'selected' : ''; ?>>QC</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" class="form-control" required value="<?php echo isset($edit_data['tanggal_masuk']) ? $edit_data['tanggal_masuk'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label>Status Karyawan</label>
                <select name="status_karyawan" class="form-select" required>
                    <option value="Tetap" <?php echo isset($edit_data['status_karyawan']) && $edit_data['status_karyawan'] == 'Tetap' ? 'selected' : ''; ?>>Tetap</option>
                    <option value="Kontrak" <?php echo isset($edit_data['status_karyawan']) && $edit_data['status_karyawan'] == 'Kontrak' ? 'selected' : ''; ?>>Kontrak</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Gaji Pokok</label>
                <input type="number" step="0.01" name="gaji_pokok" class="form-control" required value="<?php echo isset($edit_data['gaji_pokok']) ? $edit_data['gaji_pokok'] : ''; ?>">
            </div>
            <div class="mb-3">
                <label>Nomor Rekening</label>
                <input type="text" name="nomor_rekening" class="form-control" required value="<?php echo isset($edit_data['nomor_rekening']) ? $edit_data['nomor_rekening'] : ''; ?>">
            </div>
            <button type="submit" name="<?php echo isset($edit_data) ? 'update_karyawan' : 'add_karyawan'; ?>" class="btn btn-primary">
                <?php echo isset($edit_data) ? 'Update Karyawan' : 'Tambah Karyawan'; ?>
            </button>
        </form>

        <!-- Tabel Data Karyawan -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Bagian</th>
                    <th>Status Karyawan</th>
                    <th>Gaji Pokok</th>
                    <th>Nomor Rekening</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($karyawan_data)) { ?>
                    <tr>
                        <td><?php echo $row['nama']; ?></td>
                        <td><?php echo $row['bagian']; ?></td>
                        <td><?php echo $row['status_karyawan']; ?></td>
                        <td><?php echo number_format($row['gaji_pokok'], 2); ?></td>
                        <td><?php echo $row['nomor_rekening']; ?></td>
                        <td>
                            <a href="manage_karyawan.php?edit_karyawan=<?php echo $row['id_karyawan']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0pZlCZSKXcyU3kT5Hxw8ty4PRw6A6UqH96dj/m9kT+z5ImX8" crossorigin="anonymous"></script>
</body>
</html>
