-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: VimsentPlatform
-- ------------------------------------------------------
-- Server version	5.5.35-1ubuntu1

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
-- Table structure for table `Flexibility`
--

DROP TABLE IF EXISTS `Flexibility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Flexibility` (
  `Flexibility_id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` int(30) NOT NULL,
  `flexibility` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `mac` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Flexibility_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1465537 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Forecasting`
--

DROP TABLE IF EXISTS `Forecasting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Forecasting` (
  `Forecasting_id` int(11) NOT NULL AUTO_INCREMENT,
  `Kwh` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(30) NOT NULL,
  `mac` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Forecasting_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1465537 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ImeterMac`
--

DROP TABLE IF EXISTS `ImeterMac`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ImeterMac` (
  `m_id` int(11) NOT NULL AUTO_INCREMENT,
  `macNames` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mac` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`m_id`),
  KEY `mac` (`mac`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Imeters`
--

DROP TABLE IF EXISTS `Imeters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Imeters` (
  `I_id` int(11) NOT NULL AUTO_INCREMENT,
  `MacPath` text COLLATE utf8_unicode_ci NOT NULL,
  `Value` text COLLATE utf8_unicode_ci NOT NULL,
  `UserId` int(11) NOT NULL,
  PRIMARY KEY (`I_id`)
) ENGINE=InnoDB AUTO_INCREMENT=607 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Infra_forecasting`
--

DROP TABLE IF EXISTS `Infra_forecasting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Infra_forecasting` (
  `Infra_forecasting_id` int(11) NOT NULL AUTO_INCREMENT,
  `Kwh` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(30) NOT NULL,
  `mac` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`Infra_forecasting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MacDevices`
--

DROP TABLE IF EXISTS `MacDevices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MacDevices` (
  `d_id` int(11) NOT NULL AUTO_INCREMENT,
  `DeviceName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `macId` int(10) NOT NULL,
  `UserID_D` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`d_id`)
) ENGINE=InnoDB AUTO_INCREMENT=493 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Reliability`
--

DROP TABLE IF EXISTS `Reliability`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reliability` (
  `Reliability_id` int(11) NOT NULL AUTO_INCREMENT,
  `mac` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `reliability` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  PRIMARY KEY (`Reliability_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11675 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Users_v`
--

DROP TABLE IF EXISTS `Users_v`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users_v` (
  `id_v` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id_v`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


LOCK TABLES `Users_v` WRITE;
/*!40000 ALTER TABLE `Users_v` DISABLE KEYS */;
INSERT INTO `Users_v` VALUES (3,'bob','9a618248b64db62d15b300a07b00580b','0','Admin'),(5,'user','e10adc3949ba59abbe56e057f20f883e','2015-12-10 12:40:20p','User'),(6,'aaa','47bce5c74f589f4867dbd57e9ca9f808','2015-12-10 04:46:25p','User'),(7,'alex','4e4bbecd496e722a87d56d3d25be71c8','2016-01-13 11:38:41a','User');
/*!40000 ALTER TABLE `Users_v` ENABLE KEYS */;
UNLOCK TABLES;



--
-- Table structure for table `forecastingDaily`
--

DROP TABLE IF EXISTS `forecastingDaily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forecastingDaily` (
  `timestamp` date NOT NULL,
  `production` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `consumption` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `mac` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `intervalF` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forecastingHourly`
--

DROP TABLE IF EXISTS `forecastingHourly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forecastingHourly` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `production` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `consumption` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `mac` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `intervalF` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forecastingQuarter`
--

DROP TABLE IF EXISTS `forecastingQuarter`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forecastingQuarter` (
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `production` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `consumption` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `mac` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `intervalF` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `http_api_call`
--

DROP TABLE IF EXISTS `http_api_call`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `http_api_call` (
  `httpId` int(11) NOT NULL AUTO_INCREMENT,
  `FunctionName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `ApiCall` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `ApiDate` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`httpId`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `limitMac`
--

DROP TABLE IF EXISTS `limitMac`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `limitMac` (
  `lm_id` int(11) NOT NULL AUTO_INCREMENT,
  `limitValue` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `mac` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `topicName` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `intervalMac` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`lm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs`
--

DROP TABLE IF EXISTS `mqtt_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs` (
  `id` int(11) DEFAULT NULL,
  `topic` text,
  `payload` varchar(80) NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) NOT NULL,
  `topic_c` varchar(50) NOT NULL,
  KEY `mac` (`mac`),
  KEY `topic_c` (`topic_c`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_hedno`
--

DROP TABLE IF EXISTS `mqtt_logs_hedno`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_hedno` (
  `id` int(11) DEFAULT NULL,
  `topic` text,
  `payload` text,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) NOT NULL,
  `topic_c` varchar(50) NOT NULL,
  KEY `received` (`received`),
  KEY `mac` (`mac`),
  KEY `topic_c` (`topic_c`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_hedno2`
--

DROP TABLE IF EXISTS `mqtt_logs_hedno2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_hedno2` (
  `id` int(11) DEFAULT NULL,
  `topic` text,
  `payload` text,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) NOT NULL,
  `topic_c` varchar(50) NOT NULL,
  KEY `mac` (`mac`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_hedno2_daily`
--

DROP TABLE IF EXISTS `mqtt_logs_hedno2_daily`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_hedno2_daily` (
  `id` int(11) DEFAULT NULL,
  `topic` text,
  `payload` varchar(50) DEFAULT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) NOT NULL,
  `topic_c` varchar(50) NOT NULL,
  KEY `received` (`received`),
  KEY `mac` (`mac`),
  KEY `topic_c` (`topic_c`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_hedno2_hourly`
--

DROP TABLE IF EXISTS `mqtt_logs_hedno2_hourly`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_hedno2_hourly` (
  `id` int(11) DEFAULT NULL,
  `topic` text,
  `payload` varchar(50) DEFAULT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) NOT NULL,
  `topic_c` varchar(50) NOT NULL,
  KEY `received` (`received`),
  KEY `mac` (`mac`),
  KEY `topic_c` (`topic_c`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_insert`
--

DROP TABLE IF EXISTS `mqtt_logs_insert`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_insert` (
  `id` int(11) DEFAULT NULL,
  `topic` varchar(100) NOT NULL DEFAULT '',
  `payload` text,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) NOT NULL,
  `topic_c` varchar(50) NOT NULL,
  PRIMARY KEY (`topic`,`received`),
  KEY `mac` (`mac`),
  KEY `topic_c` (`topic_c`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_insert3`
--

DROP TABLE IF EXISTS `mqtt_logs_insert3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_insert3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_insert_test`
--

DROP TABLE IF EXISTS `mqtt_logs_insert_test`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_insert_test` (
  `id` int(11) DEFAULT NULL,
  `topic` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`topic`,`received`),
  KEY `mac` (`mac`),
  KEY `topic_c` (`topic_c`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interval_radios` (`interval_radios`),
  KEY `topic_c` (`topic_c`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=52468573 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction2`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction_300`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction_300`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction_300` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interval_radios` (`interval_radios`),
  KEY `topic_c` (`topic_c`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=17163615 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction_300_history`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction_300_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction_300_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interval_radios` (`interval_radios`),
  KEY `mac` (`mac`),
  KEY `topic_c` (`topic_c`)
) ENGINE=MyISAM AUTO_INCREMENT=15415401 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction_3600`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction_3600`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction_3600` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `mac` (`mac`),
  KEY `interval_radios` (`interval_radios`),
  KEY `topic_c` (`topic_c`)
) ENGINE=MyISAM AUTO_INCREMENT=4165475 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction_3600_history`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction_3600_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction_3600_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interval_radios` (`interval_radios`),
  KEY `mac` (`mac`),
  KEY `topic_c` (`topic_c`)
) ENGINE=MyISAM AUTO_INCREMENT=7132861 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction_60`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction_60`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction_60` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interval_radios` (`interval_radios`),
  KEY `topic_c` (`topic_c`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=21587649 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction_86400`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction_86400`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction_86400` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interval_radios` (`interval_radios`),
  KEY `topic_c` (`topic_c`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=334163 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction_86400_history`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction_86400_history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction_86400_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interval_radios` (`interval_radios`),
  KEY `mac` (`mac`),
  KEY `topic_c` (`topic_c`)
) ENGINE=MyISAM AUTO_INCREMENT=451321 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mqtt_logs_prediction_900`
--

DROP TABLE IF EXISTS `mqtt_logs_prediction_900`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mqtt_logs_prediction_900` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `topic` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `received` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `topic_c` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `interval_radios` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `interval_radios` (`interval_radios`),
  KEY `topic_c` (`topic_c`),
  KEY `mac` (`mac`)
) ENGINE=MyISAM AUTO_INCREMENT=16008409 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `olimeters`
--

DROP TABLE IF EXISTS `olimeters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `olimeters` (
  `oil_id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp_oil` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `liter_available_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `liter_quarter` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `mac` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`oil_id`),
  KEY `mac` (`mac`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `production_prediction`
--

DROP TABLE IF EXISTS `production_prediction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `production_prediction` (
  `pro_pre_id` int(11) NOT NULL AUTO_INCREMENT,
  `mac` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(15) NOT NULL,
  `kwh` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`pro_pre_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1194625 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `real_production`
--

DROP TABLE IF EXISTS `real_production`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `real_production` (
  `real_pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `mac` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` int(15) NOT NULL,
  `kwh` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`real_pro_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1175041 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reliability_flexibility`
--

DROP TABLE IF EXISTS `reliability_flexibility`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reliability_flexibility` (
  `mac` varchar(40) NOT NULL,
  `date` datetime NOT NULL,
  `flexibility` double DEFAULT NULL,
  `reliability` double DEFAULT NULL,
  PRIMARY KEY (`mac`,`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reliability_flexibility_3600`
--

DROP TABLE IF EXISTS `reliability_flexibility_3600`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reliability_flexibility_3600` (
  `mac` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `flexibility` double NOT NULL,
  `reliability` double NOT NULL,
  KEY `mac` (`mac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `reliability_flexibility_86400`
--

DROP TABLE IF EXISTS `reliability_flexibility_86400`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reliability_flexibility_86400` (
  `mac` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime NOT NULL,
  `flexibility` double NOT NULL,
  `reliability` double NOT NULL,
  KEY `mac` (`mac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `storage`
--

DROP TABLE IF EXISTS `storage`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `storage` (
  `date` datetime NOT NULL,
  `storage` int(20) NOT NULL,
  `mac` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  KEY `mac` (`mac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `topicMessageRealTime`
--

DROP TABLE IF EXISTS `topicMessageRealTime`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `topicMessageRealTime` (
  `topicID` int(11) NOT NULL,
  `payload` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `topicName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `timestampTopic` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `fullPath` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `dateInsert` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `changeUPdate` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`timestampTopic`,`fullPath`,`payload`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vgwMessages`
--

DROP TABLE IF EXISTS `vgwMessages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vgwMessages` (
  `mId` int(11) NOT NULL AUTO_INCREMENT,
  `id_message` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `main_Message` text COLLATE utf8_unicode_ci NOT NULL,
  `userName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `timestamp` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`mId`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `vimsentForecastTemp`
--

DROP TABLE IF EXISTS `vimsentForecastTemp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `vimsentForecastTemp` (
  `vimID` int(11) NOT NULL AUTO_INCREMENT,
  `mac` varchar(50) NOT NULL,
  `vimJson` text NOT NULL,
  `vimDay` varchar(5) NOT NULL,
  `forecast` varchar(30) NOT NULL,
  `dateInsertCall` varchar(40) NOT NULL,
  PRIMARY KEY (`vimID`)
) ENGINE=InnoDB AUTO_INCREMENT=5751 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-16 11:33:27
