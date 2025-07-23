-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 02, 2025 at 06:57 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `learning_x`
--

-- --------------------------------------------------------

--
-- Table structure for table `content_recommendation`
--

CREATE TABLE `content_recommendation` (
  `id` int(5) NOT NULL,
  `content_id` bigint(10) NOT NULL,
  `learning_style_id` bigint(10) NOT NULL,
  `priority` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_active`
--

CREATE TABLE `mdl_active` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `section_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content_type` enum('quiz','h5p','forum','assignment','file','resource','video') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_active`
--

INSERT INTO `mdl_active` (`id`, `course_id`, `section_id`, `title`, `description`, `content_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Topik 1: Pengantar IoT & Arsitektur IoT', 'Di era digital saat ini, teknologi semakin berkembang pesat dan menghadirkan inovasi yang mengubah cara kita hidup dan bekerja. Salah satu teknologi yang berperan besar dalam transformasi ini adalah Internet of Things (IoT). IoT menghubungkan berbagai perangkat fisik ke internet, memungkinkan mereka untuk saling berkomunikasi, mengumpulkan data, dan merespons secara otomatis tanpa intervensi manusia. Dari smart home yang dapat dikendalikan melalui smartphone hingga sistem industri otomatis yang meningkatkan efisiensi produksi, IoT telah menjadi bagian tak terpisahkan dari kehidupan modern. Dengan memahami IoT, kita dapat menciptakan solusi inovatif untuk berbagai sektor, seperti kesehatan, transportasi, pertanian, dan manufaktur. Mata kuliah ini akan membahas konsep dasar, arsitektur, serta implementasi IoT dalam dunia nyata. Mari kita jelajahi dunia IoT dan bagaimana teknologi ini membawa perubahan besar bagi masa depan!', 'video', '2025-04-03 05:13:18', '2025-04-03 05:13:18'),
(2, 1, 2, 'Topik 2: Pemrograman dan I/O Arduino', 'Pelajari integrasi input/output menggunakan Arduino IDE dan Serial Monitor. Analisis efisiensi kode dan evaluasi kinerja program untuk skenario IoT sederhana. Rancang solusi pemrograman yang presisi dan inovatif.', 'file', '2025-04-15 01:45:01', '2025-04-15 01:45:01'),
(3, 1, 3, 'Topik 3: Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object', 'Eksplorasi data dari sensor cahaya, suhu, dan objek untuk menciptakan aplikasi responsif. Evaluasi performa sistem sensor melalui analisis data. Rancang aplikasi yang mengintegrasikan sensor secara optimal.', 'file', '2025-04-15 01:45:21', '2025-04-15 01:45:21'),
(4, 1, 4, 'Topik 4: Aktuator: Cahaya, Bunyi, dan Motor', 'Kendalikan aktuator seperti LED RGB, buzzer, dan servo untuk membangun sistem yang dinamis. Evaluasi performa sistem kontrol berbasis aktuator. Rancang aplikasi IoT yang mengintegrasikan aktuator dengan tepat.', 'file', '2025-04-15 01:45:42', '2025-04-15 01:45:42'),
(5, 1, 5, 'Topik 5: Support (Relay dan Keypad)', 'Pahami cara kerja relay dan keypad dalam sistem kontrol yang cerdas. Evaluasi performa konfigurasi sistem berbasis relay dan keypad. Rancang sistem kontrol yang responsif dan sesuai spesifikasi.', 'file', '2025-04-15 01:45:58', '2025-04-15 01:45:58'),
(6, 1, 6, 'Topik 6: Jaringan Komunikasi', 'Analisis efisiensi jaringan komunikasi IoT seperti Wi-Fi, MQTT, dan LoRaWAN. Evaluasi performa protokol jaringan untuk aplikasi IoT. Rancang solusi komunikasi yang terintegrasi dan fungsional.', 'file', '2025-04-15 01:46:11', '2025-04-15 01:46:11'),
(7, 1, 7, 'Topik 7: Aplikasi Platform IoT', 'Dalam era digital yang semakin berkembang pesat, Internet of Things (IoT) telah menjadi salah satu teknologi yang memiliki dampak besar terhadap berbagai sektor, seperti industri, rumah tangga, dan kesehatan. IoT memungkinkan perangkat-perangkat fisik untuk saling terhubung dan berkomunikasi melalui jaringan internet, menciptakan ekosistem yang lebih cerdas dan efisien. Pada materi ini, kita akan membahas dua platform yang sangat populer dalam implementasi IoT, yaitu Blynk dan ThingSpeak. Blynk merupakan platform yang menyediakan antarmuka pengguna yang mudah digunakan untuk membangun aplikasi IoT tanpa perlu menulis banyak kode. Di sisi lain, ThingSpeak adalah platform berbasis cloud yang memungkinkan pengumpulan dan analisis data sensor secara real-time, sangat cocok untuk aplikasi IoT berbasis data. Melalui pemahaman mendalam mengenai kedua platform ini, diharapkan peserta dapat mengembangkan solusi IoT yang lebih efektif dan inovatif. Kami berharap materi ini dapat memberikan wawasan yang berguna serta memotivasi para peserta untuk mengeksplorasi lebih jauh potensi besar yang ditawarkan oleh teknologi IoT.', 'file', '2025-04-15 01:46:33', '2025-04-15 01:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign`
--

CREATE TABLE `mdl_assign` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `learning_style` enum('active','reflective','sensing','intuitive','visual','verbal','sequential','global') NOT NULL,
  `topik` enum('topik1','topik2','topik3','topik4','topik5','topik6','topik7') NOT NULL,
  `description` text NOT NULL,
  `due_date` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_assign`
--

INSERT INTO `mdl_assign` (`id`, `course_id`, `name`, `learning_style`, `topik`, `description`, `due_date`, `created_at`) VALUES
(1, 1, 'Tugas Kelompok', 'active', 'topik3', 'Rakit rangkaian sederhana menggunakan Arduino dan LDR untuk menyalakan LED otomatis saat ruangan gelap.', '2025-04-21 00:00:00', '2025-04-15 12:40:55'),
(2, 1, 'Praktikum Kolaboratif', 'active', 'topik3', 'Buat sistem monitoring suhu-kelembaban kelas dan simulasikan notifikasi jika suhu >30°C', '2025-04-22 00:00:00', '2025-04-16 07:02:09'),
(3, 1, 'Challenge', 'active', 'topik3', 'Buat sistem parkir otomatis menggunakan sensor ultrasonik dan buzzer jika jarak < 20cm', '2025-04-22 00:00:00', '2025-04-16 07:09:16'),
(4, 1, 'Praktikum: Aktuator Cahaya (LED dan RGB)\r\n', 'active', 'topik4', 'Rakit rangkaian sederhana menggunakan Arduino untuk mengendalikan LED (on/off) berdasarkan input sensor (misalnya sensor cahaya).', '2025-04-22 00:00:00', '2025-04-16 07:30:05'),
(5, 1, 'Praktikum: Aktuator Bunyi (Buzzer)', 'active', 'topik4', 'Gunakan Arduino untuk mengaktifkan buzzer dengan frekuensi tertentu sebagai indikator. Lakukan eksperimen dengan berbagai durasi suara.', '2025-04-22 00:00:00', '2025-04-16 07:30:34'),
(6, 1, 'Mini Project: Aktuator Motor (Motor DC dan Servo)', 'active', 'topik4', 'Buat proyek sederhana seperti mekanisme pembuka pintu otomatis yang dikendalikan oleh motor servo.', '2025-04-22 00:00:00', '2025-04-16 07:31:35'),
(7, 1, 'Praktikum Langsung — Kontrol Lampu via Relay', 'active', 'topik5', 'Tujuan: Mengendalikan LED/lampu menggunakan Relay dengan Arduino.\r\n\r\nInstruksi:\r\n\r\n1. Hubungkan relay 1 channel ke Arduino dan LED.\r\n\r\n2. Tulis program sederhana untuk mengaktifkan relay.', '2025-04-22 00:00:00', '2025-04-16 07:55:45'),
(8, 1, 'Praktikum — Input Password dengan Keypad 4x4', 'active', 'topik5', 'Tujuan: Menggunakan keypad untuk input kode ke sistem (seperti sistem alarm/pintu otomatis).\r\n\r\nInstruksi:\r\n\r\n1. Rakit keypad 4x4 ke Arduino.\r\n\r\n2. Tampilkan input ke LCD atau Serial Monitor.\r\n\r\n3. Jika input = \"1234\", nyalakan LED.', '2025-04-22 00:00:00', '2025-04-16 07:56:17'),
(10, 1, 'Mini Project Kolaboratif', 'active', 'topik5', 'Buat sistem kontrol lampu berbasis keypad dan relay:\r\n\r\n1. Input password via keypad. Jika benar, nyalakan relay\r\n\r\n2. Jika salah, tampilkan pesan error\r\n\r\nSimulasi boleh dilakukan via Tinkercad bagi yang belum punya alat.\r\n\r\nOutput:\r\n\r\n1. Video/screenshot simulasi\r\n\r\n2. Penjelasan alur sistem dalam bentuk diagram atau flowchart\r\n\r\n', '2025-04-22 00:00:00', '2025-04-16 07:57:25'),
(11, 1, 'Praktikum: Kirim Data Sensor via Wi-Fi (ESP8266/ESP32)', 'active', 'topik6', 'Gunakan ESP8266 atau ESP32 untuk membaca data suhu dari sensor DHT11/DHT22.\r\n\r\nKirim data ke platform IoT seperti ThingSpeak atau tampilkan di WebServer lokal.\r\n\r\nCoba dua mode:\r\n\r\n1. Station mode (koneksi ke Wi-Fi)\r\n\r\n2. Access Point mode (ESP jadi Wi-Fi host)', '2025-04-22 00:00:00', '2025-04-16 08:20:24'),
(12, 1, 'Praktikum: Komunikasi Bluetooth Jarak Dekat', 'active', 'topik6', 'Gunakan HC-05 / HC-06 / ESP32 untuk mengirim dan menerima pesan dari HP (via Serial Bluetooth Terminal).\r\n\r\nKirim perintah dari HP -> nyalakan LED di ESP.\r\n\r\nBuat interaksi 2 arah: mahasiswa bisa input teks via HP, dan ESP membalas.', '2025-04-22 00:00:00', '2025-04-16 08:20:49'),
(13, 1, 'Mini Project — “Pilih dan Bangun Jaringan”', 'active', 'topik6', 'Dalam kelompok, pilih satu dari tiga metode komunikasi dan bangun sistem IoT sederhana.\r\nContoh ide:\r\n\r\n1. Wi-Fi: Kirim status pintu (buka/tutup) ke dashboard online.\r\n\r\n2. Bluetooth: Kirim input keypad dari HP ke ESP32.\r\n\r\n3. Cellular: Kirim SMS jika sensor mendeteksi api atau gas.', '2025-04-22 00:00:00', '2025-04-16 08:22:03'),
(14, 1, 'Praktikum: Kirim Data ke Platform IoT (ThingSpeak)', 'active', 'topik7', 'Gunakan ESP8266/ESP32 + sensor suhu (DHT11/DHT22).\r\n\r\nKirim data ke ThingSpeak channel menggunakan API Key.\r\n\r\nTampilkan grafik suhu setiap 20 detik.', '2025-04-22 00:00:00', '2025-04-16 08:38:15'),
(15, 1, 'Praktikum: Kontrol LED via Smartphone (Blynk)', 'active', 'topik7', 'Buat project Blynk (Blynk 2.0).\r\n\r\nTambahkan widget tombol -> kontrol LED via HP.\r\n\r\nTambahkan juga pembacaan data sensor (jika sempat).', '2025-04-22 00:00:00', '2025-04-16 08:38:37'),
(16, 1, 'Proyek Mini Kelompok — “Aplikasi Monitoring IoT”', 'active', 'topik7', 'Rancang sistem monitoring berbasis platform IoT:\r\n\r\n1. Misalnya: monitoring kelembaban tanaman, suhu ruangan, atau sistem keamanan.\r\n\r\n2. Gunakan salah satu platform (ThingSpeak, Firebase, Blynk, dll).\r\n\r\nHasil:\r\n\r\n1. Video presentasi sistem\r\n\r\n2. Link dashboard online / dokumentasi', '2025-04-22 00:00:00', '2025-04-16 08:39:43'),
(17, 1, 'Tugas Reflektif', 'reflective', 'topik2', 'Apa saja tantangan yang mungkin kamu hadapi ketika menggunakan pin input/output Arduino, dan bagaimana cara mengatasinya?\r\n\r\nJawaban dikumpulkan dalam bentuk file word/pdf (100–200 kata)', '2025-04-22 00:00:00', '2025-04-16 09:46:15'),
(18, 1, 'Refleksi Mandiri', 'reflective', 'topik3', 'Menurut kamu, sensor mana yang paling banyak berperan dalam kehidupan sehari-hari dan kenapa?\r\n\r\nJawaban dikumpulkan dalam bentuk word/pdf (format teks singkat, max 300 kata)', '2025-04-22 00:00:00', '2025-04-17 04:14:38'),
(19, 1, 'Studi Kasus', 'reflective', 'topik4', 'Sebuah sistem pengaman rumah menggunakan sensor gerak dan buzzer sebagai alarm.\r\n\r\nAnalisis Pertanyaan:\r\n\r\n1. Bagaimana aktuator berperan dalam memberikan respons?\r\n\r\n2. Apa kelebihan/kekurangan buzzer dibandingkan notifikasi digital?\r\n\r\nJawab dalam bentuk esai 250 kata dan unggah dalam format file pdf atau docx.', '2025-04-22 00:00:00', '2025-04-17 05:34:24'),
(20, 1, 'Studi Kasus', 'reflective', 'topik5', 'Sebuah pintu otomatis dikendalikan menggunakan keypad 4x4 untuk input password, dan relay untuk mengaktifkan motor pintu.\r\n\r\nPertanyaan Analisis:\r\n\r\n1. Mengapa relay digunakan, bukan transistor biasa?\r\n\r\n1. Apa tantangan menggunakan keypad sebagai pengaman?\r\n\r\nTuliskan pemikiranmu dalam 250 kata tentang bagaimana relay dan keypad bisa bekerja bersama sebagai sistem kendali yang aman.', '2025-04-22 00:00:00', '2025-04-17 05:48:18'),
(21, 1, 'Studi Kasus Lapangan', 'sensing', 'topik1', 'Skenario:\r\nSebuah rumah sakit ingin memantau suhu ruang penyimpanan vaksin secara otomatis.\r\n\r\nTugas:\r\n\r\n1. Tentukan sensor yang digunakan\r\n\r\n2. Jaringan komunikasi yang sesuai\r\n\r\n3. Arsitektur IoT yang cocok (dijelaskan dengan diagram)\r\n\r\nKumpulkan dalam bentuk pdf/docx.', '2025-04-22 00:00:00', '2025-04-17 06:38:20'),
(22, 1, 'Contoh Kode Nyata + Penjelasan', 'sensing', 'topik2', 'void setup() {\r\n  pinMode(9, OUTPUT);\r\n}\r\n\r\nvoid loop() {\r\n  digitalWrite(9, HIGH);\r\n  delay(1000);\r\n  digitalWrite(9, LOW);\r\n  delay(1000);\r\n}\r\n\r\nPenjelasan per baris kode:\r\n\r\n1. pinMode: mengatur pin sebagai output\r\n\r\n2. digitalWrite: menghidupkan atau mematikan pin\r\n\r\n3. delay: jeda waktu 1 detik\r\n\r\nUpload video saat kamu menyalakan LED dengan hasil seperti kode di atas, lalu jelaskan bagian mana yang kamu ubah jika ingin menyalakan 2 LED.', '2025-04-22 00:00:00', '2025-04-17 11:58:26'),
(23, 1, 'Aktivitas Observasi', 'sensing', 'topik2', 'Identifikasi 3 perangkat elektronik di sekitar kamu yang menggunakan konsep input & output.', '2025-04-22 00:00:00', '2025-04-17 12:00:14'),
(24, 1, 'Kode Contoh + Praktik Langsung', 'sensing', 'topik3', 'Membaca data LDR dan menampilkan di Serial Monitor\r\n\r\nint ldrPin = A0;\r\nvoid setup() {\r\n  Serial.begin(9600);\r\n}\r\nvoid loop() {\r\n  int ldrValue = analogRead(ldrPin);\r\n  Serial.println(ldrValue);\r\n  delay(500);\r\n}', '2025-04-22 00:00:00', '2025-04-17 12:12:56'),
(25, 1, 'Kode Praktik Langsung', 'sensing', 'topik4', 'Menyalakan LED dan mengatur Servo\r\n\r\n#include <Servo.h>\r\nServo myServo;\r\nint ledPin = 7;\r\n\r\nvoid setup() {\r\n  pinMode(ledPin, OUTPUT);\r\n  myServo.attach(9);\r\n}\r\n\r\nvoid loop() {\r\n  digitalWrite(ledPin, HIGH);\r\n  delay(1000);\r\n  digitalWrite(ledPin, LOW);\r\n  delay(1000);\r\n  \r\n  myServo.write(0);\r\n  delay(1000);\r\n  myServo.write(90);\r\n  delay(1000);\r\n}\r\n\r\nTugas: Ubah program agar LED dan Servo bergerak secara bergantian setiap 2 detik', '2025-04-22 00:00:00', '2025-04-17 12:26:52'),
(26, 1, 'Contoh Kode Praktik Langsung', 'sensing', 'topik5', 'Kontrol Relay dengan Tombol Keypad\r\n\r\n#include <Keypad.h>\r\n\r\nconst byte ROWS = 4;\r\nconst byte COLS = 4;\r\nchar keys[ROWS][COLS] = {\r\n  {\'1\',\'2\',\'3\',\'A\'},\r\n  {\'4\',\'5\',\'6\',\'B\'},\r\n  {\'7\',\'8\',\'9\',\'C\'},\r\n  {\'*\',\'0\',\'#\',\'D\'}\r\n};\r\nbyte rowPins[ROWS] = {9, 8, 7, 6};\r\nbyte colPins[COLS] = {5, 4, 3, 2};\r\nKeypad keypad = Keypad(makeKeymap(keys), rowPins, colPins, ROWS, COLS);\r\n\r\nint relayPin = 10;\r\n\r\nvoid setup() {\r\n  pinMode(relayPin, OUTPUT);\r\n  digitalWrite(relayPin, LOW);\r\n  Serial.begin(9600);\r\n}\r\n\r\nvoid loop() {\r\n  char key = keypad.getKey();\r\n  if (key == \'1\') {\r\n    digitalWrite(relayPin, HIGH);\r\n    Serial.println(\"Relay ON\");\r\n  }\r\n  if (key == \'0\') {\r\n    digitalWrite(relayPin, LOW);\r\n    Serial.println(\"Relay OFF\");\r\n  }\r\n}\r\n\r\nTugas: Tambahkan kondisi agar tombol ‘A’ mengaktifkan buzzer', '2025-04-22 00:00:00', '2025-04-17 12:33:57'),
(27, 1, 'Praktik Rangkaian Nyata', 'sensing', 'topik5', 'Buat sistem kunci digital menggunakan keypad:\r\n\r\n1. Tombol password \"1234\"\r\n\r\n2. Jika benar: aktifkan relay (nyalakan LED/motor)\r\n\r\n3. Jika salah: buzzer menyala 3 detik\r\n\r\n', '2025-04-22 00:00:00', '2025-04-17 12:35:40'),
(28, 1, 'Implementasi Langsung', 'sensing', 'topik6', '1. ESP32 Terhubung ke Wi-Fi\r\n\r\n#include <WiFi.h>\r\n\r\nconst char* ssid = \"Nama_WiFi\";\r\nconst char* password = \"password123\";\r\n\r\nvoid setup() {\r\n  Serial.begin(115200);\r\n  WiFi.begin(ssid, password);\r\n  while (WiFi.status() != WL_CONNECTED) {\r\n    delay(1000);\r\n    Serial.println(\"Menghubungkan...\");\r\n  }\r\n  Serial.println(\"Terhubung ke WiFi\");\r\n}\r\n\r\nvoid loop() {\r\n  // Kirim data ke server\r\n}\r\n\r\n2. Koneksi HC-05 dan Kirim Data Serial\r\nvoid setup() {\r\n  Serial.begin(9600); // Arduino serial\r\n  Serial1.begin(9600); // HC-05\r\n}\r\n\r\nvoid loop() {\r\n  Serial1.println(\"Sensor suhu: 28C\");\r\n  delay(2000);\r\n}\r\n\r\nTugas: coba kode diatas dan kumpulkan hasilnya dalam bentuk pdf/docx', '2025-04-22 00:00:00', '2025-04-17 12:45:32'),
(29, 1, 'Setup Langkah-Langkah Implementasi', 'sensing', 'topik7', 'A. Kirim Data Sensor ke Thingspeak (ESP32 + DHT11)\r\n\r\n1. Buat akun Thingspeak dan channel baru\r\n\r\n2. Simpan Write API Key\r\n\r\n3. Upload kode berikut ke ESP32:\r\n#include <WiFi.h>\r\n#include <HTTPClient.h>\r\n#include \"DHT.h\"\r\n\r\n#define DHTPIN 4\r\n#define DHTTYPE DHT11\r\nDHT dht(DHTPIN, DHTTYPE);\r\n\r\nconst char* ssid = \"NamaWiFi\";\r\nconst char* password = \"PasswordWiFi\";\r\nconst char* server = \"http://api.thingspeak.com/update?api_key=API_KEY\";\r\n\r\nvoid setup() {\r\n  WiFi.begin(ssid, password);\r\n  dht.begin();\r\n}\r\n\r\nvoid loop() {\r\n  float t = dht.readTemperature();\r\n  String url = String(server) + \"&field1=\" + t;\r\n  HTTPClient http;\r\n  http.begin(url);\r\n  http.GET();\r\n  http.end();\r\n  delay(15000);\r\n}\r\n\r\n\r\nTugas: kumpulkan hasilnya dalam bentuk pdf/docx', '2025-04-22 00:00:00', '2025-04-17 13:46:29'),
(30, 1, 'Kontrol LED via Blynk', 'sensing', 'topik7', '1. Unduh Blynk App\r\n\r\n2. Tambah project -> Dapatkan Auth Token\r\n\r\n3. Gunakan kode berikut:\r\n#define BLYNK_TEMPLATE_ID \"xxxx\"\r\n#define BLYNK_AUTH_TOKEN \"tokenmu\"\r\n#include <WiFi.h>\r\n#include <BlynkSimpleEsp32.h>\r\n\r\nchar auth[] = BLYNK_AUTH_TOKEN;\r\nchar ssid[] = \"WiFi\";\r\nchar pass[] = \"password\";\r\n\r\nvoid setup() {\r\n  Blynk.begin(auth, ssid, pass);\r\n  pinMode(2, OUTPUT);\r\n}\r\n\r\nBLYNK_WRITE(V0) {\r\n  int value = param.asInt();\r\n  digitalWrite(2, value);\r\n}\r\n\r\nvoid loop() {\r\n  Blynk.run();\r\n}\r\n\r\nTugas: kumpulkan hasilnya dalam bentuk pdf/docx.', '2025-04-22 00:00:00', '2025-04-17 13:47:27'),
(31, 1, 'Tugas Eksplorasi', 'intuitive', 'topik1', 'Eksperimen Pikiran:\r\n\r\n1. Apa yang kamu pikirkan jika dunia ini berjalan tanpa adanya IoT? Tuliskan tiga perubahan besar yang akan terjadi.\r\n\r\n2. Gagasan bebas: Buat sketsa konsep sistem IoT untuk kesehatan mental atau energi terbarukan.', '2025-05-14 00:00:00', '2025-04-18 04:32:13'),
(32, 1, 'Studi Kasus Inovatif', 'intuitive', 'topik2', 'Bagaimana jika sistem ini digunakan untuk menciptakan alat bantu penderita tunanetra menggunakan sensor jarak dan buzzer?\r\n\r\nBerikan sketsa ide:\r\n\r\n1. Sensor ultrasonik sebagai \"mata buatan\"\r\n\r\n2. Buzzer sebagai \"rasa\" jarak', '2025-04-22 00:00:00', '2025-04-18 04:44:01'),
(33, 1, 'Proyek Eksploratif (Tugas Mini)', 'intuitive', 'topik3', 'Buatlah konsep sistem IoT yang menggunakan ketiga sensor ini dalam skenario smart home atau smart agriculture. Tidak perlu coding – fokus pada logika sistem, konektivitas, dan tujuan akhir.\r\n\r\nContoh output yang diharapkan: Diagram logika, sketsa, atau narasi skenario.', '2025-04-22 00:00:00', '2025-04-18 04:53:04'),
(34, 1, 'Eksperimen Imajinatif (Tugas Mini)', 'intuitive', 'topik4', 'Buatlah konsep sistem IoT yang menggunakan:\r\n\r\n1. LED sebagai indikator kondisi psikologis pengguna.\r\n\r\n2. Buzzer sebagai pengingat aktivitas sehat.\r\n\r\n3. Servo motor untuk membuka ventilasi otomatis saat suhu tinggi.\r\n\r\nOutput: Sketsa sistem atau narasi logika penggunaan aktuator.', '2025-04-22 00:00:00', '2025-04-18 04:59:13'),
(35, 1, 'Simulasi Imajinatif', 'intuitive', 'topik5', 'Rancang sistem rumah pintar sederhana:\r\n\r\nInput: Keypad -> kode = \"1234\"\r\n\r\nProses: Arduino memverifikasi kode\r\n\r\nOutput: Relay mengaktifkan kipas angin\r\n\r\nTugas Mini:\r\n\r\n1. Buatlah sketsa alur sistemmu\r\n\r\n2. Jelaskan apa yang terjadi jika kode salah', '2025-04-25 00:00:00', '2025-04-18 05:06:38'),
(36, 1, 'Studi Kasus Imajinatif', 'intuitive', 'topik7', 'Studi Kasus:\r\nKamu ingin membuat sistem IoT untuk kebun hidroponik pintar:\r\n\r\n- Sensor membaca kadar air\r\n\r\n- Aktuator mengaktifkan pompa\r\n\r\n- Data ditampilkan dan dikendalikan jarak jauh\r\n\r\nTantangan Konseptual:\r\n\r\nRancang sistem ini menggunakan salah satu platform (misalnya, Blynk). Gambarkan alur dan jenis komunikasi antar komponen.', '2025-04-27 00:00:00', '2025-04-18 05:17:50'),
(37, 1, 'Pemrograman dan I/O Arduino', 'visual', 'topik2', 'Rangkum apa yang didapat dari modul ini tentang Pemrograman dan I/O Arduino. Kumpulkan dalam bentuk .docx atau tipe file yang serupa.', '2025-04-26 00:00:00', '2025-04-18 05:53:46'),
(38, 1, 'Tugas', 'visual', 'topik3', 'Gambarkan alur kerja otomatisasi sistem penyiraman tanaman menggunakan sensor cahaya dan DHT11.', '2025-04-27 00:00:00', '2025-04-18 06:44:39'),
(39, 1, 'Tugas: Desain Sistem IoT Miniatur', 'visual', 'topik4', 'Deskripsi Tugas:\r\n\r\nBuatlah rancangan sistem \"Kotak Surat Pintar\" yang dapat memberikan notifikasi ketika surat dimasukkan, dengan memanfaatkan:\r\n\r\n1. LED (indikator notifikasi)\r\n\r\n2. Buzzer (alarm bunyi)\r\n\r\n3. Servo Motor (membuka otomatis penutup kotak)\r\n\r\nKeluaran yang diharapkan:\r\n\r\n- Gambar rangkaian lengkap (boleh manual atau software)\r\n\r\n- Desain sistem dalam bentuk blok diagram\r\n\r\n- Penjelasan singkat fungsi tiap aktuator (dalam bentuk caption di bawah gambar)\r\n\r\n- [Opsional] Simulasi menggunakan Tinkercad\r\n\r\nKumpulkan dalam bentuk pdf/docx', '2025-04-28 00:00:00', '2025-04-18 08:24:35'),
(40, 1, 'Tugas Visual: Desain Sistem Keamanan Sederhana', 'visual', 'topik5', 'Deskripsi Tugas:\r\n\r\nBuat rancangan sistem keamanan yang menggunakan keypad untuk input kode dan relay untuk membuka atau menutup kunci pintu elektronik.\r\n\r\nTugas ini bertujuan mengasah kemampuan desain sistem dan pemahaman visual terhadap komponen pendukung dalam IoT.\r\n\r\nKomponen Minimal yang Ditampilkan:\r\n\r\n1. Keypad 4x4\r\n\r\n2. Relay 1 channel\r\n\r\n3. Arduino UNO (atau ESP32)\r\n\r\n4. Motor DC (simulasi sebagai kunci pintu)\r\n\r\nKumpulkan dalam format file .pdf/.docx', '2025-04-28 00:00:00', '2025-04-18 08:39:14'),
(41, 1, 'Tugas', 'visual', 'topik6', 'Perbandingan Implementasi Modul Jaringan IoT\r\n\r\nInstruksi:\r\n\r\nBuatlah infografis atau poster digital (dalam format PNG atau PDF) yang membandingkan tiga jenis jaringan komunikasi IoT: WiFi, Bluetooth, dan Cellular, berdasarkan:\r\n\r\n- Konsumsi daya\r\n\r\n- Jangkauan\r\n\r\n- Biaya modul\r\n\r\n- Kecepatan transfer data\r\n\r\n- Contoh skenario penggunaan\r\n\r\nSertakan minimal 1 skema diagram sederhana yang menunjukkan alur komunikasi data dari sensor ke cloud melalui masing-masing metode.', '2025-04-29 00:00:00', '2025-04-18 15:19:01'),
(42, 1, 'Tugas', 'visual', 'topik7', 'Desain Mini Proyek Monitoring IoT\r\n\r\nInstruksi:\r\n\r\n1. Buat diagram alur komunikasi dari sensor ke platform IoT pilihanmu (ThingSpeak, Blynk, atau Adafruit IO).\r\n\r\n2. Tambahkan komponen yang digunakan, skema sambungan, dan alur pengiriman data.\r\n\r\n3. Upload diagram dalam format JPG/PNG beserta deskripsi singkat (maks. 150 kata) mengenai fungsinya.\r\n\r\n4. Gunakan tool seperti Canva, draw.io, atau PowerPoint untuk visualisasi.', '2025-04-29 00:00:00', '2025-04-18 15:36:33'),
(43, 1, 'Tugas', 'verbal', 'topik1', 'Jelaskan bagaimana IoT dapat digunakan dalam kehidupan sehari-hari. Pilih satu bidang (misalnya: pertanian, rumah pintar, transportasi) dan uraikan perangkat yang digunakan, cara kerja, serta manfaatnya.', '2025-04-30 00:00:00', '2025-04-19 03:17:55'),
(44, 1, 'Tugas ', 'verbal', 'topik2', 'Tuliskan langkah-langkah menjalankan program sederhana Arduino untuk menyalakan dan mematikan LED dengan delay tertentu. Jelaskan fungsi dari tiap baris kode!', '2025-04-30 00:00:00', '2025-04-19 03:28:33'),
(45, 1, 'Tugas ', 'verbal', 'topik3', 'Deskripsi Tugas:\r\nTuliskan penjelasan lengkap mengenai cara kerja sensor DHT11 dalam mendeteksi suhu dan kelembaban.\r\n\r\nSertakan juga:\r\n\r\n1. Cara menghubungkan ke Arduino\r\n\r\n2. Data apa yang bisa diambil\r\n\r\n3. Aplikasi di dunia nyata', '2025-05-05 00:00:00', '2025-04-19 03:44:39'),
(46, 1, 'Tugas ', 'verbal', 'topik4', 'Deskripsi Tugas:\r\nJelaskan secara tertulis bagaimana kamu akan menggunakan kombinasi LED, buzzer, dan motor untuk sistem penyiram tanaman otomatis berbasis IoT.\r\n\r\nTuliskan:\r\n\r\n1. Fungsi masing-masing aktuator\r\n\r\n2. Cara kerja sistem\r\n\r\n3. Skema naratif cara rangkaian bekerja saat sensor kelembaban mendeteksi tanah kering', '2025-05-05 00:00:00', '2025-04-19 03:57:08'),
(47, 1, 'Tugas ', 'verbal', 'topik5', 'Tugas Individu:\r\nTuliskan secara naratif alur kerja sistem keamanan berbasis keypad dan relay.\r\n\r\nSertakan:\r\n\r\n1. Bagaimana input dari keypad dibaca\r\n\r\n2. Bagaimana Arduino mengecek PIN\r\n\r\n3. Apa yang terjadi saat PIN benar atau salah\r\n\r\n4. Peran relay dalam sistem tersebut\r\n\r\nOutput:\r\nTulisan 300–400 kata dalam bentuk narasi logis.', '2025-05-05 00:00:00', '2025-04-19 04:06:49'),
(48, 1, 'Tugas (Essay/Narasi)', 'verbal', 'topik6', 'Tugas Individu:\r\nTuliskan sebuah narasi pendek berjudul:\r\n\"Petualangan Sebuah Sensor Mengirim Data ke Cloud\"\r\n\r\nIsi narasi minimal 400 kata dan harus memuat:\r\n\r\n1. Sensor yang mendeteksi suhu\r\n\r\n2. Arduino yang membaca data\r\n\r\n3. Modul komunikasi (misalnya ESP8266, SIM800L, atau LoRa)\r\n\r\n4. Server/cloud (misal ThingSpeak atau Blynk)\r\n\r\n5. Protokol komunikasi yang digunakan\r\n\r\n6. Tantangan yang dihadapi si sensor dalam “perjalanannya” mengirim data', '2025-05-05 00:00:00', '2025-04-19 04:11:47'),
(49, 1, 'Tugas ', 'verbal', 'topik7', 'Judul Tugas:\r\n\"Analisis Perbandingan Platform IoT Berdasarkan Studi Kasus\"\r\n\r\nInstruksi:\r\nTuliskan esai 500–700 kata yang membandingkan ThingSpeak, Blynk, Adafruit IO, dan Google Cloud IoT Core.\r\nUraikan dengan bahasa naratif dan gunakan parameter berikut:\r\n\r\n- Kemudahan penggunaan\r\n\r\n- Biaya\r\n\r\n- Dokumentasi\r\n\r\n- Integrasi perangkat\r\n\r\n- Kesesuaian untuk proyek edukasi skala kecil dan proyek industri skala besar', '2025-05-05 00:00:00', '2025-04-19 04:23:42'),
(50, 1, 'Tugas ', 'sequential', 'topik1', 'Judul Tugas:\r\n\"Membuat Infografis Arsitektur IoT Secara Bertahap\"\r\n\r\nInstruksi:\r\n\r\n1. Buat daftar komponen utama IoT dari yang paling dasar (sensor) ke paling atas (aplikasi).\r\n\r\n2. Tambahkan deskripsi singkat tiap komponen.\r\n\r\n3. Rangkai dalam bentuk infografis bertingkat atau diagram alur.', '2025-05-05 00:00:00', '2025-04-19 04:52:10'),
(51, 1, 'Proyek Sederhana: \"Menyalakan LED saat tombol ditekan\"', 'sequential', 'topik2', '1. Hubungkan LED ke pin 13 dan tombol ke pin 2\r\n\r\n2. Tulis kode:\r\nvoid setup() {\r\n  pinMode(13, OUTPUT);\r\n  pinMode(2, INPUT);\r\n}\r\n\r\nvoid loop() {\r\n  int tombol = digitalRead(2);\r\n  if(tombol == HIGH){\r\n    digitalWrite(13, HIGH);\r\n  } else {\r\n    digitalWrite(13, LOW);\r\n  }\r\n}\r\n\r\n3. Upload program\r\n\r\n4. Uji coba dengan menekan tombol', '2025-05-05 00:00:00', '2025-04-19 05:18:53'),
(52, 1, 'Tugas: Buat Proyek I/O: Kendali LED dan Buzzer dengan Dua Tombol', 'sequential', 'topik2', 'Langkah Tugas:\r\n\r\n1. Rancang logika program menggunakan flowchart\r\n\r\n2. Buat wiring diagram menggunakan Fritzing atau gambar tangan\r\n\r\n3. Tulis program menggunakan Arduino IDE\r\n\r\n4. Uji dan dokumentasikan hasilnya (foto/video)\r\n\r\n5. Upload laporan berisi: deskripsi, diagram, kode, hasil uji\r\n\r\n', '2025-05-05 00:00:00', '2025-04-19 05:20:04'),
(53, 1, 'Tugas ', 'sequential', 'topik3', 'Judul Tugas:\r\n\"Monitoring Suhu dan Jarak secara Bertahap dengan DHT11 dan HC-SR04\"\r\n\r\nLangkah-langkah Tugas:\r\n\r\n1. Rancang rangkaian DHT11 dan HC-SR04 dengan Arduino\r\n\r\n2. Buat program yang membaca suhu dan jarak setiap 5 detik\r\n\r\n3. Tampilkan data pada Serial Monitor\r\n\r\n4. Dokumentasikan percobaan (foto rangkaian, screenshot hasil)\r\n\r\n5. Simpulkan perbedaan data saat kondisi berbeda (ruangan tertutup vs terbuka)', '2025-05-05 00:00:00', '2025-04-19 05:57:32'),
(54, 1, 'Uji Coba & Evaluasi', 'sequential', 'topik4', '- Uji LED menyala-mati\r\n\r\n- Uji buzzer berbunyi 1 detik, mati 1 detik\r\n\r\n- Uji pergerakan servo ke 3 posisi (0°, 90°, 180°)\r\n\r\n- Bandingkan waktu respon masing-masing aktuator', '2025-05-05 00:00:00', '2025-04-19 06:27:08'),
(55, 1, 'Tugas', 'sequential', 'topik4', 'Judul Tugas:\r\n“Pengendalian Aktuator Berbasis Sensor”\r\n\r\nInstruksi Tugas:\r\n\r\n1. Gunakan sensor LDR untuk mengontrol LED:\r\n\r\n- Jika gelap -> LED nyala\r\n\r\n- Jika terang -> LED mati\r\n\r\n2. Gunakan sensor suhu untuk mengontrol buzzer:\r\n\r\n- Jika suhu > 30°C ? buzzer bunyi\r\n\r\n3. Gunakan potensiometer untuk mengatur posisi servo\r\n\r\nOutput yang Diharapkan:\r\n\r\n- Rangkaian terintegrasi sensor & aktuator\r\n\r\n- Program Arduino dalam satu file\r\n\r\n- Dokumentasi langkah-langkah & video hasil uji coba', '2025-05-05 00:00:00', '2025-04-19 06:28:17'),
(56, 1, 'Tugas ', 'sequential', 'topik5', 'Judul Tugas:\r\n“Menampilkan Waktu dan Informasi Sensor di LCD”\r\n\r\nInstruksi Tugas:\r\n\r\n1. Rangkai LCD 16x2 dan modul RTC DS3231 ke Arduino\r\n\r\n2. Tampilkan waktu dan tanggal real-time\r\n\r\n3. Tambahkan sensor suhu (misalnya DHT11/DHT22)\r\n\r\n4. Tampilkan data suhu dan kelembaban di LCD secara real-time\r\n\r\nOutput:\r\n\r\n- Rangkaian terintegrasi (foto/video)\r\n\r\n- File program .ino\r\n\r\n- Penjelasan tertulis: langkah-langkah dan penjelasan tiap bagian kode', '2025-05-05 00:00:00', '2025-04-19 06:36:52'),
(57, 1, 'Tugas ', 'sequential', 'topik6', 'Judul Tugas:\r\n“Membuat Sistem Pengiriman Data Sensor ke Platform IoT Menggunakan MQTT”\r\n\r\nInstruksi Tugas:\r\n\r\n1. Hubungkan sensor suhu ke NodeMCU/ESP32\r\n\r\n2. Gunakan protokol MQTT untuk mengirim data ke platform (misalnya: HiveMQ atau broker lokal)\r\n\r\n3. Tampilkan data suhu dan kelembaban secara real-time\r\n\r\n4. Dokumentasikan langkah-langkahmu dari awal hingga data tampil\r\n\r\nOutput yang Dikumpulkan:\r\n\r\n- Foto/video alat berfungsi\r\n\r\n- Kode program\r\n\r\n- Screenshot data di dashboard\r\n\r\n- Dokumentasi langkah teknis', '2025-05-05 00:00:00', '2025-04-19 06:46:27'),
(58, 1, 'Tugas', 'sequential', 'topik7', 'Judul Tugas:\r\n“Implementasi Pengiriman dan Visualisasi Data Sensor Menggunakan Platform IoT”\r\n\r\nInstruksi Tugas:\r\n\r\n1. Pilih salah satu platform: ThingSpeak / Blynk / Adafruit IO\r\n\r\n2. Hubungkan mikrokontroler dengan sensor (misal: suhu DHT11)\r\n\r\n3. Kirim data secara realtime ke platform menggunakan WiFi\r\n\r\n4. Buat visualisasi data dalam bentuk grafik\r\n\r\nDokumentasikan semua langkah (setup akun, coding, dashboard)\r\n\r\n- Output yang Dikumpulkan:\r\n\r\n- Kode program\r\n\r\n- Screenshot dashboard\r\n\r\n- Dokumentasi langkah-langkah', '2025-05-05 00:00:00', '2025-04-19 06:54:46'),
(59, 1, 'Visualisasi & Eksplorasi Kode', 'global', 'topik2', 'int ledPin = 13;\r\nint buttonPin = 2;\r\n\r\nvoid setup() {\r\n  pinMode(ledPin, OUTPUT);\r\n  pinMode(buttonPin, INPUT);\r\n}\r\n\r\nvoid loop() {\r\n  int buttonState = digitalRead(buttonPin);\r\n  if (buttonState == HIGH) {\r\n    digitalWrite(ledPin, HIGH);\r\n  } else {\r\n    digitalWrite(ledPin, LOW);\r\n  }\r\n}\r\n\r\n\r\nApa hubungan antara tombol, logika IF, dan LED menyala?', '2025-05-05 00:00:00', '2025-04-19 08:55:57'),
(60, 1, 'Tugas', 'global', 'topik3', 'Tugas Proyek Mini: Buatlah rangkaian dan program Arduino sederhana yang menggabungkan:\r\n\r\n- Sensor cahaya (LDR)\r\n\r\n- Sensor suhu & kelembaban (DHT11)\r\n\r\n- Sensor deteksi objek (IR atau PIR)\r\n\r\nKirimkan dokumentasi berupa:\r\n\r\n- Foto/video rangkaian\r\n\r\n- Kode program Arduino\r\n\r\n- Penjelasan alur kerja sistem secara terintegrasi', '2025-05-05 00:00:00', '2025-04-19 09:34:23'),
(61, 1, 'Studi Kasus: Sistem Peringatan Otomatis', 'global', 'topik4', 'Sebuah sekolah ingin membuat sistem peringatan otomatis. Ketika pintu terbuka secara tiba-tiba saat malam (deteksi gerakan), maka buzzer akan menyala dan lampu akan hidup sebagai tanda peringatan, sementara motor akan otomatis mengunci pintu.\r\n\r\nJelaskan bagaimana aktuator bekerja bersama dalam sistem ini, dan apa peran mikrokontroler dalam mengoordinasikan semuanya.', '2025-05-05 00:00:00', '2025-04-19 09:43:35'),
(62, 1, 'Tugas Proyek Mini', 'global', 'topik4', 'Proyek: Sistem Respons Otomatis Bangunlah sistem menggunakan Arduino yang merespons input dari satu sensor dengan tiga aktuator:\r\n\r\n1. LED: untuk visualisasi\r\n\r\n2. Buzzer: untuk alarm\r\n\r\n3. Servo/Motor DC: untuk simulasi pintu\r\n\r\nKumpulkan:\r\n\r\n- Diagram rangkaian\r\n\r\n- Kode Arduino\r\n\r\n- Penjelasan integrasi antar komponen', '2025-05-05 00:00:00', '2025-04-19 09:44:07'),
(63, 1, 'Studi Kasus Terintegrasi', 'global', 'topik5', 'Kasus: Smart Agriculture Suatu kebun sayur organik menggunakan sistem IoT untuk menyiram otomatis berdasarkan suhu dan kelembaban. Tiba-tiba sistem tidak menyiram secara otomatis.\r\n\r\nPertanyaan:\r\n\r\n1. Apa yang mungkin salah?\r\n\r\n2. Langkah-langkah support apa yang dibutuhkan?', '2025-05-05 00:00:00', '2025-04-19 11:54:43'),
(64, 1, 'Tugas Visual: Desain Sistem Keamanan Sederhana', 'global', 'topik5', 'Deskripsi Tugas:\r\n\r\nBuat rancangan sistem keamanan yang menggunakan keypad untuk input kode dan relay untuk membuka atau menutup kunci pintu elektronik.\r\n\r\nTugas ini bertujuan mengasah kemampuan desain sistem dan pemahaman visual terhadap komponen pendukung dalam IoT.\r\n\r\nKomponen Minimal yang Ditampilkan:\r\n\r\n1. Keypad 4x4\r\n\r\n2. Relay 1 channel\r\n\r\n3. Arduino UNO (atau ESP32)\r\n\r\n4. Motor DC (simulasi sebagai kunci pintu)\r\n\r\nKumpulkan dalam format file .pdf/.docx', '2025-05-05 00:00:00', '2025-04-19 11:55:41');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assignfeedback_comments`
--

CREATE TABLE `mdl_assignfeedback_comments` (
  `id` bigint(10) NOT NULL,
  `submission_id` bigint(10) NOT NULL,
  `user_id` bigint(10) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign_grades`
--

CREATE TABLE `mdl_assign_grades` (
  `id` bigint(10) NOT NULL,
  `assign_id` bigint(10) NOT NULL,
  `user_id` bigint(10) UNSIGNED NOT NULL,
  `grade` decimal(5,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_assign_submission`
--

CREATE TABLE `mdl_assign_submission` (
  `id` bigint(10) NOT NULL,
  `assign_id` bigint(10) NOT NULL,
  `user_id` bigint(10) UNSIGNED NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_assign_submission`
--

INSERT INTO `mdl_assign_submission` (`id`, `assign_id`, `user_id`, `file_path`, `status`, `created_at`) VALUES
(6, 36, 3, 'storage/assignments/KFL7ZNfSq6oYTUX8Po7YefaZjwRYldusnYgwpK3a.pdf', 'submitted', '2025-04-26 06:27:42'),
(7, 43, 1, 'storage/assignments/Y5nsHkOg4X5p1515eWWQhCGw0Q1O8giVfqpOJva5.pdf', 'submitted', '2025-04-28 06:08:30'),
(8, 31, 2, 'storage/assignments/D8TszwiT6wY38BvqzYSV3ctkWmisfOoEGRoGOSg3.pdf', 'submitted', '2025-04-28 06:13:39'),
(9, 31, 1, 'storage/assignments/rdLM0IIhNUBtuvRmKpk2wCKZ8yzIH1kquRImrksc.pdf', 'submitted', '2025-04-28 06:26:48'),
(10, 45, 1, 'storage/assignments/JBYwfjlHr1t6mV0ECfQUhapMLcPq6rdqbQ4FBwaf.pdf', 'submitted', '2025-05-01 16:10:53');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course`
--

CREATE TABLE `mdl_course` (
  `id` bigint(10) NOT NULL,
  `full_name` varchar(1333) NOT NULL,
  `short_name` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `semester` varchar(255) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_course`
--

INSERT INTO `mdl_course` (`id`, `full_name`, `short_name`, `summary`, `semester`, `visible`, `created_at`, `updated_at`) VALUES
(1, 'Internet of Things', 'IN271', 'Mata kuliah ini membahas konsep dasar Internet of Things (IoT), arsitektur sistem IoT, perangkat keras dan perangkat lunak pendukung, serta aplikasi IoT di berbagai bidang. Mahasiswa akan mempelajari pemrograman mikrokontroler (Arduino), integrasi sensor dan aktuator, pemanfaatan jaringan komunikasi IoT, serta perancangan prototipe sistem IoT sederhana. Fokus pembelajaran diarahkan pada pengembangan kemampuan analitis, evaluatif, dan kreatif untuk mengoptimalkan solusi IoT dalam mendukung otomatisasi dan transformasi digital.', '1', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_modules`
--

CREATE TABLE `mdl_course_modules` (
  `id` bigint(10) NOT NULL,
  `course` bigint(10) NOT NULL,
  `modules` bigint(10) NOT NULL,
  `instance` bigint(10) NOT NULL,
  `visible` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_course_subtopik`
--

CREATE TABLE `mdl_course_subtopik` (
  `id` bigint(20) NOT NULL,
  `section_id` bigint(20) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `sortorder` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_files`
--

CREATE TABLE `mdl_files` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `learning_style` enum('active','reflective','sensing','intuitive','visual','verbal','sequential','global') NOT NULL,
  `topik` enum('topik1','topik2','topik3','topik4','topik5','topik6','topik7') NOT NULL,
  `type` enum('active-video','active-image','active-pdf','active-link','reflective-video','reflective-image','reflective-pdf','reflective-link','sensing-video','sensing-image','sensing-pdf','sensing-link','intuitive-video','intuitive-image','intuitive-pdf','intuitive-link','visual-video','visual-image','visual-pdf','visual-link','verbal-video','verbal-image','verbal-pdf','verbal-link','sequential-video','sequential-image','sequential-pdf','sequential-link','global-video','global-image','global-pdf','global-link') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_files`
--

INSERT INTO `mdl_files` (`id`, `course_id`, `name`, `description`, `learning_style`, `topik`, `type`, `file_path`, `created_at`, `deleted_at`) VALUES
(1, 1, 'Pengenalan IoT', 'Video yang menjelaskan bagaimana perangkat IoT berkomunikasi satu sama lain menggunakan animasi yang menarik dan sederhana', 'active', 'topik1', 'active-video', 'https://www.youtube.com/embed/n-f8B76Hozk', '2025-04-03 06:09:49', NULL),
(2, 1, 'Pengantar Penerapan Internet of Things', 'Buku \"PENGANTAR & PENERAPAN INTERNET OF THINGS: Konsep Dasar & Penerapan IoT di Berbagai Sektor\" merupakan panduan komprehensif yang menyajikan pemahaman menyeluruh mengenai konsep dasar serta aplikasi Internet of Things (IoT) dalam berbagai bidang kehidupan. Buku ini membahas sejarah, perkembangan, hingga penerapan praktis IoT di sektor-sektor seperti perhotelan, komputasi, pertanian, dan pendidikan. Dengan bahasa yang jelas serta contoh konkret, buku ini ditujukan bagi pembaca yang ingin memahami dampak dan potensi besar IoT dalam membentuk dunia yang lebih terhubung, efisien, dan cerdas. Buku ini juga membuka ruang bagi kritik dan saran sebagai bentuk kontribusi terhadap pengembangan teknologi IoT di masa depan.', 'reflective', 'topik1', '', '/storage/files/reflective/Pengantar dan Penerapan Internet of Things.pdf', '2025-04-06 11:53:16', NULL),
(3, 1, 'Internet of Things (IoT): Pengertian, Cara Kerja dan Contohnya', '', 'reflective', 'topik1', 'reflective-link', 'https://www.cloudcomputing.id/pengetahuan-dasar/iot-pengertian-contohnya', '2025-04-06 11:54:55', NULL),
(4, 1, 'Pengenalan IoT-Studi Kasus.pdf', '', 'sensing', 'topik1', 'sensing-pdf', '/storage/files/sensing/Pengenalan_IoT_Studi_Kasus.pdf', '2025-04-07 05:47:52', NULL),
(5, 1, 'Peran Internet of Things dalam Revolusi Industri 4.0', 'Materi ini membahas peran penting Internet of Things (IoT) dalam mendukung revolusi Industri 4.0, terutama dalam hal integrasi sistem digital untuk meningkatkan efisiensi, otomatisasi, dan inovasi di sektor industri. IoT memungkinkan pengumpulan data waktu nyata melalui perangkat terhubung, sehingga mempermudah prediksi perawatan dan optimasi proses produksi. Selain memberikan manfaat besar, paragraf ini juga menyoroti tantangan implementasi seperti isu keamanan, biaya, dan standar global yang belum seragam. Penelitian ini bertujuan untuk mengeksplorasi manfaat, tantangan, serta peluang IoT dalam mendukung transformasi digital industri modern.', 'intuitive', 'topik1', 'intuitive-pdf', '/storage/files/intuitive/Peran Internet of Things dalam Revolusi Industri 4.0.pdf\r\n', '2025-04-07 06:28:47', NULL),
(6, 1, 'Pengenalan IoT', 'Video yang menjelaskan bagaimana perangkat IoT berkomunikasi satu sama lain menggunakan animasi yang menarik dan sederhana', 'visual', 'topik1', 'visual-video', 'https://www.youtube.com/embed/vnzrsysjYZ4', '2025-04-07 09:45:33', NULL),
(7, 1, 'Pengenalan IoT', 'Video yang menjelaskan bagaimana perangkat IoT berkomunikasi satu sama lain menggunakan animasi yang menarik dan sederhana', 'visual', 'topik1', 'visual-video', 'https://www.youtube.com/embed/-9YM87KMtfM', '2025-04-07 09:46:19', NULL),
(8, 1, 'Arsitektur Sistem Internet of Things (IoT)', 'Gambar berikut adalah representasi dari arsitektur sistem Internet of Things (IoT) yang terdiri dari empat lapisan utama, yaitu:\r\n\r\n1. Perangkat Sensor (Layer 1)\r\nKomponen dasar IoT untuk mendeteksi atau mengukur data fisik seperti suhu, kelembaban, gerakan, dll.\r\nContoh: GPS, Smart Device, RFID, Sensor.\r\n\r\n2.Jaringan & Gateway (Layer 2)\r\nMenyediakan konektivitas agar data dari sensor dapat dikirim ke sistem pusat.\r\nContoh jaringan: WPAN, WLAN, WWAN, Internet.\r\n\r\n3. Platform (Layer 3)\r\nLapisan untuk pengolahan data, keamanan, analitik, dan integrasi perangkat.\r\nContoh: Data Center, Search Engine, Smart Decision, Info Security, Data Mining.\r\n\r\n4. Aplikasi & Layanan (Layer 4)\r\nLayanan yang dimanfaatkan oleh pengguna akhir berbasis data IoT.\r\nContoh: Smart Logistic, Smart Grid, Green Building, Smart Transport, Environmental Monitoring.', 'visual', 'topik1', 'visual-image', '/storage/files/visual/struktur_iot.png', '2025-04-08 03:13:47', NULL),
(9, 1, 'Materi Pengenalan IoT', 'Berikut slide materi yang berisi rangkuman topik ini, silahkan dipelajari kembali', 'visual', 'topik1', 'visual-pdf', '/storage/files/visual/Materi Pengenalan IoT.pdf', '2025-04-08 04:32:46', NULL),
(10, 1, 'Internet of Things dan Penerapannya', 'Buku ini terdiri dari 14 bab. Pada bab satu membahas\r\ntentang Konsep Dasar Internet of Things. Bab dua membahas\r\ntentang Internet of Things dalam Pertanian. Bab tiga membahas\r\nInternet of Things dalam Pendidikan. Bab empat membahas\r\ntentang Internet of Things dalam Bidang Kesehatan. Bab lima\r\nmembahas Internet of Things dalam Bidang Bisnis. Pada bab enam\r\nmembahas tentang Internet of Things dalam Pemasaran. Bab tujuh\r\nmembahas tentang Internet of Things dalam Bidang Industri. Bab\r\ndelapan membahas tentang Internet of Things untuk Kota Cerdas.\r\nPada bab sembilan pembahasan tentang Internet of Things di\r\nBidang Konstruksi. Bab sepuluh mempelajari tentang Internet of\r\nThings pada Industri Manufaktur. Bab sebelas membahas tentang\r\nperkembangan IoT di Indonesia. Bab duabelas mempelajari\r\ntentang Internet of Thing Menuju Smart People. Bab tigabelas\r\nmembahas tentang Arduino Hardware. Bab empatbelas sebagai\r\nbab penutup membahas tentang contoh Studi Kasus/ Project IoT.\r\nBuku ini dirancang agar dapat digunakan secara terstruktur dalam\r\nmempelajarinya. Sangat disarankan pembaca dapat mempelajari\r\nsetiap tahapan yang terdapat disetiap bab buku ini.', 'verbal', 'topik1', 'verbal-pdf', '/storage/files/verbal/InternetofThingsdanPenerapannya.pdf', '2025-04-08 11:36:17', NULL),
(11, 1, 'IoT | Internet of Things | What is IoT? | How IoT Works?', 'Video ini memberikan penjelasan dasar tentang Internet of Things (IoT), termasuk definisi dan cara kerjanya, dalam durasi sekitar 6 menit. ', 'verbal', 'topik1', 'verbal-video', 'https://www.youtube.com/embed/6mBO2vqLv38', '2025-04-09 10:01:14', NULL),
(12, 1, 'IoT: Teknologi Masa Depan | Bagaimana Internet of Things Mengubah Dunia?', 'Video ini membahas konsep dasar Internet of Things (IoT), sebuah teknologi yang menghubungkan berbagai perangkat ke internet, memungkinkan mereka berkomunikasi dan bekerja secara otomatis tanpa intervensi manusia. Dengan durasi sekitar 9 menit, video ini menjelaskan:\r\n\r\n- Definisi dan prinsip kerja IoT\r\n\r\n- Contoh penerapan IoT dalam kehidupan sehari-hari, seperti smart home dan smart city\r\n\r\n- Manfaat dan tantangan implementasi IoT di berbagai sektor\r\n\r\nVideo ini cocok sebagai materi pengantar bagi pemula yang ingin memahami gambaran umum tentang Internet of Things.', 'global', 'topik1', 'global-video', 'https://www.youtube.com/embed/p0YcfvmUics?start=386', '2025-04-13 12:09:13', NULL),
(13, 1, 'Dampak IoT Pada Industri dan Kegiatan Sehari-hari', 'Artikel di bawah ini membahas tentang dampak besar yang ditimbulkan oleh teknologi Internet of Things (IoT) dalam kehidupan sehari-hari serta sektor industri. IoT telah merambah ke berbagai bidang dan membawa perubahan yang signifikan dalam efisiensi, produktivitas, dan pengambilan keputusan yang lebih tepat dan berbasis data.\r\n\r\nDalam dunia industri, IoT telah memungkinkan pengumpulan dan analisis data real-time, yang sangat berguna dalam pengambilan keputusan yang lebih efektif dan efisien. Misalnya, dalam sektor kesehatan, IoT memungkinkan pemantauan pasien secara jarak jauh, yang membantu mempercepat penanganan medis. Sementara itu, dalam transportasi dan logistik, IoT mempermudah pelacakan barang dan kendaraan, sehingga pengelolaan aliran barang menjadi lebih efisien. Di sektor manufaktur, IoT mengubah cara produksi dan pengawasan dengan memanfaatkan sensor pada mesin untuk mendeteksi masalah sejak dini, yang memungkinkan perawatan preventif.\r\n\r\nDalam kehidupan sehari-hari, IoT juga memberikan dampak besar, seperti rumah pintar yang memungkinkan pengaturan suhu dan pencahayaan secara otomatis, serta kendaraan terhubung yang mendukung navigasi yang lebih aman dan efisien.\r\n\r\nSecara keseluruhan, IoT membawa masa depan yang lebih terhubung dan lebih pintar, dengan manfaat yang dirasakan baik dalam sektor industri maupun kehidupan pribadi kita.', 'global', 'topik1', 'global-link', 'https://www.kompasiana.com/galuh53372/65a8ebd8c57afb285c629212/dampak-iot-pada-industri-dan-kegiatan-sehari-hari', '2025-04-13 12:34:45', NULL),
(14, 1, 'Internet of Things (IoT) Devices Mind Map', 'Gambar diatas merupakan ilustrasi tentang klasifikasi perangkat Internet of Things (IoT) yang terhubung dengan sistem Cloud dan Data Analytics. Di bagian tengah, terdapat dua kategori utama perangkat IoT, yaitu Personal IoT Devices dan Home IoT Devices.\r\n\r\n1. Perangkat personal meliputi smartphone, wearable devices (seperti jam tangan pintar), voice assistant (seperti Alexa atau Google Assistant), smart fashion (pakaian pintar dengan sensor), dan hearables (alat bantu dengar atau earbuds pintar).\r\n\r\n2. Perangkat rumah tangga (Home IoT Devices) mencakup smart plugs, home appliances (peralatan rumah tangga pintar seperti kulkas dan mesin cuci), hubs & controllers (pengontrol pusat seperti smart hub), lighting & climate (pencahayaan dan pengatur suhu pintar), serta entertainment devices (perangkat hiburan seperti smart TV dan speaker pintar).\r\n\r\nSeluruh perangkat ini mengumpulkan dan mengirimkan data ke sistem Cloud & Data Analytics yang berada di pusat, untuk dianalisis secara cerdas demi meningkatkan kenyamanan, efisiensi, dan pengalaman pengguna secara keseluruhan. Gambar ini menunjukkan bagaimana IoT bekerja dalam ekosistem yang saling terhubung dan terintegrasi melalui teknologi cloud.', 'global', 'topik1', 'global-image', '/storage/files/global/Internet of Things (IoT) Devices Mind Map Template.png', '2025-04-13 13:06:17', NULL),
(15, 1, 'Tutorial Dasar Arduino (Dasar Pemrograman Part 1: Dasar-dasar Pembuatan Sketch Program)', 'Video \"Tutorial Dasar Arduino\" ini  menjelaskan tentang Arduino dari dasar. Pada video ini, membahas  tentang:\r\n1. Struktur dasar bahasa pemrograman Arduino yang meliputi fungsi void set up dan void loop.\r\n2. Aturan-aturan penulisan sketch program Arduino', 'active', 'topik2', 'active-video', 'https://www.youtube.com/embed/eTOoPiq6IgM', '2025-04-15 08:30:04', NULL),
(19, 1, 'Pemrograman Arduino Dasar ', 'Mahasiswa memahami konsep dasar pemrograman Arduino dan cara kerja pin input/output melalui penjelasan teori, studi kasus, dan refleksi mandiri.', 'reflective', 'topik2', 'reflective-pdf', '/storage/files/reflective/Pemrograman Arduino Dasar.pdf', '2025-04-16 08:52:41', NULL),
(20, 1, 'arduino.cc', 'Ini adalah halaman resmi dari Arduino.', 'reflective', 'topik2', 'reflective-link', 'https://www.arduino.cc/', '2025-04-16 09:20:44', NULL),
(21, 1, 'tinkercad.com', 'Ini adalah halaman resmi dari Tinkercad.', 'reflective', 'topik2', 'reflective-link', 'https://www.tinkercad.com/', '2025-04-16 09:44:26', NULL),
(22, 1, 'Pengenalan IoT (Internet of Things)\r\n', 'Materi ini membahas tentang konsep pengenalan IoT (Internet of Things)', 'reflective', 'topik1', 'reflective-pdf', '/storage/files/reflective/Pengenalan IoT (Internet of Things).pdf', '2025-04-17 01:49:25', NULL),
(23, 1, 'Apa itu IoT?', 'Page ini mengajarkan kita tentang apa itu IoT', 'reflective', 'topik1', 'reflective-link', 'https://aws.amazon.com/id/what-is/iot/', '2025-04-17 02:39:48', NULL),
(24, 1, 'Sensor Cahaya', 'Sensor ini memiliki tugas menerima input berupa intensitas sinar atau cahaya menjadi konduktivitas (arus listrik). Nilai arus yang dihasilkan sangat bergantung pada kekuatan cahaya yang diterima pada sensor. Sensor yang memiliki tambahan komponen pendukung untuk menjaga peforma lebih baik disebut dengan modul sensor. Terdapat 2 jenis sensor cahaya: Fotovoltaic dan Fotoconductiv.', 'reflective', 'topik3', 'reflective-pdf', '/storage/files/reflective/Sensor Cahaya.pdf', '2025-04-17 02:46:45', NULL),
(25, 1, 'Fotovoltaic\r\n', 'Mengubah sinar atau cahaya matahari menjadi arus listrik DC (Direct Current). Sering dimanfaatkan sebagai sumber energi alternatif yang dikenal dengan Pembangkit Listrik Tenaga Surya (PLTS). Semakin kuat sinar matahari maka arus listrik DC yang dihasilkan semakin besar. Bahan yang dimanfaatkan untuk pembuatan panel surya ini adalah silicon, cadmium sullphide, gallium arsenide dan selenium.', 'reflective', 'topik3', 'reflective-image', '/storage/files/reflective/fotovoltaic.jpg', '2025-04-17 02:54:53', NULL),
(26, 1, 'Fotovoltaic', '', 'reflective', 'topik3', 'reflective-image', '/storage/files/reflective/fotovoltaic2.jpg', '2025-04-17 02:57:30', NULL),
(27, 1, 'Fotoconductiv', 'Mengubah intensitas cahaya menjadi perubahan konduktivitas. Konduktivitas disini adalah kemampuan suatu bahan untuk menghantarkan arus listrik (konduktor). Bahan-bahan yang digunakan untuk konduktor tersebut adalah cadmium selenoide atau cadmium sulfide. Berdasarkan kemampuan konduktor menerima intensitas cahaya terdapat 3 tipe fotoconductiv yaitu Fotoresistor, Fotodioda, Fototransitor.', 'reflective', 'topik3', 'reflective-image', '', '2025-04-17 03:25:54', NULL),
(28, 1, 'LED RGB', 'LED RGB adalah sebuah LED yang dapat mengeluarkan perpaduan warna red(merah), green(hijau), dan blue(biru). LED ini seperti LED biasa memiliki anoda dan katoda hanya saja terdapat 3 anoda pada LED ini mewakili warna red, green, dan blue. Tegangan yang dikeluarkan pada anoda-anoda inilah yang akan mempengaruhi warna nyala dari LED RGB. LED rgb termasuk ke dalam integrated output dan dapat digunakan dengan mengendalikan LED red, green, blue, dan pin com yang dihubungkan ke gnd Arduino. Terdapat 2 jenis LED RGB yaitu yang berbentuk super flux (surface mount device) dan standart (bentuknya sama dengan LED biasa dengan jumlah kaki 4)', 'reflective', 'topik4', 'reflective-image', '/storage/files/reflective/ledrgb.jpg', '2025-04-17 04:32:45', NULL),
(29, 1, 'RGB LED', 'Berikut adalah contoh implementasi LED RGB pada Arduino dan contoh Digital Increment dengan memanfaatkan Seven Segment dan contoh Digital Increment dengan memanfaatkan Seven Segment', 'reflective', 'topik4', 'reflective-video', 'https://www.youtube.com/embed/7QXtHbU-am0', '2025-04-17 04:37:19', NULL),
(30, 1, 'Seven Segment', 'Seven segment sesungguhnya adalah LED yang disusun (segment) sehingga dapat digunakan untuk menampilkan angka desimal. Angka digital menjadi sangat penting untuk menampilkan informasi sebagai bagian panel display seperti pada jam digital, counter, kalkulator dan masih banyak lagi. Seven Segment memiliki 7 segment atau bagian yang bisa dikenalikan ON dan OFF. Susunan segment yang ON sedemikian rupa dapat merepresentasikan angka digital bahkan beberapa huruf. Jika semua segment dalam kondisi ON maka akan terbentuk angka 8. Angka lain yang dapat dihasilkan 0 - 9 dan huruf yang dapat dihasilkan A - F. Beberapa pengembangan seven segment adalah adanya penambahan . (titik) , (koma) dan : (titik dua).\r\n\r\nTerdapat 2 Jenis LED 7 Segment :\r\nCommon Cathode -> ke negatif\r\nCommon Anode -> ke positif', 'reflective', 'topik4', 'reflective-image', '/storage/files/reflective/sevensegment.jpg', '2025-04-17 04:55:59', NULL),
(31, 1, 'Seven Segment', 'Berikut adalah contoh implementasi LED RGB pada Arduino dan contoh Digital Increment dengan memanfaatkan Seven Segment dan contoh Digital Increment dengan memanfaatkan Seven Segment', 'reflective', 'topik4', 'reflective-video', 'https://www.youtube.com/embed/bCLQq_0eWsw', '2025-04-17 05:07:53', NULL),
(32, 1, 'Sensor Suhu', 'Sensor suhu adalah alat yang digunakan untuk mengubah besaran panas menjadi besaran listrik yang dapat dengan mudah dianalisis besarnya. Ada beberapa metode yang digunakan untuk membuat sensor ini, salah satunya dengan cara menggunakan material yang berubah hambatannya terhadap arus listrik sesuai dengan suhunya. TMP36 merupakan salah satu sensor suhu atau temperature sensor yang cukup presisi pengukuran suhu dengan keluaran berupa tegangan output yang berubah secara linear terhadap temperatur Celcius.', 'reflective', 'topik3', 'reflective-image', '/storage/files/reflective/sensorsuhu.jpg', '2025-04-17 05:18:38', NULL),
(33, 1, 'Buzzer', 'Merupakan alat keluaran (output) yang mengubah sinyal listrik menjadi getaran suara, disebut juga dengan beeper atau piezoelectric. Karena memili ciri khas menghasilkan suara atau bunyi-bunyian maka buzzer dapat digunakan sebagai indikator suatu keadaan atau kondisi situasi tertentu. Buzzer dapat ditrigger untuk berbunyi dengan adanya tegangan kerja 3 volt hingga 12 volt. Yang dapat digunakan oleh Arduino yang tegangan dibawah 5 volt.', 'reflective', 'topik4', 'reflective-image', '/storage/files/reflective/buzzer.jpg', '2025-04-17 05:23:23', NULL),
(34, 1, 'Buzzer', 'Merupakan alat keluaran (output) yang mengubah sinyal listrik menjadi getaran suara, disebut juga dengan beeper atau piezoelectric. Karena memili ciri khas menghasilkan suara atau bunyi-bunyian maka buzzer dapat digunakan sebagai indikator suatu keadaan atau kondisi situasi tertentu. Buzzer dapat ditrigger untuk berbunyi dengan adanya tegangan kerja 3 volt hingga 12 volt. Yang dapat digunakan oleh Arduino yang tegangan dibawah 5 volt.', 'reflective', 'topik4', 'reflective-image', '/storage/files/reflective/buzzer2.jpg', '2025-04-17 05:26:58', NULL),
(35, 1, 'Servo', 'Motor servo adalah motor dengan torsi besar dan dengan sudut yang bisa diatur. Motor ini hampir sama dengan motor stepper hanya saja motor servo memiliki gerak terbatas. Motor stepper dapat berputar 360o sedangkan motor servo hanya dapat berputar 180o atau 90o saja. Motor servo lebih mudah untuk dikontrol sudutnya karena menggunakan basis PWM.', 'reflective', 'topik4', 'reflective-image', '/storage/files/reflective/servo.jpeg', '2025-04-17 05:31:48', NULL),
(36, 1, 'Relay', 'Relay termasuk dalam kategori sakelar yang bekerja dengan basis elektromagnetik untuk menggerakkan (switch) kontaktor keposisi tertentu. NC (Normally Close) : Kondisi awal dimana relai pada posisi tertutup, tetapi saat tealiri arus maka akan ke posisi terbuka. NO (Normally Open) : Merupakan kebalikan dari NC yang dimana kondisi awal relai pada posisi Open, tetapi saat tealiri arus maka akan ke posisi tertutup.\r\n\r\nRelay biasanya menggunakan kumparan/coil sebagai media untuk mengontrol switch. Cara kerjanya adalah ketika kumparan dialiri arus listrik, maka pada kumparan dihasilkan medan magnet yang akan menarik plat konduktor yang berfungsi sebagai switch sehingga berpindah titik yang lain, sebagai ilustrasi diatas, kumparan terletak diantara kaki 4-5. Sedangkan plat yang dimaksud adalah pada kaki 1 yang akan \"berpindah\" dari plat 2 ke 3 dan sebaliknya. Terdapat 2 jenis relay yang dapat digunakan pada tingkercad yaitu SPDT dan DPDT.', 'reflective', 'topik5', 'reflective-image', '/storage/files/reflective/relay.jpeg', '2025-04-17 05:39:46', NULL),
(37, 1, 'Relay SPDT (Single Pole Dual Throw)', 'Relay SPDT (Single Pole Dual Throw) adalah komponen elektronik yang berfungsi sebagai saklar otomatis yang memungkinkan kontrol terhadap perangkat listrik melalui sinyal digital dari mikrokontroler seperti Arduino. Relay SPDT memiliki satu kontak input (pole) dan dua kontak output (throw), memungkinkan pengguna untuk mengalihkan arus ke salah satu dari dua jalur yang berbeda. Ketika sinyal diberikan dari Arduino, relay SPDT mengubah posisinya, sehingga aliran listrik dialihkan ke perangkat yang ditentukan.\r\n\r\nDalam konteks Internet of Things (IoT), relay SPDT berperan penting dalam mengontrol perangkat atau sistem listrik dari jarak jauh atau otomatis. Berikut beberapa contoh aplikasi relay SPDT yang dikendalikan oleh Arduino dalam IoT:\r\n\r\n1. Sistem Otomatisasi Rumah Pintar: Relay SPDT sering digunakan untuk mengontrol peralatan rumah tangga seperti lampu, kipas angin, atau bahkan pintu otomatis. Dengan menghubungkan relay ke Arduino dan jaringan IoT, pengguna dapat menyalakan atau mematikan perangkat tersebut dari smartphone atau aplikasi IoT, meningkatkan kenyamanan dan efisiensi energi.\r\n\r\n2. Pengendalian Beban Listrik pada Industri: Dalam aplikasi IoT industri, relay SPDT digunakan untuk mengontrol beban listrik besar, seperti motor atau pemanas. Arduino yang dikendalikan dari sistem IoT mengirimkan sinyal ke relay, memungkinkan kontrol otomatis atas beban ini sesuai kebutuhan operasional, seperti penjadwalan otomatis atau pengendalian berdasarkan kondisi tertentu.\r\n\r\n3. Keamanan dan Sistem Alarm: Relay SPDT juga digunakan dalam sistem keamanan berbasis IoT untuk mengaktifkan atau menonaktifkan sirine, lampu darurat, atau pengunci pintu otomatis saat sensor mendeteksi adanya intrusi atau peringatan. Ketika sensor mendeteksi aktivitas yang mencurigakan, Arduino dapat mengirim sinyal ke relay untuk memicu tindakan keamanan.\r\n\r\n4. Sistem Kendali Pompa Air Otomatis: Dalam aplikasi IoT untuk pertanian atau irigasi pintar, relay SPDT digunakan untuk mengendalikan pompa air. Berdasarkan data dari sensor kelembaban tanah, Arduino dapat mengirim sinyal untuk menyalakan atau mematikan pompa melalui relay, sehingga irigasi hanya berjalan saat diperlukan.\r\n\r\n5. Pengaturan Sumber Daya Listrik Cadangan: Relay SPDT dapat berfungsi sebagai saklar otomatis untuk mengalihkan sumber daya listrik, misalnya dari listrik utama ke baterai cadangan. Dalam aplikasi IoT, Arduino mengendalikan relay untuk memastikan perangkat tetap mendapatkan daya, bahkan jika ada pemadaman listrik.\r\n\r\nRelay SPDT pada Arduino sangat berguna dalam IoT karena memungkinkan kontrol dari jarak jauh dan otomatis pada perangkat bertegangan tinggi yang tidak dapat langsung dikendalikan oleh mikrokontroler. Integrasinya dalam sistem IoT memungkinkan penggunaan listrik yang lebih efisien, pengendalian perangkat yang lebih aman, dan otomatisasi dalam berbagai aplikasi.\r\n', 'reflective', 'topik5', 'reflective-image', '/storage/files/reflective/relayspdt.jpg', '2025-04-17 05:43:58', NULL),
(38, 1, 'Relay DPDT', 'Relay DPDT (Dual Pole Dual Throw) adalah jenis relay yang memiliki dua kontak input (dual pole) dan dua set kontak output (dual throw), sehingga memungkinkan pengalihan dua rangkaian listrik secara bersamaan dengan satu sinyal kendali. Berbeda dengan Relay SPDT (Single Pole Dual Throw), yang hanya memiliki satu kontak input dan dua output, Relay DPDT dapat mengendalikan dua jalur listrik independen, menjadikannya lebih fleksibel dalam pengaturan otomatisasi dan kontrol dalam aplikasi IoT (Internet of Things).\r\n\r\nPenggunaan Relay DPDT pada Arduino dalam IoT memberikan beberapa keuntungan, terutama dalam situasi yang memerlukan pengalihan ganda atau pengendalian rangkaian listrik yang lebih kompleks. Berikut beberapa contoh aplikasi Relay DPDT dalam sistem IoT:\r\n\r\n1. Sistem Kendali Motor dalam Otomatisasi Rumah dan Industri: Relay DPDT dapat digunakan untuk mengendalikan arah putaran motor listrik dengan mengubah polaritas. Arduino yang dikendalikan melalui IoT dapat mengirim sinyal ke relay untuk mengubah arah putaran motor, misalnya untuk membuka dan menutup tirai otomatis di rumah pintar atau mengendalikan conveyor di lini produksi industri.\r\n\r\n2. Kontrol Sumber Daya Listrik Ganda: Dalam aplikasi IoT yang memerlukan pengalihan otomatis antara dua sumber daya, seperti dari sumber utama ke sumber daya cadangan, Relay DPDT memungkinkan pengalihan otomatis antara kedua sumber ini. Ketika sinyal diterima dari Arduino, relay mengalihkan arus ke sumber daya yang aktif, memastikan perangkat tetap beroperasi meski ada gangguan daya utama.\r\n\r\n3. Sistem Pencahayaan Ganda: Pada sistem pencahayaan berbasis IoT, Relay DPDT dapat digunakan untuk mengalihkan arus ke dua jalur pencahayaan berbeda. Dengan bantuan Arduino, sistem IoT dapat menentukan jenis pencahayaan yang diaktifkan, seperti lampu utama atau lampu redup, tergantung pada kebutuhan dan kondisi lingkungan.\r\n\r\n4. Sistem Pengendalian Keamanan dan Alarm Ganda: Relay DPDT memungkinkan kontrol lebih kompleks dalam sistem keamanan IoT, di mana dua perangkat berbeda dapat diaktifkan secara bersamaan, misalnya menghidupkan sirine dan menyalakan lampu darurat saat sensor mendeteksi ancaman. Dengan Arduino sebagai pengendali, relay dapat memicu kedua perangkat secara bersamaan untuk memberikan respons keamanan yang lebih efektif.\r\n\r\n5. Kendali Perangkat Elektronik Bertegangan Ganda: Dalam beberapa aplikasi IoT, seperti panel kontrol di bangunan pintar atau pusat data, Relay DPDT dapat mengelola dua rangkaian listrik yang berbeda pada satu waktu. Hal ini memungkinkan penggunaan perangkat dengan tegangan berbeda dalam satu sistem, yang dikendalikan secara otomatis melalui sinyal dari Arduino.\r\n\r\nKeunggulan Relay DPDT dibandingkan Relay SPDT adalah kemampuannya untuk mengalihkan dua rangkaian listrik sekaligus, sehingga cocok untuk aplikasi yang memerlukan pengaturan lebih kompleks atau pengendalian ganda. Penggunaannya dalam sistem IoT memungkinkan pengalihan arus yang lebih fleksibel dan otomatisasi yang lebih komprehensif, memperluas opsi kendali dan efisiensi di berbagai lingkungan, baik industri maupun rumah pintar.', 'reflective', 'topik5', 'reflective-image', '/storage/files/reflective/relaydpdt.jpg', '2025-04-17 05:46:49', NULL),
(39, 1, 'IoT Communication Network', 'Internet of Things (IoT) merevolusi cara perangkat terhubung dan berkomunikasi, menciptakan ekosistem yang mampu berbagi data secara otomatis untuk berbagai aplikasi. IoT Communication Network mengacu pada teknologi, protokol, dan infrastruktur yang memungkinkan perangkat IoT terhubung satu sama lain, baik melalui jaringan lokal maupun internet. Jaringan ini berperan penting dalam mentransmisikan data dari sensor ke perangkat pemrosesan, hingga akhirnya mengaktifkan actuator untuk menghasilkan respons tertentu.', 'reflective', 'topik6', 'reflective-image', '/storage/files/reflective/iot.png', '2025-04-17 05:53:37', NULL),
(40, 1, 'WiFi', '1. Memungkinkan perangkat IoT terhubung langsung ke internet melalui jaringan nirkabel.\r\n2. Contoh perangkat: ESP-12/8266, ESP32, ESP01.', 'reflective', 'topik6', 'reflective-image', '/storage/files/reflective/wifi.jpg', '2025-04-17 05:55:19', NULL),
(41, 1, 'Bluetooth', '1. Cocok untuk komunikasi jarak dekat, termasuk varian Bluetooth Low Energy (BLE) yang hemat daya.\r\n2. Contoh perangkat: HC-05, HC-06, ESP32.', 'reflective', 'topik6', 'reflective-image', '/storage/files/reflective/bluetooth.png', '2025-04-17 05:56:25', NULL),
(42, 1, 'Cellular', '1. Menggunakan jaringan seluler seperti 2G, 4G LTE, atau 5G untuk komunikasi jarak jauh, tanpa bergantung pada Wi-Fi.\r\n2. Contoh perangkat: SIM800, SIM900.', 'reflective', 'topik6', 'reflective-image', '/storage/files/reflective/cellular.png', '2025-04-17 05:57:09', NULL),
(43, 1, 'Komunikasi Serial Arduino Uno R3 Built In IoT Wifi ESP8266', '', 'reflective', 'topik6', 'reflective-video', 'https://www.youtube.com/embed/DzECItyOR4M', '2025-04-17 05:58:31', NULL),
(44, 1, 'Blynk', 'Blynk adalah platform pengembangan untuk Internet of Things (IoT) yang memungkinkan pengguna untuk membuat aplikasi mobile untuk mengendalikan perangkat keras seperti mikrokontroler (misalnya Arduino, ESP8266, ESP32, Raspberry Pi, dll.) dengan cara yang sangat sederhana dan cepat. Blynk menyediakan antarmuka pengguna (UI) berbasis aplikasi smartphone yang memungkinkan kontrol dan pemantauan perangkat IoT dari jarak jauh.\r\n\r\nFitur Utama Blynk:\r\n1. Antarmuka Pengguna (UI) yang Mudah:\r\n\r\nBlynk menyediakan antarmuka yang dapat dikustomisasi, di mana Anda dapat menambahkan berbagai widget (seperti tombol, slider, indikator, grafik, dll.) untuk mengendalikan dan memantau perangkat IoT Anda melalui aplikasi mobile. Aplikasi Blynk tersedia untuk Android dan iOS, memudahkan pengguna untuk mengaksesnya dari berbagai perangkat.\r\n\r\n2. Protokol Komunikasi:\r\n\r\n- Blynk menggunakan protokol komunikasi Blynk Cloud atau Blynk Local Server untuk memungkinkan komunikasi antara aplikasi mobile dan perangkat keras. Blynk mendukung berbagai konektivitas jaringan seperti WiFi, Ethernet, Bluetooth, dan 4G/3G, memungkinkan perangkat IoT untuk terhubung ke internet dengan cara yang fleksibel.\r\n\r\n3. Mendukung Banyak Platform Perangkat Keras:\r\n\r\n- Blynk mendukung berbagai jenis papan pengembangan, seperti Arduino, ESP8266, ESP32, Raspberry Pi, dan lain-lain, sehingga sangat cocok untuk prototyping dan proyek IoT. Dengan Blynk Library, pengguna dapat dengan mudah menghubungkan papan mikrokontroler ke aplikasi mobile dan mulai mengendalikan perangkat.\r\n\r\n4. Fitur Keamanan:\r\n\r\nUntuk komunikasi yang aman antara aplikasi dan perangkat, Blynk menyediakan token otentikasi yang unik untuk setiap perangkat yang Anda buat di platform Blynk.\r\n\r\n5. Kemudahan Penggunaan:\r\n\r\nPlatform Blynk sangat populer karena kemudahan pengaturannya, bahkan untuk pemula. Pengguna tidak perlu menulis kode untuk antarmuka pengguna atau aplikasi mobile, cukup dengan drag-and-drop widget dan menghubungkannya dengan perangkat keras.\r\n\r\nKelebihan Blynk:\r\n\r\n1. User-friendly: Antarmuka grafis yang intuitif, memudahkan pembuatan aplikasi IoT tanpa memerlukan pengalaman pengembangan aplikasi mobile.\r\n\r\n2. Fleksibilitas: Mendukung berbagai jenis perangkat keras dan koneksi jaringan, sehingga dapat digunakan di berbagai proyek IoT.\r\n\r\n3. Cepat untuk Prototyping: Mempercepat proses pengembangan dan eksperimen proyek IoT.\r\n\r\n4. Komunitas Besar: Ada banyak tutorial, forum, dan sumber daya dari komunitas pengguna Blynk yang dapat membantu dalam pengembangan.\r\n\r\nKekurangan Blynk:\r\n\r\n1. Bergantung pada Blynk Cloud (untuk penggunaan gratis): Untuk penggunaan gratis, Anda harus terhubung dengan Blynk Cloud. Jika Anda ingin menggunakan server lokal atau membutuhkan lebih banyak fungsionalitas, Anda harus membayar langganan premium.\r\n\r\n2. Keterbatasan dalam Pengembangan Aplikasi Kustom: Meski aplikasi Blynk mudah digunakan, jika Anda memerlukan fungsionalitas yang lebih spesifik atau kustomisasi aplikasi lebih lanjut, Anda mungkin membutuhkan keahlian lebih lanjut dalam pengembangan aplikasi mobile.\r\n\r\n\r\nCara Kerja Blynk:\r\n1. Buat Proyek di Aplikasi Blynk:\r\n\r\nAnda mulai dengan membuat proyek baru di aplikasi Blynk dan memilih jenis perangkat keras yang akan digunakan (misalnya ESP8266 atau Arduino). Setelah itu, Anda akan mendapatkan Blynk Token yang digunakan untuk menghubungkan aplikasi dengan perangkat keras.\r\n\r\n2. Program Perangkat Keras:\r\n\r\nAnda mengupload program ke papan mikrokontroler Anda menggunakan Blynk library dan memasukkan token yang diterima sebelumnya. Token ini memungkinkan perangkat untuk terhubung ke Blynk Cloud atau server lokal. Dalam program, Anda akan menentukan bagaimana perangkat berkomunikasi dengan aplikasi (misalnya, membaca sensor, menghidupkan atau mematikan LED, dll.).\r\n\r\n3. Kendalikan Perangkat dari Aplikasi Blynk:\r\n\r\nSetelah perangkat terhubung ke Blynk, Anda dapat mengendalikan perangkat dan memantau data dari perangkat secara real-time langsung dari aplikasi Blynk di smartphone Anda. Misalnya, Anda bisa menyalakan/mematikan lampu, membaca data sensor suhu, atau memantau status perangkat lainnya.', 'reflective', 'topik7', 'reflective-image', '', '2025-04-17 06:09:19', NULL),
(45, 1, 'Thingspeak', 'ThingSpeak adalah platform berbasis cloud untuk Internet of Things (IoT) yang memungkinkan pengumpulan, analisis, dan visualisasi data dari perangkat IoT secara real-time. ThingSpeak memungkinkan perangkat untuk mengirimkan data ke cloud, yang kemudian dapat dipantau dan dianalisis melalui antarmuka berbasis web.\r\n\r\nPlatform ini sangat populer di kalangan pengembang IoT dan peneliti karena kemudahan penggunaannya dan kemampuannya untuk menangani data dari berbagai sensor serta integrasi dengan alat analitik lainnya.\r\n\r\nFitur Utama ThingSpeak:\r\n1. Pengumpulan Data dari Perangkat IoT:\r\n\r\nThingSpeak memungkinkan perangkat seperti Arduino, ESP8266, Raspberry Pi, atau perangkat lainnya untuk mengirimkan data ke cloud. Data ini bisa berasal dari berbagai sensor, seperti sensor suhu, kelembaban, kualitas udara, tekanan, dan banyak lagi. Perangkat mengirimkan data ke ThingSpeak melalui HTTP atau MQTT (protokol komunikasi ringan untuk IoT).\r\nVisualisasi Data:\r\n\r\n2. ThingSpeak menyediakan fitur untuk menampilkan data dalam bentuk grafik dan diagram secara real-time. Visualisasi ini memungkinkan pengguna untuk memantau dan menganalisis data yang terkumpul dengan mudah. Misalnya, Anda bisa melihat grafik suhu, kelembaban, atau data sensor lainnya yang diperbarui secara langsung.\r\n\r\n3. Pengolahan dan Analisis Data:\r\n\r\nThingSpeak mendukung analisis data dengan integrasi MATLAB. Anda dapat melakukan analisis lanjutan pada data yang terkumpul menggunakan MATLAB, yang memberikan kemampuan analitik yang kuat untuk mengolah data.\r\nDengan MATLAB, Anda bisa mengembangkan model matematis, analisis statistik, atau algoritma pemrosesan data untuk mendapatkan wawasan lebih dalam dari data yang dikumpulkan.\r\n\r\n4. Pemrograman dan Otomatisasi:\r\n\r\nThingSpeak memungkinkan Anda untuk membuat aplikasi otomatisasi IoT. Misalnya, Anda dapat menulis script untuk mengambil tindakan tertentu berdasarkan data yang diterima, seperti mengirimkan notifikasi atau mengubah status perangkat tertentu (misalnya menyalakan kipas jika suhu mencapai nilai tertentu).\r\nThingSpeak memiliki fitur untuk triggering dan webhooks yang memungkinkan Anda untuk berinteraksi dengan perangkat lainnya atau platform lain.\r\n\r\n5. Integrasi dengan Layanan Lain:\r\n\r\nThingSpeak mendukung integrasi dengan berbagai layanan dan aplikasi lain, seperti IFTTT (If This Then That), yang memungkinkan Anda untuk menghubungkan ThingSpeak dengan layanan lain untuk melakukan tindakan otomatis berdasarkan kondisi tertentu.\r\nPlatform ini juga mendukung RESTful API yang memungkinkan perangkat eksternal atau aplikasi lain untuk berinteraksi dengan data di ThingSpeak.\r\n\r\nCara Kerja ThingSpeak:\r\n1. Buat Channel di ThingSpeak:\r\n\r\nPertama, pengguna membuat channel di ThingSpeak. Channel adalah tempat untuk menyimpan data dari perangkat atau sensor.\r\nSetiap channel dapat memiliki hingga 8 saluran data (misalnya, suhu, kelembaban, cahaya, dll.), yang dapat dikumpulkan dari berbagai perangkat.\r\n\r\n2. Kirim Data ke ThingSpeak:\r\n\r\nPerangkat IoT, seperti Arduino atau ESP8266, mengirimkan data ke channel ThingSpeak menggunakan HTTP requests. ThingSpeak menyediakan API untuk mengirimkan data ke channel yang sudah dibuat.\r\nMisalnya, sebuah perangkat dapat mengirimkan nilai suhu setiap menit ke ThingSpeak.\r\n\r\n3. Visualisasi dan Analisis Data:\r\n\r\nData yang dikirimkan ke ThingSpeak dapat divisualisasikan dalam bentuk grafik di dashboard ThingSpeak.\r\nAnda juga dapat melakukan analisis lanjutan menggunakan MATLAB yang disediakan oleh ThingSpeak untuk menggali lebih dalam data yang terkumpul.\r\n\r\n4. Mengambil Tindakan Berdasarkan Data:\r\n\r\nBerdasarkan data yang dikumpulkan, Anda dapat mengonfigurasi ThingSpeak untuk melakukan tindakan otomatis, seperti mengirimkan peringatan melalui email atau SMS jika data mencapai ambang tertentu.\r\nThingSpeak juga mendukung pengaturan webhook untuk menghubungkan ke aplikasi lain (misalnya, mengirimkan data ke platform lain seperti Google Sheets, atau trigger sistem lain).\r\n\r\nKelebihan ThingSpeak:\r\n\r\n1. Mudah Digunakan: Antarmuka berbasis web yang mudah digunakan memungkinkan pengguna untuk cepat memulai tanpa memerlukan banyak pengetahuan teknis.\r\n\r\n2. Integrasi MATLAB: Analisis data yang lebih canggih dan pengolahan data dengan MATLAB memungkinkan pengembang untuk menjalankan model statistik atau algoritma pembelajaran mesin pada data IoT mereka.\r\n \r\n3. Cloud-based: ThingSpeak adalah platform cloud, sehingga memungkinkan akses data dan visualisasi dari mana saja tanpa perlu mengelola server secara lokal.\r\n\r\n4. Gratis untuk Penggunaan Dasar: ThingSpeak menawarkan penggunaan gratis dengan batasan tertentu, yang cocok untuk banyak proyek IoT sederhana dan eksperimental.\r\n\r\nKekurangan ThingSpeak:\r\n\r\n1. Batasan pada Akun Gratis: Pengguna gratis memiliki keterbatasan dalam hal jumlah data yang dapat dikirimkan, kecepatan pembaruan data, dan jumlah saluran yang tersedia.\r\n\r\n2. Keterbatasan Fitur Analitik: Meskipun MATLAB integrasi menawarkan banyak kemungkinan analisis, penggunanya mungkin membutuhkan keterampilan analitik yang lebih tinggi untuk memanfaatkannya sepenuhnya.\r\n\r\n3. Keamanan dan Privasi: Karena ThingSpeak adalah platform cloud, ada kemungkinan risiko terkait dengan privasi dan keamanan data yang dikirimkan melalui internet.\r\n\r\nPenggunaan Umum ThingSpeak:\r\n\r\n1. Pemantauan Lingkungan: Menggunakan sensor untuk memantau kualitas udara, suhu, kelembaban, atau parameter lingkungan lainnya.\r\n\r\n2. Proyek Smart Home: Mengendalikan perangkat rumah pintar atau memantau parameter seperti suhu dan kelembaban untuk otomatisasi rumah.\r\n\r\n3. Pemantauan Kesehatan: Menggunakan sensor untuk memantau tanda-tanda vital atau kondisi medis tertentu, dan mengirimkan data ke ThingSpeak untuk analisis lebih lanjut.\r\n\r\n4. Proyek Riset: Banyak digunakan dalam proyek penelitian untuk mengumpulkan data dari eksperimen lapangan atau perangkat sensor.\r\n\r\nSecara keseluruhan, ThingSpeak adalah platform yang sangat berguna bagi pengembang IoT, peneliti, dan hobiis yang ingin mengumpulkan dan menganalisis data sensor secara efisien, dengan kemampuan untuk memvisualisasikan data dalam bentuk yang mudah dipahami dan melakukan analisis yang lebih lanjut menggunakan MATLAB.', 'reflective', 'topik7', 'reflective-image', '/storage/files/reflective/thingspeak.jpeg', '2025-04-17 06:13:32', NULL),
(46, 1, 'Apa itu IoT?', 'IoT adalah jaringan perangkat yang saling terhubung dan saling bertukar data melalui internet.\r\n\r\nContoh sederhana: Smart Bulb, Smartwatch, Smart AC.', 'sensing', 'topik1', 'sensing-image', '', '2025-04-17 06:30:20', NULL),
(47, 1, 'Arsitektur IoT', 'Arsitektur IoT (4 Lapisan Umum):\r\n\r\n1. Perception Layer (Perangkat Sensor)\r\nContoh: Sensor suhu, PIR sensor, servo motor, GPS, Smart Device, RFID.\r\n\r\n2. Network Layer (Jaringan dan Gateway)\r\nContoh: WiFi, Bluetooth, Zigbee, WWAN, WPAN, WLAN, WMAN).\r\n\r\n3. Processing Layer (Perangkat, Security, Analytic, dll)\r\nContoh: Raspberry Pi, Cloud, Edge Computing, Data Center, Search Engine, Smart Decision, Info Security, Data Mining.\r\n\r\n4. Application Layer (Aplikasi dan Layanan)\r\nContoh: Aplikasi Blynk, Home Assistant, Smart Grid, dll.', 'sensing', 'topik1', 'sensing-image', '/storage/files/sensing/struktur_iot.png', '2025-04-17 06:36:00', NULL),
(48, 1, 'Tabel Pin (Arduino Uno)', 'Arduino adalah mikrokontroler open-source yang digunakan untuk mengontrol perangkat elektronik.\r\n\r\nContoh papan: Arduino Uno, Arduino Nano, Arduino Mega.\r\n\r\nInput & Output\r\n1. Input Digital: Push Button (HIGH/LOW)\r\n\r\n2. Output Digital: LED, Relay\r\n\r\n3. Input Analog: Potensiometer, Sensor LDR\r\n\r\n4. Output PWM: LED dimmer, Servo Motor', 'sensing', 'topik2', 'sensing-link', 'https://www.aldyrazor.com/2020/05/pin-arduino.html', '2025-04-17 06:47:25', NULL),
(49, 1, 'Sensor Cahaya', 'Sensor ini memiliki tugas menerima input berupa intensitas sinar atau cahaya menjadi konduktivitas (arus listrik). Nilai arus yang dihasilkan sangat bergantung pada kekuatan cahaya yang diterima pada sensor. Sensor yang memiliki tambahan komponen pendukung untuk menjaga peforma lebih baik disebut dengan modul sensor. Terdapat 2 jenis sensor cahaya: Fotovoltaic dan Fotoconductiv.', 'sensing', 'topik3', 'sensing-pdf', '/storage/files/sensing/Sensor Cahaya.pdf', '2025-04-17 12:10:18', NULL),
(50, 1, 'Fotovoltaic', 'Mengubah sinar atau cahaya matahari menjadi arus listrik DC (Direct Current). Sering dimanfaatkan sebagai sumber energi alternatif yang dikenal dengan Pembangkit Listrik Tenaga Surya (PLTS). Semakin kuat sinar matahari maka arus listrik DC yang dihasilkan semakin besar. Bahan yang dimanfaatkan untuk pembuatan panel surya ini adalah silicon, cadmium sullphide, gallium arsenide dan selenium.', 'sensing', 'topik3', 'sensing-image', '/storage/files/sensing/fotovoltaic.jpg', '2025-04-17 12:10:49', NULL),
(51, 1, 'Fotovoltaic', '', 'sensing', 'topik3', 'sensing-image', '/storage/files/sensing/fotovoltaic2.jpg', '2025-04-17 12:11:13', NULL),
(52, 1, 'Fotoconductiv', 'Mengubah intensitas cahaya menjadi perubahan konduktivitas. Konduktivitas disini adalah kemampuan suatu bahan untuk menghantarkan arus listrik (konduktor). Bahan-bahan yang digunakan untuk konduktor tersebut adalah cadmium selenoide atau cadmium sulfide. Berdasarkan kemampuan konduktor menerima intensitas cahaya terdapat 3 tipe fotoconductiv yaitu Fotoresistor, Fotodioda, Fototransitor.', 'sensing', 'topik3', 'sensing-image', '', '2025-04-17 12:11:42', NULL),
(53, 1, 'Sensor Suhu', 'Sensor suhu adalah alat yang digunakan untuk mengubah besaran panas menjadi besaran listrik yang dapat dengan mudah dianalisis besarnya. Ada beberapa metode yang digunakan untuk membuat sensor ini, salah satunya dengan cara menggunakan material yang berubah hambatannya terhadap arus listrik sesuai dengan suhunya. TMP36 merupakan salah satu sensor suhu atau temperature sensor yang cukup presisi pengukuran suhu dengan keluaran berupa tegangan output yang berubah secara linear terhadap temperatur Celcius.', 'sensing', 'topik3', 'sensing-image', '/storage/files/sensing/sensorsuhu.jpg', '2025-04-17 12:12:05', NULL),
(54, 1, 'Implementasi sensor suhu pada micro controller ', '', 'sensing', 'topik3', 'sensing-video', 'https://www.youtube.com/embed/OogldLc9uYc', '2025-04-17 12:14:40', NULL),
(55, 1, 'LED RGB', 'LED RGB adalah sebuah LED yang dapat mengeluarkan perpaduan warna red(merah), green(hijau), dan blue(biru). LED ini seperti LED biasa memiliki anoda dan katoda hanya saja terdapat 3 anoda pada LED ini mewakili warna red, green, dan blue. Tegangan yang dikeluarkan pada anoda-anoda inilah yang akan mempengaruhi warna nyala dari LED RGB. LED rgb termasuk ke dalam integrated output dan dapat digunakan dengan mengendalikan LED red, green, blue, dan pin com yang dihubungkan ke gnd Arduino. Terdapat 2 jenis LED RGB yaitu yang berbentuk super flux (surface mount device) dan standart (bentuknya sama dengan LED biasa dengan jumlah kaki 4)', 'sensing', 'topik4', 'sensing-image', '/storage/files/sensing/ledrgb.jpg', '2025-04-17 12:22:11', NULL),
(56, 1, 'RGB LED', 'Berikut adalah contoh implementasi LED RGB pada Arduino dan contoh Digital Increment dengan memanfaatkan Seven Segment dan contoh Digital Increment dengan memanfaatkan Seven Segment', 'sensing', 'topik4', 'sensing-video', 'https://www.youtube.com/embed/7QXtHbU-am0', '2025-04-17 12:22:37', NULL),
(57, 1, 'Seven Segment', 'Seven segment sesungguhnya adalah LED yang disusun (segment) sehingga dapat digunakan untuk menampilkan angka desimal. Angka digital menjadi sangat penting untuk menampilkan informasi sebagai bagian panel display seperti pada jam digital, counter, kalkulator dan masih banyak lagi. Seven Segment memiliki 7 segment atau bagian yang bisa dikenalikan ON dan OFF. Susunan segment yang ON sedemikian rupa dapat merepresentasikan angka digital bahkan beberapa huruf. Jika semua segment dalam kondisi ON maka akan terbentuk angka 8. Angka lain yang dapat dihasilkan 0 - 9 dan huruf yang dapat dihasilkan A - F. Beberapa pengembangan seven segment adalah adanya penambahan . (titik) , (koma) dan : (titik dua).\r\n\r\nTerdapat 2 Jenis LED 7 Segment :\r\n1. Common Cathode -> ke negatif\r\n2. Common Anode -> ke positif', 'sensing', 'topik4', 'sensing-image', '/storage/files/reflective/sevensegment.jpg', '2025-04-17 12:23:15', NULL),
(58, 1, 'Seven Segment', 'Berikut adalah contoh implementasi LED RGB pada Arduino dan contoh Digital Increment dengan memanfaatkan Seven Segment dan contoh Digital Increment dengan memanfaatkan Seven Segment', 'sensing', 'topik4', 'sensing-video', 'https://www.youtube.com/embed/bCLQq_0eWsw', '2025-04-17 12:23:42', NULL),
(59, 1, 'Buzzer', 'Merupakan alat keluaran (output) yang mengubah sinyal listrik menjadi getaran suara, disebut juga dengan beeper atau piezoelectric. Karena memili ciri khas menghasilkan suara atau bunyi-bunyian maka buzzer dapat digunakan sebagai indikator suatu keadaan atau kondisi situasi tertentu. Buzzer dapat ditrigger untuk berbunyi dengan adanya tegangan kerja 3 volt hingga 12 volt. Yang dapat digunakan oleh Arduino yang tegangan dibawah 5 volt.', 'sensing', 'topik4', 'sensing-image', '/storage/files/sensing/buzzer.jpg', '2025-04-17 12:24:06', NULL),
(60, 1, 'Buzzer', 'Merupakan alat keluaran (output) yang mengubah sinyal listrik menjadi getaran suara, disebut juga dengan beeper atau piezoelectric. Karena memili ciri khas menghasilkan suara atau bunyi-bunyian maka buzzer dapat digunakan sebagai indikator suatu keadaan atau kondisi situasi tertentu. Buzzer dapat ditrigger untuk berbunyi dengan adanya tegangan kerja 3 volt hingga 12 volt. Yang dapat digunakan oleh Arduino yang tegangan dibawah 5 volt.', 'sensing', 'topik4', 'sensing-image', '/storage/files/sensing/buzzer2.jpg', '2025-04-17 12:24:30', NULL),
(61, 1, 'Servo', 'Motor servo adalah motor dengan torsi besar dan dengan sudut yang bisa diatur. Motor ini hampir sama dengan motor stepper hanya saja motor servo memiliki gerak terbatas. Motor stepper dapat berputar 360o sedangkan motor servo hanya dapat berputar 180o atau 90o saja. Motor servo lebih mudah untuk dikontrol sudutnya karena menggunakan basis PWM.', 'sensing', 'topik4', 'sensing-image', '/storage/files/sensing/servo.jpeg\r\n', '2025-04-17 12:24:54', NULL),
(62, 1, 'Relay', 'Relay termasuk dalam kategori sakelar yang bekerja dengan basis elektromagnetik untuk menggerakkan (switch) kontaktor keposisi tertentu. NC (Normally Close) : Kondisi awal dimana relai pada posisi tertutup, tetapi saat tealiri arus maka akan ke posisi terbuka. NO (Normally Open) : Merupakan kebalikan dari NC yang dimana kondisi awal relai pada posisi Open, tetapi saat tealiri arus maka akan ke posisi tertutup.\r\n\r\nRelay biasanya menggunakan kumparan/coil sebagai media untuk mengontrol switch. Cara kerjanya adalah ketika kumparan dialiri arus listrik, maka pada kumparan dihasilkan medan magnet yang akan menarik plat konduktor yang berfungsi sebagai switch sehingga berpindah titik yang lain, sebagai ilustrasi diatas, kumparan terletak diantara kaki 4-5. Sedangkan plat yang dimaksud adalah pada kaki 1 yang akan \"berpindah\" dari plat 2 ke 3 dan sebaliknya. Terdapat 2 jenis relay yang dapat digunakan pada tingkercad yaitu SPDT dan DPDT.', 'sensing', 'topik5', 'sensing-image', '/storage/files/sensing/relay.jpeg', '2025-04-17 12:32:19', NULL),
(63, 1, 'Relay SPDT (Single Pole Dual Throw)', 'Relay SPDT (Single Pole Dual Throw) adalah komponen elektronik yang berfungsi sebagai saklar otomatis yang memungkinkan kontrol terhadap perangkat listrik melalui sinyal digital dari mikrokontroler seperti Arduino. Relay SPDT memiliki satu kontak input (pole) dan dua kontak output (throw), memungkinkan pengguna untuk mengalihkan arus ke salah satu dari dua jalur yang berbeda. Ketika sinyal diberikan dari Arduino, relay SPDT mengubah posisinya, sehingga aliran listrik dialihkan ke perangkat yang ditentukan.\r\n\r\nDalam konteks Internet of Things (IoT), relay SPDT berperan penting dalam mengontrol perangkat atau sistem listrik dari jarak jauh atau otomatis. Berikut beberapa contoh aplikasi relay SPDT yang dikendalikan oleh Arduino dalam IoT:\r\n\r\n1. Sistem Otomatisasi Rumah Pintar: Relay SPDT sering digunakan untuk mengontrol peralatan rumah tangga seperti lampu, kipas angin, atau bahkan pintu otomatis. Dengan menghubungkan relay ke Arduino dan jaringan IoT, pengguna dapat menyalakan atau mematikan perangkat tersebut dari smartphone atau aplikasi IoT, meningkatkan kenyamanan dan efisiensi energi.\r\n\r\n2. Pengendalian Beban Listrik pada Industri: Dalam aplikasi IoT industri, relay SPDT digunakan untuk mengontrol beban listrik besar, seperti motor atau pemanas. Arduino yang dikendalikan dari sistem IoT mengirimkan sinyal ke relay, memungkinkan kontrol otomatis atas beban ini sesuai kebutuhan operasional, seperti penjadwalan otomatis atau pengendalian berdasarkan kondisi tertentu.\r\n\r\n3. Keamanan dan Sistem Alarm: Relay SPDT juga digunakan dalam sistem keamanan berbasis IoT untuk mengaktifkan atau menonaktifkan sirine, lampu darurat, atau pengunci pintu otomatis saat sensor mendeteksi adanya intrusi atau peringatan. Ketika sensor mendeteksi aktivitas yang mencurigakan, Arduino dapat mengirim sinyal ke relay untuk memicu tindakan keamanan.\r\n\r\n4. Sistem Kendali Pompa Air Otomatis: Dalam aplikasi IoT untuk pertanian atau irigasi pintar, relay SPDT digunakan untuk mengendalikan pompa air. Berdasarkan data dari sensor kelembaban tanah, Arduino dapat mengirim sinyal untuk menyalakan atau mematikan pompa melalui relay, sehingga irigasi hanya berjalan saat diperlukan.\r\n\r\n5. Pengaturan Sumber Daya Listrik Cadangan: Relay SPDT dapat berfungsi sebagai saklar otomatis untuk mengalihkan sumber daya listrik, misalnya dari listrik utama ke baterai cadangan. Dalam aplikasi IoT, Arduino mengendalikan relay untuk memastikan perangkat tetap mendapatkan daya, bahkan jika ada pemadaman listrik.\r\n\r\nRelay SPDT pada Arduino sangat berguna dalam IoT karena memungkinkan kontrol dari jarak jauh dan otomatis pada perangkat bertegangan tinggi yang tidak dapat langsung dikendalikan oleh mikrokontroler. Integrasinya dalam sistem IoT memungkinkan penggunaan listrik yang lebih efisien, pengendalian perangkat yang lebih aman, dan otomatisasi dalam berbagai aplikasi.', 'sensing', 'topik4', 'sensing-image', '/storage/files/sensing/relayspdt.jpg', '2025-04-17 12:32:47', NULL);
INSERT INTO `mdl_files` (`id`, `course_id`, `name`, `description`, `learning_style`, `topik`, `type`, `file_path`, `created_at`, `deleted_at`) VALUES
(64, 1, 'Relay DPDT', 'Relay DPDT (Dual Pole Dual Throw) adalah jenis relay yang memiliki dua kontak input (dual pole) dan dua set kontak output (dual throw), sehingga memungkinkan pengalihan dua rangkaian listrik secara bersamaan dengan satu sinyal kendali. Berbeda dengan Relay SPDT (Single Pole Dual Throw), yang hanya memiliki satu kontak input dan dua output, Relay DPDT dapat mengendalikan dua jalur listrik independen, menjadikannya lebih fleksibel dalam pengaturan otomatisasi dan kontrol dalam aplikasi IoT (Internet of Things).\r\n\r\nPenggunaan Relay DPDT pada Arduino dalam IoT memberikan beberapa keuntungan, terutama dalam situasi yang memerlukan pengalihan ganda atau pengendalian rangkaian listrik yang lebih kompleks. Berikut beberapa contoh aplikasi Relay DPDT dalam sistem IoT:\r\n\r\n1. Sistem Kendali Motor dalam Otomatisasi Rumah dan Industri: Relay DPDT dapat digunakan untuk mengendalikan arah putaran motor listrik dengan mengubah polaritas. Arduino yang dikendalikan melalui IoT dapat mengirim sinyal ke relay untuk mengubah arah putaran motor, misalnya untuk membuka dan menutup tirai otomatis di rumah pintar atau mengendalikan conveyor di lini produksi industri.\r\n\r\n2. Kontrol Sumber Daya Listrik Ganda: Dalam aplikasi IoT yang memerlukan pengalihan otomatis antara dua sumber daya, seperti dari sumber utama ke sumber daya cadangan, Relay DPDT memungkinkan pengalihan otomatis antara kedua sumber ini. Ketika sinyal diterima dari Arduino, relay mengalihkan arus ke sumber daya yang aktif, memastikan perangkat tetap beroperasi meski ada gangguan daya utama.\r\n\r\n3. Sistem Pencahayaan Ganda: Pada sistem pencahayaan berbasis IoT, Relay DPDT dapat digunakan untuk mengalihkan arus ke dua jalur pencahayaan berbeda. Dengan bantuan Arduino, sistem IoT dapat menentukan jenis pencahayaan yang diaktifkan, seperti lampu utama atau lampu redup, tergantung pada kebutuhan dan kondisi lingkungan.\r\n\r\n4. Sistem Pengendalian Keamanan dan Alarm Ganda: Relay DPDT memungkinkan kontrol lebih kompleks dalam sistem keamanan IoT, di mana dua perangkat berbeda dapat diaktifkan secara bersamaan, misalnya menghidupkan sirine dan menyalakan lampu darurat saat sensor mendeteksi ancaman. Dengan Arduino sebagai pengendali, relay dapat memicu kedua perangkat secara bersamaan untuk memberikan respons keamanan yang lebih efektif.\r\n\r\n5. Kendali Perangkat Elektronik Bertegangan Ganda: Dalam beberapa aplikasi IoT, seperti panel kontrol di bangunan pintar atau pusat data, Relay DPDT dapat mengelola dua rangkaian listrik yang berbeda pada satu waktu. Hal ini memungkinkan penggunaan perangkat dengan tegangan berbeda dalam satu sistem, yang dikendalikan secara otomatis melalui sinyal dari Arduino.\r\n\r\nKeunggulan Relay DPDT dibandingkan Relay SPDT adalah kemampuannya untuk mengalihkan dua rangkaian listrik sekaligus, sehingga cocok untuk aplikasi yang memerlukan pengaturan lebih kompleks atau pengendalian ganda. Penggunaannya dalam sistem IoT memungkinkan pengalihan arus yang lebih fleksibel dan otomatisasi yang lebih komprehensif, memperluas opsi kendali dan efisiensi di berbagai lingkungan, baik industri maupun rumah pintar.', 'sensing', 'topik5', 'sensing-image', '/storage/files/sensing/relaydpdt.jpg', '2025-04-17 12:33:14', NULL),
(65, 1, 'IoT Communication Network', 'Internet of Things (IoT) merevolusi cara perangkat terhubung dan berkomunikasi, menciptakan ekosistem yang mampu berbagi data secara otomatis untuk berbagai aplikasi. IoT Communication Network mengacu pada teknologi, protokol, dan infrastruktur yang memungkinkan perangkat IoT terhubung satu sama lain, baik melalui jaringan lokal maupun internet. Jaringan ini berperan penting dalam mentransmisikan data dari sensor ke perangkat pemrosesan, hingga akhirnya mengaktifkan actuator untuk menghasilkan respons tertentu.', 'sensing', 'topik6', 'sensing-image', '/storage/files/sensing/iot.png', '2025-04-17 12:40:17', NULL),
(66, 1, 'WiFi', '1. Memungkinkan perangkat IoT terhubung langsung ke internet melalui jaringan nirkabel.\r\n2. Contoh perangkat: ESP-12/8266, ESP32, ESP01.', 'sensing', 'topik6', 'sensing-image', '/storage/files/sensing/wifi.jpg', '2025-04-17 12:40:44', NULL),
(67, 1, 'Bluetooth', '1. Cocok untuk komunikasi jarak dekat, termasuk varian Bluetooth Low Energy (BLE) yang hemat daya.\r\n2. Contoh perangkat: HC-05, HC-06, ESP32.', 'sensing', 'topik6', 'sensing-image', '/storage/files/reflective/bluetooth.png', '2025-04-17 12:41:06', NULL),
(68, 1, 'Cellular', '1. Menggunakan jaringan seluler seperti 2G, 4G LTE, atau 5G untuk komunikasi jarak jauh, tanpa bergantung pada Wi-Fi.\r\n2. Contoh perangkat: SIM800, SIM900.', 'sensing', 'topik6', 'sensing-image', '/storage/files/reflective/cellular.png', '2025-04-17 12:41:26', NULL),
(70, 1, 'Fakta Teknis: Perbandingan Platform', '', 'sensing', 'topik7', 'sensing-image', '/storage/files/sensing/perbandingan_platform.jpg', '2025-04-17 13:43:16', NULL),
(71, 1, '', 'Konsep Abstrak: Apa Itu IoT?\r\n\r\nMenurut IoT Forum Indonesia, “suatu infrastruktur global untuk informasi masyarakat yang memungkinkan kesinambungan layanan dengan adanya interkoneksi (baik secara fisik maupun virtual) oleh suatu sensor berbasis pada perkembangan teknologi informasi dan komunikasi yang saling terkait”.\r\n\r\nInternet of Things adalah jaringan perangkat fisik yang saling terhubung, saling berbagi data, dan berinteraksi tanpa intervensi manusia langsung.\r\n\r\nAnalogi:\r\nBayangkan rumah Anda sebagai ekosistem. Lampu, kulkas, dan AC adalah \"organ tubuh\" yang bisa berpikir dan berbicara satu sama lain melalui \"sistem saraf\" yang disebut Internet.', 'intuitive', 'topik1', 'intuitive-pdf', 'https://aws.amazon.com/id/what-is/iot/', '2025-04-18 04:25:47', NULL),
(72, 1, 'Arsitektur IoT', 'Arsitektur IoT (4 Lapisan Umum):\r\n\r\n1. Perception Layer (Perangkat Sensor)\r\nContoh: Sensor suhu, PIR sensor, servo motor, GPS, Smart Device, RFID.\r\n\r\n2. Network Layer (Jaringan dan Gateway)\r\nContoh: WiFi, Bluetooth, Zigbee, WWAN, WPAN, WLAN, WMAN).\r\n\r\n3. Processing Layer (Perangkat, Security, Analytic, dll)\r\nContoh: Raspberry Pi, Cloud, Edge Computing, Data Center, Search Engine, Smart Decision, Info Security, Data Mining.\r\n\r\n4. Application Layer (Aplikasi dan Layanan)\r\nContoh: Aplikasi Blynk, Home Assistant, Smart Grid, dll.', 'intuitive', 'topik1', 'intuitive-image', '/storage/files/intuitive/struktur_iot.png', '2025-04-18 04:29:44', NULL),
(73, 1, 'Pendekatan Filosofis terhadap Arduino', '\"Arduino bukan sekadar papan sirkuit — ia adalah jembatan antara logika digital dan realitas fisik.\"\r\n\r\nBayangkan Arduino sebagai otak buatan yang memproses sinyal dari dunia dan mengubahnya menjadi aksi.\r\n\r\n', 'intuitive', 'topik2', 'intuitive-image', '', '2025-04-18 04:36:48', NULL),
(74, 1, 'Konsep Masukan (Input)', 'Sensor sebagai \"indera digital\"\r\nContoh: Tombol, Sensor Cahaya, Sensor Suhu\r\nBayangkan tombol sebagai percikan niat manusia yang diterjemahkan ke logika mesin.', 'intuitive', 'topik2', 'intuitive-image', '', '2025-04-18 04:42:47', NULL),
(75, 1, 'Konsep Keluaran (Output)', 'Aktuator sebagai \"respons digital\"\r\nContoh: LED, Buzzer, Motor\r\nPikirkan LED bukan hanya lampu, tapi \"bahasa cahaya\" yang digunakan mesin untuk menyampaikan pesan.', 'intuitive', 'topik2', 'intuitive-image', '', '2025-04-18 04:43:11', NULL),
(76, 1, 'Sensor: Indera Digital Sistem IoT', 'Bayangkan sistem IoT seperti makhluk digital—sensor adalah matanya, kulitnya, dan sarafnya.\r\n\r\nSensor memungkinkan sistem mengenali dunia sekitarnya. Tapi bagaimana jika sistem itu belajar merespons seperti manusia?', 'intuitive', 'topik3', 'intuitive-image', '', '2025-04-18 04:46:54', NULL),
(77, 1, 'Sensor Cahaya', 'Sensor ini memiliki tugas menerima input berupa intensitas sinar atau cahaya menjadi konduktivitas (arus listrik). Nilai arus yang dihasilkan sangat bergantung pada kekuatan cahaya yang diterima pada sensor. Sensor yang memiliki tambahan komponen pendukung untuk menjaga peforma lebih baik disebut dengan modul sensor. \r\n\r\nPrinsip Kerja:\r\n\r\n- Resistansi berubah sesuai intensitas cahaya.\r\n\r\nRefleksi Konseptual:\r\n\r\n- Bagaimana cahaya yang tak terlihat bisa memicu reaksi dalam sebuah sistem digital?\r\n\r\nTerdapat 2 jenis sensor cahaya: Fotovoltaic dan Fotoconductiv.\r\n\r\n', 'intuitive', 'topik3', 'intuitive-image', '', '2025-04-18 04:48:49', NULL),
(78, 1, 'Sensor Suhu & Kelembaban (DHT11/DHT22)', 'Sensor suhu adalah alat yang digunakan untuk mengubah besaran panas menjadi besaran listrik yang dapat dengan mudah dianalisis besarnya. Ada beberapa metode yang digunakan untuk membuat sensor ini, salah satunya dengan cara menggunakan material yang berubah hambatannya terhadap arus listrik sesuai dengan suhunya. TMP36 merupakan salah satu sensor suhu atau temperature sensor yang cukup presisi pengukuran suhu dengan keluaran berupa tegangan output yang berubah secara linear terhadap temperatur Celcius.\r\n\r\nPrinsip Kerja:\r\n\r\n- Resistansi berubah sesuai intensitas cahaya.\r\n\r\nRefleksi Konseptual:\r\n\r\n- Bagaimana cahaya yang tak terlihat bisa memicu reaksi dalam sebuah sistem digital?', 'intuitive', 'topik3', 'intuitive-image', '', '2025-04-18 04:49:43', NULL),
(79, 1, 'Sensor Deteksi Objek (PIR/Ultrasonik)', 'Prinsip Kerja:\r\n\r\n- Mendeteksi keberadaan atau gerakan objek.\r\n\r\nEksperimen Pemikiran:\r\n\r\n- Bagaimana sistem tahu kapan harus ‘menyapa’ seseorang yang masuk ruangan?', 'intuitive', 'topik3', 'intuitive-image', '', '2025-04-18 04:52:20', NULL),
(80, 1, 'Aktuator = Suara Sistem IoT', 'Jika sensor adalah indera, maka aktuator adalah mulut dan otot dari sistem.\r\n\r\nSistem IoT tidak hanya “merasakan” lingkungan, tetapi juga merespons secara fisik: menyala, berbunyi, bergerak.', 'intuitive', 'topik4', 'intuitive-image', '', '2025-04-18 04:56:41', NULL),
(81, 1, 'Aktuator Cahaya (LED/Lampu Pintar)', 'Makna Konseptual:\r\n\r\nCahaya digunakan untuk memberi tanda, peringatan, bahkan menciptakan suasana.', 'intuitive', 'topik4', 'intuitive-image', '', '2025-04-18 04:57:31', NULL),
(82, 1, 'Aktuator Bunyi (Buzzer/Speaker)', 'Makna Konseptual:\r\n\r\nBunyi adalah cara paling primitif sekaligus canggih untuk menarik perhatian.', 'intuitive', 'topik4', 'intuitive-image', '', '2025-04-18 04:57:50', NULL),
(83, 1, 'Aktuator Motor (DC Motor/Servo)', 'Makna Konseptual:\r\n\r\nMotor adalah “otot” sistem – mereka yang benar-benar melakukan pekerjaan fisik.', 'intuitive', 'topik4', 'intuitive-image', '', '2025-04-18 04:58:15', NULL),
(84, 1, 'Apa itu Modul Support dalam IoT?', 'Modul Support = \"Jembatan antara pengguna, sistem, dan aksi\".\r\n\r\nRelay: saklar elektronik yang menghubungkan mikrokontroler ke perangkat berdaya besar.\r\n\r\nKeypad: antarmuka input yang menjembatani komunikasi manusia ke sistem IoT.\r\n\r\n', 'intuitive', 'topik5', 'intuitive-image', '', '2025-04-18 05:02:44', NULL),
(85, 1, 'Relay', 'Konsep Utama:\r\n\r\nRelay termasuk dalam kategori sakelar yang bekerja dengan basis elektromagnetik untuk menggerakkan (switch) kontaktor keposisi tertentu. NC (Normally Close) : Kondisi awal dimana relai pada posisi tertutup, tetapi saat tealiri arus maka akan ke posisi terbuka. NO (Normally Open) : Merupakan kebalikan dari NC yang dimana kondisi awal relai pada posisi Open, tetapi saat tealiri arus maka akan ke posisi tertutup.\r\n\r\nRelay bukan hanya menghidupkan lampu tapi mengizinkan sistem kecil mengontrol sistem besar.\r\n\r\nContoh Visual Konseptual:\r\n\r\nArduino = otak kecil -> Relay = tangan sakti -> AC 220V = alat berat\r\n\r\nEksplorasi Ide:\r\n\r\nBagaimana cara mengontrol pompa air atau alarm rumah dari jarak jauh?', 'intuitive', 'topik5', 'intuitive-image', '', '2025-04-18 05:04:37', NULL),
(86, 1, 'Keypad', 'Konsep Utama:\r\n\r\nKeypad adalah gerbang interaksi manusia dengan logika sistem.\r\n\r\nAnalogi:\r\n\r\nSeperti memberi kata sandi, kode perintah, atau intervensi manusia ke sistem pintar.\r\n\r\nContoh Kasus:\r\n\r\n1. Sistem pintu otomatis dengan kode akses (keypad)\r\n\r\n2. Kontrol menu atau mode operasi IoT device dengan tombol-tombol\r\n\r\n', 'intuitive', 'topik5', 'intuitive-image', '', '2025-04-18 05:05:50', NULL),
(87, 1, 'Mengapa Komunikasi Penting dalam IoT?', 'IoT = \"Internet of Things\"\r\nTanpa komunikasi, tidak ada \"Internet\", hanya \"Things\".\r\n\r\nKonsep Besar:\r\nSetiap perangkat IoT adalah penyampai pesan. Tanpa jaringan, data tidak pernah sampai ke pengguna atau cloud.\r\n\r\n', 'intuitive', 'topik6', 'intuitive-image', '', '2025-04-18 05:09:45', NULL),
(88, 1, 'Wifi', 'Kekuatan: Cepat, stabil, langsung ke internet.\r\n\r\nKeterbatasan: Butuh infrastruktur (router), konsumsi daya tinggi.\r\n\r\nContoh Modul: ESP8266, ESP32', 'intuitive', 'topik6', 'intuitive-image', '', '2025-04-18 05:10:31', NULL),
(89, 1, 'Bluetooth', 'Kekuatan: Hemat daya, ideal untuk jarak dekat.\r\n\r\nKeterbatasan: Jarak terbatas, tidak langsung ke internet.\r\n\r\nContoh Modul: HC-05, HC-06', 'intuitive', 'topik6', 'intuitive-image', '', '2025-04-18 05:10:49', NULL),
(90, 1, 'Cellular', 'Kekuatan: Bisa digunakan di mana saja dengan jaringan seluler.\r\n\r\nKeterbatasan: Konsumsi daya & biaya lebih tinggi.\r\n\r\nContoh Modul: SIM800, SIM900', 'intuitive', 'topik6', 'intuitive-image', '', '2025-04-18 05:11:03', NULL),
(91, 1, 'Apa Itu Platform IoT?', 'Bayangkan Platform IoT sebagai “otak di awan” yang menerima data, menganalisisnya, dan memberikan instruksi balik ke perangkat.\r\n\r\nPlatform IoT = Cloud + Data Processing + UI (dashboard) + Interaksi', 'intuitive', 'topik7', 'intuitive-image', '', '2025-04-18 05:14:25', NULL),
(92, 1, 'Karakteristik Platform IoT', '', 'intuitive', 'topik7', 'intuitive-image', '/storage/files/intuitive/perbandingan_platform.jpg', '2025-04-18 05:16:02', NULL),
(93, 1, 'Analogi Platform IoT', 'Bayangkan kamu mengatur lalu lintas kota dari pusat kontrol:\r\n\r\n1. Thingspeak = Panel monitor sederhana (melihat data)\r\n\r\n2. Blynk = Panel yang bisa dikendalikan dengan tombol (kendali aktif)\r\n\r\n3. Firebase = Pusat data dan logika yang bisa diakses dari mana saja\r\n\r\n4. Node-RED = Jaringan alur kerja yang bisa kamu atur sendiri', 'intuitive', 'topik7', 'intuitive-image', '', '2025-04-18 05:16:33', NULL),
(94, 1, 'Pemrograman Arduino Dasar', 'Ini adalah modul untuk Pemrograman Arduino Dasar.', 'visual', 'topik2', 'visual-pdf', '/storage/files/visual/Pemrograman Arduino Dasar.pdf', '2025-04-18 05:52:00', NULL),
(95, 1, 'Tinkercad: IDE dan Simulator Online Arduino UNO', 'Tinkercad merupakan tools online gratis untuk membantu mendesign dan menciptakan produknya sendiri. Pada awalnya tools ini hanya memiliki fitur 3D design yang sederhana, namun saat ini Tinkercad telah dikembangkan dengan tools baru yang bernama “Circuit” untuk melakukan simulasi rangkaian elektronika sederhana dan juga Arduino. Untuk dapat menggunakan terlebih dahulu melakukan pendaftaran pada alamat web site: https://www.tinkercad.com\r\nPemrograman untuk Arduino dengan menggunakan Tinkercad sebagai IDE dan simulator online ini dapat dilakukan dengan 2 pendekatan pemrograman:\r\n\r\n1. Code => Sama persis dengan Arduino IDE.\r\nTerdapat beberapa perintah / function dasar yang digunakan:\r\n- pinMode(), digunakan untuk menntukan pin yang akan digunakan sebagai OUTPUT, INPUT\r\n- digitalWrite(), digunakan untuk memberikan nilai HIGH, LOW\r\n- delay(), menunda jalannya program dalam milidetik\r\n- info detail ada di https://www.arduino.cc/reference/en\r\n\r\n2. Block\r\nPemrograman ini diwakilkan dengan penggunaan block-block diagram yang sudah ditentukan. Cukup dengan click and drag block yang akan digunakan.', 'visual', 'topik2', 'visual-image', '', '2025-04-18 05:57:46', NULL),
(96, 1, 'arduino.cc', 'Ini adalah halaman resmi dari Arduino.', 'visual', 'topik2', 'visual-link', 'https://www.arduino.cc/', '2025-04-18 05:59:29', NULL),
(97, 1, 'tinkercad.com', 'Ini adalah halaman resmi dari Tinkercad.', 'visual', 'topik2', 'visual-link', 'https://www.tinkercad.com/', '2025-04-18 05:59:50', NULL),
(98, 1, 'Struktur Program Arduino', 'Program Arduino ditulis menggunakan bahasa pemrograman C/C++, meskipun dalam IDE Arduino, pengguna biasanya hanya perlu fokus pada fungsi-fungsi yang sudah tersedia untuk mempermudah pembuatan program. Berikut adalah struktur dasar dari sebuah program Arduino:\r\n\r\nBerikut ini penjelasan setiap bagian dari struktur program di atas:\r\n\r\n1. Header\r\n\r\nBagian ini berisi semua pustaka atau library yang diperlukan untuk program Arduino. Pustaka adalah kumpulan fungsi yang sudah dibuat sebelumnya dan bisa digunakan kembali untuk mempermudah pengembangan program. Contohnya adalah pustaka untuk mengendalikan motor, sensor, atau modul komunikasi tertentu. Pustaka ini perlu di \"include\" di awal program agar fungsi-fungsi yang ada di dalamnya dapat digunakan.\r\n\r\n2. Deklarasi Variabel Global\r\n\r\nBagian ini digunakan untuk mendeklarasikan variabel yang akan digunakan secara global di seluruh program. Variabel global adalah variabel yang dapat diakses dan dimanipulasi dari mana pun dalam program.\r\n\r\n3. Setup Function\r\n\r\nFungsi setup() adalah fungsi khusus yang hanya dieksekusi satu kali saat program Arduino pertama kali dijalankan. Fungsi ini digunakan untuk melakukan inisialisasi, seperti mengatur pin, menginisialisasi variabel, atau menyiapkan kondisi awal.\r\n\r\n4. Loop Function\r\n\r\nFungsi loop() adalah inti dari program Arduino. Setelah fungsi setup() dieksekusi, Arduino akan terus mengeksekusi fungsi loop() secara berulang tanpa henti. Di dalam fungsi loop() biasanya berisi kode-kode yang mengatur perilaku dari proyek yang sedang dibuat.', 'visual', 'topik2', 'visual-image', '/storage/files/visual/struktur_arduino.jpg', '2025-04-18 06:02:12', NULL),
(99, 1, 'Light Emitting Diode (LED)', 'Merupakan salah satu komponen elektronika yang mengubah energi listrik menjadi energi cahaya. LED paling banyak dijumpai dalam kehidupan sehari, digunakan sebagai lampu atau di layar televisi (LED). LED juga merupakan actuator yang paling sederhana. LED memiliki cahaya yang beraneka warna tergantung pada bahan pembuatnya yaitu semikonduktor. Terdapat jenis LED yang tidak bisa dilihat cahaya oleh mata manusia, jenis ini termasuk LED infrared.\r\n\r\nUntuk menyalakan LED maka haru terhubung dengan power. LED yang terhubung ke Arduino dapat dilairi dengan power tegangan sebesar 3,3 Volt atau 5 Volt tergantung berada di PIN Digital atau Analog. Sedangkan Arduino Uno memiliki aliran kuat arus pada PIN-nya (rekomendasi) sebesar 20mA atau sama dengan 0,02 A. Agar LED tidak mendapatkan kelebihan power maka perlu dipasang sebuah hambatan. Dengan menggunakan rumus V = I x R maka dapat diperoleh berapa besarnya hambatan (R) yang digunakan. Hambatan yang harus digunakan : R = V / I ; R = 5 / 0,02 = 250 W , karena dipasaran tidak ada dapat dipakai dengan penggantinya yaitu 220 ohm, 240 ohm, maupun 270 ohm.\r\n\r\n\r\nDalam akses LED ada 2 kondisi :\r\n1. activehigh adalah kondisi led akan menyala jika padapin output arduino jika diberikan logika 1 atau high\r\n2. activelow yaitu kondisi led akan menyala jika diberikan logika 0 atau low', 'visual', 'topik2', 'visual-image', '/storage/files/visual/led.jpg', '2025-04-18 06:07:00', NULL),
(100, 1, 'Tutorial Dasar Arduino (Dasar Pemrograman Part 1: Dasar-dasar Pembuatan Sketch Program)\r\n', 'Video \"Tutorial Dasar Arduino\" ini  menjelaskan tentang Arduino dari dasar. Pada video ini, membahas  tentang:\r\n\r\n1. Struktur dasar bahasa pemrograman Arduino yang meliputi fungsi void set up dan void loop.\r\n2. Aturan-aturan penulisan sketch program Arduino', 'visual', 'topik2', 'visual-video', 'https://www.youtube.com/embed/eTOoPiq6IgM', '2025-04-18 06:10:36', NULL),
(101, 1, 'Perbedaan pin digital vs pin analog', 'Berikut ini perbedaan pin analog dan digital pada Arduino adalah sebagai berikut:\r\n\r\n1. Pin analog menerima sinyal listrik berupa tegangan analog. Tegangan ini diubah oleh ADC (Analog to Digital Converter) menjadi angka digital. ADC pada Arduino UNO dan Arduino Nano memiliki resolusi 10 bit, jadi tegangan analog tersebut akan dibaca oleh perangkat lunak sebagai angka integer 0 sampai dengan 1023.\r\n\r\n2. Pin digital pada Arduino menerima sinyal listrik digital. Tegangan pada pin digital akan dibaca oleh perangkat lunak sebagai angka 0 (jika input tegangan rendah mendekati 0 volt) atau 1 (jika input tegangan tinggi mendekati 5 volt).\r\n\r\nSinyal input pada pin analog dibaca dengan fungsi analogRead(), hasilnya adalah angka integer dari 0 sampai 1023.\r\n\r\nSinyal input pada pin digital dibaca dengan fungsi digitalRead(), hasilnya adalah angka 0 atau 1.\r\n\r\n\r\nPin analog pada Arduino UNO dan Nano dapat difungsikan sebagai input analog maupun digital.\r\n\r\nPin digital pada Arduino UNO dan Nano hanya dapat difungsikan sebagai input digital.', 'visual', 'topik2', 'visual-image', '/storage/files/visual/arduino.jpg', '2025-04-18 06:17:10', NULL),
(102, 1, 'Sensor Cahaya', 'Sensor ini memiliki tugas menerima input berupa intensitas sinar atau cahaya menjadi konduktivitas (arus listrik). Nilai arus yang dihasilkan sangat bergantung pada kekuatan cahaya yang diterima pada sensor. Sensor yang memiliki tambahan komponen pendukung untuk menjaga peforma lebih baik disebut dengan modul sensor. Terdapat 2 jenis sensor cahaya: Fotovoltaic dan Fotoconductiv.\r\n', 'visual', 'topik3', 'visual-pdf', '/storage/files/visual/Sensor Cahaya.pdf', '2025-04-18 06:22:08', NULL),
(103, 1, 'Fotovoltaic', 'Mengubah sinar atau cahaya matahari menjadi arus listrik DC (Direct Current). Sering dimanfaatkan sebagai sumber energi alternatif yang dikenal dengan Pembangkit Listrik Tenaga Surya (PLTS). Semakin kuat sinar matahari maka arus listrik DC yang dihasilkan semakin besar. Bahan yang dimanfaatkan untuk pembuatan panel surya ini adalah silicon, cadmium sullphide, gallium arsenide dan selenium.', 'visual', 'topik3', 'visual-image', '/storage/files/visual/fotovoltaic.jpg', '2025-04-18 06:24:12', NULL),
(104, 1, '', '', 'visual', 'topik3', 'visual-image', '/storage/files/visual/fotovoltaic2.jpg', '2025-04-18 06:24:54', NULL),
(105, 1, 'Fotoconductiv', 'Mengubah intensitas cahaya menjadi perubahan konduktivitas. Konduktivitas disini adalah kemampuan suatu bahan untuk menghantarkan arus listrik (konduktor). Bahan-bahan yang digunakan untuk konduktor tersebut adalah cadmium selenoide atau cadmium sulfide. Berdasarkan kemampuan konduktor menerima intensitas cahaya terdapat 3 tipe fotoconductiv yaitu Fotoresistor, Fotodioda, Fototransitor.\r\n', 'visual', 'topik3', 'visual-image', '', '2025-04-18 06:25:46', NULL),
(106, 1, 'Fotoresistor\r\n', 'Fotoresistor, juga dikenal sebagai LDR (Light Dependent Resistor), adalah jenis sensor pasif yang resistansinya berubah berdasarkan intensitas cahaya yang jatuh padanya. Sebagai sensor cahaya, fotoresistor memanfaatkan prinsip semikonduktor di mana resistansi berkurang ketika intensitas cahaya meningkat, dan meningkat ketika intensitas cahaya berkurang. Karena sifatnya yang responsif terhadap cahaya, fotoresistor sering digunakan dalam aplikasi berbasis Internet of Things (IoT).\r\n\r\nDalam konteks IoT, fotoresistor dapat berperan sebagai sensor utama untuk memantau perubahan kondisi cahaya di lingkungan. Dengan menghubungkannya ke perangkat IoT, seperti mikrokontroler, fotoresistor dapat mengirim data tentang tingkat pencahayaan yang kemudian dapat diproses, dianalisis, dan diintegrasikan ke dalam sistem otomatisasi. Contoh penggunaannya meliputi:\r\n\r\n1. Sistem Pencahayaan Pintar: Fotoresistor digunakan untuk mendeteksi perubahan intensitas cahaya di sebuah ruangan atau area luar. Berdasarkan data ini, sistem dapat secara otomatis menyalakan atau mematikan lampu, menghemat energi dan menambah kenyamanan.\r\n   \r\n2. Sistem Monitoring Lingkungan: Fotoresistor dapat memantau pencahayaan alami di sebuah area tertentu, misalnya, di rumah kaca atau pertanian pintar, di mana tingkat cahaya penting untuk pertumbuhan tanaman. Sistem IoT dapat menyesuaikan penerangan buatan berdasarkan data dari fotoresistor.\r\n\r\n3. Keamanan dan Deteksi Intrusi: Dalam aplikasi keamanan, fotoresistor digunakan untuk mendeteksi adanya perubahan cahaya yang tiba-tiba, seperti bayangan orang yang mendekati pintu atau jendela, memicu alarm atau pemberitahuan di sistem IoT.', 'visual', 'topik3', 'visual-image', '/storage/files/visual/fotoresistor.png', '2025-04-18 06:29:17', NULL),
(107, 1, 'Fotoresistor', '', 'visual', 'topik3', 'visual-image', '/storage/files/visual/fotoresistor2.png', '2025-04-18 06:30:24', NULL),
(108, 1, 'Fotodioda', 'Fotodioda adalah perangkat semikonduktor yang berfungsi sebagai sensor cahaya, bekerja dengan cara mengubah energi cahaya yang diterimanya menjadi arus listrik. Tidak seperti fotoresistor yang mengubah resistansi berdasarkan cahaya, fotodioda menghasilkan arus listrik yang sebanding dengan intensitas cahaya yang jatuh pada permukaannya. Dengan respon yang cepat dan sensitivitas tinggi, fotodioda menjadi pilihan ideal untuk aplikasi yang memerlukan deteksi cahaya dengan kecepatan tinggi dan presisi.', 'visual', 'topik3', 'visual-image', '/storage/files/visual/fotodioda.jpg', '2025-04-18 06:32:53', NULL),
(109, 1, 'Fototransistor', 'Fototransistor adalah jenis transistor yang berfungsi sebagai sensor cahaya, di mana arus yang mengalir melalui transistor dipengaruhi oleh intensitas cahaya yang diterima. Fototransistor bekerja serupa dengan fotodioda, tetapi dengan keuntungan tambahan dari amplifikasi internal, yang memungkinkan untuk mendeteksi tingkat cahaya yang lebih rendah dengan sensitivitas lebih tinggi. Karena kemampuannya untuk mengubah cahaya menjadi sinyal listrik yang diperkuat, fototransistor sering digunakan dalam aplikasi yang memerlukan deteksi cahaya yang lebih akurat dan kuat.', 'visual', 'topik3', 'visual-image', '/storage/files/visual/fototransitor.jpg', '2025-04-18 06:33:59', NULL),
(110, 1, 'Sensor Suhu & Kelembaban', 'Sensor suhu adalah alat yang digunakan untuk mengubah besaran panas menjadi besaran listrik yang dapat dengan mudah dianalisis besarnya. Ada beberapa metode yang digunakan untuk membuat sensor ini, salah satunya dengan cara menggunakan material yang berubah hambatannya terhadap arus listrik sesuai dengan suhunya. TMP36 merupakan salah satu sensor suhu atau temperature sensor yang cukup presisi pengukuran suhu dengan keluaran berupa tegangan output yang berubah secara linear terhadap temperatur Celcius.\r\n\r\n', 'visual', 'topik3', 'visual-image', '/storage/files/visual/sensorsuhu.jpg', '2025-04-18 06:36:00', NULL),
(111, 1, 'Sensor Deteksi Objek – Ultrasonik HC-SR04', 'Sensor jenis ini dalam bentuk modul sensor yang mendeteksi sebuah objek menggunakan suara (ultrasonic) dan terdapat pada Tinkercad. Gelombang ultrasonic dgn frekuensi sangat tinggi yaitu 20.000 Hz dan tidak dapat di dengar oleh telinga manusia namun dapat didengar oleh anjing, kucing, kelelawar, dan lumba-lumba. Bunyi ultrasonik bisa merambat melalui zat padat, cair dan gas serta tidak dipengaruhi cahaya, suhu, dan kelembaban. Sensor ultrasonic terdiri dari sebuah transmitter (pemancar) dan sebuah receiver (penerima). Transmitter berfungsi untuk memancarkan sebuah gelombang suara kearah depan. Jika ada sebuah objek didepan transmitter maka sinyal tersebut akan memantul kembali ke Receiver. Fungsi sensor ultrasonic adalah mendeteksi benda atau objek di hadapan sensor. Penerapannya banyak dipakai pada robot pemadam api dan robot obstacle lainnya. Salah satu sensor yang paling sering digunakan adalah sensor ultrasonic tipe HC SR04.', 'visual', 'topik3', 'visual-image', '/storage/files/visual/ultrasonik.jpeg', '2025-04-18 06:38:01', NULL),
(112, 1, '', '', 'visual', 'topik3', 'visual-video', 'https://www.youtube.com/embed/2fvXW4OEWLE', '2025-04-18 06:42:04', NULL),
(113, 1, 'Mengukur Jarak dengan HC-SR04 + Simulasi Tinkercad', '', 'visual', 'topik3', 'visual-video', 'https://www.youtube.com/embed/bfiVMa6pR5M', '2025-04-18 06:43:32', NULL),
(114, 1, 'LED RGB', 'LED RGB adalah sebuah LED yang dapat mengeluarkan perpaduan warna red(merah), green(hijau), dan blue(biru). LED ini seperti LED biasa memiliki anoda dan katoda hanya saja terdapat 3 anoda pada LED ini mewakili warna red, green, dan blue. Tegangan yang dikeluarkan pada anoda-anoda inilah yang akan mempengaruhi warna nyala dari LED RGB. LED rgb termasuk ke dalam integrated output dan dapat digunakan dengan mengendalikan LED red, green, blue, dan pin com yang dihubungkan ke gnd Arduino. Terdapat 2 jenis LED RGB yaitu yang berbentuk super flux (surface mount device) dan standart (bentuknya sama dengan LED biasa dengan jumlah kaki 4)', 'visual', 'topik4', 'visual-image', '/storage/files/visual/ledrgb.jpg', '2025-04-18 08:02:54', NULL),
(115, 1, 'Seven Segment', 'Seven segment sesungguhnya adalah LED yang disusun (segment) sehingga dapat digunakan untuk menampilkan angka desimal. Angka digital menjadi sangat penting untuk menampilkan informasi sebagai bagian panel display seperti pada jam digital, counter, kalkulator dan masih banyak lagi. Seven Segment memiliki 7 segment atau bagian yang bisa dikenalikan ON dan OFF. Susunan segment yang ON sedemikian rupa dapat merepresentasikan angka digital bahkan beberapa huruf. Jika semua segment dalam kondisi ON maka akan terbentuk angka 8. Angka lain yang dapat dihasilkan 0 - 9 dan huruf yang dapat dihasilkan A - F. Beberapa pengembangan seven segment adalah adanya penambahan . (titik) , (koma) dan : (titik dua). Terdapat 2 Jenis LED 7 Segment : Common Cathode -> ke negatif Common Anode -> ke positif', 'visual', 'topik4', 'visual-image', '/storage/files/visual/sevensegment.jpg', '2025-04-18 08:03:50', NULL),
(116, 1, 'Buzzer', 'Merupakan alat keluaran (output) yang mengubah sinyal listrik menjadi getaran suara, disebut juga dengan beeper atau piezoelectric. Karena memili ciri khas menghasilkan suara atau bunyi-bunyian maka buzzer dapat digunakan sebagai indikator suatu keadaan atau kondisi situasi tertentu. Buzzer dapat ditrigger untuk berbunyi dengan adanya tegangan kerja 3 volt hingga 12 volt. Yang dapat digunakan oleh Arduino yang tegangan dibawah 5 volt.\r\n\r\n', 'visual', 'topik4', 'visual-image', '/storage/files/visual/buzzer.jpg', '2025-04-18 08:04:34', NULL),
(117, 1, '', '', 'visual', 'topik4', 'visual-image', '/storage/files/visual/buzzer2.jpg', '2025-04-18 08:04:53', NULL),
(118, 1, 'Servo', 'Motor servo adalah motor dengan torsi besar dan dengan sudut yang bisa diatur. Motor ini hampir sama dengan motor stepper hanya saja motor servo memiliki gerak terbatas. Motor stepper dapat berputar 360o sedangkan motor servo hanya dapat berputar 180o atau 90o saja. Motor servo lebih mudah untuk dikontrol sudutnya karena menggunakan basis PWM.', 'visual', 'topik4', 'visual-image', '/storage/files/visual/servo.jpeg', '2025-04-18 08:09:05', NULL),
(119, 1, '', 'Berikut adalah contoh implementasi LED RGB pada Arduino dan contoh Digital Increment dengan memanfaatkan Seven Segment dan contoh Digital Increment dengan memanfaatkan Seven Segment', 'visual', 'topik4', 'visual-video', 'https://www.youtube.com/embed/7QXtHbU-am0\r\n', '2025-04-18 08:18:33', NULL),
(120, 1, '', '', 'visual', 'topik4', 'visual-video', 'https://www.youtube.com/embed/bCLQq_0eWsw', '2025-04-18 08:19:08', NULL),
(121, 1, 'Contoh implementasi pemanfaatan sensor dan actuator', 'Contoh berikut merupakan implementasi pemanfaatan sensor dan actuator yaitu sensor ultrasonic dan servo untuk pembuatan', 'visual', 'topik4', 'visual-video', 'https://www.youtube.com/embed/tm5Zgelwy_s', '2025-04-18 08:20:30', NULL),
(122, 1, 'Infografis: Cara Kerja Relay dan Keypad', 'Secara garis besar terdapat dua jenis relay, yaitu\r\n\r\n1. Relay elektromekanis : Relay yang menggunakan  prinsip elektromagnetik untuk menggerakkan kontak saklar. Pada bagian pertama tulisan ini, akan memfokuskan kepada jenis relay satu ini\r\n\r\n2. Relay Solid State : Relay yang menggunakan teknologi semikonduktor (optocoupler) untuk melakukan switch ON dan OFF.  Pembahasan tentang RSS akan diulas di bagian ke 2.\r\no)', 'visual', 'topik5', 'visual-image', '/storage/files/visual/relay.gif', '2025-04-18 08:27:17', NULL),
(123, 1, 'Electromechanical Relay', 'Pada gambar terdapat dua rangkaian elektronik, yang dinomeri (1) dan (2). Rangkaian (1) biasa disebut rangkaian picu (triggered circuit) yang  (menggunakan prinsip elektromekanik) dapat mengendalikan apakah rangkaian (2) pada posisi ON ataupun OFF. Biasanya rangkaian (1) memiliki tegangan dan arus lebih rendah (karena terhubung dengan mikrokontroler atau rangkaian lain) daripada rangkaian (2) yang biasanya terhubung dengan tegangan AC 220V (untuk menyalakan lampu taman atau lainnya)\r\n\r\nKetika sinyal mengalir melalui rangkaian 1 (logika 1), sinyal tersebut mengalir pada kumparan dan menghasilkan gaya elektromagnetik dan menimbulkan medan magnet yang menarik kontak dan kemudian mengaktivasi rangkaian kedua (untuk bergerak ON ataupun OFF)\r\n\r\nKetika daya dari rangkaian 1 menghilang (logika 0), pegas akan menarik kontak kembali ke posisi awalnya, sehingga rangkaian (2) akan kembali off seperti semula.\r\n\r\nRelay elektromekanis menggunakan bagian yang bergerak untuk menghubungkan kontak dengan komponen output dari relay. Pergerakan kontak ini disebabkan oleh medan elektromagnetik dari sinyal input daya rendah, sehingga menyebabkan mengalirnya rangkaian dialiri dengan arus berdaya tinggi. Komponen fisik yang bergerak tersebut yang membuat bunyi “click” saat relay switch dari OFF ke ON.', 'visual', 'topik5', 'visual-image', '/storage/files/visual/relay2.gif', '2025-04-18 08:31:29', NULL),
(124, 1, 'Modul Relay Elektromekanis', 'Modul relay elektromekanis yang umum digunakan dan tersedia di pasaran biasanya memiliki jenis low level trigger atau high level trigger. Relay low level trigger memerlukan picu sinyal logika 0 untuk mengaktifkan relay, sedangkan high level trigger membutuhkan sinyal logika 1 untuk mengaktifkan relay.\r\n\r\nNamun jika pembaca membutuhkan sebuah modul relay yang dapat digunakan untuk low level trigger dan high level trigger.\r\n\r\nModul  relay tersebut memiliki dua sisi yaitu sisi trigger rangkaian (1) terdiri dari\r\n1. DC+ : tegangan DC positif (5 volt)\r\n\r\n2. DC-  : ground\r\n3. IN     : sinyal masukan untuk mengendalikan sisi\r\n\r\nsedangkan sisi switch rangkaian (2)  terdiri dari\r\n\r\n1. NO : Normally Open, jika rangkaian dihubungkan di pin ini, maka koneksi antara COM dan NO akan open secara default\r\n\r\n2. NC : Normally Close, kebalikan dari NO, jika rangkaian dihubungkan di pin ini, maka koneksi antara COM dan NC akan close secara default\r\n\r\n3. COM : Common', 'visual', 'topik5', 'visual-image', '/storage/files/visual/relay3.png', '2025-04-18 08:33:17', NULL),
(125, 1, '', 'Untuk menguji modul relay, embeddednesia menggunakan modul Arduino UNO, dengan program blinky di pada PIN 13', 'visual', 'topik5', 'visual-image', '/storage/files/visual/relay4.jpg', '2025-04-18 08:34:50', NULL),
(126, 1, '', 'Jika pin  IN dihubungkan dengan PIN13 dan jumper relay dikonfigurasi high trigger maka nyala Led built-in akan sama dengan indikator pada relay,  sebagaimana eksperimen yang dinarasikan pada video berikut', 'visual', 'topik5', 'visual-video', 'https://www.youtube.com/embed/fSV8fAqtehk', '2025-04-18 08:36:20', NULL),
(127, 1, 'Infografis Perbandingan Jaringan', 'Tabel visual perbandingan:', 'visual', 'topik6', 'visual-image', '/storage/files/visual/jaringan.jpg', '2025-04-18 15:01:23', NULL),
(128, 1, 'IoT Communication Network', 'Internet of Things (IoT) merevolusi cara perangkat terhubung dan berkomunikasi, menciptakan ekosistem yang mampu berbagi data secara otomatis untuk berbagai aplikasi. IoT Communication Network mengacu pada teknologi, protokol, dan infrastruktur yang memungkinkan perangkat IoT terhubung satu sama lain, baik melalui jaringan lokal maupun internet. Jaringan ini berperan penting dalam mentransmisikan data dari sensor ke perangkat pemrosesan, hingga akhirnya mengaktifkan actuator untuk menghasilkan respons tertentu.', 'visual', 'topik6', 'visual-image', '/storage/files/visual/iot.png', '2025-04-18 15:03:13', NULL),
(129, 1, 'Bagaimana Perangkat IoT Berbicara?', 'Bagaimana Divais IoT berkomunikasi? Video ini akan membahas berbagai alternatif cara perangkat IoT berkomunikasi dengan komponen sistem lainnya di dalam suatu ekosistem IoT. Disini dibahas berbagai macam media, serta protokol komunikasi antar IoT atau IoT dengan hirarki sistem di atasnya.', 'visual', 'topik6', 'visual-video', 'https://www.youtube.com/embed/DqKkTiEsV-0', '2025-04-18 15:06:58', NULL),
(130, 1, 'Wifi', '- Memungkinkan perangkat IoT terhubung langsung ke internet melalui jaringan nirkabel.\r\n- Contoh perangkat: ESP-12/8266, ESP32, ESP01.', 'visual', 'topik6', 'visual-image', '/storage/files/visual/wifi.jpg', '2025-04-18 15:08:59', NULL),
(131, 1, 'Bluetooth', '1. Cocok untuk komunikasi jarak dekat, termasuk varian Bluetooth Low Energy (BLE) yang hemat daya.\r\n2. Contoh perangkat: HC-05, HC-06, ESP32.', 'visual', 'topik6', 'visual-image', '/storage/files/visual/bluetooth.png', '2025-04-18 15:09:34', NULL),
(132, 1, 'Cellular', '1. Menggunakan jaringan seluler seperti 2G, 4G LTE, atau 5G untuk komunikasi jarak jauh, tanpa bergantung pada Wi-Fi.\r\n2. Contoh perangkat: SIM800, SIM900.', 'visual', 'topik6', 'visual-image', '/storage/files/visual/cellular.png', '2025-04-18 15:10:03', NULL),
(133, 1, 'Komunikasi Serial Arduino Uno R3 Built In IoT Wifi ESP8266', '', 'visual', 'topik6', 'visual-video', 'https://www.youtube.com/embed/DzECItyOR4M', '2025-04-18 15:11:24', NULL),
(134, 1, 'Jaringan Komunikasi IoT', 'Berikut ini beberapa komponen pembelajaran tambahan untuk mendukung gaya belajar visual pada topik Jaringan Komunikasi IoT', 'visual', 'topik6', 'visual-image', '/storage/files/visual/jaringan2.png', '2025-04-18 15:16:50', NULL),
(135, 1, 'Perbandingan Platform IoT Populer', 'Platform: ThingSpeak, Blynk, Adafruit IO, Google Cloud IoT Core\r\n\r\nParameter: Kemudahan penggunaan, biaya, dokumentasi, integrasi perangkat', 'visual', 'topik7', 'visual-image', '/storage/files/visual/platform.png', '2025-04-18 15:30:21', NULL),
(136, 1, 'Diagram Alur', 'Diagram visual alur komunikasi data dari sensor -> mikrokontroler -> koneksi jaringan -> platform IoT -> visualisasi data.', 'visual', 'topik7', 'visual-image', '/storage/files/visual/diagram_alur.png', '2025-04-18 15:33:26', NULL),
(137, 1, '', 'Menunjukkan proses upload data sensor ke ThingSpeak menggunakan ESP8266.', 'visual', 'topik7', 'visual-video', 'https://www.youtube.com/embed/Dhtyo2xVyY0', '2025-04-18 15:35:14', NULL),
(138, 1, 'Sejarah Singkat\r\n', 'Pertama dimulai dengan memperkenalkan seseorang yang telah menciptakan istilah “Internet of Thing”. Istilah “Internet of Thing” (IoT) telah diperkenalkan oleh Kevin Ashton pada presentasi kepada Proctor & Gamble di tahun 1999. Kevin Ashton merupakan co-founder dari Auto-ID Lab MIT. Kevin Ashton mempiornisrkan RFID (digunakan pada bar code detector) untuk supply-chain management domain. Dia juga telah memulai Zensi, sebuah perusahaan yang membuat energi untuk teknologi penginderaan dan monitoring.\r\n\r\nBerikut adalah kutipan dari Kevin Ashton yang di tulis pada tahun 2009 untuk jurnal RFID yang akan membantu dalam memahami tentang inti dari IoT:\r\n\r\n“If we had computers that knew everything there was to know about things—using data they gathered without any help from us—we would be able to track and count everything, and greatly reduce waste, loss and cost. We would know when things needed replacing, repairing or recalling, and whether they were fresh or past their best.”\r\n\r\n“We need to empower computers with their own means of gathering information, so they can see, hear and smell the world for themselves, in all its random glory.”\r\n\r\nDari kutipan diatas dapat memberikan ide tentang ideologi yang melatarbelakangi dari pengembangan IoT.', 'verbal', 'topik1', 'verbal-image', '', '2025-04-19 03:13:44', NULL),
(139, 1, 'Definisi IoT', 'Menurut IoT Forum Indonesia, “suatu infrastruktur global untuk informasi masyarakat yang memungkinkan kesinambungan layanan dengan adanya interkoneksi (baik secara fisik maupun virtual) oleh suatu sensor berbasis pada perkembangan teknologi informasi dan komunikasi yang saling terkait”.\r\n', 'verbal', 'topik1', 'verbal-image', '', '2025-04-19 03:14:15', NULL),
(140, 1, 'Komponen Utama dalam Ekosistem IoT', '1. Perangkat Sensor dan Aktuator: Mengumpulkan data dari lingkungan.\r\n\r\n2. Mikrokontroler/Gateway: Mengolah dan mengirimkan data.\r\n\r\n3. Jaringan Komunikasi: Media pengiriman data (Wi-Fi, Bluetooth, seluler).\r\n\r\n4. Platform IoT: Tempat menyimpan dan memvisualisasikan data.\r\n\r\n5. Aplikasi: Tampilan akhir yang digunakan user (mobile/web app).', 'verbal', 'topik1', 'verbal-image', '', '2025-04-19 03:15:59', NULL),
(141, 1, 'Arsitektur IoT Umum', '1. Perangkat Sensor (Layer 1)\r\nKomponen dasar IoT untuk mendeteksi atau mengukur data fisik seperti suhu, kelembaban, gerakan, dll.\r\nContoh: GPS, Smart Device, RFID, Sensor.\r\n\r\n2.Jaringan & Gateway (Layer 2)\r\nMenyediakan konektivitas agar data dari sensor dapat dikirim ke sistem pusat.\r\nContoh jaringan: WPAN, WLAN, WWAN, Internet.\r\n\r\n3. Platform (Layer 3)\r\nLapisan untuk pengolahan data, keamanan, analitik, dan integrasi perangkat.\r\nContoh: Data Center, Search Engine, Smart Decision, Info Security, Data Mining.\r\n\r\n4. Aplikasi & Layanan (Layer 4)\r\nLayanan yang dimanfaatkan oleh pengguna akhir berbasis data IoT.\r\nContoh: Smart Logistic, Smart Grid, Green Building, Smart Transport, Environmental Monitoring.', 'verbal', 'topik1', 'verbal-image', '/storage/files/verbal/struktur_iot.png', '2025-04-19 03:17:02', NULL),
(142, 1, 'Apa itu Arduino?', 'Arduino adalah platform prototipe elektronik berbasis open-source yang terdiri dari perangkat keras (board Arduino) dan perangkat lunak (Arduino IDE). Arduino digunakan untuk membuat berbagai proyek elektronik interaktif.', 'verbal', 'topik2', 'verbal-pdf', '/storage/files/verbal/Pemrograman Arduino Dasar.pdf', '2025-04-19 03:22:22', NULL),
(143, 1, 'arduino.cc', 'Ini adalah halaman resmi dari Arduino.', 'verbal', 'topik2', 'verbal-link', 'https://www.arduino.cc/', '2025-04-19 03:24:34', NULL),
(144, 1, 'tinkercad.com', 'Ini adalah halaman resmi dari Tinkercad.', 'verbal', 'topik2', 'verbal-link', 'https://www.tinkercad.com/', '2025-04-19 03:25:03', NULL),
(145, 1, 'Konsep Pemrograman Dasar Arduino', '1. Setup Function\r\n\r\nFungsi setup() adalah fungsi khusus yang hanya dieksekusi satu kali saat program Arduino pertama kali dijalankan. Fungsi ini digunakan untuk melakukan inisialisasi, seperti mengatur pin, menginisialisasi variabel, atau menyiapkan kondisi awal.\r\n\r\n2. Loop Function\r\n\r\nFungsi loop() adalah inti dari program Arduino. Setelah fungsi setup() dieksekusi, Arduino akan terus mengeksekusi fungsi loop() secara berulang tanpa henti. Di dalam fungsi loop() biasanya berisi kode-kode yang mengatur perilaku dari proyek yang sedang dibuat.', 'verbal', 'topik2', 'verbal-image', '', '2025-04-19 03:26:56', NULL),
(146, 1, 'Digital dan Analog I/O', '1. Digital Input/Output (I/O): Pin yang bisa diberi atau membaca nilai HIGH/LOW (1/0). Contoh: menyalakan LED.\r\n\r\n2. Analog Input: Digunakan untuk membaca nilai dari sensor analog (0–1023). Contoh: sensor cahaya LDR.\r\n\r\n3. Analog Output (PWM): Meskipun tidak benar-benar analog, bisa digunakan untuk mengatur kecerahan LED, kecepatan motor, dll.\r\n\r\nContoh program:\r\n\r\nvoid setup() {\r\n  pinMode(13, OUTPUT); // Atur pin 13 sebagai output\r\n}\r\n\r\nvoid loop() {\r\n  digitalWrite(13, HIGH); // Nyalakan LED\r\n  delay(1000);            // Tunggu 1 detik\r\n  digitalWrite(13, LOW);  // Matikan LED\r\n  delay(1000);            // Tunggu 1 detik\r\n}', 'verbal', 'topik2', 'verbal-image', '', '2025-04-19 03:28:06', NULL),
(147, 1, 'Tutorial Dasar Arduino: Dasar-dasar Pembuatan Sketch Program', 'Video \"Tutorial Dasar Arduino\" ini menjelaskan tentang Arduino dari dasar. Pada video ini, membahas tentang:\r\n\r\n1. Struktur dasar bahasa pemrograman Arduino yang meliputi fungsi void set up dan void loop.\r\n2. Aturan-aturan penulisan sketch program Arduino', 'verbal', 'topik2', 'verbal-video', 'https://www.youtube.com/embed/eTOoPiq6IgM', '2025-04-19 03:32:19', NULL),
(148, 1, 'Sensor Cahaya (LDR - Light Dependent Resistor)', 'Sensor ini memiliki tugas menerima input berupa intensitas sinar atau cahaya menjadi konduktivitas (arus listrik). Nilai arus yang dihasilkan sangat bergantung pada kekuatan cahaya yang diterima pada sensor. Sensor yang memiliki tambahan komponen pendukung untuk menjaga peforma lebih baik disebut dengan modul sensor. Terdapat 2 jenis sensor cahaya: Fotovoltaic dan Fotoconductiv.\r\n\r\nContoh penggunaan: Lampu otomatis menyala saat malam hari.', 'verbal', 'topik3', 'verbal-pdf', '/storage/files/verbal/Sensor Cahaya.pdf', '2025-04-19 03:34:53', NULL),
(149, 1, 'Fotovoltaic', 'Mengubah sinar atau cahaya matahari menjadi arus listrik DC (Direct Current). Sering dimanfaatkan sebagai sumber energi alternatif yang dikenal dengan Pembangkit Listrik Tenaga Surya (PLTS). Semakin kuat sinar matahari maka arus listrik DC yang dihasilkan semakin besar. Bahan yang dimanfaatkan untuk pembuatan panel surya ini adalah silicon, cadmium sullphide, gallium arsenide dan selenium.', 'verbal', 'topik3', 'verbal-image', '', '2025-04-19 03:39:41', NULL),
(150, 1, 'Fotoconductiv', 'Mengubah intensitas cahaya menjadi perubahan konduktivitas. Konduktivitas disini adalah kemampuan suatu bahan untuk menghantarkan arus listrik (konduktor). Bahan-bahan yang digunakan untuk konduktor tersebut adalah cadmium selenoide atau cadmium sulfide. Berdasarkan kemampuan konduktor menerima intensitas cahaya terdapat 3 tipe fotoconductiv yaitu Fotoresistor, Fotodioda, Fototransitor.', 'verbal', 'topik3', 'verbal-image', '', '2025-04-19 03:39:57', NULL),
(151, 1, 'Fotodioda', 'Fotodioda adalah perangkat semikonduktor yang berfungsi sebagai sensor cahaya, bekerja dengan cara mengubah energi cahaya yang diterimanya menjadi arus listrik. Tidak seperti fotoresistor yang mengubah resistansi berdasarkan cahaya, fotodioda menghasilkan arus listrik yang sebanding dengan intensitas cahaya yang jatuh pada permukaannya. Dengan respon yang cepat dan sensitivitas tinggi, fotodioda menjadi pilihan ideal untuk aplikasi yang memerlukan deteksi cahaya dengan kecepatan tinggi dan presisi.\r\n\r\nDalam konteks IoT, fotoresistor dapat berperan sebagai sensor utama untuk memantau perubahan kondisi cahaya di lingkungan. Dengan menghubungkannya ke perangkat IoT, seperti mikrokontroler, fotoresistor dapat mengirim data tentang tingkat pencahayaan yang kemudian dapat diproses, dianalisis, dan diintegrasikan ke dalam sistem otomatisasi. Contoh penggunaannya meliputi:\r\n\r\n1. Sistem Pencahayaan Pintar: Fotoresistor digunakan untuk mendeteksi perubahan intensitas cahaya di sebuah ruangan atau area luar. Berdasarkan data ini, sistem dapat secara otomatis menyalakan atau mematikan lampu, menghemat energi dan menambah kenyamanan.\r\n\r\n2. Sistem Monitoring Lingkungan: Fotoresistor dapat memantau pencahayaan alami di sebuah area tertentu, misalnya, di rumah kaca atau pertanian pintar, di mana tingkat cahaya penting untuk pertumbuhan tanaman. Sistem IoT dapat menyesuaikan penerangan buatan berdasarkan data dari fotoresistor.\r\n\r\n3. Keamanan dan Deteksi Intrusi: Dalam aplikasi keamanan, fotoresistor digunakan untuk mendeteksi adanya perubahan cahaya yang tiba-tiba, seperti bayangan orang yang mendekati pintu atau jendela, memicu alarm atau pemberitahuan di sistem IoT.', 'verbal', 'topik3', 'verbal-image', '', '2025-04-19 03:40:13', NULL),
(152, 1, 'Fotoresistor', 'Fotoresistor adalah sensor elektronik yang mengubah resistansinya ketika terkena cahaya. Fotoresistor juga dikenal sebagai light-dependent resistor (LDR) atau fotokonduktor. \r\n\r\nPrinsip kerja \r\n- Fotoresistor terbuat dari semikonduktor beresistansi tinggi.\r\n- Saat terkena cahaya, foton yang diserap oleh semikonduktor menyebabkan elektron meloncat ke pita konduksi.\r\n- Elektron bebas yang dihasilkan akan mengalirkan listrik, sehingga menurunkan resistansinya.\r\n\r\nPenggunaan\r\n- Fotoresistor digunakan untuk menunjukkan ada atau tidaknya cahaya, atau untuk mengukur intensitas cahaya. \r\n- Fotoresistor digunakan dalam rangkaian detektor peka cahaya, rangkaian sakelar yang diaktifkan oleh cahaya, dan rangkaian sakelar yang diaktifkan oleh gelap. \r\n- Fotoresistor digunakan untuk membuat lampu yang bisa otomatis menyala dan mati sendiri. \r\n- Fotoresistor digunakan untuk melacak cahaya matahari di stasiun cuaca dan sistem pemantauan lingkungan. \r\n\r\nKarakteristik\r\n- Fotoresistor memiliki sensitivitas yang bervariasi dengan panjang gelombang cahaya yang diterapkan. \r\n- Fotoresistor memiliki tingkat latensi tertentu antara paparan cahaya dan penurunan resistansi berikutnya, biasanya sekitar 10 milidetik. ', 'verbal', 'topik3', 'verbal-image', '', '2025-04-19 03:41:28', NULL),
(153, 1, 'Fototransistor', 'Fototransistor adalah jenis transistor yang berfungsi sebagai sensor cahaya, di mana arus yang mengalir melalui transistor dipengaruhi oleh intensitas cahaya yang diterima. Fototransistor bekerja serupa dengan fotodioda, tetapi dengan keuntungan tambahan dari amplifikasi internal, yang memungkinkan untuk mendeteksi tingkat cahaya yang lebih rendah dengan sensitivitas lebih tinggi. Karena kemampuannya untuk mengubah cahaya menjadi sinyal listrik yang diperkuat, fototransistor sering digunakan dalam aplikasi yang memerlukan deteksi cahaya yang lebih akurat dan kuat.\r\n\r\n', 'verbal', 'topik3', 'verbal-image', '', '2025-04-19 03:42:26', NULL);
INSERT INTO `mdl_files` (`id`, `course_id`, `name`, `description`, `learning_style`, `topik`, `type`, `file_path`, `created_at`, `deleted_at`) VALUES
(154, 1, 'Sensor Suhu dan Kelembaban (DHT11/DHT22)', 'Sensor suhu adalah alat yang digunakan untuk mengubah besaran panas menjadi besaran listrik yang dapat dengan mudah dianalisis besarnya. Ada beberapa metode yang digunakan untuk membuat sensor ini, salah satunya dengan cara menggunakan material yang berubah hambatannya terhadap arus listrik sesuai dengan suhunya. TMP36 merupakan salah satu sensor suhu atau temperature sensor yang cukup presisi pengukuran suhu dengan keluaran berupa tegangan output yang berubah secara linear terhadap temperatur Celcius.\r\nContoh penggunaan: Monitoring suhu ruangan, sistem pendingin otomatis.\r\nData keluarannya berbentuk digital.', 'verbal', 'topik3', 'verbal-image', '/storage/files/verbal/sensorsuhu.jpg', '2025-04-19 03:43:17', NULL),
(155, 1, 'Sensor Deteksi Objek (PIR dan Ultrasonik)', '- PIR (Passive Infrared): Mendeteksi gerakan berdasarkan panas tubuh.\r\n\r\n- Ultrasonik (HC-SR04): Mengukur jarak berdasarkan pantulan gelombang ultrasonik.\r\nContoh penggunaan: Sistem alarm, robot penghindar halangan.\r\n\r\n', 'verbal', 'topik3', 'verbal-image', '', '2025-04-19 03:43:47', NULL),
(156, 1, 'Aktuator Cahaya (LED – Light Emitting Diode)', 'LED adalah komponen yang mengubah energi listrik menjadi cahaya.\r\nDigunakan untuk indikator, penerangan, dan notifikasi visual.\r\nContoh penggunaan: LED berkedip sebagai indikator sistem aktif.\r\n\r\nLED RGB adalah sebuah LED yang dapat mengeluarkan perpaduan warna red(merah), green(hijau), dan blue(biru). LED ini seperti LED biasa memiliki anoda dan katoda hanya saja terdapat 3 anoda pada LED ini mewakili warna red, green, dan blue. Tegangan yang dikeluarkan pada anoda-anoda inilah yang akan mempengaruhi warna nyala dari LED RGB. LED rgb termasuk ke dalam integrated output dan dapat digunakan dengan mengendalikan LED red, green, blue, dan pin com yang dihubungkan ke gnd Arduino. Terdapat 2 jenis LED RGB yaitu yang berbentuk super flux (surface mount device) dan standart (bentuknya sama dengan LED biasa dengan jumlah kaki 4)', 'verbal', 'topik4', 'verbal-image', '', '2025-04-19 03:54:40', NULL),
(157, 1, 'Seven Segment', 'Seven segment sesungguhnya adalah LED yang disusun (segment) sehingga dapat digunakan untuk menampilkan angka desimal. Angka digital menjadi sangat penting untuk menampilkan informasi sebagai bagian panel display seperti pada jam digital, counter, kalkulator dan masih banyak lagi. Seven Segment memiliki 7 segment atau bagian yang bisa dikenalikan ON dan OFF. Susunan segment yang ON sedemikian rupa dapat merepresentasikan angka digital bahkan beberapa huruf. Jika semua segment dalam kondisi ON maka akan terbentuk angka 8. Angka lain yang dapat dihasilkan 0 - 9 dan huruf yang dapat dihasilkan A - F. Beberapa pengembangan seven segment adalah adanya penambahan . (titik) , (koma) dan : (titik dua). Terdapat 2 Jenis LED 7 Segment : Common Cathode -> ke negatif Common Anode -> ke positif', 'verbal', 'topik4', 'verbal-image', '', '2025-04-19 03:55:20', NULL),
(158, 1, 'Buzzer', 'Merupakan alat keluaran (output) yang mengubah sinyal listrik menjadi getaran suara, disebut juga dengan beeper atau piezoelectric. Karena memili ciri khas menghasilkan suara atau bunyi-bunyian maka buzzer dapat digunakan sebagai indikator suatu keadaan atau kondisi situasi tertentu. Buzzer dapat ditrigger untuk berbunyi dengan adanya tegangan kerja 3 volt hingga 12 volt. Yang dapat digunakan oleh Arduino yang tegangan dibawah 5 volt.\r\n', 'verbal', 'topik4', 'verbal-image', '', '2025-04-19 03:55:35', NULL),
(159, 1, 'Servo', 'Motor servo adalah motor dengan torsi besar dan dengan sudut yang bisa diatur. Motor ini hampir sama dengan motor stepper hanya saja motor servo memiliki gerak terbatas. Motor stepper dapat berputar 360o sedangkan motor servo hanya dapat berputar 180o atau 90o saja. Motor servo lebih mudah untuk dikontrol sudutnya karena menggunakan basis PWM.\r\n\r\n', 'verbal', 'topik4', 'verbal-image', '', '2025-04-19 03:55:54', NULL),
(160, 1, 'Contoh Deskripsi Naratif', 'Bayangkan kamu membuat prototipe lengan robot sederhana. Servo motor akan menjadi \'sendi\' untuk menggerakkan bagian lengan, buzzer memberikan bunyi peringatan ketika lengan bergerak, dan LED menyala untuk menunjukkan status aktif. Setiap bagian dari sistem ini adalah contoh pemanfaatan aktuator.', 'verbal', 'topik4', 'verbal-image', '', '2025-04-19 03:56:35', NULL),
(161, 1, 'Relay', 'Relay adalah saklar elektronik yang dikendalikan secara listrik.\r\nRelay memungkinkan mikrokontroler (misalnya Arduino) untuk mengendalikan beban besar seperti lampu AC, pompa air, atau perangkat listrik lainnya.\r\n\r\nSecara garis besar terdapat dua jenis relay, yaitu\r\n\r\n1. Relay elektromekanis : Relay yang menggunakan prinsip elektromagnetik untuk menggerakkan kontak saklar. Pada bagian pertama tulisan ini, akan memfokuskan kepada jenis relay satu ini\r\n\r\n2. Relay Solid State : Relay yang menggunakan teknologi semikonduktor (optocoupler) untuk melakukan switch ON dan OFF. Pembahasan tentang RSS akan diulas di bagian ke 2.\r\no)\r\n\r\nContoh penggunaan:\r\n\r\n- Menyalakan lampu rumah secara otomatis\r\n\r\n- Mengendalikan pompa air berdasarkan level air dalam tangki', 'verbal', 'topik5', 'verbal-image', '', '2025-04-19 04:04:18', NULL),
(162, 1, 'Electromechanical Relay\r\n\r\n', 'Pada gambar terdapat dua rangkaian elektronik, yang dinomeri (1) dan (2). Rangkaian (1) biasa disebut rangkaian picu (triggered circuit) yang (menggunakan prinsip elektromekanik) dapat mengendalikan apakah rangkaian (2) pada posisi ON ataupun OFF. Biasanya rangkaian (1) memiliki tegangan dan arus lebih rendah (karena terhubung dengan mikrokontroler atau rangkaian lain) daripada rangkaian (2) yang biasanya terhubung dengan tegangan AC 220V (untuk menyalakan lampu taman atau lainnya)\r\n\r\nKetika sinyal mengalir melalui rangkaian 1 (logika 1), sinyal tersebut mengalir pada kumparan dan menghasilkan gaya elektromagnetik dan menimbulkan medan magnet yang menarik kontak dan kemudian mengaktivasi rangkaian kedua (untuk bergerak ON ataupun OFF)\r\n\r\nKetika daya dari rangkaian 1 menghilang (logika 0), pegas akan menarik kontak kembali ke posisi awalnya, sehingga rangkaian (2) akan kembali off seperti semula.\r\n\r\nRelay elektromekanis menggunakan bagian yang bergerak untuk menghubungkan kontak dengan komponen output dari relay. Pergerakan kontak ini disebabkan oleh medan elektromagnetik dari sinyal input daya rendah, sehingga menyebabkan mengalirnya rangkaian dialiri dengan arus berdaya tinggi. Komponen fisik yang bergerak tersebut yang membuat bunyi “click” saat relay switch dari OFF ke ON.', 'verbal', 'topik5', 'verbal-image', '', '2025-04-19 04:05:01', NULL),
(163, 1, 'Modul Relay Elektromekanis', 'Modul relay elektromekanis yang umum digunakan dan tersedia di pasaran biasanya memiliki jenis low level trigger atau high level trigger. Relay low level trigger memerlukan picu sinyal logika 0 untuk mengaktifkan relay, sedangkan high level trigger membutuhkan sinyal logika 1 untuk mengaktifkan relay.\r\n\r\nNamun jika pembaca membutuhkan sebuah modul relay yang dapat digunakan untuk low level trigger dan high level trigger.\r\n\r\nModul relay tersebut memiliki dua sisi yaitu sisi trigger rangkaian (1) terdiri dari\r\n1. DC+ : tegangan DC positif (5 volt)\r\n\r\n2. DC- : ground\r\n3. IN : sinyal masukan untuk mengendalikan sisi\r\n\r\nsedangkan sisi switch rangkaian (2) terdiri dari\r\n\r\n1. NO : Normally Open, jika rangkaian dihubungkan di pin ini, maka koneksi antara COM dan NO akan open secara default\r\n\r\n2. NC : Normally Close, kebalikan dari NO, jika rangkaian dihubungkan di pin ini, maka koneksi antara COM dan NC akan close secara default\r\n\r\n3. COM : Common', 'verbal', 'topik5', 'verbal-image', '', '2025-04-19 04:05:18', NULL),
(164, 1, 'Keypad', 'Keypad adalah input device berupa tombol-tombol yang memungkinkan pengguna memasukkan data seperti angka, simbol, atau karakter.\r\nBiasanya terdiri dari 4x4 tombol (angka dan huruf) atau 3x4 (angka saja).\r\n\r\n\"Keypad seperti mulut pengguna yang bicara ke sistem: ‘Saya ingin membuka pintu’, atau ‘Saya ingin menyalakan lampu ruang tamu’.\"\r\n\r\nContoh penggunaan:\r\n\r\n- Sistem pengaman pintu dengan kode PIN\r\n\r\n- Antarmuka input untuk memilih mode operasi suatu alat', 'verbal', 'topik5', 'verbal-image', '', '2025-04-19 04:05:47', NULL),
(165, 1, 'Studi Kasus Naratif', '“Bayangkan kamu membuat sistem keamanan rumah. Pengguna mengetik PIN di keypad untuk membuka pintu. Jika PIN benar, Arduino akan mengaktifkan relay yang membuka kunci pintu listrik. Jika salah, sistem bisa mengaktifkan alarm.”', 'verbal', 'topik5', 'verbal-image', '', '2025-04-19 04:06:20', NULL),
(166, 1, 'Penjelasan Naratif', 'Internet of Things (IoT) tidak akan berfungsi tanpa jaringan komunikasi. Bayangkan setiap sensor, mikrokontroler, dan platform IoT seperti orang-orang yang perlu saling bicara. Agar mereka bisa bertukar informasi, dibutuhkan bahasa dan saluran komunikasi yang jelas.\r\n\r\nBeberapa protokol komunikasi populer dalam IoT antara lain:\r\n\r\n1. Wi-Fi – seperti berbicara lewat telepon rumah: cepat, tapi butuh sumber daya besar.\r\n\r\n2. Bluetooth – seperti bisik-bisik ke teman di sebelah: hemat energi, tapi jarak pendek.\r\n\r\n3. LoRa – seperti menulis surat yang dikirim lewat pos: sangat jauh jangkauannya, tapi lambat.\r\n\r\n4. MQTT – seperti berbicara di grup WhatsApp: semua pesan dikirim ke satu tempat, lalu diteruskan ke semua anggota.', 'verbal', 'topik6', 'verbal-image', '', '2025-04-19 04:08:54', NULL),
(167, 1, 'Wifi', '- Memungkinkan perangkat IoT terhubung langsung ke internet melalui jaringan nirkabel.\r\n- Contoh perangkat: ESP-12/8266, ESP32, ESP01.\r\n', 'verbal', 'topik6', 'verbal-image', '', '2025-04-19 04:09:29', NULL),
(168, 1, 'Bluetooth', '1. Cocok untuk komunikasi jarak dekat, termasuk varian Bluetooth Low Energy (BLE) yang hemat daya.\r\n2. Contoh perangkat: HC-05, HC-06, ESP32.', 'verbal', 'topik6', 'verbal-image', '', '2025-04-19 04:09:44', NULL),
(169, 1, 'Cellular', '1. Menggunakan jaringan seluler seperti 2G, 4G LTE, atau 5G untuk komunikasi jarak jauh, tanpa bergantung pada Wi-Fi.\r\n2. Contoh perangkat: SIM800, SIM900.', 'verbal', 'topik6', 'verbal-image', '', '2025-04-19 04:09:58', NULL),
(170, 1, 'Jaringan Komunikasi IoT\r\n\r\n', 'Berikut ini beberapa komponen pembelajaran tambahan untuk mendukung gaya belajar visual pada topik Jaringan Komunikasi IoT\r\n\r\n', 'verbal', 'topik6', 'verbal-image', '/storage/files/verbal/jaringan2.png', '2025-04-19 04:10:42', NULL),
(171, 1, 'Ilustrasi Analogi Verbal', '“Sensor adalah mata yang melihat lingkungan. Mikrokontroler adalah otak yang berpikir. Tapi tanpa mulut dan telinga alias jaringan komunikasi, informasi tidak akan pernah sampai ke pusat data atau pengguna.”\r\n\r\n', 'verbal', 'topik6', 'verbal-image', '', '2025-04-19 04:11:07', NULL),
(172, 1, 'Penjelasan Naratif', 'Dalam dunia Internet of Things (IoT), platform adalah pusat komando. Semua data dari sensor, aktuator, dan perangkat pintar dikumpulkan, dianalisis, dan divisualisasikan di platform ini. Beberapa platform IoT yang sering digunakan:\r\n\r\n1. ThingSpeak\r\nPlatform open-source dari MathWorks. Mudah digunakan untuk menampilkan grafik data secara real-time dan cocok untuk proyek edukasi.\r\n\r\n2. Blynk\r\nAplikasi mobile-friendly yang memungkinkan kamu membuat dashboard IoT interaktif tanpa coding antarmuka.\r\n\r\n3. Adafruit IO\r\nMenawarkan dashboard visual dan dokumentasi kuat, cocok untuk integrasi sensor sederhana dengan grafik yang menarik.\r\n\r\n4. Google Cloud IoT Core\r\nCocok untuk proyek skala besar. Menyediakan manajemen perangkat, keamanan, dan analisis big data.', 'verbal', 'topik7', 'verbal-image', '', '2025-04-19 04:20:17', NULL),
(173, 1, 'Diagram Alur\r\n\r\n', 'Diagram visual alur komunikasi data dari sensor -> mikrokontroler -> koneksi jaringan -> platform IoT -> visualisasi data.\r\n\r\n', 'verbal', 'topik7', 'verbal-image', '/storage/files/verbal/diagram_alur.png', '2025-04-19 04:22:05', NULL),
(174, 1, 'Narasi Verbal', 'Bayangkan kamu adalah seorang petani modern. Kamu memiliki ladang yang penuh dengan sensor suhu, kelembaban tanah, dan kamera pengawas. Setiap hari, data dari ladangmu dikirim ke ThingSpeak. Dari situ, kamu bisa melihat grafik suhu yang naik tajam siang hari dan menurun malam hari. Kamu tahu kapan harus menyiram tanaman karena platform IoT-mu memberi sinyal lewat aplikasi Blynk yang terhubung ke smartphone-mu. Tanpa kamu perlu mengecek langsung ke lapangan, semuanya sudah dikendalikan dari jarak jauh.', 'verbal', 'topik7', 'verbal-image', '', '2025-04-19 04:22:34', NULL),
(175, 1, 'Arsitektur Sistem Internet of Things (IoT)', 'Gambar berikut adalah representasi dari arsitektur sistem Internet of Things (IoT) yang terdiri dari empat lapisan utama, yaitu:\r\n\r\n1. Perangkat Sensor (Layer 1)\r\nKomponen dasar IoT untuk mendeteksi atau mengukur data fisik seperti suhu, kelembaban, gerakan, dll.\r\nContoh: GPS, Smart Device, RFID, Sensor.\r\n\r\n2.Jaringan & Gateway (Layer 2)\r\nMenyediakan konektivitas agar data dari sensor dapat dikirim ke sistem pusat.\r\nContoh jaringan: WPAN, WLAN, WWAN, Internet.\r\n\r\n3. Platform (Layer 3)\r\nLapisan untuk pengolahan data, keamanan, analitik, dan integrasi perangkat.\r\nContoh: Data Center, Search Engine, Smart Decision, Info Security, Data Mining.\r\n\r\n4. Aplikasi & Layanan (Layer 4)\r\nLayanan yang dimanfaatkan oleh pengguna akhir berbasis data IoT.\r\nContoh: Smart Logistic, Smart Grid, Green Building, Smart Transport, Environmental Monitoring.', 'sequential', 'topik1', 'sequential-image', '/storage/files/sequential/struktur_iot.png', '2025-04-19 04:50:34', NULL),
(176, 1, 'Tinkercad: IDE dan Simulator Online Arduino UNO', 'Tinkercad merupakan tools online gratis untuk membantu mendesign dan menciptakan produknya sendiri. Pada awalnya tools ini hanya memiliki fitur 3D design yang sederhana, namun saat ini Tinkercad telah dikembangkan dengan tools baru yang bernama “Circuit” untuk melakukan simulasi rangkaian elektronika sederhana dan juga Arduino. Untuk dapat menggunakan terlebih dahulu melakukan pendaftaran pada alamat web site: https://www.tinkercad.com\r\nPemrograman untuk Arduino dengan menggunakan Tinkercad sebagai IDE dan simulator online ini dapat dilakukan dengan 2 pendekatan pemrograman:\r\n\r\n1. Code => Sama persis dengan Arduino IDE.\r\nTerdapat beberapa perintah / function dasar yang digunakan:\r\n- pinMode(), digunakan untuk menntukan pin yang akan digunakan sebagai OUTPUT, INPUT\r\n- digitalWrite(), digunakan untuk memberikan nilai HIGH, LOW\r\n- delay(), menunda jalannya program dalam milidetik\r\n- info detail ada di https://www.arduino.cc/reference/en\r\n\r\n2. Block\r\nPemrograman ini diwakilkan dengan penggunaan block-block diagram yang sudah ditentukan. Cukup dengan click and drag block yang akan digunakan.', 'sequential', 'topik2', 'sequential-image', '', '2025-04-19 05:02:48', NULL),
(177, 1, 'Light Emitting Diode (LED) sebagai pengenalan actuatorPage', 'Light Emitting Diode (LED) merupakan salah satu komponen elektronika yang mengubah energi listrik menjadi energi cahaya. LED paling banyak dijumpai dalam kehidupan sehari, digunakan sebagai lampu atau di layar televisi (LED). LED juga merupakan actuator yang paling sederhana. LED memiliki cahaya yang beraneka warna tergantung pada bahan pembuatnya yaitu semikonduktor. Terdapat jenis LED yang tidak bisa dilihat cahaya oleh mata manusia, jenis ini termasuk LED infrared.\r\n\r\nUntuk menyalakan LED maka haru terhubung dengan power. LED yang terhubung ke Arduino dapat dilairi dengan power tegangan sebesar 3,3 Volt atau 5 Volt tergantung berada di PIN Digital atau Analog. Sedangkan Arduino Uno memiliki aliran kuat arus pada PIN-nya (rekomendasi) sebesar 20mA atau sama dengan 0,02 A. Agar LED tidak mendapatkan kelebihan power maka perlu dipasang sebuah hambatan. Dengan menggunakan rumus V = I x R maka dapat diperoleh berapa besarnya hambatan (R) yang digunakan. Hambatan yang harus digunakan : R = V / I ; R = 5 / 0,02 = 250 W , karena dipasaran tidak ada dapat dipakai dengan penggantinya yaitu 220 ohm, 240 ohm, maupun 270 ohm.\r\n\r\n\r\nDalam akses LED ada 2 kondisi :\r\n\r\n1. activehigh adalah kondisi led akan menyala jika padapin output arduino jika diberikan logika 1 atau high\r\n\r\n2. activelow yaitu kondisi led akan menyala jika diberikan logika 0 atau low\r\n', 'sequential', 'topik2', 'sequential-image', '', '2025-04-19 05:05:02', NULL),
(178, 1, 'Struktur Program Arduino', 'Program Arduino ditulis menggunakan bahasa pemrograman C/C++, meskipun dalam IDE Arduino, pengguna biasanya hanya perlu fokus pada fungsi-fungsi yang sudah tersedia untuk mempermudah pembuatan program. Berikut adalah struktur dasar dari sebuah program Arduino:\r\n\r\nBerikut ini penjelasan setiap bagian dari struktur program di atas:\r\n\r\n1. Header\r\n\r\nBagian ini berisi semua pustaka atau library yang diperlukan untuk program Arduino. Pustaka adalah kumpulan fungsi yang sudah dibuat sebelumnya dan bisa digunakan kembali untuk mempermudah pengembangan program. Contohnya adalah pustaka untuk mengendalikan motor, sensor, atau modul komunikasi tertentu. Pustaka ini perlu di \"include\" di awal program agar fungsi-fungsi yang ada di dalamnya dapat digunakan.\r\n\r\n2. Deklarasi Variabel Global\r\n\r\nBagian ini digunakan untuk mendeklarasikan variabel yang akan digunakan secara global di seluruh program. Variabel global adalah variabel yang dapat diakses dan dimanipulasi dari mana pun dalam program.\r\n\r\n3. Setup Function\r\n\r\nFungsi setup() adalah fungsi khusus yang hanya dieksekusi satu kali saat program Arduino pertama kali dijalankan. Fungsi ini digunakan untuk melakukan inisialisasi, seperti mengatur pin, menginisialisasi variabel, atau menyiapkan kondisi awal.\r\n\r\n4. Loop Function\r\n\r\nFungsi loop() adalah inti dari program Arduino. Setelah fungsi setup() dieksekusi, Arduino akan terus mengeksekusi fungsi loop() secara berulang tanpa henti. Di dalam fungsi loop() biasanya berisi kode-kode yang mengatur perilaku dari proyek yang sedang dibuat.', 'sequential', 'topik2', 'sequential-image', '/storage/files/sequential/struktur_arduino.jpg', '2025-04-19 05:07:30', NULL),
(179, 1, 'Pemrograman Arduino Dasar', 'Ini adalah modul untuk Pemrograman Arduino Dasar.', 'sequential', 'topik2', 'sequential-pdf', '/storage/files/sequential/Pemrograman Arduino Dasar.pdf', '2025-04-19 05:12:33', NULL),
(180, 1, 'Pemrograman dan I/O Arduino', 'Ini adalah halaman resmi dari Arduino.', 'sequential', 'topik2', 'sequential-link', 'https://www.arduino.cc/', '2025-04-19 05:13:40', NULL),
(181, 1, 'Pemrograman dan I/O Arduino', 'Ini adalah halaman resmi dari Tinkercad.', 'sequential', 'topik2', 'sequential-link', 'https://www.tinkercad.com/', '2025-04-19 05:14:19', NULL),
(182, 1, 'Sensor Cahaya', 'Sensor ini memiliki tugas menerima input berupa intensitas sinar atau cahaya menjadi konduktivitas (arus listrik). Nilai arus yang dihasilkan sangat bergantung pada kekuatan cahaya yang diterima pada sensor. Sensor yang memiliki tambahan komponen pendukung untuk menjaga peforma lebih baik disebut dengan modul sensor. Terdapat 2 jenis sensor cahaya: Fotovoltaic dan Fotoconductiv.', 'sequential', 'topik3', 'sequential-pdf', '/storage/files/sequential/Sensor Cahaya.pdf', '2025-04-19 05:24:15', NULL),
(183, 1, 'Fotovoltaic', 'Mengubah sinar atau cahaya matahari menjadi arus listrik DC (Direct Current). Sering dimanfaatkan sebagai sumber energi alternatif yang dikenal dengan Pembangkit Listrik Tenaga Surya (PLTS). Semakin kuat sinar matahari maka arus listrik DC yang dihasilkan semakin besar. Bahan yang dimanfaatkan untuk pembuatan panel surya ini adalah silicon, cadmium sullphide, gallium arsenide dan selenium.', 'sequential', 'topik3', 'sequential-image', '/storage/files/sequential/fotovoltaic.jpg', '2025-04-19 05:28:22', NULL),
(184, 1, 'Fotoconductiv', 'Mengubah intensitas cahaya menjadi perubahan konduktivitas. Konduktivitas disini adalah kemampuan suatu bahan untuk menghantarkan arus listrik (konduktor). Bahan-bahan yang digunakan untuk konduktor tersebut adalah cadmium selenoide atau cadmium sulfide. Berdasarkan kemampuan konduktor menerima intensitas cahaya terdapat 3 tipe fotoconductiv yaitu Fotoresistor, Fotodioda, Fototransitor.', 'sequential', 'topik3', 'sequential-image', '', '2025-04-19 05:29:14', NULL),
(185, 1, 'Fotoresistor', 'Fotoresistor, juga dikenal sebagai LDR (Light Dependent Resistor), adalah jenis sensor pasif yang resistansinya berubah berdasarkan intensitas cahaya yang jatuh padanya. Sebagai sensor cahaya, fotoresistor memanfaatkan prinsip semikonduktor di mana resistansi berkurang ketika intensitas cahaya meningkat, dan meningkat ketika intensitas cahaya berkurang. Karena sifatnya yang responsif terhadap cahaya, fotoresistor sering digunakan dalam aplikasi berbasis Internet of Things (IoT).\r\n\r\nDalam konteks IoT, fotoresistor dapat berperan sebagai sensor utama untuk memantau perubahan kondisi cahaya di lingkungan. Dengan menghubungkannya ke perangkat IoT, seperti mikrokontroler, fotoresistor dapat mengirim data tentang tingkat pencahayaan yang kemudian dapat diproses, dianalisis, dan diintegrasikan ke dalam sistem otomatisasi. Contoh penggunaannya meliputi:\r\n\r\n1. Sistem Pencahayaan Pintar: Fotoresistor digunakan untuk mendeteksi perubahan intensitas cahaya di sebuah ruangan atau area luar. Berdasarkan data ini, sistem dapat secara otomatis menyalakan atau mematikan lampu, menghemat energi dan menambah kenyamanan.\r\n\r\n2. Sistem Monitoring Lingkungan: Fotoresistor dapat memantau pencahayaan alami di sebuah area tertentu, misalnya, di rumah kaca atau pertanian pintar, di mana tingkat cahaya penting untuk pertumbuhan tanaman. Sistem IoT dapat menyesuaikan penerangan buatan berdasarkan data dari fotoresistor.\r\n\r\n3. Keamanan dan Deteksi Intrusi: Dalam aplikasi keamanan, fotoresistor digunakan untuk mendeteksi adanya perubahan cahaya yang tiba-tiba, seperti bayangan orang yang mendekati pintu atau jendela, memicu alarm atau pemberitahuan di sistem IoT.', 'sequential', 'topik3', 'sequential-image', '/storage/files/sequential/fotoresistor.png', '2025-04-19 05:30:10', NULL),
(186, 1, 'Fotodioda', 'Fotodioda adalah perangkat semikonduktor yang berfungsi sebagai sensor cahaya, bekerja dengan cara mengubah energi cahaya yang diterimanya menjadi arus listrik. Tidak seperti fotoresistor yang mengubah resistansi berdasarkan cahaya, fotodioda menghasilkan arus listrik yang sebanding dengan intensitas cahaya yang jatuh pada permukaannya. Dengan respon yang cepat dan sensitivitas tinggi, fotodioda menjadi pilihan ideal untuk aplikasi yang memerlukan deteksi cahaya dengan kecepatan tinggi dan presisi.', 'sequential', 'topik3', 'sequential-image', '/storage/files/sequential/fotodioda.jpg', '2025-04-19 05:30:53', NULL),
(187, 1, 'Fototransistor', 'Fototransistor adalah jenis transistor yang berfungsi sebagai sensor cahaya, di mana arus yang mengalir melalui transistor dipengaruhi oleh intensitas cahaya yang diterima. Fototransistor bekerja serupa dengan fotodioda, tetapi dengan keuntungan tambahan dari amplifikasi internal, yang memungkinkan untuk mendeteksi tingkat cahaya yang lebih rendah dengan sensitivitas lebih tinggi. Karena kemampuannya untuk mengubah cahaya menjadi sinyal listrik yang diperkuat, fototransistor sering digunakan dalam aplikasi yang memerlukan deteksi cahaya yang lebih akurat dan kuat.', 'sequential', 'topik3', 'sequential-image', '/storage/files/sequential/fototransitor.jpg', '2025-04-19 05:31:19', NULL),
(188, 1, 'Sensor Suhu & Kelembaban\r\n\r\n', 'Sensor suhu adalah alat yang digunakan untuk mengubah besaran panas menjadi besaran listrik yang dapat dengan mudah dianalisis besarnya. Ada beberapa metode yang digunakan untuk membuat sensor ini, salah satunya dengan cara menggunakan material yang berubah hambatannya terhadap arus listrik sesuai dengan suhunya. TMP36 merupakan salah satu sensor suhu atau temperature sensor yang cukup presisi pengukuran suhu dengan keluaran berupa tegangan output yang berubah secara linear terhadap temperatur Celcius.\r\n\r\nSensor ini menggunakan teknik solid-state untuk menentukan suhu. Artinya, tidak menggunakan merkuri (seperti termometer lama), bimetalic strip (seperti di beberapa termometer rumah atau kompor), juga tidak menggunakan termistor (resistor sensitif suhu). Sebaliknya, menggunakan fakta ketika suhu meningkat, tegangan dioda meningkat pada tingkat yang diketahui. (Secara teknis, ini sebenarnya drop tegangan antara basis dan emitor - Vbe - dari transistor). Dengan tepat memperkuat perubahan tegangan, maka akan menghasilkan sinyal analog yang berbanding lurus dengan suhu. Kaki 1 terhubung dengan power tegangan 2,7 hingga 5,5 v, kaki 2 terhubung dengan pin analog, dan kaki 3 terhubung pada ground. Output dari kaki 2 berupa analog voltage output yaitu tegangan analog sehingga untuk dapat terbaca dalam satuan derajat celcius perlu ada konversi.\r\n\r\nRumus konversi:\r\nVoltage = value_pin2 * 5 / 1024\r\ntempC = (Voltage – 0.5) * 100\r\n\r\nSensor TMP36 dapat mengukur suhu dikisaran -40 °C hingga 150 °C / -40 °F hingga 302 °F dengan retang tegangan output 0.1V (-40 °C) hingga 2.0V (150 °C) tetapi akurasi menurun setelah 125 °C. Karena sensor ini tidak memiliki bagian yang bergerak, maka sensor tidak pernah aus, tidak perlu kalibrasi, bekerja di bawah banyak kondisi lingkungan, dan konsisten antara sensor dan pembacaan. Tipe lain yang juga tersedia adalah LM35 / TMP35 (output Celcius) dan LM34 / TMP34 (keluaran Farenheit).\r\n\r\nJika TMP36, TMP35 atau TMP34 merupakan sensor yang membaca output tegangan dalam bentuk analog maka untuk yang digital dapat digunakan DS18B20. Penampakan aslinya mirip – mirip TMP36, ada 3 kaki, dengan warna hitam. Hanya sensornya sudah dibungkus dengan ‘waterproof’ sehingga sensor tahan air. Ketiga kaki/pin sensor suhu DS18B20 fungsinya juga hampir sama dengan TM36. Kaki nomor 1 sebagai input tegangan (5V), kaki tengah data output dan kaki ke-3 sebagai ground.\r\n\r\nUntuk memanfaatkan sensor DS18B20 harus melibatkan 2 library One Wire dan Dallas Temperature. Library berisi kumpulan kode yang dapat mengeksekusi perintah-perintah tertentu berdasarkan fungsi dan prosedur. Diakses dengan perintah include.\r\n\r\nLangkah-langkah menambah Library Arduino adalah sebagai berikut :\r\n1. Download library, pastikan library tersebut dalam keadaan terkompresi file ZIP\r\n2. Buka aplikasi Arduinonya, lalu Masuk ke menu SKETCH, pilih INCLUDE LIBRARY, pilih ADD. ZIP Library\r\n3. Cari file Library yang sudah di Download, lalu OPEN\r\n\r\n', 'sequential', 'topik3', 'sequential-image', '', '2025-04-19 05:32:54', NULL),
(189, 1, 'Sensor Suhu & Kelembaban', 'Sensor suhu dan kelembaban DHT (Digital Humidity and Temperature) adalah jenis sensor yang sering digunakan dalam berbagai aplikasi IoT (Internet of Things) untuk memantau kondisi lingkungan. Sensor ini terdiri dari dua komponen utama: thermistor untuk mengukur suhu dan kapasitor berbasis polimer untuk mendeteksi kelembaban. Model DHT yang umum digunakan adalah DHT11 dan DHT22, di mana DHT22 lebih presisi dan memiliki rentang pengukuran yang lebih luas dibandingkan dengan DHT11.\r\n\r\nSensor DHT mengirimkan data secara digital, sehingga mudah diintegrasikan dengan berbagai platform mikrokontroler yang sering digunakan dalam proyek IoT. Berikut adalah beberapa contoh penggunaan sensor DHT dalam konteks IoT:\r\n\r\n1. Pemantauan Lingkungan di Smart Home: Sensor DHT dapat digunakan untuk memantau suhu dan kelembaban di dalam rumah, dan datanya dapat dikirimkan ke aplikasi IoT yang kemudian dapat digunakan untuk mengontrol sistem HVAC (Heating, Ventilation, and Air Conditioning). Sistem ini dapat secara otomatis mengatur suhu dan kelembaban ruangan agar tetap nyaman dan efisien dalam penggunaan energi.\r\n\r\n2. Smart Farming: Dalam pertanian cerdas, sensor DHT digunakan untuk memantau kondisi lingkungan seperti suhu dan kelembaban udara di rumah kaca atau ladang. Data yang dikumpulkan secara real-time oleh sensor DHT dapat dianalisis oleh sistem IoT untuk menentukan kapan tanaman perlu disiram atau kapan ventilasi rumah kaca harus diaktifkan, membantu mengoptimalkan pertumbuhan tanaman dan menghemat sumber daya.\r\n\r\n3. Pemantauan Kualitas Udara: Pada aplikasi IoT untuk memantau kualitas udara dalam ruangan, sensor DHT digunakan untuk memantau perubahan suhu dan kelembaban yang dapat mempengaruhi kualitas udara. Data ini dikombinasikan dengan sensor lain seperti sensor gas atau partikel debu untuk memberi gambaran lebih lengkap tentang kondisi udara. Sistem IoT kemudian dapat memberikan rekomendasi atau memicu alat pembersih udara otomatis jika diperlukan.\r\n\r\n4. Sistem Kesehatan dan Pemantauan Ruangan: Di rumah sakit, laboratorium, atau fasilitas penyimpanan yang memerlukan kondisi lingkungan yang terkontrol, sensor DHT digunakan untuk memantau suhu dan kelembaban secara real-time. Dengan bantuan IoT, data ini dapat diakses dari jarak jauh dan dapat mengirimkan peringatan jika ada perubahan mendadak yang memerlukan tindakan, seperti dalam ruang penyimpanan obat-obatan yang sensitif terhadap suhu.\r\n\r\n5. IoT untuk Pemantauan Cuaca: Sensor DHT juga sering digunakan dalam stasiun cuaca berbasis IoT untuk memantau suhu dan kelembaban di lingkungan luar. Data ini bisa dikirim ke server atau cloud untuk analisis lebih lanjut atau untuk pembuatan model prediksi cuaca sederhana.\r\n\r\nKeunggulan sensor DHT adalah ukurannya yang kecil, konsumsi daya rendah, dan kemampuan untuk mengirimkan data suhu dan kelembaban secara akurat dalam satu paket, menjadikannya pilihan ideal untuk berbagai aplikasi IoT. Integrasi dengan sistem IoT memungkinkan pengguna untuk memantau kondisi lingkungan dari jarak jauh, mengoptimalkan kontrol otomatis, dan mendapatkan data real-time yang dapat digunakan untuk analisis lebih lanjut.\r\n\r\nUntuk melakukan pengukuran suhu dan kelembaban digunakan sensor DHT11 atau DHT22. Sensor tersebut tidak tersedia dalam Tinkercad. Alat untuk mengukur suhu dinamakan termometer dan alat untuk mengukur kelembaban adalah Higrometer. Perbedaan sensor DHT11 dan DHT22 adalah terletak pada akurasinya, DHT22 memiliki nilai akurasi yang lebih tinggi. Secara fisik hampir sama hanya DHT11 berwarna biru dan DHT22 berwarna putih/krem.\r\n\r\nDHT11 maupun DHT22 untuk data keluarannya sudah terkonversi dari analog ke digital sehingga dapat diakses melalui pin digital Arduino. Membutuh library DHT11 atau DHT22.', 'sequential', 'topik3', 'sequential-image', '', '2025-04-19 05:34:19', NULL),
(190, 1, 'Sensor Ultrasonic', 'Sensor jenis ini dalam bentuk modul sensor yang mendeteksi sebuah objek menggunakan suara (ultrasonic) dan terdapat pada Tinkercad. Gelombang ultrasonic dgn frekuensi sangat tinggi yaitu 20.000 Hz dan tidak dapat di dengar oleh telinga manusia namun dapat didengar oleh anjing, kucing, kelelawar, dan lumba-lumba. Bunyi ultrasonik bisa merambat melalui zat padat, cair dan gas serta tidak dipengaruhi cahaya, suhu, dan kelembaban. Sensor ultrasonic terdiri dari sebuah transmitter (pemancar) dan sebuah receiver (penerima). Transmitter berfungsi untuk memancarkan sebuah gelombang suara kearah depan. Jika ada sebuah objek didepan transmitter maka sinyal tersebut akan memantul kembali ke Receiver. Fungsi sensor ultrasonic adalah mendeteksi benda atau objek di hadapan sensor. Penerapannya banyak dipakai pada robot pemadam api dan robot obstacle lainnya. Salah satu sensor yang paling sering digunakan adalah sensor ultrasonic tipe HC SR04.\r\n\r\nHC-SR04 memiliki 2 komponen utama sebagai penyusunnya yaitu ultrasonic transmitter dan ultrasonic receiver. Fungsi dari ultrasonic transmitter adalah memancarkan gelombang ultrasonik dengan frekuensi 40 KHz kemudian ultrasonic receiver menangkap hasil pantulan gelombang ultrasonik yang mengenai suatu objek.\r\n\r\nWaktu tempuh gelombang ultrasonik dari pemancar hingga sampai ke penerima sebanding dengan 2 kali jarak antara sensor dan bidang pantul.\r\n\r\nPengukuran jarak menggunakan sensor ultrasonik HC-SR04 adalah, ketika pulsa trigger diberikan pada sensor, transmitter akan mulai memancarkan gelombang ultrasonik, pada saat yang sama sensor akan menghasilkan output TTL transisi naik menandakan sensor mulai menghitung waktu pengukuran, setelah receiver menerima pantulan yang dihasilkan oleh suatu objek maka pengukuran waktu akan dihentikan dengan menghasilkan output TTL transisi turun. Jika waktu pengukuran adalah t dan kecepatan suara adalah 340 m/s, maka jarak antara sensor dengan objek dapat dihitung dengan rumus : S = (t x 340 m/s) / 2 . Pemilihan HC-SR04 sebagai sensor jarak yang akan digunakan pada penelitian ini karena memiliki fitur sebagai berikut; kinerja yang stabil, pengukuran jarak yang akurat dengan ketelitian 0,3 cm, pengukuran maksimum dapat mencapai 4 meter dengan jarak minimum 2 cm, ukuran yang ringkas dan dapat beroperasi pada level tegangan TTL', 'sequential', 'topik3', 'sequential-image', '/storage/files/sequential/ultrasonik.jpeg', '2025-04-19 05:45:23', NULL),
(191, 1, 'Sensor Gerak (PIR)', 'Sensor Gerak yang digunakan berbasis pada Passive Infra Red (PIR) dan terdapat pada Tinkercad. Sensor ini akan mendeteksi adanya sumber infra merah, pasif disini diartikan bahwa sensor hanya menerima infra merah tidak memancarkan infra merah. Perlu diketahui bahwa seluruh benda memancarkan infra merah. Infra merah yang diterima merupakan akumulasi dari area yang mampu ditangkap oleh sensor PIR. Sensor PIR yang paling sering digunakan HCSR501. ', 'sequential', 'topik3', 'sequential-image', '/storage/files/sequential/sensor_pir.jpg', '2025-04-19 05:49:01', NULL),
(192, 1, 'Implementasi', '', 'sequential', 'topik3', 'sequential-video', 'https://www.youtube.com/embed/FxaTDvs34mM', '2025-04-19 05:49:55', NULL),
(193, 1, 'Sensor Api (Flame)', 'Sensor api tidak didukung oleh simulator Tinkercad. Sensor api berfungsi untuk mendeteksi adanya cahaya api. Sensor ini sangat sensitif terhadap nyala api (cahaya) dan radiasi di sekitarnya. Sensor ini dapat mendeteksi sumber cahaya biasa dengan panjang gelombang 760nm-1100nm dan dapat mendeteksi maksimal dengan jarak 100cm. Sensor ini menggunakan tranduser yang berupa infrared (IR) sebagai sensing sensor. Tranduser ini digunakan untuk mendeteksi akan penyerapan cahaya pada panjang gelombang tertentu. Sehinggan memungkinkan alat ini untuk membedakan antara spectrum cahaya pada api dengan spectrum cahaya lainnya seperti spectrum cahaya lampu.', 'sequential', 'topik3', 'sequential-image', '/storage/files/sequential/sensor_api.jpeg', '2025-04-19 05:51:40', NULL),
(194, 1, 'Implementasi sensor api pada micro controller\r\n', '', 'sequential', 'topik3', 'sequential-video', 'https://www.youtube.com/embed/GsfOXdO0i1A', '2025-04-19 05:53:06', NULL),
(195, 1, 'Sensor Suara (Sound)', 'Sensor suara ini juga tidak didukung oleh simulator Tinkercad. Sensor suara merupakan module sensor yang mensensing besaran suara untuk diubah menjadi besaran listrik yang akan dioleh mikrokontroler. Module ini bekerja berdasarkan prinsip kekuatan gelombang suara yang masuk. Dimana gelombang suara tersebut mengenai membran sensor, yang berefek pada bergetarnya membran sensor. Dan pada membran tersebut terdapat kumparan kecil yang dapat menghasilkan besaran listrik. Kecepatan bergeraknya membran tersebut juga akan menentukan besar kecilnya daya listrik yang akan dihasilkan. Komponen utama untuk sensor ini yaitu condeser mic sebagai penerima besar kecilnya suara yang masuk.', 'sequential', 'topik3', 'sequential-image', '/storage/files/sequential/sensor_suara.jpg', '2025-04-19 05:54:59', NULL),
(196, 1, 'Implementasi sensor suara pada micro controller ', '', 'sequential', 'topik3', 'sequential-video', 'https://www.youtube.com/embed/RwHGioglbk8', '2025-04-19 05:56:13', NULL),
(197, 1, 'LED RGB', 'LED RGB adalah sebuah LED yang dapat mengeluarkan perpaduan warna red(merah), green(hijau), dan blue(biru). LED ini seperti LED biasa memiliki anoda dan katoda hanya saja terdapat 3 anoda pada LED ini mewakili warna red, green, dan blue. Tegangan yang dikeluarkan pada anoda-anoda inilah yang akan mempengaruhi warna nyala dari LED RGB. LED rgb termasuk ke dalam integrated output dan dapat digunakan dengan mengendalikan LED red, green, blue, dan pin com yang dihubungkan ke gnd Arduino. Terdapat 2 jenis LED RGB yaitu yang berbentuk super flux (surface mount device) dan standart (bentuknya sama dengan LED biasa dengan jumlah kaki 4)', 'sequential', 'topik4', 'sequential-image', '/storage/files/sequential/led.jpg', '2025-04-19 06:16:33', NULL),
(198, 1, 'Contoh Rangkaian dan Sketch Actuator LED RGB\r\n\r\n', 'Percobaan berikut digunakan tinkercad untuk menghasilkan angka 1 dengan menggunakan seven segmen cathode.\r\n\r\n// deklarasi variabel pin LED\r\n\r\nint redPin = 11;\r\n\r\nint greenPin = 10;\r\n\r\nint bluePin = 9;\r\n\r\n//rutin dijalankan sekali saat Arduino start\r\n\r\nvoid setup()\r\n\r\n{\r\n\r\n   // deklarasi pin sebagai output\r\n\r\n   pinMode(redPin, OUTPUT);\r\n\r\n   pinMode(greenPin, OUTPUT);\r\n\r\n   pinMode(bluePin, OUTPUT);\r\n\r\n}\r\n\r\n//rutin dijalankan terus menerus setelah setup dijalankan\r\n\r\nvoid loop()\r\n\r\n{\r\n\r\n  setColor(255, 0, 0);\r\n  // setting warna merah\r\n\r\n  delay(1000);            // menunggu 1000 milidetik\r\n\r\n  setColor(0, 255, 0); // setting warna hijau\r\n\r\n  delay(1000);            // menunggu 1000 milidetik\r\n\r\n  setColor(0, 0, 255); // setting warna biru\r\n\r\n  delay(1000);            // menunggu 1000 milidetik \r\n\r\n  setColor(255, 255, 0); // setting warna kuning\r\n\r\n  delay(1000);            // menunggu 1000 milidetik\r\n\r\n  setColor(80, 0, 80); // setting warna ungu\r\n\r\n  delay(1000);            // menunggu 1000 milidetik\r\n\r\n  setColor(0, 255, 255); // setting warna aqua\r\n\r\n  delay(1000);            // menunggu 1000 milidetik\r\n\r\n}\r\n\r\n//rutin dijalankan setiap kali dipanggil\r\n\r\nvoid setColor(int red, int green, int blue)\r\n\r\n{\r\n\r\n  analogWrite(redPin, red);            //menulis data analog ke pin LED merah\r\n\r\n  analogWrite(greenPin, green);        //menulis data analog ke pin LED hijau\r\n\r\n  analogWrite(bluePin, blue);        //menulis data analog ke pin LED biru\r\n\r\n}\r\n\r\n', 'sequential', 'topik4', 'sequential-image', '', '2025-04-19 06:18:06', NULL),
(199, 1, 'Seven Segmen', 'Seven segment sesungguhnya adalah LED yang disusun (segment) sehingga dapat digunakan untuk menampilkan angka desimal. Angka digital menjadi sangat penting untuk menampilkan informasi sebagai bagian panel display seperti pada jam digital, counter, kalkulator dan masih banyak lagi. Seven Segment memiliki 7 segment atau bagian yang bisa dikenalikan ON dan OFF. Susunan segment yang ON sedemikian rupa dapat merepresentasikan angka digital bahkan beberapa huruf. Jika semua segment dalam kondisi ON maka akan terbentuk angka 8. Angka lain yang dapat dihasilkan 0 - 9 dan huruf yang dapat dihasilkan A - F. Beberapa pengembangan seven segment adalah adanya penambahan . (titik) , (koma) dan : (titik dua).\r\n\r\nTerdapat 2 Jenis LED 7 Segment :\r\n1. Common Cathode -> ke negatif\r\n2. Common Anode -> ke positif', 'sequential', 'topik4', 'sequential-image', '/storage/files/sequential/sevensegment.jpg', '2025-04-19 06:18:49', NULL),
(200, 1, 'Buzzer', 'Merupakan alat keluaran (output) yang mengubah sinyal listrik menjadi getaran suara, disebut juga dengan beeper atau piezoelectric. Karena memili ciri khas menghasilkan suara atau bunyi-bunyian maka buzzer dapat digunakan sebagai indikator suatu keadaan atau kondisi situasi tertentu. Buzzer dapat ditrigger untuk berbunyi dengan adanya tegangan kerja 3 volt hingga 12 volt. Yang dapat digunakan oleh Arduino yang tegangan dibawah 5 volt.\r\n\r\nBuzzer memiliki 2 jenis :\r\n\r\n1. Passive buzzer yaitu yang tidak mempunyai suara sendiri, sehingga cocok untuk dipasangkan dengan arduino yang dapat diprogram tinggi rendah nadanya. Contoh dalam kehidupan sehari – hari yaitu speaker.\r\n2. Active buzzer yaitu yang dapat berdiri sendiri atau standalone atau singkatnya sudah mempunyai suara tersendiri ketika diberikan catu daya.\r\n\r\nSecara default kaki buzzer terubung ke ground (-) dan yang lainnya sebagai data. Untuk Modul buzzer dapat terhubung juga dengan power (+).', 'sequential', 'topik4', 'sequential-image', '/storage/files/sequential/buzzer.jpg', '2025-04-19 06:20:29', NULL),
(201, 1, 'Tone', 'Tone adalah nada atau bunyi yang beraturan dengan frekuensi tertentu. Dalam Arduino terdapat function tone yang digunakan untuk menghasilkan gelombang persegi dari frekuensi yang ditentukan (dan siklus kerja 50%) pada pin input buzzer. Durasi dapat ditentukan, jika tidak ditentukan maka gelombang berlanjut hingga panggilan ke noTone() atau diam. Pin dapat dihubungkan ke buzzer piezo atau speaker lain untuk memutar nada. Hanya satu nada yang dapat dihasilkan dalam satu waktu. Jika nada sudah dimainkan pada pin yang berbeda, panggilan ke function tone() tidak akan berpengaruh. Jika nada dimainkan pada pin yang sama, panggilan akan mengatur frekuensinya. Penggunaan function tone() akan mengganggu keluaran PWM pada pin 3 dan 11.\r\n\r\nCara penggunaan function tone adalah sebagai berikut :\r\n\r\n- tone(pin, frequency)\r\n- tone(pin, frequency, duration)\r\n\r\nDimana pin adalah kaki buzzer yang dihubungkan ke arduino, frequency adalah frekuensi nada dalam Hz, dan duration adalah durasi nada dalam milidetik. Silahkan coba sketch berikut ini untuk penerapan tone.', 'sequential', 'topik4', 'sequential-image', '', '2025-04-19 06:21:31', NULL),
(202, 1, 'Contoh Rangkaian dan Sketch Actuator Tone pada Buzzer\r\n', 'Lebih lanjut untuk memahami Tone dalam penggunaan Buzzer, dapat dicoba sketch berikut ini:\r\n#define NOTE_B0 31\r\n#define NOTE_C1 33\r\n#define NOTE_CS1 35\r\n#define NOTE_D1 37\r\n#define NOTE_DS1 39\r\n#define NOTE_E1 41\r\n#define NOTE_F1 44\r\n#define NOTE_FS1 46\r\n#define NOTE_G1 49\r\n#define NOTE_GS1 52\r\n#define NOTE_A1 55\r\n#define NOTE_AS1 58\r\n#define NOTE_B1 62\r\n#define NOTE_C2 65\r\n#define NOTE_CS2 69\r\n#define NOTE_D2 73\r\n#define NOTE_DS2 78\r\n#define NOTE_E2 82\r\n#define NOTE_F2 87\r\n#define NOTE_FS2 93\r\n#define NOTE_G2 98\r\n#define NOTE_GS2 104\r\n#define NOTE_A2 110\r\n#define NOTE_AS2 117\r\n#define NOTE_B2 123\r\n#define NOTE_C3 131\r\n#define NOTE_CS3 139\r\n#define NOTE_D3 147\r\n#define NOTE_DS3 156\r\n#define NOTE_E3 165\r\n#define NOTE_F3 175\r\n#define NOTE_FS3 185\r\n#define NOTE_G3 196\r\n#define NOTE_GS3 208\r\n#define NOTE_A3 220\r\n#define NOTE_AS3 233\r\n#define NOTE_B3 247\r\n#define NOTE_C4 262\r\n#define NOTE_CS4 277\r\n#define NOTE_D4 294\r\n#define NOTE_DS4 311\r\n#define NOTE_E4 330\r\n#define NOTE_F4 349\r\n#define NOTE_FS4 370\r\n#define NOTE_G4 392\r\n#define NOTE_GS4 415\r\n#define NOTE_A4 440\r\n#define NOTE_AS4 466\r\n#define NOTE_B4 494\r\n#define NOTE_C5 523\r\n#define NOTE_CS5 554\r\n#define NOTE_D5 587\r\n#define NOTE_DS5 622\r\n#define NOTE_E5 659\r\n#define NOTE_F5 698\r\n#define NOTE_FS5 740\r\n#define NOTE_G5 784\r\n#define NOTE_GS5 831\r\n#define NOTE_A5 880\r\n#define NOTE_AS5 932\r\n#define NOTE_B5 988\r\n#define NOTE_C6 1047\r\n#define NOTE_CS6 1109\r\n#define NOTE_D6 1175\r\n#define NOTE_DS6 1245\r\n#define NOTE_E6 1319\r\n#define NOTE_F6 1397\r\n#define NOTE_FS6 1480\r\n#define NOTE_G6 1568\r\n#define NOTE_GS6 1661\r\n#define NOTE_A6 1760\r\n#define NOTE_AS6 1865\r\n#define NOTE_B6 1976\r\n#define NOTE_C7 2093\r\n#define NOTE_CS7 2217\r\n#define NOTE_D7 2349\r\n#define NOTE_DS7 2489\r\n#define NOTE_E7 2637\r\n#define NOTE_F7 2794\r\n#define NOTE_FS7 2960\r\n#define NOTE_G7 3136\r\n#define NOTE_GS7 3322\r\n#define NOTE_A7 3520\r\n#define NOTE_AS7 3729\r\n#define NOTE_B7 3951\r\n#define NOTE_C8 4186\r\n#define NOTE_CS8 4435\r\n#define NOTE_D8 4699\r\n#define NOTE_DS8 4978\r\n\r\nconst int pin = 9;\r\n//not dalam melody:\r\nint melody[] = {\r\nNOTE_C4, NOTE_G3, NOTE_G3, NOTE_A3, NOTE_G3, 0, NOTE_B3, NOTE_C4\r\n};\r\n\r\n//birama\r\nint noteDurations[] = {\r\n4, 8, 8, 4, 4, 4, 4, 4\r\n};\r\n\r\nvoid setup() {\r\n//iterasi nada dalam melody\r\nfor (int thisNote = 0; thisNote < 8; thisNote++) {\r\n\r\n//hitung durasi nada, contoh seperempat not = 1000 / 4\r\nint noteDuration = 1000 / noteDurations[thisNote];\r\ntone(pin, melody[thisNote], noteDuration);\r\n\r\n//tetapkan waktu minimum di antara not-not tersebut.\r\nint pauseBetweenNotes = noteDuration * 1.30;\r\ndelay(pauseBetweenNotes);\r\n//nada berhenti\r\nnoTone(pin);\r\n}\r\n}\r\n\r\nvoid loop() {\r\n}', 'sequential', 'topik4', 'sequential-image', '', '2025-04-19 06:22:00', NULL),
(203, 1, 'Melody', 'Berikut adalah teknik lain dalam penggunaan buzzer untuk memainkan sebuah melody. Dimana perhitungan nada dilakukan mengikuti rumus:\r\n\r\ntimeHigh = period / 2 = 1 / (2 * toneFrequency)', 'sequential', 'topik4', 'sequential-image', '', '2025-04-19 06:22:32', NULL),
(204, 1, 'Contoh Rangkaian dan Sketch Actuator Melody pada Buzzer\r\n', 'int speakerPin = 9;\r\n\r\nint length = 15; // the number of notes\r\nchar notes[] = \"ccggaagffeeddc \"; // a space represents a rest\r\nint beats[] = { 1, 1, 1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 1, 2, 4 };\r\nint tempo = 300;\r\n\r\nvoid playTone(int tone, int duration) {\r\nfor (long i = 0; i < duration * 1000L; i += tone * 2) {\r\ndigitalWrite(speakerPin, HIGH);\r\ndelayMicroseconds(tone);\r\ndigitalWrite(speakerPin, LOW);\r\ndelayMicroseconds(tone);\r\n}\r\n}\r\n\r\nvoid playNote(char note, int duration) {\r\nchar names[] = { \'c\', \'d\', \'e\', \'f\', \'g\', \'a\', \'b\', \'C\' };\r\nint tones[] = { 1915, 1700, 1519, 1432, 1275, 1136, 1014, 956 };\r\n\r\n// play the tone corresponding to the note name\r\nfor (int i = 0; i < 8; i++) {\r\nif (names[i] == note) {\r\nplayTone(tones[i], duration);\r\n}\r\n}\r\n}\r\n\r\nvoid setup() {\r\npinMode(speakerPin, OUTPUT);\r\n}\r\n\r\nvoid loop() {\r\nfor (int i = 0; i < length; i++) {\r\nif (notes[i] == \' \') {\r\ndelay(beats[i] * tempo); // rest\r\n} else {\r\nplayNote(notes[i], beats[i] * tempo);\r\n}\r\n\r\n// pause between notes\r\ndelay(tempo / 2);\r\n}\r\n}', 'sequential', 'topik4', 'sequential-image', '', '2025-04-19 06:24:32', NULL),
(205, 1, 'Servo', 'Motor servo adalah motor dengan torsi besar dan dengan sudut yang bisa diatur. Motor ini hampir sama dengan motor stepper hanya saja motor servo memiliki gerak terbatas. Motor stepper dapat berputar 360o sedangkan motor servo hanya dapat berputar 180o atau 90o saja. Motor servo lebih mudah untuk dikontrol sudutnya karena menggunakan basis PWM.\r\n\r\nAda beberpa hal yang perlu menjadi perhatian dalam menggunakan servo :\r\n\r\n1. Banyak dimanfaatkan sebagai actuator robotika\r\n\r\n2. Berbasis pada PWM (Pulse Width Modulator)\r\n3. Berputar 180derajat (standard) dan ada yang dapat 360o (continous)\r\n\r\n4. tegangan kerja : 4,8 – 6 Vdc, torsi : 1,6 kg/cm, arus : < 500 mA, dimensi : 22 x 12,5 x 29,5 cm, berat : 9 gr, kecepatan putaran: 0,12 detik/60 derajat\r\n\r\nDengan menggunakan servo ini sudah tidak berbicara lagi mengenai putar searah (Clock Wise) atau berlawanan arah jarum jam (Clock Counter Wise) tapi sudut 0, 45, 90 dan seterusnya sampai dengan 180.\r\n\r\nLangkah mengaplikasikan servo ini adalah dimulai dengan #include <Servo.h> digunakan untuk menyertakan library Servo pada program Arduino. Kemudian melakukan inisiasi dengan cara Servo myservo; Tentukan pin data digital untuk servo yang digunakan dengan menggunakan method attach: myservo.attach(8); Lebih lanjut untuk mengatur pergerakan servo ke posisi 10 derajat tertentu dapat menggunakan: myservo.write(10);\r\n\r\nApabila ingin mendapatkan posisi 90o dan bergerak berlawanan arah jarum jam maka dituliskan perintah myservo.write(90); setelah itu dituliskan myservo.write(0); Akan tetapi jika ingin mendapatkan posisi 90o dan serarah jarum jam maka dituliskan perintah myservo.write(90); setelah itu dituliskan perintah myservo.write(180); Jadi posisi 0 s.d 180 sudah ditentukan oleh kontroller internal motor servo, dan cukup dengan memberikan perintah pada sudut mana motor akan berputar melalui perintah myservo.write(derajat);', 'sequential', 'topik4', 'sequential-image', '', '2025-04-19 06:26:11', NULL),
(206, 1, 'Relay', 'Relay termasuk dalam kategori sakelar yang bekerja dengan basis elektromagnetik untuk menggerakkan (switch) kontaktor keposisi tertentu. NC (Normally Close) : Kondisi awal dimana relai pada posisi tertutup, tetapi saat tealiri arus maka akan ke posisi terbuka. NO (Normally Open) : Merupakan kebalikan dari NC yang dimana kondisi awal relai pada posisi Open, tetapi saat tealiri arus maka akan ke posisi tertutup.\r\n\r\nRelay biasanya menggunakan kumparan/coil sebagai media untuk mengontrol switch. Cara kerjanya adalah ketika kumparan dialiri arus listrik, maka pada kumparan dihasilkan medan magnet yang akan menarik plat konduktor yang berfungsi sebagai switch sehingga berpindah titik yang lain, sebagai ilustrasi diatas, kumparan terletak diantara kaki 4-5. Sedangkan plat yang dimaksud adalah pada kaki 1 yang akan \"berpindah\" dari plat 2 ke 3 dan sebaliknya. Terdapat 2 jenis relay yang dapat digunakan pada tingkercad yaitu SPDT dan DPDT.', 'sequential', 'topik5', 'sequential-image', '/storage/files/sequential/relay.gif', '2025-04-19 06:31:17', NULL);
INSERT INTO `mdl_files` (`id`, `course_id`, `name`, `description`, `learning_style`, `topik`, `type`, `file_path`, `created_at`, `deleted_at`) VALUES
(207, 1, 'Relay SPDT (Single Pole Dual Throw)', 'Relay SPDT (Single Pole Dual Throw) adalah komponen elektronik yang berfungsi sebagai saklar otomatis yang memungkinkan kontrol terhadap perangkat listrik melalui sinyal digital dari mikrokontroler seperti Arduino. Relay SPDT memiliki satu kontak input (pole) dan dua kontak output (throw), memungkinkan pengguna untuk mengalihkan arus ke salah satu dari dua jalur yang berbeda. Ketika sinyal diberikan dari Arduino, relay SPDT mengubah posisinya, sehingga aliran listrik dialihkan ke perangkat yang ditentukan.\r\n\r\nDalam konteks Internet of Things (IoT), relay SPDT berperan penting dalam mengontrol perangkat atau sistem listrik dari jarak jauh atau otomatis. Berikut beberapa contoh aplikasi relay SPDT yang dikendalikan oleh Arduino dalam IoT:\r\n\r\n1. Sistem Otomatisasi Rumah Pintar: Relay SPDT sering digunakan untuk mengontrol peralatan rumah tangga seperti lampu, kipas angin, atau bahkan pintu otomatis. Dengan menghubungkan relay ke Arduino dan jaringan IoT, pengguna dapat menyalakan atau mematikan perangkat tersebut dari smartphone atau aplikasi IoT, meningkatkan kenyamanan dan efisiensi energi.\r\n\r\n2. Pengendalian Beban Listrik pada Industri: Dalam aplikasi IoT industri, relay SPDT digunakan untuk mengontrol beban listrik besar, seperti motor atau pemanas. Arduino yang dikendalikan dari sistem IoT mengirimkan sinyal ke relay, memungkinkan kontrol otomatis atas beban ini sesuai kebutuhan operasional, seperti penjadwalan otomatis atau pengendalian berdasarkan kondisi tertentu.\r\n\r\n3. Keamanan dan Sistem Alarm: Relay SPDT juga digunakan dalam sistem keamanan berbasis IoT untuk mengaktifkan atau menonaktifkan sirine, lampu darurat, atau pengunci pintu otomatis saat sensor mendeteksi adanya intrusi atau peringatan. Ketika sensor mendeteksi aktivitas yang mencurigakan, Arduino dapat mengirim sinyal ke relay untuk memicu tindakan keamanan.\r\n\r\n4. Sistem Kendali Pompa Air Otomatis: Dalam aplikasi IoT untuk pertanian atau irigasi pintar, relay SPDT digunakan untuk mengendalikan pompa air. Berdasarkan data dari sensor kelembaban tanah, Arduino dapat mengirim sinyal untuk menyalakan atau mematikan pompa melalui relay, sehingga irigasi hanya berjalan saat diperlukan.\r\n\r\n5. Pengaturan Sumber Daya Listrik Cadangan: Relay SPDT dapat berfungsi sebagai saklar otomatis untuk mengalihkan sumber daya listrik, misalnya dari listrik utama ke baterai cadangan. Dalam aplikasi IoT, Arduino mengendalikan relay untuk memastikan perangkat tetap mendapatkan daya, bahkan jika ada pemadaman listrik.\r\n\r\nRelay SPDT pada Arduino sangat berguna dalam IoT karena memungkinkan kontrol dari jarak jauh dan otomatis pada perangkat bertegangan tinggi yang tidak dapat langsung dikendalikan oleh mikrokontroler. Integrasinya dalam sistem IoT memungkinkan penggunaan listrik yang lebih efisien, pengendalian perangkat yang lebih aman, dan otomatisasi dalam berbagai aplikasi.\r\n\r\nPrinsip kerja dari relay ini yaitu: pada AB terdapat kumparan sebagai driver. ketika AB belum dilewati arus, maka terminal CE akan tersambung, dan ketika AB dilewati arus maka plat C akan berpindah sehingga terminal CD akan tersambung.', 'sequential', 'topik5', 'sequential-image', '/storage/files/sequential/relayspdt.jpg', '2025-04-19 06:33:24', NULL),
(208, 1, 'Relay DPDT', 'Relay DPDT (Dual Pole Dual Throw) adalah jenis relay yang memiliki dua kontak input (dual pole) dan dua set kontak output (dual throw), sehingga memungkinkan pengalihan dua rangkaian listrik secara bersamaan dengan satu sinyal kendali. Berbeda dengan Relay SPDT (Single Pole Dual Throw), yang hanya memiliki satu kontak input dan dua output, Relay DPDT dapat mengendalikan dua jalur listrik independen, menjadikannya lebih fleksibel dalam pengaturan otomatisasi dan kontrol dalam aplikasi IoT (Internet of Things).\r\n\r\nPenggunaan Relay DPDT pada Arduino dalam IoT memberikan beberapa keuntungan, terutama dalam situasi yang memerlukan pengalihan ganda atau pengendalian rangkaian listrik yang lebih kompleks. Berikut beberapa contoh aplikasi Relay DPDT dalam sistem IoT:\r\n\r\n1. Sistem Kendali Motor dalam Otomatisasi Rumah dan Industri: Relay DPDT dapat digunakan untuk mengendalikan arah putaran motor listrik dengan mengubah polaritas. Arduino yang dikendalikan melalui IoT dapat mengirim sinyal ke relay untuk mengubah arah putaran motor, misalnya untuk membuka dan menutup tirai otomatis di rumah pintar atau mengendalikan conveyor di lini produksi industri.\r\n\r\n2. Kontrol Sumber Daya Listrik Ganda: Dalam aplikasi IoT yang memerlukan pengalihan otomatis antara dua sumber daya, seperti dari sumber utama ke sumber daya cadangan, Relay DPDT memungkinkan pengalihan otomatis antara kedua sumber ini. Ketika sinyal diterima dari Arduino, relay mengalihkan arus ke sumber daya yang aktif, memastikan perangkat tetap beroperasi meski ada gangguan daya utama.\r\n\r\n3. Sistem Pencahayaan Ganda: Pada sistem pencahayaan berbasis IoT, Relay DPDT dapat digunakan untuk mengalihkan arus ke dua jalur pencahayaan berbeda. Dengan bantuan Arduino, sistem IoT dapat menentukan jenis pencahayaan yang diaktifkan, seperti lampu utama atau lampu redup, tergantung pada kebutuhan dan kondisi lingkungan.\r\n\r\n4. Sistem Pengendalian Keamanan dan Alarm Ganda: Relay DPDT memungkinkan kontrol lebih kompleks dalam sistem keamanan IoT, di mana dua perangkat berbeda dapat diaktifkan secara bersamaan, misalnya menghidupkan sirine dan menyalakan lampu darurat saat sensor mendeteksi ancaman. Dengan Arduino sebagai pengendali, relay dapat memicu kedua perangkat secara bersamaan untuk memberikan respons keamanan yang lebih efektif.\r\n\r\n5. Kendali Perangkat Elektronik Bertegangan Ganda: Dalam beberapa aplikasi IoT, seperti panel kontrol di bangunan pintar atau pusat data, Relay DPDT dapat mengelola dua rangkaian listrik yang berbeda pada satu waktu. Hal ini memungkinkan penggunaan perangkat dengan tegangan berbeda dalam satu sistem, yang dikendalikan secara otomatis melalui sinyal dari Arduino.\r\n\r\nKeunggulan Relay DPDT dibandingkan Relay SPDT adalah kemampuannya untuk mengalihkan dua rangkaian listrik sekaligus, sehingga cocok untuk aplikasi yang memerlukan pengaturan lebih kompleks atau pengendalian ganda. Penggunaannya dalam sistem IoT memungkinkan pengalihan arus yang lebih fleksibel dan otomatisasi yang lebih komprehensif, memperluas opsi kendali dan efisiensi di berbagai lingkungan, baik industri maupun rumah pintar.\r\n\r\nPrinsip kerja dari relay ini yaitu: pada AB terdapat kumparan sebagai driver. ketika AB belum dilewati arus, maka terminal CE dan FG akan tersambung, dan ketika AB dilewati arus maka plat C dan F akan berpindah sehingga terminal CD dan FH akan tersambung. jadi ketika driver AB dilewati arus plat yang berpindah ada 2 yaitu C dan F.', 'sequential', 'topik5', 'sequential-image', '/storage/files/sequential/relaydpdt.jpg', '2025-04-19 06:34:47', NULL),
(209, 1, 'Solid State Relay', 'Model lain dari modul relay adalah Solid State Relay. Dibuat dengan komponen semikonduktor (optocoupler) yang berfungsi layaknya seperti relai tanpa melibatkan komponen mekanik\r\n(+) Lebih awet (-) Mahal\r\n\r\nDalam konteks IoT, Solid State Relay sering digunakan pada proyek otomatisasi yang memerlukan pengendalian perangkat bertegangan tinggi dari sinyal rendah yang dihasilkan oleh mikrokontroler seperti Arduino. Berikut adalah beberapa contoh penggunaan SSR dalam sistem IoT:\r\n\r\n1. Otomatisasi Rumah Pintar: SSR dapat digunakan untuk mengendalikan perangkat listrik seperti lampu, pemanas, dan AC. Dengan menghubungkannya ke Arduino yang terhubung ke jaringan IoT, pengguna dapat mengontrol perangkat tersebut dari aplikasi jarak jauh, misalnya melalui smartphone. Dengan SSR, saklar dapat diaktifkan dengan cepat dan tanpa suara, sehingga ideal untuk perangkat yang sering diaktifkan dan dimatikan.\r\n\r\n2. Pengendalian Suhu di Industri atau Rumah Pintar: SSR sering digunakan dalam aplikasi yang memerlukan pengaturan suhu, seperti pemanas di rumah atau oven industri. Dengan sensor suhu terintegrasi di sistem IoT, Arduino dapat mengirimkan sinyal ke SSR untuk mengaktifkan atau menonaktifkan pemanas berdasarkan suhu lingkungan, menciptakan sistem pemanas otomatis yang presisi dan efisien.\r\n\r\n3. Kontrol Peralatan Daya Tinggi: Karena SSR dapat menangani arus yang lebih besar dan tahan terhadap frekuensi switching yang tinggi, SSR sering digunakan dalam aplikasi IoT industri untuk mengontrol mesin atau motor besar. Arduino dapat mengirimkan sinyal ke SSR untuk mengontrol peralatan berat dari jarak jauh, meningkatkan keselamatan dan meminimalkan kontak fisik dengan perangkat daya tinggi.\r\n\r\n4. Sistem Pencahayaan Otomatis: Dalam aplikasi pencahayaan otomatis, SSR memungkinkan pengendalian pencahayaan bertegangan tinggi di gedung perkantoran atau ruang publik. Dengan integrasi sensor cahaya dalam sistem IoT, SSR yang dikendalikan Arduino dapat menyalakan atau mematikan lampu secara otomatis sesuai intensitas cahaya alami di lingkungan tersebut, meningkatkan efisiensi energi.\r\n\r\n5. Kendali Beban Listrik dalam Lingkungan yang Sensitif: SSR sangat cocok digunakan di lingkungan sensitif seperti laboratorium atau ruang server, di mana gangguan listrik sekecil apapun harus dihindari. SSR memungkinkan pengalihan arus listrik dengan sangat halus tanpa lonjakan atau percikan yang dapat merusak peralatan sensitif.\r\n\r\nKeunggulan SSR dalam aplikasi IoT adalah kemampuannya untuk bekerja secara cepat, tanpa suara, dan tanpa keausan mekanis, membuatnya cocok untuk pengendalian yang membutuhkan switching tinggi dan akurasi. Dengan menghubungkannya ke Arduino dan jaringan IoT, SSR memungkinkan kontrol perangkat yang lebih aman, efisien, dan otomatis, memperluas kemampuan sistem dalam mengelola perangkat bertegangan tinggi secara fleksibel dan berkelanjutan.', 'sequential', 'topik5', 'sequential-image', '/storage/files/sequential/ssr.png', '2025-04-19 06:35:47', NULL),
(210, 1, 'IoT Communication Network\r\n', 'Perangkat keras seperti modul komunikasi berperan sebagai penghubung utama dalam jaringan ini. Modul tersebut memungkinkan perangkat IoT mengirim, menerima, dan memproses data secara efisien. Data yang diterima dari sensor diolah untuk menghasilkan tindakan melalui actuator, membentuk rantai komunikasi yang terintegrasi.\r\n\r\nAda berbagai jenis jaringan komunikasi yang digunakan dalam IoT, masing-masing dirancang untuk memenuhi kebutuhan tertentu, antara lain:', 'sequential', 'topik6', 'sequential-image', '/storage/files/sequential/iot.png', '2025-04-19 06:40:25', NULL),
(211, 1, 'Wifi', '- Memungkinkan perangkat IoT terhubung langsung ke internet melalui jaringan nirkabel.\r\n- Contoh perangkat: ESP-12/8266, ESP32, ESP01.', 'sequential', 'topik6', 'sequential-image', '/storage/files/sequential/wifi.jpg', '2025-04-19 06:41:52', NULL),
(212, 1, 'Bluetooth\r\n', '- Cocok untuk komunikasi jarak dekat, termasuk varian Bluetooth Low Energy (BLE) yang hemat daya.\r\n- Contoh perangkat: HC-05, HC-06, ESP32.', 'sequential', 'topik6', 'sequential-image', '/storage/files/sequential/bluetooth.png', '2025-04-19 06:42:29', NULL),
(213, 1, 'Cellular', '- Menggunakan jaringan seluler seperti 2G, 4G LTE, atau 5G untuk komunikasi jarak jauh, tanpa bergantung pada Wi-Fi.\r\n- Contoh perangkat: SIM800, SIM900.', 'sequential', 'topik6', 'sequential-image', '/storage/files/sequential/cellular.png', '2025-04-19 06:43:21', NULL),
(214, 1, 'Komunikasi Serial Arduino Uno R3 Built In IoT Wifi ESP8266', '', 'sequential', 'topik6', 'sequential-video', 'https://www.youtube.com/embed/DzECItyOR4M', '2025-04-19 06:44:34', NULL),
(215, 1, 'Microcontroller Unit (MCU) System on Chip (SoC)PageAssignment', 'Microcontroller Unit (MCU) dengan teknologi System on Chip (SoC) telah menjadi fondasi utama dalam pengembangan perangkat elektronik modern, termasuk sistem berbasis IoT. SoC adalah sebuah solusi terintegrasi yang menggabungkan berbagai fungsi penting ke dalam satu chip tunggal, memungkinkan perangkat untuk menjadi lebih ringkas, efisien, dan hemat biaya.\r\n\r\nSalah satu keunggulan utama MCU dengan SoC adalah kemampuannya untuk mengelola berbagai komponen seperti Wi-Fi, Bluetooth, atau komunikasi lainnya secara internal tanpa memerlukan modul tambahan. Misalnya, perangkat seperti ESP8266 dan ESP32 mengintegrasikan prosesor, memori, GPIO (General Purpose Input/Output), dan modul komunikasi nirkabel, memungkinkan komunikasi dengan jaringan lokal atau internet.\r\n\r\nSelain itu, firmware, yaitu perangkat lunak terkompilasi dari program atau sketch yang ditulis oleh pengembang, disimpan dalam memori non-volatile (seperti flash memory) di dalam SoC. Firmware ini berperan sebagai pengendali utama yang mengatur bagaimana perangkat membaca data dari sensor, memproses informasi, dan mengontrol aktuator, sekaligus memastikan perangkat dapat berjalan secara otonom setelah diunggah dan diprogram.\r\n\r\nTeknologi MCU SoC ini telah mendorong kemajuan pesat dalam aplikasi IoT, robotika, dan sistem otomatisasi lainnya, memungkinkan pengembangan sistem yang lebih kompleks dalam bentuk yang lebih sederhana dan terjangkau.', 'sequential', 'topik6', 'sequential-image', '', '2025-04-19 06:44:59', NULL),
(216, 1, 'SoC ESP8266 VS SoC ESP32Page', 'System on Chip (SoC) telah menjadi inti dari pengembangan perangkat IoT, memungkinkan pengintegrasian komponen seperti prosesor, modul komunikasi, dan periferal dalam satu chip. Dua SoC populer yang dirancang oleh Espressif Systems adalah ESP8266 dan ESP32, yang keduanya sering digunakan dalam berbagai proyek IoT. Meskipun keduanya dikembangkan oleh produsen yang sama, mereka memiliki perbedaan signifikan dalam hal fitur, performa, dan aplikasi.', 'sequential', 'topik6', 'sequential-image', '', '2025-04-19 06:45:14', NULL),
(217, 1, 'Pemahaman Dasar: Apa itu Platform IoT?', 'Platform IoT adalah layanan berbasis cloud yang memungkinkan pengguna:\r\n\r\n- Menghubungkan perangkat IoT\r\n\r\n- Mengelola data sensor\r\n\r\n- Menyimpan dan memvisualisasikan data\r\n\r\nContoh platform populer: ThingSpeak, Blynk, Adafruit IO, Google Cloud IoT Core', 'sequential', 'topik7', 'sequential-image', '', '2025-04-19 06:49:25', NULL),
(218, 1, 'Perbandingan Platform IoT', '', 'sequential', 'topik7', 'sequential-image', '/storage/files/sequential/platform_iot.jpg', '2025-04-19 06:50:50', NULL),
(219, 1, 'Blynk', 'Blynk adalah platform pengembangan untuk Internet of Things (IoT) yang memungkinkan pengguna untuk membuat aplikasi mobile untuk mengendalikan perangkat keras seperti mikrokontroler (misalnya Arduino, ESP8266, ESP32, Raspberry Pi, dll.) dengan cara yang sangat sederhana dan cepat. Blynk menyediakan antarmuka pengguna (UI) berbasis aplikasi smartphone yang memungkinkan kontrol dan pemantauan perangkat IoT dari jarak jauh.\r\n\r\nFitur Utama Blynk:\r\n1. Antarmuka Pengguna (UI) yang Mudah:\r\n\r\nBlynk menyediakan antarmuka yang dapat dikustomisasi, di mana Anda dapat menambahkan berbagai widget (seperti tombol, slider, indikator, grafik, dll.) untuk mengendalikan dan memantau perangkat IoT Anda melalui aplikasi mobile. Aplikasi Blynk tersedia untuk Android dan iOS, memudahkan pengguna untuk mengaksesnya dari berbagai perangkat.\r\n\r\n2. Protokol Komunikasi:\r\n\r\n- Blynk menggunakan protokol komunikasi Blynk Cloud atau Blynk Local Server untuk memungkinkan komunikasi antara aplikasi mobile dan perangkat keras. Blynk mendukung berbagai konektivitas jaringan seperti WiFi, Ethernet, Bluetooth, dan 4G/3G, memungkinkan perangkat IoT untuk terhubung ke internet dengan cara yang fleksibel.\r\n\r\n3. Mendukung Banyak Platform Perangkat Keras:\r\n\r\n- Blynk mendukung berbagai jenis papan pengembangan, seperti Arduino, ESP8266, ESP32, Raspberry Pi, dan lain-lain, sehingga sangat cocok untuk prototyping dan proyek IoT. Dengan Blynk Library, pengguna dapat dengan mudah menghubungkan papan mikrokontroler ke aplikasi mobile dan mulai mengendalikan perangkat.\r\n\r\n4. Fitur Keamanan:\r\n\r\nUntuk komunikasi yang aman antara aplikasi dan perangkat, Blynk menyediakan token otentikasi yang unik untuk setiap perangkat yang Anda buat di platform Blynk.\r\n\r\n5. Kemudahan Penggunaan:\r\n\r\nPlatform Blynk sangat populer karena kemudahan pengaturannya, bahkan untuk pemula. Pengguna tidak perlu menulis kode untuk antarmuka pengguna atau aplikasi mobile, cukup dengan drag-and-drop widget dan menghubungkannya dengan perangkat keras.\r\n\r\nKelebihan Blynk:\r\n\r\n1. User-friendly: Antarmuka grafis yang intuitif, memudahkan pembuatan aplikasi IoT tanpa memerlukan pengalaman pengembangan aplikasi mobile.\r\n\r\n2. Fleksibilitas: Mendukung berbagai jenis perangkat keras dan koneksi jaringan, sehingga dapat digunakan di berbagai proyek IoT.\r\n\r\n3. Cepat untuk Prototyping: Mempercepat proses pengembangan dan eksperimen proyek IoT.\r\n\r\n4. Komunitas Besar: Ada banyak tutorial, forum, dan sumber daya dari komunitas pengguna Blynk yang dapat membantu dalam pengembangan.\r\n\r\nKekurangan Blynk:\r\n\r\n1. Bergantung pada Blynk Cloud (untuk penggunaan gratis): Untuk penggunaan gratis, Anda harus terhubung dengan Blynk Cloud. Jika Anda ingin menggunakan server lokal atau membutuhkan lebih banyak fungsionalitas, Anda harus membayar langganan premium.\r\n\r\n2. Keterbatasan dalam Pengembangan Aplikasi Kustom: Meski aplikasi Blynk mudah digunakan, jika Anda memerlukan fungsionalitas yang lebih spesifik atau kustomisasi aplikasi lebih lanjut, Anda mungkin membutuhkan keahlian lebih lanjut dalam pengembangan aplikasi mobile.\r\n\r\n\r\nCara Kerja Blynk:\r\n1. Buat Proyek di Aplikasi Blynk:\r\n\r\nAnda mulai dengan membuat proyek baru di aplikasi Blynk dan memilih jenis perangkat keras yang akan digunakan (misalnya ESP8266 atau Arduino). Setelah itu, Anda akan mendapatkan Blynk Token yang digunakan untuk menghubungkan aplikasi dengan perangkat keras.\r\n\r\n2. Program Perangkat Keras:\r\n\r\nAnda mengupload program ke papan mikrokontroler Anda menggunakan Blynk library dan memasukkan token yang diterima sebelumnya. Token ini memungkinkan perangkat untuk terhubung ke Blynk Cloud atau server lokal. Dalam program, Anda akan menentukan bagaimana perangkat berkomunikasi dengan aplikasi (misalnya, membaca sensor, menghidupkan atau mematikan LED, dll.).\r\n\r\n3. Kendalikan Perangkat dari Aplikasi Blynk:\r\n\r\nSetelah perangkat terhubung ke Blynk, Anda dapat mengendalikan perangkat dan memantau data dari perangkat secara real-time langsung dari aplikasi Blynk di smartphone Anda. Misalnya, Anda bisa menyalakan/mematikan lampu, membaca data sensor suhu, atau memantau status perangkat lainnya.', 'sequential', 'topik7', 'sequential-image', '', '2025-04-19 06:51:37', NULL),
(220, 1, 'Thingspeak', 'ThingSpeak adalah platform berbasis cloud untuk Internet of Things (IoT) yang memungkinkan pengumpulan, analisis, dan visualisasi data dari perangkat IoT secara real-time. ThingSpeak memungkinkan perangkat untuk mengirimkan data ke cloud, yang kemudian dapat dipantau dan dianalisis melalui antarmuka berbasis web.\r\n\r\nPlatform ini sangat populer di kalangan pengembang IoT dan peneliti karena kemudahan penggunaannya dan kemampuannya untuk menangani data dari berbagai sensor serta integrasi dengan alat analitik lainnya.\r\n\r\nFitur Utama ThingSpeak:\r\n1. Pengumpulan Data dari Perangkat IoT:\r\n\r\nThingSpeak memungkinkan perangkat seperti Arduino, ESP8266, Raspberry Pi, atau perangkat lainnya untuk mengirimkan data ke cloud. Data ini bisa berasal dari berbagai sensor, seperti sensor suhu, kelembaban, kualitas udara, tekanan, dan banyak lagi. Perangkat mengirimkan data ke ThingSpeak melalui HTTP atau MQTT (protokol komunikasi ringan untuk IoT).\r\nVisualisasi Data:\r\n\r\n2. ThingSpeak menyediakan fitur untuk menampilkan data dalam bentuk grafik dan diagram secara real-time. Visualisasi ini memungkinkan pengguna untuk memantau dan menganalisis data yang terkumpul dengan mudah. Misalnya, Anda bisa melihat grafik suhu, kelembaban, atau data sensor lainnya yang diperbarui secara langsung.\r\n\r\n3. Pengolahan dan Analisis Data:\r\n\r\nThingSpeak mendukung analisis data dengan integrasi MATLAB. Anda dapat melakukan analisis lanjutan pada data yang terkumpul menggunakan MATLAB, yang memberikan kemampuan analitik yang kuat untuk mengolah data.\r\nDengan MATLAB, Anda bisa mengembangkan model matematis, analisis statistik, atau algoritma pemrosesan data untuk mendapatkan wawasan lebih dalam dari data yang dikumpulkan.\r\n\r\n4. Pemrograman dan Otomatisasi:\r\n\r\nThingSpeak memungkinkan Anda untuk membuat aplikasi otomatisasi IoT. Misalnya, Anda dapat menulis script untuk mengambil tindakan tertentu berdasarkan data yang diterima, seperti mengirimkan notifikasi atau mengubah status perangkat tertentu (misalnya menyalakan kipas jika suhu mencapai nilai tertentu).\r\nThingSpeak memiliki fitur untuk triggering dan webhooks yang memungkinkan Anda untuk berinteraksi dengan perangkat lainnya atau platform lain.\r\n\r\n5. Integrasi dengan Layanan Lain:\r\n\r\nThingSpeak mendukung integrasi dengan berbagai layanan dan aplikasi lain, seperti IFTTT (If This Then That), yang memungkinkan Anda untuk menghubungkan ThingSpeak dengan layanan lain untuk melakukan tindakan otomatis berdasarkan kondisi tertentu.\r\nPlatform ini juga mendukung RESTful API yang memungkinkan perangkat eksternal atau aplikasi lain untuk berinteraksi dengan data di ThingSpeak.\r\n\r\nCara Kerja ThingSpeak:\r\n1. Buat Channel di ThingSpeak:\r\n\r\nPertama, pengguna membuat channel di ThingSpeak. Channel adalah tempat untuk menyimpan data dari perangkat atau sensor.\r\nSetiap channel dapat memiliki hingga 8 saluran data (misalnya, suhu, kelembaban, cahaya, dll.), yang dapat dikumpulkan dari berbagai perangkat.\r\n\r\n2. Kirim Data ke ThingSpeak:\r\n\r\nPerangkat IoT, seperti Arduino atau ESP8266, mengirimkan data ke channel ThingSpeak menggunakan HTTP requests. ThingSpeak menyediakan API untuk mengirimkan data ke channel yang sudah dibuat.\r\nMisalnya, sebuah perangkat dapat mengirimkan nilai suhu setiap menit ke ThingSpeak.\r\n\r\n3. Visualisasi dan Analisis Data:\r\n\r\nData yang dikirimkan ke ThingSpeak dapat divisualisasikan dalam bentuk grafik di dashboard ThingSpeak.\r\nAnda juga dapat melakukan analisis lanjutan menggunakan MATLAB yang disediakan oleh ThingSpeak untuk menggali lebih dalam data yang terkumpul.\r\n\r\n4. Mengambil Tindakan Berdasarkan Data:\r\n\r\nBerdasarkan data yang dikumpulkan, Anda dapat mengonfigurasi ThingSpeak untuk melakukan tindakan otomatis, seperti mengirimkan peringatan melalui email atau SMS jika data mencapai ambang tertentu.\r\nThingSpeak juga mendukung pengaturan webhook untuk menghubungkan ke aplikasi lain (misalnya, mengirimkan data ke platform lain seperti Google Sheets, atau trigger sistem lain).\r\n\r\nKelebihan ThingSpeak:\r\n\r\n1. Mudah Digunakan: Antarmuka berbasis web yang mudah digunakan memungkinkan pengguna untuk cepat memulai tanpa memerlukan banyak pengetahuan teknis.\r\n\r\n2. Integrasi MATLAB: Analisis data yang lebih canggih dan pengolahan data dengan MATLAB memungkinkan pengembang untuk menjalankan model statistik atau algoritma pembelajaran mesin pada data IoT mereka.\r\n\r\n3. Cloud-based: ThingSpeak adalah platform cloud, sehingga memungkinkan akses data dan visualisasi dari mana saja tanpa perlu mengelola server secara lokal.\r\n\r\n4. Gratis untuk Penggunaan Dasar: ThingSpeak menawarkan penggunaan gratis dengan batasan tertentu, yang cocok untuk banyak proyek IoT sederhana dan eksperimental.\r\n\r\nKekurangan ThingSpeak:\r\n\r\n1. Batasan pada Akun Gratis: Pengguna gratis memiliki keterbatasan dalam hal jumlah data yang dapat dikirimkan, kecepatan pembaruan data, dan jumlah saluran yang tersedia.\r\n\r\n2. Keterbatasan Fitur Analitik: Meskipun MATLAB integrasi menawarkan banyak kemungkinan analisis, penggunanya mungkin membutuhkan keterampilan analitik yang lebih tinggi untuk memanfaatkannya sepenuhnya.\r\n\r\n3. Keamanan dan Privasi: Karena ThingSpeak adalah platform cloud, ada kemungkinan risiko terkait dengan privasi dan keamanan data yang dikirimkan melalui internet.\r\n\r\nPenggunaan Umum ThingSpeak:\r\n\r\n1. Pemantauan Lingkungan: Menggunakan sensor untuk memantau kualitas udara, suhu, kelembaban, atau parameter lingkungan lainnya.\r\n\r\n2. Proyek Smart Home: Mengendalikan perangkat rumah pintar atau memantau parameter seperti suhu dan kelembaban untuk otomatisasi rumah.\r\n\r\n3. Pemantauan Kesehatan: Menggunakan sensor untuk memantau tanda-tanda vital atau kondisi medis tertentu, dan mengirimkan data ke ThingSpeak untuk analisis lebih lanjut.\r\n\r\n4. Proyek Riset: Banyak digunakan dalam proyek penelitian untuk mengumpulkan data dari eksperimen lapangan atau perangkat sensor.\r\n\r\nSecara keseluruhan, ThingSpeak adalah platform yang sangat berguna bagi pengembang IoT, peneliti, dan hobiis yang ingin mengumpulkan dan menganalisis data sensor secara efisien, dengan kemampuan untuk memvisualisasikan data dalam bentuk yang mudah dipahami dan melakukan analisis yang lebih lanjut menggunakan MATLAB.', 'sequential', 'topik7', 'sequential-image', '/storage/files/sequential/thingspeak.jpeg', '2025-04-19 06:52:32', NULL),
(221, 1, 'Alur Koneksi Perangkat ke Platform IoT', 'Diagram Alur:', 'sequential', 'topik7', 'sequential-image', '/storage/files/sequential/alur_koneksi.png', '2025-04-19 06:56:59', NULL),
(222, 1, 'Pemrograman Arduino Dasar', 'Ini adalah modul untuk Pemrograman Arduino Dasar.', 'global', 'topik2', 'global-pdf', '/storage/files/global/Pemrograman Arduino Dasar.pdf', '2025-04-19 09:13:21', NULL),
(223, 1, 'arduino.cc', 'Ini adalah halaman resmi dari Arduino.', 'global', 'topik2', 'global-link', 'https://www.arduino.cc/', '2025-04-19 09:14:02', NULL),
(224, 1, 'tinkercad.com', 'Ini adalah halaman resmi dari Tinkercad.', 'global', 'topik2', 'global-link', 'https://www.tinkercad.com/', '2025-04-19 09:14:29', NULL),
(225, 1, 'Overview Terpadu', '\"Dalam sistem IoT, pengumpulan data dari lingkungan sekitar sangat bergantung pada sensor. Sensor cahaya membantu mengukur intensitas pencahayaan, sensor suhu dan kelembaban memberikan data lingkungan yang krusial, dan sensor deteksi objek berguna untuk mengenali keberadaan manusia atau benda. Semua data ini akan dikumpulkan, dianalisis, dan digunakan untuk mengambil keputusan secara otomatis.\"', 'global', 'topik3', 'global-image', '', '2025-04-19 09:31:22', NULL),
(226, 1, 'Studi Kasus: Monitoring Ruangan Pintar', '“Bayangkan kamu membangun sistem pintar untuk memantau kondisi ruangan kantor. Sistem ini perlu mendeteksi apakah lampu perlu dinyalakan (berdasarkan cahaya), apakah suhu nyaman (berdasarkan suhu & kelembaban), dan apakah ada orang di ruangan (berdasarkan sensor deteksi objek).”\r\n\r\nDalam studi kasus ini, ketiga sensor akan bekerja sama dan memberikan informasi penting ke dashboard pemantauan di platform IoT.”\r\n\r\n', 'global', 'topik3', 'global-image', '', '2025-04-19 09:33:23', NULL),
(227, 1, 'LED RGB\r\n\r\n', 'LED RGB adalah sebuah LED yang dapat mengeluarkan perpaduan warna red(merah), green(hijau), dan blue(biru). LED ini seperti LED biasa memiliki anoda dan katoda hanya saja terdapat 3 anoda pada LED ini mewakili warna red, green, dan blue. Tegangan yang dikeluarkan pada anoda-anoda inilah yang akan mempengaruhi warna nyala dari LED RGB. LED rgb termasuk ke dalam integrated output dan dapat digunakan dengan mengendalikan LED red, green, blue, dan pin com yang dihubungkan ke gnd Arduino. Terdapat 2 jenis LED RGB yaitu yang berbentuk super flux (surface mount device) dan standart (bentuknya sama dengan LED biasa dengan jumlah kaki 4)\r\n\r\n', 'global', 'topik4', 'global-image', '', '2025-04-19 09:39:48', NULL),
(228, 1, 'Seven Segment\r\n\r\n', 'Seven segment sesungguhnya adalah LED yang disusun (segment) sehingga dapat digunakan untuk menampilkan angka desimal. Angka digital menjadi sangat penting untuk menampilkan informasi sebagai bagian panel display seperti pada jam digital, counter, kalkulator dan masih banyak lagi. Seven Segment memiliki 7 segment atau bagian yang bisa dikenalikan ON dan OFF. Susunan segment yang ON sedemikian rupa dapat merepresentasikan angka digital bahkan beberapa huruf. Jika semua segment dalam kondisi ON maka akan terbentuk angka 8. Angka lain yang dapat dihasilkan 0 - 9 dan huruf yang dapat dihasilkan A - F. Beberapa pengembangan seven segment adalah adanya penambahan . (titik) , (koma) dan : (titik dua). Terdapat 2 Jenis LED 7 Segment : Common Cathode -> ke negatif Common Anode -> ke positif', 'global', 'topik4', 'global-image', '', '2025-04-19 09:40:10', NULL),
(229, 1, 'Buzzer', 'Merupakan alat keluaran (output) yang mengubah sinyal listrik menjadi getaran suara, disebut juga dengan beeper atau piezoelectric. Karena memili ciri khas menghasilkan suara atau bunyi-bunyian maka buzzer dapat digunakan sebagai indikator suatu keadaan atau kondisi situasi tertentu. Buzzer dapat ditrigger untuk berbunyi dengan adanya tegangan kerja 3 volt hingga 12 volt. Yang dapat digunakan oleh Arduino yang tegangan dibawah 5 volt.\r\n', 'global', 'topik4', 'global-image', '', '2025-04-19 09:40:24', NULL),
(230, 1, 'Servo', 'Motor servo adalah motor dengan torsi besar dan dengan sudut yang bisa diatur. Motor ini hampir sama dengan motor stepper hanya saja motor servo memiliki gerak terbatas. Motor stepper dapat berputar 360o sedangkan motor servo hanya dapat berputar 180o atau 90o saja. Motor servo lebih mudah untuk dikontrol sudutnya karena menggunakan basis PWM.\r\n\r\n', 'global', 'topik4', 'global-image', '', '2025-04-19 09:40:38', NULL),
(231, 1, 'Using Ultrasonic Distance Sensor HC-SR04 with Buzzer, LED and Arduino', '', 'global', 'topik4', 'global-video', 'https://www.youtube.com/embed/HynLoCtUVtU', '2025-04-19 09:43:06', NULL),
(232, 1, 'Overview Terintegrasi', '\"Support dalam IoT tidak hanya soal perbaikan perangkat, tetapi juga mencakup pemantauan, pembaruan firmware, dokumentasi sistem, serta dukungan troubleshooting untuk user dan teknisi. Ini penting agar sistem IoT dapat terus berjalan optimal, terutama pada skala besar seperti smart city atau pertanian pintar.\"', 'global', 'topik5', 'global-image', '', '2025-04-19 11:50:52', NULL),
(233, 1, 'Infografis: Cara Kerja Relay dan Keypad', 'Secara garis besar terdapat dua jenis relay, yaitu\r\n\r\n1. Relay elektromekanis : Relay yang menggunakan prinsip elektromagnetik untuk menggerakkan kontak saklar. Pada bagian pertama tulisan ini, akan memfokuskan kepada jenis relay satu ini\r\n\r\n2. Relay Solid State : Relay yang menggunakan teknologi semikonduktor (optocoupler) untuk melakukan switch ON dan OFF. Pembahasan tentang RSS akan diulas di bagian ke 2.\r\no)', 'global', 'topik5', 'global-image', '/storage/files/global/relay.gif', '2025-04-19 11:53:03', NULL),
(234, 1, '', 'Jika pin IN dihubungkan dengan PIN13 dan jumper relay dikonfigurasi high trigger maka nyala Led built-in akan sama dengan indikator pada relay, sebagaimana eksperimen yang dinarasikan pada video berikut', 'global', 'topik5', 'global-video', 'https://www.youtube.com/embed/fSV8fAqtehk', '2025-04-19 11:54:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_folder`
--

CREATE TABLE `mdl_folder` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `learning_style` enum('active','reflective','sensing','intuitive','visual','verbal','sequential','global') NOT NULL,
  `topik` enum('topik1','topik2','topik3','topik4','topik5','topik6','topik7') NOT NULL,
  `type` enum('active-folder','reflective-folder','sensing-folder','intuitive-folder','visual-folder','verbal-folder','sequential-folder','global-folder') NOT NULL,
  `folder_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_folder`
--

INSERT INTO `mdl_folder` (`id`, `course_id`, `name`, `description`, `learning_style`, `topik`, `type`, `folder_path`, `file_name`, `created_at`) VALUES
(1, 1, 'Bab 1', '', 'sequential', 'topik1', 'sequential-folder', '/storage/files/sequential/Pengantar dan Penerapan Internet of Things Bab 1.pdf', 'Bab 1 - PENGANTAR DAN SEJARAH PERKEMBANGAN INTERNET OF THINGS', '2025-04-09 12:30:14'),
(2, 1, 'Bab 2', '', 'sequential', 'topik1', 'sequential-folder', '/storage/files/sequential/Pengantar dan Penerapan Internet of Things Bab 2.pdf', 'Bab 2 - KONSEP DAN ARSITEKTUR INTERNET OF THINGS', '2025-04-09 12:30:14'),
(3, 1, 'Bab 3', '', 'sequential', 'topik1', 'sequential-folder', '/storage/files/sequential/Pengantar dan Penerapan Internet of Things Bab 3.pdf', 'Bab 3 - APLIKASI-APLIKASI INTERNET OF THINGS', '2025-04-09 12:30:14'),
(4, 1, 'Bab 4', '', 'sequential', 'topik1', 'sequential-folder', '/storage/files/sequential/Pengantar dan Penerapan Internet of Things Bab 4.pdf', 'Bab 4 - FRAMEWORK PEMROGRAMAN UNTUK INTERNET OF THINGS', '2025-04-09 12:30:14'),
(5, 1, 'Bab 5', '', 'sequential', 'topik1', 'sequential-folder', '/storage/files/sequential/Pengantar dan Penerapan Internet of Things Bab 5.pdf', 'Bab 5 - PENERAPAN IoT PADA SEKTOR PERHOTELAN', '2025-04-09 12:30:14'),
(6, 1, 'Bab 6', '', 'active', 'topik1', 'active-folder', '/storage/files/sequential/Pengantar dan Penerapan Internet of Things Bab 6.pdf', 'Bab 6 - PENERAPAN IoT PADA SEKTOR COMPUTING', '2025-04-09 12:30:14'),
(7, 1, 'Bab 7', '', 'sequential', 'topik1', 'sequential-folder', '/storage/files/sequential/Pengantar dan Penerapan Internet of Things Bab 7.pdf', 'Bab 7 - PENERAPAN IoT PADA SEKTOR PERTANIAN', '2025-04-09 12:30:14'),
(8, 1, 'Bab 8', '', 'sequential', 'topik1', 'sequential-folder', '/storage/files/sequential/Pengantar dan Penerapan Internet of Things Bab 8.pdf', 'Bab 8 - PENERAPAN IoT PADA SEKTOR PENDIDIKAN', '2025-04-09 12:30:14'),
(10, 1, 'Library DHT\r\n', 'Untuk menggunakan modul sensor DHT maka harus menggunakan library berikut ini:', 'sequential', 'topik3', 'sequential-folder', '/storage/files/sequential/Arduino-Temperature-Control-Library-master.zip', 'Library DHT', '2025-04-19 05:38:20'),
(11, 1, 'OneWire-master', '', 'sequential', 'topik3', 'sequential-folder', '/storage/files/sequential/OneWire-master.zip', 'OneWire-master', '2025-04-19 05:41:25');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum`
--

CREATE TABLE `mdl_forum` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `section_id` bigint(10) NOT NULL,
  `learning_style` enum('active','reflective','sensing','intuitive','visual','verbal','sequential','global') NOT NULL,
  `topik` enum('topik1','topik2','topik3','topik4','topik5','topik6','topik7') NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_forum`
--

INSERT INTO `mdl_forum` (`id`, `course_id`, `section_id`, `learning_style`, `topik`, `name`, `description`, `created_at`) VALUES
(1, 1, 1, 'active', 'topik1', 'Diskusi Pengenalan IoT', 'Forum ini digunakan untuk berdiskusi tentang konsep dasar IoT.\r\n', '2025-04-05 05:40:44'),
(2, 1, 1, 'global', 'topik1', 'Diskusi Forum', 'Menurutmu, bagaimana IoT bisa mengubah cara kita bekerja atau belajar dalam 10 tahun ke depan?\r\n', '2025-04-13 14:10:01'),
(3, 1, 2, 'active', 'topik2', 'Pemrograman dan I/O Arduino', 'Forum ini digunakan untuk berdiskusi tentang Pemrograman dan I/O Arduino.', '2025-04-14 13:06:46'),
(4, 1, 3, 'active', 'topik3', 'Sensor Cahaya (LDR - Light Dependent Resistor)', 'Menurut kalian, bagaimana cara menerapkan sensor cahaya untuk sistem hemat energi di rumah pintar?', '2025-04-15 12:05:20'),
(5, 1, 3, 'active', 'topik3', 'Sensor Suhu & Kelembaban (DHT11 / DHT22)', 'Diskusikan ide kalian untuk menggunakan sensor DHT11 dalam sistem peringatan dini kebakaran.', '2025-04-15 12:22:07'),
(6, 1, 3, 'active', 'topik3', 'Sensor Deteksi Objek (Ultrasonik HC-SR04)', 'Apakah kamu mengalami error saat membaca jarak dari sensor ultrasonik? Share pengalamanmu dan bantu temanmu!', '2025-04-15 12:22:24'),
(7, 1, 4, 'active', 'topik4', 'Aktuator Cahaya (LED dan RGB)', 'Bagaimana cara menggunakan LED RGB dalam sistem indikator untuk berbagai status perangkat IoT?', '2025-04-16 07:36:30'),
(8, 1, 4, 'active', 'topik4', 'Aktuator Bunyi (Buzzer)', 'Bagaimana cara mengontrol buzzer dengan sinyal digital pada mikrokontroler, dan bagaimana mengatur frekuensi suara untuk keperluan tertentu?', '2025-04-16 07:36:55'),
(9, 1, 4, 'active', 'topik4', 'Aktuator Motor (Motor DC dan Servo)', 'Apa perbedaan penggunaan motor servo dengan motor DC dalam aplikasi otomatisasi? Mana yang lebih efisien untuk aplikasi IoT?', '2025-04-16 07:37:12'),
(10, 1, 6, 'active', 'topik6', 'Forum Diskusi Kolaboratif', 'Jika kamu diminta membangun sistem IoT di lokasi terpencil, mana metode komunikasi yang paling cocok?\r\nCeritakan skenario aplikatifnya!', '2025-04-16 08:22:33'),
(11, 1, 5, 'active', 'topik5', 'Forum Diskusi', 'Menurut kalian, apa kelebihan penggunaan relay dibanding langsung mengaktifkan komponen dari Arduino?\r\nDan bagaimana keypad bisa meningkatkan keamanan dalam sistem IoT?', '2025-04-16 08:24:26'),
(12, 1, 7, 'active', 'topik7', 'Forum Diskusi Kolaboratif', 'Menurut kalian, apa pertimbangan dalam memilih platform IoT?\r\nApakah semua platform cocok untuk kebutuhan industri?', '2025-04-16 08:40:06'),
(13, 1, 2, 'reflective', 'topik2', 'Forum Diskusi Reflektif', 'Apakah kamu lebih suka bekerja dengan pin digital atau analog? Kenapa?\r\nSertakan contoh penerapannya di dunia nyata.', '2025-04-16 09:37:59'),
(14, 1, 1, 'reflective', 'topik1', 'Forum Diskusi Reflektif', 'Apakah semua bidang butuh IoT? Bagaimana menurutmu peran IoT dalam pendidikan, kesehatan, dan industri?', '2025-04-17 02:35:03'),
(15, 1, 3, 'reflective', 'topik3', 'Forum Diskusi', 'Jika kamu membuat proyek IoT sederhana, sensor apa yang akan kamu pilih dan mengapa?', '2025-04-17 04:15:11'),
(16, 1, 4, 'reflective', 'topik4', 'Forum Diskusi', 'Apakah penggunaan aktuator dalam sistem IoT hanya untuk kenyamanan, atau bisa menyelamatkan nyawa?', '2025-04-17 05:37:10'),
(17, 1, 5, 'reflective', 'topik5', 'Forum Diskusi', 'Jika kamu membuat sistem keamanan rumah berbasis Arduino, lebih pilih fingerprint, keypad, atau aplikasi smartphone? Kenapa?', '2025-04-17 05:48:56'),
(18, 1, 6, 'reflective', 'topik6', 'Diskusi', 'Jika kamu membuat sistem monitoring kualitas air sungai yang jauh dari kota, kamu akan pilih WiFi, Bluetooth, atau Cellular? Jelaskan alasan teknis dan ekonomisnya.', '2025-04-17 05:59:46'),
(19, 1, 7, 'reflective', 'topik7', 'Forum Diskusi', 'Mana yang lebih penting menurutmu: kemudahan penggunaan atau kemampuan kustomisasi dalam memilih platform IoT?', '2025-04-17 06:14:19'),
(20, 1, 1, 'sensing', 'topik1', 'Forum Diskusi', 'Menurutmu, perangkat apa yang sebaiknya ditambahkan fitur IoT, dan kenapa', '2025-04-17 06:39:07'),
(21, 1, 3, 'sensing', 'topik3', 'Forum Diskusi', 'Bagaimana sensor ini bisa dimanfaatkan di rumah kamu? Kasih contoh penggunaannya.', '2025-04-17 12:16:04'),
(22, 1, 4, 'sensing', 'topik4', 'Forum Diskusi', 'Apa aktuator yang menurutmu paling berguna di rumah? Jelaskan dengan kasus nyata', '2025-04-17 12:27:21'),
(23, 1, 5, 'sensing', 'topik5', 'Forum Diskusi', 'Jika kamu membuat smart lock rumah sederhana, bagaimana kamu menggabungkan relay dan keypad?', '2025-04-17 12:36:22'),
(24, 1, 6, 'sensing', 'topik6', 'Forum Diskusi', 'Apa langkah-langkah konkret untuk menghubungkan ESP32 ke server MQTT dan bagaimana memverifikasi koneksi berhasil?', '2025-04-17 12:46:04'),
(25, 1, 7, 'sensing', 'topik7', 'Forum Diskusi', 'Mana yang lebih penting menurutmu: kemudahan penggunaan atau kemampuan kustomisasi dalam memilih platform IoT?', '2025-04-17 13:48:46'),
(26, 1, 1, 'intuitive', 'topik1', 'Refleksi Inovatif', 'Jika semua benda di sekitarmu dapat \"berpikir\" dan \"berkomunikasi\", bagaimana cara pandang kita terhadap dunia berubah?\r\n\r\nDiskusikan bagaimana IoT dapat membentuk ulang pendidikan, transportasi, atau bahkan interaksi sosial.', '2025-04-18 04:31:09'),
(27, 1, 1, 'intuitive', 'topik1', 'Forum Diskusi', 'Bayangkan IoT 10 tahun ke depan: Apa tantangan etika atau sosial yang mungkin muncul saat benda-benda mulai membuat keputusan sendiri?', '2025-04-18 04:32:39'),
(28, 1, 2, 'intuitive', 'topik2', 'Intuisi Kode: Mengapa baris kode ini penting?', 'pinMode(13, OUTPUT);\r\n\r\ndigitalWrite(13, HIGH);\r\n\r\nBagaimana dua baris sederhana ini bisa membuat sebuah LED menyala dan membentuk komunikasi manusia-mesin?\r\n\r\nDiskusikan:\r\n\r\nApakah kode itu sekadar instruksi atau bentuk bahasa untuk memahami dunia?', '2025-04-18 04:38:58'),
(29, 1, 3, 'intuitive', 'topik3', 'Forum Reflektif', 'Jika kamu harus memberi sistem otomatis kemampuan merasakan, apa ‘indera’ yang akan kamu ciptakan dengan sensor-sensor ini?', '2025-04-18 04:53:43'),
(30, 1, 4, 'intuitive', 'topik4', 'Forum Diskusi', 'Bagaimana menurutmu, apakah kita bisa menciptakan emosi buatan lewat kombinasi cahaya, bunyi, dan gerakan?', '2025-04-18 04:59:40'),
(31, 1, 5, 'intuitive', 'topik5', 'Forum Diskusi', 'Bagaimana menurutmu jika keypad digantikan dengan input suara?\r\nApakah relay bisa mengontrol perangkat IoT yang berada di kota lain?', '2025-04-18 05:07:32'),
(32, 1, 6, 'intuitive', 'topik6', 'Eksplorasi Gagasan', 'Kamu ingin membuat alat pendeteksi banjir yang bisa kirim peringatan ke HP-mu.\r\nPilihlah jaringan komunikasi yang tepat dan jelaskan alasanmu.\r\n\r\n', '2025-04-18 05:11:58'),
(33, 1, 6, 'intuitive', 'topik6', 'Forum Diskusi Inovatif', 'Bisakah kita menggabungkan dua jenis komunikasi dalam satu proyek? Misalnya, data dari Bluetooth dikirim ke cloud lewat Wifi?”\r\nBagikan idemu!', '2025-04-18 05:12:48'),
(34, 1, 7, 'intuitive', 'topik7', 'Eksplorasi Ide Inovatif', 'Kamu ingin membuat sistem pemantauan suhu ruangan dengan notifikasi.\r\nJelaskan alur sistem dari sensor hingga pengguna menggunakan satu platform pilihanmu.\r\nJelaskan apa kelebihannya dan apa kekurangannya?', '2025-04-18 05:17:10'),
(35, 1, 7, 'intuitive', 'topik7', 'Forum Diskusi', 'Bisakah satu proyek IoT menggunakan dua platform secara bersamaan? Contohnya Firebase + Node-RED?”\r\nBagikan pemikiranmu di forum', '2025-04-18 05:18:10'),
(36, 1, 2, 'visual', 'topik2', 'Diskusi', 'Forum Diskusi Pemrograman dan I/O Arduino', '2025-04-18 06:18:25'),
(37, 1, 4, 'visual', 'topik4', 'Diskusi', 'Bagaimana kamu akan merancang sistem peringatan banjir sederhana menggunakan LED, buzzer, dan servo motor?', '2025-04-18 08:22:42'),
(38, 1, 5, 'visual', 'topik5', 'Diskusi', 'Menurut kamu, bagaimana sistem kunci pintu otomatis yang menggunakan keypad dan relay bisa diterapkan di kehidupan nyata?', '2025-04-18 08:37:54'),
(39, 1, 6, 'visual', 'topik6', 'Diskusi', '1. Jika kamu merancang proyek IoT pemantauan suhu ruangan dari jarak jauh, jenis jaringan komunikasi mana yang akan kamu pilih dan mengapa?\r\n\r\n2. Dalam hal efisiensi biaya dan kemudahan integrasi, mana yang lebih cocok untuk proyek berbasis komunitas: WiFi atau Cellular?', '2025-04-18 15:18:10'),
(40, 1, 7, 'visual', 'topik7', 'Diskusi', 'Menurutmu, apakah lebih baik menggunakan platform cloud yang gratis tapi terbatas, atau berbayar tapi lebih powerful?', '2025-04-18 15:35:55'),
(41, 1, 1, 'verbal', 'topik1', 'Forum Diskusi', 'Menurut kamu, apakah ada risiko dari penggunaan IoT dalam kehidupan sehari-hari? Bagaimana solusi terbaik untuk mengatasi risiko tersebut?', '2025-04-19 03:18:16'),
(42, 1, 2, 'verbal', 'topik2', 'Forum Diskusi', 'Apa perbedaan mendasar antara pin input digital dan pin input analog pada Arduino? Kapan sebaiknya kita menggunakan masing-masing jenis pin?', '2025-04-19 03:28:54'),
(43, 1, 3, 'verbal', 'topik3', 'Forum Diskusi\r\n', 'Menurut kamu, antara sensor PIR dan sensor ultrasonik, mana yang lebih efektif untuk digunakan pada sistem keamanan rumah? Jelaskan alasannya dari sisi prinsip kerja dan efektivitasnya.', '2025-04-19 03:45:03'),
(44, 1, 4, 'verbal', 'topik4', 'Forum Diskusi', 'Menurut kamu, mana aktuator yang paling penting dalam sistem peringatan bencana berbasis IoT? Apakah cahaya, bunyi, atau motor? Jelaskan alasan dan skenario penggunaannya.', '2025-04-19 03:57:30'),
(45, 1, 5, 'verbal', 'topik5', 'Forum Diskusi\r\n', 'Menurut kamu, apa tantangan terbesar saat mengintegrasikan keypad dan relay dalam sistem berbasis IoT? Lebih baik kontrol dilakukan secara lokal (Arduino) atau melalui cloud? Jelaskan alasanmu.', '2025-04-19 04:07:09'),
(46, 1, 6, 'verbal', 'topik6', 'Diskusi ', 'Jika kamu merancang sistem monitoring suhu di perkebunan yang lokasinya jauh dari kota, komunikasi apa yang kamu pilih: Wi-Fi, LoRa, atau GSM? Jelaskan alasanmu secara logis berdasarkan kelebihan dan keterbatasan tiap teknologi.', '2025-04-19 04:12:10'),
(47, 1, 7, 'verbal', 'topik7', 'Diskusi', 'Jika kamu harus memilih satu platform IoT untuk proyek monitoring suhu ruangan kelas berbasis Arduino, mana yang akan kamu pilih: Blynk, ThingSpeak, Adafruit IO, atau Google Cloud IoT? Jelaskan pilihanmu dari segi kemudahan penggunaan, biaya, dan fitur.', '2025-04-19 04:22:52'),
(48, 1, 1, 'sequential', 'topik1', 'Diskusi ', 'Dari semua lapisan arsitektur IoT, mana yang menurutmu paling krusial dalam menjaga keamanan data? Jelaskan alasanmu secara sistematis berdasarkan peran tiap layer.', '2025-04-19 04:51:31'),
(49, 1, 2, 'sequential', 'topik2', 'Diskusi ', 'Apa risiko jika urutan dalam penulisan program Arduino tidak sesuai? Bagaimana pengaruhnya terhadap output perangkat?', '2025-04-19 05:19:18'),
(50, 1, 3, 'sequential', 'topik3', 'Diskusi', 'Bagaimana pengaruh perubahan intensitas cahaya terhadap nilai LDR yang terbaca oleh Arduino? Apa dampaknya jika sensor tidak dikalibrasi dengan benar?', '2025-04-19 05:56:49'),
(51, 1, 4, 'sequential', 'topik4', 'Diskusi', 'Apa yang akan terjadi jika Anda menggunakan motor tanpa sumber daya eksternal? Bagaimana pengaruhnya terhadap Arduino?', '2025-04-19 06:27:23'),
(52, 1, 5, 'sequential', 'topik5', 'Diskusi', 'Mengapa kita memerlukan RTC saat membuat sistem IoT seperti smart greenhouse atau data logger?', '2025-04-19 06:36:14'),
(53, 1, 6, 'sequential', 'topik6', 'Diskusi', 'Jika kamu merancang sistem monitoring cuaca berbasis IoT, komunikasi seperti apa yang kamu pilih? Mengapa?', '2025-04-19 06:45:41'),
(54, 1, 7, 'sequential', 'topik7', 'Diskusi', 'Mengapa kamu memilih platform tertentu dibandingkan yang lain untuk project IoT kamu? Apakah berdasarkan biaya, kemudahan, atau dokumentasi?', '2025-04-19 06:54:07'),
(55, 1, 2, 'global', 'topik2', 'Studi Kasus Awal', 'Skenario: \"Smart Plant Watering System\"\r\nBayangkan kamu ingin membuat sistem otomatis yang bisa menyiram tanaman saat tanahnya kering. Komponen utama:\r\n\r\n- Sensor kelembaban tanah\r\n\r\n- Arduino UNO\r\n\r\n- Pompa air mini\r\n\r\n- LED sebagai indikator\r\n\r\nPertanyaan reflektif:\r\n\r\n1. Bagaimana Arduino berperan sebagai otak sistem?\r\n\r\n2. Apa peran pin input dan output dalam sistem ini?', '2025-04-19 08:04:55'),
(56, 1, 2, 'global', 'topik2', 'Visualisasi & Eksplorasi Kode', 'int ledPin = 13;\r\nint buttonPin = 2;\r\n\r\nvoid setup() {\r\n  pinMode(ledPin, OUTPUT);\r\n  pinMode(buttonPin, INPUT);\r\n}\r\n\r\nvoid loop() {\r\n  int buttonState = digitalRead(buttonPin);\r\n  if (buttonState == HIGH) {\r\n    digitalWrite(ledPin, HIGH);\r\n  } else {\r\n    digitalWrite(ledPin, LOW);\r\n  }\r\n}\r\n\r\nDiskusi: “Apa hubungan antara tombol, logika IF, dan LED menyala?”', '2025-04-19 08:07:58'),
(57, 1, 2, 'global', 'topik2', 'Visualisasi & Eksplorasi Kode', 'int ledPin = 13;\r\nint buttonPin = 2;\r\n\r\nvoid setup() {\r\n  pinMode(ledPin, OUTPUT);\r\n  pinMode(buttonPin, INPUT);\r\n}\r\n\r\nvoid loop() {\r\n  int buttonState = digitalRead(buttonPin);\r\n  if (buttonState == HIGH) {\r\n    digitalWrite(ledPin, HIGH);\r\n  } else {\r\n    digitalWrite(ledPin, LOW);\r\n  }\r\n}\r\n\r\nDiskusi: “Apa hubungan antara tombol, logika IF, dan LED menyala?”', '2025-04-19 08:12:48'),
(58, 1, 3, 'global', 'topik3', 'Diskusi', 'Bagaimana hubungan antara data dari sensor cahaya dan deteksi objek dapat dimanfaatkan untuk menghemat energi listrik di sebuah ruang kerja?', '2025-04-19 09:33:42'),
(59, 1, 4, 'global', 'topik4', 'Diskusi', 'Mengapa penting untuk mengintegrasikan berbagai jenis aktuator dalam satu sistem otomatis, dan bagaimana koordinasi antar aktuator bisa dilakukan secara efisien?', '2025-04-19 09:44:25'),
(60, 1, 5, 'global', 'topik5', 'Diskusi ', 'Bayangkan kamu bagian dari tim support sebuah sistem IoT di lingkungan kampus. Apa langkah-langkah proaktif yang bisa kamu lakukan untuk mencegah sistem mengalami gangguan?', '2025-04-19 11:55:05');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_forum_posts`
--

CREATE TABLE `mdl_forum_posts` (
  `id` bigint(10) NOT NULL,
  `forum_id` bigint(10) NOT NULL,
  `user_id` bigint(10) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_forum_posts`
--

INSERT INTO `mdl_forum_posts` (`id`, `forum_id`, `user_id`, `content`, `created_at`, `updated_at`) VALUES
(2, 1, 1, 'Menurut saya, IoT sangat bermanfaat bagi seluruh aspek kehidupan pada zaman modern ini', '2025-04-04 23:00:07', '2025-04-15 04:11:22'),
(4, 2, 1, 'Menurut saya, IoT bisa membuat cara kita bekerja dan belajar jadi lebih efisien dan fleksibel. Misalnya, perangkat pintar bisa membantu memantau pekerjaan secara otomatis, atau membuat ruang kelas jadi interaktif dengan alat-alat yang terhubung ke internet. Dalam 10 tahun ke depan, kita mungkin bisa belajar dari mana saja dengan bantuan sensor, AI, dan perangkat IoT tanpa harus selalu berada di tempat fisik tertentu.', '2025-04-13 07:23:03', '2025-04-13 07:23:03'),
(7, 3, 1, 'Halo', '2025-04-15 04:38:56', '2025-04-15 04:38:56'),
(8, 4, 1, 'Hai', '2025-04-15 05:10:17', '2025-04-15 05:10:17'),
(9, 5, 1, 'hai', '2025-04-15 05:33:31', '2025-04-15 05:33:31'),
(10, 7, 1, 'Halo', '2025-04-16 00:37:31', '2025-04-16 00:37:31'),
(12, 14, 1, 'Halo', '2025-04-16 19:35:58', '2025-04-16 19:35:58'),
(13, 18, 1, 'Halo', '2025-04-16 23:00:39', '2025-04-16 23:00:39'),
(14, 15, 1, 'Halo', '2025-04-17 21:11:50', '2025-04-17 21:11:50'),
(15, 1, 1, 'hai', '2025-04-20 06:24:25', '2025-04-20 06:24:25'),
(16, 1, 1, 'halo', '2025-04-20 06:25:00', '2025-04-20 06:25:00'),
(17, 7, 3, 'Hallo semuanya', '2025-04-25 23:04:47', '2025-04-25 23:04:47'),
(18, 14, 1, 'oi', '2025-04-26 23:00:29', '2025-04-26 23:00:29'),
(22, 13, 1, 'halo', '2025-04-29 04:40:15', '2025-04-29 04:40:15'),
(23, 18, 1, 'halo', '2025-04-29 04:40:39', '2025-04-29 04:40:39'),
(24, 18, 1, 'halo', '2025-04-29 05:22:32', '2025-04-29 05:22:32'),
(25, 18, 1, 'halo guys', '2025-04-29 05:22:45', '2025-04-29 05:23:19'),
(26, 13, 1, 'halo', '2025-04-29 05:24:06', '2025-04-29 05:24:06'),
(27, 13, 1, 'agagagaga', '2025-04-29 05:25:32', '2025-04-29 05:25:32'),
(28, 13, 1, 'halo', '2025-04-29 05:32:39', '2025-04-29 05:32:39'),
(29, 16, 1, 'halo', '2025-04-29 05:33:15', '2025-04-29 05:33:15'),
(30, 16, 1, 'menurut saya adalah fafafa', '2025-04-29 05:33:31', '2025-04-29 05:37:24'),
(32, 19, 1, 'halo', '2025-04-29 06:01:27', '2025-04-29 06:01:27'),
(33, 19, 1, 'halo', '2025-04-29 06:19:30', '2025-04-29 06:19:30'),
(34, 19, 1, 'halo', '2025-04-29 06:19:45', '2025-04-29 06:19:45'),
(35, 14, 1, 'halo semua', '2025-04-29 17:09:36', '2025-04-29 17:09:57'),
(36, 1, 3, 'hai', '2025-04-29 18:09:55', '2025-04-29 18:09:55');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_global`
--

CREATE TABLE `mdl_global` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `section_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content_type` enum('quiz','h5p','forum','assignment','file','resource','video') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_global`
--

INSERT INTO `mdl_global` (`id`, `course_id`, `section_id`, `title`, `description`, `content_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Topik 1: Pengantar IoT & Arsitektur IoT', 'Di era digital saat ini, teknologi semakin berkembang pesat dan menghadirkan inovasi yang mengubah cara kita hidup dan bekerja. Salah satu teknologi yang berperan besar dalam transformasi ini adalah Internet of Things (IoT). IoT menghubungkan berbagai perangkat fisik ke internet, memungkinkan mereka untuk saling berkomunikasi, mengumpulkan data, dan merespons secara otomatis tanpa intervensi manusia. Dari smart home yang dapat dikendalikan melalui smartphone hingga sistem industri otomatis yang meningkatkan efisiensi produksi, IoT telah menjadi bagian tak terpisahkan dari kehidupan modern. Dengan memahami IoT, kita dapat menciptakan solusi inovatif untuk berbagai sektor, seperti kesehatan, transportasi, pertanian, dan manufaktur. Mata kuliah ini akan membahas konsep dasar, arsitektur, serta implementasi IoT dalam dunia nyata. Mari kita jelajahi dunia IoT dan bagaimana teknologi ini membawa perubahan besar bagi masa depan!', 'video', '2025-04-13 12:11:45', '2025-04-13 12:11:45'),
(2, 1, 2, 'Topik 2: Pemrograman dan I/O Arduino', 'Pelajari integrasi input/output menggunakan Arduino IDE dan Serial Monitor. Analisis efisiensi kode dan evaluasi kinerja program untuk skenario IoT sederhana. Rancang solusi pemrograman yang presisi dan inovatif.', 'file', '2025-04-15 02:18:59', '2025-04-15 02:18:59'),
(3, 1, 3, 'Topik 3: Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object', 'Eksplorasi data dari sensor cahaya, suhu, dan objek untuk menciptakan aplikasi responsif. Evaluasi performa sistem sensor melalui analisis data. Rancang aplikasi yang mengintegrasikan sensor secara optimal.', 'file', '2025-04-15 02:18:59', '2025-04-15 02:18:59'),
(4, 1, 4, 'Topik 4: Aktuator: Cahaya, Bunyi, dan Motor', 'Kendalikan aktuator seperti LED RGB, buzzer, dan servo untuk membangun sistem yang dinamis. Evaluasi performa sistem kontrol berbasis aktuator. Rancang aplikasi IoT yang mengintegrasikan aktuator dengan tepat.', 'file', '2025-04-15 02:18:59', '2025-04-15 02:18:59'),
(5, 1, 5, 'Topik 5: Support', 'Pahami cara kerja relay dan keypad dalam sistem kontrol yang cerdas. Evaluasi performa konfigurasi sistem berbasis relay dan keypad. Rancang sistem kontrol yang responsif dan sesuai spesifikasi.', 'file', '2025-04-15 02:18:59', '2025-04-15 02:18:59'),
(6, 1, 6, 'Topik 6: Jaringan Komunikasi', 'Analisis efisiensi jaringan komunikasi IoT seperti Wi-Fi, MQTT, dan LoRaWAN. Evaluasi performa protokol jaringan untuk aplikasi IoT. Rancang solusi komunikasi yang terintegrasi dan fungsional.', 'file', '2025-04-15 02:18:59', '2025-04-15 02:18:59'),
(7, 1, 7, 'Topik 7: Aplikasi Platform IoT', 'Dalam era digital yang semakin berkembang pesat, Internet of Things (IoT) telah menjadi salah satu teknologi yang memiliki dampak besar terhadap berbagai sektor, seperti industri, rumah tangga, dan kesehatan. IoT memungkinkan perangkat-perangkat fisik untuk saling terhubung dan berkomunikasi melalui jaringan internet, menciptakan ekosistem yang lebih cerdas dan efisien. Pada materi ini, kita akan membahas dua platform yang sangat populer dalam implementasi IoT, yaitu Blynk dan ThingSpeak. Blynk merupakan platform yang menyediakan antarmuka pengguna yang mudah digunakan untuk membangun aplikasi IoT tanpa perlu menulis banyak kode. Di sisi lain, ThingSpeak adalah platform berbasis cloud yang memungkinkan pengumpulan dan analisis data sensor secara real-time, sangat cocok untuk aplikasi IoT berbasis data. Melalui pemahaman mendalam mengenai kedua platform ini, diharapkan peserta dapat mengembangkan solusi IoT yang lebih efektif dan inovatif. Kami berharap materi ini dapat memberikan wawasan yang berguna serta memotivasi para peserta untuk mengeksplorasi lebih jauh potensi besar yang ditawarkan oleh teknologi IoT.', 'file', '2025-04-15 02:18:59', '2025-04-15 02:18:59');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_h5p`
--

CREATE TABLE `mdl_h5p` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_intuitive`
--

CREATE TABLE `mdl_intuitive` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `section_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content_type` enum('quiz','h5p','forum','assignment','file','resource','video') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_intuitive`
--

INSERT INTO `mdl_intuitive` (`id`, `course_id`, `section_id`, `title`, `description`, `content_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Topik 1: Pengantar IoT & Arsitektur IoT', 'Di era digital saat ini, teknologi semakin berkembang pesat dan menghadirkan inovasi yang mengubah cara kita hidup dan bekerja. Salah satu teknologi yang berperan besar dalam transformasi ini adalah Internet of Things (IoT). IoT menghubungkan berbagai perangkat fisik ke internet, memungkinkan mereka untuk saling berkomunikasi, mengumpulkan data, dan merespons secara otomatis tanpa intervensi manusia. Dari smart home yang dapat dikendalikan melalui smartphone hingga sistem industri otomatis yang meningkatkan efisiensi produksi, IoT telah menjadi bagian tak terpisahkan dari kehidupan modern. Dengan memahami IoT, kita dapat menciptakan solusi inovatif untuk berbagai sektor, seperti kesehatan, transportasi, pertanian, dan manufaktur. Mata kuliah ini akan membahas konsep dasar, arsitektur, serta implementasi IoT dalam dunia nyata. Mari kita jelajahi dunia IoT dan bagaimana teknologi ini membawa perubahan besar bagi masa depan!', 'file', '2025-04-07 06:20:59', '2025-04-07 06:20:59'),
(2, 1, 2, 'Topik 2: Pemrograman dan I/O Arduino', 'Pelajari integrasi input/output menggunakan Arduino IDE dan Serial Monitor. Analisis efisiensi kode dan evaluasi kinerja program untuk skenario IoT sederhana. Rancang solusi pemrograman yang presisi dan inovatif.', 'file', '2025-04-15 02:10:59', '2025-04-15 02:10:59'),
(3, 1, 3, 'Topik 3: Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object', 'Eksplorasi data dari sensor cahaya, suhu, dan objek untuk menciptakan aplikasi responsif. Evaluasi performa sistem sensor melalui analisis data. Rancang aplikasi yang mengintegrasikan sensor secara optimal.', 'file', '2025-04-15 02:10:59', '2025-04-15 02:10:59'),
(4, 1, 4, 'Topik 4: Aktuator: Cahaya, Bunyi, dan Motor', 'Kendalikan aktuator seperti LED RGB, buzzer, dan servo untuk membangun sistem yang dinamis. Evaluasi performa sistem kontrol berbasis aktuator. Rancang aplikasi IoT yang mengintegrasikan aktuator dengan tepat.', 'file', '2025-04-15 02:10:59', '2025-04-15 02:10:59'),
(5, 1, 5, 'Topik 5: Support', 'Pahami cara kerja relay dan keypad dalam sistem kontrol yang cerdas. Evaluasi performa konfigurasi sistem berbasis relay dan keypad. Rancang sistem kontrol yang responsif dan sesuai spesifikasi.', 'file', '2025-04-15 02:10:59', '2025-04-15 02:10:59'),
(6, 1, 6, 'Topik 6: Jaringan Komunikasi', 'Analisis efisiensi jaringan komunikasi IoT seperti Wi-Fi, MQTT, dan LoRaWAN. Evaluasi performa protokol jaringan untuk aplikasi IoT. Rancang solusi komunikasi yang terintegrasi dan fungsional.', 'file', '2025-04-15 02:10:59', '2025-04-15 02:10:59'),
(7, 1, 7, 'Topik 7: Aplikasi Platform IoT', 'Dalam era digital yang semakin berkembang pesat, Internet of Things (IoT) telah menjadi salah satu teknologi yang memiliki dampak besar terhadap berbagai sektor, seperti industri, rumah tangga, dan kesehatan. IoT memungkinkan perangkat-perangkat fisik untuk saling terhubung dan berkomunikasi melalui jaringan internet, menciptakan ekosistem yang lebih cerdas dan efisien. Pada materi ini, kita akan membahas dua platform yang sangat populer dalam implementasi IoT, yaitu Blynk dan ThingSpeak. Blynk merupakan platform yang menyediakan antarmuka pengguna yang mudah digunakan untuk membangun aplikasi IoT tanpa perlu menulis banyak kode. Di sisi lain, ThingSpeak adalah platform berbasis cloud yang memungkinkan pengumpulan dan analisis data sensor secara real-time, sangat cocok untuk aplikasi IoT berbasis data. Melalui pemahaman mendalam mengenai kedua platform ini, diharapkan peserta dapat mengembangkan solusi IoT yang lebih efektif dan inovatif. Kami berharap materi ini dapat memberikan wawasan yang berguna serta memotivasi para peserta untuk mengeksplorasi lebih jauh potensi besar yang ditawarkan oleh teknologi IoT.', 'file', '2025-04-15 02:10:59', '2025-04-15 02:10:59');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_learning_styles`
--

CREATE TABLE `mdl_learning_styles` (
  `id` bigint(10) NOT NULL,
  `style_name` varchar(255) NOT NULL,
  `dimension` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_learning_styles`
--

INSERT INTO `mdl_learning_styles` (`id`, `style_name`, `dimension`, `description`) VALUES
(1, 'ACT/REF', 'Processing', 'Active/Reflective'),
(2, 'SNS/INT', 'Perception', 'Sensing/Intuitive'),
(3, 'VIS/VRB', 'Input', 'Visual/Verbal'),
(4, 'SEQ/GLO', 'Understanding', 'Sequential/Global');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_quiz`
--

CREATE TABLE `mdl_quiz` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `learning_style` enum('active','reflective','sensing','intuitive','visual','verbal','sequential','global') NOT NULL,
  `topik` enum('topik1','topik2','topik3','topik4','topik5','topik6','topik7') NOT NULL,
  `time_open` datetime NOT NULL,
  `time_close` datetime NOT NULL,
  `time_limit` bigint(10) NOT NULL,
  `max_attempts` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_quiz`
--

INSERT INTO `mdl_quiz` (`id`, `course_id`, `name`, `description`, `learning_style`, `topik`, `time_open`, `time_close`, `time_limit`, `max_attempts`, `created_at`, `updated_at`) VALUES
(1, 1, 'Pengantar IoT', 'Quiz ini menguji pemahaman dasar tentang Internet of Things.', 'active', 'topik1', '2025-04-05 00:00:00', '2025-05-28 00:00:00', 1800, 2, '2025-04-05 11:39:08', '2025-04-05 11:39:08'),
(2, 1, 'Pengantar IoT', 'Quiz ini menguji pemahaman dasar tentang materi yang sudah dipelajari.', 'sequential', 'topik1', '2025-04-12 00:00:00', '2025-04-19 00:00:00', 1800, 2, '2025-04-12 03:49:52', '2025-04-12 03:49:52'),
(3, 1, 'IoT dalam Kehidupan Sehari-hari dan Masa Depan Teknologi', 'Quiz ini menguji pemahaman dasar tentang materi diatas yang sudah dipelajari.', 'global', 'topik1', '2025-04-14 00:00:00', '2025-04-21 00:00:00', 1800, 2, '2025-04-14 06:11:21', '2025-04-14 06:11:21'),
(4, 1, 'Quiz Tutorial Dasar Arduino (Dasar Pemrograman Part 1: Dasar-dasar Pembuatan Sketch Program)', 'Quiz ini untuk melihat seberapa paham pengetahuan tentang dasar dasar Arduino setelah melihat video pembelajaran diatas', 'active', 'topik2', '2025-04-14 00:00:00', '2025-04-21 00:00:00', 1800, 2, '2025-04-15 08:35:25', '2025-04-15 08:35:25'),
(5, 1, 'Quiz Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object\r\n', 'Quiz ini untuk melihat seberapa paham pengetahuan tentang Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object', 'active', 'topik3', '2025-04-14 00:00:00', '2025-04-21 00:00:00', 1800, 2, '2025-04-15 12:08:54', '2025-04-15 12:08:54'),
(6, 1, 'Quiz Aktuator: Cahaya, Bunyi, dan Motor\r\n', 'Menguji pemahaman konsep aktuator cahaya, bunyi, dan motor.', 'active', 'topik4', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-16 07:43:42', '2025-04-16 07:43:42'),
(7, 1, 'Quiz Support (Relay dan Keypad)', 'Prinsip kerja relay & keypad dan Perbedaan input digital vs analog', 'active', 'topik5', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-16 08:06:04', '2025-04-16 08:06:04'),
(8, 1, 'Quiz Mini', 'Untuk membandingkan karakteristik Wi-Fi, Bluetooth, dan Seluler dan mengetahui perangkat apa yang cocok untuk tiap metode', 'active', 'topik6', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-16 08:23:20', '2025-04-16 08:23:20'),
(9, 1, 'Quiz Mini', 'Fungsi masing-masing platform dan perbedaan cloud-based dan local IoT dashboard', 'active', 'topik7', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-16 08:40:45', '2025-04-16 08:40:45'),
(10, 1, 'Quiz', 'Soal-soal ini dirancang agar mahasiswa merenungkan konsep, bukan sekadar menghafal.', 'reflective', 'topik2', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-17 01:38:15', '2025-04-17 01:38:15'),
(11, 1, 'Quiz', 'Konsep & Penerapan dari Internet of Things (IoT)', 'reflective', 'topik1', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-17 02:38:08', '2025-04-17 02:38:08'),
(12, 1, 'Quiz', '', 'reflective', 'topik3', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-17 04:16:08', '2025-04-17 04:16:08'),
(13, 1, 'Quiz', 'Quiz 5 soal seputar fungsi, kode, dan analisis aktuator', 'reflective', 'topik4', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-17 05:37:43', '2025-04-17 05:37:43'),
(14, 1, 'Quiz', 'Quiz singkat (5 soal & pemahaman teknis) terkait Relay & Keypad', 'reflective', 'topik5', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-17 05:49:39', '2025-04-17 05:49:39'),
(15, 1, 'Quiz', 'Quiz reflektif 5 soal', 'reflective', 'topik6', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-17 06:00:30', '2025-04-17 06:00:30'),
(16, 1, 'Quiz Mini', '', 'intuitive', 'topik1', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-18 04:33:21', '2025-04-18 04:33:21'),
(17, 1, 'Quiz Mini Intuitif', '', 'intuitive', 'topik2', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-18 04:44:46', '2025-04-18 04:44:46'),
(18, 1, 'Quiz', '', 'intuitive', 'topik3', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-18 04:54:50', '2025-04-18 04:54:50'),
(19, 1, 'Quiz Konseptual', '', 'intuitive', 'topik4', '2025-04-15 00:00:00', '2025-04-22 00:00:00', 1800, 2, '2025-04-18 05:00:07', '2025-04-18 05:00:07');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_quiz_answers`
--

CREATE TABLE `mdl_quiz_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attempt_id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mdl_quiz_answers`
--

INSERT INTO `mdl_quiz_answers` (`id`, `attempt_id`, `question_id`, `answer`, `created_at`, `updated_at`) VALUES
(1, 12, 1, 'a', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(2, 12, 2, 'a', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(3, 12, 3, 'b', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(4, 12, 4, 'c', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(5, 12, 5, 'b', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(6, 12, 6, 'b', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(7, 12, 7, 'a', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(8, 12, 8, 'd', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(9, 12, 9, 'b', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(10, 12, 10, 'b', '2025-04-29 21:05:16', '2025-04-29 21:05:16'),
(11, 13, 1, 'a', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(12, 13, 2, 'a', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(13, 13, 3, 'b', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(14, 13, 4, 'c', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(15, 13, 5, 'b', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(16, 13, 6, 'b', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(17, 13, 7, 'a', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(18, 13, 8, 'd', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(19, 13, 9, 'b', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(20, 13, 10, 'b', '2025-05-01 10:26:04', '2025-05-01 10:26:04'),
(21, 15, 1, 'a', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(22, 15, 2, 'a', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(23, 15, 3, 'b', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(24, 15, 4, 'c', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(25, 15, 5, 'b', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(26, 15, 6, 'b', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(27, 15, 7, 'a', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(28, 15, 8, 'd', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(29, 15, 9, 'b', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(30, 15, 10, 'b', '2025-05-01 10:33:43', '2025-05-01 10:33:43'),
(31, 16, 1, 'a', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(32, 16, 2, 'a', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(33, 16, 3, 'b', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(34, 16, 4, 'c', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(35, 16, 5, 'b', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(36, 16, 6, 'b', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(37, 16, 7, 'a', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(38, 16, 8, 'd', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(39, 16, 9, 'b', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(40, 16, 10, 'c', '2025-05-01 10:37:08', '2025-05-01 10:37:08'),
(41, 17, 1, 'a', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(42, 17, 2, 'a', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(43, 17, 3, 'b', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(44, 17, 4, 'c', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(45, 17, 5, 'b', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(46, 17, 6, 'b', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(47, 17, 7, 'a', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(48, 17, 8, 'd', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(49, 17, 9, 'b', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(50, 17, 10, 'c', '2025-05-01 10:38:31', '2025-05-01 10:38:31'),
(51, 18, 1, 'a', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(52, 18, 2, 'a', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(53, 18, 3, 'b', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(54, 18, 4, 'c', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(55, 18, 5, 'b', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(56, 18, 6, 'b', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(57, 18, 7, 'a', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(58, 18, 8, 'd', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(59, 18, 9, 'b', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(60, 18, 10, 'c', '2025-05-01 10:40:41', '2025-05-01 10:40:41'),
(61, 19, 1, 'a', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(62, 19, 2, 'a', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(63, 19, 3, 'b', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(64, 19, 4, 'c', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(65, 19, 5, 'b', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(66, 19, 6, 'b', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(67, 19, 7, 'a', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(68, 19, 8, 'd', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(69, 19, 9, 'b', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(70, 19, 10, 'c', '2025-05-01 10:43:31', '2025-05-01 10:43:31'),
(71, 20, 1, 'a', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(72, 20, 2, 'a', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(73, 20, 3, 'b', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(74, 20, 4, 'c', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(75, 20, 5, 'b', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(76, 20, 6, 'b', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(77, 20, 7, 'a', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(78, 20, 8, 'd', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(79, 20, 9, 'b', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(80, 20, 10, 'c', '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(81, 21, 1, 'a', '2025-05-01 10:52:21', '2025-05-01 10:52:21'),
(82, 21, 2, 'a', '2025-05-01 10:52:21', '2025-05-01 10:52:21'),
(83, 21, 3, 'b', '2025-05-01 10:52:21', '2025-05-01 10:52:21'),
(84, 21, 4, 'c', '2025-05-01 10:52:21', '2025-05-01 10:52:21'),
(85, 21, 5, 'b', '2025-05-01 10:52:21', '2025-05-01 10:52:21'),
(86, 21, 6, 'b', '2025-05-01 10:52:21', '2025-05-01 10:52:21'),
(87, 21, 7, 'a', '2025-05-01 10:52:21', '2025-05-01 10:52:21'),
(88, 21, 8, 'd', '2025-05-01 10:52:21', '2025-05-01 10:52:21'),
(89, 21, 9, 'b', '2025-05-01 10:52:21', '2025-05-01 10:52:21'),
(90, 21, 10, 'c', '2025-05-01 10:52:21', '2025-05-01 10:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_quiz_attempts`
--

CREATE TABLE `mdl_quiz_attempts` (
  `id` bigint(10) NOT NULL,
  `quiz_id` bigint(10) NOT NULL,
  `user_id` bigint(10) UNSIGNED NOT NULL,
  `attempt_id` mediumint(6) NOT NULL DEFAULT 0,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `score` decimal(5,0) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_quiz_attempts`
--

INSERT INTO `mdl_quiz_attempts` (`id`, `quiz_id`, `user_id`, `attempt_id`, `start_time`, `end_time`, `score`, `created_at`, `updated_at`) VALUES
(20, 1, 3, 0, '2025-05-01 17:50:27', '2025-05-01 17:50:27', NULL, '2025-05-01 10:50:27', '2025-05-01 10:50:27'),
(21, 1, 3, 0, '2025-05-01 17:52:21', '2025-05-01 17:52:21', NULL, '2025-05-01 10:52:21', '2025-05-01 10:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_quiz_grades`
--

CREATE TABLE `mdl_quiz_grades` (
  `id` bigint(10) NOT NULL,
  `attempt` bigint(20) NOT NULL,
  `quiz_id` bigint(10) NOT NULL,
  `user_id` bigint(10) UNSIGNED NOT NULL,
  `grade` decimal(5,2) NOT NULL,
  `attempt_number` bigint(10) NOT NULL,
  `completed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_quiz_question`
--

CREATE TABLE `mdl_quiz_question` (
  `id` bigint(10) NOT NULL,
  `quiz_id` bigint(10) NOT NULL,
  `question_text` varchar(500) NOT NULL,
  `options_a` varchar(255) NOT NULL,
  `options_b` varchar(255) NOT NULL,
  `options_c` varchar(255) NOT NULL,
  `options_d` varchar(255) NOT NULL,
  `correct_answer` varchar(255) NOT NULL,
  `learning_style` enum('active','reflective','sensing','intuitive','visual','verbal','sequential','global') DEFAULT NULL,
  `topik` enum('topik1','topik2','topik3','topik4','topik5','topik6','topik7') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_quiz_question`
--

INSERT INTO `mdl_quiz_question` (`id`, `quiz_id`, `question_text`, `options_a`, `options_b`, `options_c`, `options_d`, `correct_answer`, `learning_style`, `topik`, `created_at`) VALUES
(1, 1, 'Apa kepanjangan dari IoT?', 'Internet of Things', 'Internet of Tree', 'Internet on Time', 'Input of Technology', 'Internet of Things', 'active', 'topik1', '2025-04-05 11:46:42'),
(2, 1, 'Manakah perangkat berikut yang termasuk perangkat IoT?', 'Smartwatch', 'Mouse', 'Printer', 'Scanner', 'Smartwatch', 'active', 'topik1', '2025-04-05 11:46:42'),
(3, 1, 'Protokol komunikasi yang umum digunakan dalam IoT adalah?', 'FTP', 'MQTT', 'SMTP', 'HTTP', 'MQTT', 'active', 'topik1', '2025-04-05 11:46:42'),
(4, 1, 'Apa fungsi utama dari sensor dalam sistem IoT?', 'Menampilkan data', 'Mengontrol perangkat', 'Mendeteksi dan mengumpulkan data', 'Menghubungkan ke internet', 'Mendeteksi dan mengumpulkan data', 'active', 'topik1', '2025-04-05 11:46:42'),
(5, 1, 'Platform populer untuk pengembangan IoT adalah?', 'Windows', 'Raspberry Pi', 'Google Chrome', 'Oracle', 'Raspberry Pi', 'active', 'topik1', '2025-04-05 11:46:42'),
(6, 1, 'Manakah contoh aplikasi IoT di bidang pertanian?', 'E-learning', 'Smart irrigation', 'Streaming musik', 'Social media', 'Smart irrigation', 'active', 'topik1', '2025-04-05 11:46:42'),
(7, 1, 'Apa kepanjangan dari MQTT?', 'Message Queue Telemetry Transport', 'Multiple Queue Transport Technique', 'Modular Queue Telemetry Transfer', 'Main Query Transfer Text', 'Message Queue Telemetry Transport', 'active', 'topik1', '2025-04-05 11:46:42'),
(8, 1, 'Perangkat yang dapat mengirim dan menerima data disebut?', 'Sensor', 'Actuator', 'Gateway', 'Node', 'Node', 'active', 'topik1', '2025-04-05 11:46:42'),
(9, 1, 'Apa manfaat utama dari sistem IoT?', 'Mengurangi konektivitas', 'Meningkatkan otomatisasi dan efisiensi', 'Menambah pekerjaan manual', 'Mengurangi teknologi', 'Meningkatkan otomatisasi dan efisiensi', 'active', 'topik1', '2025-04-05 11:46:42'),
(10, 1, 'Apa peran gateway dalam sistem IoT?', 'Menghapus data', 'Menyimpan data selamanya', 'Menghubungkan perangkat IoT ke jaringan', 'Mengganti sensor', 'Menghubungkan perangkat IoT ke jaringan', 'active', 'topik1', '2025-04-05 11:46:42'),
(11, 2, 'Salah satu konsep dasar yang mendasari IoT adalah', 'Sensor dan Suhu', 'Node dan Gateway', 'Sensor dan Aktuator', 'Sensor dan Gateway', 'Sensor dan Aktuator', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(12, 2, 'Konsep Internet of Things (IoT) pertama kali muncul pada tahun .... dan melalui perangkat ...', 'Tahun 1990 melalui mesin kopi pintar', 'Tahun 1982 melalui perangkat \"Coca-Cola Machine\"', 'Tahun 2000 melalui smartphone pertama', 'Tahun 1995 melalui sensor cuaca otomatis', 'Tahun 1982 melalui perangkat \"Coca-Cola Machine\"', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(13, 2, 'Fungsi utama dari sensor dalam ekosistem Internet of Things (IoT) adalah', 'Menyimpan dan menganalisis data secara besar-besaran', 'Menghubungkan perangkat IoT ke internet melalui jaringan', 'Mendeteksi dan mengukur parameter fisik dari lingkungan sekitar', 'Mengembangkan aplikasi yang memberikan solusi IoT', 'Mendeteksi dan mengukur parameter fisik dari lingkungan sekitar', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(14, 2, 'Berikut ini yang merupakan urutan arsitektur hierarkis dalam ekosistem IoT adalah', 'Sensor ? Aplikasi ? Platform', 'Cloud ? Fog ? Edge', 'Edge ? Fog ? Cloud', 'Platform ? Sensor ? Cloud', 'Edge ? Fog ? Cloud', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(15, 2, 'Fungsi dari gateway dalam sistem IoT adalah', 'Mengirim data dari cloud ke ponsel pintar', 'Menyimpan data sementara dari aplikasi', 'Menghubungkan sensor ke jaringan internet dan melakukan konversi protocol', 'Menyediakan tampilan visualisasi data kepada pengguna', 'Menghubungkan sensor ke jaringan internet dan melakukan konversi protocol', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(16, 2, 'Perangkat ponsel pintar dalam sistem IoT tidak hanya berfungsi sebagai sensor, tetapi juga sebagai...', 'Server penyimpanan utama', 'Antarmuka pengguna dan gateway', 'Protokol jaringan dasar', 'Sistem pendingin data', 'Antarmuka pengguna dan gateway', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(17, 2, 'Fungsi utama dari arsitektur Internet of Things (IoT) adalah', 'Menyediakan perangkat lunak untuk cloud computing', 'Menghubungkan perangkat ke jaringan sosial', 'Menggambarkan hubungan teknologi yang mendukung IoT dan komunikasi antar komponennya', 'Menghubungkan sistem AI dengan sistem keamanan', 'Menggambarkan hubungan teknologi yang mendukung IoT dan komunikasi antar komponennya', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(18, 2, 'Lapisan paling bawah dalam arsitektur IoT adalah...', 'Lapisan layanan manajemen', 'Lapisan sensor atau perangkat cerdas', 'Lapisan aplikasi pengguna', 'Lapisan analitik big data', 'Lapisan sensor atau perangkat cerdas', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(19, 2, 'Keunggulan utama dari perangkat IoT dalam kehidupan sehari-hari adalah', 'Dapat digunakan tanpa koneksi internet', 'Dapat memproduksi energi sendiri', 'Dapat dipantau dan dikendalikan dari jarak jauh', 'Hanya bekerja jika dioperasikan secara manual', 'Dapat dipantau dan dikendalikan dari jarak jauh', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(20, 2, 'Salah satu contoh penerapan aplikasi IoT di sektor kesehatan adalah...', 'Alat tulis digital', 'Mesin ATM pintar', 'Perangkat pemantauan pasien secara real-time', 'Software pengolah kata', 'Perangkat pemantauan pasien secara real-time', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(21, 2, 'Fungsi utama dari Nest Smart Thermostat dalam rumah pintar adalah', 'Menyaring udara secara otomatis', 'Menyesuaikan suhu secara otomatis berdasarkan rutinitas penghuni rumah', 'Mengendalikan sistem keamanan rumah', 'Menyediakan koneksi internet gratis', 'Menyesuaikan suhu secara otomatis berdasarkan rutinitas penghuni rumah', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(22, 2, 'Salah satu manfaat IoT membantu dalam sektor pertanian pintar (Smart Agriculture) adalah', 'Meningkatkan produksi pupuk secara otomatis', 'Memberikan laporan cuaca harian', 'Memantau kelembaban tanah dan kesehatan hewan dengan sensor', 'Menghubungkan petani ke media social', 'Memantau kelembaban tanah dan kesehatan hewan dengan sensor', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(23, 2, 'Peran penting protokol MQTT dalam perkembangan framework pemrograman untuk Internet of Things (IoT) adalah', 'Memungkinkan perangkat IoT menjalankan sistem operasi berbasis cloud', 'Menyediakan antarmuka grafis untuk pemrograman perangkat IoT', 'Mengirim data secara efisien dan mendukung konektivitas yang tidak stabil', 'Menghubungkan perangkat IoT langsung ke jaringan sosial pengguna', 'Mengirim data secara efisien dan mendukung konektivitas yang tidak stabil', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(24, 2, 'Framework yang menggunakan pendekatan pemrograman berbasis aliran (flow-based programming) dan memungkinkan pengembangan IoT tanpa pengetahuan pemrograman mendalam adalah', 'Arduino IDE', 'Node-RED', 'PlatformIO', 'MBED OS', 'Node-RED', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(25, 2, 'Dalam implementasi smart home, framework pemrograman yang sering digunakan untuk mengendalikan perangkat dan membuat otomatisasi berdasarkan parameter seperti waktu atau suhu adalah', 'MBED OS', 'Node-RED', 'Arduino dan Raspberry Pi', 'IBM Watson IoT', 'Arduino dan Raspberry Pi', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(26, 2, 'Salah satu fokus utama dalam pengembangan framework IoT di masa depan seiring dengan meningkatnya jumlah perangkat yang terhubung adalah', 'Penurunan biaya perangkat keras', 'Peningkatan keamanan dan perlindungan data', 'Pengurangan jumlah perangkat IoT', 'Penggunaan hanya satu bahasa Pemrograman', 'Peningkatan keamanan dan perlindungan data', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(27, 2, 'Tujuan utama dari penerapan teknologi Internet of Things (IoT) dalam Smart Hotel adalah', 'Meningkatkan jumlah karyawan hotel', 'Mengurangi penggunaan perangkat elektronik', 'Meningkatkan manajemen, efisiensi, dan pengalaman tamu', 'Menggantikan seluruh layanan dengan staf manual', 'Meningkatkan manajemen, efisiensi, dan pengalaman tamu', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(28, 2, 'Cara teknologi IoT meningkatkan pengalaman check-in tamu di hotel adalah', 'Dengan menyediakan layanan antar bagasi secara manual', 'Dengan memungkinkan tamu melewati meja check-in dan langsung menuju kamar', 'Dengan mengharuskan tamu membawa kunci fisik', 'Dengan mengurangi jumlah kamar yang tersedia untuk pemesanan', 'Dengan memungkinkan tamu melewati meja check-in dan langsung menuju kamar', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(29, 2, 'Manfaat utama dari penggunaan menu makanan digital dan asisten kamar yang dikontrol suara di hotel berbasis IoT adalah', 'Mengurangi kebutuhan akan staf kebersihan', 'Mempermudah tamu dalam memesan layanan dan menyimpan preferensi mereka', 'Menghapus layanan spa dari daftar layanan hotel', 'Mengganti semua layanan makanan dengan layanan otomatis', 'Mempermudah tamu dalam memesan layanan dan menyimpan preferensi mereka', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(30, 2, 'Cara teknologi IoT membantu penghematan energi di kamar hotel adalah', 'Dengan meningkatkan suhu kamar secara otomatis', 'Dengan mematikan lampu secara manual oleh staf hotel', 'Dengan sensor pintar yang mematikan lampu saat tamu keluar kamar', 'Dengan mengurangi jumlah perangkat elektronik di kamar', 'Dengan sensor pintar yang mematikan lampu saat tamu keluar kamar', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(31, 2, 'Peran utama dari platform IoT dalam arsitektur IoT pada sektor komputasi adalah', 'Menghubungkan perangkat melalui jaringan kabel', 'Mengukur suhu dan kelembaban lingkungan', 'Menerima, menyimpan, dan memproses data dari perangkat IoT', 'Mengatur jarak jangkauan sensor secara manual', 'Menerima, menyimpan, dan memproses data dari perangkat IoT', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(32, 2, 'Pernyataan berikut yang paling tepat menggambarkan fungsi perangkat lunak pengelolaan perangkat IoT adalah', 'Menghubungkan perangkat IoT hanya melalui jaringan Bluetooth', 'Mengontrol dan mengelola perangkat IoT secara terpusat, termasuk pembaruan firmware dan keamanan', 'Mengambil keputusan bisnis strategis berdasarkan tren pasar', 'Mengatur harga perangkat IoT secara otomatis', 'Mengontrol dan mengelola perangkat IoT secara terpusat, termasuk pembaruan firmware dan keamanan', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(33, 2, 'Tantangan utama dalam penerapan IoT di sektor pertanian di Indonesia adalah', 'Kurangnya minat petani terhadap pertanian modern', 'Terbatasnya daya listrik dan infrastruktur komunikasi di daerah pertanian', 'Tidak tersedianya perangkat IoT di pasar', 'Biaya perangkat IoT yang sangat rendah', 'Terbatasnya daya listrik dan infrastruktur komunikasi di daerah pertanian', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(34, 2, 'Manfaat utama dari penggunaan IoT dalam sektor pertanian adalah', 'Menambah jumlah tenaga kerja di sektor pertanian', 'Mengurangi kebutuhan akan air dan pupuk sepenuhnya', 'Memungkinkan monitoring lahan pertanian secara real-time dan presisi', 'Meningkatkan jumlah lahan pertanian yang tersedia', 'Memungkinkan monitoring lahan pertanian secara real-time dan presisi', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(35, 2, 'Menurut Kevin Ashton, teknologi Internet of Things (IoT) memungkinkan komputer untuk melakukan hal berikut ini, kecuali', 'Terhubung dengan sensor melalui jaringan internet', 'Memahami lingkungan sekitar secara otomatis', 'Menjadi bagian dari kehidupan manusia', 'Menggantikan peran guru dalam proses pembelajaran', 'Menggantikan peran guru dalam proses pembelajaran', 'sequential', 'topik1', '2025-04-10 09:51:54'),
(36, 3, 'Bagaimana IoT berkontribusi dalam bidang kesehatan, menurut isi video?', 'Menggantikan dokter dalam memberikan diagnosis', 'Menyediakan layanan streaming video kesehatan', 'Memantau kondisi kesehatan secara real-time dan memberi pengingat obat', 'Menyembuhkan penyakit kronis secara otomatis', 'Memantau kondisi kesehatan secara real-time dan memberi pengingat obat', 'global', 'topik1', '2025-04-14 06:12:17'),
(37, 3, 'Apa tantangan utama dari penerapan teknologi IoT di masa depan?', 'Biaya produksi yang terlalu mahal', 'Kurangnya perangkat pintar di pasaran', 'Risiko keamanan dan privasi data pengguna', 'Tidak adanya minat masyarakat terhadap teknologi', 'Risiko keamanan dan privasi data pengguna', 'global', 'topik1', '2025-04-14 06:25:13'),
(38, 3, 'Bagaimana IoT membantu dalam sektor manufaktur?', 'Mengurangi jumlah tenaga kerja manusia secara menyeluruh', 'Meningkatkan pengeluaran operasional', 'Mengoptimalkan proses produksi dengan pemantauan dan pengendalian mesin secara real-time', 'Menghasilkan produk baru secara otomatis tanpa desain', 'Mengoptimalkan proses produksi dengan pemantauan dan pengendalian mesin secara real-time', 'global', 'topik1', '2025-04-14 06:29:04'),
(39, 3, 'Dalam sektor pertanian, apa manfaat penggunaan sensor IoT?', 'Menjual hasil panen secara online secara otomatis', 'Mengatur harga jual hasil pertanian secara dinamis', 'Menyediakan layanan video tutorial bercocok tanam', 'Memantau kondisi pertanian secara real-time dan mengoptimalkan irigasi serta pemupukan', 'Memantau kondisi pertanian secara real-time dan mengoptimalkan irigasi serta pemupukan', 'global', 'topik1', '2025-04-14 06:29:40'),
(40, 3, 'Bagaimana rumah sakit memanfaatkan IoT untuk meningkatkan pelayanan?', 'Mengurangi interaksi antara pasien dan dokter', 'Mengandalkan relawan untuk perawatan', 'Menggunakan alat medis terhubung yang memberikan peringatan dini terhadap kondisi pasien', 'Mengganti semua perawat dengan robot', 'Menggunakan alat medis terhubung yang memberikan peringatan dini terhadap kondisi pasien', 'global', 'topik1', '2025-04-14 06:30:36'),
(41, 3, 'Apa fungsi utama dari sistem Cloud & Data Analytics dalam ekosistem perangkat IoT?', 'Menyimpan perangkat secara fisik', 'Mendistribusikan listrik ke perangkat IoT', 'Mengumpulkan dan menganalisis data dari perangkat IoT untuk meningkatkan kenyamanan dan efisiensi', 'Menyambungkan perangkat IoT ke jaringan televisi', 'Mengumpulkan dan menganalisis data dari perangkat IoT untuk meningkatkan kenyamanan dan efisiensi', 'global', 'topik1', '2025-04-14 06:31:54'),
(42, 3, 'Manakah dari berikut ini yang termasuk dalam kategori Home IoT Devices?', 'Smartwatch dan earbuds pintar', 'Smartphone dan voice assistant', 'Smart plugs dan smart TV', 'Smart fashion dan hearables', 'Smart plugs dan smart TV', 'global', 'topik1', '2025-04-14 06:32:18'),
(43, 3, 'Siapa penemu teknologi Internet of Things (IoT) dan kapan teknologi ini ditemukan?', 'Tim Berners-Lee, 1995', 'Kevin Ashton, 1999', 'Elon Musk, 2005', 'Larry Page, 2000', 'Kevin Ashton, 1999', 'global', 'topik1', '2025-04-30 06:01:47'),
(44, 3, 'Bagaimana cara kerja IoT dalam situasi darurat seperti kecelakaan lalu lintas?', 'CCTV merekam kejadian dan menyimpannya tanpa tindakan lanjut', 'Polisi menerima laporan dari saksi mata secara manual', 'Sistem IoT mendeteksi kecelakaan dan mengirim informasi ke rumah sakit terdekat', 'Kendaraan korban secara otomatis kembali ke rumah', 'Sistem IoT mendeteksi kecelakaan dan mengirim informasi ke rumah sakit terdekat', 'global', 'topik1', '2025-04-30 06:02:57');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_reflective`
--

CREATE TABLE `mdl_reflective` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(100) NOT NULL,
  `section_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content_type` enum('quiz','h5p','forum','assignment','file','resource','video') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_reflective`
--

INSERT INTO `mdl_reflective` (`id`, `course_id`, `section_id`, `title`, `description`, `content_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Topik 1: Pengantar IoT & Arsitektur IoT', 'Di era digital saat ini, teknologi semakin berkembang pesat dan menghadirkan inovasi yang mengubah cara kita hidup dan bekerja. Salah satu teknologi yang berperan besar dalam transformasi ini adalah Internet of Things (IoT). IoT menghubungkan berbagai perangkat fisik ke internet, memungkinkan mereka untuk saling berkomunikasi, mengumpulkan data, dan merespons secara otomatis tanpa intervensi manusia. Dari smart home yang dapat dikendalikan melalui smartphone hingga sistem industri otomatis yang meningkatkan efisiensi produksi, IoT telah menjadi bagian tak terpisahkan dari kehidupan modern. Dengan memahami IoT, kita dapat menciptakan solusi inovatif untuk berbagai sektor, seperti kesehatan, transportasi, pertanian, dan manufaktur. Mata kuliah ini akan membahas konsep dasar, arsitektur, serta implementasi IoT dalam dunia nyata. Mari kita jelajahi dunia IoT dan bagaimana teknologi ini membawa perubahan besar bagi masa depan!', 'file', '2025-04-06 12:22:43', '2025-04-06 12:22:43'),
(2, 1, 2, 'Topik 2: Pemrograman dan I/O Arduino', 'Pelajari integrasi input/output menggunakan Arduino IDE dan Serial Monitor. Analisis efisiensi kode dan evaluasi kinerja program untuk skenario IoT sederhana. Rancang solusi pemrograman yang presisi dan inovatif.', 'file', '2025-04-15 01:59:23', '2025-04-15 01:59:23'),
(3, 1, 3, 'Topik 3: Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object', 'Eksplorasi data dari sensor cahaya, suhu, dan objek untuk menciptakan aplikasi responsif. Evaluasi performa sistem sensor melalui analisis data. Rancang aplikasi yang mengintegrasikan sensor secara optimal.', 'file', '2025-04-15 01:59:23', '2025-04-15 01:59:23'),
(4, 1, 4, 'Topik 4: Aktuator: Cahaya, Bunyi, dan Motor', 'Kendalikan aktuator seperti LED RGB, buzzer, dan servo untuk membangun sistem yang dinamis. Evaluasi performa sistem kontrol berbasis aktuator. Rancang aplikasi IoT yang mengintegrasikan aktuator dengan tepat.', 'file', '2025-04-15 01:59:23', '2025-04-15 01:59:23'),
(5, 1, 5, 'Topik 5: Support', 'Pahami cara kerja relay dan keypad dalam sistem kontrol yang cerdas. Evaluasi performa konfigurasi sistem berbasis relay dan keypad. Rancang sistem kontrol yang responsif dan sesuai spesifikasi.', 'file', '2025-04-15 01:59:23', '2025-04-15 01:59:23'),
(6, 1, 6, 'Topik 6: Jaringan Komunikasi', 'Analisis efisiensi jaringan komunikasi IoT seperti Wi-Fi, MQTT, dan LoRaWAN. Evaluasi performa protokol jaringan untuk aplikasi IoT. Rancang solusi komunikasi yang terintegrasi dan fungsional.', 'file', '2025-04-15 01:59:23', '2025-04-15 01:59:23'),
(7, 1, 7, 'Topik 7: Aplikasi Platform IoT', 'Dalam era digital yang semakin berkembang pesat, Internet of Things (IoT) telah menjadi salah satu teknologi yang memiliki dampak besar terhadap berbagai sektor, seperti industri, rumah tangga, dan kesehatan. IoT memungkinkan perangkat-perangkat fisik untuk saling terhubung dan berkomunikasi melalui jaringan internet, menciptakan ekosistem yang lebih cerdas dan efisien. Pada materi ini, kita akan membahas dua platform yang sangat populer dalam implementasi IoT, yaitu Blynk dan ThingSpeak. Blynk merupakan platform yang menyediakan antarmuka pengguna yang mudah digunakan untuk membangun aplikasi IoT tanpa perlu menulis banyak kode. Di sisi lain, ThingSpeak adalah platform berbasis cloud yang memungkinkan pengumpulan dan analisis data sensor secara real-time, sangat cocok untuk aplikasi IoT berbasis data. Melalui pemahaman mendalam mengenai kedua platform ini, diharapkan peserta dapat mengembangkan solusi IoT yang lebih efektif dan inovatif. Kami berharap materi ini dapat memberikan wawasan yang berguna serta memotivasi para peserta untuk mengeksplorasi lebih jauh potensi besar yang ditawarkan oleh teknologi IoT.', 'file', '2025-04-15 01:59:23', '2025-04-15 01:59:23');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_resources`
--

CREATE TABLE `mdl_resources` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `type` enum('pdf','video','link') NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `mdl_section`
--

CREATE TABLE `mdl_section` (
  `id` bigint(20) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `sort_order` int(5) NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_section`
--

INSERT INTO `mdl_section` (`id`, `course_id`, `title`, `description`, `sort_order`, `visible`, `created_at`, `updated_at`) VALUES
(1, 1, 'Topik 1: Pengantar IoT & Arsitektur IoT ', 'Internet of Things (IoT) menghubungkan dunia fisik dan digital melalui perangkat keras dan perangkat lunak yang terintegrasi. Anda akan mempelajari konsep dasar IoT dan bagaimana perangkat saling berkomunikasi untuk menciptakan ekosistem yang lebih pintar. Anda akan menganalisis peran sensor, jaringan, dan aplikasi IoT dalam berbagai bidang seperti rumah pintar, kesehatan, dan transportasi.', 1, 1, NULL, NULL),
(2, 1, 'Topik 2: Pemrograman dan I/O Arduino', 'Pelajari integrasi input/output menggunakan Arduino IDE dan Serial Monitor. Analisis efisiensi kode dan evaluasi kinerja program untuk skenario IoT sederhana. Rancang solusi pemrograman yang presisi dan inovatif dengan memanfaatkan sensor dan aktuator secara optimal. Materi ini juga mencakup teknik debugging, penggunaan library eksternal, serta pendekatan modular dalam pengembangan program berbasis Arduino.', 1, 1, NULL, NULL),
(3, 1, 'Topik 3: Sensor Cahaya, Sensor Suhu & Kelembaban dan Sensor Deteksi Object', 'Eksplorasi data dari sensor cahaya, suhu, dan objek untuk menciptakan aplikasi responsif. Evaluasi performa sistem sensor melalui analisis data. Rancang aplikasi yang mengintegrasikan sensor secara optimal.', 1, 1, NULL, NULL),
(4, 1, 'Topik 4: Actuator LED RGB, Seven Segment, LCD, Buzzer, FAN dan Servo', 'Kendalikan aktuator seperti LED RGB, buzzer, dan servo untuk membangun sistem yang dinamis. Evaluasi performa sistem kontrol berbasis aktuator. Rancang aplikasi IoT yang mengintegrasikan aktuator dengan tepat.', 1, 1, NULL, NULL),
(5, 1, 'Topik 5: Support Push Button, Keypad, Relay dan Real Time Clock', 'Pahami cara kerja relay dan keypad dalam sistem kontrol yang cerdas. Evaluasi performa konfigurasi sistem berbasis relay dan keypad. Rancang sistem kontrol yang responsif dan sesuai spesifikasi.\r\n', 1, 1, NULL, NULL),
(6, 1, 'Topik 6: Jaringan Komunikasi IoT: RFID dan Wifi ESP8266', 'Analisis efisiensi jaringan komunikasi IoT seperti Wi-Fi, MQTT, dan LoRaWAN. Evaluasi performa protokol jaringan untuk aplikasi IoT. Rancang solusi komunikasi yang terintegrasi dan fungsional.', 1, 1, NULL, NULL),
(7, 1, 'Topik 7: Aplikasi Platform IoT berbasis Cloud: Blynk dan Thingspeak', 'Pada materi ini, kita akan membahas dua platform yang sangat populer dalam implementasi IoT, yaitu Blynk dan ThingSpeak. Blynk merupakan platform yang menyediakan antarmuka pengguna yang mudah digunakan untuk membangun aplikasi IoT tanpa perlu menulis banyak kode. Di sisi lain, ThingSpeak adalah platform berbasis cloud yang memungkinkan pengumpulan dan analisis data sensor secara real-time, sangat cocok untuk aplikasi IoT berbasis data.\r\nMelalui pemahaman mendalam mengenai kedua platform ini, diharapkan peserta dapat mengembangkan solusi IoT yang lebih efektif dan inovatif. Kami berharap materi ini dapat memberikan wawasan yang berguna serta memotivasi para peserta untuk mengeksplorasi lebih jauh potensi besar yang ditawarkan oleh teknologi IoT.', 1, 1, NULL, NULL),
(8, 1, 'Topik 8: Koneksi IoT ke Cloud Computing', 'Mahasiswa memahami konsep cloud computing dan cara menghubungkan perangkat IoT ke cloud. Pembahasan mencakup pengenalan layanan cloud populer seperti Firebase, AWS IoT, atau Blynk, serta bagaimana data dari sensor dapat dikirim dan dianalisis secara real-time melalui platform cloud. Mahasiswa juga akan mempelajari dasar keamanan data, autentikasi perangkat, dan implementasi arsitektur IoT yang terhubung ke cloud secara efisien dan skalabel. Selain itu, topik ini juga membahas integrasi dashboard visualisasi data dan pemanfaatan cloud untuk automasi serta pengambilan keputusan berbasis data, yang menjadi inti dari transformasi digital berbasis IoT.', 1, 1, NULL, NULL),
(9, 1, 'Topik 9: Internet of Things dan Big Data', 'Mahasiswa memahami bagaimana data yang dihasilkan IoT dapat dianalisis menggunakan Big Data.\r\n', 1, 1, NULL, NULL),
(10, 1, 'Topik 10: Keamanan dalam IoT', 'Mahasiswa memahami risiko keamanan dalam IoT dan cara mengatasinya, seperti enkripsi data dan firewall.\r\n', 1, 1, NULL, NULL),
(11, 1, 'Topik 11: IoT dan Kecerdasan Buatan (AIoT)', 'Mahasiswa memahami integrasi IoT dengan AI untuk aplikasi smart home, smart city, dan industri 4.0.\r\n', 1, 1, NULL, NULL),
(12, 1, 'Topik 12: Edge Computing dalam IoT', 'Mahasiswa memahami konsep Edge Computing dan bagaimana menggunakannya dalam IoT untuk pemrosesan data lebih cepat.\r\n', 1, 1, NULL, NULL),
(13, 1, 'Topik 13: Implementasi IoT pada Smart Home', 'Mahasiswa memahami dan menerapkan sistem IoT untuk otomatisasi rumah pintar.\r\n', 1, 1, NULL, NULL),
(14, 1, 'Topik 14: Implementasi IoT pada Smart Agriculture', 'Mahasiswa memahami dan menerapkan IoT untuk pertanian cerdas, seperti pemantauan kelembaban tanah dan suhu udara.\r\n', 1, 1, NULL, NULL),
(15, 1, 'Topik 15: Implementasi IoT pada Smart Healthcare', 'Mahasiswa memahami penggunaan IoT dalam dunia kesehatan, seperti monitoring pasien secara real-time.\r\n', 1, 1, NULL, NULL),
(16, 1, 'Topik 16: Proyek Akhir IoT', 'Mahasiswa membuat proyek IoT sederhana sebagai implementasi dari semua materi yang telah dipelajari.', 1, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_sensing`
--

CREATE TABLE `mdl_sensing` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `section_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content_type` enum('quiz','h5p','forum','assignment','file','resource','video') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_sensing`
--

INSERT INTO `mdl_sensing` (`id`, `course_id`, `section_id`, `title`, `description`, `content_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Topik 1: Pengantar IoT & Arsitektur IoT', 'Di era digital saat ini, teknologi semakin berkembang pesat dan menghadirkan inovasi yang mengubah cara kita hidup dan bekerja. Salah satu teknologi yang berperan besar dalam transformasi ini adalah Internet of Things (IoT). IoT menghubungkan berbagai perangkat fisik ke internet, memungkinkan mereka untuk saling berkomunikasi, mengumpulkan data, dan merespons secara otomatis tanpa intervensi manusia. Dari smart home yang dapat dikendalikan melalui smartphone hingga sistem industri otomatis yang meningkatkan efisiensi produksi, IoT telah menjadi bagian tak terpisahkan dari kehidupan modern. Dengan memahami IoT, kita dapat menciptakan solusi inovatif untuk berbagai sektor, seperti kesehatan, transportasi, pertanian, dan manufaktur. Mata kuliah ini akan membahas konsep dasar, arsitektur, serta implementasi IoT dalam dunia nyata. Mari kita jelajahi dunia IoT dan bagaimana teknologi ini membawa perubahan besar bagi masa depan!', 'file', '2025-04-07 05:27:25', '2025-04-07 05:27:25'),
(2, 1, 2, 'Topik 2: Pemrograman dan I/O Arduino', 'Pelajari integrasi input/output menggunakan Arduino IDE dan Serial Monitor. Analisis efisiensi kode dan evaluasi kinerja program untuk skenario IoT sederhana. Rancang solusi pemrograman yang presisi dan inovatif.', 'file', '2025-04-15 02:08:53', '2025-04-15 02:08:53'),
(3, 1, 3, 'Topik 3: Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object', 'Eksplorasi data dari sensor cahaya, suhu, dan objek untuk menciptakan aplikasi responsif. Evaluasi performa sistem sensor melalui analisis data. Rancang aplikasi yang mengintegrasikan sensor secara optimal.', 'file', '2025-04-15 02:08:53', '2025-04-15 02:08:53'),
(4, 1, 4, 'Topik 4: Aktuator: Cahaya, Bunyi, dan Motor', 'Kendalikan aktuator seperti LED RGB, buzzer, dan servo untuk membangun sistem yang dinamis. Evaluasi performa sistem kontrol berbasis aktuator. Rancang aplikasi IoT yang mengintegrasikan aktuator dengan tepat.', 'file', '2025-04-15 02:08:53', '2025-04-15 02:08:53'),
(5, 1, 5, 'Topik 5: Support', 'Pahami cara kerja relay dan keypad dalam sistem kontrol yang cerdas. Evaluasi performa konfigurasi sistem berbasis relay dan keypad. Rancang sistem kontrol yang responsif dan sesuai spesifikasi.', 'file', '2025-04-15 02:08:53', '2025-04-15 02:08:53'),
(6, 1, 6, 'Topik 6: Jaringan Komunikasi', 'Analisis efisiensi jaringan komunikasi IoT seperti Wi-Fi, MQTT, dan LoRaWAN. Evaluasi performa protokol jaringan untuk aplikasi IoT. Rancang solusi komunikasi yang terintegrasi dan fungsional.', 'file', '2025-04-15 02:08:53', '2025-04-15 02:08:53'),
(7, 1, 7, 'Topik 7: Aplikasi Platform IoT', 'Dalam era digital yang semakin berkembang pesat, Internet of Things (IoT) telah menjadi salah satu teknologi yang memiliki dampak besar terhadap berbagai sektor, seperti industri, rumah tangga, dan kesehatan. IoT memungkinkan perangkat-perangkat fisik untuk saling terhubung dan berkomunikasi melalui jaringan internet, menciptakan ekosistem yang lebih cerdas dan efisien. Pada materi ini, kita akan membahas dua platform yang sangat populer dalam implementasi IoT, yaitu Blynk dan ThingSpeak. Blynk merupakan platform yang menyediakan antarmuka pengguna yang mudah digunakan untuk membangun aplikasi IoT tanpa perlu menulis banyak kode. Di sisi lain, ThingSpeak adalah platform berbasis cloud yang memungkinkan pengumpulan dan analisis data sensor secara real-time, sangat cocok untuk aplikasi IoT berbasis data. Melalui pemahaman mendalam mengenai kedua platform ini, diharapkan peserta dapat mengembangkan solusi IoT yang lebih efektif dan inovatif. Kami berharap materi ini dapat memberikan wawasan yang berguna serta memotivasi para peserta untuk mengeksplorasi lebih jauh potensi besar yang ditawarkan oleh teknologi IoT.', 'file', '2025-04-15 02:08:53', '2025-04-15 02:08:53');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_sequential`
--

CREATE TABLE `mdl_sequential` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `section_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content_type` enum('quiz','h5p','forum','assignment','file','resource','video') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_sequential`
--

INSERT INTO `mdl_sequential` (`id`, `course_id`, `section_id`, `title`, `description`, `content_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Topik 1: Pengantar IoT & Arsitektur IoT', 'Di era digital saat ini, teknologi semakin berkembang pesat dan menghadirkan inovasi yang mengubah cara kita hidup dan bekerja. Salah satu teknologi yang berperan besar dalam transformasi ini adalah Internet of Things (IoT). IoT menghubungkan berbagai perangkat fisik ke internet, memungkinkan mereka untuk saling berkomunikasi, mengumpulkan data, dan merespons secara otomatis tanpa intervensi manusia. Dari smart home yang dapat dikendalikan melalui smartphone hingga sistem industri otomatis yang meningkatkan efisiensi produksi, IoT telah menjadi bagian tak terpisahkan dari kehidupan modern. Dengan memahami IoT, kita dapat menciptakan solusi inovatif untuk berbagai sektor, seperti kesehatan, transportasi, pertanian, dan manufaktur. Mata kuliah ini akan membahas konsep dasar, arsitektur, serta implementasi IoT dalam dunia nyata. Mari kita jelajahi dunia IoT dan bagaimana teknologi ini membawa perubahan besar bagi masa depan!', 'file', '2025-04-09 09:51:23', '2025-04-09 09:51:23'),
(2, 1, 2, 'Topik 2: Pemrograman dan I/O Arduino', 'Pelajari integrasi input/output menggunakan Arduino IDE dan Serial Monitor. Analisis efisiensi kode dan evaluasi kinerja program untuk skenario IoT sederhana. Rancang solusi pemrograman yang presisi dan inovatif.', 'file', '2025-04-15 02:17:36', '2025-04-15 02:17:36'),
(3, 1, 3, 'Topik 3: Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object', 'Eksplorasi data dari sensor cahaya, suhu, dan objek untuk menciptakan aplikasi responsif. Evaluasi performa sistem sensor melalui analisis data. Rancang aplikasi yang mengintegrasikan sensor secara optimal.', 'file', '2025-04-15 02:17:36', '2025-04-15 02:17:36'),
(4, 1, 4, 'Topik 4: Aktuator: Cahaya, Bunyi, dan Motor', 'Kendalikan aktuator seperti LED RGB, buzzer, dan servo untuk membangun sistem yang dinamis. Evaluasi performa sistem kontrol berbasis aktuator. Rancang aplikasi IoT yang mengintegrasikan aktuator dengan tepat.', 'file', '2025-04-15 02:17:36', '2025-04-15 02:17:36'),
(5, 1, 5, 'Topik 5: Support', 'Pahami cara kerja relay dan keypad dalam sistem kontrol yang cerdas. Evaluasi performa konfigurasi sistem berbasis relay dan keypad. Rancang sistem kontrol yang responsif dan sesuai spesifikasi.', 'file', '2025-04-15 02:17:36', '2025-04-15 02:17:36'),
(6, 1, 6, 'Topik 6: Jaringan Komunikasi', 'Analisis efisiensi jaringan komunikasi IoT seperti Wi-Fi, MQTT, dan LoRaWAN. Evaluasi performa protokol jaringan untuk aplikasi IoT. Rancang solusi komunikasi yang terintegrasi dan fungsional.', 'file', '2025-04-15 02:17:36', '2025-04-15 02:17:36'),
(7, 1, 7, 'Topik 7: Aplikasi Platform IoT', 'Dalam era digital yang semakin berkembang pesat, Internet of Things (IoT) telah menjadi salah satu teknologi yang memiliki dampak besar terhadap berbagai sektor, seperti industri, rumah tangga, dan kesehatan. IoT memungkinkan perangkat-perangkat fisik untuk saling terhubung dan berkomunikasi melalui jaringan internet, menciptakan ekosistem yang lebih cerdas dan efisien. Pada materi ini, kita akan membahas dua platform yang sangat populer dalam implementasi IoT, yaitu Blynk dan ThingSpeak. Blynk merupakan platform yang menyediakan antarmuka pengguna yang mudah digunakan untuk membangun aplikasi IoT tanpa perlu menulis banyak kode. Di sisi lain, ThingSpeak adalah platform berbasis cloud yang memungkinkan pengumpulan dan analisis data sensor secara real-time, sangat cocok untuk aplikasi IoT berbasis data. Melalui pemahaman mendalam mengenai kedua platform ini, diharapkan peserta dapat mengembangkan solusi IoT yang lebih efektif dan inovatif. Kami berharap materi ini dapat memberikan wawasan yang berguna serta memotivasi para peserta untuk mengeksplorasi lebih jauh potensi besar yang ditawarkan oleh teknologi IoT.', 'file', '2025-04-15 02:17:36', '2025-04-15 02:17:36');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_user_learning_styles`
--

CREATE TABLE `mdl_user_learning_styles` (
  `id` bigint(10) NOT NULL,
  `user_id` bigint(10) UNSIGNED NOT NULL,
  `dimension` varchar(255) NOT NULL,
  `a_count` int(5) NOT NULL,
  `b_count` int(5) NOT NULL,
  `learning_style_id` bigint(10) DEFAULT NULL,
  `final_score` varchar(15) DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'Balanced',
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_user_learning_styles`
--

INSERT INTO `mdl_user_learning_styles` (`id`, `user_id`, `dimension`, `a_count`, `b_count`, `learning_style_id`, `final_score`, `category`, `description`) VALUES
(57, 1, 'ACT/REF', 5, 6, NULL, '1Reflective', 'Balanced', NULL),
(58, 1, 'SNS/INT', 1, 10, NULL, '9Intuitive', 'Strong', NULL),
(59, 1, 'VIS/VRB', 8, 3, NULL, '5Verbal', 'Moderate', NULL),
(60, 1, 'SEQ/GLO', 6, 5, NULL, '1Global', 'Balanced', NULL),
(61, 2, 'ACT/REF', 8, 3, NULL, '5Reflective', 'Moderate', NULL),
(62, 2, 'SNS/INT', 8, 3, NULL, '5Intuitive', 'Moderate', NULL),
(63, 2, 'VIS/VRB', 9, 2, NULL, '7Verbal', 'Moderate', NULL),
(64, 2, 'SEQ/GLO', 8, 3, NULL, '5Global', 'Moderate', NULL),
(77, 3, 'ACT/REF', 9, 2, NULL, '7Active', 'Moderate', NULL),
(78, 3, 'SNS/INT', 6, 5, NULL, '1Sensing', 'Balanced', NULL),
(79, 3, 'VIS/VRB', 7, 4, NULL, '3Visual', 'Balanced', NULL),
(80, 3, 'SEQ/GLO', 8, 3, NULL, '5Sequential', 'Moderate', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `mdl_verbal`
--

CREATE TABLE `mdl_verbal` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `section_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content_type` enum('quiz','h5p','forum','assignment','file','resource','video') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_verbal`
--

INSERT INTO `mdl_verbal` (`id`, `course_id`, `section_id`, `title`, `description`, `content_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Topik 1: Pengantar IoT & Arsitektur IoT', 'Di era digital saat ini, teknologi semakin berkembang pesat dan menghadirkan inovasi yang mengubah cara kita hidup dan bekerja. Salah satu teknologi yang berperan besar dalam transformasi ini adalah Internet of Things (IoT). IoT menghubungkan berbagai perangkat fisik ke internet, memungkinkan mereka untuk saling berkomunikasi, mengumpulkan data, dan merespons secara otomatis tanpa intervensi manusia. Dari smart home yang dapat dikendalikan melalui smartphone hingga sistem industri otomatis yang meningkatkan efisiensi produksi, IoT telah menjadi bagian tak terpisahkan dari kehidupan modern. Dengan memahami IoT, kita dapat menciptakan solusi inovatif untuk berbagai sektor, seperti kesehatan, transportasi, pertanian, dan manufaktur. Mata kuliah ini akan membahas konsep dasar, arsitektur, serta implementasi IoT dalam dunia nyata. Mari kita jelajahi dunia IoT dan bagaimana teknologi ini membawa perubahan besar bagi masa depan!', 'file', '2025-04-08 11:25:12', '2025-04-08 11:25:12'),
(2, 1, 2, 'Topik 2: Pemrograman dan I/O Arduino', 'Pelajari integrasi input/output menggunakan Arduino IDE dan Serial Monitor. Analisis efisiensi kode dan evaluasi kinerja program untuk skenario IoT sederhana. Rancang solusi pemrograman yang presisi dan inovatif.', 'file', '2025-04-15 02:16:11', '2025-04-15 02:16:11'),
(3, 1, 3, 'Topik 3: Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object', 'Eksplorasi data dari sensor cahaya, suhu, dan objek untuk menciptakan aplikasi responsif. Evaluasi performa sistem sensor melalui analisis data. Rancang aplikasi yang mengintegrasikan sensor secara optimal.', 'file', '2025-04-15 02:16:11', '2025-04-15 02:16:11'),
(4, 1, 4, 'Topik 4: Aktuator: Cahaya, Bunyi, dan Motor', 'Kendalikan aktuator seperti LED RGB, buzzer, dan servo untuk membangun sistem yang dinamis. Evaluasi performa sistem kontrol berbasis aktuator. Rancang aplikasi IoT yang mengintegrasikan aktuator dengan tepat.', 'file', '2025-04-15 02:16:11', '2025-04-15 02:16:11'),
(5, 1, 5, 'Topik 5: Support', 'Pahami cara kerja relay dan keypad dalam sistem kontrol yang cerdas. Evaluasi performa konfigurasi sistem berbasis relay dan keypad. Rancang sistem kontrol yang responsif dan sesuai spesifikasi.', 'file', '2025-04-15 02:16:11', '2025-04-15 02:16:11'),
(6, 1, 6, 'Topik 6: Jaringan Komunikasi', 'Analisis efisiensi jaringan komunikasi IoT seperti Wi-Fi, MQTT, dan LoRaWAN. Evaluasi performa protokol jaringan untuk aplikasi IoT. Rancang solusi komunikasi yang terintegrasi dan fungsional.', 'file', '2025-04-15 02:16:11', '2025-04-15 02:16:11'),
(7, 1, 7, 'Topik 7: Aplikasi Platform IoT', 'Dalam era digital yang semakin berkembang pesat, Internet of Things (IoT) telah menjadi salah satu teknologi yang memiliki dampak besar terhadap berbagai sektor, seperti industri, rumah tangga, dan kesehatan. IoT memungkinkan perangkat-perangkat fisik untuk saling terhubung dan berkomunikasi melalui jaringan internet, menciptakan ekosistem yang lebih cerdas dan efisien. Pada materi ini, kita akan membahas dua platform yang sangat populer dalam implementasi IoT, yaitu Blynk dan ThingSpeak. Blynk merupakan platform yang menyediakan antarmuka pengguna yang mudah digunakan untuk membangun aplikasi IoT tanpa perlu menulis banyak kode. Di sisi lain, ThingSpeak adalah platform berbasis cloud yang memungkinkan pengumpulan dan analisis data sensor secara real-time, sangat cocok untuk aplikasi IoT berbasis data. Melalui pemahaman mendalam mengenai kedua platform ini, diharapkan peserta dapat mengembangkan solusi IoT yang lebih efektif dan inovatif. Kami berharap materi ini dapat memberikan wawasan yang berguna serta memotivasi para peserta untuk mengeksplorasi lebih jauh potensi besar yang ditawarkan oleh teknologi IoT.', 'file', '2025-04-15 02:16:11', '2025-04-15 02:16:11');

-- --------------------------------------------------------

--
-- Table structure for table `mdl_visual`
--

CREATE TABLE `mdl_visual` (
  `id` bigint(10) NOT NULL,
  `course_id` bigint(10) NOT NULL,
  `section_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `content_type` enum('quiz','h5p','forum','assignment','file','resource','video') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mdl_visual`
--

INSERT INTO `mdl_visual` (`id`, `course_id`, `section_id`, `title`, `description`, `content_type`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Topik 1: Pengantar IoT & Arsitektur IoT', 'Di era digital saat ini, teknologi semakin berkembang pesat dan menghadirkan inovasi yang mengubah cara kita hidup dan bekerja. Salah satu teknologi yang berperan besar dalam transformasi ini adalah Internet of Things (IoT). IoT menghubungkan berbagai perangkat fisik ke internet, memungkinkan mereka untuk saling berkomunikasi, mengumpulkan data, dan merespons secara otomatis tanpa intervensi manusia. Dari smart home yang dapat dikendalikan melalui smartphone hingga sistem industri otomatis yang meningkatkan efisiensi produksi, IoT telah menjadi bagian tak terpisahkan dari kehidupan modern. Dengan memahami IoT, kita dapat menciptakan solusi inovatif untuk berbagai sektor, seperti kesehatan, transportasi, pertanian, dan manufaktur. Mata kuliah ini akan membahas konsep dasar, arsitektur, serta implementasi IoT dalam dunia nyata. Mari kita jelajahi dunia IoT dan bagaimana teknologi ini membawa perubahan besar bagi masa depan!', 'video', '2025-04-07 09:23:34', '2025-04-07 09:23:34'),
(2, 1, 2, 'Topik 2: Pemrograman dan I/O Arduino', 'Pelajari integrasi input/output menggunakan Arduino IDE dan Serial Monitor. Analisis efisiensi kode dan evaluasi kinerja program untuk skenario IoT sederhana. Rancang solusi pemrograman yang presisi dan inovatif.', 'file', '2025-04-15 02:14:44', '2025-04-15 02:14:44'),
(3, 1, 3, 'Topik 3: Sensor Cahaya, Sensor Suhu & Kelembaban, dan Sensor Deteksi Object', 'Eksplorasi data dari sensor cahaya, suhu, dan objek untuk menciptakan aplikasi responsif. Evaluasi performa sistem sensor melalui analisis data. Rancang aplikasi yang mengintegrasikan sensor secara optimal.', 'file', '2025-04-15 02:14:44', '2025-04-15 02:14:44'),
(4, 1, 4, 'Topik 4: Aktuator: Cahaya, Bunyi, dan Motor', 'Kendalikan aktuator seperti LED RGB, buzzer, dan servo untuk membangun sistem yang dinamis. Evaluasi performa sistem kontrol berbasis aktuator. Rancang aplikasi IoT yang mengintegrasikan aktuator dengan tepat.', 'file', '2025-04-15 02:14:44', '2025-04-15 02:14:44'),
(5, 1, 5, 'Topik 5: Support', 'Pahami cara kerja relay dan keypad dalam sistem kontrol yang cerdas. Evaluasi performa konfigurasi sistem berbasis relay dan keypad. Rancang sistem kontrol yang responsif dan sesuai spesifikasi.', 'file', '2025-04-15 02:14:44', '2025-04-15 02:14:44'),
(6, 1, 6, 'Topik 6: Jaringan Komunikasi', 'Analisis efisiensi jaringan komunikasi IoT seperti Wi-Fi, MQTT, dan LoRaWAN. Evaluasi performa protokol jaringan untuk aplikasi IoT. Rancang solusi komunikasi yang terintegrasi dan fungsional.', 'file', '2025-04-15 02:14:44', '2025-04-15 02:14:44'),
(7, 1, 7, 'Topik 7: Aplikasi Platform IoT', 'Dalam era digital yang semakin berkembang pesat, Internet of Things (IoT) telah menjadi salah satu teknologi yang memiliki dampak besar terhadap berbagai sektor, seperti industri, rumah tangga, dan kesehatan. IoT memungkinkan perangkat-perangkat fisik untuk saling terhubung dan berkomunikasi melalui jaringan internet, menciptakan ekosistem yang lebih cerdas dan efisien. Pada materi ini, kita akan membahas dua platform yang sangat populer dalam implementasi IoT, yaitu Blynk dan ThingSpeak. Blynk merupakan platform yang menyediakan antarmuka pengguna yang mudah digunakan untuk membangun aplikasi IoT tanpa perlu menulis banyak kode. Di sisi lain, ThingSpeak adalah platform berbasis cloud yang memungkinkan pengumpulan dan analisis data sensor secara real-time, sangat cocok untuk aplikasi IoT berbasis data. Melalui pemahaman mendalam mengenai kedua platform ini, diharapkan peserta dapat mengembangkan solusi IoT yang lebih efektif dan inovatif. Kami berharap materi ini dapat memberikan wawasan yang berguna serta memotivasi para peserta untuk mengeksplorasi lebih jauh potensi besar yang ditawarkan oleh teknologi IoT.', 'file', '2025-04-15 02:14:44', '2025-04-15 02:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2025_04_15_110153_add_deleted_at_to_mdl_files_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('2172036@maranatha.ac.id', '$2y$10$Zjnu3BFtVVLI4fKOWRoANu9bgMydaZ/BCU3SZEzA4O0w2blqV/XXC', '2025-03-10 02:38:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `image`, `level`, `remember_token`, `created_at`, `updated_at`, `last_login_at`) VALUES
(1, 'Frangky Hernandez', '2172036@maranatha.ac.id', NULL, '$2y$10$lO15dyppO.m5qxwoqs7de.wsn1ZrBryMFa3sk2tP8CBi2EyQUKFWK', 'profile_1_1745888675.jpg', 1, NULL, '2025-03-09 22:21:49', '2025-05-02 04:54:24', '2025-05-02 04:54:24'),
(2, 'Rizky Jeremia Simanjuntak', '2172039@maranatha.ac.id', NULL, '$2y$10$uBtE5Wleji8GMZG1G1yr3.LyAqpNaH.KngJbFjN1b9JkLMN0IzPvG', '', 1, NULL, '2025-03-10 02:10:57', '2025-05-01 05:08:20', '2025-05-01 05:08:20'),
(3, 'Kristiani Nainggolan', '2172044@maranatha.ac.id', NULL, '$2y$10$fPIvnHHCuB/Xit4VRbHF0el3UWyd.t040CjrJHorSbm8fVUbQv3Ui', '', 1, NULL, NULL, '2025-05-01 10:53:32', '2025-05-01 10:53:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `content_recommendation`
--
ALTER TABLE `content_recommendation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `content_id` (`content_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `mdl_active`
--
ALTER TABLE `mdl_active`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `mdl_active_ibfk_2` (`section_id`);

--
-- Indexes for table `mdl_assign`
--
ALTER TABLE `mdl_assign`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `mdl_assignfeedback_comments`
--
ALTER TABLE `mdl_assignfeedback_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `submission_id` (`submission_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mdl_assign_grades`
--
ALTER TABLE `mdl_assign_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assign_id` (`assign_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mdl_assign_submission`
--
ALTER TABLE `mdl_assign_submission`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assign_id` (`assign_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mdl_course`
--
ALTER TABLE `mdl_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_course_modules`
--
ALTER TABLE `mdl_course_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_course_subtopik`
--
ALTER TABLE `mdl_course_subtopik`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mdl_course_subtopik_section_id_foreign` (`section_id`);

--
-- Indexes for table `mdl_files`
--
ALTER TABLE `mdl_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `mdl_folder`
--
ALTER TABLE `mdl_folder`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `mdl_forum`
--
ALTER TABLE `mdl_forum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `mdl_forum_ibfk_2` (`section_id`);

--
-- Indexes for table `mdl_forum_posts`
--
ALTER TABLE `mdl_forum_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `forum_id` (`forum_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mdl_global`
--
ALTER TABLE `mdl_global`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `mdl_global_ibfk_2` (`section_id`);

--
-- Indexes for table `mdl_h5p`
--
ALTER TABLE `mdl_h5p`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `mdl_intuitive`
--
ALTER TABLE `mdl_intuitive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `mdl_intuitive_ibfk_2` (`section_id`);

--
-- Indexes for table `mdl_learning_styles`
--
ALTER TABLE `mdl_learning_styles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_quiz`
--
ALTER TABLE `mdl_quiz`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mld_quiz_ibfk_1` (`course_id`);

--
-- Indexes for table `mdl_quiz_answers`
--
ALTER TABLE `mdl_quiz_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mdl_quiz_attempts`
--
ALTER TABLE `mdl_quiz_attempts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `mdl_quiz_grades`
--
ALTER TABLE `mdl_quiz_grades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `quiz_id` (`quiz_id`),
  ADD KEY `attempt_id` (`attempt`);

--
-- Indexes for table `mdl_quiz_question`
--
ALTER TABLE `mdl_quiz_question`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_id` (`quiz_id`);

--
-- Indexes for table `mdl_reflective`
--
ALTER TABLE `mdl_reflective`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `mdl_reflective_ibfk_2` (`section_id`);

--
-- Indexes for table `mdl_resources`
--
ALTER TABLE `mdl_resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `mdl_section`
--
ALTER TABLE `mdl_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`);

--
-- Indexes for table `mdl_sensing`
--
ALTER TABLE `mdl_sensing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `mdl_sensing_ibfk_2` (`section_id`);

--
-- Indexes for table `mdl_sequential`
--
ALTER TABLE `mdl_sequential`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `mdl_sequential_ibfk_2` (`section_id`);

--
-- Indexes for table `mdl_user_learning_styles`
--
ALTER TABLE `mdl_user_learning_styles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `learning_style_id` (`learning_style_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `mdl_verbal`
--
ALTER TABLE `mdl_verbal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `mdl_verbal_ibfk_2` (`section_id`);

--
-- Indexes for table `mdl_visual`
--
ALTER TABLE `mdl_visual`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `mdl_visual_ibfk_2` (`section_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `content_recommendation`
--
ALTER TABLE `content_recommendation`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_active`
--
ALTER TABLE `mdl_active`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mdl_assign`
--
ALTER TABLE `mdl_assign`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `mdl_assignfeedback_comments`
--
ALTER TABLE `mdl_assignfeedback_comments`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assign_grades`
--
ALTER TABLE `mdl_assign_grades`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_assign_submission`
--
ALTER TABLE `mdl_assign_submission`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `mdl_course`
--
ALTER TABLE `mdl_course`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `mdl_course_modules`
--
ALTER TABLE `mdl_course_modules`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_course_subtopik`
--
ALTER TABLE `mdl_course_subtopik`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_files`
--
ALTER TABLE `mdl_files`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=235;

--
-- AUTO_INCREMENT for table `mdl_folder`
--
ALTER TABLE `mdl_folder`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `mdl_forum`
--
ALTER TABLE `mdl_forum`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `mdl_forum_posts`
--
ALTER TABLE `mdl_forum_posts`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `mdl_global`
--
ALTER TABLE `mdl_global`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mdl_h5p`
--
ALTER TABLE `mdl_h5p`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_intuitive`
--
ALTER TABLE `mdl_intuitive`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mdl_learning_styles`
--
ALTER TABLE `mdl_learning_styles`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mdl_quiz`
--
ALTER TABLE `mdl_quiz`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `mdl_quiz_answers`
--
ALTER TABLE `mdl_quiz_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `mdl_quiz_attempts`
--
ALTER TABLE `mdl_quiz_attempts`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `mdl_quiz_grades`
--
ALTER TABLE `mdl_quiz_grades`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `mdl_quiz_question`
--
ALTER TABLE `mdl_quiz_question`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `mdl_reflective`
--
ALTER TABLE `mdl_reflective`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `mdl_resources`
--
ALTER TABLE `mdl_resources`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mdl_section`
--
ALTER TABLE `mdl_section`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `mdl_sensing`
--
ALTER TABLE `mdl_sensing`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mdl_sequential`
--
ALTER TABLE `mdl_sequential`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mdl_user_learning_styles`
--
ALTER TABLE `mdl_user_learning_styles`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `mdl_verbal`
--
ALTER TABLE `mdl_verbal`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mdl_visual`
--
ALTER TABLE `mdl_visual`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `content_recommendation`
--
ALTER TABLE `content_recommendation`
  ADD CONSTRAINT `content_recommendation_ibfk_1` FOREIGN KEY (`content_id`) REFERENCES `mdl_course_modules` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_active`
--
ALTER TABLE `mdl_active`
  ADD CONSTRAINT `mdl_active_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_active_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mdl_assign`
--
ALTER TABLE `mdl_assign`
  ADD CONSTRAINT `mdl_assign_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_assignfeedback_comments`
--
ALTER TABLE `mdl_assignfeedback_comments`
  ADD CONSTRAINT `mdl_assignfeedback_comments_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `mdl_assign_submission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_assignfeedback_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_assign_grades`
--
ALTER TABLE `mdl_assign_grades`
  ADD CONSTRAINT `mdl_assign_grades_ibfk_1` FOREIGN KEY (`assign_id`) REFERENCES `mdl_assign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_assign_grades_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_assign_submission`
--
ALTER TABLE `mdl_assign_submission`
  ADD CONSTRAINT `mdl_assign_submission_ibfk_1` FOREIGN KEY (`assign_id`) REFERENCES `mdl_assign` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_assign_submission_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_course_modules`
--
ALTER TABLE `mdl_course_modules`
  ADD CONSTRAINT `mdl_course_modules_ibfk_1` FOREIGN KEY (`id`) REFERENCES `content_recommendation` (`content_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_course_subtopik`
--
ALTER TABLE `mdl_course_subtopik`
  ADD CONSTRAINT `mdl_course_subtopik_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mdl_files`
--
ALTER TABLE `mdl_files`
  ADD CONSTRAINT `mdl_files_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_folder`
--
ALTER TABLE `mdl_folder`
  ADD CONSTRAINT `mdl_folder_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_forum`
--
ALTER TABLE `mdl_forum`
  ADD CONSTRAINT `mdl_forum_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_forum_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mdl_forum_posts`
--
ALTER TABLE `mdl_forum_posts`
  ADD CONSTRAINT `mdl_forum_posts_ibfk_1` FOREIGN KEY (`forum_id`) REFERENCES `mdl_forum` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_forum_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_global`
--
ALTER TABLE `mdl_global`
  ADD CONSTRAINT `mdl_global_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_global_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mdl_h5p`
--
ALTER TABLE `mdl_h5p`
  ADD CONSTRAINT `mdl_h5p_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_intuitive`
--
ALTER TABLE `mdl_intuitive`
  ADD CONSTRAINT `mdl_intuitive_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_intuitive_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mdl_quiz`
--
ALTER TABLE `mdl_quiz`
  ADD CONSTRAINT `mdl_quiz_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_quiz_attempts`
--
ALTER TABLE `mdl_quiz_attempts`
  ADD CONSTRAINT `mdl_quiz_attempts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_quiz_attempts_ibfk_3` FOREIGN KEY (`quiz_id`) REFERENCES `mdl_quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_quiz_grades`
--
ALTER TABLE `mdl_quiz_grades`
  ADD CONSTRAINT `mdl_quiz_grades_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_quiz_grades_ibfk_3` FOREIGN KEY (`quiz_id`) REFERENCES `mdl_quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_quiz_grades_ibfk_4` FOREIGN KEY (`attempt`) REFERENCES `mdl_quiz_attempts` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_quiz_question`
--
ALTER TABLE `mdl_quiz_question`
  ADD CONSTRAINT `mdl_quiz_question_ibfk_1` FOREIGN KEY (`quiz_id`) REFERENCES `mdl_quiz` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_reflective`
--
ALTER TABLE `mdl_reflective`
  ADD CONSTRAINT `mdl_reflective_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_reflective_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mdl_resources`
--
ALTER TABLE `mdl_resources`
  ADD CONSTRAINT `mdl_resources_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_section`
--
ALTER TABLE `mdl_section`
  ADD CONSTRAINT `mdl_section_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_sensing`
--
ALTER TABLE `mdl_sensing`
  ADD CONSTRAINT `mdl_sensing_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_sensing_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mdl_sequential`
--
ALTER TABLE `mdl_sequential`
  ADD CONSTRAINT `mdl_sequential_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_sequential_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mdl_user_learning_styles`
--
ALTER TABLE `mdl_user_learning_styles`
  ADD CONSTRAINT `mdl_user_learning_styles_ibfk_1` FOREIGN KEY (`learning_style_id`) REFERENCES `mdl_learning_styles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_user_learning_styles_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mdl_verbal`
--
ALTER TABLE `mdl_verbal`
  ADD CONSTRAINT `mdl_verbal_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_verbal_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `mdl_visual`
--
ALTER TABLE `mdl_visual`
  ADD CONSTRAINT `mdl_visual_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `mdl_course` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `mdl_visual_ibfk_2` FOREIGN KEY (`section_id`) REFERENCES `mdl_section` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
