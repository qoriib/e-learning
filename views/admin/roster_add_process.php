<?php
session_start();
include "../../config.php";

$kelas  = $_POST['kelas'];
$mapel  = $_POST['mapel'];
$guru   = $_POST['guru'];
$hari   = $_POST['hari'];
$mulai  = $_POST['jam_mulai'];
$selesai= $_POST['jam_selesai'];

// simpan ke database
mysqli_query($conn,
    "INSERT INTO roster (id_kelas, id_mapel, id_guru, hari, jam_mulai, jam_selesai)
     VALUES ('$kelas', '$mapel', '$guru', '$hari', '$mulai', '$selesai')"
);

header("Location: roster.php");
?>
