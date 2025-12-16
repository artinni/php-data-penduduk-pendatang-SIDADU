-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2025 at 06:29 AM
-- Server version: 8.0.40
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `datapendatang`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbjenis_surat`
--

CREATE TABLE `tbjenis_surat` (
  `KodeJenis` int NOT NULL,
  `NamaJenis` varchar(100) NOT NULL,
  `Deskripsi` text NOT NULL,
  `DibuatOleh` varchar(50) NOT NULL,
  `Waktu_Dibuat` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `FieldIsian` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbjenis_surat`
--

INSERT INTO `tbjenis_surat` (`KodeJenis`, `NamaJenis`, `Deskripsi`, `DibuatOleh`, `Waktu_Dibuat`, `FieldIsian`) VALUES
(2, 'Surat Pengantar Pindah', 'Adapun Permohonan Pindah WNI yang bersangkutan sebagaimana terlampi. Demikiran Surat Pengantar Pindah ini dibuat untuk dipergunakan sebagaimana mestinya.', 'Admin1', '2025-06-25 03:30:36', '[\"NamaLengkap\",\"JenisKelamin\",\"AlamatSekarang\"]'),
(3, 'SKU (Surat Keterangan Usaha)', 'Surat ini menerangkan bahwa yang bersangkutan benar memiliki usaha yang berdomisili di wilayah kami dan surat ini dibuat untuk melengkapi persyaratan perizinan atau pengajuan modal usaha.', 'Admin1', '2025-06-25 03:32:03', NULL),
(4, 'Surat Keterangan Tidak Mampu', 'Yang bersangkutan benar berdomisili di alamat tersebut dan surat ini dibuat untuk keperluan administrasi kependudukan atau keperluan lainnya yang sah.', 'Admin1', '2025-07-02 10:23:12', NULL),
(14, 'Surat Pengantar Pindah Datang', '222', 'Admin1', '2025-07-03 08:54:08', '[\"NamaLengkap\",\"NoTelp\",\"TempatLahir\"]'),
(15, 'Surat Keterangan Domisili', 'untuk domisili', 'Admin1', '2025-07-03 09:04:40', '[\"NamaLengkap\",\"Agama\",\"ProvinsiAsal\",\"KabAsal\",\"AlamatSekarang\"]'),
(18, 'Surat Permohonan Domisili Pendatang', 'Dengan ini mengajukan permohonan untuk dibuatkan Surat Keterangan Domisili dengan tujuan tersebut diatas. Sekian yang dapat disampaikan, diharapkan agar dapat menyetujui permohonan ini. Terima Kasih', 'Admin1', '2025-07-19 04:29:00', '[\"NamaLengkap\",\"NoTelp\",\"TempatLahir\",\"JenisKelamin\",\"AlamatAsal\",\"AlamatSekarang\"]');

-- --------------------------------------------------------

--
-- Table structure for table `tbkaling`
--

