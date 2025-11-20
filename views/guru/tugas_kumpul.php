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

$id_tugas = isset($_GET['id']) ? intval($_GET['id']) : 0;
if(!$id_tugas){
    header("Location: tugas.php");
    exit();
}
$tugas = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT tugas.*, kelas.nama_kelas, mapel.nama_mapel
 FROM tugas
 JOIN kelas ON tugas.id_kelas = kelas.id
 JOIN mapel ON tugas.id_mapel = mapel.id
 WHERE tugas.id='$id_tugas' AND tugas.id_guru='$id_guru'"));

if(!$tugas){
    header("Location: tugas.php");
    exit();
}

$submissions = mysqli_query($conn,
"SELECT pengumpulan_tugas.*, siswa.nis, siswa.nama_lengkap
 FROM pengumpulan_tugas
 JOIN siswa ON pengumpulan_tugas.id_siswa = siswa.id
 WHERE pengumpulan_tugas.id_tugas = '$id_tugas'
 ORDER BY pengumpulan_tugas.tanggal_kumpul DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pengumpulan Tugas</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<div class="card">
    <h2>Pengumpulan - <?= $tugas['judul_tugas']; ?></h2>
    <p>Kelas: <?= $tugas['nama_kelas']; ?> | Mapel: <?= $tugas['nama_mapel']; ?></p>
    <p>Deadline: <?= $tugas['deadline']; ?></p>
</div>

<?php if(isset($_GET['success'])): ?>
<div class="alert success">Nilai berhasil diperbarui.</div>
<?php endif; ?>

<div class="card">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama</th>
            <th>File</th>
            <th>Nilai</th>
            <th>Catatan</th>
            <th>Aksi</th>
        </tr>
        <?php if(mysqli_num_rows($submissions) == 0): ?>
        <tr>
            <td colspan="7" style="text-align:center;">Belum ada pengumpulan.</td>
        </tr>
        <?php else: $no=1; while($row = mysqli_fetch_assoc($submissions)){ ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nis']; ?></td>
            <td><?= $row['nama_lengkap']; ?></td>
            <td><a href="../../<?= $row['file_path']; ?>" target="_blank">Download</a></td>
            <td><?= $row['nilai'] !== null ? $row['nilai'] : '-'; ?></td>
            <td><?= $row['catatan_nilai'] ? $row['catatan_nilai'] : '-'; ?></td>
            <td>
                <form class="nilai-form" action="tugas_penilaian_process.php" method="POST">
                    <input type="hidden" name="id_pengumpulan" value="<?= $row['id']; ?>">
                    <input type="hidden" name="id_tugas" value="<?= $id_tugas; ?>">
                    <input type="number" name="nilai" min="0" max="100" placeholder="Nilai" value="<?= $row['nilai'] !== null ? $row['nilai'] : ''; ?>">
                    <input type="text" name="catatan" placeholder="Catatan" value="<?= $row['catatan_nilai']; ?>">
                    <button type="submit" class="btn btn-sm">Simpan</button>
                </form>
            </td>
        </tr>
        <?php } endif; ?>
    </table>
</div>

<a href="tugas.php" class="btn">Kembali</a>

</div>
</body>
</html>
