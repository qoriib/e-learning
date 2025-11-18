-- Tahun ajaran
INSERT INTO tahun_ajaran (id, tahun, semester, is_active) VALUES
  (1, '2023/2024', 'Genap', 0),
  (2, '2024/2025', 'Ganjil', 1);

-- Kelas (mengacu ke tahun ajaran)
INSERT INTO kelas (id, nama_kelas, id_tahun_ajaran) VALUES
  (1, 'X IPA 1', 2),
  (2, 'X IPA 2', 2),
  (3, 'XI IPA 1', 2),
  (4, 'XI IPS 1', 2);

-- Mapel
INSERT INTO mapel (id, nama_mapel) VALUES
  (1, 'Matematika'),
  (2, 'Fisika'),
  (3, 'Kimia'),
  (4, 'Biologi'),
  (5, 'Bahasa Inggris'),
  (6, 'Bahasa Indonesia'),
  (7, 'Sejarah');

-- Guru (dengan wali kelas)
INSERT INTO guru (id, nip, nama_lengkap, email, no_telp, id_kelas_wali) VALUES
  (1, '19800101', 'Budi Santoso', 'budi@guru.sch.id', '081234567890', 1),
  (2, '19800102', 'Siti Aminah', 'siti@guru.sch.id', '081234567891', 2),
  (3, '19800103', 'Agus Prabowo', 'agus@guru.sch.id', '081234567892', 3),
  (4, '19800104', 'Lina Kartika', 'lina@guru.sch.id', '081234567893', 4);

-- Siswa (10 siswa, tersebar di 4 kelas)
INSERT INTO siswa (id, nis, nama_lengkap, email, no_telp, id_kelas) VALUES
  (1, '2024001', 'Andi Pratama', 'andi@siswa.sch.id', '081300000001', 1),
  (2, '2024002', 'Dewi Lestari', 'dewi@siswa.sch.id', '081300000002', 1),
  (3, '2024003', 'Rudi Hartono', 'rudi@siswa.sch.id', '081300000003', 2),
  (4, '2024004', 'Maya Safitri', 'maya@siswa.sch.id', '081300000004', 2),
  (5, '2024005', 'Doni Kurniawan', 'doni@siswa.sch.id', '081300000005', 3),
  (6, '2024006', 'Rara Putri', 'rara@siswa.sch.id', '081300000006', 3),
  (7, '2024007', 'Farhan Rizky', 'farhan@siswa.sch.id', '081300000007', 4),
  (8, '2024008', 'Salsa Aulia', 'salsa@siswa.sch.id', '081300000008', 4),
  (9, '2024009', 'Gilang Saputra', 'gilang@siswa.sch.id', '081300000009', 1),
  (10,'2024010', 'Nina Oktaviani', 'nina@siswa.sch.id', '081300000010', 2);

