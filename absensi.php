<?php
session_start();
require 'config.php'; // Memuat koneksi $koneksi dari config.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Data dari form absensi
    $id_karyawan = $_POST['id_karyawan'];
    $tanggal = $_POST['tanggal'];
    $status_kehadiran = $_POST['status_kehadiran'];
    $jam_masuk = $_POST['jam_masuk'];
    $jam_keluar = $_POST['jam_keluar'];
    $lembur = $_POST['lembur'];

    // Menyimpan data absensi ke database menggunakan mysqli
    $stmt = $koneksi->prepare("INSERT INTO absensi (id_karyawan, tanggal, status_kehadiran, jam_masuk, jam_keluar, lembur) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssd", $id_karyawan, $tanggal, $status_kehadiran, $jam_masuk, $jam_keluar, $lembur);

    // Eksekusi dan cek apakah berhasil
    if ($stmt->execute()) {
        echo "Data absensi berhasil disimpan!";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Absensi</title>
    <style>
        body {
            background-color: #f6f6f6;
            font-family: Arial, sans-serif;
            color: #443f3c;
        }
        form {
            background-color: #ece8e5;
            padding: 20px;
            border-radius: 8px;
            max-width: 400px;
            margin: auto;
            box-shadow: 0px 0px 8px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #443f3c;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #f6f6f6;
        }
        button {
            background-color: #ec7d4b;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #c7663a;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Form Absensi</h2>
    
    <form method="post" action="absensi.php">
        <label>ID Karyawan:</label>
        <input type="number" name="id_karyawan" required>

        <label>Tanggal:</label>
        <input type="date" name="tanggal" required>

        <label>Status Kehadiran:</label>
        <select name="status_kehadiran">
            <option value="Hadir">Hadir</option>
            <option value="Izin">Izin</option>
            <option value="Sakit">Sakit</option>
            <option value="Alpha">Alpha</option>
        </select>

        <label>Jam Masuk:</label>
        <input type="time" name="jam_masuk">

        <label>Jam Keluar:</label>
        <input type="time" name="jam_keluar">

        <label>Lembur (Jam):</label>
        <input type="number" step="0.1" name="lembur">

        <button type="submit">Simpan Absensi</button>
    </form>
</body>
</html>
