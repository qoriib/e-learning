<?php
session_start();
include "../../config.php";
include "../../log.php";
include "../../helpers/auth_helper.php";

$siswa_id = getSiswaId($conn);
if(!$siswa_id){
    header("Location: ../../index.php");
    exit();
}

$id_tugas = $_POST['id_tugas'];
$id_siswa = $_POST['id_siswa'];
if($id_siswa != $siswa_id){
    header("Location: tugas.php?error=invalid");
    exit();
}

$folder = "../../uploads/tugas_siswa/";

if(!file_exists($folder)){
    mkdir($folder, 0777, true);
}

// nama file unik
$nama_file = time() . "_" . preg_replace("/[^A-Za-z0-9._-]/", "_", $_FILES['file_tugas']['name']);
$path = $folder . $nama_file;

move_uploaded_file($_FILES['file_tugas']['tmp_name'], $path);

// simpan ke DB
mysqli_query($conn,
"INSERT INTO pengumpulan_tugas (id_tugas, id_siswa, file_path)
 VALUES ('$id_tugas', '$id_siswa', '$path')");

catat_log($conn, "Siswa upload tugas ID: $id_tugas");

header("Location: tugas.php?success=1");
exit();
?>
