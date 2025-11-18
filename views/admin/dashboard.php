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
    <title>Dashboard Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body>

<?php include "sidebar.php"; ?>
<div class="content">
<?php include "header.php"; ?>

<h2>Dashboard Statistik Admin</h2>

<div class="grid-4">

<!-- TOTAL GURU -->
<div class="stat-card">
    <h3>Guru</h3>
    <p>
        <?php 
        echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM guru"));
        ?>
    </p>
</div>

<!-- TOTAL SISWA -->
<div class="stat-card">
    <h3>Siswa</h3>
    <p>
        <?php 
        echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM siswa"));
        ?>
    </p>
</div>

<!-- TOTAL KELAS -->
<div class="stat-card">
    <h3>Kelas</h3>
    <p>
        <?php 
        echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM kelas"));
        ?>
    </p>
</div>

<!-- TOTAL MAPEL -->
<div class="stat-card">
    <h3>Mapel</h3>
    <p>
        <?php 
        echo mysqli_num_rows(mysqli_query($conn, "SELECT id FROM mapel"));
        ?>
    </p>
</div>

</div>

<br><br>

<!-- ======================= GRAFIK ABSENSI ======================= -->
<h3>Grafik Absensi Siswa</h3>
<canvas id="absensiChart"></canvas>

<?php
$q_absen = mysqli_query($conn,
"SELECT status, COUNT(*) AS total
 FROM absensi
 WHERE jenis_absen='siswa'
 GROUP BY status");

$absensi_label = [];
$absensi_total = [];

while($r = mysqli_fetch_assoc($q_absen)){
    $absensi_label[] = $r['status'];
    $absensi_total[] = $r['total'];
}
?>

<script>
var ctx = document.getElementById("absensiChart").getContext("2d");
new Chart(ctx, {
    type: "pie",
    data: {
        labels: <?= json_encode($absensi_label); ?>,
        datasets: [{
            data: <?= json_encode($absensi_total); ?>,
            backgroundColor: ["#2ecc71","#3498db","#f1c40f","#e74c3c"]
        }]
    }
});
</script>

<br><br>

<!-- ======================= GRAFIK TUGAS ======================= -->
<h3>Grafik Jumlah Tugas per Mapel</h3>
<canvas id="tugasChart"></canvas>

<?php
$q_tugas = mysqli_query($conn,
"SELECT mapel.nama_mapel, COUNT(tugas.id) AS total
 FROM tugas
 JOIN mapel ON tugas.id_mapel = mapel.id
 GROUP BY tugas.id_mapel");

$tugas_label = [];
$tugas_total = [];

while($t = mysqli_fetch_assoc($q_tugas)){
    $tugas_label[] = $t['nama_mapel'];
    $tugas_total[] = $t['total'];
}
?>

<script>
var ctx2 = document.getElementById("tugasChart").getContext("2d");
new Chart(ctx2, {
    type: "bar",
    data: {
        labels: <?= json_encode($tugas_label); ?>,
        datasets: [{
            label: "Jumlah Tugas",
            data: <?= json_encode($tugas_total); ?>,
            backgroundColor: "#3498db"
        }]
    }
});
</script>

<br><br>

<!-- ======================= GRAFIK MATERI ======================= -->
<h3>Grafik Jumlah Materi per Mapel</h3>
<canvas id="materiChart"></canvas>

<?php
$q_materi = mysqli_query($conn,
"SELECT mapel.nama_mapel, COUNT(materi.id) AS total
 FROM materi
 JOIN mapel ON materi.id_mapel = mapel.id
 GROUP BY materi.id_mapel");

$materi_label = [];
$materi_total = [];

while($m = mysqli_fetch_assoc($q_materi)){
    $materi_label[] = $m['nama_mapel'];
    $materi_total[] = $m['total'];
}
?>

<script>
var ctx3 = document.getElementById("materiChart").getContext("2d");
new Chart(ctx3, {
    type: "bar",
    data: {
        labels: <?= json_encode($materi_label); ?>,
        datasets: [{
            label: "Jumlah Materi",
            data: <?= json_encode($materi_total); ?>,
            backgroundColor: "#9b59b6"
        }]
    }
});
</script>

<br><br>

<!-- ======================= GRAFIK NILAI ======================= -->
<h3>Grafik Rata-Rata Nilai per Mapel</h3>
<canvas id="nilaiChart"></canvas>

<?php
$q_nilai = mysqli_query($conn,
"SELECT mapel.nama_mapel, AVG(pengumpulan_tugas.nilai) AS rata
 FROM pengumpulan_tugas
 JOIN tugas ON tugas.id = pengumpulan_tugas.id_tugas
 JOIN mapel ON mapel.id = tugas.id_mapel
 WHERE pengumpulan_tugas.nilai IS NOT NULL
 GROUP BY tugas.id_mapel");

$nilai_label = [];
$nilai_total = [];

while($n = mysqli_fetch_assoc($q_nilai)){
    $nilai_label[] = $n['nama_mapel'];
    $nilai_total[] = round($n['rata']);
}
?>

<script>
var ctx4 = document.getElementById("nilaiChart").getContext("2d");
new Chart(ctx4, {
    type: "line",
    data: {
        labels: <?= json_encode($nilai_label); ?>,
        datasets: [{
            label: "Rata-rata Nilai",
            data: <?= json_encode($nilai_total); ?>,
            borderColor: "#e74c3c",
            borderWidth: 3,
            fill: false
        }]
    }
});
</script>

</div>

</body>
</html>