-- Users (password sudah di-hash dengan PASSWORD_DEFAULT)
-- admin123 / guru123 / siswa123
INSERT INTO users (id, username, password, role, id_guru, id_siswa, status, created_at) VALUES
  (1, 'admin',  '$2y$10$522eYqQ42UFgL4sk/vK1J.asstGs0TyZT4LgtEZLLGrV3T7Soxmoq', 'admin', NULL, NULL, 'aktif', NOW()),
  (2, 'guru1',  '$2y$10$3OxbYIKMwJ.N0H.dJeYQ6.QEMdKgNd8E538s9PUrGbsuXjMtSkyqW', 'guru', 1, NULL, 'aktif', NOW()),
  (3, 'guru2',  '$2y$10$3OxbYIKMwJ.N0H.dJeYQ6.QEMdKgNd8E538s9PUrGbsuXjMtSkyqW', 'guru', 2, NULL, 'aktif', NOW()),
  (4, 'guru3',  '$2y$10$3OxbYIKMwJ.N0H.dJeYQ6.QEMdKgNd8E538s9PUrGbsuXjMtSkyqW', 'guru', 3, NULL, 'aktif', NOW()),
  (5, 'guru4',  '$2y$10$3OxbYIKMwJ.N0H.dJeYQ6.QEMdKgNd8E538s9PUrGbsuXjMtSkyqW', 'guru', 4, NULL, 'aktif', NOW()),
  (6, 'siswa1', '$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 1, 'aktif', NOW()),
  (7, 'siswa2', '$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 2, 'aktif', NOW()),
  (8, 'siswa3', '$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 3, 'aktif', NOW()),
  (9, 'siswa4', '$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 4, 'aktif', NOW()),
  (10,'siswa5', '$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 5, 'aktif', NOW()),
  (11,'siswa6', '$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 6, 'aktif', NOW()),
  (12,'siswa7', '$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 7, 'aktif', NOW()),
  (13,'siswa8', '$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 8, 'aktif', NOW()),
  (14,'siswa9', '$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 9, 'aktif', NOW()),
  (15,'siswa10','$2y$10$aKjJU.Onw3oSlVgsUgcg2uQwbix4gm.1Jvb3pN1gkPZutAZIJ4MVa', 'siswa', NULL, 10,'aktif', NOW());

-- Roster (jadwal) sesuai struktur
INSERT INTO roster (id, id_kelas, id_mapel, id_guru, hari, jam_mulai, jam_selesai) VALUES
  (1, 1, 1, 1, 'Senin',  '07:00:00', '08:30:00'),
  (2, 1, 5, 4, 'Senin',  '08:45:00', '10:15:00'),
  (3, 1, 2, 2, 'Selasa', '07:00:00', '08:30:00'),
  (4, 1, 4, 3, 'Rabu',   '07:00:00', '08:30:00'),
  (5, 2, 1, 1, 'Senin',  '10:30:00', '12:00:00'),
  (6, 2, 3, 2, 'Selasa', '08:45:00', '10:15:00'),
  (7, 2, 5, 4, 'Kamis',  '07:00:00', '08:30:00'),
  (8, 3, 1, 1, 'Senin',  '13:00:00', '14:30:00'),
  (9, 3, 4, 3, 'Selasa', '13:00:00', '14:30:00'),
  (10,3, 6, 4, 'Kamis',  '13:00:00', '14:30:00'),
  (11,4, 7, 3, 'Rabu',   '10:30:00', '12:00:00'),
  (12,4, 5, 4, 'Jumat',  '07:00:00', '08:30:00');

-- Materi (menyertakan deskripsi)
INSERT INTO materi (id, id_guru, id_mapel, judul_materi, deskripsi, file_path, tanggal_upload) VALUES
  (1, 1, 1, 'Aljabar Dasar', 'Operasi dasar aljabar dan latihan soal', 'uploads/materi/aljabar.pdf', NOW()),
  (2, 4, 5, 'Teks Deskriptif', 'Contoh teks deskriptif dan analisis struktur', 'uploads/materi/teks-deskriptif.pdf', NOW()),
  (3, 3, 4, 'Ekosistem dan Rantai Makanan', 'Materi ekosistem, rantai makanan, dan jaring-jaring makanan', 'uploads/materi/ekosistem.pdf', NOW());

-- Tugas (sesuai kolom tugas)
INSERT INTO tugas (id, id_guru, id_mapel, id_kelas, judul_tugas, deskripsi, file_path, deadline, tanggal_buat) VALUES
  (1, 1, 1, 1, 'PR Aljabar', 'Kerjakan soal 1-10 pada buku paket', 'uploads/tugas/pr-aljabar.pdf', DATE_ADD(NOW(), INTERVAL 7 DAY), NOW()),
  (2, 3, 4, 1, 'Poster Ekosistem', 'Buat poster ekosistem lokal dan jelaskan rantai makanan', NULL, DATE_ADD(NOW(), INTERVAL 10 DAY), NOW()),
  (3, 2, 3, 2, 'Laporan Praktikum Reaksi Kimia', 'Catat hasil percobaan reaksi asam-basa', 'uploads/tugas/praktikum-kimia.pdf', DATE_ADD(NOW(), INTERVAL 5 DAY), NOW()),
  (4, 4, 7, 4, 'Resume Bab Kerajaan Hindu-Buddha', 'Resume 2 halaman lengkap dengan garis waktu', NULL, DATE_ADD(NOW(), INTERVAL 6 DAY), NOW());

-- Pengumpulan tugas
INSERT INTO pengumpulan_tugas (id, id_tugas, id_siswa, file_path, tanggal_kumpul, nilai, catatan_nilai) VALUES
  (1, 1, 1, 'uploads/tugas/submit/andi-pr-aljabar.pdf', NOW(), 90, 'Rapi, sedikit salah di nomor 8'),
  (2, 1, 2, 'uploads/tugas/submit/dewi-pr-aljabar.pdf', NOW(), 85, 'Perbaiki langkah nomor 5'),
  (3, 3, 3, 'uploads/tugas/submit/rudi-laporan-kimia.pdf', NOW(), 88, 'Data lengkap, diskusi singkat'),
  (4, 4, 7, 'uploads/tugas/submit/farhan-resume-sejarah.pdf', NOW(), NULL, NULL);

-- Absensi (guru dan siswa)
INSERT INTO absensi (id, id_user, tanggal, status, keterangan, jenis_absen) VALUES
  (1, 2, CURDATE(), 'Hadir', 'Mengajar sesuai jadwal', 'guru'),
  (2, 3, CURDATE(), 'Hadir', 'Menggantikan kelas', 'guru'),
  (3, 6, CURDATE(), 'Hadir', 'Tepat waktu', 'siswa'),
  (4, 7, CURDATE(), 'Sakit', 'Demam', 'siswa'),
  (5, 8, CURDATE(), 'Izin', 'Ada keperluan keluarga', 'siswa');

-- Laporan guru
INSERT INTO laporan (id, id_guru, judul_laporan, file_path, status, tanggal_upload) VALUES
  (1, 1, 'Laporan Kegiatan MGMP Matematika', 'uploads/laporan/mgmp-matematika.pdf', 'belum dibaca', NOW()),
  (2, 2, 'Laporan Kunjungan Industri', 'uploads/laporan/kunjungan-industri.pdf', 'dibaca', NOW());

-- Log aktivitas
INSERT INTO log_aktivitas (id, id_user, role, aktivitas, waktu) VALUES
  (1, 1, 'admin', 'Login ke sistem', NOW()),
  (2, 2, 'guru', 'Upload materi Aljabar Dasar', NOW()),
  (3, 6, 'siswa', 'Mengumpulkan PR Aljabar', NOW());
