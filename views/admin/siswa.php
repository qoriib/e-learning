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
<title>Data Siswa</title>
<link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Data Siswa</h2>

    <a href="siswa_add.php" class="btn">+ Tambah Siswa</a>
    <br><br>

    <table class="tabel">
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Kelas</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = 1;

        $data = mysqli_query($conn, 
            "SELECT siswa.*, kelas.nama_kelas 
             FROM siswa 
             JOIN kelas ON siswa.id_kelas = kelas.id 
             ORDER BY siswa.id DESC"
        );

        while($d = mysqli_fetch_assoc($data)){
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nis']; ?></td>
            <td><?= $d['nama_lengkap']; ?></td>
            <td><?= $d['email']; ?></td>
            <td><?= $d['no_telp']; ?></td>
            <td><?= $d['nama_kelas']; ?></td>
            <td>
                <a href="siswa_edit.php?id=<?= $d['id']; ?>">Edit</a> |
                <a href="siswa_delete.php?id=<?= $d['id']; ?>" onclick="return confirm('Hapus siswa ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>

</div>

</div>
</body>
</html>
