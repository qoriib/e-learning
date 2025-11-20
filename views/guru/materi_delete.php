<?php
session_start();
include "../../config.php";
include "../../log.php";
include "../../helpers/auth_helper.php";

$id_guru = getGuruId($conn);
if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}

$id = $_GET['id'];

// ambil file
$q = mysqli_query($conn, "SELECT file_path FROM materi WHERE id='$id' AND id_guru='$id_guru'");
$d = mysqli_fetch_assoc($q);

if($d && file_exists($d['file_path'])){
    unlink($d['file_path']);
}

mysqli_query($conn, "DELETE FROM materi WHERE id='$id' AND id_guru='$id_guru'");
mysqli_query($conn, "DELETE FROM materi_kelas WHERE id_materi='$id'");

catat_log($conn, "Guru menghapus materi ID: $id");

header("Location: materi.php");
exit();
?>
