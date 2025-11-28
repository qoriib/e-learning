<?php
session_start();
include "../../config.php";
include "../../log.php";
include "../../helpers/auth_helper.php";

$id_guru  = getGuruId($conn);
if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}
$id_kelas = intval($_POST['kelas']);
$id_mapel = intval($_POST['mapel']);
$judul    = $_POST['judul'];
$desk     = $_POST['deskripsi'];
$deadline_input = $_POST['deadline'];
$deadline = date('Y-m-d H:i:s', strtotime($deadline_input));

$cekRoster = mysqli_query($conn,
"SELECT id FROM roster
 WHERE id_guru='$id_guru'
   AND id_kelas='$id_kelas'
   AND id_mapel='$id_mapel'
 LIMIT 1");

if(mysqli_num_rows($cekRoster) == 0){
    header("Location: tugas_add.php?error=roster");
    exit();
}

$file_path = NULL;

// Jika upload file
if(!empty($_FILES['file']['name'])){
    $nama_file = $_FILES['file']['name'];
    $tmp = $_FILES['file']['tmp_name'];
    $folder = "../../uploads/tugas/";
    if(!is_dir($folder)) mkdir($folder, 0777, true);
    $clean_name = time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $nama_file);
    $full_path = $folder . $clean_name;
    move_uploaded_file($tmp, $full_path);
    $file_path = "uploads/tugas/" . $clean_name;
}

mysqli_query($conn,
"INSERT INTO tugas (id_guru, id_mapel, id_kelas, judul_tugas, deskripsi, file_path, deadline)
 VALUES ('$id_guru', '$id_mapel', '$id_kelas', '$judul', '$desk', '$file_path', '$deadline')");

catat_log($conn, "Guru membuat tugas: $judul");
header("Location: tugas.php");
exit();
?>
