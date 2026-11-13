-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: sgspip
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

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
-- Table structure for table `acteur_projet`
--

DROP TABLE IF EXISTS `acteur_projet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acteur_projet` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `acteur_id` bigint(20) unsigned NOT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acteur_projet_acteur_id_foreign` (`acteur_id`),
  KEY `acteur_projet_projet_id_foreign` (`projet_id`),
  CONSTRAINT `acteur_projet_acteur_id_foreign` FOREIGN KEY (`acteur_id`) REFERENCES `acteurs` (`id`) ON DELETE CASCADE,
  CONSTRAINT `acteur_projet_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acteur_projet`
--

LOCK TABLES `acteur_projet` WRITE;
/*!40000 ALTER TABLE `acteur_projet` DISABLE KEYS */;
/*!40000 ALTER TABLE `acteur_projet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `acteurs`
--

DROP TABLE IF EXISTS `acteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acteurs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `groupe_acteur_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acteurs_groupe_acteur_id_foreign` (`groupe_acteur_id`),
  CONSTRAINT `acteurs_groupe_acteur_id_foreign` FOREIGN KEY (`groupe_acteur_id`) REFERENCES `groupes_acteur` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acteurs`
--

LOCK TABLES `acteurs` WRITE;
/*!40000 ALTER TABLE `acteurs` DISABLE KEYS */;
/*!40000 ALTER TABLE `acteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `actions_pnd`
--

DROP TABLE IF EXISTS `actions_pnd`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actions_pnd` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actions_pnd`
--

LOCK TABLES `actions_pnd` WRITE;
/*!40000 ALTER TABLE `actions_pnd` DISABLE KEYS */;
/*!40000 ALTER TABLE `actions_pnd` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activites`
--

DROP TABLE IF EXISTS `activites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activites` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `taux_avancement` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `cout_previsionnel` decimal(18,2) DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `composante_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activites_projet_id_foreign` (`projet_id`),
  KEY `activites_composante_id_foreign` (`composante_id`),
  CONSTRAINT `activites_composante_id_foreign` FOREIGN KEY (`composante_id`) REFERENCES `composantes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `activites_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activites`
--

LOCK TABLES `activites` WRITE;
/*!40000 ALTER TABLE `activites` DISABLE KEYS */;
INSERT INTO `activites` VALUES (1,'Phase 1 : Études et mobilisation des ressources','2025-03-01','2025-11-01',40,NULL,1,NULL,'2026-09-20 11:05:44','2026-09-20 11:05:44'),(2,'Phase 2 : Exécution des travaux et acquisitions','2025-09-01','2026-05-01',0,NULL,1,NULL,'2026-09-20 11:05:44','2026-09-20 11:05:44'),(3,'Phase 1 : Études et mobilisation des ressources','2027-01-04','2027-09-04',20,NULL,2,NULL,'2026-09-20 11:05:47','2026-09-20 11:05:47'),(4,'Phase 1 : Études et mobilisation des ressources','2023-02-11','2023-10-11',100,NULL,3,NULL,'2026-09-20 11:05:49','2026-09-20 11:05:49'),(5,'Phase 2 : Exécution des travaux et acquisitions','2023-08-11','2024-04-11',80,NULL,3,NULL,'2026-09-20 11:05:49','2026-09-20 11:05:49'),(6,'Phase 1 : Études et mobilisation des ressources','2024-02-13','2024-10-13',50,NULL,4,NULL,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(7,'Phase 1 : Études et mobilisation des ressources','2025-03-17','2025-11-17',80,NULL,5,NULL,'2026-09-20 11:05:52','2026-09-20 11:05:52'),(8,'Phase 2 : Exécution des travaux et acquisitions','2025-09-17','2026-05-17',40,NULL,5,NULL,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(9,'Phase 1 : Études et mobilisation des ressources','2024-06-21','2025-02-21',75,NULL,6,NULL,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(10,'Phase 1 : Études et mobilisation des ressources','2025-03-25','2025-11-25',40,NULL,7,NULL,'2026-09-20 11:05:54','2026-09-20 11:05:54'),(11,'Phase 2 : Exécution des travaux et acquisitions','2025-09-25','2026-05-25',0,NULL,7,NULL,'2026-09-20 11:05:55','2026-09-20 11:05:55'),(12,'Phase 1 : Études et mobilisation des ressources','2027-01-22','2027-09-22',20,NULL,8,NULL,'2026-09-20 11:05:56','2026-09-20 11:05:56'),(13,'Phase 1 : Études et mobilisation des ressources','2023-03-13','2023-11-13',100,NULL,9,NULL,'2026-09-20 11:05:57','2026-09-20 11:05:57'),(14,'Phase 2 : Exécution des travaux et acquisitions','2023-09-13','2024-05-13',80,NULL,9,NULL,'2026-09-20 11:05:57','2026-09-20 11:05:57'),(15,'Phase 1 : Études et mobilisation des ressources','2025-04-06','2025-12-06',70,NULL,10,NULL,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(16,'Phase 1 : Études et mobilisation des ressources','2025-04-10','2025-12-10',80,NULL,11,NULL,'2026-09-20 11:05:59','2026-09-20 11:05:59'),(17,'Phase 2 : Exécution des travaux et acquisitions','2025-10-10','2026-06-10',40,NULL,11,NULL,'2026-09-20 11:06:01','2026-09-20 11:06:01'),(18,'Phase 1 : Études et mobilisation des ressources','2027-02-03','2027-10-03',20,NULL,12,NULL,'2026-09-20 11:06:02','2026-09-20 11:06:02'),(19,'Phase 1 : Études et mobilisation des ressources','2023-04-02','2023-12-02',100,NULL,13,NULL,'2026-09-20 11:06:04','2026-09-20 11:06:04'),(20,'Phase 2 : Exécution des travaux et acquisitions','2023-10-02','2024-06-02',80,NULL,13,NULL,'2026-09-20 11:06:05','2026-09-20 11:06:05'),(21,'Phase 1 : Études et mobilisation des ressources','2024-03-24','2024-11-24',40,NULL,14,NULL,'2026-09-20 11:06:06','2026-09-20 11:06:06'),(22,'Phase 1 : Études et mobilisation des ressources','2025-04-26','2025-12-26',60,NULL,15,NULL,'2026-09-20 11:06:08','2026-09-20 11:06:08'),(23,'Phase 2 : Exécution des travaux et acquisitions','2025-10-26','2026-06-26',20,NULL,15,NULL,'2026-09-20 11:06:09','2026-09-20 11:06:09'),(24,'Phase 1 : Études et mobilisation des ressources','2024-07-31','2025-03-31',55,NULL,16,NULL,'2026-09-20 11:06:10','2026-09-20 11:06:10'),(25,'Phase 1 : Études et mobilisation des ressources','2025-05-04','2026-01-04',80,NULL,17,NULL,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(26,'Phase 2 : Exécution des travaux et acquisitions','2025-11-04','2026-07-04',40,NULL,17,NULL,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(27,'Phase 1 : Études et mobilisation des ressources','2027-02-21','2027-10-21',20,NULL,18,NULL,'2026-09-20 11:06:13','2026-09-20 11:06:13'),(28,'Phase 1 : Études et mobilisation des ressources','2023-05-02','2024-01-02',100,NULL,19,NULL,'2026-09-20 11:06:15','2026-09-20 11:06:15'),(29,'Phase 2 : Exécution des travaux et acquisitions','2023-11-02','2024-07-02',80,NULL,19,NULL,'2026-09-20 11:06:15','2026-09-20 11:06:15'),(30,'Phase 1 : Études et mobilisation des ressources','2025-05-16','2026-01-16',50,NULL,20,NULL,'2026-09-20 11:06:17','2026-09-20 11:06:17'),(31,'Phase 1 : Études et mobilisation des ressources','2025-05-20','2026-01-20',60,NULL,21,NULL,'2026-09-20 11:06:18','2026-09-20 11:06:18'),(32,'Phase 2 : Exécution des travaux et acquisitions','2025-11-20','2026-07-20',20,NULL,21,NULL,'2026-09-20 11:06:19','2026-09-20 11:06:19'),(33,'Phase 1 : Études et mobilisation des ressources','2027-03-05','2027-11-05',20,NULL,22,NULL,'2026-09-20 11:06:21','2026-09-20 11:06:21'),(34,'Phase 1 : Études et mobilisation des ressources','2023-05-22','2024-01-22',100,NULL,23,NULL,'2026-09-20 11:06:22','2026-09-20 11:06:22'),(35,'Phase 2 : Exécution des travaux et acquisitions','2023-11-22','2024-07-22',80,NULL,23,NULL,'2026-09-20 11:06:22','2026-09-20 11:06:22'),(36,'Phase 1 : Études et mobilisation des ressources','2024-05-03','2025-01-03',50,NULL,24,NULL,'2026-09-20 11:06:24','2026-09-20 11:06:24'),(37,'Phase 1 : Études et mobilisation des ressources','2025-06-05','2026-02-05',40,NULL,25,NULL,'2026-09-20 11:06:26','2026-09-20 11:06:26'),(38,'Phase 2 : Exécution des travaux et acquisitions','2025-12-05','2026-08-05',0,NULL,25,NULL,'2026-09-20 11:06:26','2026-09-20 11:06:26'),(39,'Phase 1 : Études et mobilisation des ressources','2024-09-09','2025-05-09',65,NULL,26,NULL,'2026-09-20 11:06:28','2026-09-20 11:06:28'),(40,'Phase 1 : Études et mobilisation des ressources','2025-06-13','2026-02-13',60,NULL,27,NULL,'2026-09-20 11:06:29','2026-09-20 11:06:29'),(41,'Phase 2 : Exécution des travaux et acquisitions','2025-12-13','2026-08-13',20,NULL,27,NULL,'2026-09-20 11:06:29','2026-09-20 11:06:29'),(42,'Phase 1 : Études et mobilisation des ressources','2027-03-23','2027-11-23',20,NULL,28,NULL,'2026-09-20 11:06:30','2026-09-20 11:06:30'),(43,'Phase 1 : Études et mobilisation des ressources','2023-06-21','2024-02-21',100,NULL,29,NULL,'2026-09-20 11:06:33','2026-09-20 11:06:33'),(44,'Phase 2 : Exécution des travaux et acquisitions','2023-12-21','2024-08-21',80,NULL,29,NULL,'2026-09-20 11:06:33','2026-09-20 11:06:33'),(45,'Phase 1 : Études et mobilisation des ressources','2025-06-25','2026-02-25',90,NULL,30,NULL,'2026-09-20 11:06:34','2026-09-20 11:06:34'),(46,'Phase 1 : Études et mobilisation des ressources','2025-06-29','2026-03-01',40,NULL,31,NULL,'2026-09-20 11:06:35','2026-09-20 11:06:35'),(47,'Phase 2 : Exécution des travaux et acquisitions','2025-12-29','2026-08-29',0,NULL,31,NULL,'2026-09-20 11:06:37','2026-09-20 11:06:37'),(48,'Phase 1 : Études et mobilisation des ressources','2027-04-04','2027-12-04',20,NULL,32,NULL,'2026-09-20 11:06:38','2026-09-20 11:06:38'),(49,'Phase 1 : Études et mobilisation des ressources','2023-07-11','2024-03-11',100,NULL,33,NULL,'2026-09-20 11:06:43','2026-09-20 11:06:43'),(50,'Phase 2 : Exécution des travaux et acquisitions','2024-01-11','2024-09-11',80,NULL,33,NULL,'2026-09-20 11:06:45','2026-09-20 11:06:45'),(51,'Phase 1 : Études et mobilisation des ressources','2024-06-12','2025-02-12',40,NULL,34,NULL,'2026-09-20 11:06:47','2026-09-20 11:06:47'),(52,'Phase 1 : Études et mobilisation des ressources','2025-07-15','2026-03-15',80,NULL,35,NULL,'2026-09-20 11:06:49','2026-09-20 11:06:49'),(53,'Phase 2 : Exécution des travaux et acquisitions','2026-01-15','2026-09-15',40,NULL,35,NULL,'2026-09-20 11:06:51','2026-09-20 11:06:51'),(54,'Phase 1 : Études et mobilisation des ressources','2024-10-19','2025-06-19',75,NULL,36,NULL,'2026-09-20 11:06:52','2026-09-20 11:06:52'),(55,'Phase 1 : Études et mobilisation des ressources','2025-07-23','2026-03-23',40,NULL,37,NULL,'2026-09-20 11:06:54','2026-09-20 11:06:54'),(56,'Phase 2 : Exécution des travaux et acquisitions','2026-01-23','2026-09-23',0,NULL,37,NULL,'2026-09-20 11:06:55','2026-09-20 11:06:55'),(57,'Phase 1 : Études et mobilisation des ressources','2027-04-22','2027-12-22',20,NULL,38,NULL,'2026-09-20 11:06:55','2026-09-20 11:06:55'),(58,'Phase 1 : Études et mobilisation des ressources','2023-08-10','2024-04-10',100,NULL,39,NULL,'2026-09-20 11:06:58','2026-09-20 11:06:58'),(59,'Phase 2 : Exécution des travaux et acquisitions','2024-02-10','2024-10-10',80,NULL,39,NULL,'2026-09-20 11:06:58','2026-09-20 11:06:58'),(60,'Phase 1 : Études et mobilisation des ressources','2025-08-04','2026-04-04',70,NULL,40,NULL,'2026-09-20 11:07:01','2026-09-20 11:07:01'),(61,'Phase 1 : Études et mobilisation des ressources','2025-08-08','2026-04-08',80,NULL,41,NULL,'2026-09-20 11:07:02','2026-09-20 11:07:02'),(62,'Phase 2 : Exécution des travaux et acquisitions','2026-02-08','2026-10-08',40,NULL,41,NULL,'2026-09-20 11:07:03','2026-09-20 11:07:03'),(63,'Phase 1 : Études et mobilisation des ressources','2027-05-04','2028-01-04',20,NULL,42,NULL,'2026-09-20 11:07:04','2026-09-20 11:07:04'),(64,'Phase 1 : Études et mobilisation des ressources','2023-08-30','2024-04-30',100,NULL,43,NULL,'2026-09-20 11:07:06','2026-09-20 11:07:06'),(65,'Phase 2 : Exécution des travaux et acquisitions','2024-03-01','2024-10-30',80,NULL,43,NULL,'2026-09-20 11:07:09','2026-09-20 11:07:09'),(66,'Phase 1 : Études et mobilisation des ressources','2024-07-22','2025-03-22',50,NULL,44,NULL,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(67,'Phase 1 : Études et mobilisation des ressources','2025-08-24','2026-04-24',60,NULL,45,NULL,'2026-09-20 11:07:11','2026-09-20 11:07:11'),(68,'Phase 2 : Exécution des travaux et acquisitions','2026-02-24','2026-10-24',20,NULL,45,NULL,'2026-09-20 11:07:13','2026-09-20 11:07:13'),(69,'Phase 1 : Études et mobilisation des ressources','2024-11-28','2025-07-28',55,NULL,46,NULL,'2026-09-20 11:07:14','2026-09-20 11:07:14'),(70,'Phase 1 : Études et mobilisation des ressources','2025-09-01','2026-05-01',80,NULL,47,NULL,'2026-09-20 11:07:17','2026-09-20 11:07:17'),(71,'Phase 2 : Exécution des travaux et acquisitions','2026-03-01','2026-11-01',40,NULL,47,NULL,'2026-09-20 11:07:17','2026-09-20 11:07:17'),(72,'Phase 1 : Études et mobilisation des ressources','2027-05-22','2028-01-22',20,NULL,48,NULL,'2026-09-20 11:07:18','2026-09-20 11:07:18'),(73,'Phase 1 : Études et mobilisation des ressources','2023-09-29','2024-05-29',100,NULL,49,NULL,'2026-09-20 11:07:20','2026-09-20 11:07:20'),(74,'Phase 2 : Exécution des travaux et acquisitions','2024-03-29','2024-11-29',80,NULL,49,NULL,'2026-09-20 11:07:22','2026-09-20 11:07:22'),(75,'Phase 1 : Études et mobilisation des ressources','2025-09-13','2026-05-13',50,NULL,50,NULL,'2026-09-20 11:07:24','2026-09-20 11:07:24'),(76,'Phase 1 : Études et mobilisation des ressources','2025-09-17','2026-05-17',60,NULL,51,NULL,'2026-09-20 11:07:26','2026-09-20 11:07:26'),(77,'Phase 2 : Exécution des travaux et acquisitions','2026-03-17','2026-11-17',20,NULL,51,NULL,'2026-09-20 11:07:27','2026-09-20 11:07:27'),(78,'Phase 1 : Études et mobilisation des ressources','2027-06-03','2028-02-03',20,NULL,52,NULL,'2026-09-20 11:07:28','2026-09-20 11:07:28'),(79,'Phase 1 : Études et mobilisation des ressources','2023-10-19','2024-06-19',100,NULL,53,NULL,'2026-09-20 11:07:29','2026-09-20 11:07:29'),(80,'Phase 2 : Exécution des travaux et acquisitions','2024-04-19','2024-12-19',80,NULL,53,NULL,'2026-09-20 11:07:30','2026-09-20 11:07:30'),(81,'Phase 1 : Études et mobilisation des ressources','2024-08-31','2025-05-01',40,NULL,54,NULL,'2026-09-20 11:07:32','2026-09-20 11:07:32'),(82,'Phase 1 : Études et mobilisation des ressources','2025-10-03','2026-06-03',40,NULL,55,NULL,'2026-09-20 11:07:33','2026-09-20 11:07:33'),(83,'Phase 2 : Exécution des travaux et acquisitions','2026-04-03','2026-12-03',0,NULL,55,NULL,'2026-09-20 11:07:34','2026-09-20 11:07:34'),(84,'Phase 1 : Études et mobilisation des ressources','2025-01-07','2025-09-07',65,NULL,56,NULL,'2026-09-20 11:07:35','2026-09-20 11:07:35'),(85,'Phase 1 : Études et mobilisation des ressources','2025-10-11','2026-06-11',60,NULL,57,NULL,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(86,'Phase 2 : Exécution des travaux et acquisitions','2026-04-11','2026-12-11',20,NULL,57,NULL,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(87,'Phase 1 : Études et mobilisation des ressources','2027-06-21','2028-02-21',20,NULL,58,NULL,'2026-09-20 11:07:37','2026-09-20 11:07:37'),(88,'Phase 1 : Études et mobilisation des ressources','2023-11-18','2024-07-18',100,NULL,59,NULL,'2026-09-20 11:07:39','2026-09-20 11:07:39'),(89,'Phase 2 : Exécution des travaux et acquisitions','2024-05-18','2025-01-18',80,NULL,59,NULL,'2026-09-20 11:07:39','2026-09-20 11:07:39'),(90,'Phase 1 : Études et mobilisation des ressources','2025-10-23','2026-06-23',90,NULL,60,NULL,'2026-09-20 11:07:41','2026-09-20 11:07:41'),(91,'Phase 1 : Études et mobilisation des ressources','2025-10-27','2026-06-27',40,NULL,61,NULL,'2026-09-20 11:07:45','2026-09-20 11:07:45'),(92,'Phase 2 : Exécution des travaux et acquisitions','2026-04-27','2026-12-27',0,NULL,61,NULL,'2026-09-20 11:07:45','2026-09-20 11:07:45'),(93,'Phase 1 : Études et mobilisation des ressources','2027-07-03','2028-03-03',20,NULL,62,NULL,'2026-09-20 11:07:47','2026-09-20 11:07:47'),(94,'Phase 1 : Études et mobilisation des ressources','2023-12-08','2024-08-08',100,NULL,63,NULL,'2026-09-20 11:07:48','2026-09-20 11:07:48'),(95,'Phase 2 : Exécution des travaux et acquisitions','2024-06-08','2025-02-08',80,NULL,63,NULL,'2026-09-20 11:07:50','2026-09-20 11:07:50'),(96,'Phase 1 : Études et mobilisation des ressources','2024-10-10','2025-06-10',50,NULL,64,NULL,'2026-09-20 11:07:53','2026-09-20 11:07:53'),(97,'Phase 1 : Études et mobilisation des ressources','2025-11-12','2026-07-12',80,NULL,65,NULL,'2026-09-20 11:07:56','2026-09-20 11:07:56'),(98,'Phase 2 : Exécution des travaux et acquisitions','2026-05-12','2027-01-12',40,NULL,65,NULL,'2026-09-20 11:07:57','2026-09-20 11:07:57'),(99,'Phase 1 : Études et mobilisation des ressources','2025-02-16','2025-10-16',75,NULL,66,NULL,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(100,'Phase 1 : Études et mobilisation des ressources','2025-11-20','2026-07-20',40,NULL,67,NULL,'2026-09-20 11:08:02','2026-09-20 11:08:02'),(101,'Phase 2 : Exécution des travaux et acquisitions','2026-05-20','2027-01-20',0,NULL,67,NULL,'2026-09-20 11:08:02','2026-09-20 11:08:02'),(102,'Phase 1 : Études et mobilisation des ressources','2027-07-21','2028-03-21',20,NULL,68,NULL,'2026-09-20 11:08:05','2026-09-20 11:08:05'),(103,'Phase 1 : Études et mobilisation des ressources','2024-01-07','2024-09-07',100,NULL,69,NULL,'2026-09-20 11:08:07','2026-09-20 11:08:07'),(104,'Phase 2 : Exécution des travaux et acquisitions','2024-07-07','2025-03-07',80,NULL,69,NULL,'2026-09-20 11:08:07','2026-09-20 11:08:07'),(105,'Phase 1 : Études et mobilisation des ressources','2025-12-02','2026-08-02',70,NULL,70,NULL,'2026-09-20 11:08:10','2026-09-20 11:08:10'),(106,'Phase 1 : Études et mobilisation des ressources','2025-12-06','2026-08-06',80,NULL,71,NULL,'2026-09-20 11:08:15','2026-09-20 11:08:15'),(107,'Phase 2 : Exécution des travaux et acquisitions','2026-06-06','2027-02-06',40,NULL,71,NULL,'2026-09-20 11:08:19','2026-09-20 11:08:19'),(108,'Phase 1 : Études et mobilisation des ressources','2027-08-02','2028-04-02',20,NULL,72,NULL,'2026-09-20 11:08:21','2026-09-20 11:08:21'),(109,'Phase 1 : Études et mobilisation des ressources','2024-01-27','2024-09-27',100,NULL,73,NULL,'2026-09-20 11:08:23','2026-09-20 11:08:23'),(110,'Phase 2 : Exécution des travaux et acquisitions','2024-07-27','2025-03-27',80,NULL,73,NULL,'2026-09-20 11:08:25','2026-09-20 11:08:25'),(111,'Phase 1 : Études et mobilisation des ressources','2024-11-19','2025-07-19',40,NULL,74,NULL,'2026-09-20 11:08:34','2026-09-20 11:08:34'),(112,'Phase 1 : Études et mobilisation des ressources','2025-12-22','2026-08-22',60,NULL,75,NULL,'2026-09-20 11:08:39','2026-09-20 11:08:39'),(113,'Phase 2 : Exécution des travaux et acquisitions','2026-06-22','2027-02-22',20,NULL,75,NULL,'2026-09-20 11:08:40','2026-09-20 11:08:40');
/*!40000 ALTER TABLE `activites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `analyses_causales`
--

DROP TABLE IF EXISTS `analyses_causales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `analyses_causales` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `type_analyse_causale_id` bigint(20) unsigned DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `analyses_causales_type_analyse_causale_id_foreign` (`type_analyse_causale_id`),
  KEY `analyses_causales_projet_id_foreign` (`projet_id`),
  CONSTRAINT `analyses_causales_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `analyses_causales_type_analyse_causale_id_foreign` FOREIGN KEY (`type_analyse_causale_id`) REFERENCES `types_analyse_causale` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `analyses_causales`
--

LOCK TABLES `analyses_causales` WRITE;
/*!40000 ALTER TABLE `analyses_causales` DISABLE KEYS */;
/*!40000 ALTER TABLE `analyses_causales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `axes`
--

DROP TABLE IF EXISTS `axes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `axes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `programme_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `axes_programme_id_foreign` (`programme_id`),
  CONSTRAINT `axes_programme_id_foreign` FOREIGN KEY (`programme_id`) REFERENCES `programmes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `axes`
--

LOCK TABLES `axes` WRITE;
/*!40000 ALTER TABLE `axes` DISABLE KEYS */;
/*!40000 ALTER TABLE `axes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bailleurs`
--

DROP TABLE IF EXISTS `bailleurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bailleurs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `sigle` varchar(255) DEFAULT NULL,
  `contact` varchar(255) DEFAULT NULL,
  `type_bailleur_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bailleurs_type_bailleur_id_foreign` (`type_bailleur_id`),
  CONSTRAINT `bailleurs_type_bailleur_id_foreign` FOREIGN KEY (`type_bailleur_id`) REFERENCES `types_bailleur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bailleurs`
--

LOCK TABLES `bailleurs` WRITE;
/*!40000 ALTER TABLE `bailleurs` DISABLE KEYS */;
INSERT INTO `bailleurs` VALUES (1,'Banque Mondiale','BM',NULL,1,'2026-09-20 11:05:40','2026-09-20 11:05:40'),(2,'Banque Africaine de Développement','BAD',NULL,3,'2026-09-20 11:05:41','2026-09-20 11:05:41'),(3,'Agence Française de Développement','AFD',NULL,3,'2026-09-20 11:05:41','2026-09-20 11:05:41'),(4,'Union Européenne','UE',NULL,1,'2026-09-20 11:05:41','2026-09-20 11:05:41');
/*!40000 ALTER TABLE `bailleurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `budgets`
--

DROP TABLE IF EXISTS `budgets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `budgets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `exercice` smallint(5) unsigned NOT NULL,
  `credit_budgetaire_notifie` decimal(18,2) DEFAULT NULL,
  `montant_pec_avant_exercice` decimal(18,2) DEFAULT NULL,
  `montant_previsionnel_n` decimal(18,2) DEFAULT NULL,
  `montant_previsionnel_n1` decimal(18,2) DEFAULT NULL,
  `montant_previsionnel_n2` decimal(18,2) DEFAULT NULL,
  `taux_execution_financier` decimal(5,2) DEFAULT NULL,
  `taux_execution_physique` decimal(5,2) DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `budgets_projet_id_foreign` (`projet_id`),
  CONSTRAINT `budgets_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `budgets`
--

LOCK TABLES `budgets` WRITE;
/*!40000 ALTER TABLE `budgets` DISABLE KEYS */;
/*!40000 ALTER TABLE `budgets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `charges_recurrentes`
--

DROP TABLE IF EXISTS `charges_recurrentes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `charges_recurrentes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `rubrique` varchar(255) NOT NULL,
  `categorie` varchar(255) DEFAULT NULL,
  `montant` decimal(18,2) NOT NULL DEFAULT 0.00,
  `annee` smallint(5) unsigned NOT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `charges_recurrentes_projet_id_foreign` (`projet_id`),
  CONSTRAINT `charges_recurrentes_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `charges_recurrentes`
--

LOCK TABLES `charges_recurrentes` WRITE;
/*!40000 ALTER TABLE `charges_recurrentes` DISABLE KEYS */;
/*!40000 ALTER TABLE `charges_recurrentes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cibles`
--

DROP TABLE IF EXISTS `cibles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cibles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_beneficiaire` varchar(255) DEFAULT NULL,
  `acteur` varchar(255) DEFAULT NULL,
  `probleme_specifique` text DEFAULT NULL,
  `attentes` text DEFAULT NULL,
  `craintes` text DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cibles_projet_id_foreign` (`projet_id`),
  CONSTRAINT `cibles_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cibles`
--

LOCK TABLES `cibles` WRITE;
/*!40000 ALTER TABLE `cibles` DISABLE KEYS */;
/*!40000 ALTER TABLE `cibles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comites_projet`
--

DROP TABLE IF EXISTS `comites_projet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comites_projet` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('supervision','pilotage','technique','suivi_evaluation','audit_controle') NOT NULL,
  `role` varchar(255) DEFAULT NULL,
  `composition` text DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comites_projet_projet_id_foreign` (`projet_id`),
  CONSTRAINT `comites_projet_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comites_projet`
--

LOCK TABLES `comites_projet` WRITE;
/*!40000 ALTER TABLE `comites_projet` DISABLE KEYS */;
/*!40000 ALTER TABLE `comites_projet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `communes`
--

DROP TABLE IF EXISTS `communes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `communes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `departement_id` bigint(20) unsigned NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `communes_departement_id_foreign` (`departement_id`),
  CONSTRAINT `communes_departement_id_foreign` FOREIGN KEY (`departement_id`) REFERENCES `departements` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `communes`
--

LOCK TABLES `communes` WRITE;
/*!40000 ALTER TABLE `communes` DISABLE KEYS */;
INSERT INTO `communes` VALUES (1,1,'Abobo',NULL,'2026-09-20 11:05:34','2026-09-20 11:05:34'),(2,1,'Adjamé',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(3,1,'Attécoubé',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(4,1,'Bingerville',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(5,1,'Cocody',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(6,1,'Koumassi',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(7,1,'Marcory',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(8,1,'Le Plateau',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(9,1,'Port-Bouët',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(10,1,'Songon',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(11,1,'Treichville',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35'),(12,1,'Yopougon',NULL,'2026-09-20 11:05:35','2026-09-20 11:05:35');
/*!40000 ALTER TABLE `communes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `composantes`
--

DROP TABLE IF EXISTS `composantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `composantes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `budget_previsionnel` decimal(18,2) NOT NULL DEFAULT 0.00,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `composantes_projet_id_foreign` (`projet_id`),
  CONSTRAINT `composantes_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `composantes`
--

LOCK TABLES `composantes` WRITE;
/*!40000 ALTER TABLE `composantes` DISABLE KEYS */;
/*!40000 ALTER TABLE `composantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conventions_financement`
--

DROP TABLE IF EXISTS `conventions_financement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conventions_financement` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_accord` varchar(255) DEFAULT NULL,
  `nature_financement` varchar(255) DEFAULT NULL,
  `date_limite_tirage` date DEFAULT NULL,
  `niveau_avancement_negociations` varchar(255) DEFAULT NULL,
  `numero_accord_signe` varchar(255) DEFAULT NULL,
  `montant` decimal(18,2) DEFAULT NULL,
  `date_signature` date DEFAULT NULL,
  `financement_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conventions_financement_financement_id_unique` (`financement_id`),
  CONSTRAINT `conventions_financement_financement_id_foreign` FOREIGN KEY (`financement_id`) REFERENCES `financements` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conventions_financement`
--

LOCK TABLES `conventions_financement` WRITE;
/*!40000 ALTER TABLE `conventions_financement` DISABLE KEYS */;
/*!40000 ALTER TABLE `conventions_financement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criteres_evaluation`
--

DROP TABLE IF EXISTS `criteres_evaluation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criteres_evaluation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `critere` varchar(255) NOT NULL,
  `sous_critere` varchar(255) DEFAULT NULL,
  `appreciation` enum('total','partiel','faible','oui','non') DEFAULT NULL,
  `justification` text DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `criteres_evaluation_projet_id_foreign` (`projet_id`),
  CONSTRAINT `criteres_evaluation_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criteres_evaluation`
--

LOCK TABLES `criteres_evaluation` WRITE;
/*!40000 ALTER TABLE `criteres_evaluation` DISABLE KEYS */;
/*!40000 ALTER TABLE `criteres_evaluation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `decaissements`
--

DROP TABLE IF EXISTS `decaissements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `decaissements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `montant` decimal(18,2) NOT NULL,
  `date` date NOT NULL,
  `reference` varchar(255) NOT NULL,
  `bailleur_id` bigint(20) unsigned NOT NULL,
  `financement_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `decaissements_reference_unique` (`reference`),
  KEY `decaissements_bailleur_id_foreign` (`bailleur_id`),
  KEY `decaissements_financement_id_foreign` (`financement_id`),
  CONSTRAINT `decaissements_bailleur_id_foreign` FOREIGN KEY (`bailleur_id`) REFERENCES `bailleurs` (`id`),
  CONSTRAINT `decaissements_financement_id_foreign` FOREIGN KEY (`financement_id`) REFERENCES `financements` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `decaissements`
--

LOCK TABLES `decaissements` WRITE;
/*!40000 ALTER TABLE `decaissements` DISABLE KEYS */;
INSERT INTO `decaissements` VALUES (1,42750000.00,'2025-05-01','DEC-2026-001',1,1,'2026-09-20 11:05:43','2026-09-20 11:05:43'),(2,2949750000.00,'2023-04-11','DEC-2026-003',3,3,'2026-09-20 11:05:49','2026-09-20 11:05:49'),(3,1295325000.00,'2024-04-13','DEC-2026-004',4,4,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(4,3411450000.00,'2025-05-17','DEC-2026-005',1,5,'2026-09-20 11:05:52','2026-09-20 11:05:52'),(5,775912500.00,'2024-08-21','DEC-2026-006',2,6,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(6,555750000.00,'2025-05-25','DEC-2026-007',3,7,'2026-09-20 11:05:54','2026-09-20 11:05:54'),(7,5514750000.00,'2023-05-13','DEC-2026-009',1,9,'2026-09-20 11:05:57','2026-09-20 11:05:57'),(8,619875000.00,'2025-06-06','DEC-2026-010',2,10,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(9,1564650000.00,'2025-06-10','DEC-2026-011',3,11,'2026-09-20 11:05:59','2026-09-20 11:05:59'),(10,5343750000.00,'2023-06-02','DEC-2026-013',1,13,'2026-09-20 11:06:03','2026-09-20 11:06:03'),(11,213750000.00,'2024-05-24','DEC-2026-014',2,14,'2026-09-20 11:06:06','2026-09-20 11:06:06'),(12,974700000.00,'2025-06-26','DEC-2026-015',3,15,'2026-09-20 11:06:08','2026-09-20 11:06:08'),(13,1331662500.00,'2024-10-01','DEC-2026-016',4,16,'2026-09-20 11:06:10','2026-09-20 11:06:10'),(14,3103650000.00,'2025-07-04','DEC-2026-017',1,17,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(15,2265750000.00,'2023-07-02','DEC-2026-019',3,19,'2026-09-20 11:06:14','2026-09-20 11:06:14'),(16,1090125000.00,'2025-07-16','DEC-2026-020',4,20,'2026-09-20 11:06:17','2026-09-20 11:06:17'),(17,2000700000.00,'2025-07-20','DEC-2026-021',1,21,'2026-09-20 11:06:18','2026-09-20 11:06:18'),(18,2094750000.00,'2023-07-22','DEC-2026-023',3,23,'2026-09-20 11:06:22','2026-09-20 11:06:22'),(19,1038825000.00,'2024-07-03','DEC-2026-024',4,24,'2026-09-20 11:06:23','2026-09-20 11:06:23'),(20,966150000.00,'2025-08-05','DEC-2026-025',1,25,'2026-09-20 11:06:25','2026-09-20 11:06:25'),(21,250087500.00,'2024-11-09','DEC-2026-026',2,26,'2026-09-20 11:06:27','2026-09-20 11:06:27'),(22,769500000.00,'2025-08-13','DEC-2026-027',3,27,'2026-09-20 11:06:29','2026-09-20 11:06:29'),(23,4659750000.00,'2023-08-21','DEC-2026-029',1,29,'2026-09-20 11:06:31','2026-09-20 11:06:31'),(24,269325000.00,'2025-08-25','DEC-2026-030',2,30,'2026-09-20 11:06:34','2026-09-20 11:06:34'),(25,350550000.00,'2025-08-29','DEC-2026-031',3,31,'2026-09-20 11:06:35','2026-09-20 11:06:35'),(26,4488750000.00,'2023-09-11','DEC-2026-033',1,33,'2026-09-20 11:06:42','2026-09-20 11:06:42'),(27,42750000.00,'2024-08-12','DEC-2026-034',2,34,'2026-09-20 11:06:47','2026-09-20 11:06:47'),(28,949050000.00,'2025-09-15','DEC-2026-035',3,35,'2026-09-20 11:06:48','2026-09-20 11:06:48'),(29,1622362500.00,'2024-12-19','DEC-2026-036',4,36,'2026-09-20 11:06:52','2026-09-20 11:06:52'),(30,863550000.00,'2025-09-23','DEC-2026-037',1,37,'2026-09-20 11:06:54','2026-09-20 11:06:54'),(31,1410750000.00,'2023-10-10','DEC-2026-039',3,39,'2026-09-20 11:06:58','2026-09-20 11:06:58'),(32,1389375000.00,'2025-10-04','DEC-2026-040',4,40,'2026-09-20 11:07:00','2026-09-20 11:07:00'),(33,2488050000.00,'2025-10-08','DEC-2026-041',1,41,'2026-09-20 11:07:02','2026-09-20 11:07:02'),(34,1239750000.00,'2023-10-30','DEC-2026-043',3,43,'2026-09-20 11:07:06','2026-09-20 11:07:06'),(35,782325000.00,'2024-09-22','DEC-2026-044',4,44,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(36,1590300000.00,'2025-10-24','DEC-2026-045',1,45,'2026-09-20 11:07:11','2026-09-20 11:07:11'),(37,1870312500.00,'2025-01-28','DEC-2026-046',2,46,'2026-09-20 11:07:14','2026-09-20 11:07:14'),(38,641250000.00,'2025-11-01','DEC-2026-047',3,47,'2026-09-20 11:07:16','2026-09-20 11:07:16'),(39,3804750000.00,'2023-11-29','DEC-2026-049',1,49,'2026-09-20 11:07:20','2026-09-20 11:07:20'),(40,1551825000.00,'2025-11-13','DEC-2026-050',2,50,'2026-09-20 11:07:24','2026-09-20 11:07:24'),(41,359100000.00,'2025-11-17','DEC-2026-051',3,51,'2026-09-20 11:07:26','2026-09-20 11:07:26'),(42,3633750000.00,'2023-12-19','DEC-2026-053',1,53,'2026-09-20 11:07:29','2026-09-20 11:07:29'),(43,1000350000.00,'2024-10-31','DEC-2026-054',2,54,'2026-09-20 11:07:31','2026-09-20 11:07:31'),(44,145350000.00,'2025-12-03','DEC-2026-055',3,55,'2026-09-20 11:07:33','2026-09-20 11:07:33'),(45,942637500.00,'2025-03-07','DEC-2026-056',4,56,'2026-09-20 11:07:34','2026-09-20 11:07:34'),(46,1385100000.00,'2025-12-11','DEC-2026-057',1,57,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(47,555750000.00,'2024-01-18','DEC-2026-059',3,59,'2026-09-20 11:07:38','2026-09-20 11:07:38'),(48,1346625000.00,'2025-12-23','DEC-2026-060',4,60,'2026-09-20 11:07:40','2026-09-20 11:07:40'),(49,658350000.00,'2025-12-27','DEC-2026-061',1,61,'2026-09-20 11:07:44','2026-09-20 11:07:44'),(50,384750000.00,'2024-02-08','DEC-2026-063',3,63,'2026-09-20 11:07:48','2026-09-20 11:07:48'),(51,525825000.00,'2024-12-10','DEC-2026-064',4,64,'2026-09-20 11:07:53','2026-09-20 11:07:53'),(52,1872450000.00,'2026-01-12','DEC-2026-065',1,65,'2026-09-20 11:07:55','2026-09-20 11:07:55'),(53,2468812500.00,'2025-04-16','DEC-2026-066',2,66,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(54,42750000.00,'2026-01-20','DEC-2026-067',3,67,'2026-09-20 11:08:01','2026-09-20 11:08:01'),(55,2949750000.00,'2024-03-07','DEC-2026-069',1,69,'2026-09-20 11:08:07','2026-09-20 11:08:07'),(56,2158875000.00,'2026-02-02','DEC-2026-070',2,70,'2026-09-20 11:08:10','2026-09-20 11:08:10'),(57,3411450000.00,'2026-02-06','DEC-2026-071',3,71,'2026-09-20 11:08:14','2026-09-20 11:08:14'),(58,2778750000.00,'2024-03-27','DEC-2026-073',1,73,'2026-09-20 11:08:23','2026-09-20 11:08:23'),(59,829350000.00,'2025-01-19','DEC-2026-074',2,74,'2026-09-20 11:08:32','2026-09-20 11:08:32'),(60,2205900000.00,'2026-02-22','DEC-2026-075',3,75,'2026-09-20 11:08:37','2026-09-20 11:08:37');
/*!40000 ALTER TABLE `decaissements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departements`
--

DROP TABLE IF EXISTS `departements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `region_id` bigint(20) unsigned NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `departements_region_id_foreign` (`region_id`),
  CONSTRAINT `departements_region_id_foreign` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departements`
--

LOCK TABLES `departements` WRITE;
/*!40000 ALTER TABLE `departements` DISABLE KEYS */;
INSERT INTO `departements` VALUES (1,1,'Abidjan',NULL,'2026-09-20 11:05:34','2026-09-20 11:05:34');
/*!40000 ALTER TABLE `departements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `depenses`
--

DROP TABLE IF EXISTS `depenses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `depenses` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `montant` decimal(18,2) NOT NULL,
  `date` date NOT NULL,
  `reference` varchar(255) NOT NULL,
  `projet_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `depenses_reference_unique` (`reference`),
  KEY `depenses_projet_id_foreign` (`projet_id`),
  CONSTRAINT `depenses_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `depenses`
--

LOCK TABLES `depenses` WRITE;
/*!40000 ALTER TABLE `depenses` DISABLE KEYS */;
INSERT INTO `depenses` VALUES (1,'Travaux et acquisitions - Aménager et bitumer la route M\'Batto-Afféry (40 km)',123750000.00,'2025-06-01','DEP-2026-001',1,'2026-09-20 11:05:43','2026-09-20 11:05:43'),(2,'Travaux et acquisitions - Construire des parkings publics et souterrains dans les zones commerciales et ad',1707750000.00,'2023-05-11','DEP-2026-003',3,'2026-09-20 11:05:49','2026-09-20 11:05:49'),(3,'Travaux et acquisitions - Développer un réseau cyclable sécurisé et des pistes piétonnes',2499750000.00,'2024-05-13','DEP-2026-004',4,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(4,'Travaux et acquisitions - Construire 12 sites radioélectriques à Andobo-Alluibo, Assekakro, Besseri-Takikr',3291750000.00,'2025-06-17','DEP-2026-005',5,'2026-09-20 11:05:52','2026-09-20 11:05:52'),(5,'Travaux et acquisitions - Poursuivre la digitalisation du processus d\'obtention des extraits de casier jud',816750000.00,'2024-09-21','DEP-2026-006',6,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(6,'Travaux et acquisitions - Etendre le parc de zones d\'activité industrielle',1608750000.00,'2025-06-25','DEP-2026-007',7,'2026-09-20 11:05:54','2026-09-20 11:05:54'),(7,'Travaux et acquisitions - Construire des marchés de proximité',3192750000.00,'2023-06-13','DEP-2026-009',9,'2026-09-20 11:05:57','2026-09-20 11:05:57'),(8,'Travaux et acquisitions - Créer une unité Satellite de transformation de noix de cajou (1500T) à Zuénoula',717750000.00,'2025-07-06','DEP-2026-010',10,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(9,'Travaux et acquisitions - Promouvoir des activités artisanales à travers l\'appui logistique aux associatio',1509750000.00,'2025-07-10','DEP-2026-011',11,'2026-09-20 11:05:59','2026-09-20 11:05:59'),(10,'Travaux et acquisitions - Mettre en œuvre le projet Clonix PHASE-II',3093750000.00,'2023-07-02','DEP-2026-013',13,'2026-09-20 11:06:03','2026-09-20 11:06:03'),(11,'Travaux et acquisitions - Mettre en place des microcrédits et programmes d\'accompagnement financier pour j',618750000.00,'2024-06-24','DEP-2026-014',14,'2026-09-20 11:06:06','2026-09-20 11:06:06'),(12,'Travaux et acquisitions - Construire une salle de sport semi-couverte au Lycée Moderne d\'Adzopé et d\'Alépé',1410750000.00,'2025-07-26','DEP-2026-015',15,'2026-09-20 11:06:08','2026-09-20 11:06:08'),(13,'Travaux et acquisitions - Construire deux (02) salles de sports sémi-couverte dans le Lycée Moderne Koumas',2202750000.00,'2024-10-31','DEP-2026-016',16,'2026-09-20 11:06:10','2026-09-20 11:06:10'),(14,'Travaux et acquisitions - Promouvoir l\'autonomisation économique des femmes par la formation et le microcr',2994750000.00,'2025-08-04','DEP-2026-017',17,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(15,'Travaux et acquisitions - Construire et équiper le tribunal du commerce de Daloa',1311750000.00,'2023-08-02','DEP-2026-019',19,'2026-09-20 11:06:14','2026-09-20 11:06:14'),(16,'Travaux et acquisitions - Construire et équiper une nouvelle MAC et sa cité pénitentiaire à Bingerville',2103750000.00,'2025-08-16','DEP-2026-020',20,'2026-09-20 11:06:17','2026-09-20 11:06:17'),(17,'Travaux et acquisitions - Alimenter la zone sud d\'Abidjan à partir de la nappe du Sud Comoé - phase 3',2895750000.00,'2025-08-20','DEP-2026-021',21,'2026-09-20 11:06:18','2026-09-20 11:06:18'),(18,'Travaux et acquisitions - Construire deux-cent cinquante (250) cantines scolaires dans deux-cent cinquante',1212750000.00,'2023-08-22','DEP-2026-023',23,'2026-09-20 11:06:22','2026-09-20 11:06:22'),(19,'Travaux et acquisitions - Construire et équiper 12 collèges sur la période 2026-2028',2004750000.00,'2024-08-03','DEP-2026-024',24,'2026-09-20 11:06:23','2026-09-20 11:06:23'),(20,'Travaux et acquisitions - Poursuivre la réhabilitation et équipement Centre Recherches Océanographiques (C',2796750000.00,'2025-09-05','DEP-2026-025',25,'2026-09-20 11:06:25','2026-09-20 11:06:25'),(21,'Travaux et acquisitions - Étendre les infrastructures de l\'Université de Man',321750000.00,'2024-12-09','DEP-2026-026',26,'2026-09-20 11:06:28','2026-09-20 11:06:28'),(22,'Travaux et acquisitions - Construire et équiper le garage école de Daloa',1113750000.00,'2025-09-13','DEP-2026-027',27,'2026-09-20 11:06:29','2026-09-20 11:06:29'),(23,'Travaux et acquisitions - Construire deux (2) villages d\'artisans',2697750000.00,'2023-09-21','DEP-2026-029',29,'2026-09-20 11:06:32','2026-09-20 11:06:32'),(24,'Travaux et acquisitions - Développer l\'écotourisme côtier (plages, mangroves, excursions lagunaires)',222750000.00,'2025-09-25','DEP-2026-030',30,'2026-09-20 11:06:34','2026-09-20 11:06:34'),(25,'Travaux et acquisitions - Mettre en œuvre le projet de pôle agro-industriel dans le nord-est de la Côte d\'',1014750000.00,'2025-09-29','DEP-2026-031',31,'2026-09-20 11:06:35','2026-09-20 11:06:35'),(26,'Travaux et acquisitions - Créer des points de vente des produits issus des élevages en développement',2598750000.00,'2023-10-11','DEP-2026-033',33,'2026-09-20 11:06:43','2026-09-20 11:06:43'),(27,'Travaux et acquisitions - Installer 6 fermes aquacoles',123750000.00,'2024-09-12','DEP-2026-034',34,'2026-09-20 11:06:47','2026-09-20 11:06:47'),(28,'Travaux et acquisitions - Aménager et meubler le siège du Conseil régional et la résidence du directeur gé',915750000.00,'2025-10-15','DEP-2026-035',35,'2026-09-20 11:06:49','2026-09-20 11:06:49'),(29,'Travaux et acquisitions - Restructurer et aménager les quartiers précaires d\'Abidjan',1707750000.00,'2025-01-19','DEP-2026-036',36,'2026-09-20 11:06:52','2026-09-20 11:06:52'),(30,'Travaux et acquisitions - Poursuivre la dotation des communes ne disposant pas de service délégué de propr',2499750000.00,'2025-10-23','DEP-2026-037',37,'2026-09-20 11:06:54','2026-09-20 11:06:54'),(31,'Travaux et acquisitions - Construire 45 ESPC dont 14 dispensaires ruraux, 21 centres de santé urbains et 1',816750000.00,'2023-11-10','DEP-2026-039',39,'2026-09-20 11:06:58','2026-09-20 11:06:58'),(32,'Travaux et acquisitions - Renforcer la production d\'oxygène dans les établissements sanitaires de référenc',1608750000.00,'2025-11-04','DEP-2026-040',40,'2026-09-20 11:07:00','2026-09-20 11:07:00'),(33,'Travaux et acquisitions - Poursuivre la construction de la mine d\'or KONÉ, dans les départements de Kani',2400750000.00,'2025-11-08','DEP-2026-041',41,'2026-09-20 11:07:02','2026-09-20 11:07:02'),(34,'Travaux et acquisitions - Mettre en œuvre le Projet de réalisation de la centrale solaire de Binguebougou',717750000.00,'2023-11-30','DEP-2026-043',43,'2026-09-20 11:07:06','2026-09-20 11:07:06'),(35,'Travaux et acquisitions - Mettre en œuvre le Programme Électricité Pour Tous (PEPT) par le branchement de',1509750000.00,'2024-10-22','DEP-2026-044',44,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(36,'Travaux et acquisitions - Promouvoir les arts, traditions et savoir-faire locaux (danse, artisanat, musiqu',2301750000.00,'2025-11-24','DEP-2026-045',45,'2026-09-20 11:07:11','2026-09-20 11:07:11'),(37,'Travaux et acquisitions - Développer des infrastructures touristiques (hébergements, routes d\'accès, signa',3093750000.00,'2025-02-28','DEP-2026-046',46,'2026-09-20 11:07:14','2026-09-20 11:07:14'),(38,'Travaux et acquisitions - Mettre en place un système de suivi-évaluation pour le suivi des projets et leur',618750000.00,'2025-12-01','DEP-2026-047',47,'2026-09-20 11:07:17','2026-09-20 11:07:17'),(39,'Travaux et acquisitions - Réhabiliter et équiper les services de l\'administration du travail d\'Adjamé',2202750000.00,'2023-12-29','DEP-2026-049',49,'2026-09-20 11:07:20','2026-09-20 11:07:20'),(40,'Travaux et acquisitions - Poursuivre l\'enrôlement au RSTI et à la CMU',2994750000.00,'2025-12-13','DEP-2026-050',50,'2026-09-20 11:07:24','2026-09-20 11:07:24'),(41,'Travaux et acquisitions - Aménager et équiper des Crèches garderies dans les CPPE des régions non pourvues',519750000.00,'2025-12-17','DEP-2026-051',51,'2026-09-20 11:07:26','2026-09-20 11:07:26'),(42,'Travaux et acquisitions - Acquérir un bac pour la traversée à Béoumi',2103750000.00,'2024-01-19','DEP-2026-053',53,'2026-09-20 11:07:29','2026-09-20 11:07:29'),(43,'Travaux et acquisitions - Construire et renforcer les routes (reprofilage lourd et léger) et ouvrages',2895750000.00,'2024-12-01','DEP-2026-054',54,'2026-09-20 11:07:32','2026-09-20 11:07:32'),(44,'Travaux et acquisitions - Construire une caserne de sapeurs-pompiers',420750000.00,'2026-01-03','DEP-2026-055',55,'2026-09-20 11:07:33','2026-09-20 11:07:33'),(45,'Travaux et acquisitions - Construire et équiper des centres de manœuvres et d\'entrainements',1212750000.00,'2025-04-07','DEP-2026-056',56,'2026-09-20 11:07:35','2026-09-20 11:07:35'),(46,'Travaux et acquisitions - Développer une brigade municipale de prévention (sécurité routière, environnemen',2004750000.00,'2026-01-11','DEP-2026-057',57,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(47,'Travaux et acquisitions - Insertion de 27 458 jeunes aux programmes d\'insertion professionnelle (2023 -202',321750000.00,'2024-02-18','DEP-2026-059',59,'2026-09-20 11:07:39','2026-09-20 11:07:39'),(48,'Travaux et acquisitions - Construire et équiper 12 Agences (une dans chacune des Sous-Préfectures) types d',1113750000.00,'2026-01-23','DEP-2026-060',60,'2026-09-20 11:07:40','2026-09-20 11:07:40'),(49,'Travaux et acquisitions - Promouvoir l\'énergie renouvelable (solaire sur bâtiments publics et éclairage pu',1905750000.00,'2026-01-27','DEP-2026-061',61,'2026-09-20 11:07:44','2026-09-20 11:07:44'),(50,'Travaux et acquisitions - Construire le Lycée Professionnel de Toumodi',222750000.00,'2024-03-08','DEP-2026-063',63,'2026-09-20 11:07:48','2026-09-20 11:07:48'),(51,'Travaux et acquisitions - Aménager et bitumer la route Séguéla-Kongasso-Kounahiri (100 km)',1014750000.00,'2025-01-10','DEP-2026-064',64,'2026-09-20 11:07:53','2026-09-20 11:07:53'),(52,'Travaux et acquisitions - Poursuivre la construction du Lycée d\'Excellence de jeunes filles de Bouna',1806750000.00,'2026-02-12','DEP-2026-065',65,'2026-09-20 11:07:55','2026-09-20 11:07:55'),(53,'Travaux et acquisitions - Reconstruire aux normes le marché de détail de Guiglo',2598750000.00,'2025-05-16','DEP-2026-066',66,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(54,'Travaux et acquisitions - Construire le pont sur l\'axe Banankoro - Manadoun',123750000.00,'2026-02-20','DEP-2026-067',67,'2026-09-20 11:08:02','2026-09-20 11:08:02'),(55,'Travaux et acquisitions - Poursuivre la construction et l\'équipement du CHR de Katiola',1707750000.00,'2024-04-07','DEP-2026-069',69,'2026-09-20 11:08:07','2026-09-20 11:08:07'),(56,'Travaux et acquisitions - Construire l\'Université d\'Abengourou',2499750000.00,'2026-03-02','DEP-2026-070',70,'2026-09-20 11:08:10','2026-09-20 11:08:10'),(57,'Travaux et acquisitions - Poursuivre la construction de dix (10) marchés dans le Lôh-Djiboua',3291750000.00,'2026-03-06','DEP-2026-071',71,'2026-09-20 11:08:15','2026-09-20 11:08:15'),(58,'Travaux et acquisitions - Construire le Lycée Professionnel de Dimbokro',1608750000.00,'2024-04-27','DEP-2026-073',73,'2026-09-20 11:08:23','2026-09-20 11:08:23'),(59,'Travaux et acquisitions - Finaliser la construction des infrastructures et mettre en service le métro d\'Ab',2400750000.00,'2025-02-19','DEP-2026-074',74,'2026-09-20 11:08:33','2026-09-20 11:08:33'),(60,'Travaux et acquisitions - Finaliser la construction de la centrale à biomasse BIOVEA à Aboisso',3192750000.00,'2026-03-22','DEP-2026-075',75,'2026-09-20 11:08:38','2026-09-20 11:08:38');
/*!40000 ALTER TABLE `depenses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `districts`
--

DROP TABLE IF EXISTS `districts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `districts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `zone_execution_id` bigint(20) unsigned DEFAULT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `districts_zone_execution_id_foreign` (`zone_execution_id`),
  CONSTRAINT `districts_zone_execution_id_foreign` FOREIGN KEY (`zone_execution_id`) REFERENCES `zones_localisation` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `districts`
--

LOCK TABLES `districts` WRITE;
/*!40000 ALTER TABLE `districts` DISABLE KEYS */;
INSERT INTO `districts` VALUES (1,1,'District Autonome d\'Abidjan',NULL,'2026-09-20 11:05:34','2026-09-20 11:05:34'),(2,1,'District Autonome de Yamoussoukro',NULL,'2026-09-20 11:05:36','2026-09-20 11:05:36'),(3,1,'Régions de l\'intérieur',NULL,'2026-09-20 11:05:36','2026-09-20 11:05:36');
/*!40000 ALTER TABLE `districts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documents`
--

DROP TABLE IF EXISTS `documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documents` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint(20) unsigned NOT NULL,
  `type_document_id` bigint(20) unsigned DEFAULT NULL,
  `titre` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `fichier` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `strategie` varchar(255) DEFAULT NULL,
  `taille` bigint(20) unsigned DEFAULT NULL,
  `extension` varchar(20) DEFAULT NULL,
  `ajoute_par_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_projet_id_foreign` (`projet_id`),
  KEY `documents_ajoute_par_id_foreign` (`ajoute_par_id`),
  KEY `documents_type_document_id_foreign` (`type_document_id`),
  CONSTRAINT `documents_ajoute_par_id_foreign` FOREIGN KEY (`ajoute_par_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `documents_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `documents_type_document_id_foreign` FOREIGN KEY (`type_document_id`) REFERENCES `types_document` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documents`
--

LOCK TABLES `documents` WRITE;
/*!40000 ALTER TABLE `documents` DISABLE KEYS */;
/*!40000 ALTER TABLE `documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `echeanciers_ae_cp`
--

DROP TABLE IF EXISTS `echeanciers_ae_cp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `echeanciers_ae_cp` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `annee_lf` smallint(5) unsigned NOT NULL,
  `montant_ae` decimal(18,2) DEFAULT NULL,
  `montant_cp` decimal(18,2) DEFAULT NULL,
  `marche_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `echeanciers_ae_cp_marche_id_foreign` (`marche_id`),
  CONSTRAINT `echeanciers_ae_cp_marche_id_foreign` FOREIGN KEY (`marche_id`) REFERENCES `marches` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `echeanciers_ae_cp`
--

LOCK TABLES `echeanciers_ae_cp` WRITE;
/*!40000 ALTER TABLE `echeanciers_ae_cp` DISABLE KEYS */;
/*!40000 ALTER TABLE `echeanciers_ae_cp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etudes`
--

DROP TABLE IF EXISTS `etudes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etudes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `mode_execution` varchar(255) DEFAULT NULL,
  `structure_realisation` varchar(255) DEFAULT NULL,
  `budget` decimal(18,2) DEFAULT NULL,
  `date_demarrage` date DEFAULT NULL,
  `duree` varchar(255) DEFAULT NULL,
  `etat_execution` varchar(255) DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `etudes_projet_id_foreign` (`projet_id`),
  CONSTRAINT `etudes_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etudes`
--

LOCK TABLES `etudes` WRITE;
/*!40000 ALTER TABLE `etudes` DISABLE KEYS */;
/*!40000 ALTER TABLE `etudes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fiche_pip_projet`
--

DROP TABLE IF EXISTS `fiche_pip_projet`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fiche_pip_projet` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `fiche_pip_id` bigint(20) unsigned NOT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fiche_pip_projet_fiche_pip_id_projet_id_unique` (`fiche_pip_id`,`projet_id`),
  KEY `fiche_pip_projet_projet_id_foreign` (`projet_id`),
  CONSTRAINT `fiche_pip_projet_fiche_pip_id_foreign` FOREIGN KEY (`fiche_pip_id`) REFERENCES `fiches_pip` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fiche_pip_projet_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiche_pip_projet`
--

LOCK TABLES `fiche_pip_projet` WRITE;
/*!40000 ALTER TABLE `fiche_pip_projet` DISABLE KEYS */;
INSERT INTO `fiche_pip_projet` VALUES (1,1,1,NULL,NULL),(2,1,2,NULL,NULL),(3,2,23,NULL,NULL),(4,2,24,NULL,NULL),(5,3,39,NULL,NULL),(6,3,40,NULL,NULL),(7,1,53,NULL,NULL),(8,1,54,NULL,NULL),(9,1,64,NULL,NULL),(10,2,65,NULL,NULL),(11,1,67,NULL,NULL),(12,1,68,NULL,NULL),(13,3,69,NULL,NULL);
/*!40000 ALTER TABLE `fiche_pip_projet` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `fiches_pip`
--

DROP TABLE IF EXISTS `fiches_pip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fiches_pip` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `numero` varchar(255) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `programme_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `fiches_pip_numero_unique` (`numero`),
  KEY `fiches_pip_programme_id_foreign` (`programme_id`),
  CONSTRAINT `fiches_pip_programme_id_foreign` FOREIGN KEY (`programme_id`) REFERENCES `programmes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `fiches_pip`
--

LOCK TABLES `fiches_pip` WRITE;
/*!40000 ALTER TABLE `fiches_pip` DISABLE KEYS */;
INSERT INTO `fiches_pip` VALUES (1,'PIP-2026-0001','Fiche d\'identification - Infrastructures routières régionales',1,'2026-09-20 11:05:42','2026-09-20 11:05:42'),(2,'PIP-2026-0002','Fiche d\'identification - Construction et réhabilitation d\'écoles',2,'2026-09-20 11:05:42','2026-09-20 11:05:42'),(3,'PIP-2026-0003','Fiche d\'identification - Établissements sanitaires de proximité',3,'2026-09-20 11:05:42','2026-09-20 11:05:42');
/*!40000 ALTER TABLE `fiches_pip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `financements`
--

DROP TABLE IF EXISTS `financements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `financements` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `montant_engage` decimal(18,2) NOT NULL,
  `date` date NOT NULL,
  `reference` varchar(255) NOT NULL,
  `devise` varchar(255) NOT NULL DEFAULT 'XOF',
  `taux_change` decimal(12,4) DEFAULT NULL,
  `ressources_internes` decimal(18,2) DEFAULT NULL,
  `ressources_externes` decimal(18,2) DEFAULT NULL,
  `statut` varchar(255) DEFAULT NULL,
  `observation` text DEFAULT NULL,
  `type_source` enum('tresor','emprunt','don','participation_collectivites','participation_populations','participation_secteur_prive','ppp','fonds_propres_parapublics') DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `bailleur_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `financements_reference_unique` (`reference`),
  KEY `financements_projet_id_foreign` (`projet_id`),
  KEY `financements_bailleur_id_foreign` (`bailleur_id`),
  CONSTRAINT `financements_bailleur_id_foreign` FOREIGN KEY (`bailleur_id`) REFERENCES `bailleurs` (`id`) ON DELETE SET NULL,
  CONSTRAINT `financements_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `financements`
--

LOCK TABLES `financements` WRITE;
/*!40000 ALTER TABLE `financements` DISABLE KEYS */;
INSERT INTO `financements` VALUES (1,225000000.00,'2025-03-01','FIN-2026-001','XOF',NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2026-09-20 11:05:43','2026-09-20 11:05:43'),(2,1665000000.00,'2027-01-04','FIN-2026-002','XOF',NULL,NULL,NULL,NULL,NULL,NULL,2,2,'2026-09-20 11:05:46','2026-09-20 11:05:46'),(3,3105000000.00,'2023-02-11','FIN-2026-003','XOF',NULL,NULL,NULL,NULL,NULL,NULL,3,3,'2026-09-20 11:05:48','2026-09-20 11:05:48'),(4,4545000000.00,'2024-02-13','FIN-2026-004','XOF',NULL,NULL,NULL,NULL,NULL,NULL,4,4,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(5,5985000000.00,'2025-03-17','FIN-2026-005','XOF',NULL,NULL,NULL,NULL,NULL,NULL,5,1,'2026-09-20 11:05:52','2026-09-20 11:05:52'),(6,1485000000.00,'2024-06-21','FIN-2026-006','XOF',NULL,NULL,NULL,NULL,NULL,NULL,6,2,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(7,2925000000.00,'2025-03-25','FIN-2026-007','XOF',NULL,NULL,NULL,NULL,NULL,NULL,7,3,'2026-09-20 11:05:54','2026-09-20 11:05:54'),(8,4365000000.00,'2027-01-22','FIN-2026-008','XOF',NULL,NULL,NULL,NULL,NULL,NULL,8,4,'2026-09-20 11:05:56','2026-09-20 11:05:56'),(9,5805000000.00,'2023-03-13','FIN-2026-009','XOF',NULL,NULL,NULL,NULL,NULL,NULL,9,1,'2026-09-20 11:05:57','2026-09-20 11:05:57'),(10,1305000000.00,'2025-04-06','FIN-2026-010','XOF',NULL,NULL,NULL,NULL,NULL,NULL,10,2,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(11,2745000000.00,'2025-04-10','FIN-2026-011','XOF',NULL,NULL,NULL,NULL,NULL,NULL,11,3,'2026-09-20 11:05:59','2026-09-20 11:05:59'),(12,4185000000.00,'2027-02-03','FIN-2026-012','XOF',NULL,NULL,NULL,NULL,NULL,NULL,12,4,'2026-09-20 11:06:02','2026-09-20 11:06:02'),(13,5625000000.00,'2023-04-02','FIN-2026-013','XOF',NULL,NULL,NULL,NULL,NULL,NULL,13,1,'2026-09-20 11:06:03','2026-09-20 11:06:03'),(14,1125000000.00,'2024-03-24','FIN-2026-014','XOF',NULL,NULL,NULL,NULL,NULL,NULL,14,2,'2026-09-20 11:06:06','2026-09-20 11:06:06'),(15,2565000000.00,'2025-04-26','FIN-2026-015','XOF',NULL,NULL,NULL,NULL,NULL,NULL,15,3,'2026-09-20 11:06:08','2026-09-20 11:06:08'),(16,4005000000.00,'2024-07-31','FIN-2026-016','XOF',NULL,NULL,NULL,NULL,NULL,NULL,16,4,'2026-09-20 11:06:10','2026-09-20 11:06:10'),(17,5445000000.00,'2025-05-04','FIN-2026-017','XOF',NULL,NULL,NULL,NULL,NULL,NULL,17,1,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(18,945000000.00,'2027-02-21','FIN-2026-018','XOF',NULL,NULL,NULL,NULL,NULL,NULL,18,2,'2026-09-20 11:06:13','2026-09-20 11:06:13'),(19,2385000000.00,'2023-05-02','FIN-2026-019','XOF',NULL,NULL,NULL,NULL,NULL,NULL,19,3,'2026-09-20 11:06:14','2026-09-20 11:06:14'),(20,3825000000.00,'2025-05-16','FIN-2026-020','XOF',NULL,NULL,NULL,NULL,NULL,NULL,20,4,'2026-09-20 11:06:16','2026-09-20 11:06:16'),(21,5265000000.00,'2025-05-20','FIN-2026-021','XOF',NULL,NULL,NULL,NULL,NULL,NULL,21,1,'2026-09-20 11:06:18','2026-09-20 11:06:18'),(22,765000000.00,'2027-03-05','FIN-2026-022','XOF',NULL,NULL,NULL,NULL,NULL,NULL,22,2,'2026-09-20 11:06:20','2026-09-20 11:06:20'),(23,2205000000.00,'2023-05-22','FIN-2026-023','XOF',NULL,NULL,NULL,NULL,NULL,NULL,23,3,'2026-09-20 11:06:22','2026-09-20 11:06:22'),(24,3645000000.00,'2024-05-03','FIN-2026-024','XOF',NULL,NULL,NULL,NULL,NULL,NULL,24,4,'2026-09-20 11:06:23','2026-09-20 11:06:23'),(25,5085000000.00,'2025-06-05','FIN-2026-025','XOF',NULL,NULL,NULL,NULL,NULL,NULL,25,1,'2026-09-20 11:06:25','2026-09-20 11:06:25'),(26,585000000.00,'2024-09-09','FIN-2026-026','XOF',NULL,NULL,NULL,NULL,NULL,NULL,26,2,'2026-09-20 11:06:27','2026-09-20 11:06:27'),(27,2025000000.00,'2025-06-13','FIN-2026-027','XOF',NULL,NULL,NULL,NULL,NULL,NULL,27,3,'2026-09-20 11:06:29','2026-09-20 11:06:29'),(28,3465000000.00,'2027-03-23','FIN-2026-028','XOF',NULL,NULL,NULL,NULL,NULL,NULL,28,4,'2026-09-20 11:06:30','2026-09-20 11:06:30'),(29,4905000000.00,'2023-06-21','FIN-2026-029','XOF',NULL,NULL,NULL,NULL,NULL,NULL,29,1,'2026-09-20 11:06:31','2026-09-20 11:06:31'),(30,405000000.00,'2025-06-25','FIN-2026-030','XOF',NULL,NULL,NULL,NULL,NULL,NULL,30,2,'2026-09-20 11:06:34','2026-09-20 11:06:34'),(31,1845000000.00,'2025-06-29','FIN-2026-031','XOF',NULL,NULL,NULL,NULL,NULL,NULL,31,3,'2026-09-20 11:06:35','2026-09-20 11:06:35'),(32,3285000000.00,'2027-04-04','FIN-2026-032','XOF',NULL,NULL,NULL,NULL,NULL,NULL,32,4,'2026-09-20 11:06:38','2026-09-20 11:06:38'),(33,4725000000.00,'2023-07-11','FIN-2026-033','XOF',NULL,NULL,NULL,NULL,NULL,NULL,33,1,'2026-09-20 11:06:42','2026-09-20 11:06:42'),(34,225000000.00,'2024-06-12','FIN-2026-034','XOF',NULL,NULL,NULL,NULL,NULL,NULL,34,2,'2026-09-20 11:06:47','2026-09-20 11:06:47'),(35,1665000000.00,'2025-07-15','FIN-2026-035','XOF',NULL,NULL,NULL,NULL,NULL,NULL,35,3,'2026-09-20 11:06:48','2026-09-20 11:06:48'),(36,3105000000.00,'2024-10-19','FIN-2026-036','XOF',NULL,NULL,NULL,NULL,NULL,NULL,36,4,'2026-09-20 11:06:52','2026-09-20 11:06:52'),(37,4545000000.00,'2025-07-23','FIN-2026-037','XOF',NULL,NULL,NULL,NULL,NULL,NULL,37,1,'2026-09-20 11:06:54','2026-09-20 11:06:54'),(38,5985000000.00,'2027-04-22','FIN-2026-038','XOF',NULL,NULL,NULL,NULL,NULL,NULL,38,2,'2026-09-20 11:06:55','2026-09-20 11:06:55'),(39,1485000000.00,'2023-08-10','FIN-2026-039','XOF',NULL,NULL,NULL,NULL,NULL,NULL,39,3,'2026-09-20 11:06:58','2026-09-20 11:06:58'),(40,2925000000.00,'2025-08-04','FIN-2026-040','XOF',NULL,NULL,NULL,NULL,NULL,NULL,40,4,'2026-09-20 11:07:00','2026-09-20 11:07:00'),(41,4365000000.00,'2025-08-08','FIN-2026-041','XOF',NULL,NULL,NULL,NULL,NULL,NULL,41,1,'2026-09-20 11:07:02','2026-09-20 11:07:02'),(42,5805000000.00,'2027-05-04','FIN-2026-042','XOF',NULL,NULL,NULL,NULL,NULL,NULL,42,2,'2026-09-20 11:07:04','2026-09-20 11:07:04'),(43,1305000000.00,'2023-08-30','FIN-2026-043','XOF',NULL,NULL,NULL,NULL,NULL,NULL,43,3,'2026-09-20 11:07:06','2026-09-20 11:07:06'),(44,2745000000.00,'2024-07-22','FIN-2026-044','XOF',NULL,NULL,NULL,NULL,NULL,NULL,44,4,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(45,4185000000.00,'2025-08-24','FIN-2026-045','XOF',NULL,NULL,NULL,NULL,NULL,NULL,45,1,'2026-09-20 11:07:11','2026-09-20 11:07:11'),(46,5625000000.00,'2024-11-28','FIN-2026-046','XOF',NULL,NULL,NULL,NULL,NULL,NULL,46,2,'2026-09-20 11:07:14','2026-09-20 11:07:14'),(47,1125000000.00,'2025-09-01','FIN-2026-047','XOF',NULL,NULL,NULL,NULL,NULL,NULL,47,3,'2026-09-20 11:07:15','2026-09-20 11:07:15'),(48,2565000000.00,'2027-05-22','FIN-2026-048','XOF',NULL,NULL,NULL,NULL,NULL,NULL,48,4,'2026-09-20 11:07:18','2026-09-20 11:07:18'),(49,4005000000.00,'2023-09-29','FIN-2026-049','XOF',NULL,NULL,NULL,NULL,NULL,NULL,49,1,'2026-09-20 11:07:20','2026-09-20 11:07:20'),(50,5445000000.00,'2025-09-13','FIN-2026-050','XOF',NULL,NULL,NULL,NULL,NULL,NULL,50,2,'2026-09-20 11:07:23','2026-09-20 11:07:23'),(51,945000000.00,'2025-09-17','FIN-2026-051','XOF',NULL,NULL,NULL,NULL,NULL,NULL,51,3,'2026-09-20 11:07:26','2026-09-20 11:07:26'),(52,2385000000.00,'2027-06-03','FIN-2026-052','XOF',NULL,NULL,NULL,NULL,NULL,NULL,52,4,'2026-09-20 11:07:28','2026-09-20 11:07:28'),(53,3825000000.00,'2023-10-19','FIN-2026-053','XOF',NULL,NULL,NULL,NULL,NULL,NULL,53,1,'2026-09-20 11:07:29','2026-09-20 11:07:29'),(54,5265000000.00,'2024-08-31','FIN-2026-054','XOF',NULL,NULL,NULL,NULL,NULL,NULL,54,2,'2026-09-20 11:07:31','2026-09-20 11:07:31'),(55,765000000.00,'2025-10-03','FIN-2026-055','XOF',NULL,NULL,NULL,NULL,NULL,NULL,55,3,'2026-09-20 11:07:33','2026-09-20 11:07:33'),(56,2205000000.00,'2025-01-07','FIN-2026-056','XOF',NULL,NULL,NULL,NULL,NULL,NULL,56,4,'2026-09-20 11:07:34','2026-09-20 11:07:34'),(57,3645000000.00,'2025-10-11','FIN-2026-057','XOF',NULL,NULL,NULL,NULL,NULL,NULL,57,1,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(58,5085000000.00,'2027-06-21','FIN-2026-058','XOF',NULL,NULL,NULL,NULL,NULL,NULL,58,2,'2026-09-20 11:07:37','2026-09-20 11:07:37'),(59,585000000.00,'2023-11-18','FIN-2026-059','XOF',NULL,NULL,NULL,NULL,NULL,NULL,59,3,'2026-09-20 11:07:38','2026-09-20 11:07:38'),(60,2025000000.00,'2025-10-23','FIN-2026-060','XOF',NULL,NULL,NULL,NULL,NULL,NULL,60,4,'2026-09-20 11:07:40','2026-09-20 11:07:40'),(61,3465000000.00,'2025-10-27','FIN-2026-061','XOF',NULL,NULL,NULL,NULL,NULL,NULL,61,1,'2026-09-20 11:07:42','2026-09-20 11:07:42'),(62,4905000000.00,'2027-07-03','FIN-2026-062','XOF',NULL,NULL,NULL,NULL,NULL,NULL,62,2,'2026-09-20 11:07:47','2026-09-20 11:07:47'),(63,405000000.00,'2023-12-08','FIN-2026-063','XOF',NULL,NULL,NULL,NULL,NULL,NULL,63,3,'2026-09-20 11:07:48','2026-09-20 11:07:48'),(64,1845000000.00,'2024-10-10','FIN-2026-064','XOF',NULL,NULL,NULL,NULL,NULL,NULL,64,4,'2026-09-20 11:07:52','2026-09-20 11:07:52'),(65,3285000000.00,'2025-11-12','FIN-2026-065','XOF',NULL,NULL,NULL,NULL,NULL,NULL,65,1,'2026-09-20 11:07:55','2026-09-20 11:07:55'),(66,4725000000.00,'2025-02-16','FIN-2026-066','XOF',NULL,NULL,NULL,NULL,NULL,NULL,66,2,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(67,225000000.00,'2025-11-20','FIN-2026-067','XOF',NULL,NULL,NULL,NULL,NULL,NULL,67,3,'2026-09-20 11:08:00','2026-09-20 11:08:00'),(68,1665000000.00,'2027-07-21','FIN-2026-068','XOF',NULL,NULL,NULL,NULL,NULL,NULL,68,4,'2026-09-20 11:08:04','2026-09-20 11:08:04'),(69,3105000000.00,'2024-01-07','FIN-2026-069','XOF',NULL,NULL,NULL,NULL,NULL,NULL,69,1,'2026-09-20 11:08:07','2026-09-20 11:08:07'),(70,4545000000.00,'2025-12-02','FIN-2026-070','XOF',NULL,NULL,NULL,NULL,NULL,NULL,70,2,'2026-09-20 11:08:09','2026-09-20 11:08:09'),(71,5985000000.00,'2025-12-06','FIN-2026-071','XOF',NULL,NULL,NULL,NULL,NULL,NULL,71,3,'2026-09-20 11:08:14','2026-09-20 11:08:14'),(72,1485000000.00,'2027-08-02','FIN-2026-072','XOF',NULL,NULL,NULL,NULL,NULL,NULL,72,4,'2026-09-20 11:08:21','2026-09-20 11:08:21'),(73,2925000000.00,'2024-01-27','FIN-2026-073','XOF',NULL,NULL,NULL,NULL,NULL,NULL,73,1,'2026-09-20 11:08:23','2026-09-20 11:08:23'),(74,4365000000.00,'2024-11-19','FIN-2026-074','XOF',NULL,NULL,NULL,NULL,NULL,NULL,74,2,'2026-09-20 11:08:31','2026-09-20 11:08:31'),(75,5805000000.00,'2025-12-22','FIN-2026-075','XOF',NULL,NULL,NULL,NULL,NULL,NULL,75,3,'2026-09-20 11:08:37','2026-09-20 11:08:37');
/*!40000 ALTER TABLE `financements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groupes_acteur`
--

DROP TABLE IF EXISTS `groupes_acteur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groupes_acteur` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groupes_acteur`
--

LOCK TABLES `groupes_acteur` WRITE;
/*!40000 ALTER TABLE `groupes_acteur` DISABLE KEYS */;
/*!40000 ALTER TABLE `groupes_acteur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `indicateurs`
--

DROP TABLE IF EXISTS `indicateurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `indicateurs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `unite` varchar(255) DEFAULT NULL,
  `situation_reference` varchar(255) DEFAULT NULL,
  `valeur_cible` decimal(18,2) DEFAULT NULL,
  `valeur_realisee` decimal(18,2) DEFAULT NULL,
  `date_mesure` date DEFAULT NULL,
  `sources_verification` varchar(255) DEFAULT NULL,
  `hypothese` varchar(255) DEFAULT NULL,
  `activite_id` bigint(20) unsigned NOT NULL,
  `resultat_attendu_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `indicateurs_activite_id_foreign` (`activite_id`),
  KEY `indicateurs_resultat_attendu_id_foreign` (`resultat_attendu_id`),
  CONSTRAINT `indicateurs_activite_id_foreign` FOREIGN KEY (`activite_id`) REFERENCES `activites` (`id`) ON DELETE CASCADE,
  CONSTRAINT `indicateurs_resultat_attendu_id_foreign` FOREIGN KEY (`resultat_attendu_id`) REFERENCES `resultats_attendus` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `indicateurs`
--

LOCK TABLES `indicateurs` WRITE;
/*!40000 ALTER TABLE `indicateurs` DISABLE KEYS */;
INSERT INTO `indicateurs` VALUES (1,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2025-07-01',NULL,NULL,1,NULL,'2026-09-20 11:05:44','2026-09-20 11:05:44'),(2,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,0.00,'2026-01-01',NULL,NULL,2,NULL,'2026-09-20 11:05:45','2026-09-20 11:05:45'),(3,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-05-04',NULL,NULL,3,NULL,'2026-09-20 11:05:47','2026-09-20 11:05:47'),(4,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2023-06-11',NULL,NULL,4,NULL,'2026-09-20 11:05:49','2026-09-20 11:05:49'),(5,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2023-12-11',NULL,NULL,5,NULL,'2026-09-20 11:05:50','2026-09-20 11:05:50'),(6,'Taux de réalisation des études (%)','%',NULL,100.00,50.00,'2024-06-13',NULL,NULL,6,NULL,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(7,'Taux de réalisation des études (%)','%',NULL,100.00,80.00,'2025-07-17',NULL,NULL,7,NULL,'2026-09-20 11:05:52','2026-09-20 11:05:52'),(8,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,40.00,'2026-01-17',NULL,NULL,8,NULL,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(9,'Taux de réalisation des études (%)','%',NULL,100.00,75.00,'2024-10-21',NULL,NULL,9,NULL,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(10,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2025-07-25',NULL,NULL,10,NULL,'2026-09-20 11:05:55','2026-09-20 11:05:55'),(11,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,0.00,'2026-01-25',NULL,NULL,11,NULL,'2026-09-20 11:05:56','2026-09-20 11:05:56'),(12,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-05-22',NULL,NULL,12,NULL,'2026-09-20 11:05:56','2026-09-20 11:05:56'),(13,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2023-07-13',NULL,NULL,13,NULL,'2026-09-20 11:05:57','2026-09-20 11:05:57'),(14,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-01-13',NULL,NULL,14,NULL,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(15,'Taux de réalisation des études (%)','%',NULL,100.00,70.00,'2025-08-06',NULL,NULL,15,NULL,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(16,'Taux de réalisation des études (%)','%',NULL,100.00,80.00,'2025-08-10',NULL,NULL,16,NULL,'2026-09-20 11:06:00','2026-09-20 11:06:00'),(17,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,40.00,'2026-02-10',NULL,NULL,17,NULL,'2026-09-20 11:06:01','2026-09-20 11:06:01'),(18,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-06-03',NULL,NULL,18,NULL,'2026-09-20 11:06:02','2026-09-20 11:06:02'),(19,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2023-08-02',NULL,NULL,19,NULL,'2026-09-20 11:06:04','2026-09-20 11:06:04'),(20,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-02-02',NULL,NULL,20,NULL,'2026-09-20 11:06:05','2026-09-20 11:06:05'),(21,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2024-07-24',NULL,NULL,21,NULL,'2026-09-20 11:06:07','2026-09-20 11:06:07'),(22,'Taux de réalisation des études (%)','%',NULL,100.00,60.00,'2025-08-26',NULL,NULL,22,NULL,'2026-09-20 11:06:09','2026-09-20 11:06:09'),(23,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,20.00,'2026-02-26',NULL,NULL,23,NULL,'2026-09-20 11:06:09','2026-09-20 11:06:09'),(24,'Taux de réalisation des études (%)','%',NULL,100.00,55.00,'2024-12-01',NULL,NULL,24,NULL,'2026-09-20 11:06:11','2026-09-20 11:06:11'),(25,'Taux de réalisation des études (%)','%',NULL,100.00,80.00,'2025-09-04',NULL,NULL,25,NULL,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(26,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,40.00,'2026-03-04',NULL,NULL,26,NULL,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(27,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-06-21',NULL,NULL,27,NULL,'2026-09-20 11:06:14','2026-09-20 11:06:14'),(28,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2023-09-02',NULL,NULL,28,NULL,'2026-09-20 11:06:15','2026-09-20 11:06:15'),(29,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-03-02',NULL,NULL,29,NULL,'2026-09-20 11:06:16','2026-09-20 11:06:16'),(30,'Taux de réalisation des études (%)','%',NULL,100.00,50.00,'2025-09-16',NULL,NULL,30,NULL,'2026-09-20 11:06:17','2026-09-20 11:06:17'),(31,'Taux de réalisation des études (%)','%',NULL,100.00,60.00,'2025-09-20',NULL,NULL,31,NULL,'2026-09-20 11:06:19','2026-09-20 11:06:19'),(32,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,20.00,'2026-03-20',NULL,NULL,32,NULL,'2026-09-20 11:06:20','2026-09-20 11:06:20'),(33,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-07-05',NULL,NULL,33,NULL,'2026-09-20 11:06:21','2026-09-20 11:06:21'),(34,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2023-09-22',NULL,NULL,34,NULL,'2026-09-20 11:06:22','2026-09-20 11:06:22'),(35,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-03-22',NULL,NULL,35,NULL,'2026-09-20 11:06:23','2026-09-20 11:06:23'),(36,'Taux de réalisation des études (%)','%',NULL,100.00,50.00,'2024-09-03',NULL,NULL,36,NULL,'2026-09-20 11:06:24','2026-09-20 11:06:24'),(37,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2025-10-05',NULL,NULL,37,NULL,'2026-09-20 11:06:26','2026-09-20 11:06:26'),(38,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,0.00,'2026-04-05',NULL,NULL,38,NULL,'2026-09-20 11:06:26','2026-09-20 11:06:26'),(39,'Taux de réalisation des études (%)','%',NULL,100.00,65.00,'2025-01-09',NULL,NULL,39,NULL,'2026-09-20 11:06:28','2026-09-20 11:06:28'),(40,'Taux de réalisation des études (%)','%',NULL,100.00,60.00,'2025-10-13',NULL,NULL,40,NULL,'2026-09-20 11:06:29','2026-09-20 11:06:29'),(41,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,20.00,'2026-04-13',NULL,NULL,41,NULL,'2026-09-20 11:06:30','2026-09-20 11:06:30'),(42,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-07-23',NULL,NULL,42,NULL,'2026-09-20 11:06:31','2026-09-20 11:06:31'),(43,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2023-10-21',NULL,NULL,43,NULL,'2026-09-20 11:06:33','2026-09-20 11:06:33'),(44,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-04-21',NULL,NULL,44,NULL,'2026-09-20 11:06:34','2026-09-20 11:06:34'),(45,'Taux de réalisation des études (%)','%',NULL,100.00,90.00,'2025-10-25',NULL,NULL,45,NULL,'2026-09-20 11:06:35','2026-09-20 11:06:35'),(46,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2025-10-29',NULL,NULL,46,NULL,'2026-09-20 11:06:36','2026-09-20 11:06:36'),(47,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,0.00,'2026-04-29',NULL,NULL,47,NULL,'2026-09-20 11:06:37','2026-09-20 11:06:37'),(48,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-08-04',NULL,NULL,48,NULL,'2026-09-20 11:06:41','2026-09-20 11:06:41'),(49,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2023-11-11',NULL,NULL,49,NULL,'2026-09-20 11:06:44','2026-09-20 11:06:44'),(50,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-05-11',NULL,NULL,50,NULL,'2026-09-20 11:06:45','2026-09-20 11:06:45'),(51,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2024-10-12',NULL,NULL,51,NULL,'2026-09-20 11:06:47','2026-09-20 11:06:47'),(52,'Taux de réalisation des études (%)','%',NULL,100.00,80.00,'2025-11-15',NULL,NULL,52,NULL,'2026-09-20 11:06:51','2026-09-20 11:06:51'),(53,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,40.00,'2026-05-15',NULL,NULL,53,NULL,'2026-09-20 11:06:51','2026-09-20 11:06:51'),(54,'Taux de réalisation des études (%)','%',NULL,100.00,75.00,'2025-02-19',NULL,NULL,54,NULL,'2026-09-20 11:06:53','2026-09-20 11:06:53'),(55,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2025-11-23',NULL,NULL,55,NULL,'2026-09-20 11:06:54','2026-09-20 11:06:54'),(56,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,0.00,'2026-05-23',NULL,NULL,56,NULL,'2026-09-20 11:06:55','2026-09-20 11:06:55'),(57,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-08-22',NULL,NULL,57,NULL,'2026-09-20 11:06:56','2026-09-20 11:06:56'),(58,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2023-12-10',NULL,NULL,58,NULL,'2026-09-20 11:06:58','2026-09-20 11:06:58'),(59,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-06-10',NULL,NULL,59,NULL,'2026-09-20 11:06:59','2026-09-20 11:06:59'),(60,'Taux de réalisation des études (%)','%',NULL,100.00,70.00,'2025-12-04',NULL,NULL,60,NULL,'2026-09-20 11:07:01','2026-09-20 11:07:01'),(61,'Taux de réalisation des études (%)','%',NULL,100.00,80.00,'2025-12-08',NULL,NULL,61,NULL,'2026-09-20 11:07:02','2026-09-20 11:07:02'),(62,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,40.00,'2026-06-08',NULL,NULL,62,NULL,'2026-09-20 11:07:03','2026-09-20 11:07:03'),(63,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-09-04',NULL,NULL,63,NULL,'2026-09-20 11:07:04','2026-09-20 11:07:04'),(64,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2023-12-30',NULL,NULL,64,NULL,'2026-09-20 11:07:09','2026-09-20 11:07:09'),(65,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-06-30',NULL,NULL,65,NULL,'2026-09-20 11:07:09','2026-09-20 11:07:09'),(66,'Taux de réalisation des études (%)','%',NULL,100.00,50.00,'2024-11-22',NULL,NULL,66,NULL,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(67,'Taux de réalisation des études (%)','%',NULL,100.00,60.00,'2025-12-24',NULL,NULL,67,NULL,'2026-09-20 11:07:12','2026-09-20 11:07:12'),(68,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,20.00,'2026-06-24',NULL,NULL,68,NULL,'2026-09-20 11:07:13','2026-09-20 11:07:13'),(69,'Taux de réalisation des études (%)','%',NULL,100.00,55.00,'2025-03-28',NULL,NULL,69,NULL,'2026-09-20 11:07:15','2026-09-20 11:07:15'),(70,'Taux de réalisation des études (%)','%',NULL,100.00,80.00,'2026-01-01',NULL,NULL,70,NULL,'2026-09-20 11:07:17','2026-09-20 11:07:17'),(71,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,40.00,'2026-07-01',NULL,NULL,71,NULL,'2026-09-20 11:07:17','2026-09-20 11:07:17'),(72,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-09-22',NULL,NULL,72,NULL,'2026-09-20 11:07:19','2026-09-20 11:07:19'),(73,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2024-01-29',NULL,NULL,73,NULL,'2026-09-20 11:07:22','2026-09-20 11:07:22'),(74,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-07-29',NULL,NULL,74,NULL,'2026-09-20 11:07:23','2026-09-20 11:07:23'),(75,'Taux de réalisation des études (%)','%',NULL,100.00,50.00,'2026-01-13',NULL,NULL,75,NULL,'2026-09-20 11:07:25','2026-09-20 11:07:25'),(76,'Taux de réalisation des études (%)','%',NULL,100.00,60.00,'2026-01-17',NULL,NULL,76,NULL,'2026-09-20 11:07:27','2026-09-20 11:07:27'),(77,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,20.00,'2026-07-17',NULL,NULL,77,NULL,'2026-09-20 11:07:27','2026-09-20 11:07:27'),(78,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-10-03',NULL,NULL,78,NULL,'2026-09-20 11:07:29','2026-09-20 11:07:29'),(79,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2024-02-19',NULL,NULL,79,NULL,'2026-09-20 11:07:30','2026-09-20 11:07:30'),(80,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-08-19',NULL,NULL,80,NULL,'2026-09-20 11:07:31','2026-09-20 11:07:31'),(81,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2024-12-31',NULL,NULL,81,NULL,'2026-09-20 11:07:32','2026-09-20 11:07:32'),(82,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2026-02-03',NULL,NULL,82,NULL,'2026-09-20 11:07:34','2026-09-20 11:07:34'),(83,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,0.00,'2026-08-03',NULL,NULL,83,NULL,'2026-09-20 11:07:34','2026-09-20 11:07:34'),(84,'Taux de réalisation des études (%)','%',NULL,100.00,65.00,'2025-05-07',NULL,NULL,84,NULL,'2026-09-20 11:07:35','2026-09-20 11:07:35'),(85,'Taux de réalisation des études (%)','%',NULL,100.00,60.00,'2026-02-11',NULL,NULL,85,NULL,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(86,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,20.00,'2026-08-11',NULL,NULL,86,NULL,'2026-09-20 11:07:37','2026-09-20 11:07:37'),(87,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-10-21',NULL,NULL,87,NULL,'2026-09-20 11:07:38','2026-09-20 11:07:38'),(88,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2024-03-18',NULL,NULL,88,NULL,'2026-09-20 11:07:39','2026-09-20 11:07:39'),(89,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-09-18',NULL,NULL,89,NULL,'2026-09-20 11:07:40','2026-09-20 11:07:40'),(90,'Taux de réalisation des études (%)','%',NULL,100.00,90.00,'2026-02-23',NULL,NULL,90,NULL,'2026-09-20 11:07:41','2026-09-20 11:07:41'),(91,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2026-02-27',NULL,NULL,91,NULL,'2026-09-20 11:07:45','2026-09-20 11:07:45'),(92,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,0.00,'2026-08-27',NULL,NULL,92,NULL,'2026-09-20 11:07:46','2026-09-20 11:07:46'),(93,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-11-03',NULL,NULL,93,NULL,'2026-09-20 11:07:47','2026-09-20 11:07:47'),(94,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2024-04-08',NULL,NULL,94,NULL,'2026-09-20 11:07:49','2026-09-20 11:07:49'),(95,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-10-08',NULL,NULL,95,NULL,'2026-09-20 11:07:50','2026-09-20 11:07:50'),(96,'Taux de réalisation des études (%)','%',NULL,100.00,50.00,'2025-02-10',NULL,NULL,96,NULL,'2026-09-20 11:07:53','2026-09-20 11:07:53'),(97,'Taux de réalisation des études (%)','%',NULL,100.00,80.00,'2026-03-12',NULL,NULL,97,NULL,'2026-09-20 11:07:57','2026-09-20 11:07:57'),(98,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,40.00,'2026-09-12',NULL,NULL,98,NULL,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(99,'Taux de réalisation des études (%)','%',NULL,100.00,75.00,'2025-06-16',NULL,NULL,99,NULL,'2026-09-20 11:07:59','2026-09-20 11:07:59'),(100,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2026-03-20',NULL,NULL,100,NULL,'2026-09-20 11:08:02','2026-09-20 11:08:02'),(101,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,0.00,'2026-09-20',NULL,NULL,101,NULL,'2026-09-20 11:08:02','2026-09-20 11:08:02'),(102,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-11-21',NULL,NULL,102,NULL,'2026-09-20 11:08:05','2026-09-20 11:08:05'),(103,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2024-05-07',NULL,NULL,103,NULL,'2026-09-20 11:08:07','2026-09-20 11:08:07'),(104,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-11-07',NULL,NULL,104,NULL,'2026-09-20 11:08:08','2026-09-20 11:08:08'),(105,'Taux de réalisation des études (%)','%',NULL,100.00,70.00,'2026-04-02',NULL,NULL,105,NULL,'2026-09-20 11:08:11','2026-09-20 11:08:11'),(106,'Taux de réalisation des études (%)','%',NULL,100.00,80.00,'2026-04-06',NULL,NULL,106,NULL,'2026-09-20 11:08:18','2026-09-20 11:08:18'),(107,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,40.00,'2026-10-06',NULL,NULL,107,NULL,'2026-09-20 11:08:19','2026-09-20 11:08:19'),(108,'Taux de réalisation des études (%)','%',NULL,100.00,20.00,'2027-12-02',NULL,NULL,108,NULL,'2026-09-20 11:08:22','2026-09-20 11:08:22'),(109,'Taux de réalisation des études (%)','%',NULL,100.00,100.00,'2024-05-27',NULL,NULL,109,NULL,'2026-09-20 11:08:25','2026-09-20 11:08:25'),(110,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,80.00,'2024-11-27',NULL,NULL,110,NULL,'2026-09-20 11:08:26','2026-09-20 11:08:26'),(111,'Taux de réalisation des études (%)','%',NULL,100.00,40.00,'2025-03-19',NULL,NULL,111,NULL,'2026-09-20 11:08:36','2026-09-20 11:08:36'),(112,'Taux de réalisation des études (%)','%',NULL,100.00,60.00,'2026-04-22',NULL,NULL,112,NULL,'2026-09-20 11:08:40','2026-09-20 11:08:40'),(113,'Taux de réalisation physique des travaux (%)','%',NULL,100.00,20.00,'2026-10-22',NULL,NULL,113,NULL,'2026-09-20 11:08:41','2026-09-20 11:08:41');
/*!40000 ALTER TABLE `indicateurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marches`
--

DROP TABLE IF EXISTS `marches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `objet` varchar(255) NOT NULL,
  `etat` varchar(255) DEFAULT NULL,
  `duree` varchar(255) DEFAULT NULL,
  `cout` decimal(18,2) DEFAULT NULL,
  `montant_engage` decimal(18,2) NOT NULL DEFAULT 0.00,
  `montant_liquide` decimal(18,2) NOT NULL DEFAULT 0.00,
  `montant_paye` decimal(18,2) NOT NULL DEFAULT 0.00,
  `restes_a_engager` decimal(18,2) DEFAULT NULL,
  `charges_a_payer` decimal(18,2) DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `marches_projet_id_foreign` (`projet_id`),
  CONSTRAINT `marches_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marches`
--

LOCK TABLES `marches` WRITE;
/*!40000 ALTER TABLE `marches` DISABLE KEYS */;
/*!40000 ALTER TABLE `marches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'2025_01_01_000001_create_types_structure_table',1),(3,'2025_01_01_000002_create_structures_table',1),(4,'2025_01_01_000003_create_secteurs_table',1),(5,'2025_01_01_000004_create_zones_localisation_table',1),(6,'2025_01_01_000005_create_etats_table',1),(7,'2025_01_01_000006_create_types_bailleur_table',1),(8,'2025_01_01_000007_create_bailleurs_table',1),(9,'2025_01_01_000008_create_programmes_table',1),(10,'2025_01_01_000009_create_fiches_pip_table',1),(11,'2025_01_01_000010_create_projets_table',1),(12,'2025_01_01_000011_create_fiche_pip_projet_table',1),(13,'2025_01_01_000012_create_depenses_table',1),(14,'2025_01_01_000013_create_activites_table',1),(15,'2025_01_01_000014_create_taches_table',1),(16,'2025_01_01_000015_create_indicateurs_table',1),(17,'2025_01_01_000016_create_financements_table',1),(18,'2025_01_01_000017_create_decaissements_table',1),(19,'2025_01_01_000018_create_rapports_table',1),(20,'2025_01_01_000020_create_documents_table',1),(21,'2026_01_01_000001_create_composantes_table',1),(22,'2026_01_01_000002_add_composante_id_to_activites_table',1),(23,'2026_01_01_000003_create_risques_table',1),(24,'2026_01_01_000004_create_parties_prenantes_table',1),(25,'2026_01_01_000005_create_cibles_table',1),(26,'2026_01_01_000006_create_etudes_table',1),(27,'2026_01_01_000007_create_charges_recurrentes_table',1),(28,'2026_01_01_000008_create_marches_table',1),(29,'2026_01_01_000009_create_objectifs_specifiques_table',1),(30,'2026_01_01_000010_create_conventions_financement_table',1),(31,'2026_01_01_000011_create_axes_table',1),(32,'2026_01_01_000012_add_axe_id_to_projets_table',1),(33,'2026_01_01_000013_create_reformes_table',1),(34,'2026_01_01_000014_add_cahier_des_charges_fields_to_projets_table',1),(35,'2026_01_01_000015_create_types_objectif_table',1),(36,'2026_01_01_000016_create_objectifs_table',1),(37,'2026_01_01_000017_create_resultats_attendus_table',1),(38,'2026_01_01_000018_create_budgets_table',1),(39,'2026_01_01_000019_create_portefeuilles_table',1),(40,'2026_01_01_000020_create_comites_projet_table',1),(41,'2026_01_01_000021_create_criteres_evaluation_table',1),(42,'2026_01_01_000022_create_opportunites_emploi_table',1),(43,'2026_01_01_000023_add_new_fields_to_projets_table',1),(44,'2026_01_01_000024_create_types_partie_prenante_table',1),(45,'2026_01_01_000025_create_types_analyse_causale_table',1),(46,'2026_01_01_000026_create_analyses_causales_table',1),(47,'2026_01_01_000027_create_groupes_acteur_table',1),(48,'2026_01_01_000028_create_acteurs_table',1),(49,'2026_01_01_000029_add_type_source_to_financements_table',1),(50,'2026_01_01_000030_create_echeanciers_ae_cp_table',1),(51,'2026_01_01_000031_add_fields_to_indicateurs_table',1),(52,'2026_01_01_000032_extend_zones_localisation_type_enum',1),(53,'2026_01_01_000033_add_produit_to_resultats_attendus_table',1),(54,'2026_01_01_000033_create_pays_etrangers_table',1),(55,'2026_01_01_000034_rebuild_geo_hierarchy_tables',1),(56,'2026_01_01_000035_align_zones_execution_with_cahier',1),(57,'2026_01_01_000036_projet_zone_execution_many_to_many',1),(58,'2026_01_01_000037_create_milieux_execution_table',1),(59,'2026_01_01_000038_create_actions_pnd_table',1),(60,'2026_01_01_000039_create_types_document_and_align_documents',1),(61,'2026_01_01_000040_consolidate_objectif_into_objectif_specifique',1),(62,'2026_01_01_000041_align_parties_prenantes_with_cahier',1),(63,'2026_01_01_000042_add_missing_fields_to_marches_table',1),(64,'2026_01_01_000043_add_missing_fields_to_financements_table',1),(65,'2026_01_01_000044_drop_etat_entity',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `milieux_execution`
--

DROP TABLE IF EXISTS `milieux_execution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `milieux_execution` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `categorie` enum('rural','urbain','peri_urbain','inter_urbain') NOT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `milieux_execution_projet_id_foreign` (`projet_id`),
  CONSTRAINT `milieux_execution_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `milieux_execution`
--

LOCK TABLES `milieux_execution` WRITE;
/*!40000 ALTER TABLE `milieux_execution` DISABLE KEYS */;
INSERT INTO `milieux_execution` VALUES (1,'rural',75,'2026-09-23 00:54:16','2026-09-23 00:54:16');
/*!40000 ALTER TABLE `milieux_execution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `objectifs_specifiques`
--

DROP TABLE IF EXISTS `objectifs_specifiques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `objectifs_specifiques` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `objectifs_specifiques_projet_id_foreign` (`projet_id`),
  CONSTRAINT `objectifs_specifiques_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `objectifs_specifiques`
--

LOCK TABLES `objectifs_specifiques` WRITE;
/*!40000 ALTER TABLE `objectifs_specifiques` DISABLE KEYS */;
/*!40000 ALTER TABLE `objectifs_specifiques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `opportunites_emploi`
--

DROP TABLE IF EXISTS `opportunites_emploi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opportunites_emploi` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type_emploi` enum('direct','indirect') NOT NULL,
  `phase` enum('realisation','exploitation') NOT NULL,
  `nombre_emplois_prevus` int(10) unsigned DEFAULT NULL,
  `duree_activite_previsionnelle` int(10) unsigned DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `opportunites_emploi_projet_id_foreign` (`projet_id`),
  CONSTRAINT `opportunites_emploi_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opportunites_emploi`
--

LOCK TABLES `opportunites_emploi` WRITE;
/*!40000 ALTER TABLE `opportunites_emploi` DISABLE KEYS */;
/*!40000 ALTER TABLE `opportunites_emploi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `parties_prenantes`
--

DROP TABLE IF EXISTS `parties_prenantes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `parties_prenantes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) DEFAULT NULL,
  `sig` varchar(255) DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `type_partie_prenante_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parties_prenantes_projet_id_foreign` (`projet_id`),
  KEY `parties_prenantes_type_partie_prenante_id_foreign` (`type_partie_prenante_id`),
  CONSTRAINT `parties_prenantes_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `parties_prenantes_type_partie_prenante_id_foreign` FOREIGN KEY (`type_partie_prenante_id`) REFERENCES `types_partie_prenante` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `parties_prenantes`
--

LOCK TABLES `parties_prenantes` WRITE;
/*!40000 ALTER TABLE `parties_prenantes` DISABLE KEYS */;
/*!40000 ALTER TABLE `parties_prenantes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pays_etrangers`
--

DROP TABLE IF EXISTS `pays_etrangers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pays_etrangers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pays_etrangers_libelle_unique` (`libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pays_etrangers`
--

LOCK TABLES `pays_etrangers` WRITE;
/*!40000 ALTER TABLE `pays_etrangers` DISABLE KEYS */;
/*!40000 ALTER TABLE `pays_etrangers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portefeuilles`
--

DROP TABLE IF EXISTS `portefeuilles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portefeuilles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `appartenance_pnd` tinyint(1) NOT NULL DEFAULT 0,
  `libelle_associe` varchar(255) DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `portefeuilles_projet_id_foreign` (`projet_id`),
  CONSTRAINT `portefeuilles_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portefeuilles`
--

LOCK TABLES `portefeuilles` WRITE;
/*!40000 ALTER TABLE `portefeuilles` DISABLE KEYS */;
/*!40000 ALTER TABLE `portefeuilles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `programmes`
--

DROP TABLE IF EXISTS `programmes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `programmes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `libelle` varchar(255) DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `structure_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `programmes_code_unique` (`code`),
  KEY `programmes_structure_id_foreign` (`structure_id`),
  CONSTRAINT `programmes_structure_id_foreign` FOREIGN KEY (`structure_id`) REFERENCES `structures` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `programmes`
--

LOCK TABLES `programmes` WRITE;
/*!40000 ALTER TABLE `programmes` DISABLE KEYS */;
INSERT INTO `programmes` VALUES (1,'Programme National de Développement des Infrastructures et du Transport','PNDIT 2026-2030','PROG-2026-001','2026-01-01','2030-12-31',1,'2026-09-20 11:05:41','2026-09-20 11:05:41'),(2,'Programme Régional de Renforcement de l\'Offre Éducative','PRROE 2026-2028','PROG-2026-002','2026-01-01','2028-12-31',10,'2026-09-20 11:05:41','2026-09-20 11:05:41'),(3,'Programme de Couverture Sanitaire Universelle des Régions','PCSUR 2026-2029','PROG-2026-003','2026-01-01','2029-12-31',17,'2026-09-20 11:05:42','2026-09-20 11:05:42');
/*!40000 ALTER TABLE `programmes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projet_zone_execution`
--

DROP TABLE IF EXISTS `projet_zone_execution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projet_zone_execution` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `projet_id` bigint(20) unsigned NOT NULL,
  `zone_localisation_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projet_zone_unique` (`projet_id`,`zone_localisation_id`),
  KEY `projet_zone_execution_zone_localisation_id_foreign` (`zone_localisation_id`),
  CONSTRAINT `projet_zone_execution_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `projet_zone_execution_zone_localisation_id_foreign` FOREIGN KEY (`zone_localisation_id`) REFERENCES `zones_localisation` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projet_zone_execution`
--

LOCK TABLES `projet_zone_execution` WRITE;
/*!40000 ALTER TABLE `projet_zone_execution` DISABLE KEYS */;
INSERT INTO `projet_zone_execution` VALUES (1,1,2,NULL,NULL),(2,2,3,NULL,NULL),(3,3,4,NULL,NULL),(4,4,5,NULL,NULL),(5,5,6,NULL,NULL),(6,6,7,NULL,NULL),(7,7,8,NULL,NULL),(8,8,9,NULL,NULL),(9,9,2,NULL,NULL),(10,10,10,NULL,NULL),(11,11,11,NULL,NULL),(12,12,11,NULL,NULL),(13,13,12,NULL,NULL),(14,14,13,NULL,NULL),(15,15,14,NULL,NULL),(16,16,15,NULL,NULL),(17,17,16,NULL,NULL),(18,18,17,NULL,NULL),(19,19,18,NULL,NULL),(20,20,15,NULL,NULL),(21,21,15,NULL,NULL),(22,22,17,NULL,NULL),(23,23,19,NULL,NULL),(24,24,2,NULL,NULL),(25,25,15,NULL,NULL),(26,26,8,NULL,NULL),(27,27,18,NULL,NULL),(28,28,20,NULL,NULL),(29,29,15,NULL,NULL),(30,30,16,NULL,NULL),(31,31,21,NULL,NULL),(32,32,18,NULL,NULL),(33,33,22,NULL,NULL),(34,34,23,NULL,NULL),(35,35,11,NULL,NULL),(36,36,15,NULL,NULL),(37,37,18,NULL,NULL),(38,38,10,NULL,NULL),(39,39,23,NULL,NULL),(40,40,20,NULL,NULL),(41,41,24,NULL,NULL),(42,42,17,NULL,NULL),(43,43,25,NULL,NULL),(44,44,12,NULL,NULL),(45,45,26,NULL,NULL),(46,46,27,NULL,NULL),(47,47,28,NULL,NULL),(48,48,23,NULL,NULL),(49,49,28,NULL,NULL),(50,50,6,NULL,NULL),(51,51,20,NULL,NULL),(52,52,20,NULL,NULL),(53,53,6,NULL,NULL),(54,54,11,NULL,NULL),(55,55,29,NULL,NULL),(56,56,3,NULL,NULL),(57,57,30,NULL,NULL),(58,58,16,NULL,NULL),(59,59,8,NULL,NULL),(60,60,31,NULL,NULL),(61,61,32,NULL,NULL),(62,62,33,NULL,NULL),(63,63,34,NULL,NULL),(64,64,35,NULL,NULL),(65,65,36,NULL,NULL),(66,66,37,NULL,NULL),(67,67,38,NULL,NULL),(68,68,39,NULL,NULL),(69,69,40,NULL,NULL),(70,70,41,NULL,NULL),(71,71,42,NULL,NULL),(72,72,43,NULL,NULL),(73,73,44,NULL,NULL),(74,74,45,NULL,NULL),(75,75,46,NULL,NULL);
/*!40000 ALTER TABLE `projet_zone_execution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projets`
--

DROP TABLE IF EXISTS `projets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `projets` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `reference` varchar(255) NOT NULL,
  `code_pip` varchar(255) DEFAULT NULL,
  `intitule` varchar(255) NOT NULL,
  `contexte` text DEFAULT NULL,
  `objectif` text DEFAULT NULL,
  `cout_estimatif` decimal(18,2) NOT NULL DEFAULT 0.00,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `avancement_physique` tinyint(3) unsigned NOT NULL DEFAULT 0,
  `statut` enum('planifie','en_cours','termine','suspendu','retarde') NOT NULL DEFAULT 'planifie',
  `maitre_ouvrage` varchar(255) DEFAULT NULL,
  `maitre_ouvrage_delegue` varchar(255) DEFAULT NULL,
  `maitre_oeuvre` varchar(255) DEFAULT NULL,
  `duree_prevue` varchar(255) DEFAULT NULL,
  `programme_budgetaire` varchar(255) DEFAULT NULL,
  `odd_concerne` varchar(255) DEFAULT NULL,
  `domaine_impact_socio_eco` varchar(255) DEFAULT NULL,
  `type_projet` enum('investissement','routine') NOT NULL DEFAULT 'investissement',
  `cible_trimestre_1` varchar(255) DEFAULT NULL,
  `cible_trimestre_2` varchar(255) DEFAULT NULL,
  `cible_trimestre_3` varchar(255) DEFAULT NULL,
  `cible_trimestre_4` varchar(255) DEFAULT NULL,
  `code_pjgouv` varchar(255) DEFAULT NULL,
  `code_psgouv` varchar(255) DEFAULT NULL,
  `appartenance` varchar(255) DEFAULT NULL,
  `probleme` text DEFAULT NULL,
  `attentes_projet` text DEFAULT NULL,
  `craintes_projet` text DEFAULT NULL,
  `taille` varchar(255) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `structure_id` bigint(20) unsigned NOT NULL,
  `secteur_id` bigint(20) unsigned NOT NULL,
  `axe_id` bigint(20) unsigned DEFAULT NULL,
  `action_pnd_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projets_reference_unique` (`reference`),
  KEY `projets_structure_id_foreign` (`structure_id`),
  KEY `projets_secteur_id_foreign` (`secteur_id`),
  KEY `projets_axe_id_foreign` (`axe_id`),
  KEY `projets_action_pnd_id_foreign` (`action_pnd_id`),
  CONSTRAINT `projets_action_pnd_id_foreign` FOREIGN KEY (`action_pnd_id`) REFERENCES `actions_pnd` (`id`) ON DELETE SET NULL,
  CONSTRAINT `projets_axe_id_foreign` FOREIGN KEY (`axe_id`) REFERENCES `axes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `projets_secteur_id_foreign` FOREIGN KEY (`secteur_id`) REFERENCES `secteurs` (`id`),
  CONSTRAINT `projets_structure_id_foreign` FOREIGN KEY (`structure_id`) REFERENCES `structures` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projets`
--

LOCK TABLES `projets` WRITE;
/*!40000 ALTER TABLE `projets` DISABLE KEYS */;
INSERT INTO `projets` VALUES (1,'PIP-CI-2026-001',NULL,'Aménager et bitumer la route M\'Batto-Afféry (40 km)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Moronou.','Contribuer au développement du secteur « Infrastructures » dans la zone de Moronou, conformément aux orientations du PIP régional.',250000000.00,'2025-03-01','2027-03-01',20,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,17,NULL,NULL,'2026-09-20 11:05:42','2026-09-20 11:05:42'),(2,'PIP-CI-2026-002',NULL,'Aménager et bitumer la route Tiémé- N\'Globlasso - Goulia (57km)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Kabadougou.','Contribuer au développement du secteur « Infrastructures » dans la zone de Kabadougou, conformément aux orientations du PIP régional.',1850000000.00,'2027-01-04','2028-07-04',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,17,NULL,NULL,'2026-09-20 11:05:46','2026-09-20 11:05:46'),(3,'PIP-CI-2026-003',NULL,'Construire des parkings publics et souterrains dans les zones commerciales et administratives','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Songon.','Contribuer au développement du secteur « Transport » dans la zone de Songon, conformément aux orientations du PIP régional.',3450000000.00,'2023-02-11','2024-10-11',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,29,NULL,NULL,'2026-09-20 11:05:48','2026-09-20 11:05:48'),(4,'PIP-CI-2026-004',NULL,'Développer un réseau cyclable sécurisé et des pistes piétonnes','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Yopougon.','Contribuer au développement du secteur « Transport » dans la zone de Yopougon, conformément aux orientations du PIP régional.',5050000000.00,'2024-02-13','2025-05-13',30,'retarde',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,29,NULL,NULL,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(5,'PIP-CI-2026-005',NULL,'Construire 12 sites radioélectriques à Andobo-Alluibo, Assekakro, Besseri-Takikro, Bobokro, Djigbe, Fari-Oko, Iki, Kirakro, Koyorabo, Monebo, Plahankro, Zédé-Kan','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gbêkê.','Contribuer au développement du secteur « Transition Numérique » dans la zone de Gbêkê, conformément aux orientations du PIP régional.',6650000000.00,'2025-03-17','2027-03-17',60,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,28,NULL,NULL,'2026-09-20 11:05:52','2026-09-20 11:05:52'),(6,'PIP-CI-2026-006',NULL,'Poursuivre la digitalisation du processus d\'obtention des extraits de casier judiciaire, des certificats de nationalité et autres documents administratifs','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Treichville.','Contribuer au développement du secteur « Transition Numérique » dans la zone de Treichville, conformément aux orientations du PIP régional.',1650000000.00,'2024-06-21','2026-02-21',55,'suspendu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,3,28,NULL,NULL,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(7,'PIP-CI-2026-007',NULL,'Etendre le parc de zones d\'activité industrielle','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Tonkpi.','Contribuer au développement du secteur « Industrie » dans la zone de Tonkpi, conformément aux orientations du PIP régional.',3250000000.00,'2025-03-25','2027-03-25',20,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,16,NULL,NULL,'2026-09-20 11:05:54','2026-09-20 11:05:54'),(8,'PIP-CI-2026-008',NULL,'Aménager la zone industrielle de Dabou','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Grands-Ponts.','Contribuer au développement du secteur « Industrie » dans la zone de Grands-Ponts, conformément aux orientations du PIP régional.',4850000000.00,'2027-01-22','2028-07-22',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,16,NULL,NULL,'2026-09-20 11:05:56','2026-09-20 11:05:56'),(9,'PIP-CI-2026-009',NULL,'Construire des marchés de proximité','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Moronou.','Contribuer au développement du secteur « Commerce » dans la zone de Moronou, conformément aux orientations du PIP régional.',6450000000.00,'2023-03-13','2024-11-13',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,4,NULL,NULL,'2026-09-20 11:05:57','2026-09-20 11:05:57'),(10,'PIP-CI-2026-010',NULL,'Créer une unité Satellite de transformation de noix de cajou (1500T) à Zuénoula','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Marahoué.','Contribuer au développement du secteur « Commerce » dans la zone de Marahoué, conformément aux orientations du PIP régional.',1450000000.00,'2025-04-06','2027-04-06',50,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,4,NULL,NULL,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(11,'PIP-CI-2026-011',NULL,'Promouvoir des activités artisanales à travers l\'appui logistique aux associations locales et la valorisation des savoir-faire traditionnels','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gbôklé.','Contribuer au développement du secteur « Artisanat » dans la zone de Gbôklé, conformément aux orientations du PIP régional.',3050000000.00,'2025-04-10','2027-04-10',60,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,2,NULL,NULL,'2026-09-20 11:05:59','2026-09-20 11:05:59'),(12,'PIP-CI-2026-012',NULL,'Poursuivre la formation de 500 artisans','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gbôklé.','Contribuer au développement du secteur « Artisanat » dans la zone de Gbôklé, conformément aux orientations du PIP régional.',4650000000.00,'2027-02-03','2028-08-03',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,2,NULL,NULL,'2026-09-20 11:06:02','2026-09-20 11:06:02'),(13,'PIP-CI-2026-013',NULL,'Mettre en œuvre le projet Clonix PHASE-II','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gôh.','Contribuer au développement du secteur « Promotion des PME » dans la zone de Gôh, conformément aux orientations du PIP régional.',6250000000.00,'2023-04-02','2024-12-02',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,22,NULL,NULL,'2026-09-20 11:06:03','2026-09-20 11:06:03'),(14,'PIP-CI-2026-014',NULL,'Mettre en place des microcrédits et programmes d\'accompagnement financier pour jeunes et femmes entrepreneures','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Attécoubé.','Contribuer au développement du secteur « Promotion des PME » dans la zone de Attécoubé, conformément aux orientations du PIP régional.',1250000000.00,'2024-03-24','2025-06-24',20,'retarde',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,22,NULL,NULL,'2026-09-20 11:06:05','2026-09-20 11:06:05'),(15,'PIP-CI-2026-015',NULL,'Construire une salle de sport semi-couverte au Lycée Moderne d\'Adzopé et d\'Alépé','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de La Mé.','Contribuer au développement du secteur « Sport » dans la zone de La Mé, conformément aux orientations du PIP régional.',2850000000.00,'2025-04-26','2027-04-26',40,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,26,NULL,NULL,'2026-09-20 11:06:08','2026-09-20 11:06:08'),(16,'PIP-CI-2026-016',NULL,'Construire deux (02) salles de sports sémi-couverte dans le Lycée Moderne Koumassi 2 et le Lycée Moderne de Treichville','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de District Autonome d\'Abidjan.','Contribuer au développement du secteur « Sport » dans la zone de District Autonome d\'Abidjan, conformément aux orientations du PIP régional.',4450000000.00,'2024-07-31','2026-03-31',35,'suspendu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,5,26,NULL,NULL,'2026-09-20 11:06:10','2026-09-20 11:06:10'),(17,'PIP-CI-2026-017',NULL,'Promouvoir l\'autonomisation économique des femmes par la formation et le microcrédit','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Port-Bouët.','Contribuer au développement du secteur « Femme, Famille et Enfant » dans la zone de Port-Bouët, conformément aux orientations du PIP régional.',6050000000.00,'2025-05-04','2027-05-04',60,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,11,NULL,NULL,'2026-09-20 11:06:11','2026-09-20 11:06:11'),(18,'PIP-CI-2026-018',NULL,'Réhabiliter et équiper l\'IFEF de Boundiali','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Bagoué.','Contribuer au développement du secteur « Femme, Famille et Enfant » dans la zone de Bagoué, conformément aux orientations du PIP régional.',1050000000.00,'2027-02-21','2028-08-21',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,11,NULL,NULL,'2026-09-20 11:06:13','2026-09-20 11:06:13'),(19,'PIP-CI-2026-019',NULL,'Construire et équiper le tribunal du commerce de Daloa','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Haut-Sassandra.','Contribuer au développement du secteur « Justice et Droits de l\'Homme » dans la zone de Haut-Sassandra, conformément aux orientations du PIP régional.',2650000000.00,'2023-05-02','2025-01-02',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,7,20,NULL,NULL,'2026-09-20 11:06:14','2026-09-20 11:06:14'),(20,'PIP-CI-2026-020',NULL,'Construire et équiper une nouvelle MAC et sa cité pénitentiaire à Bingerville','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de District Autonome d\'Abidjan.','Contribuer au développement du secteur « Justice et Droits de l\'Homme » dans la zone de District Autonome d\'Abidjan, conformément aux orientations du PIP régional.',4250000000.00,'2025-05-16','2027-05-16',30,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,7,20,NULL,NULL,'2026-09-20 11:06:16','2026-09-20 11:06:16'),(21,'PIP-CI-2026-021',NULL,'Alimenter la zone sud d\'Abidjan à partir de la nappe du Sud Comoé - phase 3','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de District Autonome d\'Abidjan.','Contribuer au développement du secteur « Hydraulique » dans la zone de District Autonome d\'Abidjan, conformément aux orientations du PIP régional.',5850000000.00,'2025-05-20','2027-05-20',40,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,8,15,NULL,NULL,'2026-09-20 11:06:18','2026-09-20 11:06:18'),(22,'PIP-CI-2026-022',NULL,'Mettre en œuvre un programme d\'accès à l\'eau dans les écoles et centres de santé','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Bagoué.','Contribuer au développement du secteur « Hydraulique » dans la zone de Bagoué, conformément aux orientations du PIP régional.',850000000.00,'2027-03-05','2028-09-05',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,8,15,NULL,NULL,'2026-09-20 11:06:20','2026-09-20 11:06:20'),(23,'PIP-CI-2026-023',NULL,'Construire deux-cent cinquante (250) cantines scolaires dans deux-cent cinquante (250) gros villages de la région','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Bafing.','Contribuer au développement du secteur « Éducation » dans la zone de Bafing, conformément aux orientations du PIP régional.',2450000000.00,'2023-05-22','2025-01-22',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,10,30,NULL,NULL,'2026-09-20 11:06:21','2026-09-20 11:06:21'),(24,'PIP-CI-2026-024',NULL,'Construire et équiper 12 collèges sur la période 2026-2028','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Moronou.','Contribuer au développement du secteur « Éducation » dans la zone de Moronou, conformément aux orientations du PIP régional.',4050000000.00,'2024-05-03','2025-08-03',30,'retarde',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,10,30,NULL,NULL,'2026-09-20 11:06:23','2026-09-20 11:06:23'),(25,'PIP-CI-2026-025',NULL,'Poursuivre la réhabilitation et équipement Centre Recherches Océanographiques (CRO)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de District Autonome d\'Abidjan.','Contribuer au développement du secteur « Enseignement Supérieur et Recherche Scientifique » dans la zone de District Autonome d\'Abidjan, conformément aux orientations du PIP régional.',5650000000.00,'2025-06-05','2027-06-05',20,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,11,8,NULL,NULL,'2026-09-20 11:06:24','2026-09-20 11:06:24'),(26,'PIP-CI-2026-026',NULL,'Étendre les infrastructures de l\'Université de Man','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Tonkpi.','Contribuer au développement du secteur « Enseignement Supérieur et Recherche Scientifique » dans la zone de Tonkpi, conformément aux orientations du PIP régional.',650000000.00,'2024-09-09','2026-05-09',45,'suspendu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,11,8,NULL,NULL,'2026-09-20 11:06:26','2026-09-20 11:06:26'),(27,'PIP-CI-2026-027',NULL,'Construire et équiper le garage école de Daloa','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Haut-Sassandra.','Contribuer au développement du secteur « Enseignement Technique et Formation Professionnelle » dans la zone de Haut-Sassandra, conformément aux orientations du PIP régional.',2250000000.00,'2025-06-13','2027-06-13',40,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12,9,NULL,NULL,'2026-09-20 11:06:29','2026-09-20 11:06:29'),(28,'PIP-CI-2026-028',NULL,'Construire un lycée professionnel agricole à Sahué sous-préfecture de Sikensi','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Agnéby-Tiassa.','Contribuer au développement du secteur « Enseignement Technique et Formation Professionnelle » dans la zone de Agnéby-Tiassa, conformément aux orientations du PIP régional.',3850000000.00,'2027-03-23','2028-09-23',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12,9,NULL,NULL,'2026-09-20 11:06:30','2026-09-20 11:06:30'),(29,'PIP-CI-2026-029',NULL,'Construire deux (2) villages d\'artisans','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de District Autonome d\'Abidjan.','Contribuer au développement du secteur « Tourisme et Loisirs » dans la zone de District Autonome d\'Abidjan, conformément aux orientations du PIP régional.',5450000000.00,'2023-06-21','2025-02-21',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,27,NULL,NULL,'2026-09-20 11:06:31','2026-09-20 11:06:31'),(30,'PIP-CI-2026-030',NULL,'Développer l\'écotourisme côtier (plages, mangroves, excursions lagunaires)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Port-Bouët.','Contribuer au développement du secteur « Tourisme et Loisirs » dans la zone de Port-Bouët, conformément aux orientations du PIP régional.',450000000.00,'2025-06-25','2027-06-25',70,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,13,27,NULL,NULL,'2026-09-20 11:06:34','2026-09-20 11:06:34'),(31,'PIP-CI-2026-031',NULL,'Mettre en œuvre le projet de pôle agro-industriel dans le nord-est de la Côte d\'Ivoire','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gontougo.','Contribuer au développement du secteur « Agriculture » dans la zone de Gontougo, conformément aux orientations du PIP régional.',2050000000.00,'2025-06-29','2027-06-29',20,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,14,1,NULL,NULL,'2026-09-20 11:06:35','2026-09-20 11:06:35'),(32,'PIP-CI-2026-032',NULL,'Créer des unités de transformation de manioc','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Haut-Sassandra.','Contribuer au développement du secteur « Agriculture » dans la zone de Haut-Sassandra, conformément aux orientations du PIP régional.',3650000000.00,'2027-04-04','2028-10-04',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,14,1,NULL,NULL,'2026-09-20 11:06:37','2026-09-20 11:06:37'),(33,'PIP-CI-2026-033',NULL,'Créer des points de vente des produits issus des élevages en développement','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de District Autonome de Yamoussoukro.','Contribuer au développement du secteur « Ressources Animales et Halieutiques » dans la zone de District Autonome de Yamoussoukro, conformément aux orientations du PIP régional.',5250000000.00,'2023-07-11','2025-03-11',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,15,24,NULL,NULL,'2026-09-20 11:06:42','2026-09-20 11:06:42'),(34,'PIP-CI-2026-034',NULL,'Installer 6 fermes aquacoles','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de San-Pédro.','Contribuer au développement du secteur « Ressources Animales et Halieutiques » dans la zone de San-Pédro, conformément aux orientations du PIP régional.',250000000.00,'2024-06-12','2025-09-12',20,'retarde',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,15,24,NULL,NULL,'2026-09-20 11:06:46','2026-09-20 11:06:46'),(35,'PIP-CI-2026-035',NULL,'Aménager et meubler le siège du Conseil régional et la résidence du directeur général de l\'administration','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gbôklé.','Contribuer au développement du secteur « Habitat et Logement » dans la zone de Gbôklé, conformément aux orientations du PIP régional.',1850000000.00,'2025-07-15','2027-07-15',60,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,16,14,NULL,NULL,'2026-09-20 11:06:48','2026-09-20 11:06:48'),(36,'PIP-CI-2026-036',NULL,'Restructurer et aménager les quartiers précaires d\'Abidjan','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de District Autonome d\'Abidjan.','Contribuer au développement du secteur « Habitat et Logement » dans la zone de District Autonome d\'Abidjan, conformément aux orientations du PIP régional.',3450000000.00,'2024-10-19','2026-06-19',55,'suspendu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,16,14,NULL,NULL,'2026-09-20 11:06:51','2026-09-20 11:06:51'),(37,'PIP-CI-2026-037',NULL,'Poursuivre la dotation des communes ne disposant pas de service délégué de propreté en matériel de salubrité','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Haut-Sassandra.','Contribuer au développement du secteur « Assainissement et Salubrité » dans la zone de Haut-Sassandra, conformément aux orientations du PIP régional.',5050000000.00,'2025-07-23','2027-07-23',20,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,9,3,NULL,NULL,'2026-09-20 11:06:53','2026-09-20 11:06:53'),(38,'PIP-CI-2026-038',NULL,'Construire un (01) Centre de Valorisation et d\'Enfouissement Technique à Bonon','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Marahoué.','Contribuer au développement du secteur « Assainissement et Salubrité » dans la zone de Marahoué, conformément aux orientations du PIP régional.',6650000000.00,'2027-04-22','2028-10-22',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,9,3,NULL,NULL,'2026-09-20 11:06:55','2026-09-20 11:06:55'),(39,'PIP-CI-2026-039',NULL,'Construire 45 ESPC dont 14 dispensaires ruraux, 21 centres de santé urbains et 10 centres de santé ruraux','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de San-Pédro.','Contribuer au développement du secteur « Santé » dans la zone de San-Pédro, conformément aux orientations du PIP régional.',1650000000.00,'2023-08-10','2025-04-10',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,17,25,NULL,NULL,'2026-09-20 11:06:57','2026-09-20 11:06:57'),(40,'PIP-CI-2026-040',NULL,'Renforcer la production d\'oxygène dans les établissements sanitaires de référence','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Agnéby-Tiassa.','Contribuer au développement du secteur « Santé » dans la zone de Agnéby-Tiassa, conformément aux orientations du PIP régional.',3250000000.00,'2025-08-04','2027-08-04',50,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,17,25,NULL,NULL,'2026-09-20 11:07:00','2026-09-20 11:07:00'),(41,'PIP-CI-2026-041',NULL,'Poursuivre la construction de la mine d\'or KONÉ, dans les départements de Kani','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Worodougou.','Contribuer au développement du secteur « Mines » dans la zone de Worodougou, conformément aux orientations du PIP régional.',4850000000.00,'2025-08-08','2027-08-08',60,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,18,21,NULL,NULL,'2026-09-20 11:07:01','2026-09-20 11:07:01'),(42,'PIP-CI-2026-042',NULL,'Poursuivre le projet minier aurifère avancé de la Bagoué (phase de développement)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Bagoué.','Contribuer au développement du secteur « Mines » dans la zone de Bagoué, conformément aux orientations du PIP régional.',6450000000.00,'2027-05-04','2028-11-04',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,18,21,NULL,NULL,'2026-09-20 11:07:03','2026-09-20 11:07:03'),(43,'PIP-CI-2026-043',NULL,'Mettre en œuvre le Projet de réalisation de la centrale solaire de Binguebougou (50 MWC)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Poro.','Contribuer au développement du secteur « Électricité » dans la zone de Poro, conformément aux orientations du PIP régional.',1450000000.00,'2023-08-30','2025-04-30',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,18,31,NULL,NULL,'2026-09-20 11:07:04','2026-09-20 11:07:04'),(44,'PIP-CI-2026-044',NULL,'Mettre en œuvre le Programme Électricité Pour Tous (PEPT) par le branchement de 400 000 ménages au niveau national dont la région du Gôh','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gôh.','Contribuer au développement du secteur « Électricité » dans la zone de Gôh, conformément aux orientations du PIP régional.',3050000000.00,'2024-07-22','2025-10-22',30,'retarde',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,18,31,NULL,NULL,'2026-09-20 11:07:09','2026-09-20 11:07:09'),(45,'PIP-CI-2026-045',NULL,'Promouvoir les arts, traditions et savoir-faire locaux (danse, artisanat, musique)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Abobo.','Contribuer au développement du secteur « Culture » dans la zone de Abobo, conformément aux orientations du PIP régional.',4650000000.00,'2025-08-24','2027-08-24',40,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,19,5,NULL,NULL,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(46,'PIP-CI-2026-046',NULL,'Développer des infrastructures touristiques (hébergements, routes d\'accès, signalétique)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Bingerville.','Contribuer au développement du secteur « Culture » dans la zone de Bingerville, conformément aux orientations du PIP régional.',6250000000.00,'2024-11-28','2026-07-28',35,'suspendu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,19,5,NULL,NULL,'2026-09-20 11:07:13','2026-09-20 11:07:13'),(47,'PIP-CI-2026-047',NULL,'Mettre en place un système de suivi-évaluation pour le suivi des projets et leur impact socio-économique','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Adjamé.','Contribuer au développement du secteur « Gouvernance Locale » dans la zone de Adjamé, conformément aux orientations du PIP régional.',1250000000.00,'2025-09-01','2027-09-01',60,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,20,13,NULL,NULL,'2026-09-20 11:07:15','2026-09-20 11:07:15'),(48,'PIP-CI-2026-048',NULL,'Construire et équiper un centre régional d\'archives','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de San-Pédro.','Contribuer au développement du secteur « Gouvernance Locale » dans la zone de San-Pédro, conformément aux orientations du PIP régional.',2850000000.00,'2027-05-22','2028-11-22',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,20,13,NULL,NULL,'2026-09-20 11:07:18','2026-09-20 11:07:18'),(49,'PIP-CI-2026-049',NULL,'Réhabiliter et équiper les services de l\'administration du travail d\'Adjamé','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Adjamé.','Contribuer au développement du secteur « Emploi et Protection Sociale » dans la zone de Adjamé, conformément aux orientations du PIP régional.',4450000000.00,'2023-09-29','2025-05-29',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,21,7,NULL,NULL,'2026-09-20 11:07:20','2026-09-20 11:07:20'),(50,'PIP-CI-2026-050',NULL,'Poursuivre l\'enrôlement au RSTI et à la CMU','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gbêkê.','Contribuer au développement du secteur « Emploi et Protection Sociale » dans la zone de Gbêkê, conformément aux orientations du PIP régional.',6050000000.00,'2025-09-13','2027-09-13',30,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,21,7,NULL,NULL,'2026-09-20 11:07:23','2026-09-20 11:07:23'),(51,'PIP-CI-2026-051',NULL,'Aménager et équiper des Crèches garderies dans les CPPE des régions non pourvues dont l\'Agnéby-Tiassa','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Agnéby-Tiassa.','Contribuer au développement du secteur « Genre et Égalité des Sexes » dans la zone de Agnéby-Tiassa, conformément aux orientations du PIP régional.',1050000000.00,'2025-09-17','2027-09-17',40,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,12,NULL,NULL,'2026-09-20 11:07:26','2026-09-20 11:07:26'),(52,'PIP-CI-2026-052',NULL,'Construire et équiper des CACE dans les sous-préfectures de la région de l\'Agnéby-Tiassa','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Agnéby-Tiassa.','Contribuer au développement du secteur « Genre et Égalité des Sexes » dans la zone de Agnéby-Tiassa, conformément aux orientations du PIP régional.',2650000000.00,'2027-06-03','2028-12-03',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,6,12,NULL,NULL,'2026-09-20 11:07:28','2026-09-20 11:07:28'),(53,'PIP-CI-2026-053',NULL,'Acquérir un bac pour la traversée à Béoumi','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gbêkê.','Contribuer au développement du secteur « Infrastructures Routières » dans la zone de Gbêkê, conformément aux orientations du PIP régional.',4250000000.00,'2023-10-19','2025-06-19',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,18,NULL,NULL,'2026-09-20 11:07:29','2026-09-20 11:07:29'),(54,'PIP-CI-2026-054',NULL,'Construire et renforcer les routes (reprofilage lourd et léger) et ouvrages','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Gbôklé.','Contribuer au développement du secteur « Infrastructures Routières » dans la zone de Gbôklé, conformément aux orientations du PIP régional.',5850000000.00,'2024-08-31','2025-12-01',20,'retarde',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,18,NULL,NULL,'2026-09-20 11:07:31','2026-09-20 11:07:31'),(55,'PIP-CI-2026-055',NULL,'Construire une caserne de sapeurs-pompiers','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Iffou.','Contribuer au développement du secteur « Défense et Sécurité » dans la zone de Iffou, conformément aux orientations du PIP régional.',850000000.00,'2025-10-03','2027-10-03',20,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,22,6,NULL,NULL,'2026-09-20 11:07:32','2026-09-20 11:07:32'),(56,'PIP-CI-2026-056',NULL,'Construire et équiper des centres de manœuvres et d\'entrainements','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Kabadougou.','Contribuer au développement du secteur « Défense et Sécurité » dans la zone de Kabadougou, conformément aux orientations du PIP régional.',2450000000.00,'2025-01-07','2026-09-07',45,'suspendu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,22,6,NULL,NULL,'2026-09-20 11:07:34','2026-09-20 11:07:34'),(57,'PIP-CI-2026-057',NULL,'Développer une brigade municipale de prévention (sécurité routière, environnement)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Koumassi.','Contribuer au développement du secteur « Protection Civile » dans la zone de Koumassi, conformément aux orientations du PIP régional.',4050000000.00,'2025-10-11','2027-10-11',40,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,23,23,NULL,NULL,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(58,'PIP-CI-2026-058',NULL,'Renforcer la vidéosurveillance et la présence policière dans les zones sensibles','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Port-Bouët.','Contribuer au développement du secteur « Protection Civile » dans la zone de Port-Bouët, conformément aux orientations du PIP régional.',5650000000.00,'2027-06-21','2028-12-21',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,23,23,NULL,NULL,'2026-09-20 11:07:37','2026-09-20 11:07:37'),(59,'PIP-CI-2026-059',NULL,'Insertion de 27 458 jeunes aux programmes d\'insertion professionnelle (2023 -2025)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Tonkpi.','Contribuer au développement du secteur « Jeunesse » dans la zone de Tonkpi, conformément aux orientations du PIP régional.',650000000.00,'2023-11-18','2025-07-18',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,24,19,NULL,NULL,'2026-09-20 11:07:38','2026-09-20 11:07:38'),(60,'PIP-CI-2026-060',NULL,'Construire et équiper 12 Agences (une dans chacune des Sous-Préfectures) types de l\'agence emploi jeunes dans la région','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Tchologo.','Contribuer au développement du secteur « Jeunesse » dans la zone de Tchologo, conformément aux orientations du PIP régional.',2250000000.00,'2025-10-23','2027-10-23',70,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,24,19,NULL,NULL,'2026-09-20 11:07:40','2026-09-20 11:07:40'),(61,'PIP-CI-2026-061',NULL,'Promouvoir l\'énergie renouvelable (solaire sur bâtiments publics et éclairage public)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Marcory.','Contribuer au développement du secteur « Environnement » dans la zone de Marcory, conformément aux orientations du PIP régional.',3850000000.00,'2025-10-27','2027-10-27',20,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,25,10,NULL,NULL,'2026-09-20 11:07:42','2026-09-20 11:07:42'),(62,'PIP-CI-2026-062',NULL,'Mettre en place des centres de traitement des eaux usées et de lutte contre les inondations','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Cocody.','Contribuer au développement du secteur « Environnement » dans la zone de Cocody, conformément aux orientations du PIP régional.',5450000000.00,'2027-07-03','2029-01-03',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,25,10,NULL,NULL,'2026-09-20 11:07:47','2026-09-20 11:07:47'),(63,'PIP-CI-2026-063',NULL,'Construire le Lycée Professionnel de Toumodi','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Bélier.','Contribuer au développement du secteur « Enseignement Technique et Formation Professionnelle » dans la zone de Bélier, conformément aux orientations du PIP régional.',450000000.00,'2023-12-08','2025-08-08',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12,9,NULL,NULL,'2026-09-20 11:07:48','2026-09-20 11:07:48'),(64,'PIP-CI-2026-064',NULL,'Aménager et bitumer la route Séguéla-Kongasso-Kounahiri (100 km)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Béré.','Contribuer au développement du secteur « Infrastructures Routières » dans la zone de Béré, conformément aux orientations du PIP régional.',2050000000.00,'2024-10-10','2026-01-10',30,'retarde',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,18,NULL,NULL,'2026-09-20 11:07:52','2026-09-20 11:07:52'),(65,'PIP-CI-2026-065',NULL,'Poursuivre la construction du Lycée d\'Excellence de jeunes filles de Bouna','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Bounkani.','Contribuer au développement du secteur « Éducation » dans la zone de Bounkani, conformément aux orientations du PIP régional.',3650000000.00,'2025-11-12','2027-11-12',60,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,10,30,NULL,NULL,'2026-09-20 11:07:54','2026-09-20 11:07:54'),(66,'PIP-CI-2026-066',NULL,'Reconstruire aux normes le marché de détail de Guiglo','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Cavally.','Contribuer au développement du secteur « Commerce » dans la zone de Cavally, conformément aux orientations du PIP régional.',5250000000.00,'2025-02-16','2026-10-16',55,'suspendu',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,4,NULL,NULL,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(67,'PIP-CI-2026-067',NULL,'Construire le pont sur l\'axe Banankoro - Manadoun','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Folon.','Contribuer au développement du secteur « Infrastructures » dans la zone de Folon, conformément aux orientations du PIP régional.',250000000.00,'2025-11-20','2027-11-20',20,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,17,NULL,NULL,'2026-09-20 11:07:59','2026-09-20 11:07:59'),(68,'PIP-CI-2026-068',NULL,'Aménager et bitumer la route Guéhiebly - Zou - Mahapleu (91 km)','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Guémon.','Contribuer au développement du secteur « Infrastructures Routières » dans la zone de Guémon, conformément aux orientations du PIP régional.',1850000000.00,'2027-07-21','2029-01-21',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,18,NULL,NULL,'2026-09-20 11:08:03','2026-09-20 11:08:03'),(69,'PIP-CI-2026-069',NULL,'Poursuivre la construction et l\'équipement du CHR de Katiola','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Hambol.','Contribuer au développement du secteur « Santé » dans la zone de Hambol, conformément aux orientations du PIP régional.',3450000000.00,'2024-01-07','2025-09-07',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,17,25,NULL,NULL,'2026-09-20 11:08:06','2026-09-20 11:08:06'),(70,'PIP-CI-2026-070',NULL,'Construire l\'Université d\'Abengourou','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Indénié-Djuablin.','Contribuer au développement du secteur « Enseignement Supérieur et Recherche Scientifique » dans la zone de Indénié-Djuablin, conformément aux orientations du PIP régional.',5050000000.00,'2025-12-02','2027-12-02',50,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,11,8,NULL,NULL,'2026-09-20 11:08:08','2026-09-20 11:08:08'),(71,'PIP-CI-2026-071',NULL,'Poursuivre la construction de dix (10) marchés dans le Lôh-Djiboua','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Lôh-Djiboua.','Contribuer au développement du secteur « Commerce » dans la zone de Lôh-Djiboua, conformément aux orientations du PIP régional.',6650000000.00,'2025-12-06','2027-12-06',60,'en_cours',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,4,4,NULL,NULL,'2026-09-20 11:08:13','2026-09-20 11:08:13'),(72,'PIP-CI-2026-072',NULL,'Poursuivre les travaux de réhabilitation du groupe 3 de la centrale hydroélectrique de Buyo','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Nawa.','Contribuer au développement du secteur « Électricité » dans la zone de Nawa, conformément aux orientations du PIP régional.',1650000000.00,'2027-08-02','2029-02-02',0,'planifie',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,18,31,NULL,NULL,'2026-09-20 11:08:20','2026-09-20 11:08:20'),(73,'PIP-CI-2026-073',NULL,'Construire le Lycée Professionnel de Dimbokro','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Nzi.','Contribuer au développement du secteur « Enseignement Technique et Formation Professionnelle » dans la zone de Nzi, conformément aux orientations du PIP régional.',3250000000.00,'2024-01-27','2025-09-27',100,'termine',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,12,9,NULL,NULL,'2026-09-20 11:08:22','2026-09-20 11:08:22'),(74,'PIP-CI-2026-074',NULL,'Finaliser la construction des infrastructures et mettre en service le métro d\'Abidjan','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Le Plateau.','Contribuer au développement du secteur « Transport » dans la zone de Le Plateau, conformément aux orientations du PIP régional.',4850000000.00,'2024-11-19','2026-02-19',20,'retarde',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,2,29,NULL,NULL,'2026-09-20 11:08:30','2026-09-20 11:08:30'),(75,'PIP-CI-2026-075',NULL,'Finaliser la construction de la centrale à biomasse BIOVEA à Aboisso','Projet identifié dans le cadre du Programme d\'Investissement Public régional 2026-2030, au titre des perspectives de développement de la zone de Sud-Comoé.','Contribuer au développement du secteur « Électricité » dans la zone de Sud-Comoé, conformément aux orientations du PIP régional.',6450000000.00,'2025-12-22','2027-12-22',40,'en_cours','Ministère du Commerce et de l\'Industrie','Ministère du Commerce','ESBTP',NULL,NULL,NULL,NULL,'investissement',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,18,31,NULL,NULL,'2026-09-20 11:08:37','2026-09-23 00:54:16');
/*!40000 ALTER TABLE `projets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rapports`
--

DROP TABLE IF EXISTS `rapports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rapports` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` enum('avancement','financier','physique','suivi','annuel','trimestriel','mensuel','synthese','execution') NOT NULL,
  `titre` varchar(255) NOT NULL,
  `donnees` longtext DEFAULT NULL,
  `fichier` varchar(255) DEFAULT NULL,
  `date` date NOT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `utilisateur_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rapports_projet_id_foreign` (`projet_id`),
  KEY `rapports_utilisateur_id_foreign` (`utilisateur_id`),
  CONSTRAINT `rapports_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE,
  CONSTRAINT `rapports_utilisateur_id_foreign` FOREIGN KEY (`utilisateur_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rapports`
--

LOCK TABLES `rapports` WRITE;
/*!40000 ALTER TABLE `rapports` DISABLE KEYS */;
INSERT INTO `rapports` VALUES (1,'trimestriel','Trimestriel - Aménager et bitumer la route M\'Batto-Afféry (40 km)','Point de situation du projet « Aménager et bitumer la route M\'Batto-Afféry (40 km) » (zone : Moronou). Avancement physique estimé à 20%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-09-01',1,4,'2026-09-20 11:05:45','2026-09-20 11:05:45'),(2,'financier','Financier - Construire des parkings publics et souterrains dans les zones commerci','Point de situation du projet « Construire des parkings publics et souterrains dans les zones commerciales et administratives » (zone : Songon). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2023-08-11',3,3,'2026-09-20 11:05:50','2026-09-20 11:05:50'),(3,'suivi','Suivi - Développer un réseau cyclable sécurisé et des pistes piétonnes','Point de situation du projet « Développer un réseau cyclable sécurisé et des pistes piétonnes » (zone : Yopougon). Avancement physique estimé à 30%. Statut administratif : retarde.','rapports/rapport-demo.pdf','2024-08-13',4,4,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(4,'trimestriel','Trimestriel - Construire 12 sites radioélectriques à Andobo-Alluibo, Assekakro, Bess','Point de situation du projet « Construire 12 sites radioélectriques à Andobo-Alluibo, Assekakro, Besseri-Takikro, Bobokro, Djigbe, Fari-Oko, Iki, Kirakro, Koyorabo, Monebo, Plahankro, Zédé-Kan » (zone : Gbêkê). Avancement physique estimé à 60%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-09-17',5,4,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(5,'avancement','Avancement - Poursuivre la digitalisation du processus d\'obtention des extraits de','Point de situation du projet « Poursuivre la digitalisation du processus d\'obtention des extraits de casier judiciaire, des certificats de nationalité et autres documents administratifs » (zone : Treichville). Avancement physique estimé à 55%. Statut administratif : suspendu.','rapports/rapport-demo.pdf','2024-12-21',6,2,'2026-09-20 11:05:54','2026-09-20 11:05:54'),(6,'financier','Financier - Etendre le parc de zones d\'activité industrielle','Point de situation du projet « Etendre le parc de zones d\'activité industrielle » (zone : Tonkpi). Avancement physique estimé à 20%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-09-25',7,3,'2026-09-20 11:05:56','2026-09-20 11:05:56'),(7,'trimestriel','Trimestriel - Construire des marchés de proximité','Point de situation du projet « Construire des marchés de proximité » (zone : Moronou). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2023-09-13',9,4,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(8,'avancement','Avancement - Créer une unité Satellite de transformation de noix de cajou (1500T) à','Point de situation du projet « Créer une unité Satellite de transformation de noix de cajou (1500T) à Zuénoula » (zone : Marahoué). Avancement physique estimé à 50%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-10-06',10,2,'2026-09-20 11:05:59','2026-09-20 11:05:59'),(9,'financier','Financier - Promouvoir des activités artisanales à travers l\'appui logistique aux','Point de situation du projet « Promouvoir des activités artisanales à travers l\'appui logistique aux associations locales et la valorisation des savoir-faire traditionnels » (zone : Gbôklé). Avancement physique estimé à 60%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-10-10',11,3,'2026-09-20 11:06:01','2026-09-20 11:06:01'),(10,'trimestriel','Trimestriel - Mettre en œuvre le projet Clonix PHASE-II','Point de situation du projet « Mettre en œuvre le projet Clonix PHASE-II » (zone : Gôh). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2023-10-02',13,4,'2026-09-20 11:06:05','2026-09-20 11:06:05'),(11,'avancement','Avancement - Mettre en place des microcrédits et programmes d\'accompagnement financ','Point de situation du projet « Mettre en place des microcrédits et programmes d\'accompagnement financier pour jeunes et femmes entrepreneures » (zone : Attécoubé). Avancement physique estimé à 20%. Statut administratif : retarde.','rapports/rapport-demo.pdf','2024-09-24',14,2,'2026-09-20 11:06:07','2026-09-20 11:06:07'),(12,'financier','Financier - Construire une salle de sport semi-couverte au Lycée Moderne d\'Adzopé','Point de situation du projet « Construire une salle de sport semi-couverte au Lycée Moderne d\'Adzopé et d\'Alépé » (zone : La Mé). Avancement physique estimé à 40%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-10-26',15,3,'2026-09-20 11:06:10','2026-09-20 11:06:10'),(13,'suivi','Suivi - Construire deux (02) salles de sports sémi-couverte dans le Lycée Mode','Point de situation du projet « Construire deux (02) salles de sports sémi-couverte dans le Lycée Moderne Koumassi 2 et le Lycée Moderne de Treichville » (zone : District Autonome d\'Abidjan). Avancement physique estimé à 35%. Statut administratif : suspendu.','rapports/rapport-demo.pdf','2025-01-31',16,4,'2026-09-20 11:06:11','2026-09-20 11:06:11'),(14,'trimestriel','Trimestriel - Promouvoir l\'autonomisation économique des femmes par la formation et','Point de situation du projet « Promouvoir l\'autonomisation économique des femmes par la formation et le microcrédit » (zone : Port-Bouët). Avancement physique estimé à 60%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-11-04',17,4,'2026-09-20 11:06:13','2026-09-20 11:06:13'),(15,'financier','Financier - Construire et équiper le tribunal du commerce de Daloa','Point de situation du projet « Construire et équiper le tribunal du commerce de Daloa » (zone : Haut-Sassandra). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2023-11-02',19,3,'2026-09-20 11:06:16','2026-09-20 11:06:16'),(16,'suivi','Suivi - Construire et équiper une nouvelle MAC et sa cité pénitentiaire à Bing','Point de situation du projet « Construire et équiper une nouvelle MAC et sa cité pénitentiaire à Bingerville » (zone : District Autonome d\'Abidjan). Avancement physique estimé à 30%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-11-16',20,4,'2026-09-20 11:06:18','2026-09-20 11:06:18'),(17,'trimestriel','Trimestriel - Alimenter la zone sud d\'Abidjan à partir de la nappe du Sud Comoé - ph','Point de situation du projet « Alimenter la zone sud d\'Abidjan à partir de la nappe du Sud Comoé - phase 3 » (zone : District Autonome d\'Abidjan). Avancement physique estimé à 40%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-11-20',21,4,'2026-09-20 11:06:20','2026-09-20 11:06:20'),(18,'financier','Financier - Construire deux-cent cinquante (250) cantines scolaires dans deux-cent','Point de situation du projet « Construire deux-cent cinquante (250) cantines scolaires dans deux-cent cinquante (250) gros villages de la région » (zone : Bafing). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2023-11-22',23,3,'2026-09-20 11:06:23','2026-09-20 11:06:23'),(19,'suivi','Suivi - Construire et équiper 12 collèges sur la période 2026-2028','Point de situation du projet « Construire et équiper 12 collèges sur la période 2026-2028 » (zone : Moronou). Avancement physique estimé à 30%. Statut administratif : retarde.','rapports/rapport-demo.pdf','2024-11-03',24,4,'2026-09-20 11:06:24','2026-09-20 11:06:24'),(20,'trimestriel','Trimestriel - Poursuivre la réhabilitation et équipement Centre Recherches Océanogra','Point de situation du projet « Poursuivre la réhabilitation et équipement Centre Recherches Océanographiques (CRO) » (zone : District Autonome d\'Abidjan). Avancement physique estimé à 20%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-12-05',25,4,'2026-09-20 11:06:26','2026-09-20 11:06:26'),(21,'avancement','Avancement - Étendre les infrastructures de l\'Université de Man','Point de situation du projet « Étendre les infrastructures de l\'Université de Man » (zone : Tonkpi). Avancement physique estimé à 45%. Statut administratif : suspendu.','rapports/rapport-demo.pdf','2025-03-09',26,2,'2026-09-20 11:06:28','2026-09-20 11:06:28'),(22,'financier','Financier - Construire et équiper le garage école de Daloa','Point de situation du projet « Construire et équiper le garage école de Daloa » (zone : Haut-Sassandra). Avancement physique estimé à 40%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-12-13',27,3,'2026-09-20 11:06:30','2026-09-20 11:06:30'),(23,'trimestriel','Trimestriel - Construire deux (2) villages d\'artisans','Point de situation du projet « Construire deux (2) villages d\'artisans » (zone : District Autonome d\'Abidjan). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2023-12-21',29,4,'2026-09-20 11:06:34','2026-09-20 11:06:34'),(24,'avancement','Avancement - Développer l\'écotourisme côtier (plages, mangroves, excursions lagunai','Point de situation du projet « Développer l\'écotourisme côtier (plages, mangroves, excursions lagunaires) » (zone : Port-Bouët). Avancement physique estimé à 70%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-12-25',30,2,'2026-09-20 11:06:35','2026-09-20 11:06:35'),(25,'financier','Financier - Mettre en œuvre le projet de pôle agro-industriel dans le nord-est de','Point de situation du projet « Mettre en œuvre le projet de pôle agro-industriel dans le nord-est de la Côte d\'Ivoire » (zone : Gontougo). Avancement physique estimé à 20%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2025-12-29',31,3,'2026-09-20 11:06:37','2026-09-20 11:06:37'),(26,'trimestriel','Trimestriel - Créer des points de vente des produits issus des élevages en développe','Point de situation du projet « Créer des points de vente des produits issus des élevages en développement » (zone : District Autonome de Yamoussoukro). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2024-01-11',33,4,'2026-09-20 11:06:46','2026-09-20 11:06:46'),(27,'avancement','Avancement - Installer 6 fermes aquacoles','Point de situation du projet « Installer 6 fermes aquacoles » (zone : San-Pédro). Avancement physique estimé à 20%. Statut administratif : retarde.','rapports/rapport-demo.pdf','2024-12-12',34,2,'2026-09-20 11:06:47','2026-09-20 11:06:47'),(28,'financier','Financier - Aménager et meubler le siège du Conseil régional et la résidence du di','Point de situation du projet « Aménager et meubler le siège du Conseil régional et la résidence du directeur général de l\'administration » (zone : Gbôklé). Avancement physique estimé à 60%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-01-15',35,3,'2026-09-20 11:06:51','2026-09-20 11:06:51'),(29,'suivi','Suivi - Restructurer et aménager les quartiers précaires d\'Abidjan','Point de situation du projet « Restructurer et aménager les quartiers précaires d\'Abidjan » (zone : District Autonome d\'Abidjan). Avancement physique estimé à 55%. Statut administratif : suspendu.','rapports/rapport-demo.pdf','2025-04-19',36,4,'2026-09-20 11:06:53','2026-09-20 11:06:53'),(30,'trimestriel','Trimestriel - Poursuivre la dotation des communes ne disposant pas de service délégu','Point de situation du projet « Poursuivre la dotation des communes ne disposant pas de service délégué de propreté en matériel de salubrité » (zone : Haut-Sassandra). Avancement physique estimé à 20%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-01-23',37,4,'2026-09-20 11:06:55','2026-09-20 11:06:55'),(31,'financier','Financier - Construire 45 ESPC dont 14 dispensaires ruraux, 21 centres de santé ur','Point de situation du projet « Construire 45 ESPC dont 14 dispensaires ruraux, 21 centres de santé urbains et 10 centres de santé ruraux » (zone : San-Pédro). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2024-02-10',39,3,'2026-09-20 11:06:59','2026-09-20 11:06:59'),(32,'suivi','Suivi - Renforcer la production d\'oxygène dans les établissements sanitaires d','Point de situation du projet « Renforcer la production d\'oxygène dans les établissements sanitaires de référence » (zone : Agnéby-Tiassa). Avancement physique estimé à 50%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-02-04',40,4,'2026-09-20 11:07:01','2026-09-20 11:07:01'),(33,'trimestriel','Trimestriel - Poursuivre la construction de la mine d\'or KONÉ, dans les départements','Point de situation du projet « Poursuivre la construction de la mine d\'or KONÉ, dans les départements de Kani » (zone : Worodougou). Avancement physique estimé à 60%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-02-08',41,4,'2026-09-20 11:07:03','2026-09-20 11:07:03'),(34,'financier','Financier - Mettre en œuvre le Projet de réalisation de la centrale solaire de Bin','Point de situation du projet « Mettre en œuvre le Projet de réalisation de la centrale solaire de Binguebougou (50 MWC) » (zone : Poro). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2024-03-01',43,3,'2026-09-20 11:07:09','2026-09-20 11:07:09'),(35,'suivi','Suivi - Mettre en œuvre le Programme Électricité Pour Tous (PEPT) par le branc','Point de situation du projet « Mettre en œuvre le Programme Électricité Pour Tous (PEPT) par le branchement de 400 000 ménages au niveau national dont la région du Gôh » (zone : Gôh). Avancement physique estimé à 30%. Statut administratif : retarde.','rapports/rapport-demo.pdf','2025-01-22',44,4,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(36,'trimestriel','Trimestriel - Promouvoir les arts, traditions et savoir-faire locaux (danse, artisan','Point de situation du projet « Promouvoir les arts, traditions et savoir-faire locaux (danse, artisanat, musique) » (zone : Abobo). Avancement physique estimé à 40%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-02-24',45,4,'2026-09-20 11:07:13','2026-09-20 11:07:13'),(37,'avancement','Avancement - Développer des infrastructures touristiques (hébergements, routes d\'ac','Point de situation du projet « Développer des infrastructures touristiques (hébergements, routes d\'accès, signalétique) » (zone : Bingerville). Avancement physique estimé à 35%. Statut administratif : suspendu.','rapports/rapport-demo.pdf','2025-05-28',46,2,'2026-09-20 11:07:15','2026-09-20 11:07:15'),(38,'financier','Financier - Mettre en place un système de suivi-évaluation pour le suivi des proje','Point de situation du projet « Mettre en place un système de suivi-évaluation pour le suivi des projets et leur impact socio-économique » (zone : Adjamé). Avancement physique estimé à 60%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-03-01',47,3,'2026-09-20 11:07:18','2026-09-20 11:07:18'),(39,'trimestriel','Trimestriel - Réhabiliter et équiper les services de l\'administration du travail d\'A','Point de situation du projet « Réhabiliter et équiper les services de l\'administration du travail d\'Adjamé » (zone : Adjamé). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2024-03-29',49,4,'2026-09-20 11:07:23','2026-09-20 11:07:23'),(40,'avancement','Avancement - Poursuivre l\'enrôlement au RSTI et à la CMU','Point de situation du projet « Poursuivre l\'enrôlement au RSTI et à la CMU » (zone : Gbêkê). Avancement physique estimé à 30%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-03-13',50,2,'2026-09-20 11:07:25','2026-09-20 11:07:25'),(41,'financier','Financier - Aménager et équiper des Crèches garderies dans les CPPE des régions no','Point de situation du projet « Aménager et équiper des Crèches garderies dans les CPPE des régions non pourvues dont l\'Agnéby-Tiassa » (zone : Agnéby-Tiassa). Avancement physique estimé à 40%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-03-17',51,3,'2026-09-20 11:07:28','2026-09-20 11:07:28'),(42,'trimestriel','Trimestriel - Acquérir un bac pour la traversée à Béoumi','Point de situation du projet « Acquérir un bac pour la traversée à Béoumi » (zone : Gbêkê). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2024-04-19',53,4,'2026-09-20 11:07:31','2026-09-20 11:07:31'),(43,'avancement','Avancement - Construire et renforcer les routes (reprofilage lourd et léger) et ouv','Point de situation du projet « Construire et renforcer les routes (reprofilage lourd et léger) et ouvrages » (zone : Gbôklé). Avancement physique estimé à 20%. Statut administratif : retarde.','rapports/rapport-demo.pdf','2025-03-03',54,2,'2026-09-20 11:07:32','2026-09-20 11:07:32'),(44,'financier','Financier - Construire une caserne de sapeurs-pompiers','Point de situation du projet « Construire une caserne de sapeurs-pompiers » (zone : Iffou). Avancement physique estimé à 20%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-04-03',55,3,'2026-09-20 11:07:34','2026-09-20 11:07:34'),(45,'suivi','Suivi - Construire et équiper des centres de manœuvres et d\'entrainements','Point de situation du projet « Construire et équiper des centres de manœuvres et d\'entrainements » (zone : Kabadougou). Avancement physique estimé à 45%. Statut administratif : suspendu.','rapports/rapport-demo.pdf','2025-07-07',56,4,'2026-09-20 11:07:35','2026-09-20 11:07:35'),(46,'trimestriel','Trimestriel - Développer une brigade municipale de prévention (sécurité routière, en','Point de situation du projet « Développer une brigade municipale de prévention (sécurité routière, environnement) » (zone : Koumassi). Avancement physique estimé à 40%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-04-11',57,4,'2026-09-20 11:07:37','2026-09-20 11:07:37'),(47,'financier','Financier - Insertion de 27 458 jeunes aux programmes d\'insertion professionnelle','Point de situation du projet « Insertion de 27 458 jeunes aux programmes d\'insertion professionnelle (2023 -2025) » (zone : Tonkpi). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2024-05-18',59,3,'2026-09-20 11:07:40','2026-09-20 11:07:40'),(48,'suivi','Suivi - Construire et équiper 12 Agences (une dans chacune des Sous-Préfecture','Point de situation du projet « Construire et équiper 12 Agences (une dans chacune des Sous-Préfectures) types de l\'agence emploi jeunes dans la région » (zone : Tchologo). Avancement physique estimé à 70%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-04-23',60,4,'2026-09-20 11:07:42','2026-09-20 11:07:42'),(49,'trimestriel','Trimestriel - Promouvoir l\'énergie renouvelable (solaire sur bâtiments publics et éc','Point de situation du projet « Promouvoir l\'énergie renouvelable (solaire sur bâtiments publics et éclairage public) » (zone : Marcory). Avancement physique estimé à 20%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-04-27',61,4,'2026-09-20 11:07:46','2026-09-20 11:07:46'),(50,'financier','Financier - Construire le Lycée Professionnel de Toumodi','Point de situation du projet « Construire le Lycée Professionnel de Toumodi » (zone : Bélier). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2024-06-08',63,3,'2026-09-20 11:07:51','2026-09-20 11:07:51'),(51,'suivi','Suivi - Aménager et bitumer la route Séguéla-Kongasso-Kounahiri (100 km)','Point de situation du projet « Aménager et bitumer la route Séguéla-Kongasso-Kounahiri (100 km) » (zone : Béré). Avancement physique estimé à 30%. Statut administratif : retarde.','rapports/rapport-demo.pdf','2025-04-10',64,4,'2026-09-20 11:07:54','2026-09-20 11:07:54'),(52,'trimestriel','Trimestriel - Poursuivre la construction du Lycée d\'Excellence de jeunes filles de B','Point de situation du projet « Poursuivre la construction du Lycée d\'Excellence de jeunes filles de Bouna » (zone : Bounkani). Avancement physique estimé à 60%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-05-12',65,4,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(53,'avancement','Avancement - Reconstruire aux normes le marché de détail de Guiglo','Point de situation du projet « Reconstruire aux normes le marché de détail de Guiglo » (zone : Cavally). Avancement physique estimé à 55%. Statut administratif : suspendu.','rapports/rapport-demo.pdf','2025-08-16',66,2,'2026-09-20 11:07:59','2026-09-20 11:07:59'),(54,'financier','Financier - Construire le pont sur l\'axe Banankoro - Manadoun','Point de situation du projet « Construire le pont sur l\'axe Banankoro - Manadoun » (zone : Folon). Avancement physique estimé à 20%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-05-20',67,3,'2026-09-20 11:08:03','2026-09-20 11:08:03'),(55,'trimestriel','Trimestriel - Poursuivre la construction et l\'équipement du CHR de Katiola','Point de situation du projet « Poursuivre la construction et l\'équipement du CHR de Katiola » (zone : Hambol). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2024-07-07',69,4,'2026-09-20 11:08:08','2026-09-20 11:08:08'),(56,'avancement','Avancement - Construire l\'Université d\'Abengourou','Point de situation du projet « Construire l\'Université d\'Abengourou » (zone : Indénié-Djuablin). Avancement physique estimé à 50%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-06-02',70,2,'2026-09-20 11:08:12','2026-09-20 11:08:12'),(57,'financier','Financier - Poursuivre la construction de dix (10) marchés dans le Lôh-Djiboua','Point de situation du projet « Poursuivre la construction de dix (10) marchés dans le Lôh-Djiboua » (zone : Lôh-Djiboua). Avancement physique estimé à 60%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-06-06',71,3,'2026-09-20 11:08:20','2026-09-20 11:08:20'),(58,'trimestriel','Trimestriel - Construire le Lycée Professionnel de Dimbokro','Point de situation du projet « Construire le Lycée Professionnel de Dimbokro » (zone : Nzi). Avancement physique estimé à 100%. Statut administratif : termine.','rapports/rapport-demo.pdf','2024-07-27',73,4,'2026-09-20 11:08:27','2026-09-20 11:08:27'),(59,'avancement','Avancement - Finaliser la construction des infrastructures et mettre en service le','Point de situation du projet « Finaliser la construction des infrastructures et mettre en service le métro d\'Abidjan » (zone : Le Plateau). Avancement physique estimé à 20%. Statut administratif : retarde.','rapports/rapport-demo.pdf','2025-05-19',74,2,'2026-09-20 11:08:36','2026-09-20 11:08:36'),(60,'financier','Financier - Finaliser la construction de la centrale à biomasse BIOVEA à Aboisso','Point de situation du projet « Finaliser la construction de la centrale à biomasse BIOVEA à Aboisso » (zone : Sud-Comoé). Avancement physique estimé à 40%. Statut administratif : en_cours.','rapports/rapport-demo.pdf','2026-06-22',75,3,'2026-09-20 11:08:42','2026-09-20 11:08:42');
/*!40000 ALTER TABLE `rapports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reformes`
--

DROP TABLE IF EXISTS `reformes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reformes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `resultat_global_attendu` text DEFAULT NULL,
  `statut` enum('demarree','en_cours','achevee') NOT NULL DEFAULT 'demarree',
  `date_transmission_sgg` date DEFAULT NULL,
  `annee_debut` smallint(5) unsigned DEFAULT NULL,
  `annee_fin` smallint(5) unsigned DEFAULT NULL,
  `taux_execution_annee_precedente` decimal(5,2) DEFAULT NULL,
  `taux_execution_previsionnel` decimal(5,2) DEFAULT NULL,
  `cible_trimestre_1` varchar(255) DEFAULT NULL,
  `cible_trimestre_2` varchar(255) DEFAULT NULL,
  `cible_trimestre_3` varchar(255) DEFAULT NULL,
  `cible_trimestre_4` varchar(255) DEFAULT NULL,
  `localite` varchar(255) DEFAULT NULL,
  `budget_global` decimal(18,2) DEFAULT NULL,
  `source_financement` varchar(255) DEFAULT NULL,
  `montant_etat` decimal(18,2) DEFAULT NULL,
  `montant_autres_bailleurs` decimal(18,2) DEFAULT NULL,
  `livrables_attendus` text DEFAULT NULL,
  `indicateurs` text DEFAULT NULL,
  `code_pjgouv` varchar(255) DEFAULT NULL,
  `code_psgouv` varchar(255) DEFAULT NULL,
  `observations` text DEFAULT NULL,
  `structure_id` bigint(20) unsigned NOT NULL,
  `axe_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reformes_structure_id_foreign` (`structure_id`),
  KEY `reformes_axe_id_foreign` (`axe_id`),
  CONSTRAINT `reformes_axe_id_foreign` FOREIGN KEY (`axe_id`) REFERENCES `axes` (`id`) ON DELETE SET NULL,
  CONSTRAINT `reformes_structure_id_foreign` FOREIGN KEY (`structure_id`) REFERENCES `structures` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reformes`
--

LOCK TABLES `reformes` WRITE;
/*!40000 ALTER TABLE `reformes` DISABLE KEYS */;
/*!40000 ALTER TABLE `reformes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `regions`
--

DROP TABLE IF EXISTS `regions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `regions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `district_id` bigint(20) unsigned NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `regions_district_id_foreign` (`district_id`),
  CONSTRAINT `regions_district_id_foreign` FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `regions`
--

LOCK TABLES `regions` WRITE;
/*!40000 ALTER TABLE `regions` DISABLE KEYS */;
INSERT INTO `regions` VALUES (1,1,'Abidjan',NULL,'2026-09-20 11:05:34','2026-09-20 11:05:34'),(2,2,'Yamoussoukro',NULL,'2026-09-20 11:05:36','2026-09-20 11:05:36'),(3,3,'Agnéby-Tiassa',NULL,'2026-09-20 11:05:36','2026-09-20 11:05:36'),(4,3,'Bafing',NULL,'2026-09-20 11:05:36','2026-09-20 11:05:36'),(5,3,'Bagoué',NULL,'2026-09-20 11:05:36','2026-09-20 11:05:36'),(6,3,'Bélier',NULL,'2026-09-20 11:05:37','2026-09-20 11:05:37'),(7,3,'Béré',NULL,'2026-09-20 11:05:37','2026-09-20 11:05:37'),(8,3,'Bounkani',NULL,'2026-09-20 11:05:37','2026-09-20 11:05:37'),(9,3,'Cavally',NULL,'2026-09-20 11:05:37','2026-09-20 11:05:37'),(10,3,'Folon',NULL,'2026-09-20 11:05:37','2026-09-20 11:05:37'),(11,3,'Gbêkê',NULL,'2026-09-20 11:05:37','2026-09-20 11:05:37'),(12,3,'Gbôklé',NULL,'2026-09-20 11:05:37','2026-09-20 11:05:37'),(13,3,'Gôh',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(14,3,'Gontougo',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(15,3,'Grands-Ponts',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(16,3,'Guémon',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(17,3,'Hambol',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(18,3,'Haut-Sassandra',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(19,3,'Iffou',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(20,3,'Indénié-Djuablin',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(21,3,'Kabadougou',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(22,3,'La Mé',NULL,'2026-09-20 11:05:38','2026-09-20 11:05:38'),(23,3,'Lôh-Djiboua',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(24,3,'Marahoué',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(25,3,'Moronou',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(26,3,'Nawa',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(27,3,'Nzi',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(28,3,'Poro',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(29,3,'San-Pédro',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(30,3,'Sud-Comoé',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(31,3,'Tchologo',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(32,3,'Tonkpi',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39'),(33,3,'Worodougou',NULL,'2026-09-20 11:05:39','2026-09-20 11:05:39');
/*!40000 ALTER TABLE `regions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `resultats_attendus`
--

DROP TABLE IF EXISTS `resultats_attendus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `resultats_attendus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `niveau` enum('impact','effet','extrant') NOT NULL DEFAULT 'extrant',
  `produit` varchar(255) DEFAULT NULL,
  `libelle` varchar(255) NOT NULL,
  `situation_reference` varchar(255) DEFAULT NULL,
  `cible` varchar(255) DEFAULT NULL,
  `valeur_realisee` varchar(255) DEFAULT NULL,
  `reste_a_atteindre` varchar(255) DEFAULT NULL,
  `commentaire` text DEFAULT NULL,
  `objectif_specifique_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resultats_attendus_objectif_specifique_id_foreign` (`objectif_specifique_id`),
  CONSTRAINT `resultats_attendus_objectif_specifique_id_foreign` FOREIGN KEY (`objectif_specifique_id`) REFERENCES `objectifs_specifiques` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `resultats_attendus`
--

LOCK TABLES `resultats_attendus` WRITE;
/*!40000 ALTER TABLE `resultats_attendus` DISABLE KEYS */;
/*!40000 ALTER TABLE `resultats_attendus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `risques`
--

DROP TABLE IF EXISTS `risques`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risques` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `consequence` text DEFAULT NULL,
  `probabilite` enum('faible','moyenne','forte') NOT NULL DEFAULT 'moyenne',
  `criticite` enum('faible','moyenne','elevee') NOT NULL DEFAULT 'moyenne',
  `mesure_mitigation` text DEFAULT NULL,
  `type_strategie` varchar(255) DEFAULT NULL,
  `projet_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `risques_projet_id_foreign` (`projet_id`),
  CONSTRAINT `risques_projet_id_foreign` FOREIGN KEY (`projet_id`) REFERENCES `projets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `risques`
--

LOCK TABLES `risques` WRITE;
/*!40000 ALTER TABLE `risques` DISABLE KEYS */;
/*!40000 ALTER TABLE `risques` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secteurs`
--

DROP TABLE IF EXISTS `secteurs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `secteurs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secteurs`
--

LOCK TABLES `secteurs` WRITE;
/*!40000 ALTER TABLE `secteurs` DISABLE KEYS */;
INSERT INTO `secteurs` VALUES (1,'Agriculture','2026-09-20 11:05:31','2026-09-20 11:05:31'),(2,'Artisanat','2026-09-20 11:05:31','2026-09-20 11:05:31'),(3,'Assainissement et Salubrité','2026-09-20 11:05:31','2026-09-20 11:05:31'),(4,'Commerce','2026-09-20 11:05:31','2026-09-20 11:05:31'),(5,'Culture','2026-09-20 11:05:31','2026-09-20 11:05:31'),(6,'Défense et Sécurité','2026-09-20 11:05:31','2026-09-20 11:05:31'),(7,'Emploi et Protection Sociale','2026-09-20 11:05:31','2026-09-20 11:05:31'),(8,'Enseignement Supérieur et Recherche Scientifique','2026-09-20 11:05:31','2026-09-20 11:05:31'),(9,'Enseignement Technique et Formation Professionnelle','2026-09-20 11:05:31','2026-09-20 11:05:31'),(10,'Environnement','2026-09-20 11:05:31','2026-09-20 11:05:31'),(11,'Femme, Famille et Enfant','2026-09-20 11:05:31','2026-09-20 11:05:31'),(12,'Genre et Égalité des Sexes','2026-09-20 11:05:31','2026-09-20 11:05:31'),(13,'Gouvernance Locale','2026-09-20 11:05:32','2026-09-20 11:05:32'),(14,'Habitat et Logement','2026-09-20 11:05:32','2026-09-20 11:05:32'),(15,'Hydraulique','2026-09-20 11:05:32','2026-09-20 11:05:32'),(16,'Industrie','2026-09-20 11:05:32','2026-09-20 11:05:32'),(17,'Infrastructures','2026-09-20 11:05:32','2026-09-20 11:05:32'),(18,'Infrastructures Routières','2026-09-20 11:05:32','2026-09-20 11:05:32'),(19,'Jeunesse','2026-09-20 11:05:32','2026-09-20 11:05:32'),(20,'Justice et Droits de l\'Homme','2026-09-20 11:05:32','2026-09-20 11:05:32'),(21,'Mines','2026-09-20 11:05:32','2026-09-20 11:05:32'),(22,'Promotion des PME','2026-09-20 11:05:32','2026-09-20 11:05:32'),(23,'Protection Civile','2026-09-20 11:05:33','2026-09-20 11:05:33'),(24,'Ressources Animales et Halieutiques','2026-09-20 11:05:33','2026-09-20 11:05:33'),(25,'Santé','2026-09-20 11:05:33','2026-09-20 11:05:33'),(26,'Sport','2026-09-20 11:05:33','2026-09-20 11:05:33'),(27,'Tourisme et Loisirs','2026-09-20 11:05:33','2026-09-20 11:05:33'),(28,'Transition Numérique','2026-09-20 11:05:33','2026-09-20 11:05:33'),(29,'Transport','2026-09-20 11:05:33','2026-09-20 11:05:33'),(30,'Éducation','2026-09-20 11:05:33','2026-09-20 11:05:33'),(31,'Électricité','2026-09-20 11:05:33','2026-09-20 11:05:33');
/*!40000 ALTER TABLE `secteurs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('34OoiPEpoNgClqL7LDyo7ejXIVZoPvARhVrs6QyM',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJ0MVlNSmRyT2wxWk9WNlRjMkp6djlmU2tIWjN3OTJTN0NMUDRTYlUwIiwidXJsIjp7ImludGVuZGVkIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDBcL3Byb2pldHMifSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wcm9qZXRzIiwicm91dGUiOiJwcm9qZXRzLmluZGV4In0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1790124108),('5hD6spzR7LdfyID64TxlmJ4pzbindRNoqJQ82kEi',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJhVlk4Tm9xR3JzZWp3aXIzWmhmd0RFS2t6ZDNMc295NnVGODJ3M2lnIiwidXJsIjpbXSwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC90YWJsZWF1LWRlLWJvcmQiLCJyb3V0ZSI6ImRhc2hib2FyZCJ9LCJfZmxhc2giOnsib2xkIjpbXSwibmV3IjpbXX0sImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjoxfQ==',1790125241);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sous_prefectures`
--

DROP TABLE IF EXISTS `sous_prefectures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sous_prefectures` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `commune_id` bigint(20) unsigned NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sous_prefectures_commune_id_foreign` (`commune_id`),
  CONSTRAINT `sous_prefectures_commune_id_foreign` FOREIGN KEY (`commune_id`) REFERENCES `communes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sous_prefectures`
--

LOCK TABLES `sous_prefectures` WRITE;
/*!40000 ALTER TABLE `sous_prefectures` DISABLE KEYS */;
/*!40000 ALTER TABLE `sous_prefectures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `structures`
--

DROP TABLE IF EXISTS `structures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `structures` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `sigle` varchar(255) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `telephone` varchar(255) DEFAULT NULL,
  `type_structure_id` bigint(20) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `structures_type_structure_id_foreign` (`type_structure_id`),
  CONSTRAINT `structures_type_structure_id_foreign` FOREIGN KEY (`type_structure_id`) REFERENCES `types_structure` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `structures`
--

LOCK TABLES `structures` WRITE;
/*!40000 ALTER TABLE `structures` DISABLE KEYS */;
INSERT INTO `structures` VALUES (1,'Ministère des Infrastructures Économiques','MIE',NULL,NULL,1,'2026-09-20 11:05:28','2026-09-20 11:05:28'),(2,'Ministère des Transports','MT',NULL,NULL,1,'2026-09-20 11:05:28','2026-09-20 11:05:28'),(3,'Ministère de la Transition Numérique et de la Digitalisation','MTND',NULL,NULL,1,'2026-09-20 11:05:28','2026-09-20 11:05:28'),(4,'Ministère du Commerce, de l\'Industrie et de la Promotion des PME','MCIPME',NULL,NULL,1,'2026-09-20 11:05:28','2026-09-20 11:05:28'),(5,'Ministère des Sports','MSPT',NULL,NULL,1,'2026-09-20 11:05:28','2026-09-20 11:05:28'),(6,'Ministère de la Femme, de la Famille et de l\'Enfant','MFFE',NULL,NULL,1,'2026-09-20 11:05:28','2026-09-20 11:05:28'),(7,'Ministère de la Justice et des Droits de l\'Homme','MJDH',NULL,NULL,1,'2026-09-20 11:05:28','2026-09-20 11:05:28'),(8,'Ministère de l\'Hydraulique','MH',NULL,NULL,1,'2026-09-20 11:05:29','2026-09-20 11:05:29'),(9,'Ministère de l\'Assainissement et de la Salubrité Urbaine','MASU',NULL,NULL,1,'2026-09-20 11:05:29','2026-09-20 11:05:29'),(10,'Ministère de l\'Éducation Nationale et de l\'Alphabétisation','MENA',NULL,NULL,1,'2026-09-20 11:05:29','2026-09-20 11:05:29'),(11,'Ministère de l\'Enseignement Supérieur et de la Recherche Scientifique','MESRS',NULL,NULL,1,'2026-09-20 11:05:29','2026-09-20 11:05:29'),(12,'Ministère de l\'Enseignement Technique, de la Formation Professionnelle et de l\'Apprentissage','METFPA',NULL,NULL,1,'2026-09-20 11:05:29','2026-09-20 11:05:29'),(13,'Ministère du Tourisme et des Loisirs','MTL',NULL,NULL,1,'2026-09-20 11:05:29','2026-09-20 11:05:29'),(14,'Ministère de l\'Agriculture et du Développement Rural','MADR',NULL,NULL,1,'2026-09-20 11:05:29','2026-09-20 11:05:29'),(15,'Ministère des Ressources Animales et Halieutiques','MIRAH',NULL,NULL,1,'2026-09-20 11:05:29','2026-09-20 11:05:29'),(16,'Ministère de la Construction, du Logement et de l\'Urbanisme','MCLU',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30'),(17,'Ministère de la Santé, de l\'Hygiène Publique et de la Couverture Maladie Universelle','MSHPCMU',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30'),(18,'Ministère des Mines, du Pétrole et de l\'Énergie','MMPE',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30'),(19,'Ministère de la Culture et de la Francophonie','MCF',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30'),(20,'Ministère de l\'Administration du Territoire et de la Décentralisation','MATD',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30'),(21,'Ministère de l\'Emploi et de la Protection Sociale','MEPS',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30'),(22,'Ministère de la Défense','MDEF',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30'),(23,'Ministère de l\'Intérieur et de la Sécurité','MIS',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30'),(24,'Ministère de la Promotion de la Jeunesse','MPJ',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30'),(25,'Ministère de l\'Environnement et du Développement Durable','MINEDD',NULL,NULL,1,'2026-09-20 11:05:30','2026-09-20 11:05:30');
/*!40000 ALTER TABLE `structures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taches`
--

DROP TABLE IF EXISTS `taches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taches` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `intitule` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `date_debut` date DEFAULT NULL,
  `date_fin` date DEFAULT NULL,
  `activite_id` bigint(20) unsigned NOT NULL,
  `depense_id` bigint(20) unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `taches_activite_id_foreign` (`activite_id`),
  KEY `taches_depense_id_foreign` (`depense_id`),
  CONSTRAINT `taches_activite_id_foreign` FOREIGN KEY (`activite_id`) REFERENCES `activites` (`id`) ON DELETE CASCADE,
  CONSTRAINT `taches_depense_id_foreign` FOREIGN KEY (`depense_id`) REFERENCES `depenses` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=189 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taches`
--

LOCK TABLES `taches` WRITE;
/*!40000 ALTER TABLE `taches` DISABLE KEYS */;
INSERT INTO `taches` VALUES (1,'Réalisation des études techniques','Tâche rattachée à : Aménager et bitumer la route M\'Batto-Afféry (40 km)','2025-03-01','2025-11-01',1,1,'2026-09-20 11:05:44','2026-09-20 11:05:44'),(2,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Aménager et bitumer la route M\'Batto-Afféry (40 km)','2025-03-01','2025-05-01',1,NULL,'2026-09-20 11:05:44','2026-09-20 11:05:44'),(3,'Exécution et réception des travaux','Tâche rattachée à : Aménager et bitumer la route M\'Batto-Afféry (40 km)','2025-09-01','2026-05-01',2,NULL,'2026-09-20 11:05:44','2026-09-20 11:05:44'),(4,'Réalisation des études techniques','Tâche rattachée à : Aménager et bitumer la route Tiémé- N\'Globlasso - Goulia (57km)','2027-01-04','2027-09-04',3,NULL,'2026-09-20 11:05:47','2026-09-20 11:05:47'),(5,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Aménager et bitumer la route Tiémé- N\'Globlasso - Goulia (57km)','2027-01-04','2027-03-04',3,NULL,'2026-09-20 11:05:47','2026-09-20 11:05:47'),(6,'Réalisation des études techniques','Tâche rattachée à : Construire des parkings publics et souterrains dans les zones commerciales et administratives','2023-02-11','2023-10-11',4,2,'2026-09-20 11:05:49','2026-09-20 11:05:49'),(7,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire des parkings publics et souterrains dans les zones commerciales et administrati','2023-02-11','2023-04-11',4,NULL,'2026-09-20 11:05:49','2026-09-20 11:05:49'),(8,'Exécution et réception des travaux','Tâche rattachée à : Construire des parkings publics et souterrains dans les zones commerciales et administratives','2023-08-11','2024-04-11',5,NULL,'2026-09-20 11:05:50','2026-09-20 11:05:50'),(9,'Réalisation des études techniques','Tâche rattachée à : Développer un réseau cyclable sécurisé et des pistes piétonnes','2024-02-13','2024-10-13',6,3,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(10,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Développer un réseau cyclable sécurisé et des pistes piétonnes','2024-02-13','2024-04-13',6,NULL,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(11,'Réalisation des études techniques','Tâche rattachée à : Construire 12 sites radioélectriques à Andobo-Alluibo, Assekakro, Besseri-Takikro, Bobokro, Djigbe,','2025-03-17','2025-11-17',7,4,'2026-09-20 11:05:52','2026-09-20 11:05:52'),(12,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire 12 sites radioélectriques à Andobo-Alluibo, Assekakro, Besseri-Takikro, Bobokro','2025-03-17','2025-05-17',7,NULL,'2026-09-20 11:05:52','2026-09-20 11:05:52'),(13,'Exécution et réception des travaux','Tâche rattachée à : Construire 12 sites radioélectriques à Andobo-Alluibo, Assekakro, Besseri-Takikro, Bobokro, Djigbe,','2025-09-17','2026-05-17',8,NULL,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(14,'Réalisation des études techniques','Tâche rattachée à : Poursuivre la digitalisation du processus d\'obtention des extraits de casier judiciaire, des certifi','2024-06-21','2025-02-21',9,5,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(15,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre la digitalisation du processus d\'obtention des extraits de casier judiciaire, d','2024-06-21','2024-08-21',9,NULL,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(16,'Réalisation des études techniques','Tâche rattachée à : Etendre le parc de zones d\'activité industrielle','2025-03-25','2025-11-25',10,6,'2026-09-20 11:05:54','2026-09-20 11:05:54'),(17,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Etendre le parc de zones d\'activité industrielle','2025-03-25','2025-05-25',10,NULL,'2026-09-20 11:05:55','2026-09-20 11:05:55'),(18,'Exécution et réception des travaux','Tâche rattachée à : Etendre le parc de zones d\'activité industrielle','2025-09-25','2026-05-25',11,NULL,'2026-09-20 11:05:55','2026-09-20 11:05:55'),(19,'Réalisation des études techniques','Tâche rattachée à : Aménager la zone industrielle de Dabou','2027-01-22','2027-09-22',12,NULL,'2026-09-20 11:05:56','2026-09-20 11:05:56'),(20,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Aménager la zone industrielle de Dabou','2027-01-22','2027-03-22',12,NULL,'2026-09-20 11:05:56','2026-09-20 11:05:56'),(21,'Réalisation des études techniques','Tâche rattachée à : Construire des marchés de proximité','2023-03-13','2023-11-13',13,7,'2026-09-20 11:05:57','2026-09-20 11:05:57'),(22,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire des marchés de proximité','2023-03-13','2023-05-13',13,NULL,'2026-09-20 11:05:57','2026-09-20 11:05:57'),(23,'Exécution et réception des travaux','Tâche rattachée à : Construire des marchés de proximité','2023-09-13','2024-05-13',14,NULL,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(24,'Réalisation des études techniques','Tâche rattachée à : Créer une unité Satellite de transformation de noix de cajou (1500T) à Zuénoula','2025-04-06','2025-12-06',15,8,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(25,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Créer une unité Satellite de transformation de noix de cajou (1500T) à Zuénoula','2025-04-06','2025-06-06',15,NULL,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(26,'Réalisation des études techniques','Tâche rattachée à : Promouvoir des activités artisanales à travers l\'appui logistique aux associations locales et la val','2025-04-10','2025-12-10',16,9,'2026-09-20 11:05:59','2026-09-20 11:05:59'),(27,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Promouvoir des activités artisanales à travers l\'appui logistique aux associations locales','2025-04-10','2025-06-10',16,NULL,'2026-09-20 11:06:00','2026-09-20 11:06:00'),(28,'Exécution et réception des travaux','Tâche rattachée à : Promouvoir des activités artisanales à travers l\'appui logistique aux associations locales et la val','2025-10-10','2026-06-10',17,NULL,'2026-09-20 11:06:01','2026-09-20 11:06:01'),(29,'Réalisation des études techniques','Tâche rattachée à : Poursuivre la formation de 500 artisans','2027-02-03','2027-10-03',18,NULL,'2026-09-20 11:06:02','2026-09-20 11:06:02'),(30,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre la formation de 500 artisans','2027-02-03','2027-04-03',18,NULL,'2026-09-20 11:06:02','2026-09-20 11:06:02'),(31,'Réalisation des études techniques','Tâche rattachée à : Mettre en œuvre le projet Clonix PHASE-II','2023-04-02','2023-12-02',19,10,'2026-09-20 11:06:04','2026-09-20 11:06:04'),(32,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Mettre en œuvre le projet Clonix PHASE-II','2023-04-02','2023-06-02',19,NULL,'2026-09-20 11:06:04','2026-09-20 11:06:04'),(33,'Exécution et réception des travaux','Tâche rattachée à : Mettre en œuvre le projet Clonix PHASE-II','2023-10-02','2024-06-02',20,NULL,'2026-09-20 11:06:05','2026-09-20 11:06:05'),(34,'Réalisation des études techniques','Tâche rattachée à : Mettre en place des microcrédits et programmes d\'accompagnement financier pour jeunes et femmes entr','2024-03-24','2024-11-24',21,11,'2026-09-20 11:06:07','2026-09-20 11:06:07'),(35,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Mettre en place des microcrédits et programmes d\'accompagnement financier pour jeunes et f','2024-03-24','2024-05-24',21,NULL,'2026-09-20 11:06:07','2026-09-20 11:06:07'),(36,'Réalisation des études techniques','Tâche rattachée à : Construire une salle de sport semi-couverte au Lycée Moderne d\'Adzopé et d\'Alépé','2025-04-26','2025-12-26',22,12,'2026-09-20 11:06:09','2026-09-20 11:06:09'),(37,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire une salle de sport semi-couverte au Lycée Moderne d\'Adzopé et d\'Alépé','2025-04-26','2025-06-26',22,NULL,'2026-09-20 11:06:09','2026-09-20 11:06:09'),(38,'Exécution et réception des travaux','Tâche rattachée à : Construire une salle de sport semi-couverte au Lycée Moderne d\'Adzopé et d\'Alépé','2025-10-26','2026-06-26',23,NULL,'2026-09-20 11:06:09','2026-09-20 11:06:09'),(39,'Réalisation des études techniques','Tâche rattachée à : Construire deux (02) salles de sports sémi-couverte dans le Lycée Moderne Koumassi 2 et le Lycée Mod','2024-07-31','2025-03-31',24,13,'2026-09-20 11:06:10','2026-09-20 11:06:10'),(40,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire deux (02) salles de sports sémi-couverte dans le Lycée Moderne Koumassi 2 et le','2024-07-31','2024-10-01',24,NULL,'2026-09-20 11:06:11','2026-09-20 11:06:11'),(41,'Réalisation des études techniques','Tâche rattachée à : Promouvoir l\'autonomisation économique des femmes par la formation et le microcrédit','2025-05-04','2026-01-04',25,14,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(42,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Promouvoir l\'autonomisation économique des femmes par la formation et le microcrédit','2025-05-04','2025-07-04',25,NULL,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(43,'Exécution et réception des travaux','Tâche rattachée à : Promouvoir l\'autonomisation économique des femmes par la formation et le microcrédit','2025-11-04','2026-07-04',26,NULL,'2026-09-20 11:06:12','2026-09-20 11:06:12'),(44,'Réalisation des études techniques','Tâche rattachée à : Réhabiliter et équiper l\'IFEF de Boundiali','2027-02-21','2027-10-21',27,NULL,'2026-09-20 11:06:13','2026-09-20 11:06:13'),(45,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Réhabiliter et équiper l\'IFEF de Boundiali','2027-02-21','2027-04-21',27,NULL,'2026-09-20 11:06:13','2026-09-20 11:06:13'),(46,'Réalisation des études techniques','Tâche rattachée à : Construire et équiper le tribunal du commerce de Daloa','2023-05-02','2024-01-02',28,15,'2026-09-20 11:06:15','2026-09-20 11:06:15'),(47,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire et équiper le tribunal du commerce de Daloa','2023-05-02','2023-07-02',28,NULL,'2026-09-20 11:06:15','2026-09-20 11:06:15'),(48,'Exécution et réception des travaux','Tâche rattachée à : Construire et équiper le tribunal du commerce de Daloa','2023-11-02','2024-07-02',29,NULL,'2026-09-20 11:06:16','2026-09-20 11:06:16'),(49,'Réalisation des études techniques','Tâche rattachée à : Construire et équiper une nouvelle MAC et sa cité pénitentiaire à Bingerville','2025-05-16','2026-01-16',30,16,'2026-09-20 11:06:17','2026-09-20 11:06:17'),(50,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire et équiper une nouvelle MAC et sa cité pénitentiaire à Bingerville','2025-05-16','2025-07-16',30,NULL,'2026-09-20 11:06:17','2026-09-20 11:06:17'),(51,'Réalisation des études techniques','Tâche rattachée à : Alimenter la zone sud d\'Abidjan à partir de la nappe du Sud Comoé - phase 3','2025-05-20','2026-01-20',31,17,'2026-09-20 11:06:19','2026-09-20 11:06:19'),(52,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Alimenter la zone sud d\'Abidjan à partir de la nappe du Sud Comoé - phase 3','2025-05-20','2025-07-20',31,NULL,'2026-09-20 11:06:19','2026-09-20 11:06:19'),(53,'Exécution et réception des travaux','Tâche rattachée à : Alimenter la zone sud d\'Abidjan à partir de la nappe du Sud Comoé - phase 3','2025-11-20','2026-07-20',32,NULL,'2026-09-20 11:06:19','2026-09-20 11:06:19'),(54,'Réalisation des études techniques','Tâche rattachée à : Mettre en œuvre un programme d\'accès à l\'eau dans les écoles et centres de santé','2027-03-05','2027-11-05',33,NULL,'2026-09-20 11:06:21','2026-09-20 11:06:21'),(55,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Mettre en œuvre un programme d\'accès à l\'eau dans les écoles et centres de santé','2027-03-05','2027-05-05',33,NULL,'2026-09-20 11:06:21','2026-09-20 11:06:21'),(56,'Réalisation des études techniques','Tâche rattachée à : Construire deux-cent cinquante (250) cantines scolaires dans deux-cent cinquante (250) gros villages','2023-05-22','2024-01-22',34,18,'2026-09-20 11:06:22','2026-09-20 11:06:22'),(57,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire deux-cent cinquante (250) cantines scolaires dans deux-cent cinquante (250) gro','2023-05-22','2023-07-22',34,NULL,'2026-09-20 11:06:22','2026-09-20 11:06:22'),(58,'Exécution et réception des travaux','Tâche rattachée à : Construire deux-cent cinquante (250) cantines scolaires dans deux-cent cinquante (250) gros villages','2023-11-22','2024-07-22',35,NULL,'2026-09-20 11:06:22','2026-09-20 11:06:22'),(59,'Réalisation des études techniques','Tâche rattachée à : Construire et équiper 12 collèges sur la période 2026-2028','2024-05-03','2025-01-03',36,19,'2026-09-20 11:06:24','2026-09-20 11:06:24'),(60,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire et équiper 12 collèges sur la période 2026-2028','2024-05-03','2024-07-03',36,NULL,'2026-09-20 11:06:24','2026-09-20 11:06:24'),(61,'Réalisation des études techniques','Tâche rattachée à : Poursuivre la réhabilitation et équipement Centre Recherches Océanographiques (CRO)','2025-06-05','2026-02-05',37,20,'2026-09-20 11:06:26','2026-09-20 11:06:26'),(62,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre la réhabilitation et équipement Centre Recherches Océanographiques (CRO)','2025-06-05','2025-08-05',37,NULL,'2026-09-20 11:06:26','2026-09-20 11:06:26'),(63,'Exécution et réception des travaux','Tâche rattachée à : Poursuivre la réhabilitation et équipement Centre Recherches Océanographiques (CRO)','2025-12-05','2026-08-05',38,NULL,'2026-09-20 11:06:26','2026-09-20 11:06:26'),(64,'Réalisation des études techniques','Tâche rattachée à : Étendre les infrastructures de l\'Université de Man','2024-09-09','2025-05-09',39,21,'2026-09-20 11:06:28','2026-09-20 11:06:28'),(65,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Étendre les infrastructures de l\'Université de Man','2024-09-09','2024-11-09',39,NULL,'2026-09-20 11:06:28','2026-09-20 11:06:28'),(66,'Réalisation des études techniques','Tâche rattachée à : Construire et équiper le garage école de Daloa','2025-06-13','2026-02-13',40,22,'2026-09-20 11:06:29','2026-09-20 11:06:29'),(67,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire et équiper le garage école de Daloa','2025-06-13','2025-08-13',40,NULL,'2026-09-20 11:06:29','2026-09-20 11:06:29'),(68,'Exécution et réception des travaux','Tâche rattachée à : Construire et équiper le garage école de Daloa','2025-12-13','2026-08-13',41,NULL,'2026-09-20 11:06:30','2026-09-20 11:06:30'),(69,'Réalisation des études techniques','Tâche rattachée à : Construire un lycée professionnel agricole à Sahué sous-préfecture de Sikensi','2027-03-23','2027-11-23',42,NULL,'2026-09-20 11:06:30','2026-09-20 11:06:30'),(70,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire un lycée professionnel agricole à Sahué sous-préfecture de Sikensi','2027-03-23','2027-05-23',42,NULL,'2026-09-20 11:06:31','2026-09-20 11:06:31'),(71,'Réalisation des études techniques','Tâche rattachée à : Construire deux (2) villages d\'artisans','2023-06-21','2024-02-21',43,23,'2026-09-20 11:06:33','2026-09-20 11:06:33'),(72,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire deux (2) villages d\'artisans','2023-06-21','2023-08-21',43,NULL,'2026-09-20 11:06:33','2026-09-20 11:06:33'),(73,'Exécution et réception des travaux','Tâche rattachée à : Construire deux (2) villages d\'artisans','2023-12-21','2024-08-21',44,NULL,'2026-09-20 11:06:33','2026-09-20 11:06:33'),(74,'Réalisation des études techniques','Tâche rattachée à : Développer l\'écotourisme côtier (plages, mangroves, excursions lagunaires)','2025-06-25','2026-02-25',45,24,'2026-09-20 11:06:34','2026-09-20 11:06:34'),(75,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Développer l\'écotourisme côtier (plages, mangroves, excursions lagunaires)','2025-06-25','2025-08-25',45,NULL,'2026-09-20 11:06:34','2026-09-20 11:06:34'),(76,'Réalisation des études techniques','Tâche rattachée à : Mettre en œuvre le projet de pôle agro-industriel dans le nord-est de la Côte d\'Ivoire','2025-06-29','2026-03-01',46,25,'2026-09-20 11:06:36','2026-09-20 11:06:36'),(77,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Mettre en œuvre le projet de pôle agro-industriel dans le nord-est de la Côte d\'Ivoire','2025-06-29','2025-08-29',46,NULL,'2026-09-20 11:06:36','2026-09-20 11:06:36'),(78,'Exécution et réception des travaux','Tâche rattachée à : Mettre en œuvre le projet de pôle agro-industriel dans le nord-est de la Côte d\'Ivoire','2025-12-29','2026-08-29',47,NULL,'2026-09-20 11:06:37','2026-09-20 11:06:37'),(79,'Réalisation des études techniques','Tâche rattachée à : Créer des unités de transformation de manioc','2027-04-04','2027-12-04',48,NULL,'2026-09-20 11:06:39','2026-09-20 11:06:39'),(80,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Créer des unités de transformation de manioc','2027-04-04','2027-06-04',48,NULL,'2026-09-20 11:06:40','2026-09-20 11:06:40'),(81,'Réalisation des études techniques','Tâche rattachée à : Créer des points de vente des produits issus des élevages en développement','2023-07-11','2024-03-11',49,26,'2026-09-20 11:06:43','2026-09-20 11:06:43'),(82,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Créer des points de vente des produits issus des élevages en développement','2023-07-11','2023-09-11',49,NULL,'2026-09-20 11:06:44','2026-09-20 11:06:44'),(83,'Exécution et réception des travaux','Tâche rattachée à : Créer des points de vente des produits issus des élevages en développement','2024-01-11','2024-09-11',50,NULL,'2026-09-20 11:06:45','2026-09-20 11:06:45'),(84,'Réalisation des études techniques','Tâche rattachée à : Installer 6 fermes aquacoles','2024-06-12','2025-02-12',51,27,'2026-09-20 11:06:47','2026-09-20 11:06:47'),(85,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Installer 6 fermes aquacoles','2024-06-12','2024-08-12',51,NULL,'2026-09-20 11:06:47','2026-09-20 11:06:47'),(86,'Réalisation des études techniques','Tâche rattachée à : Aménager et meubler le siège du Conseil régional et la résidence du directeur général de l\'administr','2025-07-15','2026-03-15',52,28,'2026-09-20 11:06:50','2026-09-20 11:06:50'),(87,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Aménager et meubler le siège du Conseil régional et la résidence du directeur général de l','2025-07-15','2025-09-15',52,NULL,'2026-09-20 11:06:50','2026-09-20 11:06:50'),(88,'Exécution et réception des travaux','Tâche rattachée à : Aménager et meubler le siège du Conseil régional et la résidence du directeur général de l\'administr','2026-01-15','2026-09-15',53,NULL,'2026-09-20 11:06:51','2026-09-20 11:06:51'),(89,'Réalisation des études techniques','Tâche rattachée à : Restructurer et aménager les quartiers précaires d\'Abidjan','2024-10-19','2025-06-19',54,29,'2026-09-20 11:06:53','2026-09-20 11:06:53'),(90,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Restructurer et aménager les quartiers précaires d\'Abidjan','2024-10-19','2024-12-19',54,NULL,'2026-09-20 11:06:53','2026-09-20 11:06:53'),(91,'Réalisation des études techniques','Tâche rattachée à : Poursuivre la dotation des communes ne disposant pas de service délégué de propreté en matériel de s','2025-07-23','2026-03-23',55,30,'2026-09-20 11:06:54','2026-09-20 11:06:54'),(92,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre la dotation des communes ne disposant pas de service délégué de propreté en mat','2025-07-23','2025-09-23',55,NULL,'2026-09-20 11:06:54','2026-09-20 11:06:54'),(93,'Exécution et réception des travaux','Tâche rattachée à : Poursuivre la dotation des communes ne disposant pas de service délégué de propreté en matériel de s','2026-01-23','2026-09-23',56,NULL,'2026-09-20 11:06:55','2026-09-20 11:06:55'),(94,'Réalisation des études techniques','Tâche rattachée à : Construire un (01) Centre de Valorisation et d\'Enfouissement Technique à Bonon','2027-04-22','2027-12-22',57,NULL,'2026-09-20 11:06:55','2026-09-20 11:06:55'),(95,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire un (01) Centre de Valorisation et d\'Enfouissement Technique à Bonon','2027-04-22','2027-06-22',57,NULL,'2026-09-20 11:06:56','2026-09-20 11:06:56'),(96,'Réalisation des études techniques','Tâche rattachée à : Construire 45 ESPC dont 14 dispensaires ruraux, 21 centres de santé urbains et 10 centres de santé r','2023-08-10','2024-04-10',58,31,'2026-09-20 11:06:58','2026-09-20 11:06:58'),(97,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire 45 ESPC dont 14 dispensaires ruraux, 21 centres de santé urbains et 10 centres','2023-08-10','2023-10-10',58,NULL,'2026-09-20 11:06:58','2026-09-20 11:06:58'),(98,'Exécution et réception des travaux','Tâche rattachée à : Construire 45 ESPC dont 14 dispensaires ruraux, 21 centres de santé urbains et 10 centres de santé r','2024-02-10','2024-10-10',59,NULL,'2026-09-20 11:06:59','2026-09-20 11:06:59'),(99,'Réalisation des études techniques','Tâche rattachée à : Renforcer la production d\'oxygène dans les établissements sanitaires de référence','2025-08-04','2026-04-04',60,32,'2026-09-20 11:07:01','2026-09-20 11:07:01'),(100,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Renforcer la production d\'oxygène dans les établissements sanitaires de référence','2025-08-04','2025-10-04',60,NULL,'2026-09-20 11:07:01','2026-09-20 11:07:01'),(101,'Réalisation des études techniques','Tâche rattachée à : Poursuivre la construction de la mine d\'or KONÉ, dans les départements de Kani','2025-08-08','2026-04-08',61,33,'2026-09-20 11:07:02','2026-09-20 11:07:02'),(102,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre la construction de la mine d\'or KONÉ, dans les départements de Kani','2025-08-08','2025-10-08',61,NULL,'2026-09-20 11:07:02','2026-09-20 11:07:02'),(103,'Exécution et réception des travaux','Tâche rattachée à : Poursuivre la construction de la mine d\'or KONÉ, dans les départements de Kani','2026-02-08','2026-10-08',62,NULL,'2026-09-20 11:07:03','2026-09-20 11:07:03'),(104,'Réalisation des études techniques','Tâche rattachée à : Poursuivre le projet minier aurifère avancé de la Bagoué (phase de développement)','2027-05-04','2028-01-04',63,NULL,'2026-09-20 11:07:04','2026-09-20 11:07:04'),(105,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre le projet minier aurifère avancé de la Bagoué (phase de développement)','2027-05-04','2027-07-04',63,NULL,'2026-09-20 11:07:04','2026-09-20 11:07:04'),(106,'Réalisation des études techniques','Tâche rattachée à : Mettre en œuvre le Projet de réalisation de la centrale solaire de Binguebougou (50 MWC)','2023-08-30','2024-04-30',64,34,'2026-09-20 11:07:06','2026-09-20 11:07:06'),(107,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Mettre en œuvre le Projet de réalisation de la centrale solaire de Binguebougou (50 MWC)','2023-08-30','2023-10-30',64,NULL,'2026-09-20 11:07:08','2026-09-20 11:07:08'),(108,'Exécution et réception des travaux','Tâche rattachée à : Mettre en œuvre le Projet de réalisation de la centrale solaire de Binguebougou (50 MWC)','2024-03-01','2024-10-30',65,NULL,'2026-09-20 11:07:09','2026-09-20 11:07:09'),(109,'Réalisation des études techniques','Tâche rattachée à : Mettre en œuvre le Programme Électricité Pour Tous (PEPT) par le branchement de 400 000 ménages au n','2024-07-22','2025-03-22',66,35,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(110,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Mettre en œuvre le Programme Électricité Pour Tous (PEPT) par le branchement de 400 000 mé','2024-07-22','2024-09-22',66,NULL,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(111,'Réalisation des études techniques','Tâche rattachée à : Promouvoir les arts, traditions et savoir-faire locaux (danse, artisanat, musique)','2025-08-24','2026-04-24',67,36,'2026-09-20 11:07:11','2026-09-20 11:07:11'),(112,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Promouvoir les arts, traditions et savoir-faire locaux (danse, artisanat, musique)','2025-08-24','2025-10-24',67,NULL,'2026-09-20 11:07:12','2026-09-20 11:07:12'),(113,'Exécution et réception des travaux','Tâche rattachée à : Promouvoir les arts, traditions et savoir-faire locaux (danse, artisanat, musique)','2026-02-24','2026-10-24',68,NULL,'2026-09-20 11:07:13','2026-09-20 11:07:13'),(114,'Réalisation des études techniques','Tâche rattachée à : Développer des infrastructures touristiques (hébergements, routes d\'accès, signalétique)','2024-11-28','2025-07-28',69,37,'2026-09-20 11:07:14','2026-09-20 11:07:14'),(115,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Développer des infrastructures touristiques (hébergements, routes d\'accès, signalétique)','2024-11-28','2025-01-28',69,NULL,'2026-09-20 11:07:14','2026-09-20 11:07:14'),(116,'Réalisation des études techniques','Tâche rattachée à : Mettre en place un système de suivi-évaluation pour le suivi des projets et leur impact socio-économ','2025-09-01','2026-05-01',70,38,'2026-09-20 11:07:17','2026-09-20 11:07:17'),(117,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Mettre en place un système de suivi-évaluation pour le suivi des projets et leur impact so','2025-09-01','2025-11-01',70,NULL,'2026-09-20 11:07:17','2026-09-20 11:07:17'),(118,'Exécution et réception des travaux','Tâche rattachée à : Mettre en place un système de suivi-évaluation pour le suivi des projets et leur impact socio-économ','2026-03-01','2026-11-01',71,NULL,'2026-09-20 11:07:17','2026-09-20 11:07:17'),(119,'Réalisation des études techniques','Tâche rattachée à : Construire et équiper un centre régional d\'archives','2027-05-22','2028-01-22',72,NULL,'2026-09-20 11:07:18','2026-09-20 11:07:18'),(120,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire et équiper un centre régional d\'archives','2027-05-22','2027-07-22',72,NULL,'2026-09-20 11:07:19','2026-09-20 11:07:19'),(121,'Réalisation des études techniques','Tâche rattachée à : Réhabiliter et équiper les services de l\'administration du travail d\'Adjamé','2023-09-29','2024-05-29',73,39,'2026-09-20 11:07:21','2026-09-20 11:07:21'),(122,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Réhabiliter et équiper les services de l\'administration du travail d\'Adjamé','2023-09-29','2023-11-29',73,NULL,'2026-09-20 11:07:21','2026-09-20 11:07:21'),(123,'Exécution et réception des travaux','Tâche rattachée à : Réhabiliter et équiper les services de l\'administration du travail d\'Adjamé','2024-03-29','2024-11-29',74,NULL,'2026-09-20 11:07:22','2026-09-20 11:07:22'),(124,'Réalisation des études techniques','Tâche rattachée à : Poursuivre l\'enrôlement au RSTI et à la CMU','2025-09-13','2026-05-13',75,40,'2026-09-20 11:07:25','2026-09-20 11:07:25'),(125,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre l\'enrôlement au RSTI et à la CMU','2025-09-13','2025-11-13',75,NULL,'2026-09-20 11:07:25','2026-09-20 11:07:25'),(126,'Réalisation des études techniques','Tâche rattachée à : Aménager et équiper des Crèches garderies dans les CPPE des régions non pourvues dont l\'Agnéby-Tiass','2025-09-17','2026-05-17',76,41,'2026-09-20 11:07:26','2026-09-20 11:07:26'),(127,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Aménager et équiper des Crèches garderies dans les CPPE des régions non pourvues dont l\'Ag','2025-09-17','2025-11-17',76,NULL,'2026-09-20 11:07:27','2026-09-20 11:07:27'),(128,'Exécution et réception des travaux','Tâche rattachée à : Aménager et équiper des Crèches garderies dans les CPPE des régions non pourvues dont l\'Agnéby-Tiass','2026-03-17','2026-11-17',77,NULL,'2026-09-20 11:07:27','2026-09-20 11:07:27'),(129,'Réalisation des études techniques','Tâche rattachée à : Construire et équiper des CACE dans les sous-préfectures de la région de l\'Agnéby-Tiassa','2027-06-03','2028-02-03',78,NULL,'2026-09-20 11:07:29','2026-09-20 11:07:29'),(130,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire et équiper des CACE dans les sous-préfectures de la région de l\'Agnéby-Tiassa','2027-06-03','2027-08-03',78,NULL,'2026-09-20 11:07:29','2026-09-20 11:07:29'),(131,'Réalisation des études techniques','Tâche rattachée à : Acquérir un bac pour la traversée à Béoumi','2023-10-19','2024-06-19',79,42,'2026-09-20 11:07:30','2026-09-20 11:07:30'),(132,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Acquérir un bac pour la traversée à Béoumi','2023-10-19','2023-12-19',79,NULL,'2026-09-20 11:07:30','2026-09-20 11:07:30'),(133,'Exécution et réception des travaux','Tâche rattachée à : Acquérir un bac pour la traversée à Béoumi','2024-04-19','2024-12-19',80,NULL,'2026-09-20 11:07:30','2026-09-20 11:07:30'),(134,'Réalisation des études techniques','Tâche rattachée à : Construire et renforcer les routes (reprofilage lourd et léger) et ouvrages','2024-08-31','2025-05-01',81,43,'2026-09-20 11:07:32','2026-09-20 11:07:32'),(135,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire et renforcer les routes (reprofilage lourd et léger) et ouvrages','2024-08-31','2024-10-31',81,NULL,'2026-09-20 11:07:32','2026-09-20 11:07:32'),(136,'Réalisation des études techniques','Tâche rattachée à : Construire une caserne de sapeurs-pompiers','2025-10-03','2026-06-03',82,44,'2026-09-20 11:07:33','2026-09-20 11:07:33'),(137,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire une caserne de sapeurs-pompiers','2025-10-03','2025-12-03',82,NULL,'2026-09-20 11:07:34','2026-09-20 11:07:34'),(138,'Exécution et réception des travaux','Tâche rattachée à : Construire une caserne de sapeurs-pompiers','2026-04-03','2026-12-03',83,NULL,'2026-09-20 11:07:34','2026-09-20 11:07:34'),(139,'Réalisation des études techniques','Tâche rattachée à : Construire et équiper des centres de manœuvres et d\'entrainements','2025-01-07','2025-09-07',84,45,'2026-09-20 11:07:35','2026-09-20 11:07:35'),(140,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire et équiper des centres de manœuvres et d\'entrainements','2025-01-07','2025-03-07',84,NULL,'2026-09-20 11:07:35','2026-09-20 11:07:35'),(141,'Réalisation des études techniques','Tâche rattachée à : Développer une brigade municipale de prévention (sécurité routière, environnement)','2025-10-11','2026-06-11',85,46,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(142,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Développer une brigade municipale de prévention (sécurité routière, environnement)','2025-10-11','2025-12-11',85,NULL,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(143,'Exécution et réception des travaux','Tâche rattachée à : Développer une brigade municipale de prévention (sécurité routière, environnement)','2026-04-11','2026-12-11',86,NULL,'2026-09-20 11:07:36','2026-09-20 11:07:36'),(144,'Réalisation des études techniques','Tâche rattachée à : Renforcer la vidéosurveillance et la présence policière dans les zones sensibles','2027-06-21','2028-02-21',87,NULL,'2026-09-20 11:07:38','2026-09-20 11:07:38'),(145,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Renforcer la vidéosurveillance et la présence policière dans les zones sensibles','2027-06-21','2027-08-21',87,NULL,'2026-09-20 11:07:38','2026-09-20 11:07:38'),(146,'Réalisation des études techniques','Tâche rattachée à : Insertion de 27 458 jeunes aux programmes d\'insertion professionnelle (2023 -2025)','2023-11-18','2024-07-18',88,47,'2026-09-20 11:07:39','2026-09-20 11:07:39'),(147,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Insertion de 27 458 jeunes aux programmes d\'insertion professionnelle (2023 -2025)','2023-11-18','2024-01-18',88,NULL,'2026-09-20 11:07:39','2026-09-20 11:07:39'),(148,'Exécution et réception des travaux','Tâche rattachée à : Insertion de 27 458 jeunes aux programmes d\'insertion professionnelle (2023 -2025)','2024-05-18','2025-01-18',89,NULL,'2026-09-20 11:07:39','2026-09-20 11:07:39'),(149,'Réalisation des études techniques','Tâche rattachée à : Construire et équiper 12 Agences (une dans chacune des Sous-Préfectures) types de l\'agence emploi je','2025-10-23','2026-06-23',90,48,'2026-09-20 11:07:41','2026-09-20 11:07:41'),(150,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire et équiper 12 Agences (une dans chacune des Sous-Préfectures) types de l\'agence','2025-10-23','2025-12-23',90,NULL,'2026-09-20 11:07:41','2026-09-20 11:07:41'),(151,'Réalisation des études techniques','Tâche rattachée à : Promouvoir l\'énergie renouvelable (solaire sur bâtiments publics et éclairage public)','2025-10-27','2026-06-27',91,49,'2026-09-20 11:07:45','2026-09-20 11:07:45'),(152,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Promouvoir l\'énergie renouvelable (solaire sur bâtiments publics et éclairage public)','2025-10-27','2025-12-27',91,NULL,'2026-09-20 11:07:45','2026-09-20 11:07:45'),(153,'Exécution et réception des travaux','Tâche rattachée à : Promouvoir l\'énergie renouvelable (solaire sur bâtiments publics et éclairage public)','2026-04-27','2026-12-27',92,NULL,'2026-09-20 11:07:45','2026-09-20 11:07:45'),(154,'Réalisation des études techniques','Tâche rattachée à : Mettre en place des centres de traitement des eaux usées et de lutte contre les inondations','2027-07-03','2028-03-03',93,NULL,'2026-09-20 11:07:47','2026-09-20 11:07:47'),(155,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Mettre en place des centres de traitement des eaux usées et de lutte contre les inondation','2027-07-03','2027-09-03',93,NULL,'2026-09-20 11:07:47','2026-09-20 11:07:47'),(156,'Réalisation des études techniques','Tâche rattachée à : Construire le Lycée Professionnel de Toumodi','2023-12-08','2024-08-08',94,50,'2026-09-20 11:07:49','2026-09-20 11:07:49'),(157,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire le Lycée Professionnel de Toumodi','2023-12-08','2024-02-08',94,NULL,'2026-09-20 11:07:49','2026-09-20 11:07:49'),(158,'Exécution et réception des travaux','Tâche rattachée à : Construire le Lycée Professionnel de Toumodi','2024-06-08','2025-02-08',95,NULL,'2026-09-20 11:07:50','2026-09-20 11:07:50'),(159,'Réalisation des études techniques','Tâche rattachée à : Aménager et bitumer la route Séguéla-Kongasso-Kounahiri (100 km)','2024-10-10','2025-06-10',96,51,'2026-09-20 11:07:53','2026-09-20 11:07:53'),(160,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Aménager et bitumer la route Séguéla-Kongasso-Kounahiri (100 km)','2024-10-10','2024-12-10',96,NULL,'2026-09-20 11:07:53','2026-09-20 11:07:53'),(161,'Réalisation des études techniques','Tâche rattachée à : Poursuivre la construction du Lycée d\'Excellence de jeunes filles de Bouna','2025-11-12','2026-07-12',97,52,'2026-09-20 11:07:57','2026-09-20 11:07:57'),(162,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre la construction du Lycée d\'Excellence de jeunes filles de Bouna','2025-11-12','2026-01-12',97,NULL,'2026-09-20 11:07:57','2026-09-20 11:07:57'),(163,'Exécution et réception des travaux','Tâche rattachée à : Poursuivre la construction du Lycée d\'Excellence de jeunes filles de Bouna','2026-05-12','2027-01-12',98,NULL,'2026-09-20 11:07:57','2026-09-20 11:07:57'),(164,'Réalisation des études techniques','Tâche rattachée à : Reconstruire aux normes le marché de détail de Guiglo','2025-02-16','2025-10-16',99,53,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(165,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Reconstruire aux normes le marché de détail de Guiglo','2025-02-16','2025-04-16',99,NULL,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(166,'Réalisation des études techniques','Tâche rattachée à : Construire le pont sur l\'axe Banankoro - Manadoun','2025-11-20','2026-07-20',100,54,'2026-09-20 11:08:02','2026-09-20 11:08:02'),(167,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire le pont sur l\'axe Banankoro - Manadoun','2025-11-20','2026-01-20',100,NULL,'2026-09-20 11:08:02','2026-09-20 11:08:02'),(168,'Exécution et réception des travaux','Tâche rattachée à : Construire le pont sur l\'axe Banankoro - Manadoun','2026-05-20','2027-01-20',101,NULL,'2026-09-20 11:08:02','2026-09-20 11:08:02'),(169,'Réalisation des études techniques','Tâche rattachée à : Aménager et bitumer la route Guéhiebly - Zou - Mahapleu (91 km)','2027-07-21','2028-03-21',102,NULL,'2026-09-20 11:08:05','2026-09-20 11:08:05'),(170,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Aménager et bitumer la route Guéhiebly - Zou - Mahapleu (91 km)','2027-07-21','2027-09-21',102,NULL,'2026-09-20 11:08:05','2026-09-20 11:08:05'),(171,'Réalisation des études techniques','Tâche rattachée à : Poursuivre la construction et l\'équipement du CHR de Katiola','2024-01-07','2024-09-07',103,55,'2026-09-20 11:08:07','2026-09-20 11:08:07'),(172,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre la construction et l\'équipement du CHR de Katiola','2024-01-07','2024-03-07',103,NULL,'2026-09-20 11:08:07','2026-09-20 11:08:07'),(173,'Exécution et réception des travaux','Tâche rattachée à : Poursuivre la construction et l\'équipement du CHR de Katiola','2024-07-07','2025-03-07',104,NULL,'2026-09-20 11:08:07','2026-09-20 11:08:07'),(174,'Réalisation des études techniques','Tâche rattachée à : Construire l\'Université d\'Abengourou','2025-12-02','2026-08-02',105,56,'2026-09-20 11:08:11','2026-09-20 11:08:11'),(175,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire l\'Université d\'Abengourou','2025-12-02','2026-02-02',105,NULL,'2026-09-20 11:08:11','2026-09-20 11:08:11'),(176,'Réalisation des études techniques','Tâche rattachée à : Poursuivre la construction de dix (10) marchés dans le Lôh-Djiboua','2025-12-06','2026-08-06',106,57,'2026-09-20 11:08:17','2026-09-20 11:08:17'),(177,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre la construction de dix (10) marchés dans le Lôh-Djiboua','2025-12-06','2026-02-06',106,NULL,'2026-09-20 11:08:17','2026-09-20 11:08:17'),(178,'Exécution et réception des travaux','Tâche rattachée à : Poursuivre la construction de dix (10) marchés dans le Lôh-Djiboua','2026-06-06','2027-02-06',107,NULL,'2026-09-20 11:08:19','2026-09-20 11:08:19'),(179,'Réalisation des études techniques','Tâche rattachée à : Poursuivre les travaux de réhabilitation du groupe 3 de la centrale hydroélectrique de Buyo','2027-08-02','2028-04-02',108,NULL,'2026-09-20 11:08:21','2026-09-20 11:08:21'),(180,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Poursuivre les travaux de réhabilitation du groupe 3 de la centrale hydroélectrique de Buy','2027-08-02','2027-10-02',108,NULL,'2026-09-20 11:08:22','2026-09-20 11:08:22'),(181,'Réalisation des études techniques','Tâche rattachée à : Construire le Lycée Professionnel de Dimbokro','2024-01-27','2024-09-27',109,58,'2026-09-20 11:08:24','2026-09-20 11:08:24'),(182,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Construire le Lycée Professionnel de Dimbokro','2024-01-27','2024-03-27',109,NULL,'2026-09-20 11:08:24','2026-09-20 11:08:24'),(183,'Exécution et réception des travaux','Tâche rattachée à : Construire le Lycée Professionnel de Dimbokro','2024-07-27','2025-03-27',110,NULL,'2026-09-20 11:08:26','2026-09-20 11:08:26'),(184,'Réalisation des études techniques','Tâche rattachée à : Finaliser la construction des infrastructures et mettre en service le métro d\'Abidjan','2024-11-19','2025-07-19',111,59,'2026-09-20 11:08:35','2026-09-20 11:08:35'),(185,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Finaliser la construction des infrastructures et mettre en service le métro d\'Abidjan','2024-11-19','2025-01-19',111,NULL,'2026-09-20 11:08:35','2026-09-20 11:08:35'),(186,'Réalisation des études techniques','Tâche rattachée à : Finaliser la construction de la centrale à biomasse BIOVEA à Aboisso','2025-12-22','2026-08-22',112,60,'2026-09-20 11:08:39','2026-09-20 11:08:39'),(187,'Passation des marchés publics','Sélection et contractualisation des entreprises pour : Finaliser la construction de la centrale à biomasse BIOVEA à Aboisso','2025-12-22','2026-02-22',112,NULL,'2026-09-20 11:08:40','2026-09-20 11:08:40'),(188,'Exécution et réception des travaux','Tâche rattachée à : Finaliser la construction de la centrale à biomasse BIOVEA à Aboisso','2026-06-22','2027-02-22',113,NULL,'2026-09-20 11:08:41','2026-09-20 11:08:41');
/*!40000 ALTER TABLE `taches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types_analyse_causale`
--

DROP TABLE IF EXISTS `types_analyse_causale`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types_analyse_causale` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types_analyse_causale`
--

LOCK TABLES `types_analyse_causale` WRITE;
/*!40000 ALTER TABLE `types_analyse_causale` DISABLE KEYS */;
INSERT INTO `types_analyse_causale` VALUES (1,'Cause immédiate','2026-09-20 11:04:17','2026-09-20 11:04:17'),(2,'Cause sous-jacente','2026-09-20 11:04:17','2026-09-20 11:04:17'),(3,'Cause structurelle','2026-09-20 11:04:17','2026-09-20 11:04:17');
/*!40000 ALTER TABLE `types_analyse_causale` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types_bailleur`
--

DROP TABLE IF EXISTS `types_bailleur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types_bailleur` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types_bailleur`
--

LOCK TABLES `types_bailleur` WRITE;
/*!40000 ALTER TABLE `types_bailleur` DISABLE KEYS */;
INSERT INTO `types_bailleur` VALUES (1,'Institution multilatérale','2026-09-20 11:05:40','2026-09-20 11:05:40'),(2,'Institution bilatérale','2026-09-20 11:05:40','2026-09-20 11:05:40'),(3,'Banque de développement','2026-09-20 11:05:40','2026-09-20 11:05:40'),(4,'ONG','2026-09-20 11:05:40','2026-09-20 11:05:40'),(5,'Fonds public national','2026-09-20 11:05:40','2026-09-20 11:05:40');
/*!40000 ALTER TABLE `types_bailleur` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types_document`
--

DROP TABLE IF EXISTS `types_document`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types_document` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `types_document_libelle_unique` (`libelle`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types_document`
--

LOCK TABLES `types_document` WRITE;
/*!40000 ALTER TABLE `types_document` DISABLE KEYS */;
/*!40000 ALTER TABLE `types_document` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types_partie_prenante`
--

DROP TABLE IF EXISTS `types_partie_prenante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types_partie_prenante` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types_partie_prenante`
--

LOCK TABLES `types_partie_prenante` WRITE;
/*!40000 ALTER TABLE `types_partie_prenante` DISABLE KEYS */;
/*!40000 ALTER TABLE `types_partie_prenante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `types_structure`
--

DROP TABLE IF EXISTS `types_structure`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `types_structure` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `types_structure`
--

LOCK TABLES `types_structure` WRITE;
/*!40000 ALTER TABLE `types_structure` DISABLE KEYS */;
INSERT INTO `types_structure` VALUES (1,'Ministère','2026-09-20 11:05:27','2026-09-20 11:05:27'),(2,'Direction générale','2026-09-20 11:05:27','2026-09-20 11:05:27'),(3,'Direction centrale','2026-09-20 11:05:27','2026-09-20 11:05:27'),(4,'Établissement public','2026-09-20 11:05:28','2026-09-20 11:05:28'),(5,'Collectivité territoriale','2026-09-20 11:05:28','2026-09-20 11:05:28');
/*!40000 ALTER TABLE `types_structure` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('administrateur','gestionnaire_projet','responsable_financier','responsable_suivi_evaluation','consultant') NOT NULL DEFAULT 'consultant',
  `actif` tinyint(1) NOT NULL DEFAULT 1,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Hien Toto','I.','i.hien@plan.gouv.ci',NULL,'$2y$12$KTivUCYWIX1Wkni5q7eu7OBNzX7lZ4T/lk3k9tZS5qy11Lc8sZPe2','administrateur',1,NULL,'2026-09-20 11:05:25','2026-09-20 11:05:25'),(2,'Gbané','I.','i.gbane@plan.gouv.ci',NULL,'$2y$12$QNeZ9qmNXCyMITPBad7fuu41Zldv.3SE7zjSX2vSKZJpg8GQvl2X2','gestionnaire_projet',1,NULL,'2026-09-20 11:05:25','2026-09-20 11:05:25'),(3,'Diarrassouba','I.','i.diarra@plan.gouv.ci',NULL,'$2y$12$uoZspdXOlCHc.Y937eK4veLL8KceYgoozZqwgDJk/pnB5O0ts3IS2','responsable_financier',1,NULL,'2026-09-20 11:05:25','2026-09-20 11:05:25'),(4,'Yapo','I.','i.yapo@plan.gouv.ci',NULL,'$2y$12$WoSxAxBmS6LcNI0SagF4Yul5tJkIPJwHlAJE2FigOYdwGR.Qgi82G','responsable_suivi_evaluation',1,NULL,'2026-09-20 11:05:26','2026-09-20 11:05:26'),(5,'Bohoussou','I.','i.bohoussou@plan.gouv.ci',NULL,'$2y$12$HxPe4qsScTgvnh8rj2NW.eHeDO65o4WkxR4U6nW/zY4hpGKOiGP2u','consultant',1,NULL,'2026-09-20 11:05:26','2026-09-20 11:05:26');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `villages`
--

DROP TABLE IF EXISTS `villages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `villages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sous_prefecture_id` bigint(20) unsigned NOT NULL,
  `nom` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `villages_sous_prefecture_id_foreign` (`sous_prefecture_id`),
  CONSTRAINT `villages_sous_prefecture_id_foreign` FOREIGN KEY (`sous_prefecture_id`) REFERENCES `sous_prefectures` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `villages`
--

LOCK TABLES `villages` WRITE;
/*!40000 ALTER TABLE `villages` DISABLE KEYS */;
/*!40000 ALTER TABLE `villages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `zones_localisation`
--

DROP TABLE IF EXISTS `zones_localisation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `zones_localisation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `pays` varchar(255) DEFAULT NULL,
  `pays_etranger_id` bigint(20) unsigned DEFAULT NULL,
  `latitude` decimal(10,6) DEFAULT NULL,
  `longitude` decimal(10,6) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `zones_localisation_pays_etranger_id_foreign` (`pays_etranger_id`),
  CONSTRAINT `zones_localisation_pays_etranger_id_foreign` FOREIGN KEY (`pays_etranger_id`) REFERENCES `pays_etrangers` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `zones_localisation`
--

LOCK TABLES `zones_localisation` WRITE;
/*!40000 ALTER TABLE `zones_localisation` DISABLE KEYS */;
INSERT INTO `zones_localisation` VALUES (1,'Territoire national','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:34','2026-09-20 11:05:34'),(2,'Moronou','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:42','2026-09-20 11:05:42'),(3,'Kabadougou','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:46','2026-09-20 11:05:46'),(4,'Songon','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:48','2026-09-20 11:05:48'),(5,'Yopougon','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:51','2026-09-20 11:05:51'),(6,'Gbêkê','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:52','2026-09-20 11:05:52'),(7,'Treichville','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:53','2026-09-20 11:05:53'),(8,'Tonkpi','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:54','2026-09-20 11:05:54'),(9,'Grands-Ponts','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:56','2026-09-20 11:05:56'),(10,'Marahoué','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:58','2026-09-20 11:05:58'),(11,'Gbôklé','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:05:59','2026-09-20 11:05:59'),(12,'Gôh','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:03','2026-09-20 11:06:03'),(13,'Attécoubé','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:05','2026-09-20 11:06:05'),(14,'La Mé','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:07','2026-09-20 11:06:07'),(15,'District Autonome d\'Abidjan','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:10','2026-09-20 11:06:10'),(16,'Port-Bouët','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:11','2026-09-20 11:06:11'),(17,'Bagoué','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:13','2026-09-20 11:06:13'),(18,'Haut-Sassandra','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:14','2026-09-20 11:06:14'),(19,'Bafing','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:21','2026-09-20 11:06:21'),(20,'Agnéby-Tiassa','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:30','2026-09-20 11:06:30'),(21,'Gontougo','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:35','2026-09-20 11:06:35'),(22,'District Autonome de Yamoussoukro','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:41','2026-09-20 11:06:41'),(23,'San-Pédro','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:06:46','2026-09-20 11:06:46'),(24,'Worodougou','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:01','2026-09-20 11:07:01'),(25,'Poro','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:04','2026-09-20 11:07:04'),(26,'Abobo','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:10','2026-09-20 11:07:10'),(27,'Bingerville','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:13','2026-09-20 11:07:13'),(28,'Adjamé','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:15','2026-09-20 11:07:15'),(29,'Iffou','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:32','2026-09-20 11:07:32'),(30,'Koumassi','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:35','2026-09-20 11:07:35'),(31,'Tchologo','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:40','2026-09-20 11:07:40'),(32,'Marcory','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:42','2026-09-20 11:07:42'),(33,'Cocody','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:46','2026-09-20 11:07:46'),(34,'Bélier','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:48','2026-09-20 11:07:48'),(35,'Béré','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:52','2026-09-20 11:07:52'),(36,'Bounkani','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:54','2026-09-20 11:07:54'),(37,'Cavally','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:58','2026-09-20 11:07:58'),(38,'Folon','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:07:59','2026-09-20 11:07:59'),(39,'Guémon','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:08:03','2026-09-20 11:08:03'),(40,'Hambol','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:08:06','2026-09-20 11:08:06'),(41,'Indénié-Djuablin','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:08:08','2026-09-20 11:08:08'),(42,'Lôh-Djiboua','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:08:12','2026-09-20 11:08:12'),(43,'Nawa','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:08:20','2026-09-20 11:08:20'),(44,'Nzi','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:08:22','2026-09-20 11:08:22'),(45,'Le Plateau','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:08:28','2026-09-20 11:08:28'),(46,'Sud-Comoé','Côte d\'Ivoire',NULL,NULL,NULL,'2026-09-20 11:08:36','2026-09-20 11:08:36');
/*!40000 ALTER TABLE `zones_localisation` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-23  1:20:17
