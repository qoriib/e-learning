<?php
session_start();
include "../../config.php";
include "../../log.php";

$id_tugas = $_POST['id_tugas'];
$id_siswa = $_POST['id_siswa'];

$folder = "../../uploads/tugas_siswa/";

if(!file_exists($folder)){
    mkdir($folder, 0777, true);
}

// nama file unik
$nama_file = time() . "_" . $_FILES['file_tugas']['name'];
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
