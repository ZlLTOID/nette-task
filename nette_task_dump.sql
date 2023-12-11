-- MySQL dump 10.13  Distrib 8.0.32, for Linux (x86_64)
--
-- Host: localhost    Database: nette-task
-- ------------------------------------------------------
-- Server version	8.0.32

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `contract`
--

DROP TABLE IF EXISTS `contract`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `priceCZK` decimal(10,2) NOT NULL,
  `priceEUR` decimal(10,2) DEFAULT NULL,
  `priceUSD` decimal(10,2) DEFAULT NULL,
  `forInvoicing` tinyint(1) DEFAULT NULL,
  `invoiceId` int DEFAULT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `invoiceId` (`invoiceId`),
  CONSTRAINT `contract_ibfk_1` FOREIGN KEY (`invoiceId`) REFERENCES `invoice` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract`
--

LOCK TABLES `contract` WRITE;
/*!40000 ALTER TABLE `contract` DISABLE KEYS */;
INSERT INTO `contract` VALUES (1,'Oprava telefonu',1500.00,NULL,NULL,0,NULL,'2023-12-11 12:30:09'),(2,'Rekonstrukce hradu',15000000.00,NULL,NULL,0,NULL,'2023-12-11 12:30:09'),(3,'Stavba satelitu',90000000.00,NULL,NULL,0,NULL,'2023-12-11 12:30:09'),(4,'Ozdobení vánočního stromku',1000.00,NULL,NULL,0,NULL,'2023-12-11 12:30:09'),(5,'Umytí kočky',25000.00,NULL,NULL,0,NULL,'2023-12-11 12:30:09'),(6,'Dodání výpočetní techniky',250000.00,NULL,NULL,0,NULL,'2023-12-11 12:30:09');
/*!40000 ALTER TABLE `contract` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contract_solvers`
--

DROP TABLE IF EXISTS `contract_solvers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contract_solvers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `contractId` int NOT NULL,
  `solverId` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contractId` (`contractId`),
  KEY `solverId` (`solverId`),
  CONSTRAINT `contract_solvers_ibfk_1` FOREIGN KEY (`contractId`) REFERENCES `contract` (`id`),
  CONSTRAINT `contract_solvers_ibfk_2` FOREIGN KEY (`solverId`) REFERENCES `solver` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contract_solvers`
--

LOCK TABLES `contract_solvers` WRITE;
/*!40000 ALTER TABLE `contract_solvers` DISABLE KEYS */;
INSERT INTO `contract_solvers` VALUES (1,1,1),(2,1,2),(3,2,1),(4,3,3),(5,4,3),(6,5,1),(7,5,2),(8,5,3),(9,6,2),(10,6,3);
/*!40000 ALTER TABLE `contract_solvers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoice`
--

DROP TABLE IF EXISTS `invoice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoice` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoice`
--

LOCK TABLES `invoice` WRITE;
/*!40000 ALTER TABLE `invoice` DISABLE KEYS */;
/*!40000 ALTER TABLE `invoice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `solver`
--

DROP TABLE IF EXISTS `solver`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `solver` (
  `id` int NOT NULL AUTO_INCREMENT,
  `firstName` varchar(255) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `createdAt` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `solver`
--

LOCK TABLES `solver` WRITE;
/*!40000 ALTER TABLE `solver` DISABLE KEYS */;
INSERT INTO `solver` VALUES (1,'Václav','Varaďa','2023-12-11 12:30:12'),(2,'Lukáš','Radil','2023-12-11 12:30:12'),(3,'Lukáš','Sedlák','2023-12-11 12:30:12');
/*!40000 ALTER TABLE `solver` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-11 12:38:47
