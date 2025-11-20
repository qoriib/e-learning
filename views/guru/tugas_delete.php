<?php
session_start();
include "../../config.php";
include "../../log.php";
include "../../helpers/auth_helper.php";

$id = $_GET['id'];
$id_guru = getGuruId($conn);
if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}

$q = mysqli_query($conn, "SELECT file_path FROM tugas WHERE id='$id' AND id_guru='$id_guru'");
$d = mysqli_fetch_assoc($q);

if($d && $d['file_path'] && file_exists($d['file_path'])){
    unlink($d['file_path']);
}

mysqli_query($conn, "DELETE FROM tugas WHERE id='$id' AND id_guru='$id_guru'");

catat_log($conn, "Guru menghapus tugas ID: $id");

header("Location: tugas.php");
exit();
?>
