-- MySQL dump 10.13  Distrib 5.7.24, for Linux (x86_64)
--
-- Host: localhost    Database: template
-- ------------------------------------------------------
-- Server version	5.7.24-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `gallery`
--

DROP TABLE IF EXISTS `gallery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gallery` (
  `id_gallery` int(11) NOT NULL AUTO_INCREMENT,
  `fk_id_user` int(11) NOT NULL,
  `description_gallery` varchar(256) DEFAULT NULL,
  `title_gallery` varchar(64) NOT NULL,
  `img_full_name_gallery` varchar(255) NOT NULL,
  `creation_date_gallery` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modification_date_gallery` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `hastags_gallery` text,
  `size_kb_gallery` varchar(45) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_gallery`),
  KEY `fk_gallery_1_idx` (`fk_id_user`),
  CONSTRAINT `fk_gallery_1` FOREIGN KEY (`fk_id_user`) REFERENCES `user` (`id_user`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gallery`
--

LOCK TABLES `gallery` WRITE;
/*!40000 ALTER TABLE `gallery` DISABLE KEYS */;
INSERT INTO `gallery` VALUES (19,3,'vds','vsd','vsd.5c41cbf5e652c5.18152115.jpg','2019-01-18 12:52:05','2019-01-18 12:52:05',NULL,'0'),(20,3,'gredf','grz','grz.5c41cce2c51b11.35710826.jpg','2019-01-18 12:56:02','2019-01-18 12:56:02',NULL,'0'),(21,3,'erdcfvtgy','xserdcftg','xserdcftg.5c433f8c2d1c35.04606627.jpg','2019-01-19 15:17:32','2019-01-19 15:17:32',NULL,'0'),(22,3,'dcfvgh',',ijnhubygtvfr',',ijnhubygtvfr.5c433f925ceef4.24929725.jpg','2019-01-19 15:17:38','2019-01-19 15:17:38',NULL,'0'),(23,3,'cfvgh','bytr','bytr.5c433f9a1cea58.68707541.jpg','2019-01-19 15:17:46','2019-01-19 15:17:46',NULL,'0'),(24,3,'ctvvy','tÃ¨r','tÃ¨r.5c433fa36e3759.11564107.jpg','2019-01-19 15:17:55','2019-01-19 15:17:55',NULL,'0'),(25,4,'rdfcvgbh','ftvygbh','ftvygbh.5c433fde7d17b4.85437928.jpg','2019-01-19 15:18:54','2019-01-19 15:18:54',NULL,'0'),(26,4,'xdfcg','ngbyfvt','ngbyfvt.5c433fe7638c70.54595353.jpg','2019-01-19 15:19:03','2019-01-19 15:19:03',NULL,'0'),(27,4,'bhn','kijuhygtf','kijuhygtf.5c433ff060b3c6.01416527.jpg','2019-01-19 15:19:12','2019-01-19 15:19:12',NULL,'0'),(28,4,'dfcd','ngybft','ngybft.5c433ff75bf143.65120359.jpg','2019-01-19 15:19:19','2019-01-19 15:19:19',NULL,'0'),(29,4,'crvtr','bgtyvt','bgtyvt.5c434009ee3369.19730508.jpg','2019-01-19 15:19:37','2019-01-19 15:19:37',NULL,'0');
/*!40000 ALTER TABLE `gallery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `package`
--

DROP TABLE IF EXISTS `package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `package` (
  `id_package` int(11) NOT NULL AUTO_INCREMENT,
  `nom_package` varchar(45) NOT NULL,
  `size_upload_limit_package` int(11) DEFAULT NULL,
  `daily_upload_package` int(11) NOT NULL DEFAULT '0',
  `nb_maximum_upload_package` int(11) NOT NULL DEFAULT '0',
  `creation_date_package` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modification_date_package` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `price_package` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_package`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `package`
--

LOCK TABLES `package` WRITE;
/*!40000 ALTER TABLE `package` DISABLE KEYS */;
INSERT INTO `package` VALUES (1,'FREE',100000,10,10,'2018-11-06 18:01:02','2019-01-18 12:57:33',0),(2,'PRO',10000000,100,100,'2018-11-19 17:41:10','2019-01-18 12:51:54',20),(4,'GOLD',1000000000,10000,1000,'2019-01-03 14:48:23','2019-01-18 12:50:22',200000);
/*!40000 ALTER TABLE `package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `id_role` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `modify_description_role` tinyint(1) NOT NULL DEFAULT '0',
  `modify_description_all_role` tinyint(1) NOT NULL DEFAULT '0',
  `view_stats_role` tinyint(1) NOT NULL DEFAULT '0',
  `view_stats_all_role` tinyint(1) NOT NULL DEFAULT '0',
  `manage_image` tinyint(1) NOT NULL DEFAULT '0',
  `manage_image_all` tinyint(1) NOT NULL DEFAULT '0',
  `modify_profil` tinyint(1) NOT NULL DEFAULT '0',
  `modify_profil_all` tinyint(1) NOT NULL DEFAULT '0',
  `modify_package` tinyint(1) NOT NULL DEFAULT '0',
  `modify_package_all` tinyint(1) NOT NULL DEFAULT '0',
  `view_action` tinyint(1) NOT NULL DEFAULT '0',
  `creation_date_role` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modification_date_role` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
INSERT INTO `role` VALUES (2,'Administrator',0,0,0,0,0,0,0,0,0,0,0,'2018-11-06 18:54:20','2018-11-06 18:54:20'),(3,'User',0,0,0,0,0,0,0,0,0,0,0,'2018-11-06 18:54:20','2018-12-29 20:42:29'),(4,'Admin',0,0,0,0,0,0,0,0,0,0,0,'2018-11-19 17:38:53','2018-11-19 17:38:53');
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `fk_package_id` int(11) NOT NULL DEFAULT '0',
  `fk_role_id` int(11) NOT NULL,
  `uid_user` varchar(45) NOT NULL,
  `email_user` varchar(45) NOT NULL,
  `creation_date_user` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `modification_date_user` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password_user` text,
  `upload_kb_consumption` int(11) NOT NULL DEFAULT '0',
  `upload_nb_consumption` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_user`),
  KEY `fk_user_1_idx` (`fk_package_id`),
  KEY `fk_user_2_idx` (`fk_role_id`),
  CONSTRAINT `fk_user_1` FOREIGN KEY (`fk_package_id`) REFERENCES `package` (`id_package`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,4,2,'Hugues','hugues.audoux@gmail.com','2018-11-04 20:41:12','2019-01-10 18:15:55','$2y$10$RAHPmmF3U9DqbbdZ/uqPdeZZiUHQ0gM1tqMPjAweBPM8FB0DyHCUW',836,2),(2,2,2,'fr','hugues.audoux@gmail.com','2018-11-19 18:20:17','2019-01-05 14:38:07','$2y$10$RAHPmmF3U9DqbbdZ/uqPdeZZiUHQ0gM1tqMPjAweBPM8FB0DyHCUW',0,0),(3,4,2,'h','h@h.com','2018-12-24 20:59:11','2019-01-19 15:17:55','$2y$10$vV5C8DFuY7IRPpHUd5ErqeKDuBBOklBwFCb0EujTrPzp9DLj2f9He',19583027,9),(4,2,3,'user','user@user.com','2018-12-31 14:33:44','2019-01-19 15:19:38','$2y$10$/P7apqtXpFtOZdE3BQKTCO7zFAo9qeKLLLXX4sBh/a6KtRW4OkKr6',17912012,8),(5,1,1,'test','test@gez.fr','2019-01-03 10:53:40','2019-01-03 10:53:40','$2y$10$8ahemxTt.nOLuiSmMIxrZ..WOUjTIUifW3IiB/u3dT93PbQTMrFjq',0,0),(6,1,1,'test2','test2@ge.fr','2019-01-03 10:55:27','2019-01-03 10:55:27','$2y$10$ldJILam4xWTlZ49Sl8ffIOwyoeBe1AvYIfCQWE5wm75W19mHxYlau',0,0),(7,2,1,'vz','gze@gm.fr','2019-01-03 10:55:58','2019-01-03 10:55:58','$2y$10$PR7EUtPUpJ1wECREkN037uwrtyPoaLuWYvhxPrOmHjqcYQd3q28B6',0,0);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-19 16:23:00
