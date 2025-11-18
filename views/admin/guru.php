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
<title>Data Guru</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Data Guru</h2>

    <a href="guru_add.php" class="btn">+ Tambah Guru</a>
    <br><br>

    <table class="tabel">
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;
        $data = mysqli_query($conn, "SELECT * FROM guru ORDER BY id DESC");
        while($d = mysqli_fetch_assoc($data)){
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nip']; ?></td>
            <td><?= $d['nama_lengkap']; ?></td>
            <td><?= $d['email']; ?></td>
            <td><?= $d['no_telp']; ?></td>
            <td>
                <a href="guru_edit.php?id=<?= $d['id']; ?>">Edit</a> |
                <a href="guru_delete.php?id=<?= $d['id']; ?>" onclick="return confirm('Hapus guru ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

</div>

</div>
</body>
</html>
