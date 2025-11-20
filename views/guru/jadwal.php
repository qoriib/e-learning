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

$jadwal = mysqli_query($conn,
"SELECT roster.*, kelas.nama_kelas, mapel.nama_mapel
 FROM roster
 JOIN kelas ON roster.id_kelas = kelas.id
 JOIN mapel ON roster.id_mapel = mapel.id
 WHERE roster.id_guru = '$id_guru'
 ORDER BY FIELD(roster.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), roster.jam_mulai");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Roster Mengajar</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Roster Mengajar</h2>

<div class="card">
<table class="tabel">
    <tr>
        <th>Hari</th>
        <th>Jam</th>
        <th>Kelas</th>
        <th>Mata Pelajaran</th>
    </tr>
    <?php while($r = mysqli_fetch_assoc($jadwal)){ ?>
    <tr>
        <td><?= $r['hari']; ?></td>
        <td><?= substr($r['jam_mulai'],0,5); ?> - <?= substr($r['jam_selesai'],0,5); ?></td>
        <td><?= $r['nama_kelas']; ?></td>
        <td><?= $r['nama_mapel']; ?></td>
    </tr>
    <?php } ?>
</table>
</div>

</div>
</body>
</html>
