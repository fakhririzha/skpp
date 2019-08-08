-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2019 at 03:10 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skpp`
--
CREATE DATABASE IF NOT EXISTS `skpp` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `skpp`;

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `hitungLaporanDetail` (`nominal` INT(20), `kode` VARCHAR(3), `keterangan` VARCHAR(100)) RETURNS INT(20) BEGIN
	DECLARE nominalTrx int(20);
    
    IF (kode LIKE '3A' AND keterangan = 'Debit') THEN
    	SET nominalTrx = nominal;
    ELSEIF (kode LIKE '%B' AND keterangan = 'Kredit') THEN
    	SET nominalTrx = nominal;
   	ELSE
    	SET nominalTrx = 0;
    END IF;
    RETURN nominalTrx;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `hitungLaporanDetailPenerimaan` (`nominal` INT(20), `kode` VARCHAR(3), `keterangan` VARCHAR(100)) RETURNS INT(20) BEGIN
	DECLARE nominalTrx int(20);
    
    IF (kode = '1A' AND keterangan='Debit') THEN
    	SET nominalTrx = nominal;
    ELSEIF (kode = '2A' AND keterangan='Debit') THEN
    	SET nominalTrx = nominal;
   	ELSE
    	SET nominalTrx = 0;
    END IF;
    RETURN nominalTrx;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `hitungPemasukanLainnya` (`waktuMulai` DATE, `waktuAkhir` DATE) RETURNS INT(20) BEGIN
	DECLARE pemasukanLainnya int(20);
	SELECT SUM(nominal) INTO pemasukanLainnya FROM transaksi WHERE kode = '3A' AND tanggal BETWEEN waktuMulai AND waktuAkhir;
    RETURN pemasukanLainnya;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `hitungPenerimaan` (`waktuMulai` DATE, `waktuAkhir` DATE) RETURNS INT(20) BEGIN
	DECLARE pemasukan int(20);
	SELECT SUM(nominal) INTO pemasukan FROM transaksi WHERE kode = '1A' OR kode = '2A' AND tanggal BETWEEN waktuMulai AND waktuAkhir;
    RETURN pemasukan;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `hitungPengeluaran` (`waktuMulai` DATE, `waktuAkhir` DATE) RETURNS INT(20) NO SQL
BEGIN
	DECLARE pengeluaran int(20);
	SELECT SUM(nominal) INTO pengeluaran FROM transaksi WHERE kode = '1A' OR kode = '2A' AND tanggal BETWEEN waktuMulai AND waktuAkhir;
    RETURN pengeluaran;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `jumlahAkun` () RETURNS INT(11) BEGIN
	DECLARE jumlahAkun int(11);
    SELECT COUNT(*) INTO jumlahAkun
    FROM user;
    RETURN jumlahAkun;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `jumlahSiswa` () RETURNS INT(11) BEGIN
	DECLARE jumlahSiswa int(11);
    SELECT COUNT(*) INTO jumlahSiswa
    FROM siswa
    WHERE jenis_kelamin='laki-laki';
    RETURN jumlahSiswa;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `jumlahSiswi` () RETURNS INT(11) BEGIN
	DECLARE jumlahSiswi int(11);
    SELECT COUNT(*) INTO jumlahSiswi
    FROM siswa
    WHERE jenis_kelamin='perempuan';
    RETURN jumlahSiswi;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `laporanKeuangan` (`nominal` INT(20), `kode` VARCHAR(3), `keterangan` VARCHAR(20)) RETURNS INT(20) BEGIN
	DECLARE nominalTrx int(20);
    
    IF (kode LIKE '%A' AND keterangan = 'Pemasukan') THEN
    	SET nominalTrx = nominal;
    ELSEIF (kode LIKE '%B' AND keterangan = 'Pengeluaran') THEN
    	SET nominalTrx = nominal;
   	ELSE
    	SET nominalTrx = 0;
    END IF;
    RETURN nominalTrx;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `laporanPengeluaran` (`nominal` INT(20), `kode` VARCHAR(3), `keterangan` VARCHAR(100)) RETURNS INT(20) BEGIN
	DECLARE nominalTrx int(20);
    
    IF (kode LIKE '%B') THEN
    	SET nominalTrx = nominal;
   	ELSE
    	SET nominalTrx = 0;
    END IF;
    RETURN nominalTrx;
END$$

CREATE DEFINER=`root`@`localhost` FUNCTION `penerimaanSPP` (`nominal` INT(20), `kode` VARCHAR(3), `keterangan` VARCHAR(20)) RETURNS INT(20) BEGIN
	DECLARE nominalTrx int(20);
    
    IF (kode = '1A' AND keterangan='Putra') THEN
    	SET nominalTrx = nominal;
    ELSEIF (kode = '2A' AND keterangan='Putri') THEN
    	SET nominalTrx = nominal;
    ELSEIF (kode = '3A' AND keterangan='Lainnya') THEN
    	SET nominalTrx = nominal;
   	ELSE
    	SET nominalTrx = 0;
    END IF;
    RETURN nominalTrx;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `bulanan`
--

CREATE TABLE `bulanan` (
  `id` int(11) NOT NULL,
  `no_ref` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sttb` int(11) NOT NULL,
  `tahun_akademik` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `semester` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` int(11) NOT NULL,
  `bulan_bayar` int(2) NOT NULL,
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `bulanan`
--

INSERT INTO `bulanan` (`id`, `no_ref`, `sttb`, `tahun_akademik`, `semester`, `tanggal`, `nominal`, `bulan_bayar`, `id_petugas`) VALUES
(1, 'BLN1', 17250, '2019/2020', 'A', '2019-07-31', 700000, 7, 2),
(2, 'BLN2', 17251, '2019/2020', 'A', '2019-07-31', 700000, 7, 2),
(3, 'BLN3', 17250, '2019/2020', 'A', '2019-08-01', 700000, 8, 2),
(4, 'BLN4', 17251, '2019/2020', 'A', '2019-08-02', 700000, 8, 2),
(5, 'BLN5', 17252, '2019/2020', 'A', '2019-07-17', 700000, 7, 2),
(6, 'BLN6', 17254, '2019/2020', 'A', '2019-07-18', 700000, 7, 2),
(7, 'BLN7', 17255, '2019/2020', 'A', '2019-07-19', 700000, 7, 2),
(8, 'BLN8', 17256, '2019/2020', 'A', '2019-07-19', 700000, 7, 2),
(9, 'BLN9', 17257, '2019/2020', 'A', '2019-07-21', 700000, 7, 2),
(10, 'BLN10', 17258, '2019/2020', 'A', '2019-07-22', 700000, 7, 2),
(11, 'BLN11', 17259, '2019/2020', 'A', '2019-07-14', 700000, 7, 2),
(12, 'BLN12', 17260, '2019/2020', 'A', '2019-07-13', 700000, 7, 2),
(13, 'BLN13', 17261, '2019/2020', 'A', '2019-07-12', 700000, 7, 2),
(14, 'BLN14', 17262, '2019/2020', 'A', '2019-07-11', 700000, 7, 2),
(15, 'BLN15', 17263, '2019/2020', 'A', '2019-07-10', 700000, 7, 2),
(16, 'BLN16', 17264, '2019/2020', 'A', '2019-07-09', 700000, 7, 2),
(17, 'BLN17', 17265, '2019/2020', 'A', '2019-07-08', 700000, 7, 2),
(18, 'BLN18', 17266, '2019/2020', 'A', '2019-07-07', 700000, 7, 2);

--
-- Triggers `bulanan`
--
DELIMITER $$
CREATE TRIGGER `iuran_bulanan` AFTER UPDATE ON `bulanan` FOR EACH ROW BEGIN
    DECLARE jk varchar(11);
    DECLARE keterangan varchar(255);
    DECLARE kode varchar(3);
    SELECT jenis_kelamin INTO jk FROM `siswa` WHERE sttb=NEW.sttb;
    
    IF jk = "laki-laki" THEN
    	SET kode='1A';
      	SELECT `kode_transaksi`.`keterangan` INTO keterangan FROM `kode_transaksi` WHERE `kode_transaksi`.`kode`=kode;
      	INSERT INTO `transaksi` VALUES(NULL, NEW.no_ref, kode, keterangan, NEW.tanggal, NEW.nominal, 'bukabuku', NEW.id_petugas);
    ELSE
	SET kode='2A';
      	SELECT `kode_transaksi`.`keterangan` INTO keterangan FROM `kode_transaksi` WHERE `kode_transaksi`.`kode`=kode;
      	INSERT INTO `transaksi` VALUES(NULL,  NEW.no_ref, kode, keterangan, NEW.tanggal, NEW.nominal, 'bukabuku', NEW.id_petugas);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `kode_kelas` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `semester` varchar(1) COLLATE utf8_unicode_ci NOT NULL,
  `tahun_akademik` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `iuran_bulanan` int(11) NOT NULL,
  `iuran_bulanan_subsidi` int(11) NOT NULL,
  `iuran_tahunan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`kode_kelas`, `semester`, `tahun_akademik`, `iuran_bulanan`, `iuran_bulanan_subsidi`, `iuran_tahunan`) VALUES
