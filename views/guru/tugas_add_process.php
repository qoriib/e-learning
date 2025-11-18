<?php
session_start();
include "../../config.php";
include "../../log.php";

$id_guru  = $_SESSION['id'];
$id_kelas = $_POST['kelas'];
$id_mapel = $_POST['mapel'];
$judul    = $_POST['judul'];
$desk     = $_POST['deskripsi'];
$deadline = $_POST['deadline'];

$file_path = NULL;

// Jika upload file
if(!empty($_FILES['file']['name'])){
    $nama_file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $folder = "../../uploads/tugas/";
    if(!is_dir($folder)) mkdir($folder, 0777, true);
    $file_path = $folder . time() . "_" . $nama_file;
    move_uploaded_file($tmp, $file_path);
}

mysqli_query($conn,
"INSERT INTO tugas (id_guru, id_mapel, id_kelas, judul_tugas, deskripsi, file_path, deadline)
 VALUES ('$id_guru', '$id_mapel', '$id_kelas', '$judul', '$desk', '$file_path', '$deadline')");

catat_log($conn, "Guru membuat tugas: $judul");
header("Location: tugas.php");
exit();
?>
