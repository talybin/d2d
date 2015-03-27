-- MySQL dump 10.13  Distrib 5.5.41, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: Lab2
-- ------------------------------------------------------
-- Server version	5.5.41-0ubuntu0.14.04.1

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
-- Current Database: `Lab2`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `Lab2` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `Lab2`;

--
-- Table structure for table `Buyer`
--

DROP TABLE IF EXISTS `Buyer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Buyer` (
  `email` varchar(255) NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_Buyer_User1_idx` (`email`),
  CONSTRAINT `fk_Buyer_User1` FOREIGN KEY (`email`) REFERENCES `User` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Buyer`
--

LOCK TABLES `Buyer` WRITE;
/*!40000 ALTER TABLE `Buyer` DISABLE KEYS */;
INSERT INTO `Buyer` VALUES ('buyer@d2d.se'),('vladimir@d2d.se');
/*!40000 ALTER TABLE `Buyer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Contract`
--

DROP TABLE IF EXISTS `Contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contract` (
  `contractID` int(11) NOT NULL AUTO_INCREMENT,
  `seller` varchar(255) NOT NULL,
  `buyer` varchar(255) NOT NULL,
  `pickUpAddress` varchar(100) NOT NULL,
  `deliveryAddress` varchar(100) NOT NULL,
  `opens` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Seller opens (create) contract',
  `signs` timestamp NULL DEFAULT NULL COMMENT 'Seller signs contract',
  `pays` timestamp NULL DEFAULT NULL COMMENT 'Buyer pays the contract amount',
  `confirms` timestamp NULL DEFAULT NULL COMMENT 'Buyer confirms​ delivery and satisfaction',
  `settled` timestamp NULL DEFAULT NULL COMMENT 'Contract is settled with Seller',
  PRIMARY KEY (`contractID`),
  KEY `fk_Contract_Buyer1_idx` (`buyer`),
  KEY `fk_Contract_Seller1_idx` (`seller`),
  CONSTRAINT `fk_Contract_Buyer1` FOREIGN KEY (`buyer`) REFERENCES `Buyer` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Contract_Seller1` FOREIGN KEY (`seller`) REFERENCES `Seller` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contract`
--

LOCK TABLES `Contract` WRITE;
/*!40000 ALTER TABLE `Contract` DISABLE KEYS */;
INSERT INTO `Contract` VALUES (1,'seller@d2d.se','buyer@d2d.se','Säljvägen 10','Kallegatan 9','2015-03-27 08:21:52',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `Contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Delivery`
--

DROP TABLE IF EXISTS `Delivery`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Delivery` (
  `contractID` int(11) NOT NULL,
  `driverID` int(11) NOT NULL,
  `price` double NOT NULL COMMENT 'Delivery price of all packages',
  `takes` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Driver ​takes​ contract (row create time)',
  `picksUp` timestamp NULL DEFAULT NULL COMMENT 'Driver ​picks-­up package(s)',
  `dropsOff` timestamp NULL DEFAULT NULL COMMENT 'Driver drops-­off​ package(s) to buyer',
  UNIQUE KEY `contractID_UNIQUE` (`contractID`),
  KEY `fk_Delivery_2_idx` (`driverID`),
  CONSTRAINT `fk_Delivery_1` FOREIGN KEY (`contractID`) REFERENCES `Contract` (`contractID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Delivery_2` FOREIGN KEY (`driverID`) REFERENCES `Driver` (`driverID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Delivery`
--

LOCK TABLES `Delivery` WRITE;
/*!40000 ALTER TABLE `Delivery` DISABLE KEYS */;
/*!40000 ALTER TABLE `Delivery` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Driver`
--

DROP TABLE IF EXISTS `Driver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Driver` (
  `driverID` int(11) NOT NULL AUTO_INCREMENT,
  `bankRouting` varchar(4) DEFAULT NULL,
  `bankAccount` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`driverID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Driver`
--

LOCK TABLES `Driver` WRITE;
/*!40000 ALTER TABLE `Driver` DISABLE KEYS */;
INSERT INTO `Driver` VALUES (1,'0909','19283746'),(2,'7777','88888888');
/*!40000 ALTER TABLE `Driver` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Package`
--

DROP TABLE IF EXISTS `Package`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Package` (
  `packageID` int(11) NOT NULL AUTO_INCREMENT,
  `contractID` int(11) NOT NULL,
  `price` double NOT NULL COMMENT 'Value of contents',
  `height` double NOT NULL,
  `width` double NOT NULL,
  `length` double NOT NULL,
  `weight` double NOT NULL,
  `description` varchar(256) DEFAULT NULL COMMENT 'Description of contents',
  PRIMARY KEY (`packageID`),
  KEY `fk_Package_1_idx` (`contractID`),
  CONSTRAINT `fk_Package_1` FOREIGN KEY (`contractID`) REFERENCES `Contract` (`contractID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Package`
--

LOCK TABLES `Package` WRITE;
/*!40000 ALTER TABLE `Package` DISABLE KEYS */;
INSERT INTO `Package` VALUES (1,1,2300,100,200,300,4,'Playstation 2');
/*!40000 ALTER TABLE `Package` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Seller`
--

DROP TABLE IF EXISTS `Seller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Seller` (
  `email` varchar(255) NOT NULL,
  `bankRouting` varchar(4) NOT NULL COMMENT 'Sellers default address',
  `bankAccount` varchar(16) NOT NULL,
  PRIMARY KEY (`email`),
  KEY `fk_Seller_User1_idx` (`email`),
  CONSTRAINT `fk_Seller_User1` FOREIGN KEY (`email`) REFERENCES `User` (`email`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Seller`
--

LOCK TABLES `Seller` WRITE;
/*!40000 ALTER TABLE `Seller` DISABLE KEYS */;
INSERT INTO `Seller` VALUES ('andreas@d2d.se','1234','11111111'),('konstantin@d2d.se','3456','33333333'),('seller@d2d.se','9150','12345678'),('vladimir@d2d.se','2345','22222222');
/*!40000 ALTER TABLE `Seller` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `email` varchar(255) NOT NULL,
  `password` varchar(45) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
INSERT INTO `User` VALUES ('andreas@d2d.se','2222','Nynäsvägen 1'),('buyer@d2d.se','1234','Kallegatan 9'),('konstantin@d2d.se','4444','Stockholmsvägen 1'),('seller@d2d.se','1111','Säljvägen 10'),('vladimir@d2d.se','3333','Nynäsgata 2');
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-27  9:27:43
