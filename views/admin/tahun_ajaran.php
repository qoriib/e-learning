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
<title>Data Tahun Ajaran</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">

<?php include "header.php"; ?>

<div class="card">
    <h2>Data Tahun Ajaran</h2>

    <a href="tahun_ajaran_add.php" class="btn">+ Tambah Tahun Ajaran</a>
    <br><br>

    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Tahun</th>
            <th>Semester</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM tahun_ajaran ORDER BY id DESC");
        while($d = mysqli_fetch_assoc($data)){
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['tahun']; ?></td>
            <td><?= $d['semester']; ?></td>
            <td>
                <?= $d['is_active'] ? '<span style="color:green;font-weight:bold;">Aktif</span>' : 'Tidak aktif'; ?>
            </td>
            <td>
                <a href="tahun_ajaran_edit.php?id=<?= $d['id']; ?>">Edit</a> | 
                <a href="tahun_ajaran_delete.php?id=<?= $d['id']; ?>" onclick="return confirm('Hapus tahun ajaran ini?')">Hapus</a> | 
                
                <?php if(!$d['is_active']){ ?>
                    <a href="tahun_ajaran_set_active.php?id=<?= $d['id']; ?>" onclick="return confirm('Jadikan tahun ajaran aktif?')">Aktifkan</a>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>

    </table>

</div>

</div>
</body>
</html>
