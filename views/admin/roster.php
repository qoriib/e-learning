<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}
include "../../config.php";
?>

<!DOCTYPE html>
<html>
<head>
<title>Roster Pelajaran</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Roster Pelajaran</h2>

    <a href="roster_add.php" class="btn">+ Tambah Jadwal</a>
    <br><br>

    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Kelas</th>
            <th>Mapel</th>
            <th>Guru</th>
            <th>Hari</th>
            <th>Jam Mulai</th>
            <th>Jam Selesai</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($conn,
            "SELECT roster.*, kelas.nama_kelas, mapel.nama_mapel, guru.nama_lengkap 
             FROM roster
             JOIN kelas ON roster.id_kelas = kelas.id
             JOIN mapel ON roster.id_mapel = mapel.id
             JOIN guru ON roster.id_guru = guru.id
             ORDER BY roster.hari, roster.jam_mulai"
        );

        while($d = mysqli_fetch_assoc($data)){
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nama_kelas']; ?></td>
            <td><?= $d['nama_mapel']; ?></td>
            <td><?= $d['nama_lengkap']; ?></td>
            <td><?= $d['hari']; ?></td>
            <td><?= $d['jam_mulai']; ?></td>
            <td><?= $d['jam_selesai']; ?></td>
            <td>
                <a href="roster_edit.php?id=<?= $d['id']; ?>">Edit</a> |
                <a href="roster_delete.php?id=<?= $d['id']; ?>" onclick="return confirm('Hapus jadwal ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>

    </table>

</div>

</div>

</body>
</html>
