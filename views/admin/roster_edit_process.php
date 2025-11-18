<?php
session_start();
include "../../config.php";

$id = $_POST['id'];
$kelas = $_POST['kelas'];
$mapel = $_POST['mapel'];
$guru = $_POST['guru'];
$hari = $_POST['hari'];
$mulai = $_POST['jam_mulai'];
$selesai = $_POST['jam_selesai'];

mysqli_query($conn,
    "UPDATE roster SET
        id_kelas='$kelas',
        id_mapel='$mapel',
        id_guru='$guru',
        hari='$hari',
        jam_mulai='$mulai',
        jam_selesai='$selesai'
     WHERE id='$id'"
);

header("Location: roster.php");
?>
