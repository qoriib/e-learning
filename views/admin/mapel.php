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
<title>Data Mata Pelajaran</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>

<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Data Mata Pelajaran</h2>

    <a href="mapel_add.php" class="btn">+ Tambah Mapel</a>
    <br><br>

    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Nama Mapel</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM mapel ORDER BY id DESC");
        while($d = mysqli_fetch_assoc($data)){
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nama_mapel']; ?></td>
            <td>
                <a href="mapel_edit.php?id=<?= $d['id']; ?>">Edit</a> |
                <a href="mapel_delete.php?id=<?= $d['id']; ?>" onclick="return confirm('Hapus mapel ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

</div>

</div>

</body>
</html>
