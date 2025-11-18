<?php
session_start();
include "config.php";
include "log.php";

// catat log dulu sebelum session dihancurkan
catat_log($conn, "Logout dari sistem oleh user: " . $_SESSION['username']);

// setelah log dicatat, baru hancurkan session
session_destroy();

// redirect
header("Location: index.php");
exit();
?>
