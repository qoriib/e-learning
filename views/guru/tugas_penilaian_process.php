<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../log.php";
include "../../helpers/auth_helper.php";

$id_guru = getGuruId($conn);
if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}

$id_pengumpulan = $_POST['id_pengumpulan'];
$id_tugas = $_POST['id_tugas'];
$id_pengumpulan = intval($id_pengumpulan);
$id_tugas = intval($id_tugas);
$catatan = mysqli_real_escape_string($conn, trim($_POST['catatan']));

if(!$id_pengumpulan || !$id_tugas){
    header("Location: tugas.php");
    exit();
}

$nilai = $_POST['nilai'] !== '' ? intval($_POST['nilai']) : null;
$nilai = $nilai === null ? null : max(0, min(100, $nilai));

$cek = mysqli_query($conn,
"SELECT pengumpulan_tugas.id
 FROM pengumpulan_tugas
 JOIN tugas ON tugas.id = pengumpulan_tugas.id_tugas
 WHERE pengumpulan_tugas.id='$id_pengumpulan'
   AND tugas.id_guru='$id_guru'
   AND tugas.id='$id_tugas'
 LIMIT 1");

if(mysqli_num_rows($cek) == 0){
    header("Location: tugas.php");
    exit();
}

$nilaiValue = $nilai === null ? "NULL" : "'$nilai'";
mysqli_query($conn,
"UPDATE pengumpulan_tugas
 SET nilai = $nilaiValue,
     catatan_nilai = '$catatan'
 WHERE id='$id_pengumpulan'");

catat_log($conn, "Guru memberi nilai untuk tugas ID {$id_tugas}");
header("Location: tugas_kumpul.php?id=$id_tugas&success=1");
exit();
