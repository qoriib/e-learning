<?php
session_start();
include "../../config.php";
include "../../log.php";
$id_guru = null;
if($_SESSION['role'] == 'guru'){
    include "../../helpers/auth_helper.php";
    $id_guru = getGuruId($conn);
}

if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}
$id_mapel = intval($_POST['mapel']);
$id_kelas = intval($_POST['kelas']);
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];
$nama_file = $_FILES['file']['name'];
$tmp = $_FILES['file']['tmp_name'];

$cekRoster = mysqli_query($conn,
"SELECT id FROM roster
 WHERE id_guru='$id_guru'
   AND id_kelas='$id_kelas'
   AND id_mapel='$id_mapel'
 LIMIT 1");

if(mysqli_num_rows($cekRoster) == 0){
    header("Location: materi_add.php?error=roster");
    exit();
}

if(empty($nama_file)){
    header("Location: materi_add.php?error=file");
    exit();
}

$folder = "../../uploads/materi/";
if(!is_dir($folder)){
    mkdir($folder, 0777, true);
}
$path = $folder . time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $nama_file);

// upload file
move_uploaded_file($tmp, $path);

mysqli_query($conn,
"INSERT INTO materi (id_guru, id_mapel, judul_materi, deskripsi, file_path)
 VALUES ('$id_guru', '$id_mapel', '$judul', '$deskripsi', '$path')");
$id_materi = mysqli_insert_id($conn);

mysqli_query($conn,
"INSERT INTO materi_kelas (id_materi, id_kelas)
 VALUES ('$id_materi', '$id_kelas')");

// LOG
catat_log($conn, "Guru mengupload materi: $judul");

header("Location: materi.php");
exit();
?>
