<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

$d = mysqli_fetch_assoc(mysqli_query($conn, 
    "SELECT file_path FROM laporan WHERE id='$id'"
));

if(file_exists($d['file_path'])){
    unlink($d['file_path']);
}

mysqli_query($conn, "DELETE FROM laporan WHERE id='$id'");

header("Location: laporan.php");
?>
