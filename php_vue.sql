-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Des 2020 pada 14.04
-- Versi server: 10.4.10-MariaDB
-- Versi PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `demo_vue`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_produk`
--

CREATE TABLE `tb_produk` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `harga` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `tb_produk`
--

INSERT INTO `tb_produk` (`id`, `nama`, `deskripsi`, `harga`, `berat`, `gambar`) VALUES
(32, 'Madu Sarang Premium MADU MURNI', 'MADU SARANG merupakan KOMBINASI MADU DAN SARANGNYA.\r\nMadu ini diambil langsung dengan sarangnya, tanpa dipisahkan terlebih dahulu.\r\ntekstur sarangnya empuk, rasa dan aroma madunya masih segar. jadi BUKAN SARANG TUA YANG SUDAH KOSONG KEMUDIAN DISIRAM MADU.\r\n\r\nKELEBIHAN :\r\nSemua manfaat yang terkandung dari madu sarang lebah bisa langsung dirasakan dgn tanpa perlu proses apapun juga. diantaranya madu murni, beepollen, royal jelly dan propolis.\r\n*tidak semua potongan sarang terdapat beepollennya.\r\n\r\nPENYIMPANAN :\r\n-Madu murni tidak ada expirednya. cukup ditutup rapat dan simpan ditempat yang sejuk,suhu ruangan', 150000, 700, 'madu-sarang.jpg'),
(40, '[10 Pcs] Pisang Goreng Madu \"Bu Siti\"', 'Dengan menggunakan pisang dan bahan-bahan pilihan terbaik, Pisang Goreng Madu “Bu Nanik” memiliki rasa manis alami dan tekstur renyah yang sangat khas.\r\nWarna dan corak kehitaman pada Pisang Goreng Madu “Bu Nanik” merupakan hasil karamelisasi dari madu berkualitas terbaik.\r\nPisang Goreng Madu “Bu Nanik” dijamin akan membuat anda ketagihan dari pertama kali anda mencobanya!\r\n\r\n——————————————————————————\r\n\r\nBerat :\r\n+- 1500 Gram (10 PCS)', 70000, 1500, 'pisang-goreng-madu.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_produk`
--
ALTER TABLE `tb_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
