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
<title>Data Kelas</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">

<?php include "header.php"; ?>

<div class="card">
    <h2>Data Kelas</h2>

    <a href="kelas_add.php" class="btn">+ Tambah Kelas</a>
    <br><br>

    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Nama Kelas</th>
            <th>Tahun Ajaran</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($conn, 
            "SELECT kelas.*, tahun_ajaran.tahun, tahun_ajaran.semester
             FROM kelas
             JOIN tahun_ajaran ON kelas.id_tahun_ajaran = tahun_ajaran.id
             ORDER BY kelas.id DESC"
        );
        while($d = mysqli_fetch_assoc($data)){
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nama_kelas']; ?></td>
            <td><?= $d['tahun'].' ('.$d['semester'].')'; ?></td>
            <td>
                <a href="kelas_edit.php?id=<?= $d['id']; ?>">Edit</a> |
                <a href="kelas_delete.php?id=<?= $d['id']; ?>" onclick="return confirm('Hapus kelas ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>

    </table>

</div>

</div>
</body>
</html>
