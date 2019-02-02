-- MySQL dump 10.13  Distrib 5.7.25, for Linux (x86_64)
--
-- Host: localhost    Database: template
-- ------------------------------------------------------
-- Server version	5.7.25-0ubuntu0.18.04.2

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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-02-02 12:51:19