('X A', 'A', '2019/2020', 700000, 650000, 2000000),
('X B', 'A', '2019/2020', 700000, 0, 2000000),
('X C', 'A', '2019/2020', 700000, 0, 2000000),
('X D', 'A', '2019/2020', 700000, 0, 2000000),
('X E', 'A', '2019/2020', 700000, 0, 2000000),
('XI A', 'A', '2019/2020', 700000, 0, 2000000),
('XI B', 'A', '2019/2020', 700000, 0, 2000000),
('XI C', 'A', '2019/2020', 700000, 0, 2000000),
('XI D', 'A', '2019/2020', 700000, 0, 2000000),
('XI E', 'A', '2019/2020', 700000, 0, 2000000),
('XII A', 'A', '2019/2020', 700000, 0, 2000000),
('XII B', 'A', '2019/2020', 700000, 0, 2000000),
('XII C', 'A', '2019/2020', 700000, 0, 2000000),
('XII D', 'A', '2019/2020', 700000, 0, 2000000),
('XII E', 'A', '2019/2020', 700000, 0, 2000000);

-- --------------------------------------------------------

--
-- Table structure for table `kode_transaksi`
--

CREATE TABLE `kode_transaksi` (
  `kode` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `kode_transaksi`
--

INSERT INTO `kode_transaksi` (`kode`, `keterangan`) VALUES
('10B', 'Pengeluaran Lainnya'),
('1A', 'Pembayaran Putra'),
('1B', 'Pimpinan'),
('2A', 'Pembayaran Putri'),
('2B', 'Sekretaris'),
('3A', 'Pemasukan Lainnya'),
('3B', 'Bendahara'),
('4A', 'Saldo Awal'),
('4B', 'KMI'),
('5B', 'Pengasuhan'),
('6B', 'Dapur'),
('7B', 'Pembangunan'),
('8B', 'Listrik'),
('9B', 'Kesejahteraan');

-- --------------------------------------------------------

--
-- Table structure for table `pembagian_kelas`
--

CREATE TABLE `pembagian_kelas` (
  `sttb` int(20) NOT NULL,
  `kode_kelas` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `tahun_akademik` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('aktif','nonaktif') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pembagian_kelas`
--

INSERT INTO `pembagian_kelas` (`sttb`, `kode_kelas`, `tahun_akademik`, `status`) VALUES
(17269, 'X E', '2019/2020', 'aktif'),
(17270, 'X E', '2019/2020', 'aktif'),
(17271, 'X E', '2019/2020', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `sttb` int(11) NOT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `kode_kelas` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jenis_kelamin` enum('laki-laki','perempuan') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('subsidi','non-subsidi') COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`sttb`, `nama`, `kode_kelas`, `jenis_kelamin`, `status`) VALUES
(17250, 'Siti Maula Fadriya', 'X E', 'perempuan', 'non-subsidi'),
(17251, 'Khotimatun Nisa Br. Swaga', 'X E', 'perempuan', 'non-subsidi'),
(17252, 'Zain Rofifah Siagian', 'X E', 'perempuan', 'non-subsidi'),
(17253, 'Nabila Destria Syafira', 'X E', 'perempuan', 'non-subsidi'),
(17254, 'Fadhillah Ramadhani', 'X E', 'perempuan', 'non-subsidi'),
(17255, 'Rahma Anggraini Tanjung', 'X E', 'perempuan', 'non-subsidi'),
(17256, 'Nailin Tasnim', 'X E', 'perempuan', 'non-subsidi'),
(17257, 'Suci Amara Harahap', 'X E', 'perempuan', 'non-subsidi'),
(17258, 'Najwa Laila IX', 'X E', 'perempuan', 'non-subsidi'),
(17259, 'Sindy Aulia Sari', 'X E', 'perempuan', 'non-subsidi'),
(17260, 'Annisa ul-Husna', 'X E', 'perempuan', 'non-subsidi'),
(17261, 'Vika Lestari', 'X E', 'perempuan', 'non-subsidi'),
(17262, 'Annisa Salsabula Lesti', 'X E', 'perempuan', 'non-subsidi'),
(17263, 'Nur Sakinah Harahap', 'X E', 'perempuan', 'non-subsidi'),
(17264, 'Mirna Amelia Citra B', 'X E', 'perempuan', 'non-subsidi'),
(17265, 'Nazwa Syifa', 'X E', 'perempuan', 'non-subsidi'),
(17266, 'Dwi Syagilla Syam', 'X E', 'perempuan', 'non-subsidi'),
(17267, 'Nadhawasa Zeno', 'X E', 'perempuan', 'non-subsidi'),
(17268, 'Debby Adelia', 'X E', 'perempuan', 'non-subsidi'),
(17269, 'Fakhirah Mentaya', 'X E', 'perempuan', 'non-subsidi'),
(17270, 'Rezky Febri Dawanti', 'X E', 'perempuan', 'non-subsidi'),
(17271, 'Nadia Nasywa', 'X E', 'perempuan', 'non-subsidi');

-- --------------------------------------------------------

--
-- Table structure for table `tahunan`
--

CREATE TABLE `tahunan` (
  `id` int(11) NOT NULL,
  `no_ref` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `sttb` int(11) NOT NULL,
  `tahun_akademik` varchar(9) COLLATE utf8_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Triggers `tahunan`
--
DELIMITER $$
CREATE TRIGGER `iuran_tahunan` AFTER UPDATE ON `tahunan` FOR EACH ROW BEGIN
	DECLARE jk varchar(11);
    DECLARE keterangan varchar(255);
	DECLARE kode varchar(3);
    SELECT jenis_kelamin INTO jk FROM `siswa` WHERE sttb=NEW.sttb;
    
    IF jk = "laki-laki" THEN
    	SET kode='1A';
      	SELECT `kode_transaksi`.`keterangan` INTO keterangan FROM `kode_transaksi` WHERE `kode_transaksi`.`kode`=kode;
      	INSERT INTO `transaksi` VALUES(NULL,  NEW.no_ref, kode, keterangan, NEW.tanggal, NEW.nominal, 'bukabuku', NEW.id_petugas);
    ELSE
		SET kode='2A';
      	SELECT `kode_transaksi`.`keterangan` INTO keterangan FROM `kode_transaksi` WHERE `kode_transaksi`.`kode`=kode;
      	INSERT INTO `transaksi` VALUES(NULL,  NEW.no_ref, kode, keterangan, NEW.tanggal, NEW.nominal, 'bukabuku', NEW.id_petugas);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `no_ref` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `kode` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `keterangan` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` int(11) NOT NULL,
  `status` enum('bukabuku','tutupbuku') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'bukabuku',
  `id_petugas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `no_ref`, `kode`, `keterangan`, `tanggal`, `nominal`, `status`, `id_petugas`) VALUES
(1, 'BLN1', '2A', 'Pembayaran Putri', '2019-07-31', 700000, 'bukabuku', 2),
(2, 'BLN2', '1A', 'Pembayaran Putra', '2019-07-31', 700000, 'bukabuku', 2),
(3, 'BLN3', '2A', 'Pembayaran Putri', '2019-08-01', 700000, 'bukabuku', 2),
(4, 'BLN4', '1A', 'Pembayaran Putra', '2019-08-02', 700000, 'bukabuku', 2),
(6, 'OUT6', '6B', 'Dapoer', '2019-07-31', 350000, 'bukabuku', 2),
(8, 'LN8', '3A', 'Transfer Bambang', '2019-07-31', 500000, 'bukabuku', 2),
(9, 'BLN5', '2A', 'Pembayaran Putri', '2019-07-17', 700000, 'bukabuku', 2),
(10, 'BLN6', '2A', 'Pembayaran Putri', '2019-07-18', 700000, 'bukabuku', 2),
(11, 'BLN7', '2A', 'Pembayaran Putri', '2019-07-19', 700000, 'bukabuku', 2),
(12, 'BLN8', '2A', 'Pembayaran Putri', '2019-07-19', 700000, 'bukabuku', 2),
(13, 'BLN9', '2A', 'Pembayaran Putri', '2019-07-21', 700000, 'bukabuku', 2),
(14, 'BLN10', '2A', 'Pembayaran Putri', '2019-07-22', 700000, 'bukabuku', 2),
(15, 'BLN11', '2A', 'Pembayaran Putri', '2019-07-14', 700000, 'bukabuku', 2),
(16, 'BLN12', '2A', 'Pembayaran Putri', '2019-07-13', 700000, 'bukabuku', 2),
(17, 'BLN13', '2A', 'Pembayaran Putri', '2019-07-12', 700000, 'bukabuku', 2),
(18, 'BLN14', '2A', 'Pembayaran Putri', '2019-07-11', 700000, 'bukabuku', 2),
(19, 'BLN15', '2A', 'Pembayaran Putri', '2019-07-10', 700000, 'bukabuku', 2),
(20, 'BLN16', '2A', 'Pembayaran Putri', '2019-07-09', 700000, 'bukabuku', 2),
(21, 'BLN17', '2A', 'Pembayaran Putri', '2019-07-08', 700000, 'bukabuku', 2),
(22, 'BLN18', '2A', 'Pembayaran Putri', '2019-07-07', 700000, 'bukabuku', 2),
(23, 'OUT23', '10B', 'Transfer Bambang', '2019-07-01', 570000, 'bukabuku', 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nama` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `jabatan` enum('admin','bendahara','staff') COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('logged_in','inactive') COLLATE utf8_unicode_ci NOT NULL,
  `last_login` varchar(32) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `nama`, `jabatan`, `status`, `last_login`) VALUES
(1, 'admin', '$2y$10$0bfZbKKVUZau0sF5fJo6Mu1pA7FxcRBUNmskRwSsRADW44uakFKyu', 'admin', 'admin', 'logged_in', '2019-08-07 15:15:25'),
(2, 'harmain', '$2y$10$J1db1I2kRnRO6mqPfSYvAeq7djZDI1OZqL2b.B5I65vxZJfIJwHpS', 'Ust. M. Harmain, S.E, M.M', 'bendahara', 'logged_in', '2019-08-08 11:15:56'),
(3, 'rezky', '$2y$10$GFRKINPKvow2KOlhk6vFRecNdU/jSMK2qe6bge7EukvFMhuux5ZLu', 'Rezky Lubis', 'staff', 'inactive', '2019-08-06 15:45:44'),
(4, 'rezkyfebri', '$2y$10$JBDMzv2lqgDeZBF9WDT8weVpZdQ8.1W0pbEmg/rjnLi1e18HAp6IW', 'Rezy Febri', 'staff', 'inactive', '2019-08-06 15:46:10'),
(5, 'yusri', '$2y$10$/Q92MsHX/FtVRQipDu6UTOoIFvqcuvVvmjv8iMQwrsuzZvuwUOIma', 'Yusriantoni', 'staff', 'inactive', '2019-08-06 15:46:26'),
(6, 'fakhri', '$2y$10$WK/Y0oC.Q8PH//GzpKQgP.j1OzJD2KjZ0q9bEuovg.jnVLctTSpJq', 'Fakhri Rizha Ananda', 'staff', 'inactive', '2019-08-06 15:47:07');

-- --------------------------------------------------------

--
-- Stand-in structure for view `vhistoritransaksi`
-- (See below for the actual view)
--
CREATE TABLE `vhistoritransaksi` (
`id` int(11)
,`no_ref` varchar(100)
,`kode` varchar(3)
,`keterangan` varchar(255)
,`tanggal` date
,`nominal` int(11)
,`status` enum('bukabuku','tutupbuku')
,`id_petugas` int(11)
,`nama` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vhistoritransaksibulanan`
-- (See below for the actual view)
--
CREATE TABLE `vhistoritransaksibulanan` (
`namaSiswa` varchar(255)
,`sttbSiswa` int(11)
,`id` int(11)
,`no_ref` varchar(100)
,`sttb` int(11)
,`tahun_akademik` varchar(9)
,`semester` varchar(1)
,`tanggal` date
,`nominal` int(11)
,`bulan_bayar` int(2)
,`id_petugas` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vhistoritransaksitahunan`
-- (See below for the actual view)
--
CREATE TABLE `vhistoritransaksitahunan` (
`namaSiswa` varchar(255)
,`sttbSiswa` int(11)
,`id` int(11)
,`no_ref` varchar(100)
,`sttb` int(11)
,`tahun_akademik` varchar(9)
,`tanggal` date
,`nominal` int(11)
,`id_petugas` int(11)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vlaporandetail`
-- (See below for the actual view)
--
CREATE TABLE `vlaporandetail` (
`tanggalFormatted` varchar(10)
,`tanggal` date
,`keterangan` varchar(255)
,`ddebit` int(20)
,`kkredit` int(20)
,`debit` decimal(41,0)
,`kredit` decimal(41,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vlaporandetailpenerimaan`
-- (See below for the actual view)
--
CREATE TABLE `vlaporandetailpenerimaan` (
`tanggalFormatted` varchar(10)
,`tanggal` date
,`putra` int(20)
,`putri` int(20)
,`penerimaanPutra` decimal(41,0)
,`penerimaanPutri` decimal(41,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vlaporankeuangan`
-- (See below for the actual view)
--
CREATE TABLE `vlaporankeuangan` (
`tanggalFormatted` varchar(10)
,`tanggal` date
,`debet` int(20)
,`kredit` int(20)
,`jlhDebit` decimal(41,0)
,`jlhKredit` decimal(41,0)
,`selisih` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vlaporanpengeluaran`
-- (See below for the actual view)
--
CREATE TABLE `vlaporanpengeluaran` (
`tanggalFormatted` varchar(10)
,`tanggal` date
,`kredit` int(20)
,`pengeluaran` decimal(41,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vlaporanspp`
-- (See below for the actual view)
--
CREATE TABLE `vlaporanspp` (
`tanggalFormatted` varchar(10)
,`tanggal` date
,`putra` int(20)
,`putri` int(20)
,`jlhPutra` decimal(41,0)
,`jlhPutri` decimal(41,0)
,`jumlah` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vpenerimaanputra`
-- (See below for the actual view)
--
CREATE TABLE `vpenerimaanputra` (
`tanggal` date
,`penerimaanPutra` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vpenerimaanputri`
-- (See below for the actual view)
--
CREATE TABLE `vpenerimaanputri` (
`tanggal` date
,`penerimaanPutri` decimal(32,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vsiswakelas`
-- (See below for the actual view)
--
CREATE TABLE `vsiswakelas` (
`sttb` int(11)
,`nama` varchar(255)
,`kode_kelas` varchar(255)
,`status` enum('subsidi','non-subsidi')
,`semester` varchar(1)
,`tahun_akademik` varchar(9)
,`iuran_bulanan` int(11)
,`iuran_bulanan_subsidi` int(11)
,`iuran_tahunan` int(11)
);

-- --------------------------------------------------------

--
-- Structure for view `vhistoritransaksi`
--
DROP TABLE IF EXISTS `vhistoritransaksi`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vhistoritransaksi`  AS  select `t`.`id` AS `id`,`t`.`no_ref` AS `no_ref`,`t`.`kode` AS `kode`,`t`.`keterangan` AS `keterangan`,`t`.`tanggal` AS `tanggal`,`t`.`nominal` AS `nominal`,`t`.`status` AS `status`,`t`.`id_petugas` AS `id_petugas`,`u`.`nama` AS `nama` from (`transaksi` `t` join `user` `u`) where (`t`.`id_petugas` = `u`.`id`) ;

-- --------------------------------------------------------

--
-- Structure for view `vhistoritransaksibulanan`
--
DROP TABLE IF EXISTS `vhistoritransaksibulanan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vhistoritransaksibulanan`  AS  select `s`.`nama` AS `namaSiswa`,`s`.`sttb` AS `sttbSiswa`,`b`.`id` AS `id`,`b`.`no_ref` AS `no_ref`,`b`.`sttb` AS `sttb`,`b`.`tahun_akademik` AS `tahun_akademik`,`b`.`semester` AS `semester`,`b`.`tanggal` AS `tanggal`,`b`.`nominal` AS `nominal`,`b`.`bulan_bayar` AS `bulan_bayar`,`b`.`id_petugas` AS `id_petugas` from (`bulanan` `b` join `siswa` `s`) where (`s`.`sttb` = `b`.`sttb`) ;

-- --------------------------------------------------------

--
-- Structure for view `vhistoritransaksitahunan`
--
DROP TABLE IF EXISTS `vhistoritransaksitahunan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vhistoritransaksitahunan`  AS  select `s`.`nama` AS `namaSiswa`,`s`.`sttb` AS `sttbSiswa`,`b`.`id` AS `id`,`b`.`no_ref` AS `no_ref`,`b`.`sttb` AS `sttb`,`b`.`tahun_akademik` AS `tahun_akademik`,`b`.`tanggal` AS `tanggal`,`b`.`nominal` AS `nominal`,`b`.`id_petugas` AS `id_petugas` from (`tahunan` `b` join `siswa` `s`) where (`s`.`sttb` = `b`.`sttb`) ;

-- --------------------------------------------------------

--
-- Structure for view `vlaporandetail`
--
DROP TABLE IF EXISTS `vlaporandetail`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vlaporandetail`  AS  select date_format(`transaksi`.`tanggal`,'%d/%m/%Y') AS `tanggalFormatted`,`transaksi`.`tanggal` AS `tanggal`,`transaksi`.`keterangan` AS `keterangan`,`hitungLaporanDetail`(`transaksi`.`nominal`,`transaksi`.`kode`,'Debit') AS `ddebit`,`hitungLaporanDetail`(`transaksi`.`nominal`,`transaksi`.`kode`,'Kredit') AS `kkredit`,sum((select `ddebit`)) AS `debit`,sum((select `kkredit`)) AS `kredit` from `transaksi` where ((`transaksi`.`kode` like '%B') or (`transaksi`.`kode` = '3A')) ;

-- --------------------------------------------------------

--
-- Structure for view `vlaporandetailpenerimaan`
--
DROP TABLE IF EXISTS `vlaporandetailpenerimaan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vlaporandetailpenerimaan`  AS  select date_format(`transaksi`.`tanggal`,'%d/%m/%Y') AS `tanggalFormatted`,`transaksi`.`tanggal` AS `tanggal`,`penerimaanSPP`(`transaksi`.`nominal`,`transaksi`.`kode`,'Putra') AS `putra`,`penerimaanSPP`(`transaksi`.`nominal`,`transaksi`.`kode`,'Putri') AS `putri`,sum((select `putra`)) AS `penerimaanPutra`,sum((select `putri`)) AS `penerimaanPutri` from `transaksi` where ((`transaksi`.`kode` = '1A') or (`transaksi`.`kode` = '2A')) group by `transaksi`.`tanggal` ;

-- --------------------------------------------------------

--
-- Structure for view `vlaporankeuangan`
--
DROP TABLE IF EXISTS `vlaporankeuangan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vlaporankeuangan`  AS  select date_format(`transaksi`.`tanggal`,'%d/%m/%Y') AS `tanggalFormatted`,`transaksi`.`tanggal` AS `tanggal`,`laporanKeuangan`(`transaksi`.`nominal`,`transaksi`.`kode`,'Pemasukan') AS `debet`,`laporanKeuangan`(`transaksi`.`nominal`,`transaksi`.`kode`,'Pengeluaran') AS `kredit`,sum((select `debet`)) AS `jlhDebit`,sum((select `kredit`)) AS `jlhKredit`,sum(((select `debet`) - (select `kredit`))) AS `selisih` from `transaksi` group by `transaksi`.`tanggal` ;

-- --------------------------------------------------------

--
-- Structure for view `vlaporanpengeluaran`
--
DROP TABLE IF EXISTS `vlaporanpengeluaran`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vlaporanpengeluaran`  AS  select date_format(`transaksi`.`tanggal`,'%d/%m/%Y') AS `tanggalFormatted`,`transaksi`.`tanggal` AS `tanggal`,`laporanPengeluaran`(`transaksi`.`nominal`,`transaksi`.`kode`,'Pengeluaran') AS `kredit`,sum((select `kredit`)) AS `pengeluaran` from `transaksi` group by `transaksi`.`tanggal` ;

-- --------------------------------------------------------

--
-- Structure for view `vlaporanspp`
--
DROP TABLE IF EXISTS `vlaporanspp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vlaporanspp`  AS  select date_format(`transaksi`.`tanggal`,'%d/%m/%Y') AS `tanggalFormatted`,`transaksi`.`tanggal` AS `tanggal`,`penerimaanSPP`(`transaksi`.`nominal`,`transaksi`.`kode`,'Putra') AS `putra`,`penerimaanSPP`(`transaksi`.`nominal`,`transaksi`.`kode`,'Putri') AS `putri`,sum((select `putra`)) AS `jlhPutra`,sum((select `putri`)) AS `jlhPutri`,sum(((select `putra`) + (select `putri`))) AS `jumlah` from `transaksi` where ((`transaksi`.`kode` = '1A') or (`transaksi`.`kode` = '2A')) group by `transaksi`.`tanggal` ;

-- --------------------------------------------------------

--
-- Structure for view `vpenerimaanputra`
--
DROP TABLE IF EXISTS `vpenerimaanputra`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vpenerimaanputra`  AS  select `transaksi`.`tanggal` AS `tanggal`,sum(`transaksi`.`nominal`) AS `penerimaanPutra` from `transaksi` where (`transaksi`.`kode` = '1A') group by `transaksi`.`tanggal` ;

-- --------------------------------------------------------

--
-- Structure for view `vpenerimaanputri`
--
DROP TABLE IF EXISTS `vpenerimaanputri`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vpenerimaanputri`  AS  select `transaksi`.`tanggal` AS `tanggal`,sum(`transaksi`.`nominal`) AS `penerimaanPutri` from `transaksi` where (`transaksi`.`kode` = '2A') group by `transaksi`.`tanggal` ;

-- --------------------------------------------------------

--
-- Structure for view `vsiswakelas`
--
DROP TABLE IF EXISTS `vsiswakelas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vsiswakelas`  AS  select `s`.`sttb` AS `sttb`,`s`.`nama` AS `nama`,`s`.`kode_kelas` AS `kode_kelas`,`s`.`status` AS `status`,`k`.`semester` AS `semester`,`k`.`tahun_akademik` AS `tahun_akademik`,`k`.`iuran_bulanan` AS `iuran_bulanan`,`k`.`iuran_bulanan_subsidi` AS `iuran_bulanan_subsidi`,`k`.`iuran_tahunan` AS `iuran_tahunan` from (`siswa` `s` left join `kelas` `k` on((`s`.`kode_kelas` = `k`.`kode_kelas`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bulanan`
--
ALTER TABLE `bulanan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sttb` (`sttb`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`kode_kelas`);

--
-- Indexes for table `kode_transaksi`
--
ALTER TABLE `kode_transaksi`
  ADD PRIMARY KEY (`kode`);

--
-- Indexes for table `pembagian_kelas`
--
ALTER TABLE `pembagian_kelas`
  ADD KEY `sttb` (`sttb`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`sttb`),
  ADD KEY `kode_kelas` (`kode_kelas`);

--
-- Indexes for table `tahunan`
--
ALTER TABLE `tahunan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sttb` (`sttb`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kode` (`kode`),
  ADD KEY `id_petugas` (`id_petugas`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bulanan`
--
ALTER TABLE `bulanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tahunan`
--
ALTER TABLE `tahunan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `update_tahunAkademik` ON SCHEDULE EVERY 1 YEAR STARTS '2020-07-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
	DECLARE tahun_akademik varchar(9);
    SET tahun_akademik = CONCAT_WS("/", YEAR(NOW()), YEAR(NOW())+1);
	UPDATE kelas SET tahun_akademik=tahun_akademik;
END$$

CREATE DEFINER=`root`@`localhost` EVENT `update_semesterB` ON SCHEDULE EVERY 1 YEAR STARTS '2020-01-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE kelas SET semester='B'$$

CREATE DEFINER=`root`@`localhost` EVENT `update_semesterA` ON SCHEDULE EVERY 1 YEAR STARTS '2020-07-01 00:00:00' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE kelas SET semester='A'$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
