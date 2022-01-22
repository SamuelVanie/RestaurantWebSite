-- MariaDB dump 10.19  Distrib 10.5.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: restaurant_kone
-- ------------------------------------------------------
-- Server version	10.5.12-MariaDB-1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Badge`
--

DROP TABLE IF EXISTS `Badge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Badge` (
  `IdBadge` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MontantBadge` decimal(14,0) NOT NULL,
  `MatriculeEt` varchar(10) NOT NULL,
  PRIMARY KEY (`IdBadge`),
  UNIQUE KEY `MatriculeEt` (`MatriculeEt`),
  CONSTRAINT `fk_MatriculeEtBadge` FOREIGN KEY (`MatriculeEt`) REFERENCES `Etudiant` (`MatriculeEt`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Badge`
--

LOCK TABLES `Badge` WRITE;
/*!40000 ALTER TABLE `Badge` DISABLE KEYS */;
INSERT INTO `Badge` VALUES (1,150000,'18INP00826'),(2,100000,'17INP00452'),(3,53200,'17INP00231'),(4,0,'20INP00322');
/*!40000 ALTER TABLE `Badge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Contenir`
--

DROP TABLE IF EXISTS `Contenir`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Contenir` (
  `IdCont` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `IdPlat` int(5) unsigned NOT NULL,
  `NumeroFact` int(10) unsigned NOT NULL,
  PRIMARY KEY (`IdCont`),
  KEY `fk_IdPlat` (`IdPlat`),
  KEY `fk_NumeroFact` (`NumeroFact`),
  CONSTRAINT `fk_IdPlat` FOREIGN KEY (`IdPlat`) REFERENCES `Plat` (`IdPlat`),
  CONSTRAINT `fk_NumeroFact` FOREIGN KEY (`NumeroFact`) REFERENCES `Facture` (`NumeroFact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Contenir`
--

LOCK TABLES `Contenir` WRITE;
/*!40000 ALTER TABLE `Contenir` DISABLE KEYS */;
/*!40000 ALTER TABLE `Contenir` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Etudiant`
--

DROP TABLE IF EXISTS `Etudiant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Etudiant` (
  `MatriculeEt` varchar(10) NOT NULL,
  `NomEt` varchar(10) NOT NULL,
  `PrenomEt` varchar(30) NOT NULL,
  `DateNaissEt` date NOT NULL,
  `LieuNaissEt` varchar(20) NOT NULL,
  `EcoleEt` varchar(50) NOT NULL,
  `FiliereEt` varchar(50) NOT NULL,
  PRIMARY KEY (`MatriculeEt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Etudiant`
--

LOCK TABLES `Etudiant` WRITE;
/*!40000 ALTER TABLE `Etudiant` DISABLE KEYS */;
INSERT INTO `Etudiant` VALUES ('17INP00231','Cuisse','Potelee','2003-06-10','Zougougbeu','ESI','STGI'),('17INP00452','Kouagni','Kouassi Leopard','1998-03-21','','',''),('18INP00826','Vanie','Bi Misanze Samuel Michael','2001-08-20','','',''),('18INP00888','Jilles','Joli','1999-08-14','Diegonefla','ESI','STGI'),('20INP00322','Kouamé','Konan Fabrice','1998-03-20','Cocody','ESI','STIC');
/*!40000 ALTER TABLE `Etudiant` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Facture`
--

DROP TABLE IF EXISTS `Facture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Facture` (
  `NumeroFact` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `MontantFact` decimal(14,0) NOT NULL,
  `DateFact` datetime NOT NULL,
  `MatriculeEt` varchar(10) NOT NULL,
  PRIMARY KEY (`NumeroFact`),
  KEY `fk_MatriculeEt` (`MatriculeEt`),
  CONSTRAINT `fk_MatriculeEt` FOREIGN KEY (`MatriculeEt`) REFERENCES `Etudiant` (`MatriculeEt`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Facture`
--

LOCK TABLES `Facture` WRITE;
/*!40000 ALTER TABLE `Facture` DISABLE KEYS */;
/*!40000 ALTER TABLE `Facture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Plat`
--

DROP TABLE IF EXISTS `Plat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Plat` (
  `IdPlat` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `NomPlat` varchar(100) NOT NULL,
  `MontantPlat` decimal(14,0) NOT NULL,
  PRIMARY KEY (`IdPlat`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Plat`
--

LOCK TABLES `Plat` WRITE;
/*!40000 ALTER TABLE `Plat` DISABLE KEYS */;
INSERT INTO `Plat` VALUES (1,'Tchep Poisson',1000),(2,'Tchep Poulet',1500),(3,'Alloco',500),(4,'Attieke',200),(5,'Risoto de poulet',1500),(6,'Attieke Soupe de poulet',1500),(7,'Deguê',500),(8,'Gateau au chocolat',2500),(9,'Chocolat Suisse',6000),(10,'Frite Poulet',1200),(11,'Poulet KFC',2500),(12,'Bissap',500),(13,'Foutou Sauce Graine avec poisson',1000),(14,'Foutou Sauce Graine avec viande de boeuf',1500),(15,'Pizza moyenne',3000),(16,'Pizza grande',5000),(17,'Foutou Sauce Arachide avec poisson',1000),(18,'Foufou Sauce Claire',1000);
/*!40000 ALTER TABLE `Plat` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-01-21  0:38:26
