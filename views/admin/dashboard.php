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

<?php
$absen_guru_label = [];
$absen_guru_total = [];
$absen_siswa_label = [];
$absen_siswa_total = [];

$q_abs_guru = mysqli_query($conn,
"SELECT status, COUNT(*) AS total
 FROM absensi
 WHERE jenis_absen='guru'
 GROUP BY status");

while($row = mysqli_fetch_assoc($q_abs_guru)){
    $absen_guru_label[] = $row['status'];
    $absen_guru_total[] = $row['total'];
}

$absen_guru_label = $absen_guru_label ?: ['Belum Ada Data'];
$absen_guru_total = $absen_guru_total ?: [0];

$q_abs_siswa = mysqli_query($conn,
"SELECT status, COUNT(*) AS total
 FROM absensi
 WHERE jenis_absen='siswa'
 GROUP BY status");

while($row = mysqli_fetch_assoc($q_abs_siswa)){
    $absen_siswa_label[] = $row['status'];
    $absen_siswa_total[] = $row['total'];
}

$absen_siswa_label = $absen_siswa_label ?: ['Belum Ada Data'];
$absen_siswa_total = $absen_siswa_total ?: [0];
?>

<div class="chart-grid">
    <div class="card">
        <h3>Absensi Guru</h3>
        <canvas id="absensiGuruChart"></canvas>
    </div>
    <div class="card">
        <h3>Absensi Siswa</h3>
        <canvas id="absensiSiswaChart"></canvas>
    </div>
</div>

<div class="card calendar-card">
    <h3>Kalender & Waktu</h3>
    <div class="calendar-header">
        <div>
            <div id="calendarDate" class="calendar-date"></div>
            <div id="calendarClock" class="calendar-clock"></div>
        </div>
    </div>
    <div id="calendarGrid" class="calendar-grid"></div>
</div>

<script>
const guruChart = document.getElementById("absensiGuruChart").getContext("2d");
new Chart(guruChart, {
    type: "doughnut",
    data: {
        labels: <?= json_encode($absen_guru_label); ?>,
        datasets: [{
            data: <?= json_encode($absen_guru_total); ?>,
            backgroundColor: ["#2ecc71","#f1c40f","#e67e22","#e74c3c"]
        }]
    },
    options: {
        plugins: { legend: { position: "bottom" } }
    }
});

const siswaChart = document.getElementById("absensiSiswaChart").getContext("2d");
new Chart(siswaChart, {
    type: "doughnut",
    data: {
        labels: <?= json_encode($absen_siswa_label); ?>,
        datasets: [{
            data: <?= json_encode($absen_siswa_total); ?>,
            backgroundColor: ["#3498db","#9b59b6","#1abc9c","#e74c3c"]
        }]
    },
    options: {
        plugins: { legend: { position: "bottom" } }
    }
});

const monthNames = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];

function buildCalendar(){
    const grid = document.getElementById("calendarGrid");
    const dateText = document.getElementById("calendarDate");
    const now = new Date();
    const year = now.getFullYear();
    const month = now.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = now.getDate();

    dateText.textContent = `${today} ${monthNames[month]} ${year}`;

    const weekdays = ["Min","Sen","Sel","Rab","Kam","Jum","Sab"];
    let html = '<div class="calendar-row calendar-header-row">';
    weekdays.forEach(day => html += `<div>${day}</div>`);
    html += "</div><div class='calendar-row'>";

    for(let i=0;i<firstDay;i++){
        html += "<div class='empty'></div>";
    }
    for(let d=1; d<=daysInMonth; d++){
        const isToday = d === today;
        html += `<div class="${isToday ? 'today' : ''}">${d}</div>`;
        if((d + firstDay) % 7 === 0){
            html += "</div><div class='calendar-row'>";
        }
    }
    html += "</div>";
    grid.innerHTML = html;
}

function updateClock(){
    const clockText = document.getElementById("calendarClock");
    clockText.textContent = new Date().toLocaleTimeString("id-ID");
}

buildCalendar();
updateClock();
setInterval(updateClock, 1000);
setInterval(buildCalendar, 60000);
</script>

</div>

</body>
</html>
