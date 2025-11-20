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
    header("Location: guru.php?import=0&msg=no_file");
    exit();
}

$tmp = $_FILES['file_excel']['tmp_name'];
$xlsx = \Shuchkin\SimpleXLSX::parse($tmp);
if(!$xlsx){
    header("Location: guru.php?import=0&msg=format");
    exit();
}

$rows = $xlsx->rows();
$added = 0;
$skipped = 0;

foreach($rows as $index => $row){
    if($index === 0){
        continue;
    }

    $username = mysqli_real_escape_string($conn, trim($row[0] ?? ''));
    $nip      = mysqli_real_escape_string($conn, trim($row[1] ?? ''));
    $nama     = mysqli_real_escape_string($conn, trim($row[2] ?? ''));
    $email    = mysqli_real_escape_string($conn, trim($row[3] ?? ''));
    $telp     = mysqli_real_escape_string($conn, trim($row[4] ?? ''));
    $kelasWaliRaw = trim($row[5] ?? '');
    $kelasWali = $kelasWaliRaw === '' ? null : (int)$kelasWaliRaw;

    if($kelasWali !== null){
        $kelasCheck = mysqli_query($conn, "SELECT id FROM kelas WHERE id='$kelasWali' LIMIT 1");
        if(mysqli_num_rows($kelasCheck) === 0){
            $kelasWali = null;
        }
    }

    if($username === '' || $nip === '' || $nama === ''){
        $skipped++;
        continue;
    }

    $cekGuru = mysqli_query($conn, "SELECT id FROM guru WHERE nip='$nip' LIMIT 1");
    $cekUser = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' LIMIT 1");
    if(mysqli_num_rows($cekGuru) > 0 || mysqli_num_rows($cekUser) > 0){
        $skipped++;
        continue;
    }

    $kelasValue = $kelasWali === null ? "NULL" : "'" . mysqli_real_escape_string($conn, (string)$kelasWali) . "'";
    mysqli_query($conn,
    "INSERT INTO guru (nip, nama_lengkap, email, no_telp, id_kelas_wali)
     VALUES ('$nip', '$nama', '$email', '$telp', $kelasValue)");
    $id_guru = mysqli_insert_id($conn);

    if($id_guru){
        $password = password_hash('guru123', PASSWORD_DEFAULT);
        mysqli_query($conn,
        "INSERT INTO users (username, password, role, id_guru, status)
         VALUES ('$username', '$password', 'guru', '$id_guru', 'aktif')");
        $added++;
    } else {
        $skipped++;
    }
}

catat_log($conn, "Admin import data guru ($added berhasil, $skipped dilewati)");
header("Location: guru.php?import=1&added=$added&skipped=$skipped");
exit();
