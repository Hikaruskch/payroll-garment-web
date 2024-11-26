<?php
session_start();
include 'config.php';

if (isset($_POST['email']) && isset($_POST['password'])) {
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];
    
    $query = "SELECT * FROM pengguna WHERE email = '$user_email' AND kata_sandi = '$user_password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        // Jika user ditemukan, login berhasil
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id_pengguna'];
        $_SESSION['user_name'] = $user['email'];
        $_SESSION['tingkat_akses'] = $user['tingkat_akses'];

        // Redirect berdasarkan user level
        if ($user['tingkat_akses'] === 'admin') {
            header("Location:dashboard_admin.php");
        } else {
            header("Location:absensi.php");
        }
        exit;
    } else {
        echo "Email atau password salah, atau akun tidak aktif.";
    }
} else {
    echo "Silahkan isi email dan password.";
}
?>
