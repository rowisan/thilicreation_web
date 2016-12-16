-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.12-log - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for thili
DROP DATABASE IF EXISTS `thili`;
CREATE DATABASE IF NOT EXISTS `thili` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `thili`;


-- Dumping structure for table thili.album
DROP TABLE IF EXISTS `album`;
CREATE TABLE IF NOT EXISTS `album` (
  `index_no` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `type` enum('1','2','3','4') DEFAULT '1' COMMENT '1 : WEDDING; 2 : PRIVATE SESSION; 3 : OTHER; 4 : VIDEOS',
  `name` varchar(50) DEFAULT '0',
  `path` varchar(150) DEFAULT '0',
  `video_id` varchar(300) DEFAULT '0',
  `status` enum('A','I','D') DEFAULT 'A' COMMENT 'A : ACTIVE; I : INACTIVE; D : DELETE',
  PRIMARY KEY (`index_no`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table thili.album: ~9 rows (approximately)
DELETE FROM `album`;
/*!40000 ALTER TABLE `album` DISABLE KEYS */;
INSERT INTO `album` (`index_no`, `id`, `type`, `name`, `path`, `video_id`, `status`) VALUES
	(1, 1, '1', '1', 'gal/gal_files/vlb_images1/wedding/1/', '', 'A'),
	(2, 2, '1', '2', 'gal/gal_files/vlb_images1/wedding/2/', '', 'A'),
	(3, 1, '2', '1', 'gal/gal_files/vlb_images1/private_session/1/', '', 'A'),
	(4, 2, '2', '2', 'gal/gal_files/vlb_images1/private_session/2/', '', 'A'),
	(5, 3, '2', '3', 'gal/gal_files/vlb_images1/private_session/3/', '', 'A'),
	(6, 1, '3', '1', 'gal/gal_files/vlb_images1/other/1/', '', 'A'),
	(7, 2, '3', '2', 'gal/gal_files/vlb_images1/other/2/', '', 'A'),
	(8, 3, '3', '3', 'gal/gal_files/vlb_images1/other/3/', '', 'A'),
	(9, 4, '3', '4', 'gal/gal_files/vlb_images1/other/4/', '', 'A');
/*!40000 ALTER TABLE `album` ENABLE KEYS */;


-- Dumping structure for table thili.user
DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) NOT NULL DEFAULT '0',
  `password` varchar(35) NOT NULL DEFAULT '0',
  `roll` varchar(30) NOT NULL DEFAULT '0',
  `status` enum('A','I','D') NOT NULL DEFAULT 'A',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Dumping data for table thili.user: ~0 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `password`, `roll`, `status`) VALUES
	(1, 'thili', '202cb962ac59075b964b07152d234b70', '0', 'A');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
