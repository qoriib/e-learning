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
<title>Data Siswa</title>
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
        $importMessage = "Import selesai. $added siswa ditambahkan, $skipped baris dilewati.";
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

<?php
$search = trim($_GET['q'] ?? '');
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$where = "";
if($search !== ''){
    $like = mysqli_real_escape_string($conn, "%".$search."%");
    $where = "WHERE siswa.nama_lengkap LIKE '$like' OR siswa.nis LIKE '$like'";
}
$baseQuery = "SELECT siswa.*, kelas.nama_kelas, users.username 
              FROM siswa 
              JOIN kelas ON siswa.id_kelas = kelas.id 
              LEFT JOIN users ON users.id_siswa = siswa.id
              $where
              ORDER BY siswa.id DESC";

if(isset($_GET['download']) && $_GET['download'] == '1'){
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="data_siswa.csv"');
    $downloadRes = mysqli_query($conn, $baseQuery);
    $out = fopen('php://output', 'w');
    fputcsv($out, ['NIS','Nama','Email','No Telp','Kelas','Username']);
    while($row = mysqli_fetch_assoc($downloadRes)){
        fputcsv($out, [$row['nis'],$row['nama_lengkap'],$row['email'],$row['no_telp'],$row['nama_kelas'],$row['username']]);
    }
    fclose($out);
    exit();
}

$pagination = paginate_query($conn, $baseQuery, $page, 30);
$data = $pagination['result'];
?>

<div class="card">
    <h2>Data Siswa</h2>

    <div class="table-toolbar">
        <a href="siswa_add.php" class="btn">+ Tambah Siswa</a>
        <form method="GET" style="display:flex;gap:8px;align-items:center;">
            <input type="text" name="q" placeholder="Cari nama/NIS..." value="<?= htmlspecialchars($search); ?>">
            <button type="submit" class="btn">Cari</button>
        </form>
        <a class="btn" href="siswa.php?download=1<?= $search ? '&q='.urlencode($search) : ''; ?>">Download Data</a>
    </div>

    <table class="tabel">
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Email</th>
            <th>No Telp</th>
            <th>Kelas</th>
            <th>Username</th>
            <th>Aksi</th>
        </tr>

        <?php
        $no = $pagination['offset'] + 1;

        while($d = mysqli_fetch_assoc($data)){
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nis']; ?></td>
            <td><?= $d['nama_lengkap']; ?></td>
            <td><?= $d['email']; ?></td>
            <td><?= $d['no_telp']; ?></td>
            <td><?= $d['nama_kelas']; ?></td>
            <td><?= $d['username']; ?></td>
            <td>
                <a href="siswa_edit.php?id=<?= $d['id']; ?>">Edit</a> |
                <a href="siswa_delete.php?id=<?= $d['id']; ?>" onclick="return confirm('Hapus siswa ini?')">Hapus</a>
            </td>
        </tr>
        <?php } ?>
    </table>
    <?= render_pagination('siswa.php', $pagination, $search ? ['q'=>$search] : []); ?>

</div>

<div class="card import-card">
    <h3>Import Data Siswa via Excel</h3>
    <p>Setiap baris wajib memiliki Username, NIS, dan ID Kelas.</p>
    <a class="btn" href="../../assets/templates/siswa_template.xlsx" download>Download Template Siswa</a>
    <form class="import-form" action="siswa_import_process.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file_excel" accept=".xlsx" required>
        <button type="submit" class="btn">Upload File</button>
    </form>
    <small>Password awal siswa otomatis <b>siswa123</b>.</small>
</div>

</div>
</body>
</html>
