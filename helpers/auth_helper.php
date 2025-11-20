<?php

function getGuruId(mysqli $conn){
    if(isset($_SESSION['guru_id']) && $_SESSION['guru_id']){
        return $_SESSION['guru_id'];
    }

    if(!isset($_SESSION['id'])){
        return null;
    }

    $userId = $_SESSION['id'];
    $result = mysqli_query($conn, "SELECT id_guru FROM users WHERE id='$userId' LIMIT 1");
    if($result && $row = mysqli_fetch_assoc($result)){
        $_SESSION['guru_id'] = $row['id_guru'];
        return $row['id_guru'];
    }

    return null;
}

function getSiswaId(mysqli $conn){
    if(isset($_SESSION['siswa_id']) && $_SESSION['siswa_id']){
        return $_SESSION['siswa_id'];
    }

    if(!isset($_SESSION['id'])){
        return null;
    }

    $userId = $_SESSION['id'];
    $result = mysqli_query($conn, "SELECT id_siswa FROM users WHERE id='$userId' LIMIT 1");
    if($result && $row = mysqli_fetch_assoc($result)){
        $_SESSION['siswa_id'] = $row['id_siswa'];
        return $row['id_siswa'];
    }

    return null;
}