CREATE TABLE `tbkaling` (
  `KodeKaling` int NOT NULL,
  `Username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `NamaLengkap` varchar(40) NOT NULL,
  `Jabatan` varchar(100) DEFAULT NULL,
  `JenisKelamin` varchar(15) NOT NULL,
  `Alamat` varchar(50) NOT NULL,
  `Kelurahan` varchar(100) DEFAULT NULL,
  `Kecamatan` varchar(100) DEFAULT NULL,
  `Kabupaten` varchar(100) DEFAULT NULL,
  `Provinsi` varchar(100) DEFAULT NULL,
  `Telp` varchar(15) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `StatusAktivasi` varchar(20) NOT NULL,
  `JenisAkun` varchar(20) NOT NULL,
  `EmailToken` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbkaling`
--

INSERT INTO `tbkaling` (`KodeKaling`, `Username`, `NamaLengkap`, `Jabatan`, `JenisKelamin`, `Alamat`, `Kelurahan`, `Kecamatan`, `Kabupaten`, `Provinsi`, `Telp`, `Email`, `Password`, `StatusAktivasi`, `JenisAkun`, `EmailToken`) VALUES
(16, '2345654', 'Eka Putra', 'Kepala Lingkungan', 'Laki-laki', 'Jl. Kenangan', '5171020015', '5171020', '5171', '51', '081237939052', 'madeartini425@gmail.com', '$2y$10$X5y1Gvv4BwMO7UxIo8Wh2u9F8XnWd7zkTsK028DVSOO.Q.lKvcwWO', 'Terverifikasi', 'Kaling', ''),
(17, '2345654', 'Krisnayanti Kadek', 'Kepala Lingkungan', 'Perempuan', 'Jl. Kenangan', '5108010014', '5108010', '5108', '51', '081237939052', 'madeartini425@gmail.com', '$2y$10$xwCuQqjrXq5BbB8hFY4rbuX.w8xj1EgILq7zL8M8uJ4VWgbkbpAie', 'Terverifikasi', 'Kaling', ''),
(20, '2315323034', 'Bagus Kencana Putra', 'Kepala Lingkungan 2', 'Laki-laki', 'Jl. Perumahan Taman Unud', '5103010005', '5103010', '5103', '51', '081237939052', 'cutemeowmeow111@gmail.com', '$2y$10$f1LXQA9TVtKxbvFgPA/3q.DjkMvCPbqv/QTsIhwsxaAaO4LA6uyJS', 'Terverifikasi', 'Kaling', ''),
(30, '868750032', 'Kadek Agnesya Dwitira', NULL, 'Perempuan', 'Jl. Taman Paradise ', NULL, NULL, NULL, NULL, '01821989', 'artinnimade425@gmail.com', '$2y$10$YlBt.E95u7NW5Hl9Sgazyelcu0.V/.iurbWWr.2ma/8l2q2jKy7WG', 'Terverifikasi', 'Kaling', '');

-- --------------------------------------------------------

--
-- Table structure for table `tblogin`
--

CREATE TABLE `tblogin` (
  `KodeLogin` int NOT NULL,
  `Username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Password` varchar(100) NOT NULL,
  `NamaLengkap` varchar(40) NOT NULL,
  `JenisAkun` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tblogin`
--

INSERT INTO `tblogin` (`KodeLogin`, `Username`, `Password`, `NamaLengkap`, `JenisAkun`) VALUES
(2, 'Admin1', 'Admin1', 'Administrator Role', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tbpendatang`
--

CREATE TABLE `tbpendatang` (
  `KodePendatang` int NOT NULL,
  `KodePJ` int NOT NULL,
  `NIK` int NOT NULL,
  `NamaLengkap` varchar(100) NOT NULL,
  `NoTelp` varchar(15) NOT NULL,
  `TempatLahir` varchar(50) NOT NULL,
  `TanggalLahir` date NOT NULL,
  `JenisKelamin` varchar(10) NOT NULL,
  `GolonganDarah` varchar(9) NOT NULL,
  `Agama` varchar(9) NOT NULL,
  `ProvinsiAsal` varchar(50) NOT NULL,
  `KabAsal` varchar(50) NOT NULL,
  `KecAsal` varchar(50) NOT NULL,
  `KelAsal` varchar(50) NOT NULL,
  `RT` varchar(9) NOT NULL,
  `RW` varchar(9) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `AlamatAsal` varchar(100) NOT NULL,
  `AlamatSekarang` varchar(100) NOT NULL,
  `Tujuan` varchar(100) NOT NULL,
  `TglMasuk` date NOT NULL,
  `TglKeluar` date NOT NULL,
  `Wilayah` varchar(50) NOT NULL,
  `Foto` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `KTP` varchar(10) NOT NULL,
  `Latitude` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `Longitude` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `StatusVerifikasi` varchar(10) NOT NULL,
  `AlasanPenolakan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbpendatang`
--

INSERT INTO `tbpendatang` (`KodePendatang`, `KodePJ`, `NIK`, `NamaLengkap`, `NoTelp`, `TempatLahir`, `TanggalLahir`, `JenisKelamin`, `GolonganDarah`, `Agama`, `ProvinsiAsal`, `KabAsal`, `KecAsal`, `KelAsal`, `RT`, `RW`, `AlamatAsal`, `AlamatSekarang`, `Tujuan`, `TglMasuk`, `TglKeluar`, `Wilayah`, `Foto`, `KTP`, `Latitude`, `Longitude`, `StatusVerifikasi`, `AlasanPenolakan`) VALUES
(32, 26, 567800, 'Bisma Bisma', '0812389890', 'Jimbaran', '2025-06-03', 'Laki-laki', 'B', 'Islam', '15', '1502', '1502010', '1502010016', '00', '00', 'Jln. Mecutan Ketiga gg 2', 'Ula Villa, 11, Jalan Kebo Iwa, Nusa Dua, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80', 'kost', '2025-06-06', '2025-07-10', 'Perumahan Nuansa II', '', '', NULL, NULL, 'Diterima', NULL),
(35, 27, 8899, 'Tanjung Putra', '0089890089', 'Baturiti', '2005-06-22', 'Laki-laki', 'A', 'Hindu', '51', '5102', '5102011', '5102011001', '00', '00', 'Jembrana', 'Jalan Jepun, Jimbaran, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80163, Indonesia', 'Kost', '2025-07-12', '2025-09-11', 'Perumahan Nusa II', 'KTP_110.jpg', 'KTP_111.jp', NULL, NULL, 'Diterima', NULL),
(37, 27, 532, 'NI MADE ARTINI', '081237939052', 'Sading', '2005-02-13', 'Perempuan', 'AB', 'Hindu', '51', '5101', '5101010', '5101010009', '00', '00', 'Jl. Taman Paradise No 75', 'Tanjung Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia', 'Pekerjaan', '2025-07-02', '2025-08-06', 'Perumahan Nusa II', 'KTP_114.jpg', 'KTP_115.jp', NULL, NULL, 'Diproses', NULL),
(38, 26, 4490, 'Wahyuni Putri', '081237939052', 'Baturiti', '2005-06-22', 'Perempuan', 'B', 'Islam', '51', '5104', '5104030', '5104030017', '00', '00', 'Bukeleng, Lovina', 'Gang Karang Bunga II, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia', 'Pekerjaan', '2011-02-17', '2025-09-11', 'Perumahan Nuansa II', '', '', NULL, NULL, 'Diterima', NULL),
(39, 27, 345008890, 'Natalia de Coven', '081237939052', 'Badung', '2005-02-13', 'Perempuan', 'B', 'Hindu', '51', '5107', '5107030', '5107030005', '00', '00', 'Jl. Taman Sari', 'Jimbaran, Kuta Selatan, Badung, Bali, Nusa Tenggara, 80364, Indonesia', 'Pekerjaan', '2025-07-02', '2025-08-06', 'Perumahan Nusa II', 'KTP_116.jpg', 'KTP_117.jp', NULL, NULL, 'Diproses', NULL),
(41, 56, 215353, 'Ni Kadek Desta ', '0813328989', 'Badung', '2005-03-17', 'Perempuan', 'B', 'Hindu', '51', '5103', '5103010', '5103010002', '00', '00', 'Jl. Nusa Indah ', 'Gang Sandat, Jimbaran, Kuta Selatan, Badung, Bali, Nusa Tenggara, 80364, Indonesia', 'Kuliah dan Bekerja', '2025-07-08', '2025-10-30', 'Nuansa Perumahan Paradise', 'Selfie_Ktp1.jpg', 'KTP_119.jp', NULL, NULL, 'Diterima', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbpj`
--

CREATE TABLE `tbpj` (
  `KodePJ` int NOT NULL,
  `Username` int NOT NULL,
  `NamaLengkap` varchar(40) NOT NULL,
  `JenisKelamin` varchar(11) NOT NULL,
  `Alamat` varchar(50) NOT NULL,
  `Telp` varchar(15) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `Wilayah` varchar(100) NOT NULL,
  `StatusAktivasi` varchar(20) NOT NULL,
  `JenisAkun` varchar(20) NOT NULL,
  `EmailToken` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbpj`
--

INSERT INTO `tbpj` (`KodePJ`, `Username`, `NamaLengkap`, `JenisKelamin`, `Alamat`, `Telp`, `Email`, `Password`, `Wilayah`, `StatusAktivasi`, `JenisAkun`, `EmailToken`) VALUES
(25, 231, 'Wahyuni Putri', 'Perempuan', 'Gianyar', '0812348989', 'radityaaa@gmail.com', '$2y$10$3AVSlrmIyS2NOGOcYBWV4OStwKsMEoB5MaG0hmSBd4xGKKSG542WG', 'Perumahan Gianyar 2', 'Ditolak', 'Penanggungjawab', NULL),
(26, 1003, 'Agnesya Dwitira', '', 'Denpasar', '231123', 'radityaaa@gmail.com', '$2y$10$ZdOhESDUVv5vDR3u8xM/me/RiAZbGXmlE61CPBA8AhTJ63LUu0aIu', 'Perumahan Nuansa II', 'Terverifikasi', 'Penanggungjawab', NULL),
(27, 10230, 'Kadek Krisnayanti', 'Perempuan', 'Denpasar', '231123', 'radityaaa@gmail.com', '$2y$10$YoI9NqaZld8s6u2FJg4WqeLX2SA/hP03KOClPzT1.ulNUVlbcq73G', 'Perumahan Nusa II', 'Terverifikasi', 'Penanggungjawab', NULL),
(52, 23456, 'NINA', 'Perempuan', 'Jl. Kenangan', '081237939052', 'madeartini425@gmail.com', '$2y$10$dpAyMBO1tDk3GVZAToaxaOFkFXWPdNXrG52vltNUG/ObOJNaTGH2q', 'Nuansa Jimbaran I', 'Diproses', 'Penanggungjawab', NULL),
(53, 1091221, 'NOAH', 'Laki-laki', 'Br. Bakung Sari Ungasan', '0989009', 'cutemeowmeow111@gmail.com', '$2y$10$k6sQ79naAXt49Jb/cnucq.WeC93jvUbYNAqunSCS.wqjHPk2s5pBW', 'Perumahan Permai', 'Terverifikasi', 'Penanggungjawab', NULL),
(54, 21313, 'nonaa sajsia', 'Perempuan', 'Jl. Kenangan', '081237939052', 'cutemeowmeow111@gmail.com', '$2y$10$7QjnE5o3B/2ETKZzDTZMFezJsR1MRFFLOQ2WlmEc6OHmIBtJUX2I2', 'Perumahan Indah', 'Diproses', 'Penanggungjawab', NULL),
(56, 123434034, 'Allisyah Purnami Putri', 'Perempuan', 'Jl. Taman Paradise', '08989780', 'cutemeowmeow111@gmail.com', '$2y$10$QjzANFCrQqb5LSlJW0hm4OGEk69hxyAmA9btdLxBm0M/vzqfN8Iba', 'Nuansa Perumahan Paradise', 'Terverifikasi', 'Penanggungjawab', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbsurat`
--

CREATE TABLE `tbsurat` (
  `KodeSurat` int NOT NULL,
  `KodeJenis` int NOT NULL,
  `KodePendatang` int NOT NULL,
  `Nomor_Surat` varchar(50) DEFAULT NULL,
  `Tanggal_Surat` date DEFAULT NULL,
  `Keperluan` text,
  `File_Lampiran` varchar(255) DEFAULT NULL,
  `Catatan` text,
  `status` varchar(20) DEFAULT 'draft',
  `Waktu_Dibuat` datetime DEFAULT CURRENT_TIMESTAMP,
  `FieldTambahan` text,
  `KodeKaling` int DEFAULT NULL,
  `Dibuat_Oleh` varchar(100) NOT NULL,
  `TandaTangan` varchar(100) NOT NULL,
  `Catatan_penolakan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tbsurat`
--

INSERT INTO `tbsurat` (`KodeSurat`, `KodeJenis`, `KodePendatang`, `Nomor_Surat`, `Tanggal_Surat`, `Keperluan`, `File_Lampiran`, `Catatan`, `status`, `Waktu_Dibuat`, `FieldTambahan`, `KodeKaling`, `Dibuat_Oleh`, `TandaTangan`, `Catatan_penolakan`) VALUES
(17, 2, 32, '007/SUR/07/2025', '2025-07-17', NULL, 'surat_17.pdf', '-', 'Siap', '2025-07-17 22:25:21', '{\"KodeKaling\":\"17\",\"NamaLengkap\":\"Bisma Bisma\",\"JenisKelamin\":\"Laki-laki\",\"AlamatSekarang\":\"Ula Villa, 11, Jalan Kebo Iwa, Nusa Dua, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80\"}', 17, 'NOAH', '', ''),
(18, 14, 32, '008/SUR/07/2025', '2025-07-17', NULL, 'surat_18.pdf', '-', 'Siap', '2025-07-17 22:25:54', '{\"KodeKaling\":\"16\",\"NamaLengkap\":\"Bisma Bisma\",\"NoTelp\":\"0812389890\",\"TempatLahir\":\"Jimbaran\"}', 16, 'NOAH', '', ''),
(20, 2, 32, '010/SUR/07/2025', '2025-07-18', NULL, 'surat_20.pdf', '-', 'Tolak', '2025-07-18 01:29:00', '{\"KodeKaling\":\"17\",\"NamaLengkap\":\"Bisma Bisma\",\"JenisKelamin\":\"Laki-laki\",\"AlamatSekarang\":\"Ula Villa, 11, Jalan Kebo Iwa, Nusa Dua, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80\"}', 17, 'Administrator Role', '', 'Perbaiki nama instansi'),
(21, 2, 32, '011/SUR/07/2025', '2025-07-18', NULL, 'surat_21.pdf', '1', 'Siap', '2025-07-18 02:26:20', '{\"KodeKaling\":\"17\",\"NamaLengkap\":\"Bisma Bisma\",\"JenisKelamin\":\"Laki-laki\",\"AlamatSekarang\":\"Ula Villa, 11, Jalan Kebo Iwa, Nusa Dua, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80\"}', 17, 'Administrator Role', '', ''),
(22, 15, 38, '012/SUR/07/2025', '2025-07-18', NULL, 'surat_22.pdf', '-', 'Tolak', '2025-07-18 15:02:02', '{\"KodeKaling\":\"16\",\"NamaLengkap\":\"Wahyuni Putri\",\"Agama\":\"Islam\",\"ProvinsiAsal\":\"51\",\"KabAsal\":\"5104\",\"AlamatSekarang\":\"Gang Karang Bunga II, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia\"}', 16, 'Administrator Role', '', ''),
(23, 2, 38, '013/SUR/07/2025', '2025-07-18', NULL, 'surat_23.pdf', '-', 'Siap', '2025-07-18 16:16:25', '{\"KodeKaling\":\"17\",\"NamaLengkap\":\"Wahyuni Putri\",\"JenisKelamin\":\"Perempuan\",\"AlamatSekarang\":\"Gang Karang Bunga II, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia\"}', 17, 'Administrator Role', '23.png', ''),
(24, 15, 38, '014/SUR/07/2025', '2025-07-18', NULL, 'surat_24.pdf', '-', 'Permohonan', '2025-07-18 16:16:42', '{\"KodeKaling\":\"16\",\"NamaLengkap\":\"Wahyuni Putri\",\"Agama\":\"Islam\",\"ProvinsiAsal\":\"51\",\"KabAsal\":\"5104\",\"AlamatSekarang\":\"Gang Karang Bunga II, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia\"}', 16, 'Administrator Role', '', ''),
(25, 2, 38, '015/SUR/07/2025', '2025-07-18', NULL, 'surat_25.pdf', 'aasasasas', 'Siap', '2025-07-18 16:39:23', '{\"KodeKaling\":\"16\",\"NamaLengkap\":\"Wahyuni Putri\",\"JenisKelamin\":\"Perempuan\",\"AlamatSekarang\":\"Gang Karang Bunga II, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia\"}', 16, 'Administrator Role', '25.png', ''),
(26, 2, 38, '016/SUR/07/2025', '2025-07-18', NULL, 'surat_26.pdf', 'utyfg', 'Permohonan', '2025-07-18 16:52:45', '{\"KodeKaling\":\"16\",\"NamaLengkap\":\"Wahyuni Putri\",\"JenisKelamin\":\"Perempuan\",\"AlamatSekarang\":\"Gang Karang Bunga II, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia\"}', 16, 'Administrator Role', '', ''),
(27, 2, 38, '017/SUR/07/2025', '2025-07-18', NULL, 'surat_27.pdf', 'dfgd', 'draft', '2025-07-18 16:55:32', '{\"KodeKaling\":\"16\",\"NamaLengkap\":\"Wahyuni Putri\",\"JenisKelamin\":\"Perempuan\",\"AlamatSekarang\":\"Gang Karang Bunga II, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia\"}', 16, 'Administrator Role', '', ''),
(28, 2, 38, '018/SUR/07/2025', '2025-07-19', NULL, 'surat_28.pdf', '-', 'Siap', '2025-07-19 01:49:13', '{\"NamaLengkap\":\"Wahyuni Putri\",\"JenisKelamin\":\"Perempuan\",\"AlamatSekarang\":\"Gang Karang Bunga II, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia\"}', 17, 'Administrator Role', '28.png', ''),
(30, 2, 38, '020/SUR/07/2025', '2025-07-19', NULL, 'surat_30.pdf', 'tfdt', 'Siap', '2025-07-19 01:55:13', '{\"NamaLengkap\":\"Wahyuni Putri\",\"JenisKelamin\":\"Perempuan\",\"AlamatSekarang\":\"Gang Karang Bunga II, Benoa, Kuta Selatan, Badung, Bali, Lesser Sunda Islands, 80363, Indonesia\"}', 16, 'Administrator Role', '30.png', ''),
(32, 18, 41, '021/SUR/07/2025', '2025-07-19', NULL, 'surat_32.pdf', 'sasa', 'Siap', '2025-07-19 04:30:15', '{\"NamaLengkap\":\"Ni Kadek Desta \",\"NoTelp\":\"0813328989\",\"TempatLahir\":\"Badung\",\"JenisKelamin\":\"Perempuan\",\"AlamatAsal\":\"Jl. Nusa Indah \",\"AlamatSekarang\":\"Gang Sandat, Jimbaran, Kuta Selatan, Badung, Bali, Nusa Tenggara, 80364, Indonesia\"}', 20, 'Administrator Role', '32.png', ''),
(33, 18, 41, '022/SUR/07/2025', '2025-07-19', NULL, NULL, 'Untuk Pekerjaan', 'draft', '2025-07-19 08:40:29', '{\"NamaLengkap\":\"Ni Kadek Desta \",\"NoTelp\":\"0813328989\",\"TempatLahir\":\"Badung\",\"JenisKelamin\":\"Perempuan\",\"AlamatAsal\":\"Jl. Nusa Indah \",\"AlamatSekarang\":\"Gang Sandat, Jimbaran, Kuta Selatan, Badung, Bali, Nusa Tenggara, 80364, Indonesia\"}', 20, 'Eka Putra', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbjenis_surat`
--
ALTER TABLE `tbjenis_surat`
  ADD PRIMARY KEY (`KodeJenis`);

--
-- Indexes for table `tbkaling`
--
ALTER TABLE `tbkaling`
  ADD PRIMARY KEY (`KodeKaling`);

--
-- Indexes for table `tblogin`
--
ALTER TABLE `tblogin`
  ADD PRIMARY KEY (`KodeLogin`);

--
-- Indexes for table `tbpendatang`
--
ALTER TABLE `tbpendatang`
  ADD PRIMARY KEY (`KodePendatang`),
  ADD KEY `KodePJ` (`KodePJ`) USING BTREE;

--
-- Indexes for table `tbpj`
--
ALTER TABLE `tbpj`
  ADD PRIMARY KEY (`KodePJ`);

--
-- Indexes for table `tbsurat`
--
ALTER TABLE `tbsurat`
  ADD PRIMARY KEY (`KodeSurat`),
  ADD KEY `KodeJenis` (`KodeJenis`),
  ADD KEY `KodePendatang` (`KodePendatang`),
  ADD KEY `fk_kaling` (`KodeKaling`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbjenis_surat`
--
ALTER TABLE `tbjenis_surat`
  MODIFY `KodeJenis` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbkaling`
--
ALTER TABLE `tbkaling`
  MODIFY `KodeKaling` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tblogin`
--
ALTER TABLE `tblogin`
  MODIFY `KodeLogin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbpendatang`
--
ALTER TABLE `tbpendatang`
  MODIFY `KodePendatang` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `tbpj`
--
ALTER TABLE `tbpj`
  MODIFY `KodePJ` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `tbsurat`
--
ALTER TABLE `tbsurat`
  MODIFY `KodeSurat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbpendatang`
--
ALTER TABLE `tbpendatang`
  ADD CONSTRAINT `FK_KodePJ` FOREIGN KEY (`KodePJ`) REFERENCES `tbpj` (`KodePJ`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbsurat`
--
ALTER TABLE `tbsurat`
  ADD CONSTRAINT `fk_kaling` FOREIGN KEY (`KodeKaling`) REFERENCES `tbkaling` (`KodeKaling`),
  ADD CONSTRAINT `tbsurat_ibfk_1` FOREIGN KEY (`KodeJenis`) REFERENCES `tbjenis_surat` (`KodeJenis`),
  ADD CONSTRAINT `tbsurat_ibfk_2` FOREIGN KEY (`KodePendatang`) REFERENCES `tbpendatang` (`KodePendatang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
