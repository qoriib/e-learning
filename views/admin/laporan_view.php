<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

mysqli_query($conn, "UPDATE laporan SET status='dibaca' WHERE id='$id'");

header("Location: laporan.php");
?>
