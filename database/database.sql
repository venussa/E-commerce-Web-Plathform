-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Bulan Mei 2020 pada 04.06
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms_koi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_activity`
--

CREATE TABLE `db_activity` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `date_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_alert`
--

CREATE TABLE `db_alert` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `date_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_cancel_order`
--

CREATE TABLE `db_cancel_order` (
  `id` int(11) NOT NULL,
  `order_id` bigint(20) NOT NULL,
  `note` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` bigint(20) NOT NULL,
  `date_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_cart`
--

CREATE TABLE `db_cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_category`
--

CREATE TABLE `db_category` (
  `id` int(11) NOT NULL,
  `uniq_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `level` int(11) NOT NULL,
  `sublevel` int(11) NOT NULL,
  `img` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `transaction_scheme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `db_category`
--

INSERT INTO `db_category` (`id`, `uniq_id`, `title`, `description`, `level`, `sublevel`, `img`, `transaction_scheme`) VALUES
(1, 'IKN', 'Ikan', 'Ikan adalah anggota vertebrata poikilotermik (berdarah dingin) yang hidup di air dan bernapas dengan insang', 0, 0, '1580114157.png', 1),
(2, 'KLM', 'Kolam', 'Kolam adalah perairan di daratan yang lebih kecil ukurannya daripada danau. Kolam terbentuk secara alami atau dapat dibuat manusia', 0, 0, '1580114164.png', 0),
(3, 'PKN', 'Pakan', 'Pakan adalah makanan/asupan yang diberikan kepada hewan ternak (peliharaan)', 0, 0, '1580114170.png', 0),
(34, 'BGA', 'Ikan Konsumsi', 'Adalah ikan untuk kebutuhan konsumsi atau untuk dimakan', 1, 1, '', 1),
(35, 'KSU', 'Ikan Hias', 'Adalah ikan untuk tujuan sebagai pajangan atau hiasan atau peliharaan', 1, 1, '', 1),
(36, 'KTH', 'Kolam Tanah', '', 1, 2, '', 0),
(37, 'KKC', 'Kolam Kaca', '', 1, 2, '', 0),
(38, 'KFB', 'Kolam Fiber', '', 1, 2, '', 0),
(39, 'KBN', 'Kolam Beton', '', 1, 2, '', 0),
(40, 'KPS', 'Kolam Plastik', '', 1, 2, '', 0),
(41, 'PAN', 'Pakan Organik', 'Pakan berasal dari tanaman alami yang baik untuk kesehatan ikan terutama ikan konsumsi', 1, 3, '', 0),
(42, 'POR', 'Pakan Anorganik', 'Pakan yang sangat cocok untuk ikan hias guna menghasilkan warna ikan yang cermerlang dan menarik', 1, 3, '', 0),
(43, 'ACG', 'Alat Pancing', 'Memancing secara luas adalah suatu kegiatan menangkap ikan yang bisa merupakan pekerjaan, hobi, olahraga luar ruang (outdoor) atau kegiatan di pinggir atau di tengah danau, laut, sungai dan perairan lainnya dengan target seekor ikan', 0, 0, '1580115926.png', 0),
(44, 'JRG', 'Jaring', '', 1, 43, '', 0),
(45, 'JRN', 'Joran', '', 1, 43, '', 0),
(46, 'SNR', 'Senar', '', 1, 43, '', 0),
(47, 'UPN', 'Umpan', '', 1, 43, '', 0),
(48, 'BLT', 'Belut', 'kaya uler gan', 1, 1, '', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_chats`
--

CREATE TABLE `db_chats` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `img` text NOT NULL,
  `chat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `date_time` bigint(20) NOT NULL,
  `room` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `typing` int(11) NOT NULL,
  `privacy` int(11) NOT NULL,
  `chat_type` int(11) NOT NULL,
  `chat_object` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_chat_typing`
--

CREATE TABLE `db_chat_typing` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_custom_page`
--

CREATE TABLE `db_custom_page` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `slug` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `img` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `contact_form` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `position` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `date_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `db_custom_page`
--

INSERT INTO `db_custom_page` (`id`, `user_id`, `title`, `description`, `slug`, `img`, `content`, `contact_form`, `status`, `position`, `level`, `date_time`) VALUES
(2, 0, 'Tentang Kami', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies es', 'tentang-kami', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies est, eget maximus massa tortor ac enim. Proin varius vehicula sapien, nec hendrerit nulla auctor ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla tincidunt eros faucibus nisi luctus, sed facilisis dui viverra. Cras tincidunt, metus quis ornare finibus, nisi dui bibendum felis, a imperdiet justo dui quis nulla. Nam tincidunt odio in mauris mattis, eget gravida turpis bibendum. Donec a elit tristique, dictum massa vitae, eleifend sapien. Pellentesque feugiat iaculis tortor sit amet porta. Donec nulla eros, iaculis eget dignissim nec, faucibus id arcu. Morbi semper at metus ac lacinia. Phasellus posuere nisi velit, malesuada mattis nisl pulvinar placerat. Aenean elementum viverra nulla, sed facilisis ante tempor sed.</p>\r\n<p>Quisque vel tortor ex. Curabitur condimentum nunc eu gravida vestibulum. Proin viverra vestibulum nisi in volutpat. Donec fermentum at magna sed accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec scelerisque auctor ultricies. Etiam suscipit rhoncus ligula sed consequat. Maecenas rhoncus porttitor placerat. Maecenas pellentesque ante id ex ultrices semper. Nam dignissim sapien nec felis volutpat vulputate nec et ligula. Proin in sapien id mauris posuere ultrices. Duis libero lectus, sollicitudin ac consequat ut, imperdiet hendrerit arcu.</p>\r\n<p>Nulla ut ipsum id justo facilisis vulputate in a mi. Aenean quis tristique turpis. Phasellus luctus sem vel nisi tempor condimentum. Phasellus ac nisi sit amet mauris posuere fringilla sit amet id felis. Integer semper iaculis ligula, id volutpat enim ultricies eget. Nullam hendrerit eleifend tristique. In hac habitasse platea dictumst. Aenean maximus iaculis enim, in consequat sem. Proin ut posuere tellus.</p>\r\n<p>Pellentesque pharetra felis in velit dapibus, non commodo tellus suscipit. Vestibulum magna erat, feugiat vitae dignissim at, tincidunt eget nibh. Fusce in tincidunt velit. Donec accumsan blandit sagittis. Praesent lobortis suscipit molestie. Sed lobortis ultricies tortor et fermentum. Sed egestas dolor vel nisi volutpat, venenatis ullamcorper quam volutpat. Morbi sed aliquet orci, et lacinia felis. Aliquam id ex finibus, aliquam enim sed, vehicula lacus. Curabitur est ante, tincidunt ac condimentum at, aliquet in nulla. Integer gravida massa id lorem aliquet consequat.</p>\r\n<p>Mauris et mauris euismod, tempor felis at, hendrerit eros. Morbi pellentesque lacinia est, a dictum purus blandit vel. In semper dolor sed convallis lobortis. Nulla facilisi. Ut id leo pharetra, dictum eros ac, placerat turpis. Aenean vehicula venenatis efficitur. Sed auctor porttitor metus a accumsan. Ut tincidunt elit vel leo bibendum facilisis. Cras sodales nunc in dui bibendum, auctor ultricies lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id diam auctor, commodo dolor eu, efficitur lacus. Cras convallis ornare leo eu mollis. In ullamcorper turpis sit amet ligula dapibus, eget commodo velit hendrerit.</p>', 0, 1, 1, 0, 0),
(3, 0, 'Hubungi Kami', '', 'hubungi-kami', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies est, eget maximus massa tortor ac enim. Proin varius vehicula sapien, nec hendrerit nulla auctor ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla tincidunt eros faucibus nisi luctus, sed facilisis dui viverra. Cras tincidunt, metus quis ornare finibus, nisi dui bibendum felis, a imperdiet justo dui quis nulla. Nam tincidunt odio in mauris mattis, eget gravida turpis bibendum. Donec a elit tristique, dictum massa vitae, eleifend sapien. Pellentesque feugiat iaculis tortor sit amet porta. Donec nulla eros, iaculis eget dignissim nec, faucibus id arcu. Morbi semper at metus ac lacinia. Phasellus posuere nisi velit, malesuada mattis nisl pulvinar placerat. Aenean elementum viverra nulla, sed facilisis ante tempor sed.</p>\r\n<p>Quisque vel tortor ex. Curabitur condimentum nunc eu gravida vestibulum. Proin viverra vestibulum nisi in volutpat. Donec fermentum at magna sed accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec scelerisque auctor ultricies. Etiam suscipit rhoncus ligula sed consequat. Maecenas rhoncus porttitor placerat. Maecenas pellentesque ante id ex ultrices semper. Nam dignissim sapien nec felis volutpat vulputate nec et ligula. Proin in sapien id mauris posuere ultrices. Duis libero lectus, sollicitudin ac consequat ut, imperdiet hendrerit arcu.</p>\r\n<p>Nulla ut ipsum id justo facilisis vulputate in a mi. Aenean quis tristique turpis. Phasellus luctus sem vel nisi tempor condimentum. Phasellus ac nisi sit amet mauris posuere fringilla sit amet id felis. Integer semper iaculis ligula, id volutpat enim ultricies eget. Nullam hendrerit eleifend tristique. In hac habitasse platea dictumst. Aenean maximus iaculis enim, in consequat sem. Proin ut posuere tellus.</p>\r\n<p>Pellentesque pharetra felis in velit dapibus, non commodo tellus suscipit. Vestibulum magna erat, feugiat vitae dignissim at, tincidunt eget nibh. Fusce in tincidunt velit. Donec accumsan blandit sagittis. Praesent lobortis suscipit molestie. Sed lobortis ultricies tortor et fermentum. Sed egestas dolor vel nisi volutpat, venenatis ullamcorper quam volutpat. Morbi sed aliquet orci, et lacinia felis. Aliquam id ex finibus, aliquam enim sed, vehicula lacus. Curabitur est ante, tincidunt ac condimentum at, aliquet in nulla. Integer gravida massa id lorem aliquet consequat.</p>\r\n<p>Mauris et mauris euismod, tempor felis at, hendrerit eros. Morbi pellentesque lacinia est, a dictum purus blandit vel. In semper dolor sed convallis lobortis. Nulla facilisi. Ut id leo pharetra, dictum eros ac, placerat turpis. Aenean vehicula venenatis efficitur. Sed auctor porttitor metus a accumsan. Ut tincidunt elit vel leo bibendum facilisis. Cras sodales nunc in dui bibendum, auctor ultricies lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id diam auctor, commodo dolor eu, efficitur lacus. Cras convallis ornare leo eu mollis. In ullamcorper turpis sit amet ligula dapibus, eget commodo velit hendrerit.</p>', 1, 1, 2, 0, 0),
(4, 0, 'Syarat & Ketentuan', '', 'syarat-ketentuan', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies est, eget maximus massa tortor ac enim. Proin varius vehicula sapien, nec hendrerit nulla auctor ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla tincidunt eros faucibus nisi luctus, sed facilisis dui viverra. Cras tincidunt, metus quis ornare finibus, nisi dui bibendum felis, a imperdiet justo dui quis nulla. Nam tincidunt odio in mauris mattis, eget gravida turpis bibendum. Donec a elit tristique, dictum massa vitae, eleifend sapien. Pellentesque feugiat iaculis tortor sit amet porta. Donec nulla eros, iaculis eget dignissim nec, faucibus id arcu. Morbi semper at metus ac lacinia. Phasellus posuere nisi velit, malesuada mattis nisl pulvinar placerat. Aenean elementum viverra nulla, sed facilisis ante tempor sed.</p>\r\n<p>Quisque vel tortor ex. Curabitur condimentum nunc eu gravida vestibulum. Proin viverra vestibulum nisi in volutpat. Donec fermentum at magna sed accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec scelerisque auctor ultricies. Etiam suscipit rhoncus ligula sed consequat. Maecenas rhoncus porttitor placerat. Maecenas pellentesque ante id ex ultrices semper. Nam dignissim sapien nec felis volutpat vulputate nec et ligula. Proin in sapien id mauris posuere ultrices. Duis libero lectus, sollicitudin ac consequat ut, imperdiet hendrerit arcu.</p>\r\n<p>Nulla ut ipsum id justo facilisis vulputate in a mi. Aenean quis tristique turpis. Phasellus luctus sem vel nisi tempor condimentum. Phasellus ac nisi sit amet mauris posuere fringilla sit amet id felis. Integer semper iaculis ligula, id volutpat enim ultricies eget. Nullam hendrerit eleifend tristique. In hac habitasse platea dictumst. Aenean maximus iaculis enim, in consequat sem. Proin ut posuere tellus.</p>\r\n<p>Pellentesque pharetra felis in velit dapibus, non commodo tellus suscipit. Vestibulum magna erat, feugiat vitae dignissim at, tincidunt eget nibh. Fusce in tincidunt velit. Donec accumsan blandit sagittis. Praesent lobortis suscipit molestie. Sed lobortis ultricies tortor et fermentum. Sed egestas dolor vel nisi volutpat, venenatis ullamcorper quam volutpat. Morbi sed aliquet orci, et lacinia felis. Aliquam id ex finibus, aliquam enim sed, vehicula lacus. Curabitur est ante, tincidunt ac condimentum at, aliquet in nulla. Integer gravida massa id lorem aliquet consequat.</p>\r\n<p>Mauris et mauris euismod, tempor felis at, hendrerit eros. Morbi pellentesque lacinia est, a dictum purus blandit vel. In semper dolor sed convallis lobortis. Nulla facilisi. Ut id leo pharetra, dictum eros ac, placerat turpis. Aenean vehicula venenatis efficitur. Sed auctor porttitor metus a accumsan. Ut tincidunt elit vel leo bibendum facilisis. Cras sodales nunc in dui bibendum, auctor ultricies lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id diam auctor, commodo dolor eu, efficitur lacus. Cras convallis ornare leo eu mollis. In ullamcorper turpis sit amet ligula dapibus, eget commodo velit hendrerit.</p>', 0, 1, 3, 0, 0),
(5, 0, 'Kebijakan Privasi', '', 'kebijakan-privasi', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies est, eget maximus massa tortor ac enim. Proin varius vehicula sapien, nec hendrerit nulla auctor ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla tincidunt eros faucibus nisi luctus, sed facilisis dui viverra. Cras tincidunt, metus quis ornare finibus, nisi dui bibendum felis, a imperdiet justo dui quis nulla. Nam tincidunt odio in mauris mattis, eget gravida turpis bibendum. Donec a elit tristique, dictum massa vitae, eleifend sapien. Pellentesque feugiat iaculis tortor sit amet porta. Donec nulla eros, iaculis eget dignissim nec, faucibus id arcu. Morbi semper at metus ac lacinia. Phasellus posuere nisi velit, malesuada mattis nisl pulvinar placerat. Aenean elementum viverra nulla, sed facilisis ante tempor sed.</p>\r\n<p>Quisque vel tortor ex. Curabitur condimentum nunc eu gravida vestibulum. Proin viverra vestibulum nisi in volutpat. Donec fermentum at magna sed accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec scelerisque auctor ultricies. Etiam suscipit rhoncus ligula sed consequat. Maecenas rhoncus porttitor placerat. Maecenas pellentesque ante id ex ultrices semper. Nam dignissim sapien nec felis volutpat vulputate nec et ligula. Proin in sapien id mauris posuere ultrices. Duis libero lectus, sollicitudin ac consequat ut, imperdiet hendrerit arcu.</p>\r\n<p>Nulla ut ipsum id justo facilisis vulputate in a mi. Aenean quis tristique turpis. Phasellus luctus sem vel nisi tempor condimentum. Phasellus ac nisi sit amet mauris posuere fringilla sit amet id felis. Integer semper iaculis ligula, id volutpat enim ultricies eget. Nullam hendrerit eleifend tristique. In hac habitasse platea dictumst. Aenean maximus iaculis enim, in consequat sem. Proin ut posuere tellus.</p>\r\n<p>Pellentesque pharetra felis in velit dapibus, non commodo tellus suscipit. Vestibulum magna erat, feugiat vitae dignissim at, tincidunt eget nibh. Fusce in tincidunt velit. Donec accumsan blandit sagittis. Praesent lobortis suscipit molestie. Sed lobortis ultricies tortor et fermentum. Sed egestas dolor vel nisi volutpat, venenatis ullamcorper quam volutpat. Morbi sed aliquet orci, et lacinia felis. Aliquam id ex finibus, aliquam enim sed, vehicula lacus. Curabitur est ante, tincidunt ac condimentum at, aliquet in nulla. Integer gravida massa id lorem aliquet consequat.</p>\r\n<p>Mauris et mauris euismod, tempor felis at, hendrerit eros. Morbi pellentesque lacinia est, a dictum purus blandit vel. In semper dolor sed convallis lobortis. Nulla facilisi. Ut id leo pharetra, dictum eros ac, placerat turpis. Aenean vehicula venenatis efficitur. Sed auctor porttitor metus a accumsan. Ut tincidunt elit vel leo bibendum facilisis. Cras sodales nunc in dui bibendum, auctor ultricies lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id diam auctor, commodo dolor eu, efficitur lacus. Cras convallis ornare leo eu mollis. In ullamcorper turpis sit amet ligula dapibus, eget commodo velit hendrerit.</p>', 0, 1, 4, 0, 0),
(6, 0, 'Pusat Bantuan', '', 'pusat-bantuan', '', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies est, eget maximus massa tortor ac enim. Proin varius vehicula sapien, nec hendrerit nulla auctor ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla tincidunt eros faucibus nisi luctus, sed facilisis dui viverra. Cras tincidunt, metus quis ornare finibus, nisi dui bibendum felis, a imperdiet justo dui quis nulla. Nam tincidunt odio in mauris mattis, eget gravida turpis bibendum. Donec a elit tristique, dictum massa vitae, eleifend sapien. Pellentesque feugiat iaculis tortor sit amet porta. Donec nulla eros, iaculis eget dignissim nec, faucibus id arcu. Morbi semper at metus ac lacinia. Phasellus posuere nisi velit, malesuada mattis nisl pulvinar placerat. Aenean elementum viverra nulla, sed facilisis ante tempor sed.</p>\r\n<p>Quisque vel tortor ex. Curabitur condimentum nunc eu gravida vestibulum. Proin viverra vestibulum nisi in volutpat. Donec fermentum at magna sed accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec scelerisque auctor ultricies. Etiam suscipit rhoncus ligula sed consequat. Maecenas rhoncus porttitor placerat. Maecenas pellentesque ante id ex ultrices semper. Nam dignissim sapien nec felis volutpat vulputate nec et ligula. Proin in sapien id mauris posuere ultrices. Duis libero lectus, sollicitudin ac consequat ut, imperdiet hendrerit arcu.</p>\r\n<p>Nulla ut ipsum id justo facilisis vulputate in a mi. Aenean quis tristique turpis. Phasellus luctus sem vel nisi tempor condimentum. Phasellus ac nisi sit amet mauris posuere fringilla sit amet id felis. Integer semper iaculis ligula, id volutpat enim ultricies eget. Nullam hendrerit eleifend tristique. In hac habitasse platea dictumst. Aenean maximus iaculis enim, in consequat sem. Proin ut posuere tellus.</p>\r\n<p>Pellentesque pharetra felis in velit dapibus, non commodo tellus suscipit. Vestibulum magna erat, feugiat vitae dignissim at, tincidunt eget nibh. Fusce in tincidunt velit. Donec accumsan blandit sagittis. Praesent lobortis suscipit molestie. Sed lobortis ultricies tortor et fermentum. Sed egestas dolor vel nisi volutpat, venenatis ullamcorper quam volutpat. Morbi sed aliquet orci, et lacinia felis. Aliquam id ex finibus, aliquam enim sed, vehicula lacus. Curabitur est ante, tincidunt ac condimentum at, aliquet in nulla. Integer gravida massa id lorem aliquet consequat.</p>\r\n<p>Mauris et mauris euismod, tempor felis at, hendrerit eros. Morbi pellentesque lacinia est, a dictum purus blandit vel. In semper dolor sed convallis lobortis. Nulla facilisi. Ut id leo pharetra, dictum eros ac, placerat turpis. Aenean vehicula venenatis efficitur. Sed auctor porttitor metus a accumsan. Ut tincidunt elit vel leo bibendum facilisis. Cras sodales nunc in dui bibendum, auctor ultricies lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id diam auctor, commodo dolor eu, efficitur lacus. Cras convallis ornare leo eu mollis. In ullamcorper turpis sit amet ligula dapibus, eget commodo velit hendrerit.</p>', 0, 1, 5, 0, 0),
(8, 0, 'Promo Gajian Warnai Awal Bulan', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies es', 'promo-gajian-warnai-awal-bulan', '1582602585.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies est, eget maximus massa tortor ac enim. Proin varius vehicula sapien, nec hendrerit nulla auctor ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla tincidunt eros faucibus nisi luctus, sed facilisis dui viverra. Cras tincidunt, metus quis ornare finibus, nisi dui bibendum felis, a imperdiet justo dui quis nulla. Nam tincidunt odio in mauris mattis, eget gravida turpis bibendum. Donec a elit tristique, dictum massa vitae, eleifend sapien. Pellentesque feugiat iaculis tortor sit amet porta. Donec nulla eros, iaculis eget dignissim nec, faucibus id arcu. Morbi semper at metus ac lacinia. Phasellus posuere nisi velit, malesuada mattis nisl pulvinar placerat. Aenean elementum viverra nulla, sed facilisis ante tempor sed.</p>\r\n<p>Quisque vel tortor ex. Curabitur condimentum nunc eu gravida vestibulum. Proin viverra vestibulum nisi in volutpat. Donec fermentum at magna sed accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec scelerisque auctor ultricies. Etiam suscipit rhoncus ligula sed consequat. Maecenas rhoncus porttitor placerat. Maecenas pellentesque ante id ex ultrices semper. Nam dignissim sapien nec felis volutpat vulputate nec et ligula. Proin in sapien id mauris posuere ultrices. Duis libero lectus, sollicitudin ac consequat ut, imperdiet hendrerit arcu.</p>\r\n<p>Nulla ut ipsum id justo facilisis vulputate in a mi. Aenean quis tristique turpis. Phasellus luctus sem vel nisi tempor condimentum. Phasellus ac nisi sit amet mauris posuere fringilla sit amet id felis. Integer semper iaculis ligula, id volutpat enim ultricies eget. Nullam hendrerit eleifend tristique. In hac habitasse platea dictumst. Aenean maximus iaculis enim, in consequat sem. Proin ut posuere tellus.</p>\r\n<p>Pellentesque pharetra felis in velit dapibus, non commodo tellus suscipit. Vestibulum magna erat, feugiat vitae dignissim at, tincidunt eget nibh. Fusce in tincidunt velit. Donec accumsan blandit sagittis. Praesent lobortis suscipit molestie. Sed lobortis ultricies tortor et fermentum. Sed egestas dolor vel nisi volutpat, venenatis ullamcorper quam volutpat. Morbi sed aliquet orci, et lacinia felis. Aliquam id ex finibus, aliquam enim sed, vehicula lacus. Curabitur est ante, tincidunt ac condimentum at, aliquet in nulla. Integer gravida massa id lorem aliquet consequat.</p>\r\n<p>Mauris et mauris euismod, tempor felis at, hendrerit eros. Morbi pellentesque lacinia est, a dictum purus blandit vel. In semper dolor sed convallis lobortis. Nulla facilisi. Ut id leo pharetra, dictum eros ac, placerat turpis. Aenean vehicula venenatis efficitur. Sed auctor porttitor metus a accumsan. Ut tincidunt elit vel leo bibendum facilisis. Cras sodales nunc in dui bibendum, auctor ultricies lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id diam auctor, commodo dolor eu, efficitur lacus. Cras convallis ornare leo eu mollis. In ullamcorper turpis sit amet ligula dapibus, eget commodo velit hendrerit.</p>', 0, 1, 1, 1, 0),
(9, 0, 'Promo Bebas Ongking Tanpa Minimum Belanja', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies es', 'promo-bebas-ongking-tanpa-minimum-belanja', '1582602597.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies est, eget maximus massa tortor ac enim. Proin varius vehicula sapien, nec hendrerit nulla auctor ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla tincidunt eros faucibus nisi luctus, sed facilisis dui viverra. Cras tincidunt, metus quis ornare finibus, nisi dui bibendum felis, a imperdiet justo dui quis nulla. Nam tincidunt odio in mauris mattis, eget gravida turpis bibendum. Donec a elit tristique, dictum massa vitae, eleifend sapien. Pellentesque feugiat iaculis tortor sit amet porta. Donec nulla eros, iaculis eget dignissim nec, faucibus id arcu. Morbi semper at metus ac lacinia. Phasellus posuere nisi velit, malesuada mattis nisl pulvinar placerat. Aenean elementum viverra nulla, sed facilisis ante tempor sed.</p>\r\n<p>Quisque vel tortor ex. Curabitur condimentum nunc eu gravida vestibulum. Proin viverra vestibulum nisi in volutpat. Donec fermentum at magna sed accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec scelerisque auctor ultricies. Etiam suscipit rhoncus ligula sed consequat. Maecenas rhoncus porttitor placerat. Maecenas pellentesque ante id ex ultrices semper. Nam dignissim sapien nec felis volutpat vulputate nec et ligula. Proin in sapien id mauris posuere ultrices. Duis libero lectus, sollicitudin ac consequat ut, imperdiet hendrerit arcu.</p>\r\n<p>Nulla ut ipsum id justo facilisis vulputate in a mi. Aenean quis tristique turpis. Phasellus luctus sem vel nisi tempor condimentum. Phasellus ac nisi sit amet mauris posuere fringilla sit amet id felis. Integer semper iaculis ligula, id volutpat enim ultricies eget. Nullam hendrerit eleifend tristique. In hac habitasse platea dictumst. Aenean maximus iaculis enim, in consequat sem. Proin ut posuere tellus.</p>\r\n<p>Pellentesque pharetra felis in velit dapibus, non commodo tellus suscipit. Vestibulum magna erat, feugiat vitae dignissim at, tincidunt eget nibh. Fusce in tincidunt velit. Donec accumsan blandit sagittis. Praesent lobortis suscipit molestie. Sed lobortis ultricies tortor et fermentum. Sed egestas dolor vel nisi volutpat, venenatis ullamcorper quam volutpat. Morbi sed aliquet orci, et lacinia felis. Aliquam id ex finibus, aliquam enim sed, vehicula lacus. Curabitur est ante, tincidunt ac condimentum at, aliquet in nulla. Integer gravida massa id lorem aliquet consequat.</p>\r\n<p>Mauris et mauris euismod, tempor felis at, hendrerit eros. Morbi pellentesque lacinia est, a dictum purus blandit vel. In semper dolor sed convallis lobortis. Nulla facilisi. Ut id leo pharetra, dictum eros ac, placerat turpis. Aenean vehicula venenatis efficitur. Sed auctor porttitor metus a accumsan. Ut tincidunt elit vel leo bibendum facilisis. Cras sodales nunc in dui bibendum, auctor ultricies lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id diam auctor, commodo dolor eu, efficitur lacus. Cras convallis ornare leo eu mollis. In ullamcorper turpis sit amet ligula dapibus, eget commodo velit hendrerit.</p>', 0, 1, 2, 1, 0),
(10, 0, 'Harga Khsusus Untuk Pengembang Web Deveoper', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies es', 'harga-khsusus-untuk-pengembang-web-deveoper', '1582602607.jpg', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies est, eget maximus massa tortor ac enim. Proin varius vehicula sapien, nec hendrerit nulla auctor ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla tincidunt eros faucibus nisi luctus, sed facilisis dui viverra. Cras tincidunt, metus quis ornare finibus, nisi dui bibendum felis, a imperdiet justo dui quis nulla. Nam tincidunt odio in mauris mattis, eget gravida turpis bibendum. Donec a elit tristique, dictum massa vitae, eleifend sapien. Pellentesque feugiat iaculis tortor sit amet porta. Donec nulla eros, iaculis eget dignissim nec, faucibus id arcu. Morbi semper at metus ac lacinia. Phasellus posuere nisi velit, malesuada mattis nisl pulvinar placerat. Aenean elementum viverra nulla, sed facilisis ante tempor sed.</p>\r\n<p>Quisque vel tortor ex. Curabitur condimentum nunc eu gravida vestibulum. Proin viverra vestibulum nisi in volutpat. Donec fermentum at magna sed accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec scelerisque auctor ultricies. Etiam suscipit rhoncus ligula sed consequat. Maecenas rhoncus porttitor placerat. Maecenas pellentesque ante id ex ultrices semper. Nam dignissim sapien nec felis volutpat vulputate nec et ligula. Proin in sapien id mauris posuere ultrices. Duis libero lectus, sollicitudin ac consequat ut, imperdiet hendrerit arcu.</p>\r\n<p>Nulla ut ipsum id justo facilisis vulputate in a mi. Aenean quis tristique turpis. Phasellus luctus sem vel nisi tempor condimentum. Phasellus ac nisi sit amet mauris posuere fringilla sit amet id felis. Integer semper iaculis ligula, id volutpat enim ultricies eget. Nullam hendrerit eleifend tristique. In hac habitasse platea dictumst. Aenean maximus iaculis enim, in consequat sem. Proin ut posuere tellus.</p>\r\n<p>Pellentesque pharetra felis in velit dapibus, non commodo tellus suscipit. Vestibulum magna erat, feugiat vitae dignissim at, tincidunt eget nibh. Fusce in tincidunt velit. Donec accumsan blandit sagittis. Praesent lobortis suscipit molestie. Sed lobortis ultricies tortor et fermentum. Sed egestas dolor vel nisi volutpat, venenatis ullamcorper quam volutpat. Morbi sed aliquet orci, et lacinia felis. Aliquam id ex finibus, aliquam enim sed, vehicula lacus. Curabitur est ante, tincidunt ac condimentum at, aliquet in nulla. Integer gravida massa id lorem aliquet consequat.</p>\r\n<p>Mauris et mauris euismod, tempor felis at, hendrerit eros. Morbi pellentesque lacinia est, a dictum purus blandit vel. In semper dolor sed convallis lobortis. Nulla facilisi. Ut id leo pharetra, dictum eros ac, placerat turpis. Aenean vehicula venenatis efficitur. Sed auctor porttitor metus a accumsan. Ut tincidunt elit vel leo bibendum facilisis. Cras sodales nunc in dui bibendum, auctor ultricies lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id diam auctor, commodo dolor eu, efficitur lacus. Cras convallis ornare leo eu mollis. In ullamcorper turpis sit amet ligula dapibus, eget commodo velit hendrerit.</p>', 0, 1, 3, 1, 0),
(11, 0, 'Promo Masker Cegah Penyebaran Corona', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies es', 'promo-masker-cegah-penyebaran-corona', '1582602616.png', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras condimentum tristique tempor. Integer eleifend, ante et cursus scelerisque, metus est ultricies est, eget maximus massa tortor ac enim. Proin varius vehicula sapien, nec hendrerit nulla auctor ac. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Nulla tincidunt eros faucibus nisi luctus, sed facilisis dui viverra. Cras tincidunt, metus quis ornare finibus, nisi dui bibendum felis, a imperdiet justo dui quis nulla. Nam tincidunt odio in mauris mattis, eget gravida turpis bibendum. Donec a elit tristique, dictum massa vitae, eleifend sapien. Pellentesque feugiat iaculis tortor sit amet porta. Donec nulla eros, iaculis eget dignissim nec, faucibus id arcu. Morbi semper at metus ac lacinia. Phasellus posuere nisi velit, malesuada mattis nisl pulvinar placerat. Aenean elementum viverra nulla, sed facilisis ante tempor sed.</p>\r\n<p>Quisque vel tortor ex. Curabitur condimentum nunc eu gravida vestibulum. Proin viverra vestibulum nisi in volutpat. Donec fermentum at magna sed accumsan. Interdum et malesuada fames ac ante ipsum primis in faucibus. Donec scelerisque auctor ultricies. Etiam suscipit rhoncus ligula sed consequat. Maecenas rhoncus porttitor placerat. Maecenas pellentesque ante id ex ultrices semper. Nam dignissim sapien nec felis volutpat vulputate nec et ligula. Proin in sapien id mauris posuere ultrices. Duis libero lectus, sollicitudin ac consequat ut, imperdiet hendrerit arcu.</p>\r\n<p>Nulla ut ipsum id justo facilisis vulputate in a mi. Aenean quis tristique turpis. Phasellus luctus sem vel nisi tempor condimentum. Phasellus ac nisi sit amet mauris posuere fringilla sit amet id felis. Integer semper iaculis ligula, id volutpat enim ultricies eget. Nullam hendrerit eleifend tristique. In hac habitasse platea dictumst. Aenean maximus iaculis enim, in consequat sem. Proin ut posuere tellus.</p>\r\n<p>Pellentesque pharetra felis in velit dapibus, non commodo tellus suscipit. Vestibulum magna erat, feugiat vitae dignissim at, tincidunt eget nibh. Fusce in tincidunt velit. Donec accumsan blandit sagittis. Praesent lobortis suscipit molestie. Sed lobortis ultricies tortor et fermentum. Sed egestas dolor vel nisi volutpat, venenatis ullamcorper quam volutpat. Morbi sed aliquet orci, et lacinia felis. Aliquam id ex finibus, aliquam enim sed, vehicula lacus. Curabitur est ante, tincidunt ac condimentum at, aliquet in nulla. Integer gravida massa id lorem aliquet consequat.</p>\r\n<p>Mauris et mauris euismod, tempor felis at, hendrerit eros. Morbi pellentesque lacinia est, a dictum purus blandit vel. In semper dolor sed convallis lobortis. Nulla facilisi. Ut id leo pharetra, dictum eros ac, placerat turpis. Aenean vehicula venenatis efficitur. Sed auctor porttitor metus a accumsan. Ut tincidunt elit vel leo bibendum facilisis. Cras sodales nunc in dui bibendum, auctor ultricies lorem consequat. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus id diam auctor, commodo dolor eu, efficitur lacus. Cras convallis ornare leo eu mollis. In ullamcorper turpis sit amet ligula dapibus, eget commodo velit hendrerit.</p>', 0, 1, 4, 1, 0),
(23, 1, '12 Jenis Ikan Molly atau Ikan Balon Tervaforit hingga Termahal', 'Ikan molly atau ikan balon sudah menjadi idaman para pecinta ikan di Indonesia. Salah satu jenis ikan hias berpenampilan imut ini memang mempunyai fisik yang menggemaskan bila dipandang mata.', '12-jenis-ikan-molly-atau-ikan-balon-tervaforit-hingga-termahal', '1582609954.jpg', '<p>Ikan molly atau ikan balon sudah menjadi idaman para pecinta ikan di Indonesia. Salah satu jenis ikan hias berpenampilan imut ini memang mempunyai fisik yang menggemaskan bila dipandang mata.</p>\r\n<p>Ikan yang berasal dari Meksiko ini pada awalnya dikonsumsi, tapi karena bentuk fisiknya yang sangat indah dengan corak di setiap badannya maka binatang satu ini dijadikan peliharaan dan sebagai cinderamata rumah.</p>\r\n<p>Untuk membedakan jenis-jenis molly memang sulit. Coraknya di setiap badan juga cukup&nbsp; banyak, sehingga sangat sulit untuk dibedakan.</p>\r\n<p>Oleh karena itu, pastinya kamu harus tahu terfavorit dan paling lucu jenis molly berikut ini agar kamu bisa membedakannya saat membelinya!</p>\r\n<p><br /><strong>1. Black Molly</strong></p>\r\n<p><strong><img src=../sources/galery/fish-1529192_1920-701x467.jpg alt=fish-1529192_1920-701x467 width=100% /> </strong></p>\r\n<p>Jenis ikan molly yang pertama ini memiliki warna sisik yang hitam di sekujur tubuhnya hingga ekor dan sirip. Jika disimpan dalam akuarium sebagai ikan hias, kamu harus memilih tangki yang sesuai ukuran dengan karakter kepribadian yang sama dengan molly hitam.</p>\r\n<p>Warnanya yang hitam pekat, membuatnya terlihat begitu eksotis ketika tersorot lampu akuarium.</p>\r\n<p><strong>2. Dalmatian Molly</strong></p>\r\n<p><strong><img src=../sources/galery/img_3775.jpg alt=img_3775 width=100% /> </strong></p>\r\n<p>Mempunyai corak yang sama seperti anjing dalmatian, ikan ini menjadi jajaran top ikan balon terfavorit. Jenis molly yang satu ini sedikit berbeda dan spesial, Toppers.</p>\r\n<p>Mereka bisa tumbuh sedikit lebih besar dari molly hitam biasa, rata-rata sedikit di bawah 5 inci. Semakin banyak corak hitam-putih, maka ia semakin cantik untuk dilihat.</p>\r\n<p><strong>3. Black Sailfin Molly</strong></p>\r\n<p><strong><img src=../sources/galery/ikas-mas-koki-ryukin-1000x667.jpg alt=ikas-mas-koki-ryukin-1000x667 width=100% /> </strong></p>\r\n<p>Ikan sailfin molly memiliki sirip yang indah dan panjang. Sekilas ia terlihat seperti ikan cupang hias.</p>\r\n<p>Jenis ikan balon yang satu ini juga mudah berkembang biak dan dirawat dan sangat direkomendasikan untuk para pemula yang ingin memeliharanya sebagai ikan hias atau ternak.</p>\r\n<p><strong>4. Wild Green Sailfin Molly</strong></p>\r\n<p><strong><img src=../sources/galery/Sukses-dan-Berhasil-Berkat-Budidaya-Ikan-Koi-pixabay.jpg alt=Sukses-dan-Berhasil-Berkat-Budidaya-Ikan-Koi-pixabay width=100% /> </strong></p>\r\n<p>Jenis ikan ini masuk ke dalam kelompok sailfin molly yang artinya, molly bersirip panjang. Spesies ini cukup menarik karena langka dan dihargai cukup tinggi.</p>\r\n<p>Sesuai namanya, ikan ini memiliki warna dasar abu abu kehijauan dengan warna oranye.</p>\r\n<p><strong>5. Yucatan Molly</strong></p>\r\n<p><strong><img src=../sources/galery/Pemkot_Jakarta_Pusat_Akan_Gelar_Kontes_Ikan_Mas.original.jpg alt=Pemkot_Jakarta_Pusat_Akan_Gelar_Kontes_Ikan_Mas.original width=100% /> </strong></p>\r\n<p>Yucatan molly juga tergolong dalam sailfin molly. Yucatan molly memiliki warna yang kerap dijumpai ialah merah dan ada sedikit putih di bagian perutnya.</p>\r\n<p>Ikan ini terlihat cantik karena bersirip kekar. Ukuran tubuhnya juga tidak terlalu besar, ia hanya bisa tumbuh hingga 12 centimeter (cm).</p>\r\n<p><strong>6. Poecilia Latipinna Molly</strong></p>\r\n<p><strong><img src=../sources/galery/Ciri-ciri-Ikan-Arwana-Golden-Red.jpg alt=Ciri-ciri-Ikan-Arwana-Golden-Red width=100% /> </strong></p>\r\n<p>Jenis ikan sailfin molly ini memiliki keunikan bentuk pola tubuhnya bintik-bintik dengan sirip punggung yang agak lebar. Habitat poecilia latipinna berada di sungai San Antonio Texas.</p>\r\n<p>Walaupun memiliki ukuran maksimal hanya sebesar 12 cm, sang betina bisa memiliki ukuran tubuh yang besar dari si jantan.</p>\r\n<p>Penuhi asupan oksigen ikan dengan alat berkualitas di sini!</p>\r\n<p><br /><strong>7. Silver Sailfin Molly</strong></p>\r\n<p><strong><img src=../sources/galery/Blog_Jenis-Ikan-Mas-Koki-Lucu-Cantik-Paling-Populer.jpg alt=Blog_Jenis-Ikan-Mas-Koki-Lucu-Cantik-Paling-Populer width=100% /> </strong></p>\r\n<p>Hasil dari hybrid Poecilia, molly sailfin Putih atau Perak memiliki sisik keperakan dan sirip panjang yang indah. Biasanya, sang betina tumbuh lebih besar dari pada si jantan dan lebih berat.</p>\r\n<p>Si jantan mempunyai sisi lain yang sedikit lebih berwarna dengan menampilkan tanda oranye di daerah punggung dan tubuh mereka serta tanda pirus pada sirip ekor mereka.</p>\r\n<p><strong>8. Golden Black Molly</strong></p>\r\n<p><strong><img src=../sources/galery/budidaya-ikan-lele.jpg alt=budidaya-ikan-lele width=100% /> </strong></p>\r\n<p>Golden black molly memiliki ciri tubuh yang khas. Dengan warna emasnya yang membalut tubuhnya dari kepala sampai perut lalu sebagiannya warna hitam.</p>\r\n<p>Perpaduan ini justru membuat para kolektor diluar sana memburu jenis ikan molly ini.</p>\r\n<p><strong>9. Balloon Molly</strong></p>\r\n<p><strong><img src=../sources/galery/budidaya-ikan-lele-sangkuriang.png alt=budidaya-ikan-lele-sangkuriang width=100% /> </strong></p>\r\n<p>Dengan bentuk tubuhnya yang menyerupai balon, tentu kamu pernah melihat ikan molly jenis ini di berbagai tempat. Ya, jenis ini memang cukup populer di lingkungan masyarakat.</p>\r\n<p><strong>10. Lyretail Molly</strong></p>\r\n<p><strong><img src=../sources/galery/30bd5f4ece249b74c03b1ab4d74faf61.jpg alt=30bd5f4ece249b74c03b1ab4d74faf61 width=100% /> </strong></p>\r\n<p>Berbeda dengan sailfin, lyretail molly memiliki ciri pada ekornya dan warnanya yang beragam. Ekornya seperti ada pita di bagian ujung atas dan bawah.</p>\r\n<p>Dan, rata-rata berwarna belang belang dikombinasikan dengan warna cantik.</p>\r\n<p><strong>11. Platinum Lyretail Molly</strong></p>\r\n<p><strong><img src=../sources/galery/grosir-ikan-koi-blita-hewan-dan-perlengkapan-ikan-8974559.jpg alt=grosir-ikan-koi-blita-hewan-dan-perlengkapan-ikan-8974559 width=100% /> </strong></p>\r\n<p>Jenis hybrid dari lyretail molly ini memiliki tubuh platinum atau emas dan sirip punggung tinggi yang hanya akan berkibar dengan indah jika tersedia ruang yang cukup luas pada tangkinya.</p>\r\n<p>Jadi, ikan molly jenis platinum lyretail ini sangat cocok dipelihara di akuarium mini di rumah kamu.</p>\r\n<p><strong>12. Marbel Molly</strong></p>\r\n<p><strong><img src=../sources/galery/99b1b1dcb454878eaa6a560047798e16.jpg alt=99b1b1dcb454878eaa6a560047798e16 width=100% /> <br /> </strong></p>\r\n<p>Ikan molly jenis marbel ini merupakan hasil perkawinan silang yang kemudian menghasilkan jenis baru bernama molly marbel.</p>\r\n<p>Dipenuhi warna putih dan disertai bercak bercak hitam di dalamnya, molly marbel terlihat sangat anggun dan menawan.</p>\r\n<p>Nah, itulah jenis-jenis ikan molly terfavorit dan terlucu yang dapat menjadi sumber informasi kamu. Ikan molly di atas masih bisa dikawin-silangkan, sehingga melahirkan jenis molly yang baru, lho! Mana yang jadi favoritmu?</p>', 0, 1, 0, 2, 1582630808),
(24, 1, 'Jenis Ikan Mas Koki Lucu & Cantik Paling Populer', 'Jenis Ikan Mas Koki – Ikan Mas Koki merupakan salah satu jenis ikan hias air tawar populer yang sangat mudah ditemui di Indonesia. Tak hanya karena tampilannya yang lucu dan cantik, perawatan Ikan Mas Koki yang cukup sederhana menjadikannya primadona ikan hias yang tak boleh dilewatkan oleh para kolektor ikan hias.', 'jenis-ikan-mas-koki-lucu-cantik-paling-populer', '1582610573.jpg', '<p>Jenis Ikan Mas Koki &ndash; Ikan Mas Koki merupakan salah satu jenis ikan hias air tawar populer yang sangat mudah ditemui di Indonesia. Tak hanya karena tampilannya yang lucu dan cantik, perawatan Ikan Mas Koki yang cukup sederhana menjadikannya primadona ikan hias yang tak boleh dilewatkan oleh para kolektor ikan hias.</p>\r\n<p>Selain memiliki banyak pilihan warna, Ikan Mas Koki juga memiliki berbagai jenis berbeda. Tertarik miliki Ikan Mas Koki hias sebagai salah satu ikan peliharaan di akuarium rumahmu?</p>\r\n<p>Intip berbagai jenis Ikan Mas Koki hias yang punya tampilan lucu nan cantik, serta terpopuler!</p>\r\n<p><br /><strong>1. Ikan Mas Ryukin</strong><br /><br />Berasal dari Jepang, Ikan Mas Ryukin adalah ikan mas koki hias yang terkenal akan bentuknya yang lucu. Ciri khas dari Ikan Mas Koki hias ini adalah tubuhnya yang pendek dan memiliki punuk serta sirip yang lebar dan besar.</p>\r\n<p>Ikan Mas Ryukin sendiri tergolong salah satu jenis ikan mas koki hias yang cukup mahal karena memang cukup sulit ditemukan di Indonesia dan kebanyakan masih diimpor dari luar negeri.</p>\r\n<p><strong>2. Ikan Mas Lionhead</strong><br /><br />Ikan Mas Lionhead merupakan salah satu jenis ikan mas koki paling populer di Indonesia. Karakternya yang sangat khas yakni bagian kepala yang dipenuhi gumpalan bak buah berry menjadi daya tarik utama dari ikan mas koki jenis ini.</p>\r\n<p><strong>3. Ikan Mas Koki Black Moor</strong><br /><br />Jenis ikan mas koki selanjutnya tak kalah terkenal dari jenis ikan mas koki sebelumnya. Ciri khas dari ikan mas koki black moor adalah warna hitam pekat serta bagian mata yang menonjol.</p>\r\n<p>Warnanya yang kontras dari jenis ikan mas koki lainnya membuat ikan mas koki black moor sangat cocok dipelihara bersama ikan mas koki jenis lainnya.</p>\r\n<p><strong>4. Ikan Mas Koki Bubble Eye</strong><br /><br />Dari namanya saja, Toppers sudah bisa menebak bagaimana penampilan dari jenis ikan mas koki satu ini. Memiliki gumpalan seperti balon air pada bagian bawah matanya membuat ikan mas koki bubble eye terlihat sangat lucu dan menggemaskan.</p>\r\n<p>Meskipun lucu, soal harga ikan mas koki jenis ini termasuk yang cukup mahal, lho.</p>\r\n<p><strong>5. Celestial Goldfish</strong><br /><br />Celestial Goldfish atau ikan mas koki jenis celestial adalah ikan mas koki yang juga terkenal karena memiliki mata yang menonjol. Namun, yang membuatnya lebih unik adalah tonjolan mata yang menghadapa ke atas serta tidak memiliki sirip punggung.</p>\r\n<p>Kedua hal ini membuat jenis ikan mas koki ini tak memiliki kemampuan berenang dan penghilatan yang baik.</p>\r\n<p>Memancing lebih praktis dan mudah, serta dapatkan ikan lebih banyak dengan joran pancing portable terbaik di sini!<br /><br /><strong>6. Ikan Mas Koki Fantail</strong><br /><br />Jenis ikan mas koki selanjutnya adalah ikan mas koki fantail alias ekor kipas yang terkenal akan sirip ekor ganda yang terlihat mengembang. Sekilas ikan mas koki jenis ini terlihat tak berebda dengan jenis ikan mas lainnya.</p>\r\n<p>Hanya saja bagian ekor yang lebih pendek menajadi ciri khas dari ikan mas koki jenis ini.</p>\r\n<p><strong>7. Ikan Mas Koki Shubunkin</strong><br /><br />Ciri khas dari jenis ikan mas koki satu ini adalah komposisi warna yang lebih kaya, yakni terdiri dari tiga warna yang umumnya terdiri dari putih, oranye, dan juga cipratan pola hitam pada sekujur tubuhnya.</p>\r\n<p><strong>8. Ikan Mas Koki Oranda</strong><br /><br />Ikan Mas Koki Oranda sekilas terlihat mirip dengan ikan mas koki jenis lionhead, yang menjadi pembedanya adalah bentuk gumpalan yang hanya ada dibagian atas kepala bak konde.</p>\r\n<p><strong>9. Ikan Mas Mutiara</strong><br /><br />Untuk Toppers yang suka dengan ikan hias yang lucu, jenis ikan mas mutiara adalah jenis ikan mas koki hias yang tepat untukmu.</p>\r\n<p>Memiliki tubuh bulat dan membuntal serta sisik bulat-bulat menonjol bak mutiara menjadikan ikan mas mutiara ini terlihat sangat menggemaskan.</p>\r\n<p><strong>10. Ikan Mas Koki Ranchu</strong><br /><br />Mas koki Ranchu punya tampilan yang eksotis, dengan memiliki beberapa warna mencolok. Harga yang ditawarkan biasanya cukup terjangkau untuk bisa memiliki ikan cantik ini.</p>\r\n<p>Untuk mengetahui jenis ikan ini, ciri-cirinya yaitu punya tubuh bungkuk, pola sisi mutiara di punggung, dan terdapat jambul di kepalanya.</p>', 0, 1, 0, 2, 1582610573),
(25, 1, 'Menguak misteri excalibur, pedang legendaris dari mitos Raja Arthur', 'Sudah pernah mendengar tentang excalibur atau escalibor? Kamu yang akrab dengan legenda King Arthur dari inggris pasti sudah tak asing lagi dengan pedang ini.', 'menguak-misteri-excalibur-pedang-legendaris-dari-mitos-raja-arthur', '1582610689.jpg', '<p>Sudah pernah mendengar tentang excalibur atau escalibor? Kamu yang akrab dengan legenda King Arthur dari inggris pasti sudah tak asing lagi dengan pedang ini. Dalam legenda dikisahkan kalau siapapun yang mampu mencabut pedang excalibur yang tertancap pada batu kelak akan menjadi Raja Inggris. Dan ternyata Arthur yang mampu mencabut pedang legendaris yang juga dikenal dengan nama caliburn tersebut.</p>\r\n<p>Walaupun legenda Arthur merupakan cerita rakyat belaka, ternyata pedang excalibur benar-benar ada. Hanya saja pedang tersebut tidak ditemukan di Inggris, melainkan di Italia. Di dalam sebuah kapel di Monte Siepi, Italia ada sebuah pedang kuno yang tertanam di dalam batu. Pedang itu diyakini sebagai senjata milik San Galgano, seorang kesatria dari Tuscany yang hidup pada abad 13.</p>\r\n<p>Galgano yang bernama asli Galgano Guidotti tadinya adalah kesatria bengis yang sudah membunuh begitu banyak nyawa. Dia menghabisi nyawa musuh-musuhnya dengan pedang tersebut. Suatu ketika ia didatangi Malaikat Michael dan diminta untuk meninggalkan cara hidupnya yang penuh dosa. Galgano menegaskan bahwa melakukan hal itu sama sulitnya dengan menancapkan pedang ke batu.</p>\r\n<p>Kemudian untuk membuktikan perkataannya itu Galgano mencoba menancapkan pedangnya ke sebuah batu di dekatnya. Tak disangka pedang tersebut tertancap di dalam batu begitu mudahnya. Kemudian Galgano pun memutuskan untuk bertobat dan meninggalkan pedangnya yang masih tertancap di dalam batu hingga sekarang.</p>\r\n<p>Pedang dan batu itu sampai sekarang masih tersimpan di San Galgano Abbey, Monte Siepi, Italia. Kemungkinan besar kisah pedang ini sampai ke Inggris dan menjadi asal-usul legenda Arthur. Selama ini banyak yang menduga kalau pedang excalibur di San Galgano Abbey palsu. Tetapi penelitian pada tahun 2001 membuktikan kalau pedang ini berasal dari periode yang sama dengan kisah hidup San Galgano.</p>\r\n<p>&nbsp;</p>\r\n<p>Pedang St. Galgano &copy;Worldtrippers.com</p>\r\n<p>Melakukan penanggalan pada logam adalah tugas yang sangat sulit, tapi kami dapat mengatakan kalau komposisi logam dan modelnya cocok dengan era legenda tersebut berasal, kata Luigi Garlaschelli, salah satu peneliti dari University of Pavia seperti dilansir The Guardian</p>', 0, 1, 0, 2, 1582610689),
(26, 1, 'Fakta-fakta Megalodon, Hiu Purba Raksasa yang Hidup Jutaan Tahun Lalu', 'Hiu dikenal sebagai makhluk paling menyeramkan di lautan. Beberapa film seperti Jaws pun menjadikan ikan ini sebagai tokoh utamanya.', 'fakta-fakta-megalodon-hiu-purba-raksasa-yang-hidup-jutaan-tahun-lalu', '1582610783.jpg', '<p>Hiu dikenal sebagai makhluk paling menyeramkan di lautan. Beberapa film seperti Jaws pun menjadikan ikan ini sebagai tokoh utamanya.</p>\r\n<p>Namun, hiu putih besar tersebut, terlihat tidak ada apa-apanya jika dibandingkan dengan spesies megalodon. Berikut hal-hal yang perlu Anda ketahui tentang hiu raksasa ini.</p>\r\n<p>Apa itu hiu megalodon?</p>\r\n<p>Megalodon, yang merupakan hiu terbesar sepanjang sejarah, menjelajahi lautan kita sekitar 28 juta tahun lalu.</p>\r\n<p>Para ilmuwan yakin, makhluk ini mengonsumsi sekitar satu ton makanan per hari untuk menopang kehidupannya, termasuk paus dan makhluk laut besar lain seperti singa laut.</p>\r\n<p>Baca Juga: Telur Es Membanjiri Pantai di Finlandia, Apakah Penyebabnya?</p>\r\n<p>Seberapa besar ia?</p>\r\n<p>Sisa-sisa Megalodon menunjukkan bahwa makhluk laut ini dapat tumbuh hingga tiga kali lipat dari ukuran hiu putih besar.</p>\r\n<p>Ukuran minimalnya sekitar 40 kaki dan dipercaya bisa mencapai 59 kaki pada bentuk terbesarnya. Giginya &nbsp;saja memiliki panjang tujuh inci.</p>\r\n<p>&nbsp;</p>\r\n<p>mj0007/Getty Images/iStockphoto<br />Gigi megalodon yang ditemukan peneliti.<br />&nbsp;</p>\r\n<p><br />Apakah hiu megalodon masih ada?</p>\r\n<p>Saat ini, spesies megalodon telah punah. Namun, beberapa teori konspirasi menyatakan, predator ini masih berkeliaran di laut kita.</p>\r\n<p>Beberapa pelaut melaporkan bahwa mereka pernah melihat makhluk purba tersebut.</p>\r\n<p>Salah satunya kisah nelayan di New South Wales pada 1918. Ia mengatakan bahwa jaringnya telah dimakan oleh hiu raksasa.</p>\r\n<p>Laporan lain dari 1933 bersikeras bahwa binatang laut misterius menyerupai megalodon terlihat di pesisir pantai Prancis.</p>\r\n<p>Meski begitu, mayoritas ahli mengatakan bahwa tidak ada bukti yang menunjukkan predator raksasa ini masih ada.</p>\r\n<p>Baca Juga: Dampak Melelehnya Es Arktika, Penyebaran Virus yang Mematikan</p>\r\n<p>Mengapa ia punah?</p>\r\n<p>Selama beberapa dekade, para ahli telah memperdebatkan alasan mengapa spesies hiu ini bisa punah.</p>\r\n<p>Beberapa percaya bahwa penurunan jumlah persediaan makanan dan pendinginan lautan lah yang mengurangi populasi megalodon.</p>\r\n<p>Hasil penelitian dari University of Zurich menyatakan bahwa sepertiga hewan laut terbesar di laut, punah selama zaman Pliosen, sekitar 5,3 juta tahun lalu &ndash; termasuk megalodon.</p>', 0, 1, 0, 2, 1582610783);
INSERT INTO `db_custom_page` (`id`, `user_id`, `title`, `description`, `slug`, `img`, `content`, `contact_form`, `status`, `position`, `level`, `date_time`) VALUES
(27, 1, 'Arapaima Gigas, Ikan Purba Terbesar di Dunia Yang Terjaga Kelestariannya', 'Arapaima Gigas adalah ikan air tawar terbesar di dunia. Ikan predator ini adalah ikan purba yang sudah hidup sejak ratusan juta tahun yang lalu', 'arapaima-gigas-ikan-purba-terbesar-di-dunia-yang-terjaga-kelestariannya', '1582610973.jpeg', '<p>Arapaima Gigas adalah ikan air tawar terbesar di dunia. Ikan predator ini adalah ikan purba yang sudah hidup sejak ratusan juta tahun yang lalu. Arapaima sangat populer di kalangan pecinta predator. Bahkan Arapaima juga dikenal dengan nama Piracucu.</p>\r\n<p>Perlu kamu ketahui, ikan Arapaima Gigas merupakan salah satu ikan tipe atas alias &lsquo;Top Feeder&rsquo;. Sebenarnya, fungsi dari ikan predator tipe atas adalah membersihkan makanan yang sulit dijangkau oleh ikan tipe tengah dan bawah yaitu di area atas permukaan air.</p>\r\n<p>Terkadang dalam beberapa kasus, ikan tipe tengah dan bawah kesulitan menjangkau makanan yang berada di area atas tepatnya di sekitar permukaan air. Ikan tipe atas sangat berguna membesihkan makanan yang berada di atas tersebut sehingga airnya akan lebih bersih.</p>\r\n<p>Mengenai ikan Arapaima Gigas, sebenarnya sudah mulai ramai dan banyak yang tahu tentang ikan ini semenjak viral di pertengahan tahun 2018. Lalu seperti apa sih seluk beluk dari ikan Arapaima Gigas? Kamu penasaran? Yuk simak berikut!!</p>\r\n<p>Arapaima memiliki bentuk fisik yang cukup unik, kalau dilihat-lihat Arapaima memiliki badan yang menyerupai ikan Arwana tetapi dengan kepala yang mirip ikan Gabus. Bagaimana? Cukup eksotis kan menurutmu?</p>\r\n<p>Ikan Arapaima memiliki tubuh berwarna hitam dan kadang beberapa sedikit keabu-abuan. Saat besar, pada ekornya akan terlihat warna oranye kemerahan yang sangat indah.</p>\r\n<p>Sebagai ikan yang memiliki predikat ikan air tawar terbesar di dunia, Arapaima dapat tumbuh mencapai 450 cm di alam liar, tetapi ketika dipelihara hanya mampu mencapai panjang 200 cm dengan berat 150 kg.<br />Arapaima dapat dibilang memiliki dua predikat sekaligus yaitu ikan air tawar terbesar di dunia dan ikan yang sangat rakus. Ikan dengan nama lain &lsquo;Piracucu&rsquo; ini sangat lahap dan memiliki menu makanan yang sangat banyak seperti ikan, udang, reptil, bahkan burung.</p>\r\n<p>Saking rakus dan agresifnya, sudah banyak laporan terkait penyerangan Arapaima terhadap manusia oleh penduduk lokal. Untuk merawat Arapaima sangat mudah terutama dalam hal pakan. Kamu bisa memberi ikan, udang, cacing beku, ulat, bahkan serangga ketika memelihara Arapaima.</p>\r\n<p>Berikan ia makanan antara 1-2 kali sehari. Tergantung dari ukuran tubuh yang dimilikinya. Apakah masih kecil, atau mungkin sudah besar alias dewasa.</p>\r\n<p><br />Dengan memiliki habitat Sungai Amazon yang panjang dan cukup rimbun, Arapaima memiliki adaptasi yang luar biasa. Arapaima sebenarnya mampu bernafas melalui dua cara yaitu insang dan paru paru primitifnya.</p>\r\n<p>Namun Arapaima lebih sering menggunakan paru-paru primitif untuk bernafas, sehingga ikan ini perlu naik ke permukaan air setiap kali ingin mendapatkan udara.<br />Sayangnya, karakteristik yang membuat Arapaima kadang naik ke permukaan air dimanfaatkan oleh pemburu. Dengan ketergantungan Arapaima naik ke permukaan air untuk mengambil nafas, pemburu sudah langsung siap menangkapnya ketika berada di permukaan air. Karena mudahnya memburu Arapaima inilah yang membuat populasi Arapaima menurun drastis.<br />&nbsp;<br />Temperamen Arapaima sebenarnya sangat agresif baik ke sesama spesiesnya maupun dengan ikan-ikan lain. Tapi jangan khawatir, selama ketersediaan pangan tercukupi Arapaima bisa di gabung dengan ikan apa saja. Namun dengan catatan ikan tankmate tidak lebih kecil dari mulut Arapaima.<br />&nbsp;</p>\r\n<p>Seperti yang sudah disebutkan sebelumnya, Arapaima telah lama menjadi korban penangkapan berlebih. Kemudian diperburuk dengan kebiasaan ikan ini yang mudah dieksploitasi ketika muncul ke permukaan air untuk mengambil udara secara langsung. IUCN tidak bisa menetapkan status konservasi Arapaima karena kurangnya informasi rinci tentang perkembangan populasi.</p>', 0, 1, 0, 2, 1582610973),
(28, 1, 'Arwana, Ikan Purba Yang Belum Punah Hingga Sekarang', 'Arwana termasuk ikan karnivor yang mendiami habitat sungai dan danau berair tenang. Ikan ini dapat ditemukan di Amazon, dan di beberapa bagian Afrika, Asia dan Australia.', 'arwana-ikan-purba-yang-belum-punah-hingga-sekarang', '1582611063.jpg', '<p>Arwana sebenarnya termasuk jenis ikan purba yang hingga kini belum punah.</p>\r\n<p>Studi genetik dan temuan fosil menunjukkan, ikan ini setidaknya telah hidup di bumi sejak 220 juta tahun yang lalu.</p>\r\n<p>Arwana sangat diminati sebagai hewan akuarium yang eksotis.</p>\r\n<p>Ikan ini bahkan bisa melompat hingga 2 meter di atas air untuk menangkap mangsanya seperti burung dan kelelawar untuk dimakan.</p>\r\n<p>Arwana termasuk ikan karnivor yang mendiami habitat sungai dan danau berair tenang. Ikan ini dapat ditemukan di Amazon, dan di beberapa bagian Afrika, Asia dan Australia</p>', 0, 1, 0, 2, 1585360968);

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_delivery_service`
--

CREATE TABLE `db_delivery_service` (
  `id` int(11) NOT NULL,
  `code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `company_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `service_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `service_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `price` bigint(20) NOT NULL,
  `time` bigint(20) NOT NULL,
  `invoice_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `product_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_deposit_request`
--

CREATE TABLE `db_deposit_request` (
  `id` int(11) NOT NULL,
  `tf_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `saldo` bigint(20) NOT NULL,
  `bank_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `rekening_number` bigint(20) NOT NULL,
  `card_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `picture` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `type` int(11) NOT NULL,
  `invoice_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `date_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_destination_address`
--

CREATE TABLE `db_destination_address` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `district` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `state` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `province` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `zip_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `nama_penerima` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `phone_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `label` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `db_destination_address`
--

INSERT INTO `db_destination_address` (`id`, `user_id`, `address`, `district`, `state`, `province`, `zip_code`, `nama_penerima`, `phone_number`, `label`) VALUES
(19, 24, 'Jl. Pegangsaat Timur No 56', 'Menteng', 'Jakarta Pusat', 'DKI Jakarta', '10340', 'Anastasya Hosin', '087888987652', 'Rumah'),
(20, 25, 'Komplek Pejaten Elok Block B3, Pejaten Barat', 'Pasar Minggu', 'Jakarta Selatan', 'DKI Jakarta', '12560', 'Yudha Romadhon', '082298534562', 'My Home'),
(21, 26, 'Jl. Akses UI Kelapa 2 ', '16424', 'k80', 'p9', '16424', 'Muhammad Reza', '082256785432', 'Rumah'),
(22, 27, 'Jl. R.E Martadinata Kav 10', 'Bone Raya', 'Bone Bolango', 'Gorontalo', '96585', 'Muhammad Reza', '085713193542', 'Rumah'),
(23, 27, 'Jl. Salemba Raya Komp TNI Kopasus', 'Kebayoran Lama', 'Jakarta Selatan', 'DKI Jakarta', '12310', 'Jefri Bukhari', '085647652398', 'Kantor'),
(24, 28, 'Jl. Raya Mampang Prapatan Rt 003 Rw 007', 'Pesanggrahan', 'Jakarta Selatan', 'DKI Jakarta', '12330', 'Nazip Razak', '087846752338', 'Rumah'),
(25, 9, 'Komplek Pejaten Elok B3, Pejaten Barat', 'Pasar Minggu', 'Jakarta Selatan', 'DKI Jakarta', '12560', 'Rudiantara', '082110976556', 'Rumah'),
(26, 29, 'Jl. Medan Merdeka Utara No.3, RT.2/RW.3, Gambir', 'Gambir', 'Jakarta Pusat', 'DKI Jakarta', '10160', 'Rudiantara Hadiningrat', '082110976556', 'Rumah'),
(27, 25, 'Jl. Masjid Al-fajri Pejaten Barat', 'Pasar Minggu', 'Jakarta Selatan', 'DKI Jakarta', '12560', 'Bugi Sularso', '083819671872', 'Kantor');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_email`
--

CREATE TABLE `db_email` (
  `id` int(11) NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `subject` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `reply` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `date_time` bigint(20) NOT NULL,
  `reply_time` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_location`
--

CREATE TABLE `db_location` (
  `id` int(11) NOT NULL,
  `loc_id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `type` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `parrent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `db_location`
--

INSERT INTO `db_location` (`id`, `loc_id`, `name`, `type`, `parrent`) VALUES
(1, 1, 'Bali', 'provinsi', 0),
(2, 2, 'Bangka Belitung', 'provinsi', 0),
(3, 3, 'Banten', 'provinsi', 0),
(4, 4, 'Bengkulu', 'provinsi', 0),
(5, 5, 'DI Yogyakarta', 'provinsi', 0),
(6, 6, 'DKI Jakarta', 'provinsi', 0),
(7, 7, 'Gorontalo', 'provinsi', 0),
(8, 8, 'Jambi', 'provinsi', 0),
(9, 9, 'Jawa Barat', 'provinsi', 0),
(10, 10, 'Jawa Tengah', 'provinsi', 0),
(11, 11, 'Jawa Timur', 'provinsi', 0),
(12, 12, 'Kalimantan Barat', 'provinsi', 0),
(13, 13, 'Kalimantan Selatan', 'provinsi', 0),
(14, 14, 'Kalimantan Tengah', 'provinsi', 0),
(15, 15, 'Kalimantan Timur', 'provinsi', 0),
(16, 16, 'Kalimantan Utara', 'provinsi', 0),
(17, 17, 'Kepulauan Riau', 'provinsi', 0),
(18, 18, 'Lampung', 'provinsi', 0),
(19, 19, 'Maluku', 'provinsi', 0),
(20, 20, 'Maluku Utara', 'provinsi', 0),
(21, 21, 'Nanggroe Aceh Darussalam (NAD)', 'provinsi', 0),
(22, 22, 'Nusa Tenggara Barat (NTB)', 'provinsi', 0),
(23, 23, 'Nusa Tenggara Timur (NTT)', 'provinsi', 0),
(24, 24, 'Papua', 'provinsi', 0),
(25, 25, 'Papua Barat', 'provinsi', 0),
(26, 26, 'Riau', 'provinsi', 0),
(27, 27, 'Sulawesi Barat', 'provinsi', 0),
(28, 28, 'Sulawesi Selatan', 'provinsi', 0),
(29, 29, 'Sulawesi Tengah', 'provinsi', 0),
(30, 30, 'Sulawesi Tenggara', 'provinsi', 0),
(31, 31, 'Sulawesi Utara', 'provinsi', 0),
(32, 32, 'Sumatera Barat', 'provinsi', 0),
(33, 33, 'Sumatera Selatan', 'provinsi', 0),
(34, 34, 'Sumatera Utara', 'provinsi', 0),
(35, 17, 'Badung', 'kabupaten', 1),
(36, 32, 'Bangli', 'kabupaten', 1),
(37, 94, 'Buleleng', 'kabupaten', 1),
(38, 114, 'Denpasar', 'kabupaten', 1),
(39, 128, 'Gianyar', 'kabupaten', 1),
(40, 161, 'Jembrana', 'kabupaten', 1),
(41, 170, 'Karangasem', 'kabupaten', 1),
(42, 197, 'Klungkung', 'kabupaten', 1),
(43, 447, 'Tabanan', 'kabupaten', 1),
(44, 27, 'Bangka', 'kabupaten', 2),
(45, 28, 'Bangka Barat', 'kabupaten', 2),
(46, 29, 'Bangka Selatan', 'kabupaten', 2),
(47, 30, 'Bangka Tengah', 'kabupaten', 2),
(48, 56, 'Belitung', 'kabupaten', 2),
(49, 57, 'Belitung Timur', 'kabupaten', 2),
(50, 334, 'Pangkal Pinang', 'kabupaten', 2),
(51, 106, 'Cilegon', 'kabupaten', 3),
(52, 232, 'Lebak', 'kabupaten', 3),
(53, 331, 'Pandeglang', 'kabupaten', 3),
(54, 402, 'Serang', 'kabupaten', 3),
(55, 403, 'Serang', 'kabupaten', 3),
(56, 455, 'Tangerang', 'kabupaten', 3),
(57, 456, 'Tangerang', 'kabupaten', 3),
(58, 457, 'Tangerang Selatan', 'kabupaten', 3),
(59, 62, 'Bengkulu', 'kabupaten', 4),
(60, 63, 'Bengkulu Selatan', 'kabupaten', 4),
(61, 64, 'Bengkulu Tengah', 'kabupaten', 4),
(62, 65, 'Bengkulu Utara', 'kabupaten', 4),
(63, 175, 'Kaur', 'kabupaten', 4),
(64, 183, 'Kepahiang', 'kabupaten', 4),
(65, 233, 'Lebong', 'kabupaten', 4),
(66, 294, 'Muko Muko', 'kabupaten', 4),
(67, 379, 'Rejang Lebong', 'kabupaten', 4),
(68, 397, 'Seluma', 'kabupaten', 4),
(69, 39, 'Bantul', 'kabupaten', 5),
(70, 135, 'Gunung Kidul', 'kabupaten', 5),
(71, 210, 'Kulon Progo', 'kabupaten', 5),
(72, 419, 'Sleman', 'kabupaten', 5),
(73, 501, 'Yogyakarta', 'kabupaten', 5),
(74, 151, 'Jakarta Barat', 'kabupaten', 6),
(75, 152, 'Jakarta Pusat', 'kabupaten', 6),
(76, 153, 'Jakarta Selatan', 'kabupaten', 6),
(77, 154, 'Jakarta Timur', 'kabupaten', 6),
(78, 155, 'Jakarta Utara', 'kabupaten', 6),
(79, 189, 'Kepulauan Seribu', 'kabupaten', 6),
(80, 77, 'Boalemo', 'kabupaten', 7),
(81, 88, 'Bone Bolango', 'kabupaten', 7),
(82, 129, 'Gorontalo', 'kabupaten', 7),
(83, 130, 'Gorontalo', 'kabupaten', 7),
(84, 131, 'Gorontalo Utara', 'kabupaten', 7),
(85, 361, 'Pohuwato', 'kabupaten', 7),
(86, 50, 'Batang Hari', 'kabupaten', 8),
(87, 97, 'Bungo', 'kabupaten', 8),
(88, 156, 'Jambi', 'kabupaten', 8),
(89, 194, 'Kerinci', 'kabupaten', 8),
(90, 280, 'Merangin', 'kabupaten', 8),
(91, 293, 'Muaro Jambi', 'kabupaten', 8),
(92, 393, 'Sarolangun', 'kabupaten', 8),
(93, 442, 'Sungaipenuh', 'kabupaten', 8),
(94, 460, 'Tanjung Jabung Barat', 'kabupaten', 8),
(95, 461, 'Tanjung Jabung Timur', 'kabupaten', 8),
(96, 471, 'Tebo', 'kabupaten', 8),
(97, 22, 'Bandung', 'kabupaten', 9),
(98, 23, 'Bandung', 'kabupaten', 9),
(99, 24, 'Bandung Barat', 'kabupaten', 9),
(100, 34, 'Banjar', 'kabupaten', 9),
(101, 54, 'Bekasi', 'kabupaten', 9),
(102, 55, 'Bekasi', 'kabupaten', 9),
(103, 78, 'Bogor', 'kabupaten', 9),
(104, 79, 'Bogor', 'kabupaten', 9),
(105, 103, 'Ciamis', 'kabupaten', 9),
(106, 104, 'Cianjur', 'kabupaten', 9),
(107, 107, 'Cimahi', 'kabupaten', 9),
(108, 108, 'Cirebon', 'kabupaten', 9),
(109, 109, 'Cirebon', 'kabupaten', 9),
(110, 115, 'Depok', 'kabupaten', 9),
(111, 126, 'Garut', 'kabupaten', 9),
(112, 149, 'Indramayu', 'kabupaten', 9),
(113, 171, 'Karawang', 'kabupaten', 9),
(114, 211, 'Kuningan', 'kabupaten', 9),
(115, 252, 'Majalengka', 'kabupaten', 9),
(116, 332, 'Pangandaran', 'kabupaten', 9),
(117, 376, 'Purwakarta', 'kabupaten', 9),
(118, 428, 'Subang', 'kabupaten', 9),
(119, 430, 'Sukabumi', 'kabupaten', 9),
(120, 431, 'Sukabumi', 'kabupaten', 9),
(121, 440, 'Sumedang', 'kabupaten', 9),
(122, 468, 'Tasikmalaya', 'kabupaten', 9),
(123, 469, 'Tasikmalaya', 'kabupaten', 9),
(124, 37, 'Banjarnegara', 'kabupaten', 10),
(125, 41, 'Banyumas', 'kabupaten', 10),
(126, 49, 'Batang', 'kabupaten', 10),
(127, 76, 'Blora', 'kabupaten', 10),
(128, 91, 'Boyolali', 'kabupaten', 10),
(129, 92, 'Brebes', 'kabupaten', 10),
(130, 105, 'Cilacap', 'kabupaten', 10),
(131, 113, 'Demak', 'kabupaten', 10),
(132, 134, 'Grobogan', 'kabupaten', 10),
(133, 163, 'Jepara', 'kabupaten', 10),
(134, 169, 'Karanganyar', 'kabupaten', 10),
(135, 177, 'Kebumen', 'kabupaten', 10),
(136, 181, 'Kendal', 'kabupaten', 10),
(137, 196, 'Klaten', 'kabupaten', 10),
(138, 209, 'Kudus', 'kabupaten', 10),
(139, 249, 'Magelang', 'kabupaten', 10),
(140, 250, 'Magelang', 'kabupaten', 10),
(141, 344, 'Pati', 'kabupaten', 10),
(142, 348, 'Pekalongan', 'kabupaten', 10),
(143, 349, 'Pekalongan', 'kabupaten', 10),
(144, 352, 'Pemalang', 'kabupaten', 10),
(145, 375, 'Purbalingga', 'kabupaten', 10),
(146, 377, 'Purworejo', 'kabupaten', 10),
(147, 380, 'Rembang', 'kabupaten', 10),
(148, 386, 'Salatiga', 'kabupaten', 10),
(149, 398, 'Semarang', 'kabupaten', 10),
(150, 399, 'Semarang', 'kabupaten', 10),
(151, 427, 'Sragen', 'kabupaten', 10),
(152, 433, 'Sukoharjo', 'kabupaten', 10),
(153, 445, 'Surakarta (Solo)', 'kabupaten', 10),
(154, 472, 'Tegal', 'kabupaten', 10),
(155, 473, 'Tegal', 'kabupaten', 10),
(156, 476, 'Temanggung', 'kabupaten', 10),
(157, 497, 'Wonogiri', 'kabupaten', 10),
(158, 498, 'Wonosobo', 'kabupaten', 10),
(159, 31, 'Bangkalan', 'kabupaten', 11),
(160, 42, 'Banyuwangi', 'kabupaten', 11),
(161, 51, 'Batu', 'kabupaten', 11),
(162, 74, 'Blitar', 'kabupaten', 11),
(163, 75, 'Blitar', 'kabupaten', 11),
(164, 80, 'Bojonegoro', 'kabupaten', 11),
(165, 86, 'Bondowoso', 'kabupaten', 11),
(166, 133, 'Gresik', 'kabupaten', 11),
(167, 160, 'Jember', 'kabupaten', 11),
(168, 164, 'Jombang', 'kabupaten', 11),
(169, 178, 'Kediri', 'kabupaten', 11),
(170, 179, 'Kediri', 'kabupaten', 11),
(171, 222, 'Lamongan', 'kabupaten', 11),
(172, 243, 'Lumajang', 'kabupaten', 11),
(173, 247, 'Madiun', 'kabupaten', 11),
(174, 248, 'Madiun', 'kabupaten', 11),
(175, 251, 'Magetan', 'kabupaten', 11),
(176, 255, 'Malang', 'kabupaten', 11),
(177, 256, 'Malang', 'kabupaten', 11),
(178, 289, 'Mojokerto', 'kabupaten', 11),
(179, 290, 'Mojokerto', 'kabupaten', 11),
(180, 305, 'Nganjuk', 'kabupaten', 11),
(181, 306, 'Ngawi', 'kabupaten', 11),
(182, 317, 'Pacitan', 'kabupaten', 11),
(183, 330, 'Pamekasan', 'kabupaten', 11),
(184, 342, 'Pasuruan', 'kabupaten', 11),
(185, 343, 'Pasuruan', 'kabupaten', 11),
(186, 363, 'Ponorogo', 'kabupaten', 11),
(187, 369, 'Probolinggo', 'kabupaten', 11),
(188, 370, 'Probolinggo', 'kabupaten', 11),
(189, 390, 'Sampang', 'kabupaten', 11),
(190, 409, 'Sidoarjo', 'kabupaten', 11),
(191, 418, 'Situbondo', 'kabupaten', 11),
(192, 441, 'Sumenep', 'kabupaten', 11),
(193, 444, 'Surabaya', 'kabupaten', 11),
(194, 487, 'Trenggalek', 'kabupaten', 11),
(195, 489, 'Tuban', 'kabupaten', 11),
(196, 492, 'Tulungagung', 'kabupaten', 11),
(197, 61, 'Bengkayang', 'kabupaten', 12),
(198, 168, 'Kapuas Hulu', 'kabupaten', 12),
(199, 176, 'Kayong Utara', 'kabupaten', 12),
(200, 195, 'Ketapang', 'kabupaten', 12),
(201, 208, 'Kubu Raya', 'kabupaten', 12),
(202, 228, 'Landak', 'kabupaten', 12),
(203, 279, 'Melawi', 'kabupaten', 12),
(204, 364, 'Pontianak', 'kabupaten', 12),
(205, 365, 'Pontianak', 'kabupaten', 12),
(206, 388, 'Sambas', 'kabupaten', 12),
(207, 391, 'Sanggau', 'kabupaten', 12),
(208, 395, 'Sekadau', 'kabupaten', 12),
(209, 415, 'Singkawang', 'kabupaten', 12),
(210, 417, 'Sintang', 'kabupaten', 12),
(211, 18, 'Balangan', 'kabupaten', 13),
(212, 33, 'Banjar', 'kabupaten', 13),
(213, 35, 'Banjarbaru', 'kabupaten', 13),
(214, 36, 'Banjarmasin', 'kabupaten', 13),
(215, 43, 'Barito Kuala', 'kabupaten', 13),
(216, 143, 'Hulu Sungai Selatan', 'kabupaten', 13),
(217, 144, 'Hulu Sungai Tengah', 'kabupaten', 13),
(218, 145, 'Hulu Sungai Utara', 'kabupaten', 13),
(219, 203, 'Kotabaru', 'kabupaten', 13),
(220, 446, 'Tabalong', 'kabupaten', 13),
(221, 452, 'Tanah Bumbu', 'kabupaten', 13),
(222, 454, 'Tanah Laut', 'kabupaten', 13),
(223, 466, 'Tapin', 'kabupaten', 13),
(224, 44, 'Barito Selatan', 'kabupaten', 14),
(225, 45, 'Barito Timur', 'kabupaten', 14),
(226, 46, 'Barito Utara', 'kabupaten', 14),
(227, 136, 'Gunung Mas', 'kabupaten', 14),
(228, 167, 'Kapuas', 'kabupaten', 14),
(229, 174, 'Katingan', 'kabupaten', 14),
(230, 205, 'Kotawaringin Barat', 'kabupaten', 14),
(231, 206, 'Kotawaringin Timur', 'kabupaten', 14),
(232, 221, 'Lamandau', 'kabupaten', 14),
(233, 296, 'Murung Raya', 'kabupaten', 14),
(234, 326, 'Palangka Raya', 'kabupaten', 14),
(235, 371, 'Pulang Pisau', 'kabupaten', 14),
(236, 405, 'Seruyan', 'kabupaten', 14),
(237, 432, 'Sukamara', 'kabupaten', 14),
(238, 19, 'Balikpapan', 'kabupaten', 15),
(239, 66, 'Berau', 'kabupaten', 15),
(240, 89, 'Bontang', 'kabupaten', 15),
(241, 214, 'Kutai Barat', 'kabupaten', 15),
(242, 215, 'Kutai Kartanegara', 'kabupaten', 15),
(243, 216, 'Kutai Timur', 'kabupaten', 15),
(244, 341, 'Paser', 'kabupaten', 15),
(245, 354, 'Penajam Paser Utara', 'kabupaten', 15),
(246, 387, 'Samarinda', 'kabupaten', 15),
(247, 96, 'Bulungan (Bulongan)', 'kabupaten', 16),
(248, 257, 'Malinau', 'kabupaten', 16),
(249, 311, 'Nunukan', 'kabupaten', 16),
(250, 450, 'Tana Tidung', 'kabupaten', 16),
(251, 467, 'Tarakan', 'kabupaten', 16),
(252, 48, 'Batam', 'kabupaten', 17),
(253, 71, 'Bintan', 'kabupaten', 17),
(254, 172, 'Karimun', 'kabupaten', 17),
(255, 184, 'Kepulauan Anambas', 'kabupaten', 17),
(256, 237, 'Lingga', 'kabupaten', 17),
(257, 302, 'Natuna', 'kabupaten', 17),
(258, 462, 'Tanjung Pinang', 'kabupaten', 17),
(259, 21, 'Bandar Lampung', 'kabupaten', 18),
(260, 223, 'Lampung Barat', 'kabupaten', 18),
(261, 224, 'Lampung Selatan', 'kabupaten', 18),
(262, 225, 'Lampung Tengah', 'kabupaten', 18),
(263, 226, 'Lampung Timur', 'kabupaten', 18),
(264, 227, 'Lampung Utara', 'kabupaten', 18),
(265, 282, 'Mesuji', 'kabupaten', 18),
(266, 283, 'Metro', 'kabupaten', 18),
(267, 355, 'Pesawaran', 'kabupaten', 18),
(268, 356, 'Pesisir Barat', 'kabupaten', 18),
(269, 368, 'Pringsewu', 'kabupaten', 18),
(270, 458, 'Tanggamus', 'kabupaten', 18),
(271, 490, 'Tulang Bawang', 'kabupaten', 18),
(272, 491, 'Tulang Bawang Barat', 'kabupaten', 18),
(273, 496, 'Way Kanan', 'kabupaten', 18),
(274, 14, 'Ambon', 'kabupaten', 19),
(275, 99, 'Buru', 'kabupaten', 19),
(276, 100, 'Buru Selatan', 'kabupaten', 19),
(277, 185, 'Kepulauan Aru', 'kabupaten', 19),
(278, 258, 'Maluku Barat Daya', 'kabupaten', 19),
(279, 259, 'Maluku Tengah', 'kabupaten', 19),
(280, 260, 'Maluku Tenggara', 'kabupaten', 19),
(281, 261, 'Maluku Tenggara Barat', 'kabupaten', 19),
(282, 400, 'Seram Bagian Barat', 'kabupaten', 19),
(283, 401, 'Seram Bagian Timur', 'kabupaten', 19),
(284, 488, 'Tual', 'kabupaten', 19),
(285, 138, 'Halmahera Barat', 'kabupaten', 20),
(286, 139, 'Halmahera Selatan', 'kabupaten', 20),
(287, 140, 'Halmahera Tengah', 'kabupaten', 20),
(288, 141, 'Halmahera Timur', 'kabupaten', 20),
(289, 142, 'Halmahera Utara', 'kabupaten', 20),
(290, 191, 'Kepulauan Sula', 'kabupaten', 20),
(291, 372, 'Pulau Morotai', 'kabupaten', 20),
(292, 477, 'Ternate', 'kabupaten', 20),
(293, 478, 'Tidore Kepulauan', 'kabupaten', 20),
(294, 1, 'Aceh Barat', 'kabupaten', 21),
(295, 2, 'Aceh Barat Daya', 'kabupaten', 21),
(296, 3, 'Aceh Besar', 'kabupaten', 21),
(297, 4, 'Aceh Jaya', 'kabupaten', 21),
(298, 5, 'Aceh Selatan', 'kabupaten', 21),
(299, 6, 'Aceh Singkil', 'kabupaten', 21),
(300, 7, 'Aceh Tamiang', 'kabupaten', 21),
(301, 8, 'Aceh Tengah', 'kabupaten', 21),
(302, 9, 'Aceh Tenggara', 'kabupaten', 21),
(303, 10, 'Aceh Timur', 'kabupaten', 21),
(304, 11, 'Aceh Utara', 'kabupaten', 21),
(305, 20, 'Banda Aceh', 'kabupaten', 21),
(306, 59, 'Bener Meriah', 'kabupaten', 21),
(307, 72, 'Bireuen', 'kabupaten', 21),
(308, 127, 'Gayo Lues', 'kabupaten', 21),
(309, 230, 'Langsa', 'kabupaten', 21),
(310, 235, 'Lhokseumawe', 'kabupaten', 21),
(311, 300, 'Nagan Raya', 'kabupaten', 21),
(312, 358, 'Pidie', 'kabupaten', 21),
(313, 359, 'Pidie Jaya', 'kabupaten', 21),
(314, 384, 'Sabang', 'kabupaten', 21),
(315, 414, 'Simeulue', 'kabupaten', 21),
(316, 429, 'Subulussalam', 'kabupaten', 21),
(317, 68, 'Bima', 'kabupaten', 22),
(318, 69, 'Bima', 'kabupaten', 22),
(319, 118, 'Dompu', 'kabupaten', 22),
(320, 238, 'Lombok Barat', 'kabupaten', 22),
(321, 239, 'Lombok Tengah', 'kabupaten', 22),
(322, 240, 'Lombok Timur', 'kabupaten', 22),
(323, 241, 'Lombok Utara', 'kabupaten', 22),
(324, 276, 'Mataram', 'kabupaten', 22),
(325, 438, 'Sumbawa', 'kabupaten', 22),
(326, 439, 'Sumbawa Barat', 'kabupaten', 22),
(327, 13, 'Alor', 'kabupaten', 23),
(328, 58, 'Belu', 'kabupaten', 23),
(329, 122, 'Ende', 'kabupaten', 23),
(330, 125, 'Flores Timur', 'kabupaten', 23),
(331, 212, 'Kupang', 'kabupaten', 23),
(332, 213, 'Kupang', 'kabupaten', 23),
(333, 234, 'Lembata', 'kabupaten', 23),
(334, 269, 'Manggarai', 'kabupaten', 23),
(335, 270, 'Manggarai Barat', 'kabupaten', 23),
(336, 271, 'Manggarai Timur', 'kabupaten', 23),
(337, 301, 'Nagekeo', 'kabupaten', 23),
(338, 304, 'Ngada', 'kabupaten', 23),
(339, 383, 'Rote Ndao', 'kabupaten', 23),
(340, 385, 'Sabu Raijua', 'kabupaten', 23),
(341, 412, 'Sikka', 'kabupaten', 23),
(342, 434, 'Sumba Barat', 'kabupaten', 23),
(343, 435, 'Sumba Barat Daya', 'kabupaten', 23),
(344, 436, 'Sumba Tengah', 'kabupaten', 23),
(345, 437, 'Sumba Timur', 'kabupaten', 23),
(346, 479, 'Timor Tengah Selatan', 'kabupaten', 23),
(347, 480, 'Timor Tengah Utara', 'kabupaten', 23),
(348, 16, 'Asmat', 'kabupaten', 24),
(349, 67, 'Biak Numfor', 'kabupaten', 24),
(350, 90, 'Boven Digoel', 'kabupaten', 24),
(351, 111, 'Deiyai (Deliyai)', 'kabupaten', 24),
(352, 117, 'Dogiyai', 'kabupaten', 24),
(353, 150, 'Intan Jaya', 'kabupaten', 24),
(354, 157, 'Jayapura', 'kabupaten', 24),
(355, 158, 'Jayapura', 'kabupaten', 24),
(356, 159, 'Jayawijaya', 'kabupaten', 24),
(357, 180, 'Keerom', 'kabupaten', 24),
(358, 193, 'Kepulauan Yapen (Yapen Waropen)', 'kabupaten', 24),
(359, 231, 'Lanny Jaya', 'kabupaten', 24),
(360, 263, 'Mamberamo Raya', 'kabupaten', 24),
(361, 264, 'Mamberamo Tengah', 'kabupaten', 24),
(362, 274, 'Mappi', 'kabupaten', 24),
(363, 281, 'Merauke', 'kabupaten', 24),
(364, 284, 'Mimika', 'kabupaten', 24),
(365, 299, 'Nabire', 'kabupaten', 24),
(366, 303, 'Nduga', 'kabupaten', 24),
(367, 335, 'Paniai', 'kabupaten', 24),
(368, 347, 'Pegunungan Bintang', 'kabupaten', 24),
(369, 373, 'Puncak', 'kabupaten', 24),
(370, 374, 'Puncak Jaya', 'kabupaten', 24),
(371, 392, 'Sarmi', 'kabupaten', 24),
(372, 443, 'Supiori', 'kabupaten', 24),
(373, 484, 'Tolikara', 'kabupaten', 24),
(374, 495, 'Waropen', 'kabupaten', 24),
(375, 499, 'Yahukimo', 'kabupaten', 24),
(376, 500, 'Yalimo', 'kabupaten', 24),
(377, 124, 'Fakfak', 'kabupaten', 25),
(378, 165, 'Kaimana', 'kabupaten', 25),
(379, 272, 'Manokwari', 'kabupaten', 25),
(380, 273, 'Manokwari Selatan', 'kabupaten', 25),
(381, 277, 'Maybrat', 'kabupaten', 25),
(382, 346, 'Pegunungan Arfak', 'kabupaten', 25),
(383, 378, 'Raja Ampat', 'kabupaten', 25),
(384, 424, 'Sorong', 'kabupaten', 25),
(385, 425, 'Sorong', 'kabupaten', 25),
(386, 426, 'Sorong Selatan', 'kabupaten', 25),
(387, 449, 'Tambrauw', 'kabupaten', 25),
(388, 474, 'Teluk Bintuni', 'kabupaten', 25),
(389, 475, 'Teluk Wondama', 'kabupaten', 25),
(390, 60, 'Bengkalis', 'kabupaten', 26),
(391, 120, 'Dumai', 'kabupaten', 26),
(392, 147, 'Indragiri Hilir', 'kabupaten', 26),
(393, 148, 'Indragiri Hulu', 'kabupaten', 26),
(394, 166, 'Kampar', 'kabupaten', 26),
(395, 187, 'Kepulauan Meranti', 'kabupaten', 26),
(396, 207, 'Kuantan Singingi', 'kabupaten', 26),
(397, 350, 'Pekanbaru', 'kabupaten', 26),
(398, 351, 'Pelalawan', 'kabupaten', 26),
(399, 381, 'Rokan Hilir', 'kabupaten', 26),
(400, 382, 'Rokan Hulu', 'kabupaten', 26),
(401, 406, 'Siak', 'kabupaten', 26),
(402, 253, 'Majene', 'kabupaten', 27),
(403, 262, 'Mamasa', 'kabupaten', 27),
(404, 265, 'Mamuju', 'kabupaten', 27),
(405, 266, 'Mamuju Utara', 'kabupaten', 27),
(406, 362, 'Polewali Mandar', 'kabupaten', 27),
(407, 38, 'Bantaeng', 'kabupaten', 28),
(408, 47, 'Barru', 'kabupaten', 28),
(409, 87, 'Bone', 'kabupaten', 28),
(410, 95, 'Bulukumba', 'kabupaten', 28),
(411, 123, 'Enrekang', 'kabupaten', 28),
(412, 132, 'Gowa', 'kabupaten', 28),
(413, 162, 'Jeneponto', 'kabupaten', 28),
(414, 244, 'Luwu', 'kabupaten', 28),
(415, 245, 'Luwu Timur', 'kabupaten', 28),
(416, 246, 'Luwu Utara', 'kabupaten', 28),
(417, 254, 'Makassar', 'kabupaten', 28),
(418, 275, 'Maros', 'kabupaten', 28),
(419, 328, 'Palopo', 'kabupaten', 28),
(420, 333, 'Pangkajene Kepulauan', 'kabupaten', 28),
(421, 336, 'Parepare', 'kabupaten', 28),
(422, 360, 'Pinrang', 'kabupaten', 28),
(423, 396, 'Selayar (Kepulauan Selayar)', 'kabupaten', 28),
(424, 408, 'Sidenreng Rappang/Rapang', 'kabupaten', 28),
(425, 416, 'Sinjai', 'kabupaten', 28),
(426, 423, 'Soppeng', 'kabupaten', 28),
(427, 448, 'Takalar', 'kabupaten', 28),
(428, 451, 'Tana Toraja', 'kabupaten', 28),
(429, 486, 'Toraja Utara', 'kabupaten', 28),
(430, 493, 'Wajo', 'kabupaten', 28),
(431, 25, 'Banggai', 'kabupaten', 29),
(432, 26, 'Banggai Kepulauan', 'kabupaten', 29),
(433, 98, 'Buol', 'kabupaten', 29),
(434, 119, 'Donggala', 'kabupaten', 29),
(435, 291, 'Morowali', 'kabupaten', 29),
(436, 329, 'Palu', 'kabupaten', 29),
(437, 338, 'Parigi Moutong', 'kabupaten', 29),
(438, 366, 'Poso', 'kabupaten', 29),
(439, 410, 'Sigi', 'kabupaten', 29),
(440, 482, 'Tojo Una-Una', 'kabupaten', 29),
(441, 483, 'Toli-Toli', 'kabupaten', 29),
(442, 53, 'Bau-Bau', 'kabupaten', 30),
(443, 85, 'Bombana', 'kabupaten', 30),
(444, 101, 'Buton', 'kabupaten', 30),
(445, 102, 'Buton Utara', 'kabupaten', 30),
(446, 182, 'Kendari', 'kabupaten', 30),
(447, 198, 'Kolaka', 'kabupaten', 30),
(448, 199, 'Kolaka Utara', 'kabupaten', 30),
(449, 200, 'Konawe', 'kabupaten', 30),
(450, 201, 'Konawe Selatan', 'kabupaten', 30),
(451, 202, 'Konawe Utara', 'kabupaten', 30),
(452, 295, 'Muna', 'kabupaten', 30),
(453, 494, 'Wakatobi', 'kabupaten', 30),
(454, 73, 'Bitung', 'kabupaten', 31),
(455, 81, 'Bolaang Mongondow (Bolmong)', 'kabupaten', 31),
(456, 82, 'Bolaang Mongondow Selatan', 'kabupaten', 31),
(457, 83, 'Bolaang Mongondow Timur', 'kabupaten', 31),
(458, 84, 'Bolaang Mongondow Utara', 'kabupaten', 31),
(459, 188, 'Kepulauan Sangihe', 'kabupaten', 31),
(460, 190, 'Kepulauan Siau Tagulandang Biaro (Sitaro)', 'kabupaten', 31),
(461, 192, 'Kepulauan Talaud', 'kabupaten', 31),
(462, 204, 'Kotamobagu', 'kabupaten', 31),
(463, 267, 'Manado', 'kabupaten', 31),
(464, 285, 'Minahasa', 'kabupaten', 31),
(465, 286, 'Minahasa Selatan', 'kabupaten', 31),
(466, 287, 'Minahasa Tenggara', 'kabupaten', 31),
(467, 288, 'Minahasa Utara', 'kabupaten', 31),
(468, 485, 'Tomohon', 'kabupaten', 31),
(469, 12, 'Agam', 'kabupaten', 32),
(470, 93, 'Bukittinggi', 'kabupaten', 32),
(471, 116, 'Dharmasraya', 'kabupaten', 32),
(472, 186, 'Kepulauan Mentawai', 'kabupaten', 32),
(473, 236, 'Lima Puluh Koto/Kota', 'kabupaten', 32),
(474, 318, 'Padang', 'kabupaten', 32),
(475, 321, 'Padang Panjang', 'kabupaten', 32),
(476, 322, 'Padang Pariaman', 'kabupaten', 32),
(477, 337, 'Pariaman', 'kabupaten', 32),
(478, 339, 'Pasaman', 'kabupaten', 32),
(479, 340, 'Pasaman Barat', 'kabupaten', 32),
(480, 345, 'Payakumbuh', 'kabupaten', 32),
(481, 357, 'Pesisir Selatan', 'kabupaten', 32),
(482, 394, 'Sawah Lunto', 'kabupaten', 32),
(483, 411, 'Sijunjung (Sawah Lunto Sijunjung)', 'kabupaten', 32),
(484, 420, 'Solok', 'kabupaten', 32),
(485, 421, 'Solok', 'kabupaten', 32),
(486, 422, 'Solok Selatan', 'kabupaten', 32),
(487, 453, 'Tanah Datar', 'kabupaten', 32),
(488, 40, 'Banyuasin', 'kabupaten', 33),
(489, 121, 'Empat Lawang', 'kabupaten', 33),
(490, 220, 'Lahat', 'kabupaten', 33),
(491, 242, 'Lubuk Linggau', 'kabupaten', 33),
(492, 292, 'Muara Enim', 'kabupaten', 33),
(493, 297, 'Musi Banyuasin', 'kabupaten', 33),
(494, 298, 'Musi Rawas', 'kabupaten', 33),
(495, 312, 'Ogan Ilir', 'kabupaten', 33),
(496, 313, 'Ogan Komering Ilir', 'kabupaten', 33),
(497, 314, 'Ogan Komering Ulu', 'kabupaten', 33),
(498, 315, 'Ogan Komering Ulu Selatan', 'kabupaten', 33),
(499, 316, 'Ogan Komering Ulu Timur', 'kabupaten', 33),
(500, 324, 'Pagar Alam', 'kabupaten', 33),
(501, 327, 'Palembang', 'kabupaten', 33),
(502, 367, 'Prabumulih', 'kabupaten', 33),
(503, 15, 'Asahan', 'kabupaten', 34),
(504, 52, 'Batu Bara', 'kabupaten', 34),
(505, 70, 'Binjai', 'kabupaten', 34),
(506, 110, 'Dairi', 'kabupaten', 34),
(507, 112, 'Deli Serdang', 'kabupaten', 34),
(508, 137, 'Gunungsitoli', 'kabupaten', 34),
(509, 146, 'Humbang Hasundutan', 'kabupaten', 34),
(510, 173, 'Karo', 'kabupaten', 34),
(511, 217, 'Labuhan Batu', 'kabupaten', 34),
(512, 218, 'Labuhan Batu Selatan', 'kabupaten', 34),
(513, 219, 'Labuhan Batu Utara', 'kabupaten', 34),
(514, 229, 'Langkat', 'kabupaten', 34),
(515, 268, 'Mandailing Natal', 'kabupaten', 34),
(516, 278, 'Medan', 'kabupaten', 34),
(517, 307, 'Nias', 'kabupaten', 34),
(518, 308, 'Nias Barat', 'kabupaten', 34),
(519, 309, 'Nias Selatan', 'kabupaten', 34),
(520, 310, 'Nias Utara', 'kabupaten', 34),
(521, 319, 'Padang Lawas', 'kabupaten', 34),
(522, 320, 'Padang Lawas Utara', 'kabupaten', 34),
(523, 323, 'Padang Sidempuan', 'kabupaten', 34),
(524, 325, 'Pakpak Bharat', 'kabupaten', 34),
(525, 353, 'Pematang Siantar', 'kabupaten', 34),
(526, 389, 'Samosir', 'kabupaten', 34),
(527, 404, 'Serdang Bedagai', 'kabupaten', 34),
(528, 407, 'Sibolga', 'kabupaten', 34),
(529, 413, 'Simalungun', 'kabupaten', 34),
(530, 459, 'Tanjung Balai', 'kabupaten', 34),
(531, 463, 'Tapanuli Selatan', 'kabupaten', 34),
(532, 464, 'Tapanuli Tengah', 'kabupaten', 34),
(533, 465, 'Tapanuli Utara', 'kabupaten', 34),
(534, 470, 'Tebing Tinggi', 'kabupaten', 34),
(535, 481, 'Toba Samosir', 'kabupaten', 34);

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_log_order`
--

CREATE TABLE `db_log_order` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_orders`
--

CREATE TABLE `db_orders` (
  `invoice_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `sorting_id` int(11) NOT NULL,
  `product_id` text NOT NULL,
  `price` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `total_order` int(11) NOT NULL,
  `pay_with` int(11) NOT NULL,
  `wallet` int(11) NOT NULL,
  `destination` int(11) NOT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `province` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `state` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `district` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `zip_code` int(11) NOT NULL,
  `phone_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `nama_penerima` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `delivery_service` int(11) NOT NULL,
  `resi_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `your_rekening_number` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `your_bank_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `your_atas_nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `screenshot` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `note_order` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `note_complain` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `note_deal_complain` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `start_time` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `rec_cancel` int(11) NOT NULL,
  `handle_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_order_pending`
--

CREATE TABLE `db_order_pending` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivery_id` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_order_type`
--

CREATE TABLE `db_order_type` (
  `id` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `msg` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `color` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `db_order_type`
--

INSERT INTO `db_order_type` (`id`, `type`, `msg`, `color`) VALUES
(1, 0, 'Melakukan order', '#8d918d'),
(2, 1, 'Upload bukti pembayaran', '#3863d9'),
(3, 2, 'Pembayaran terverifikasi', '#be55c9'),
(4, 3, 'Pesanan di kirim oleh kurir', '#cc781f'),
(5, 4, 'Pesanan sampai tujuan', '#00c4aa'),
(6, 5, 'Mengajukan complain', '#e8eb34'),
(7, 6, 'Pesanan akan di resolve', '#ebc634'),
(8, 7, 'Pesanan akan di refund', '#12a173'),
(9, 8, 'Selesai', '#77ff0f'),
(10, 9, 'Pesanan di Batalkan', '#bf1b06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_page_view`
--

CREATE TABLE `db_page_view` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `ip` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `date_time` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_pay_info`
--

CREATE TABLE `db_pay_info` (
  `id` int(11) NOT NULL,
  `bank_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `bank_info` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `code_bank` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `atas_nama` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `icon` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `db_pay_info`
--

INSERT INTO `db_pay_info` (`id`, `bank_name`, `bank_info`, `code_bank`, `atas_nama`, `icon`) VALUES
(2, 'Bank BCA', '98475234862', '213', 'Roger Danuarta', '1579934132.png'),
(3, 'Bank BTPN', '90011492805', '214', 'Yudha Romadhon', '1579934124.jpg'),
(4, 'Bank BRI', '23423463451', '215', 'Joe Taslim', '1579934117.png'),
(6, 'Bank MANDIRI', '52367452341', '216', 'Ahmad Muzadi', '1579934109.png'),
(7, 'Bank BNI', '7180147612', '217', 'Veri Jayadi', '1579934102.png');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_product`
--

CREATE TABLE `db_product` (
  `product_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `category` int(11) NOT NULL,
  `sub_category` int(11) NOT NULL,
  `size` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `stock` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `min_order` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `picture` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `date_time` bigint(20) NOT NULL,
  `status` int(11) NOT NULL,
  `sorting_id` int(11) NOT NULL,
  `transaction_scheme` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `db_product`
--

INSERT INTO `db_product` (`product_id`, `user_id`, `title`, `description`, `category`, `sub_category`, `size`, `stock`, `price`, `min_order`, `weight`, `picture`, `date_time`, `status`, `sorting_id`, `transaction_scheme`) VALUES
('IKN/KSU/27022020200948', 29, 'Ikan Hias Aquascape Ramirezi Blue Electric Baloon', 'HANYA PAKAI OJEK ONLINE\r\nSELAIN ITU CANCEL!\r\nTanya stok terlebih dahulu\r\nUkuran Blue elektrik 2 cm \r\nCocok untuk penggemar aquascape\r\n\r\nMelayani Gosend dan Grab saja\r\nOrder diatas jam 16.00 akan dikirim esok harinya', 1, 35, 'Kecil', 50, 8000, 5, 15, '[\"1582808988-1.jpg\",\"1582808988-2.jpg\",\"1582808988-3.jpg\"]', 1582808988, 1, 36, 1),
('IKN/KSU/27022020201542', 29, 'Ikan Hias Cupang Super Red Plakat', 'CASH BACK 20RB SETIAP PEMBELANJAAN 150RB (belum termasuk ongkir) BERLAKU KELIPATANNYA sebelum belanja hubungin no.081909882956\r\n\r\n\r\n1. Packing yang kita gunakan individu (satu kantung satu ikan)\r\n2. mengunakan oksigen full dan dapat bertahan 3-4 hari pengiriman\r\n3. Ikan Bergaransi\r\n4. Jika ingin membeli pasangan tinggal order dua atau lebih lalu berideskripsi pasangan.\r\n\r\nSyarat klam garansi\r\n1. kirim bukti foto minimal 3 atau vidio unboxing ikan\r\n2. garansi uang kembali sesuai ikan yang mati atau kirim ikan lagi diorderan selanjutnya\r\n3. garansi gratis ongkir apa bila ikan yang mati lebih dari 80%\r\n\r\nFAST RESPONSE VIA WA 081909882956 ', 1, 35, 'Kecil', 100, 22000, 1, 100, '[\"1582809342-1.jpg\",\"1582809342-2.jpg\"]', 1582809342, 1, 37, 1),
('IKN/KSU/27022020201746', 29, 'Ikan Hias Cupang Half Moon', 'CASH BACK 20RB SETIAP PEMBELANJAAN 150RB (belum termasuk ongkir) BERLAKU KELIPATANNYA sebelum belanja hubungin no.081909882956\r\n\r\nJika ingin Membeli ikan selain guppy bisa kunjungi link ini https://www.tokopedia.com/ggikan\r\n\r\n1. Packing yang kita gunakan individu (satu kantung satu ikan)\r\n2. mengunakan oksigen full dan dapat bertahan 3-4 hari pengiriman\r\n3. Ikan Bergaransi\r\n4. Jika ingin membeli pasangan tinggal order dua atau lebih lalu berideskripsi pasangan.\r\n\r\nSyarat klam garansi\r\n1. kirim bukti foto minimal 3 atau vidio unboxing ikan\r\n2. garansi uang kembali sesuai ikan yang mati atau kirim ikan lagi diorderan selanjutnya\r\n3. garansi gratis ongkir apa bila ikan yang mati lebih dari 80%\r\n\r\nFAST RESPONSE VIA WA 081909882956 ', 1, 35, 'Kecil', 100, 6000, 5, 100, '[\"1582809466-1.jpg\",\"1582809466-2.jpg\",\"1582809466-3.jpg\",\"1582809466-4.jpg\"]', 1582809466, 1, 38, 1),
('IKN/KSU/27022020202006', 29, 'Ikan Hias Cichlid Lemon', 'Ukuran 4 cman', 1, 35, 'Kecil', 30, 5000, 5, 75, '[\"1582809606-1.jpg\",\"1582809606-2.jpg\",\"1582809606-3.jpg\"]', 1584868601, 1, 39, 1),
('IKN/KSU/27022020202227', 29, 'Ikan Hias Black Ghost / Black Ghost Knife Fish', 'HANYA PAKAI OJEK ONLINE\r\nSELAIN ITU CANCEL!\r\nIkan Black ghost knife fish size -+ 7cm\r\n\r\nhanya melayani menggunakan gosend dan grab\r\njam operasional :\r\nsenin-sabtu = 08.00-16.00 \r\nminggu : 08.00-12.00\r\n\r\nWA : 085780037347', 1, 35, 'Kecil', 35, 15000, 1, 50, '[\"1582809747-1.jpg\",\"1582809747-2.jpg\"]', 1582809747, 1, 40, 1),
('PKN/PAN/27022020202445', 29, 'daphnia magna, kutu air giant pakan ikan hias', 'Berat 250-300 gram , sangat cocok untuk pakan cupang guppy jenis tetra dll', 3, 41, 'Kecil', 100, 10000, 1, 800, '[\"1582809885-1.jpg\"]', 1582809886, 1, 41, 0),
('PKN/POR/27022020202630', 29, 'makanan pakan ikan cupang kecil hias guppy mutiara tropical', 'MUTIARA TROPICAL 100gr\r\nBisa digunakan untuk semua jenis ikan, \r\nSpesialis ikan kecil seperti : guppy, neon, platys, dll\r\n\r\nMakanan ikan berbentuk butiran-butiran kecil untuk ikan tropis kecil dan spesies dengan mulut kecil.\r\n-Mengandung astaxanthin, spirulina, udang segar, dan perwarna fermentasi untuk membentuk warna cerah yang alami.\r\n-Diperkaya dengan vitamin C untuk membantu sistem kekebalan tubuh dan mencegah ikan dari stres.\r\n-Dibuat dengan komposisi ekstrak udang kecil yang banyak untuk meningkatkan kilau tubuh ikan, serta meningkatkan sistem pencernaan ikan agar dapat bertahan dari polusi air.\r\n\r\nPelet Pakan Ikan Kecil Baby Mutiara 100gr\r\n\r\nSpesial Untuk Ikan Tropis\r\nUkuran 1 mm cocok untuk ikan kecil ( guppy, tetta, sumatra, dll)\r\nKandungan Protein 48% Cocok untuk pertumbuhan ikan\r\nFiber 4%\r\nLemak 8%\r\nMoisture 7,5%\r\nBerat 100 gr', 3, 42, 'Sedang', 70, 12500, 1, 150, '[\"1582809989-1.jpg\",\"1582809989-2.jpg\"]', 1582809990, 1, 42, 0),
('IKN/KSU/27022020202843', 29, 'Ikan Hias Guppy AFR Pasangan', 'Ikan Guppy pasangan AFR Sudah siap brending\r\n\r\nWa. 08987929578', 1, 35, 'Kecil', 100, 35000, 1, 56, '[\"1582810123-1.jpg\",\"1582810123-2.jpg\",\"1582810123-3.jpg\"]', 1582810123, 1, 43, 1),
('PKN/PAN/27022020203055', 29, 'makanan ikan hias koi sakura', 'Klik di sini khusus pengiriman By gojek gosend yang lain tolak!!!\r\n\r\n\r\nIsi 10 Kg uk pellet 5 mm', 3, 41, 'Besar', 30, 113500, 1, 12000, '[\"1582810255-1.jpg\",\"1582810255-2.jpg\"]', 1582810255, 1, 44, 0),
('PKN/POR/27022020203245', 29, 'Burger Ikan Hias / Discus / Louhan', 'BUKTIKAN SENDIRI DAN DAPATKAN PELAYANAN RESPONS CEPAT DAN BARANG BERKUALITAS DARI TOKO KAMI ORDER SEKARANG JUGA \r\n\r\nPACKING SANGAT RAPIH SEHINGGA PENGIRIMAN BARANG AMAN SAMPAI TUJUAN ANDA \r\n\r\nBurger pakan olahan / Discus dari jantung sapi plus multivitamin dan mineral yg dibutuhkan ikan untuk meningkatkan daya tahan tubuh serta mencerahkan warna merah pada ikan anda. \r\nHarga untuk 100 Gr\r\n\r\n*PENGIRIMAN HANYA DENGAN Grab Express dan GOJEK GOSEND YA*\r\n\r\nJIKA ANDA ORDER DILUAR GOJEK (JNE YES DAN TIKI ONS RESIKO PEMBELI) \r\n\r\n*Karena Ini makanan Beku yang sifatnya mudah mencair*\r\n\r\nORDER SEKARANG JUGA!!', 3, 42, 'Besar', 50, 35000, 1, 300, '[\"1582810365-1.jpg\",\"1582810365-2.jpg\"]', 1582810365, 1, 45, 0),
('IKN/KSU/27022020203456', 29, 'Ikan Hias Aquascape Golden Ramirezi Tropical', 'Hanya menggunakan Ojek online\r\nSelain itu cancel!!\r\nUkuran 2,5 cm', 1, 35, 'Kecil', 500, 2000, 10, 15, '[\"1582810495-1.jpg\",\"1582810496-2.jpg\",\"1582810496-3.jpg\"]', 1582810496, 1, 46, 1),
('IKN/KSU/27022020203631', 29, 'Ikan Hias Aquascape Synodontis Eupterus / Synodontis Fish', 'HANYA PAKAI OJEK ONLINE\r\nSELAIN ITU CANCEL!\r\n\r\nIkan Synodontis Eupterus / Synodontis Fish size 3 cm up termasuk ekor\r\nBisa berperan sebagai ALGA EATER \r\ncocok untuk pencinta aquascape\r\n\r\nhanya melayani menggunakan gosend dan grab\r\njam operasional :\r\nsenin-sabtu = 08.00-16.00 \r\nminggu : 08.00-12.00\r\n\r\nWA : 085780037347', 1, 35, 'Sedang', 90, 6000, 2, 100, '[\"1582810591-1.jpg\"]', 1582810591, 1, 47, 1),
('IKN/KSU/27022020203845', 29, 'Ikan Hias Rainbow Shark / Red Tail Fin', 'HANYA PAKAI OJEK ONLINE\r\nSELAIN ITU CANCEL!\r\nUkuran 4 cm', 1, 35, 'Kecil', 200, 3500, 3, 20, '[\"1582810724-1.jpg\"]', 1582810725, 1, 48, 1),
('IKN/KSU/27022020203939', 29, 'Ikan Hias Cichlid Niasa / Melanochromis Auratus', 'HANYA PAKAI GRAB GOJEK!\r\nUkuran 3,5 - 4 cm', 1, 35, 'Kecil', 50, 5000, 2, 75, '[\"1582810779-1.jpg\"]', 1582810779, 1, 49, 1),
('IKN/KSU/27022020204226', 29, 'Ikan Hias Maskoki Mas Koki Tosa Aquarium Aquascape Garansi Hidup', 'kELEBIHAN IKAN KAMI\r\n1. WARNA PILIHAN LEBIH CERAH\r\n2. UMUR BAGUS\r\n3. PEMBERIAN VITAMIN RUTIN (SAYA BUKAN PETERNAK TAPI PECINTA IKAN HIAS)\r\n4. GARANSI HIDUP SAMPAI DITEMPAT\r\n5. GRATIS O2\r\n\r\nUntuk Harga Ikan Belum Termasuk Ongkos Packing Busa untuk disarankan membeli Packing Busa Hanya 10rb perak di link ini\r\n\r\nWARNING\r\nBILA INGIN MENDAPATKAN GARANSI HIDUP SAMPAI DITEMPAT WAJIB MENGGUNAKAN PACKING TAMBAHAN', 1, 35, 'Sedang', 25, 30000, 1, 250, '[\"1582810946-1.jpg\",\"1582810946-2.jpg\",\"1582810946-3.png\"]', 1582810946, 1, 50, 1),
('IKN/KSU/27022020204900', 29, 'Ikan Hias Gurame Dwarf / sepat Laris', 'CASH BACK 20rb atau pemotongan ongkir setiap pembelanjaan minimal total belanja ditoko senilai 150 rb sebelum order harap hub 085717502689,\r\n\r\n# Kelipatan Berlaku.\r\n\r\n\r\n1. Packing yang kita gunakan individu (satu kantung satu ikan)\r\n2. mengunakan oksigen full dan dapat bertahan 3-4 hari pengiriman\r\n3. Ikan Bergaransi\r\n4. Jika ingin membeli pasangan tinggal order dua atau lebih lalu berideskripsi pasangan.\r\n\r\nSyarat klam garansi\r\n\r\n1. kirim bukti foto minimal 3 atau vidio unboxing ikan\r\n2. garansi uang kembali sesuai ikan yang mati atau kirim ikan lagi diorderan selanjutnya\r\n3. garansi gratis ongkir apa bila ikan yang mati lebih dari 80%\r\n\r\n#guppy #ikanhias #aquascape #hobi\r\n\r\nFAST RESPONSE VIA WA 085717502689', 1, 35, 'Besar', 70, 55000, 1, 500, '[\"1582811340-1.jpg\"]', 1582811340, 1, 51, 1),
('PKN/POR/27022020205215', 29, 'Pakan Makanan Ikan Lele Nila Gurame Pelet Hi Provit 781-2 Repack 1 Kg', 'Pakan Pelet ikan Air Tawar type mengapung. untuk ikan Mas,lele,nila,gurame dll.\r\n\r\nPakan ikan Lele,nila,gurame,dan ikan air tawar lainnya. Cocok untuk ikan ukuran 10 cm ke atas / biasa digunakan untuk pakan indukan\r\n\r\nKeunggulan produk:\r\n\r\n- Menggunakan bahan baku yang berkualitas tinggi dan dipilih secara selektif.\r\n- Memiliki nutrisi yang tinggi dengan kandungan protein yang sesuai untuk pertumbuhan ikan.\r\n- Mempunyai Atractant yang kuat, merangsang nafsu makan ikan dan ukuran pakan sesuai dengan bukaan mulut ikan sehingga mudah dicerna dengan baik.\r\n-Diformulasikan khusus untuk meningkatkan daya tahan tubuh ikan dan menghasilkan pertumbuhan yang maksimum\r\n\r\nDiproduksi di bawah pengawasan kontrol kualitas yang ketat untuk menjamin hasil produk yang terbaik.\r\n\r\nKandungan / Tipe / Kemasan / Komposisi Produk\r\n\r\n- Kode Pakan 781-2\r\n- Bentuk Ukuran 2.3-3.0 (mm)\r\n- Protein 31-33 (%)\r\n- Lemak 4-6 (%)\r\n- Fiber 3-5 (%)\r\n- Kadar Air 9-10 (%)\r\n\r\nSize Ikan 10-20 (gr/ekor)\r\n\r\nFeeding Frekuensi Rate 2-3 x sehari', 3, 42, 'Besar', 150, 25000, 1, 1000, '[\"1582811535-1.jpg\"]', 1584880695, 1, 52, 0),
('PKN/PAN/27022020205337', 29, 'Pakan Bibit Ikan Kecil FF-999', '*harga diatas untuk 1 kilo\r\n\r\nUntuk agan yang butuh pakan dengan ukuran sangat kecil untuk benih ikan\r\n\r\nAgan dapat mencoba pakan FF-999 punya centralprima (cp) \r\n\r\nBagus sekali untuk pertumbuhan\r\nBeli 1 karung (10 kg) lebih murah\r\n\r\nSyarat mendapat GARANSI :\r\n1. Setelah barang diterima, mohon ulas kami dengan memilih Puas\r\n2. Mohon ulas rating 4 atau 5 pada produk kami.\r\n3. TIDAK MENGIKUTI POIN 1 DAN 2 GARANSI TIDAK BERLAKU\r\n4. Ikan Akan diganti bila masih garansi. ONGKIR TIDAK DIGANTI', 3, 41, 'Besar', 30, 31500, 1, 1000, '[\"1582811617-1.jpg\",\"1582811617-2.jpg\"]', 1582811617, 1, 53, 0),
('PKN/PAN/27022020205743', 29, 'pakan ikan louhan / pelet ikan okiko platinum', 'Keunggulan:\r\n\r\nKomposisi nutrisi seimbang untuk mempercepat pertumbuhan ikan.\r\nMembentuk struktur tulang ikan yang sempurna.\r\nMeningkatkan daya tahan tubuh ikan terhadap penyakit.\r\nTerbuat dari bahan alami pilihan, tanpa pewarna buatan.\r\nTidak mengeruhkan air.\r\n\r\nBahan-bahan:\r\nPeru/chilean fish meal, marine protein, shrimp meal, spirulina, wheat flour, corn gluten meal, soybean meal, yeast, stabilized vitamin C, calcium and monosodium phosphor, essential vitamins and minerals.\r\n\r\nType floating\r\n\r\nUNTUK IKAN\r\n2mm	: ikan koi ukuran 5-15 cm \r\n5mm	: ikan koi ukuran >15cm', 3, 41, 'Besar', 10, 120000, 1, 5000, '[\"1582811863-1.jpg\"]', 1582811864, 1, 54, 0),
('PKN/POR/27022020205831', 29, 'pakan ikan louhan / pelet ikan okiko platinum', 'pelet ikan louhan\r\nokiko head huncher & colour faster\r\nReady size M,dan XL\r\nFloating type\r\nberat 100gr', 3, 42, 'Kecil', 55, 35000, 1, 100, '[\"1582811911-1.jpg\"]', 1582811911, 1, 55, 0),
('PKN/POR/27022020205919', 29, 'KONISHI SUPER HI GROWTH 2 KG PAKAN IKAN IMPOR FLOATING SIZE M 5MM', 'PAKAN IKAN IMPOR KONISHI SUPER HI GROWTH, FLOATING, SIZE M (UKURAN BUTIR 5MM).\r\n\r\nPAKAN HARIAN TERBAIK UNTUK IKAN.\r\nKUALITAS TELAH TERBUKTI DAN TERUJI (BUKAN MERK BARU).\r\n\r\nSANGAT BAGUS UNTUK PERTUMBUHAN YANG CEPAT, TANPA MERUSAK WARNA IKAN.\r\nMEMBENTUK BODY IDEAL IKAN .\r\nTIDAK MEMBUAT KERUH AIR.\r\n\r\nGUARANTEED ANALYSIS : \r\nPROTEIN : 48%\r\nFAT : 9%\r\nFIBER : 5%\r\nASH : 10%\r\nVITAMIN etc : 28%\r\n\r\nHARGA SPECIAL.\r\nBUKAN STOK LAMA.\r\nGARANSI 100% ORIGINAL (BUKAN ASPAL).', 3, 42, 'Besar', 30, 180000, 1, 2000, '[\"1582811959-1.jpg\"]', 1582811959, 1, 56, 0),
('PKN/PAN/27022020210029', 29, 'HIRO COLOR EXPERT makanan pakan pelet ikan koi fish food', 'ETALASE KHUSUS COLOR EXPERT\r\n\r\norder HIGH GROWTH di link berikut\r\n\r\nMerk : Hiro\r\nvarian : COLOR EXPERT\r\nSize M: untuk koi panjang 20cm ke atas\r\n\r\nProdusen : PT. CENTRAL PROTEINA PRIMA Tbk\r\n\r\nType : Floating ( Terapung )\r\nBerat Bersih : 1kg\r\n\r\nNutrisi Lengkap dan seimbang untuk memacu pertumbuhan dan bentuk ikan yang bagus dengan kandungan protein tinggi 42%.\r\n\r\nBahan-bahan :\r\nFish Meal, Soybean Meal, Wheat flour, Corn, Squid Meal, Krill Meal, Fish Oil, Corn Gluten Meal, Spirulina, Vitamins and Minerals', 3, 41, 'Besar', 100, 65000, 1, 1500, '[\"1582812029-1.jpg\"]', 1582812029, 1, 57, 0),
('PKN/PAN/27022020210140', 29, 'Spirulina Powder / Pakan Burayak Ikan (50gram)', 'Spirulina Powder (50gram) dapat di manfaatkan untuk pakan benih ikan air tawar maupun laut.\r\n\r\nSpirulina merupakan mikroalga/fitoplankton yang dapat dimanfaatkan sebagai pakan alami benih ikan, baik ikan air laut atau tawar. Alga ini mempunyai kandungan gizi yang tinggi, yaitu protein yang bisa mencapai 60 %\r\n\r\nSpirulina merupakan mikroalga hijau kebiruan. Alga ini mengandungan berbagai zat gizi seperti protein dapat mencapai 60 %, lipid 8%, karbohidrat 16%,vitamin B1, B2, B6, B12, C, niasin, karotin dan kandungan asam amino yang cukup seimbang. Spirulina juga mengandung salah satu asam lemak esensial yaitu asam -linoleat (GLA), yang merupakan asam lemak majemuk. Kandungan membuat SPIRULINA SANGAT BERMANFAAT BAGI PERTUMBUHAN IKAN HIAS.\r\n\r\nAgar packingan lebih aman, kami menyarankan untuk menambah packingan dengan bubble wrap\r\n\r\nBerat bersih 50gram', 3, 41, 'Sedang', 43, 23500, 1, 150, '[\"1582812100-1.jpg\"]', 1582812100, 1, 58, 0),
('PKN/PAN/27022020210245', 29, 'Pakan ikan koi CP Balance untuk koi', '*MENGANDUNG EKSTRAK BAWANG PUTIH\r\n*UKURAN PELET 2 MM\r\n\r\nHalo gan. \r\nAda stok CP koi untuk koi anda \r\n\r\nCP koi memiliki warna merah kecoklatan dengan keungulan tipe pakan apung yang mudah dicerna, mempunyai vitamin dan nutri yang baik untuk ikan. \r\n\r\nCP koi memiliki nutrisi yang seimbang. bagus sekali bila dicampur dengan koi spirullina \r\n\r\nAnda dapat membeli CP koi secara kiloan di Ikanesia.\r\n\r\nHarga diatas berlaku untuk 1 kg pakan\r\nPelet akan di Repack menggunakan bungkus PLASTIK BENING\r\n\r\nSyarat mendapat GARANSI : \r\n1. Setelah barang diterima, mohon ulas kami dengan memilih Puas \r\n2. Mohon ulas rating 4 atau 5 pada produk kami. \r\n3. TIDAK MENGIKUTI POIN 1 DAN 2 GARANSI TIDAK BERLAKU \r\n4. Ikan Akan diganti bila masih garansi. ONGKIR TIDAK DIGANTI \r\n\r\nKunjungi kami di google maps Ikanesia Koi Farm', 3, 41, 'Besar', 50, 55000, 1, 1500, '[\"1582812165-1.jpg\",\"1582812165-2.jpg\"]', 1582812165, 1, 59, 0),
('KLM/KKC/27022020210518', 29, 'Kandila 54L Tank iglass 500 50x35x35cm Aquarium', 'aquarium kandila iglass ini model tekuk tanpa sambungan dibagian depan\r\np 50cm\r\nl 35cm\r\nt 35cm\r\nvolume 54 liter / 57 liter\r\n\r\ntampil mewah dengan model lengkung dan Gosok Halus', 2, 37, 'Besar', 50, 325000, 1, 9000, '[\"1582812318-1.jpg\",\"1582812318-2.png\"]', 1582812318, 1, 60, 0),
('KLM/KKC/27022020210704', 29, 'Aquarium mini & elegant', 'Akuarium mini cocok buat dimeja tamu, meja kantor, meja belajar dan ruang tidur, ringan sehingga mudah untuk dipindah dan dibersihkan. \r\n\r\nCocok buat ikan hias cupang, ikan guppy & ikan hias kecil lainnya, Disarankan agar tidak dicampur biar tidak terjadi tawuran (hehehe...).\r\n\r\nDiameter 17 cm tebal 12 cm dan dilapis kulit bermotif buaya / kayu (tergantung stok yang ada).\r\n\r\nHarga diatas hanya akuariumnya saja. \r\n\r\nHARGA PROMOSI.... Stok sangat terbatas.', 2, 37, 'Sedang', 50, 107000, 1, 1000, '[\"1582812424-1.jpg\"]', 1582812424, 1, 61, 0),
('KLM/KKC/27022020210831', 29, 'AQUARIUM BULAT 7 LITER / TOPLES SHELLA / FISH BOWL', 'HATI HATI TERTIPU DENGAN BARANG MURAH, BARANG KAMI DIJAMIN 100% ORIGINAL YANG MANA ORIGINAL ADALAH KUALITAS TERBAIK\r\n\r\nKHUSUS GOJEK/GRAB YAAA!!\r\nselain itu=blacklist&cancel\r\n\r\nUkuran 7 liter air\r\nDiameter 25cm, tinggi 23cm\r\nKACA TEBAL, PENGIRIMAN HANYA DAPAT MELALUI GOJEK.\r\n\r\nToko kami memiliki toko fisik di daerah Jakarta Pusat. Tepatnya di Jl. Kartini Raya No. 54, Kartini, Sawah Besar.', 2, 37, 'Sedang', 17, 60000, 1, 4000, '[\"1582812511-1.jpg\"]', 1582812511, 1, 62, 0),
('KLM/KKC/27022020211014', 29, 'Aquarium Ultra Clear Glass 30cm', 'Ultra Clear / Optic Clear Aquarium glass tank\r\nBerbeda dengan kaca pada umumnya yang berwarna hijau, kaca ultra clear mengandung hanya sedikit zat besi, sehingga meningkatkan kejernihan pada kaca dan warna natural. Dengan tidak adanya efek hijau pada kaca, sehingga cahaya yang dibiaskan adalah warna sesungguhnya. \r\n\r\n30cm Dimensi PxLxT - 30x19x24cm \r\n\r\nUntuk Nano tank aquascape, betta, guppy, shrimps maniac.\r\n\r\nPengiriman luar kota wajib menggunakan packing kayu, biaya pengiriman akan lebih mahal. \r\nKonsultasikan pada kami untuk pengiriman luar kota. :)', 2, 37, 'Besar', 22, 135000, 1, 3000, '[\"1582812614-1.jpg\"]', 1582812614, 1, 63, 0),
('KLM/KKC/27022020211250', 29, 'Tank Aquarium / Glass water tank Bahan Akrilik / Volume 60 Liter', 'PENGIRIMAN HANYA MENGGUNAKAN GO-SEND / GRAB ! Mohon maaf, tidak melayani pengiriman menggunakan JNE, TIKI, J&T Dll. \r\n\r\nAquarium terbuat dari bahan Akrilik. \r\nSize : 60 x 29,5 x 35,5 cm | Volume air : 60 Liter \r\n\r\nHitam : Ready\r\nOrange : -\r\nUngu : -\r\nBiru : \r\nHijau muda : -\r\n\r\n\r\nAda dua merek. Nikita dan Armada akan dikirim sesuai stok yang tersedia. \r\n\r\nFast Respon Whatsapp : 089605221041 .\r\n\r\nSelamat berbelanja :)', 2, 37, 'Besar', 13, 175000, 1, 3500, '[\"1582812770-1.jpg\"]', 1582812770, 1, 64, 0),
('KLM/KBN/27022020211505', 29, 'Chihiros RGB VIVID 2 - Series Aquarium/Aquascape Lamp LED', 'Chihiros RGB VIVID 2 adalah generasi terbaru dari series lampu Chihiros, dilengkapi dengan built in bluetooth module pada lampu, sehingga anda dapat mengatur intensitas, on/off, atau sunrise-sunset dari aplikasi My Chihiros pada smartphone anda.\r\nRGB VIVID 2\r\n\r\n•	Size box unit 55.6x24.3x11.8 cm\r\n•	Size/Light unit 45.5x16.2x3.4 cm\r\n•	Weight/light unit: 2kgs, power supply: 0.55 kg\r\n•	Input voltage AC100-240V 50/60 HZ\r\n•	Power consumption 130 W\r\n•	Led light/ 160PCS(RGB IN ONE LED SHIP)\r\n•	Operating temperature range: -20-40\r\n•	 4m DC CABLE\r\n•	 Luminous flux:5500 lm\r\n•	Built in bluetooth controller (New app:My Chihiros)\r\n\r\nTHE DIFFERENCE BETWEEN OLD ONE :\r\n•	VIVID2 size more silm2. RGB VIVID have two colors, which are silver and black\r\n•	APP new function for each one or two colors can adjust more than 100% \r\n        when other colors setting under 100%\r\n•	RGB VIVID use by GVE power supply, only Germany still use Meanwell power supply\r\n•	Hang up use new way can more easier to balance the body of lamp\r\n\r\nChihiros Indonesia memberikan garansi resmi 1 tahun untuk pembelian dari reseller chihiros Indonesia.', 2, 39, 'Besar', 27, 5325000, 1, 6000, '[\"1582812904-1.jpg\",\"1582812904-2.jpg\",\"1582812904-3.jpg\"]', 1582812905, 1, 65, 0),
('KLM/KFB/27022020211724', 29, 'Paket Akuarium Aquascape', 'Aquascape masih sangat baru untuk dijual alasan dikarenakan ingin pindah luar kota', 2, 38, 'Besar', 1, 35000000, 1, 45000, '[\"1582813044-1.jpg\",\"1582813044-2.jpg\",\"1582813044-3.jpg\",\"1582813044-4.jpg\"]', 1582813045, 1, 66, 0),
('KLM/KFB/27022020211858', 29, 'Red Sea Reefer Peninsula 650 160x60 Black Aquarium Kabinet Sump set', 'NOTE!\r\nUntuk pemesanan aquarium bisa hubungi :\r\n081381037790 (call/whatsapp)\r\n\r\nKonsep REEFER\r\nSeri Sistem Laut REEFERdari Red Seamemberi penghobi yang kuat dengan fondasi yang kuat untuk membangun akuarium karang atau laut berfitur lengkap. Seri REEFERmenggabungkan akuarium kaca kontemporer, tanpa bingkai, ultra-bening dengan kabinet penuh gaya dan sistem pengelolaan air yang komprehensif termasuk tempat penampungan siap pakai refugium profesional dengan top-up otomatis terintegrasi dan sistem aliran bawah yang unik.\r\n\r\nAkuarium dibangun dari kaca tebal, tepi miring, ultra-bening untuk mendukung desain tanpa bingkai yang elegan dan modern.Akuarium duduk di pangkalan tersembunyi yang mengapung di atas kabinet, yang dengan mulus mengikuti kontur kaca. Kabinet laminasi spek kelautan yang menampung bah, (dan dalam model yang lebih besar juga mencakup ruang khusus untuk ventilasi), dilengkapi dengan cerdas dengan pintu tahan cuaca dan dicat epoksi.\r\n\r\nSistem manajemen air :\r\nSisir skimming permukaan yang dapat dilepas mengelilingi bagian atas kotak luapan yang terletak di pusat yang menampung pipa turun, pipa penampung kembali, dan nozzle outlet balik bola mata multi-arah yang bijaksana.\r\n\r\nDalam hal terjadi penyumbatan pada pipa yang diatur, pipa luapan darurat tambahan memberikan aliran bebas air akuarium langsung ke bak penampung, dalam hal terjadi penyumbatan pada pipa yang mengatur, pipa luapan darurat menyediakan aliran bebas akuarium air langsung ke bak penampung.Untuk menghilangkan gelembung udara yang mungkin lolos dari skimmer, air melewati kaskade pengupasan gelembung dalam perjalanan ke ruang pompa kembali.', 2, 38, 'Besar', 5, 59450000, 1, 70000, '[\"1582813138-1.png\"]', 1582813138, 1, 67, 0),
('KLM/KFB/27022020212226', 29, 'Aquarium Full Jati', 'BERKAH AQUARIUM\r\nAquarium Kabinet P300cm L70cm T70cm\r\n- Rangka Besi Holo 5X5\r\n- Kabinet Full Jati\r\n- Finishing Cat Plitur Coklat\r\n- Kaca 12mm Tempered\r\n- Cannister Resun EF-2800 = 1pcs \r\n- UV-Lamp Atman 36 Watt = 1pcs\r\n- Air Pump = 1pcs\r\n- Lampu Tanning P280cm 144 LED 12.000 kelvin\r\n- Aerator Bundar = 1pcs\r\n- Background Scotlite Hitam Gloss Oracal\r\nPengerjaan : 30 hari', 2, 38, 'Besar', 4, 39000000, 1, 25000, '[\"1582813346-1.jpg\",\"1582813346-2.jpg\",\"1582813346-3.jpeg\",\"1582813346-4.jpg\"]', 1582813346, 1, 68, 0),
('KLM/KFB/27022020212331', 29, 'Akuarium Aquarium Kabinet Fullset Custom', 'Jual Akuarium Kabinet Custom Fullset\r\n\r\n(lampu UV, Filter lengkap)\r\n\r\nHarga Nego\r\n\r\nLokasi Jakarta pusat\r\n(angkut sendiri tp bisa kita nego lagi hehe)\r\n\r\nminat? hub 08170459999 (WA/SMS/CALL)\r\n\r\nmakasih gan!', 2, 38, 'Besar', 10, 27800000, 1, 15000, '[\"1582813411-1.jpg\",\"1582813411-2.jpeg\"]', 1582813411, 1, 69, 0),
('KLM/KFB/27022020212439', 29, 'BOYU SET AKUARIUM DAN KABINET LY-1500A D - GOLD - JABODETABEK ONLY', 'Pengiriman Khusus JABODETABEK (berat produk dan ongkos kirim sudah disesuaikan dengan tarif pengiriman ke JABODETABEK)\r\n\r\nUntuk pengiriman JABODETABEK silahkan dipesan seperti biasa. Ongkir yang tertera saat checkout adalah ongkir kurir toko kami.\r\n\r\nHadirkan suasana akuatik di sekitar Anda dengan Boyu set akuarium dan kabinet. Dilengkapi dengan kabinet yang bisa digunakan untuk menyimpan pakan ikan dan aksesoris akuarium. Boyu Set Akuarium dan Kabinet dapat digunakan untuk ikan air tawar atau air laut. Akuarium ini juga sudah dilengkapi dengan pompa air untuk sirkulasi ke filter. Bisa dipajang di rumah atau area kantor sesuai dengan gaya dekorasi selera Anda.\r\n\r\nUntuk ikan air tawar atau laut\r\n\r\n	Dilengkapi dengan kabinet  filter  pompa  dan lampu akuarium\r\n\r\nDilengkapi dengan termostat suhu akuarium\r\n\r\nDimensi produk : 150 x 65 x 166 cm\r\n\r\nKetebalan kaca : 10 mm\r\n\r\nDaya pompa : 23W 2300L/H\r\n\r\nKonsumsi daya lampu : 3 x 16W', 2, 38, 'Besar', 15, 36000000, 1, 20000, '[\"1582813479-1.jpg\"]', 1582813479, 1, 70, 0),
('KLM/KPS/27022020212533', 29, 'AQUARIUM AIR TAWAR', 'BISMILLAH\r\n\r\nMAU JUAL AQUARIUM AIR TAWAR BESERTA IKAN TERUMBU KARANG DAN MESIN NYA\r\n\r\nMASIH BAGUS DAN TERAWAT SEKALI\r\n\r\nSILAHKAN BAGI YANG SEDANG MENCARI AQUAIRIUM LANGKA\r\n\r\nBUKA HARGA 35.000.000 (NEGOTIABLE)\r\n\r\nSILAHKAN BISA HUBUNGI SAYA LANGSUNG\r\nWA/TLPN 0812-1869-0829 (HIMA)', 2, 40, 'Besar', 1, 16700000, 1, 18000, '[\"1582813533-1.jpg\"]', 1582813533, 1, 71, 0),
('ACG/JRN/27022020212744', 29, 'Joran Hemus Challenger 502 (FUJI)', 'Length 502 (150cm)\r\nLine up 6-14lb\r\nGuide FUJI O Ring\r\nHemus Challenger Spinning Rods menghadirkan teknologi blank ultra advanced dan komponen premium. Hemus Challenger mampu menggunakan resin polyacrylonitrile yang mengoptimalkan fitur serat karbon yang menghasilkan kelenturan dan ketahanan kompresi yang mengejutkan.\r\n Seri Hemus Challenger dirancang untuk mengurangi secara signifikan ujung pantulan setelah gips, Bagian tengah blank dan tip memiliki aksi yang berbeda, tulang punggung bereaksi terhadap jumlah kekuatan, mengeras ketika kekuatan meningkat, membuat batang sangat mampu  menyeret ikan tanpa kehilangan kemampuan gips.\r\nSkema guide adalah cincin FUJI O yang memungkinkan presisi sempurna dalam presentasi dan sensitivitas tarikan ikan.', 43, 45, 'Sedang', 5, 300000, 1, 400, '[\"1582813664-1.jpg\"]', 1582813664, 1, 72, 0),
('ACG/JRN/27022020213019', 29, 'Joran Ryobi Tokumei UL 6.0F (Fuji) Ultra Light Fishing Rod Spinning', 'elamat Datang di mancing id\r\nKami Menyediakan Berbagai Macam Alat Pancing\r\n===================================================================================\r\n\r\nDescription Product:\r\nRyobi Tokumei UL 6.0F Ultra Light Fishing Rod Spinning\r\n- Length : 6 (180cm)\r\n- Ring Qty : 8\r\n- Line : 1-6Lb\r\n- Lure : 0.8 - 5 gram.\r\n- Rod Weight : 60 gram\r\n- BattleField : Ocean Rock Fishing, River, Lake\r\n- Fuji Guide/Ring \r\n- Japan Style Handle\r\n\r\n====================================================================================\r\n--> Harap Menanyakan Ketersediaan Barang Sebelum Membeli.\r\n--> Orderan Maksimal jam 15:00WIB Agar Dikirim Dihari Yang Sama.\r\n\r\n--> For More Information Please Contact :\r\n0812-9060-6858 (WhatsApp)\r\n\r\nTerima Kasih', 43, 45, 'Besar', 7, 520000, 1, 2000, '[\"1582813819-1.jpg\"]', 1582813819, 1, 73, 0),
('ACG/JRN/27022020213229', 29, 'SET JORAN / ALAT PANCING MURAH (JORAN UTICATE & REEL AUDREY)', '>>>SET PANCING PEMULA SUPER LARIS!!!\r\n\r\nSET PANCING INI SANGAT cocok untuk dipakai Anak-anak maupun Dewasa yang masih PEMULA dan cocok dipakai untuk mancing kolam/Balong/empang, sungai dan danau/tepi pantai/dermaga. Kami akan kirim sesuai spesifikasi dibawah ini :\r\n\r\n- 1 REEL AUDREY 5 BALL Bearings, sudah terisi Senar jadi tidak repot-repot lagi masukkan senar\r\nGear ratio 5:2.1\r\nLine capacity\r\n0.18mm/245m\r\n0.20mm/200m\r\n0.25mm/125m\r\nSpool Plastik\r\n- 1 Joran Antena Panjang 1,5 meter terdiri dari warna kuning, biru, & merah. warna akan dikirim \r\nsesuai stok\r\n- 1 Bungkus Kail isi 10 pcs\r\n- 1 Pelampung\r\n- 1 Timah anting\r\n\r\nAnak/kakak/adik anda pasti senang dengan dibelikan set alat pancing ini dan nikmati hari sabtu minggu anda dengan memancing bersama keluarga.\r\n\r\n>>>Tidak usah takut Karena Belanja disini paling aman...\r\n>>>BURUAN DIORDER SEBELUM KEHABISAN!!!', 43, 45, 'Sedang', 22, 52000, 1, 1500, '[\"1582813948-1.jpg\",\"1582813948-2.jpg\"]', 1582813949, 1, 74, 0),
('ACG/JRN/27022020213357', 29, 'Joran Pancing professional 20kg laut Ikan Besar 5 segments 2.1m - GOLD SMALL', 'HARAP KLIK DI VARIAN YA ,UNTUK PILIHAN VARIANNYA\r\nGOLD SMALL = PANJANG 2.1M / 5 SECTION\r\nGOLD MEDIUM = PANJANG 2.7M / 6 SECTION\r\nGOLD LARGE = PANJANG 3.0M / 7 SECTION\r\nGOLD XL = PANJANG 3.6M / SECTION\r\nWarna: Kuning\r\nJoran pancing ini terbuat dari carbon yang kuat, dapat menahan beban yang berat dan tidak patah, cocok untuk menangkap ikan-ikan besar di laut. Tongkat pancing dilengkapi bait casting yang kuat dan kokoh, membuat penangkapan ikan lebih mudah.KJOMTHB0GY\r\nNote: Hanya dapat Joran saja\r\n\r\nKeunggulan\r\nProfessional Fishing Rod\r\nTongkat pancing ini didesain untuk profesional, membuat Anda dapat memancing di laut dan menangkap ikan-ikan besar tanpa khawatir joran ini patah, sangat cocok untuk mancing mania.\r\n\r\nStrong \r\n yang stabil dan kuat, dapat berputar dengan cepat menyeimbangkan dengan keluarnya senar, mengurangi backlash yang terjadi, sehingga penggumpalan senar tidak terjadi.\r\n\r\nMultiple Layer Rod\r\nRod terdapat beberapa layer yang dapat Anda sesuaikan ukuran panjangnya, terdapat Rims protection.\r\n\r\nPortable Rod\r\nJoran pancing ini praktis karena dapat dilipat menjadi lebih pendek, memudahkan Anda untuk membawa tongkat pancing ini kemanapun Anda pergi.\r\n\r\nCatch 20KG Fish\r\nTongkat pancing telescopic ini mampu menahan beban hingga 20kg ikan laut, sudah saatnya Anda menangkap ikan besar dengan alat pancing ini.\r\n\r\nSpesifikasi Barang:\r\nMaterial	Carbon Fiber + Stainless Steel', 43, 45, 'Besar', 8, 97500, 1, 1125, '[\"1582814037-1.jpg\",\"1582814037-2.jpg\"]', 1582814037, 1, 75, 0),
('ACG/JRN/27022020213444', 29, 'COMBO SET PANCING KOLAM MURAH JORAN ANTENA 150 - 165', 'COMBO SET ALAT PANCING  JORAN DENGAN REEL\r\n\r\nJORAN 150 + REEL TIPE 200/250\r\n\r\nKUALITAS MULUS DAN MANTAP\r\n\r\nWARNA RANDOM \r\n\r\nSTOK TERBATAS HARGA TERMURAH', 43, 45, 'Sedang', 9, 48500, 1, 415, '[\"1582814084-1.jpg\"]', 1582814084, 1, 76, 0),
('ACG/JRN/27022020213551', 29, 'joran pancing shimano 165cm high carbon/alat pancing', 'joran pancing shimano 165cm\r\n\r\nbahan carbon solid\r\nlb 8 -16', 43, 45, 'Kecil', 6, 72000, 1, 300, '[\"1582814151-1.jpg\",\"1582814151-2.jpg\"]', 1582814151, 1, 77, 0),
('ACG/JRG/27022020213829', 29, 'Jaring kantong wadah filter batu ziolite bio ring bio ball kolam ikan', 'Jaring tempat media filter berkualitas untuk\r\n_ Aquarium\r\n_ Aquascape\r\n_ Kolam ikan\r\n\r\nJaring ini sangat multifungsi bisa diganakan untuk bermacam2 media seperti\r\n_ Bio ball\r\n_ Batu ziolite\r\n_ Kaldness\r\n_ Pumice/batu apung\r\n_ Bio crystal\r\n_ Bio block\r\n_ Bio ring\r\n_ Dll.\r\n\r\nUkuran \r\nPanjang : 50cm \r\nLebar : 30cm', 43, 44, 'Kecil', 100, 7000, 1, 75, '[\"1582814309-1.jpg\",\"1582814309-2.jpg\"]', 1582814309, 1, 78, 0),
('ACG/JRG/27022020214008', 29, 'Perangkap ikan / Bubu ikan / Jaring Ikan udang Hexagonal 16 Lubang', 'Jaring pancing yang biasa digunakan untuk menangkat ikan dan udang ini memiliki 16 buah lubang. Tidak hanya itu, jaring pancing ini juga memiliki fitur buka otomatis sehingga proses pemasangan jaring pancing ini menjadi sangat cepat dan mudah.\r\n\r\nFeatures\r\nAutomatic Folding\r\nJaring pancing ini juga memiliki fitur buka otomatis sehingga proses pemasangan jaring pancing ini menjadi sangat cepat dan mudah.\r\n\r\n16 Holes\r\nTerdapat 16 buah lubang dimana ikan-ikan dapat masuk terperangkat ke jaring pancing ini. Lubang yang banyak memberi peluang ikan masuk semakin besar.\r\n\r\nPackage Contents\r\nBarang-barang yang anda dapat dalam kotak produk:\r\n\r\n1 x Jaring Pancing Ikan Udang Automatic Folding Umbrella Fishing Net Cage\r\nVideo YouTube yang ditampilkan hanyalah ilustrasi fungsi dan penggunaan produk. Kami tidak menjamin barang kami 100% mirip dengan produk dalam video YouTube tersebut.\r\n\r\nSpesifikasi Jaring Pancing Ikan Udang Automatic Fold Umbrella Fishing Net 16 Holes\r\nDimensi 93 x 93 cm ', 43, 44, 'Sedang', 32, 37000, 1, 400, '[\"1582814408-1.jpg\",\"1582814408-2.jpg\",\"1582814408-3.jpg\"]', 1582814408, 1, 79, 0),
('ACG/JRG/27022020214119', 29, 'jaring ikan lipat portable/ Jaring Perangkap Ikan Udang Lipat Portable', 'jaring  perangkap ikan lipat dengan 7 fit \r\n\r\nSpecifications:\r\n\r\nType:Fishing Net\r\n\r\nMaterial:nylon\r\n\r\nColor:Nearly Green\r\nSize:As picture shows\r\n\r\nThe number of intervals:11\r\n\r\nPackage includes:\r\n1 x Fishing Net\r\n\r\nMeasurement Details in the attached picture.\r\n\r\nFeatures:\r\n\r\n100% Brand new.\r\n\r\nNylon material, solid and strong, you can use it for a long time.\r\n\r\nEasy to use, when pull the top rope, then quickly opened, neednt install, very convenient\r\n\r\nIdeal for catching eels, crabs, lobsters, minnows, shrimps, mackerels, crawfish, etc...\r\n\r\nNotice:\r\n\r\n1.The real color of the item may be slightly different from the pictures shown on website caused by many factors such as brightness of your monitor and light brightness.\r\n\r\n2.Please allow slight deviation for the measurement data.\r\n\r\n3.Please allow 1-3cm error.', 43, 44, 'Sedang', 82, 102000, 1, 800, '[\"1582814479-1.jpg\",\"1582814479-2.jpg\"]', 1582814479, 1, 80, 0),
('ACG/JRG/27022020214244', 29, 'jaring ikan 3 lapis siap pakai 1 inci 30meter', 'Jaring ikan siap pakai senar 020 ukuran 1 inci (2jari sempit masuk) panjang jaring 30meter tinggi 120cm', 43, 44, 'Kecil', 28, 139000, 1, 300, '[\"1582814564-1.jpg\",\"1582814564-2.png\",\"1582814564-3.jpg\"]', 1582814564, 1, 81, 0),
('ACG/JRG/27022020214333', 29, 'Serokan / Jaring Ikan Cupang dan ikan kecil lainnya', 'Serokan / Jaring Ikan Cupang dan ikan kecil lainnya diameter 5 cm', 43, 44, 'Kecil', 99, 7000, 1, 150, '[\"1582814613-1.jpg\"]', 1584866070, 1, 82, 0),
('ACG/SNR/27022020214458', 29, 'SENAR PANCING OPTIMA HI CLASS 240yds /330yds', 'READY STOCK\r\n40% FlouroCarbon, IGFA CLASS TOURNAMENT\r\n\r\nSenar premium Dengan kekuatan tinggi, sensitivitas tinggi terhadap cibitan ikan pada umpan, sehingga Kinerja tangkapannya sangat meningkat.\r\nKonsisten sepanjang senar yang berimbang dan perpanjangan elongasi rendah (tidak bersifat elastis yg semakin ditarik makin panjang sehingga diameter senar mengecil yang dapat mengakibatkan kekuatan senar berkurang),\r\nDilapisankan fluorocarbon sehingga tahan akan gesekan dan abrasi\r\nDaya simpul sangat kuat, lembut dan kualitas senar didesain dengan nomor satu\r\n\r\n40% FlouroCarbon, IGFA CLASS TOURNAMENT\r\nSENAR OPTIMA HI CLASS 240YDS 015MM / 12LB /6KG\r\nSENAR OPTIMA HI CLASS 240YDS 018MM / 14LB /7.6KG\r\nSENAR OPTIMA HI CLASS 240YDS 020MM / 16LB /8.6KG\r\nSENAR OPTIMA HI CLASS 240YDS 023MM / 20LB /10.2KG\r\nSENAR OPTIMA HI CLASS 240YDS 026MM / 24LB /12.6KG\r\nSENAR OPTIMA HI CLASS 240YDS 028MM / 29LB /15.2KG\r\nSENAR OPTIMA HI CLASS 330YDS 030MM / 32LB /16.8KG\r\nSENAR OPTIMA HI CLASS 330YDS 035MM / 36LB /18.9KG\r\nSENAR OPTIMA HI CLASS 330YDS 040MM / 41LB /21.5KG\r\nSENAR OPTIMA HI CLASS 330YDS 046MM / 49LB /25.7KG\r\nSENAR OPTIMA HI CLASS 330YDS 050MM / 53LB /27.8KG\r\nSENAR OPTIMA HI CLASS 240YDS 060MM / 62LB /32.6KG', 43, 46, 'Kecil', 90, 90000, 1, 200, '[\"1582814698-1.jpg\"]', 1584884871, 1, 83, 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_product_discount`
--

CREATE TABLE `db_product_discount` (
  `id` int(11) NOT NULL,
  `product_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `price` int(11) NOT NULL,
  `start_time` bigint(20) NOT NULL,
  `end_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_reset_pass`
--

CREATE TABLE `db_reset_pass` (
  `id` int(11) NOT NULL,
  `email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_settings`
--

CREATE TABLE `db_settings` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `conf` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `db_settings`
--

INSERT INTO `db_settings` (`id`, `name`, `conf`) VALUES
(1, 'title', 'Okoifish.com'),
(2, 'tagline', 'Beli ikan kualitas terbaik di sini'),
(3, 'description', 'Kami adlah website untuk membeli ikan, benih, ataupun pakan dengan kualitas terbaik di sini. jadi silakan beli'),
(4, 'facebook', 'https://facebook.com'),
(5, 'twitter', 'https://twitter.com'),
(6, 'instagram', 'https://instagram.com'),
(7, 'icon', '7ee58466725211050f1357fa311f4a68.png'),
(8, 'logo', '126056455552e3a00ff7ce0fb33965ed.png'),
(9, 'thumbnail', 'ee0ddb35eff396077e682d912c12e1bb.png'),
(10, 'api', 'b82dedbe22ac2aefc72216ac130a8078'),
(11, 'address', 'Komplek Pejaten Elok B3, Pejaten Barat'),
(12, 'contact', '082197758893'),
(13, 'email', 'customer@okoifish.com'),
(14, 'distributor_location', '153'),
(15, 'district', 'Pasar Minggu'),
(16, 'state', 'Jakarta Selatan'),
(17, 'province', 'DKI Jakarta'),
(18, 'zip_code', '12560'),
(19, 'status', '0'),
(20, 'slider', '[\"210d79ce7e14de242792f723c4683d26.jpg\",\"d4eb51de962a38c1e0b756e37f4dffb5.jpg\",\"599ed1a80b4332ca2ebe420bcabc13f3.jpg\",\"86cadc0ac4fb042b4029682b34a42bee.jpg\"]'),
(21, 'smtp_host', 'smtp.gmail.com'),
(22, 'smtp_port', '465'),
(23, 'smtp_user', 'pymtechnologi@gmail.com'),
(24, 'smtp_pass', 'inuyasha56');

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_users`
--

CREATE TABLE `db_users` (
  `id` int(11) NOT NULL,
  `profile_pict` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `first_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `last_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `gender` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `address` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `state` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `district` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `province` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `zip_code` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `phone_number` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `regis_date` bigint(20) NOT NULL,
  `username` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `level` int(11) NOT NULL,
  `role` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `status` int(11) NOT NULL,
  `online` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `db_users`
--

INSERT INTO `db_users` (`id`, `profile_pict`, `first_name`, `last_name`, `gender`, `address`, `state`, `district`, `province`, `zip_code`, `phone_number`, `email`, `regis_date`, `username`, `password`, `level`, `role`, `status`, `online`) VALUES
(1, '1577328279_094439.jpg', 'Albert', 'Enstein', 'Laki - laki', 'Jl. Pegangsaan Timur Nomor 56', 'Jakarta Selatan', 'Setia Budi', 'DKI Jakarta', '12970', '082110976556', 'steavenroger@gmail.com', 1575951033, 'venussa', '453bbddfa16f5b619c08044e0f371e8b', 3, '{\"blog\":[\"0\",\"1\",\"2\",\"3\"],\"custom\":[\"0\",\"1\",\"2\",\"3\"],\"product\":[\"0\",\"1\",\"2\",\"3\"],\"category\":[\"0\",\"1\",\"2\",\"3\"],\"bank\":[\"0\",\"1\",\"2\",\"3\"],\"user\":[\"0\",\"1\",\"2\",\"3\"],\"refund\":[\"6\"],\"deposit\":[\"6\"],\"order\":[\"6\"],\"income\":[\"6\"],\"funds\":[\"6\"],\"opinion\":[\"6\"]}', 1, 1588727395),
(9, '', 'Rizal', 'Faizal', 'Laki - laki', 'Jl. Merdeka Timur 56', 'Kepulauan Seribu', 'Kepulauan Seribu Utara', 'DKI Jakarta', '14540', '082298538213', 'rizal_faizal@gmail.com', 1575992786, 'rizal_faizal', '1f56fd7c55b27c8deeb99651291b8c3f', 1, '', 1, 1579666628),
(25, '1579108727_001847.jpg', 'Yudha', 'Romadhon', 'Laki - laki', 'Komplek Pejaten Elok Block B3, Pejaten Barat', 'Jakarta Selatan', 'Pasar Minggu', 'DKI Jakarta', '12560', '082298534562', 'pymtechnologi@gmail.com', 1579108210, 'yudha56', '5ff4a3f3455b9b7b2ac539075280f2c9', 0, '', 1, 1585476628),
(27, '1579110167_004247.jpeg', 'muhammad', 'reza', 'Laki - laki', 'Jl. Akses UI Kelapa Dua', 'Depok', 'Beji', 'Jawa Barat', '16424', '085713193542', 'muliawan.daffa@gmail.com', 1579110108, 'reza56', '86cf883ac3e9b2097ca0c0ecf99cf224', 0, '', 1, 1588727399),
(28, '', 'Nazip', 'Razak', 'Laki - laki', 'Jl. Raya Mampang Prapatan Rt 003 Rw 007', 'Jakarta Selatan', 'Pesanggrahan', 'DKI Jakarta', '12330', '087846752338', 'iamroot.tech@gmail.com', 1579151752, 'nazips256', '684aa2e127d3a264028e0de54ebf8f0e', 2, '{\"blog\":[\"0\",\"1\",\"2\",\"3\"],\"custom\":[\"0\",\"1\",\"2\",\"3\"],\"product\":[\"0\",\"1\",\"2\",\"3\"],\"category\":[\"0\",\"1\",\"2\",\"3\"],\"bank\":[\"0\",\"1\",\"2\",\"3\"],\"user\":[\"0\",\"1\",\"2\",\"3\"],\"refund\":[\"6\"],\"deposit\":[\"6\"],\"order\":[\"6\"],\"income\":[\"6\"],\"funds\":[\"6\"],\"opinion\":[\"6\"]}', 1, 1588668604),
(29, '1579670527_122207.png', 'Rudiantara', 'Hadiningrat', 'Laki - laki', 'Jl. Medan Merdeka Utara No.3, RT.2/RW.3, Gambir', 'Jakarta Pusat', 'Gambir', 'DKI Jakarta', '10160', '082110976556', 'yudharomadhoen@gmail.com', 1579668652, 'rudiantara', 'f0ba4264e538f564d4531d3372105ba8', 1, '', 1, 1584019171);

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_user_bank`
--

CREATE TABLE `db_user_bank` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `card_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `bank_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `rekening_number` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_wallet`
--

CREATE TABLE `db_wallet` (
  `id` int(11) NOT NULL,
  `tf_id` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `saldo` bigint(20) NOT NULL,
  `bank_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `rekening_number` bigint(20) NOT NULL,
  `card_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `picture` text CHARACTER SET utf8mb4 COLLATE utf8mb4_swedish_ci NOT NULL,
  `type` int(11) NOT NULL,
  `invoice_id` text NOT NULL,
  `status` int(11) NOT NULL,
  `date_time` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `db_white_list`
--

CREATE TABLE `db_white_list` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `db_activity`
--
ALTER TABLE `db_activity`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_alert`
--
ALTER TABLE `db_alert`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_cancel_order`
--
ALTER TABLE `db_cancel_order`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_cart`
--
ALTER TABLE `db_cart`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_category`
--
ALTER TABLE `db_category`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_chats`
--
ALTER TABLE `db_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_chat_typing`
--
ALTER TABLE `db_chat_typing`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_custom_page`
--
ALTER TABLE `db_custom_page`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_delivery_service`
--
ALTER TABLE `db_delivery_service`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_deposit_request`
--
ALTER TABLE `db_deposit_request`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_destination_address`
--
ALTER TABLE `db_destination_address`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_email`
--
ALTER TABLE `db_email`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_location`
--
ALTER TABLE `db_location`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_log_order`
--
ALTER TABLE `db_log_order`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_orders`
--
ALTER TABLE `db_orders`
  ADD PRIMARY KEY (`sorting_id`);

--
-- Indeks untuk tabel `db_order_pending`
--
ALTER TABLE `db_order_pending`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_order_type`
--
ALTER TABLE `db_order_type`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_page_view`
--
ALTER TABLE `db_page_view`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_pay_info`
--
ALTER TABLE `db_pay_info`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_product`
--
ALTER TABLE `db_product`
  ADD PRIMARY KEY (`sorting_id`);

--
-- Indeks untuk tabel `db_product_discount`
--
ALTER TABLE `db_product_discount`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_reset_pass`
--
ALTER TABLE `db_reset_pass`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_settings`
--
ALTER TABLE `db_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_users`
--
ALTER TABLE `db_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_user_bank`
--
ALTER TABLE `db_user_bank`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_wallet`
--
ALTER TABLE `db_wallet`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `db_white_list`
--
ALTER TABLE `db_white_list`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `db_activity`
--
ALTER TABLE `db_activity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_alert`
--
ALTER TABLE `db_alert`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_cancel_order`
--
ALTER TABLE `db_cancel_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_cart`
--
ALTER TABLE `db_cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_category`
--
ALTER TABLE `db_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT untuk tabel `db_chats`
--
ALTER TABLE `db_chats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_chat_typing`
--
ALTER TABLE `db_chat_typing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_custom_page`
--
ALTER TABLE `db_custom_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT untuk tabel `db_delivery_service`
--
ALTER TABLE `db_delivery_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_deposit_request`
--
ALTER TABLE `db_deposit_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `db_destination_address`
--
ALTER TABLE `db_destination_address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT untuk tabel `db_email`
--
ALTER TABLE `db_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `db_location`
--
ALTER TABLE `db_location`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=536;

--
-- AUTO_INCREMENT untuk tabel `db_log_order`
--
ALTER TABLE `db_log_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_orders`
--
ALTER TABLE `db_orders`
  MODIFY `sorting_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_order_pending`
--
ALTER TABLE `db_order_pending`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT untuk tabel `db_order_type`
--
ALTER TABLE `db_order_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `db_page_view`
--
ALTER TABLE `db_page_view`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_pay_info`
--
ALTER TABLE `db_pay_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `db_product`
--
ALTER TABLE `db_product`
  MODIFY `sorting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT untuk tabel `db_product_discount`
--
ALTER TABLE `db_product_discount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `db_reset_pass`
--
ALTER TABLE `db_reset_pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_settings`
--
ALTER TABLE `db_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `db_users`
--
ALTER TABLE `db_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT untuk tabel `db_user_bank`
--
ALTER TABLE `db_user_bank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `db_wallet`
--
ALTER TABLE `db_wallet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT untuk tabel `db_white_list`
--
ALTER TABLE `db_white_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
