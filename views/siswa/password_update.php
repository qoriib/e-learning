<?php
session_start();
include "../../config.php";

$id_user = $_SESSION['id'];

$p1 = $_POST['password1'];
$p2 = $_POST['password2'];

if($p1 != $p2){
    header("Location: password_edit.php?error=1");
    exit();
}

$hash = password_hash($p1, PASSWORD_DEFAULT);

mysqli_query($conn,
"UPDATE users 
 SET password='$hash'
 WHERE id='$id_user'");

header("Location: profil.php?pw=success");
exit();
?>
