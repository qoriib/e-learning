<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../log.php";
require_once "../../lib/SimpleXLSX.php";

if(empty($_FILES['file_excel']['name'])){
    header("Location: mapel.php?import=0&msg=no_file");
    exit();
}

$tmp = $_FILES['file_excel']['tmp_name'];
$xlsx = \Shuchkin\SimpleXLSX::parse($tmp);
if(!$xlsx){
    header("Location: mapel.php?import=0&msg=format");
    exit();
}

$rows = $xlsx->rows();
$added = 0;
$skipped = 0;

foreach($rows as $index => $row){
    if($index === 0){
        continue;
    }

    $nama_mapel = mysqli_real_escape_string($conn, trim($row[0] ?? ''));
    if($nama_mapel === ''){
        $skipped++;
        continue;
    }

    $cek = mysqli_query($conn, "SELECT id FROM mapel WHERE nama_mapel='$nama_mapel' LIMIT 1");
    if(mysqli_num_rows($cek) > 0){
        $skipped++;
        continue;
    }

    mysqli_query($conn, "INSERT INTO mapel (nama_mapel) VALUES ('$nama_mapel')");
    if(mysqli_affected_rows($conn) > 0){
        $added++;
    } else {
        $skipped++;
    }
}

catat_log($conn, "Admin import data mapel ($added berhasil, $skipped dilewati)");
header("Location: mapel.php?import=1&added=$added&skipped=$skipped");
exit();
