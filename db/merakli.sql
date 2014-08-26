-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 26, 2014 at 07:34 PM
-- Server version: 5.6.20
-- PHP Version: 5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `merakli`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
`id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(1, 'PHP'),
(2, 'jQuery Nedir?'),
(3, 'SQL'),
(4, 'Diğer');

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
`id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=9 ;

--
-- Dumping data for table `files`
--

INSERT INTO `files` (`id`, `filename`) VALUES
(8, '258c5.10606532_851306961546723_5074839846515665460_n.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
`id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `content` text COLLATE utf8_turkish_ci,
  `category_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=10 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `category_id`, `created`, `updated`) VALUES
(1, 'PHP Nedir?', 'PHP (açılımı PHP: Hypertext Preprocessor) geniş bir kitle tarafından kullanılan, özellikle sanal yöreler üzerinde geliştirme için tasarlanmış HTML içine gömülebilen bir betik dilidir.', 1, '2014-08-18 00:00:00', '2014-08-18 00:00:00'),
(2, 'jQuery Nedir?', 'Jquery bir javascript kütüphanesidir. Ya da bir javascript frameworküdür diyebiliriz. Daha çok sayfalardaki animasyonlar için Flash alternatifi olarak kullanılan bu teknoloji ile, slaytlar, foto galeriler, tab menüler yapmak oldukça kolaydır.', 2, '2014-08-18 00:00:00', '2014-08-18 00:00:00'),
(3, 'OOP''ye giriş', 'OOP''yi çok severiz. OOP kullanmamak çok sıkıntı çıkarır, spaghetti insanın midesini bozar.', 1, '2014-08-23 11:46:55', '2014-08-23 13:20:23'),
(5, 'Nesne Yönelimli Programlama nasıl yapılmalı', 'İnce eleyip sık dokuyarak', 1, '2014-08-26 18:53:07', '2014-08-26 18:53:07');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
