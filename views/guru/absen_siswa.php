<?php
session_start();
if($_SESSION['role'] != 'guru'){
    header("Location: ../../index.php");
    exit();
}

include "../../config.php";
$id_user = $_SESSION['id'];
include "../../helpers/auth_helper.php";
$id_guru = getGuruId($conn);
if(!$id_guru){
    header("Location: ../../index.php");
    exit();
}

$tanggal = date("Y-m-d");
$rekap_tanggal = isset($_GET['rekap_tanggal']) ? $_GET['rekap_tanggal'] : $tanggal;

// ambil kelas dari GET (jika ada)
$id_kelas = isset($_GET['kelas']) ? $_GET['kelas'] : "";

?>

<!DOCTYPE html>
<html>
<head>
    <title>Absensi Siswa</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

    <h2>Absensi Siswa</h2>

    <div class="card">
        <form method="GET" action="absen_siswa.php">
            <label>Pilih Kelas</label>
            <input type="hidden" name="rekap_tanggal" value="<?= $rekap_tanggal; ?>">
            <select name="kelas" onchange="this.form.submit()">
                <option value="">-- Pilih Kelas --</option>
                <?php
                $kelas_q = mysqli_query($conn,
                "SELECT DISTINCT kelas.*
                 FROM roster
                 JOIN kelas ON roster.id_kelas = kelas.id
                 WHERE roster.id_guru = '$id_guru'
                 ORDER BY kelas.nama_kelas ASC");
                while($k = mysqli_fetch_assoc($kelas_q)){
                    $sel = ($id_kelas == $k['id']) ? "selected" : "";
                    echo "<option value='".$k['id']."' $sel>".$k['nama_kelas']."</option>";
                }
                ?>
            </select>
        </form>
    </div>

    <?php if($id_kelas != ""): ?>

    <div class="card">
        <h3>Absensi Siswa Tanggal <?= $tanggal; ?></h3>

        <?php if(isset($_GET['success'])): ?>
            <p style="color:green;">Absensi siswa berhasil disimpan.</p>
        <?php endif; ?>

        <form action="absen_siswa_process.php" method="POST">

            <input type="hidden" name="id_kelas" value="<?= $id_kelas; ?>">
            <input type="hidden" name="tanggal" value="<?= $tanggal; ?>">

            <table class="tabel">
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                </tr>

                <?php
                $no = 1;
                // join siswa + users + absensi utk tanggal ini
                $data = mysqli_query($conn,
                    "SELECT s.id AS id_siswa, s.nis, s.nama_lengkap,
                            u.id AS id_user,
                            a.status AS status_absen,
                            a.keterangan AS ket_absen
                     FROM siswa s
                     JOIN users u ON u.id_siswa = s.id
                     LEFT JOIN absensi a 
                        ON a.id_user = u.id 
                       AND a.tanggal = '$tanggal' 
                       AND a.jenis_absen = 'siswa'
                     WHERE s.id_kelas = '$id_kelas'
                     ORDER BY s.nama_lengkap ASC"
                );

                while($d = mysqli_fetch_assoc($data)){
                    $id_user = $d['id_user'];
                    $status_now = $d['status_absen']; // bisa null kalau belum pernah absen
                    $ket_now = $d['ket_absen'];
                ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $d['nis']; ?></td>
                    <td><?= $d['nama_lengkap']; ?></td>
                    <td>
                        <select name="status[<?= $id_user; ?>]">
                            <option value="">- pilih -</option>
                            <option value="Hadir" <?= ($status_now=='Hadir'?'selected':''); ?>>Hadir</option>
                            <option value="Sakit" <?= ($status_now=='Sakit'?'selected':''); ?>>Sakit</option>
                            <option value="Izin"  <?= ($status_now=='Izin' ?'selected':''); ?>>Izin</option>
                            <option value="Alpa"  <?= ($status_now=='Alpa' ?'selected':''); ?>>Alpa</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" 
                               name="keterangan[<?= $id_user; ?>]" 
                               value="<?= htmlspecialchars($ket_now ?? ''); ?>">
                    </td>
                </tr>
                <?php } ?>
            </table>

            <br>
            <button type="submit" class="btn">Simpan Absensi</button>
        </form>

    </div>

    <div class="card">
        <h3>Rekap Riwayat Absensi Siswa</h3>
        <form method="GET" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
            <input type="hidden" name="kelas" value="<?= $id_kelas; ?>">
            <div>
                <label>Tanggal</label>
                <input type="date" name="rekap_tanggal" value="<?= $rekap_tanggal; ?>">
            </div>
            <button type="submit" class="btn">Tampilkan</button>
        </form>
        <table class="tabel">
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Keterangan</th>
            </tr>
            <?php
            $rekapQuery = mysqli_query($conn,
                "SELECT s.nis, s.nama_lengkap, a.status, a.keterangan
                 FROM siswa s
                 JOIN users u ON u.id_siswa = s.id
                 LEFT JOIN absensi a
                    ON a.id_user = u.id
                   AND a.tanggal = '$rekap_tanggal'
                   AND a.jenis_absen = 'siswa'
                 WHERE s.id_kelas = '$id_kelas'
                 ORDER BY s.nama_lengkap ASC");
            $no = 1;
            while($rekap = mysqli_fetch_assoc($rekapQuery)){
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $rekap['nis']; ?></td>
                <td><?= $rekap['nama_lengkap']; ?></td>
                <td><?= $rekap['status'] ?? '-'; ?></td>
                <td><?= $rekap['keterangan'] ?? '-'; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <?php endif; ?>

</div>

</body>
</html>
