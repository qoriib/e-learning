<?php
session_start();
include "../../config.php";
include "../../log.php"; // WAJIB ditambahkan agar catat_log berfungsi
include "../../helpers/auth_helper.php";

$id_guru = getGuruId($conn);
if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}
$judul   = $_POST['judul'];

$nama_file = $_FILES['file']['name'];
$lokasi = $_FILES['file']['tmp_name'];

$folder = "../../uploads/laporan/";
if(!is_dir($folder)){
    mkdir($folder, 0777, true);
}
$cleanName = time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $nama_file);
$path = $folder . $cleanName;
$dbPath = "uploads/laporan/" . $cleanName;

// upload file
move_uploaded_file($lokasi, $path);

// simpan ke database
mysqli_query($conn, "INSERT INTO laporan (id_guru, judul_laporan, file_path)
VALUES ('$id_guru', '$judul', '$dbPath')");

// CATAT LOG AKTIVITAS GURU
catat_log($conn, "Guru mengupload laporan: $judul");

// redirect
header("Location: laporan.php");
exit();
?>
