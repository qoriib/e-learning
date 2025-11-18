<?php
session_start();
include "../../config.php";
include "../../log.php";

if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}

$id_kelas = $_POST['id_kelas'];
$tanggal  = $_POST['tanggal'];
$statusArr = isset($_POST['status']) ? $_POST['status'] : [];
$ketArr    = isset($_POST['keterangan']) ? $_POST['keterangan'] : [];

foreach($statusArr as $id_user => $status){
    if($status == "" || $status == null){
        // kalau kosong, skip saja
        continue;
    }
    $ket = isset($ketArr[$id_user]) ? $ketArr[$id_user] : "";

    // cek apakah sudah ada absensi untuk id_user + tanggal + siswa
    $cek = mysqli_query($conn,
        "SELECT id FROM absensi 
         WHERE id_user='$id_user' 
           AND tanggal='$tanggal' 
           AND jenis_absen='siswa'
         LIMIT 1"
    );

    if(mysqli_num_rows($cek) > 0){
        // update
        mysqli_query($conn,
            "UPDATE absensi SET 
                status='$status',
                keterangan='$ket'
             WHERE id_user='$id_user'
               AND tanggal='$tanggal'
               AND jenis_absen='siswa'"
        );
    } else {
        // insert baru
        mysqli_query($conn,
            "INSERT INTO absensi (id_user, tanggal, status, keterangan, jenis_absen)
             VALUES ('$id_user', '$tanggal', '$status', '$ket', 'siswa')"
        );
    }
}

// catat log
catat_log($conn, "Guru melakukan absensi siswa untuk kelas ID: $id_kelas pada tanggal $tanggal");

header("Location: absen_siswa.php?kelas=".$id_kelas."&success=1");
exit();
?>
