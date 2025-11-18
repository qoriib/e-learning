<?php
session_start();
include "../../config.php";
include "../../log.php"; // WAJIB ditambahkan agar catat_log berfungsi

$id_guru = $_SESSION['id']; // id user guru
$judul   = $_POST['judul'];

$nama_file = $_FILES['file']['name'];
$lokasi = $_FILES['file']['tmp_name'];

$folder = "../../uploads/laporan/";
$path = $folder . time() . "_" . $nama_file;

// upload file
move_uploaded_file($lokasi, $path);

// simpan ke database
mysqli_query($conn, "INSERT INTO laporan (id_guru, judul_laporan, file_path)
VALUES ('$id_guru', '$judul', '$path')");

// CATAT LOG AKTIVITAS GURU
catat_log($conn, "Guru mengupload laporan: $judul");

// redirect
header("Location: laporan.php");
exit();
?>
