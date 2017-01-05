-- MySQL dump 10.13  Distrib 5.6.33, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: loc.devtools
-- ------------------------------------------------------
-- Server version	5.6.33-0ubuntu0.14.04.1

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
-- Current Database: `loc.devtools`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `loc.devtools` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;

USE `arte.devtools`;

--
-- Table structure for table `backup`
--

DROP TABLE IF EXISTS `backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `backup` (
  `backup_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `backup_active` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `backup`
--

LOCK TABLES `backup` WRITE;
/*!40000 ALTER TABLE `backup` DISABLE KEYS */;
INSERT INTO `backup` VALUES ('arte',1);
/*!40000 ALTER TABLE `backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vhosts`
--

DROP TABLE IF EXISTS `vhosts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vhosts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vhost_name` varchar(64) COLLATE utf8_bin NOT NULL,
  `server_path` varchar(256) COLLATE utf8_bin NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=182 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vhosts`
--

LOCK TABLES `vhosts` WRITE;
/*!40000 ALTER TABLE `vhosts` DISABLE KEYS */;
INSERT INTO `vhosts` VALUES (158,'loc.compass','/var/www/http_linux/loc.compass/web',1),(159,'adfx.app','/var/www/http_linux/loc.adfx',1),(160,'iapi.app','/var/www/http_linux/loc.iapi',1),(161,'loc.folens','/var/www/http_linux/loc.folens',1),(162,'loc.hrm','/var/www/http_linux/loc.hrm',1),(163,'loc.hrm_lu','/var/www/http_linux/loc.hrm_lu',1),(165,'loc.barretstown','/var/www/http_linux/loc.barretstown/web',1),(167,'loc.drupal','/var/www/http_linux/loc.drupal',1),(168,'loc.glamowl','/var/www/http_linux/loc.glamowl/public',1),(169,'loc.ts','/var/www/http_linux/templestreet.ie',1),(170,'fineos.dev','/var/www/http_linux/fineos.dev',1),(171,'loc.craft','/var/www/http_linux/loc.craft/public',1),(172,'loc.rk','/var/www/http_linux/loc.rk',1),(173,'loc.mjflood','/var/www/http_linux/loc.mjflood',1),(174,'loc.ican_old','/var/www/http_linux/loc.ican_old/public',1),(175,'loc.ican_craft','/var/www/http_linux/loc.ican_craft/public',1),(176,'autism-initiatives.dev','/var/www/http_linux/autism-initiatives.dev/public',1),(177,'loc.accenturestormtest','/var/www/http_linux/loc.accenturestormtest',1),(178,'loc.unicef','/var/www/http_linux/loc.unicef',1),(179,'loc.firesafety','/var/www/http_linux/loc.firesafety',1),(180,'loc.designireland','/var/www/http_linux/loc.designireland/public',1),(181,'design.dev','/var/www/http_linux/loc.designireland/public',1);
/*!40000 ALTER TABLE `vhosts` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-11-02 13:31:42
