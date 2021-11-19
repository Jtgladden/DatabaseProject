-- MySQL dump 10.13  Distrib 8.0.26, for Win64 (x86_64)
--
-- Host: localhost    Database: colors
-- ------------------------------------------------------
-- Server version	8.0.26

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `whenCreated` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `lastUpdated` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Jarom','Gladden','jaromgladden@gmail.com','2021-10-06 15:14:59','2021-10-06 15:14:59'),(3,'john','Doe','example@test.com','2021-10-18 15:10:37','2021-10-18 15:10:37'),(4,'john','Doe','example@test.com','2021-10-18 15:22:25','2021-10-18 15:22:25'),(5,'Thomas ','Zain','Thomaszain@gmail.com','2021-10-18 15:22:55','2021-10-18 15:22:55'),(6,'Thomas ','Zain','Thomaszain@gmail.com','2021-10-18 15:24:49','2021-10-18 15:24:49'),(7,'Thomas ','Zain','Thomaszain@gmail.com','2021-10-18 15:25:36','2021-10-18 15:25:36'),(8,'Thomas ','Zain','Thomaszain@gmail.com','2021-10-18 15:26:24','2021-10-18 15:26:24'),(9,'JAROM','gLADDEN','jarom@gladden.ink','2021-10-18 15:26:50','2021-10-18 15:26:50'),(10,'JAROM','gLADDEN','jarom@gladden.ink','2021-10-18 15:26:54','2021-10-18 15:26:54'),(11,'JAROM','gLADDEN','jarom@gladden.ink','2021-10-18 15:28:36','2021-10-18 15:28:36'),(12,'JAROM','gLADDEN','jarom@gladden.ink','2021-10-18 15:32:20','2021-10-18 15:32:20'),(13,'JAROM','gLADDEN','jarom@gladden.ink','2021-10-18 15:34:23','2021-10-18 15:34:23'),(14,'JAROM','gLADDEN','jarom@gladden.ink','2021-10-18 15:35:35','2021-10-18 15:35:35'),(15,'JAROM','gLADDEN','jarom@gladden.ink','2021-10-18 15:37:34','2021-10-18 15:37:34'),(16,'Jarom','Gladden','gladden@jarom.ink','2021-10-18 15:39:13','2021-10-18 15:39:13'),(17,'thom','jefferson','presidnet@us.gov','2021-10-18 15:45:16','2021-10-18 15:45:16');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-17 11:08:24
