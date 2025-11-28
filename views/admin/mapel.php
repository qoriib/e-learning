<?php
session_start();
if($_SESSION['role'] != 'admin'){
    header("Location: ../../index.php");
    exit();
}
include "../../config.php";
include "../../helpers/pagination_helper.php";
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

<?php
$importMessage = "";
$importClass = "success";
if(isset($_GET['import'])){
    if($_GET['import'] == '1'){
        $added = intval($_GET['added'] ?? 0);
        $skipped = intval($_GET['skipped'] ?? 0);
        $importMessage = "Import selesai. $added mapel ditambahkan, $skipped baris dilewati.";
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
    <h2>Data Mata Pelajaran</h2>

    <a href="mapel_add.php" class="btn">+ Tambah Mapel</a>
    <br><br>
    <?php
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $baseQuery = "SELECT * FROM mapel ORDER BY id DESC";
    $pagination = paginate_query($conn, $baseQuery, $page, 30);
    $data = $pagination['result'];
    ?>

    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Nama Mapel</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = $pagination['offset'] + 1;
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
    <?= render_pagination('mapel.php', $pagination); ?>

</div>

<div class="card import-card">
    <h3>Import Mapel via Excel</h3>
    <p>Gunakan template berikut untuk menambahkan banyak mapel sekaligus.</p>
    <a class="btn" href="../../assets/templates/mapel_template.xlsx" download>Download Template Mapel</a>
    <form class="import-form" action="mapel_import_process.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file_excel" accept=".xlsx" required>
        <button type="submit" class="btn">Upload File</button>
    </form>
</div>

</div>

</body>
</html>
