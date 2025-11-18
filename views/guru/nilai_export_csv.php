<?php
include "../../config.php";

$id_kelas = $_GET['kelas'];
$id_mapel = $_GET['mapel'];

// ambil info kelas & mapel
$kelas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_kelas FROM kelas WHERE id='$id_kelas'"));
$mapel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_mapel FROM mapel WHERE id='$id_mapel'"));

// nama file otomatis
$filename = "Rekap_Nilai_Kelas_{$kelas['nama_kelas']}_Mapel_{$mapel['nama_mapel']}.csv";

// header agar browser download file
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$filename\"");

// buka output
$output = fopen("php://output", "w");

// -------------------------------------------------------
// 1. TULIS JUDUL
// -------------------------------------------------------
fputcsv($output, ["REKAP NILAI SISWA"]);
fputcsv($output, ["Kelas", $kelas['nama_kelas']]);
fputcsv($output, ["Mapel", $mapel['nama_mapel']]);
fputcsv($output, []); // baris kosong

// -------------------------------------------------------
// 2. HEADER TABEL
// -------------------------------------------------------
fputcsv($output, ["NIS", "Nama Siswa", "Nilai", "Status"]);

// -------------------------------------------------------
// 3. AMBIL DATA SISWA + NILAI
// -------------------------------------------------------
$q = mysqli_query($conn,
"SELECT siswa.nis, siswa.nama_lengkap, pengumpulan_tugas.nilai
 FROM siswa
 LEFT JOIN pengumpulan_tugas 
        ON pengumpulan_tugas.id_siswa = siswa.id
 LEFT JOIN tugas 
        ON tugas.id = pengumpulan_tugas.id_tugas
 WHERE siswa.id_kelas = '$id_kelas'
   AND tugas.id_mapel = '$id_mapel'
 ORDER BY siswa.nama_lengkap ASC"
);

// -------------------------------------------------------
// 4. TULIS DATA PER BARIS
// -------------------------------------------------------
while($d = mysqli_fetch_assoc($q)){
    $nilai = $d['nilai'] === null ? "-" : $d['nilai'];
    $status = $d['nilai'] === null ? "Belum Mengumpulkan" : "Selesai";

    fputcsv($output, [
        $d['nis'],
        $d['nama_lengkap'],
        $nilai,
        $status
    ]);
}

fclose($output);
exit();
?>
