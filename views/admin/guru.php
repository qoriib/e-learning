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

<?php
$importMessage = "";
$importClass = "success";
if(isset($_GET['import'])){
    if($_GET['import'] == '1'){
        $added = intval($_GET['added'] ?? 0);
        $skipped = intval($_GET['skipped'] ?? 0);
        $importMessage = "Import selesai. $added guru ditambahkan, $skipped baris dilewati.";
        $importClass = "success";
    } else {
        $reason = $_GET['msg'] ?? 'gagal';
        $text = "Import gagal.";
        if($reason == 'no_file'){ $text = "Upload gagal: file belum dipilih."; }
        if($reason == 'format'){ $text = "Upload gagal: format file tidak valid, gunakan template .xlsx."; }
        $importMessage = $text;
        $importClass = "error";
    }
}
?>

<?php if($importMessage): ?>
<div class="alert <?= $importClass; ?>">
    <?= $importMessage; ?>
</div>
<?php endif; ?>

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

<div class="card import-card">
    <h3>Import Data Guru via Excel</h3>
    <p>Gunakan template agar kolom sesuai. File harus berformat <b>.xlsx</b>.</p>
    <a class="btn" href="../../assets/templates/guru_template.xlsx" download>Download Template Guru</a>
    <form class="import-form" action="guru_import_process.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file_excel" accept=".xlsx" required>
        <button type="submit" class="btn">Upload File</button>
    </form>
    <small>Setiap guru baru memiliki password awal <b>guru123</b>.</small>
</div>

</div>
</body>
</html>
