<?php
session_start();
include "../../config.php";

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM roster WHERE id='$id'");

header("Location: roster.php");
?>
