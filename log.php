<?php
function catat_log($conn, $aktivitas){

    if(!isset($_SESSION['id']) || !isset($_SESSION['role'])){
        return;
    }

    $id_user = $_SESSION['id'];
    $role = $_SESSION['role'];

    mysqli_query($conn, 
        "INSERT INTO log_aktivitas (id_user, role, aktivitas) 
         VALUES ('$id_user', '$role', '$aktivitas')"
    );
}
?>
