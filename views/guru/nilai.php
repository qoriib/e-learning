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

// ambil filter kelas & mapel
$id_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : "";
$id_mapel = isset($_GET['mapel']) ? $_GET['mapel'] : "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rekap Nilai Siswa</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Rekap Nilai Siswa</h2>

<div class="card">

<!-- FORM FILTER -->
<form method="GET" action="nilai.php">

    <label>Pilih Kelas</label>
    <select name="kelas" required onchange="this.form.submit()">
        <option value="">-- pilih kelas --</option>
        <?php
        $kelas = mysqli_query($conn,
        "SELECT DISTINCT kelas.id, kelas.nama_kelas
         FROM roster
         JOIN kelas ON roster.id_kelas = kelas.id
         WHERE roster.id_guru = '$id_guru'
         ORDER BY kelas.nama_kelas ASC");

        while($k = mysqli_fetch_assoc($kelas)){
            $sel = ($id_kelas == $k['id']) ? "selected" : "";
            echo "<option value='{$k['id']}' $sel>{$k['nama_kelas']}</option>";
        }
        ?>
    </select>

    <label>Pilih Mapel</label>
    <select name="mapel" required onchange="this.form.submit()">
        <option value="">-- pilih mapel --</option>
        <?php
        $mapel = mysqli_query($conn,
        "SELECT DISTINCT mapel.id, mapel.nama_mapel
         FROM roster
         JOIN mapel ON roster.id_mapel = mapel.id
         WHERE roster.id_guru = '$id_guru'
         ORDER BY mapel.nama_mapel ASC");

        while($m = mysqli_fetch_assoc($mapel)){
            $sel = ($id_mapel == $m['id']) ? "selected" : "";
            echo "<option value='{$m['id']}' $sel>{$m['nama_mapel']}</option>";
        }
        ?>
    </select>

</form>
</div>

<?php if($id_kelas != "" && $id_mapel != ""): ?>

<!-- TOMBOL EXPORT -->
<div class="card export-card">
    <a class="btn" href="nilai_export_excel.php?kelas=<?= $id_kelas ?>&mapel=<?= $id_mapel ?>">Download Excel</a>
    <a class="btn" href="nilai_export_csv.php?kelas=<?= $id_kelas ?>&mapel=<?= $id_mapel ?>">Download CSV</a>
</div>

<div class="card">
<h3>Nilai Siswa</h3>

<table class="tabel">
    <tr>
        <th>No</th>
        <th>NIS</th>
        <th>Nama</th>
        <th>Nilai</th>
        <th>Catatan</th>
    </tr>

<?php
$no = 1;

$q = mysqli_query($conn,
"SELECT siswa.id AS id_siswa, siswa.nis, siswa.nama_lengkap,
        (
            SELECT pt.nilai
            FROM pengumpulan_tugas pt
            JOIN tugas t2 ON t2.id = pt.id_tugas
            WHERE pt.id_siswa = siswa.id
              AND t2.id_mapel = '$id_mapel'
              AND t2.id_kelas = '$id_kelas'
            ORDER BY pt.tanggal_kumpul DESC
            LIMIT 1
        ) AS nilai,
        (
            SELECT pt.catatan_nilai
            FROM pengumpulan_tugas pt
            JOIN tugas t2 ON t2.id = pt.id_tugas
            WHERE pt.id_siswa = siswa.id
              AND t2.id_mapel = '$id_mapel'
              AND t2.id_kelas = '$id_kelas'
            ORDER BY pt.tanggal_kumpul DESC
            LIMIT 1
        ) AS catatan_nilai
 FROM siswa
 WHERE siswa.id_kelas = '$id_kelas'
 ORDER BY siswa.nama_lengkap ASC");

while($d = mysqli_fetch_assoc($q)){
?>
<tr>
    <td><?= $no++; ?></td>
    <td><?= $d['nis']; ?></td>
    <td><?= $d['nama_lengkap']; ?></td>
    <td><?= ($d['nilai'] !== null ? $d['nilai'] : "-"); ?></td>
    <td><?= ($d['catatan_nilai'] ? $d['catatan_nilai'] : "-"); ?></td>
</tr>
<?php } ?>
</table>

</div>

<?php endif; ?>

</div>

</body>
</html>
