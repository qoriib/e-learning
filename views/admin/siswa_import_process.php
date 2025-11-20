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
    header("Location: siswa.php?import=0&msg=no_file");
    exit();
}

$tmp = $_FILES['file_excel']['tmp_name'];
$xlsx = \Shuchkin\SimpleXLSX::parse($tmp);
if(!$xlsx){
    header("Location: siswa.php?import=0&msg=format");
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
    $nis      = mysqli_real_escape_string($conn, trim($row[1] ?? ''));
    $nama     = mysqli_real_escape_string($conn, trim($row[2] ?? ''));
    $email    = mysqli_real_escape_string($conn, trim($row[3] ?? ''));
    $telp     = mysqli_real_escape_string($conn, trim($row[4] ?? ''));
    $idKelasRaw = trim($row[5] ?? '');
    $id_kelas = $idKelasRaw === '' ? null : (int)$idKelasRaw;

    if($id_kelas !== null){
        $kelasCheck = mysqli_query($conn, "SELECT id FROM kelas WHERE id='$id_kelas' LIMIT 1");
        if(mysqli_num_rows($kelasCheck) === 0){
            $id_kelas = null;
        }
    }

    if($username === '' || $nis === '' || $nama === '' || $id_kelas === null){
        $skipped++;
        continue;
    }

    $cekSiswa = mysqli_query($conn, "SELECT id FROM siswa WHERE nis='$nis' LIMIT 1");
    $cekUser = mysqli_query($conn, "SELECT id FROM users WHERE username='$username' LIMIT 1");
    if(mysqli_num_rows($cekSiswa) > 0 || mysqli_num_rows($cekUser) > 0){
        $skipped++;
        continue;
    }

    mysqli_query($conn,
    "INSERT INTO siswa (nis, nama_lengkap, email, no_telp, id_kelas)
     VALUES ('$nis', '$nama', '$email', '$telp', '$id_kelas')");
    $id_siswa = mysqli_insert_id($conn);

    if($id_siswa){
        $password = password_hash('siswa123', PASSWORD_DEFAULT);
        mysqli_query($conn,
        "INSERT INTO users (username, password, role, id_siswa, status)
         VALUES ('$username', '$password', 'siswa', '$id_siswa', 'aktif')");
        $added++;
    } else {
        $skipped++;
    }
}

catat_log($conn, "Admin import data siswa ($added berhasil, $skipped dilewati)");
header("Location: siswa.php?import=1&added=$added&skipped=$skipped");
exit();
