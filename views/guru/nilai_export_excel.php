<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
include "../../helpers/auth_helper.php";

$id_guru = getGuruId($conn);
if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}

$id_kelas = $_GET['kelas'];
$id_mapel = $_GET['mapel'];

$cek = mysqli_query($conn,
"SELECT id FROM roster
 WHERE id_guru='$id_guru'
   AND id_kelas='$id_kelas'
   AND id_mapel='$id_mapel'
 LIMIT 1");

if(mysqli_num_rows($cek) == 0){
    header("Location: nilai.php");
    exit();
}

$kelas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_kelas FROM kelas WHERE id='$id_kelas'"));
$mapel = mysqli_fetch_assoc(mysqli_query($conn, "SELECT nama_mapel FROM mapel WHERE id='$id_mapel'"));

$filename = "Rekap_Nilai_{$kelas['nama_kelas']}_{$mapel['nama_mapel']}.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

$data = mysqli_query($conn,
"SELECT siswa.nis, siswa.nama_lengkap,
        (
            SELECT pt.nilai
            FROM pengumpulan_tugas pt
            JOIN tugas t2 ON t2.id = pt.id_tugas
            WHERE pt.id_siswa = siswa.id
              AND t2.id_mapel = '$id_mapel'
              AND t2.id_kelas = '$id_kelas'
            ORDER BY pt.tanggal_kumpul DESC
            LIMIT 1
        ) AS nilai,
        (
            SELECT pt.catatan_nilai
            FROM pengumpulan_tugas pt
            JOIN tugas t2 ON t2.id = pt.id_tugas
            WHERE pt.id_siswa = siswa.id
              AND t2.id_mapel = '$id_mapel'
              AND t2.id_kelas = '$id_kelas'
            ORDER BY pt.tanggal_kumpul DESC
            LIMIT 1
        ) AS catatan
 FROM siswa
 WHERE siswa.id_kelas = '$id_kelas'
 ORDER BY siswa.nama_lengkap ASC");

echo "<table border='1'>";
echo "<tr><th colspan='4'>REKAP NILAI SISWA</th></tr>";
echo "<tr><td>Kelas</td><td colspan='3'>".htmlspecialchars($kelas['nama_kelas'])."</td></tr>";
echo "<tr><td>Mapel</td><td colspan='3'>".htmlspecialchars($mapel['nama_mapel'])."</td></tr>";
echo "<tr><td colspan='4'></td></tr>";
echo "<tr><th>NIS</th><th>Nama Siswa</th><th>Nilai</th><th>Catatan</th></tr>";

while($row = mysqli_fetch_assoc($data)){
    $nilai = $row['nilai'] === null ? '-' : $row['nilai'];
    $catatan = $row['catatan'] ? $row['catatan'] : '-';
    echo "<tr>";
    echo "<td>".htmlspecialchars($row['nis'])."</td>";
    echo "<td>".htmlspecialchars($row['nama_lengkap'])."</td>";
    echo "<td>{$nilai}</td>";
    echo "<td>".htmlspecialchars($catatan)."</td>";
    echo "</tr>";
}
echo "</table>";
exit();
