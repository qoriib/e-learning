<?php
session_start();
include "../../config.php";
include "../../log.php";

$id_guru = $_SESSION['id'];
$id_mapel = $_POST['mapel'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];

$nama_file = $_FILES['file']['name'];
$tmp = $_FILES['file']['tmp_name'];

$folder = "../../uploads/materi/";
$path = $folder . time() . "_" . $nama_file;

// upload file
move_uploaded_file($tmp, $path);

mysqli_query($conn,
"INSERT INTO materi (id_guru, id_mapel, judul_materi, deskripsi, file_path)
 VALUES ('$id_guru', '$id_mapel', '$judul', '$deskripsi', '$path')");

// LOG
catat_log($conn, "Guru mengupload materi: $judul");

header("Location: materi.php");
exit();
?>
