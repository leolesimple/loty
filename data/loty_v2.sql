-- MySQL dump 10.13  Distrib 9.5.0, for macos26.1 (arm64)
--
-- Host: localhost    Database: loty
-- ------------------------------------------------------
-- Server version	9.5.0

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
-- Table structure for table `bento`
--

DROP TABLE IF EXISTS `bento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bento` (
  `id_bento` int NOT NULL AUTO_INCREMENT,
  `bento_nom` text NOT NULL,
  `description` text NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_bento`),
  KEY `user_bento` (`id_user`),
  CONSTRAINT `user_bento` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bento`
--

LOCK TABLES `bento` WRITE;
/*!40000 ALTER TABLE `bento` DISABLE KEYS */;
INSERT INTO `bento` VALUES (1,'Lion','Dame un grrr (⸘un qué?)\r\nUn grrr (⸘un qué, un qué?)\r\nUn grrr (⸘un qué?)\r\nUn grrr',1),(2,'Bento du midi','Un bento simple et efficace pour le déjeuner',1),(3,'Bento rapide','Bento fait à l’arrache mais ça nourrit',1),(4,'Bento comfort','Du gras, du chaud, du bonheur',1),(5,'Bento test','Bento uniquement là pour casser le front',1),(6,'Bento zéro motivation','Quand t’as faim mais aucune envie de cuisiner',1),(7,'Bento random','On met ce qu’on trouve et on voit après',1);
/*!40000 ALTER TABLE `bento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bento_recettes`
--

DROP TABLE IF EXISTS `bento_recettes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bento_recettes` (
  `id_bento` int NOT NULL,
  `id_recette` int NOT NULL,
  KEY `fk_bento_recettes_bento` (`id_bento`),
  KEY `fk_recette_bento_recette` (`id_recette`),
  CONSTRAINT `fk_bento_recettes_bento` FOREIGN KEY (`id_bento`) REFERENCES `bento` (`id_bento`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `fk_recette_bento_recette` FOREIGN KEY (`id_recette`) REFERENCES `recette` (`id_recette`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bento_recettes`
--

LOCK TABLES `bento_recettes` WRITE;
/*!40000 ALTER TABLE `bento_recettes` DISABLE KEYS */;
INSERT INTO `bento_recettes` VALUES (1,1),(2,2),(3,2),(4,3),(5,4),(6,5),(7,6);
/*!40000 ALTER TABLE `bento_recettes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enregistrements`
--

DROP TABLE IF EXISTS `enregistrements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `enregistrements` (
  `id_enregistrements` int NOT NULL AUTO_INCREMENT,
  `nom_enregistrements` varchar(60) NOT NULL,
  `cover` text NOT NULL,
  `description` int NOT NULL,
  `creation_enregistrements` datetime NOT NULL,
  `modification_enregistrements` datetime NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_enregistrements`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enregistrements`
--

LOCK TABLES `enregistrements` WRITE;
/*!40000 ALTER TABLE `enregistrements` DISABLE KEYS */;
/*!40000 ALTER TABLE `enregistrements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etapes_recettes`
--

DROP TABLE IF EXISTS `etapes_recettes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `etapes_recettes` (
  `id_recette` int NOT NULL,
  `num_etape` int DEFAULT NULL,
  `description_etape` text NOT NULL,
  KEY `fk_recette_etapes` (`id_recette`),
  CONSTRAINT `fk_recette_etapes` FOREIGN KEY (`id_recette`) REFERENCES `recette` (`id_recette`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etapes_recettes`
--

LOCK TABLES `etapes_recettes` WRITE;
/*!40000 ALTER TABLE `etapes_recettes` DISABLE KEYS */;
INSERT INTO `etapes_recettes` VALUES (2,1,'Préchauffer le four à 180°C'),(2,2,'Mélanger les ingrédients dans un saladier'),(2,3,'Verser dans un plat et enfourner 25 minutes');
/*!40000 ALTER TABLE `etapes_recettes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredients` (
  `id_ingredient` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `allergenes` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_ingredient`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredients`
--

LOCK TABLES `ingredients` WRITE;
/*!40000 ALTER TABLE `ingredients` DISABLE KEYS */;
INSERT INTO `ingredients` VALUES (1,'poivre',NULL),(2,'sel',NULL),(3,'muscade',NULL),(4,'farine',NULL),(5,'beurre',NULL),(6,'crème fraîche',NULL),(7,'lait entier',NULL),(8,'comté',NULL),(9,'huile',NULL),(10,'œuf',NULL),(11,'eau',NULL),(12,'chapelure',NULL);
/*!40000 ALTER TABLE `ingredients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ingredients_recettes`
--

DROP TABLE IF EXISTS `ingredients_recettes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ingredients_recettes` (
  `id_ingredients` int NOT NULL,
  `id_recette` int NOT NULL,
  `quantite` float DEFAULT NULL,
  `unites` int NOT NULL,
  KEY `ingredients` (`id_ingredients`),
  KEY `recette` (`id_recette`),
  KEY `unit` (`unites`),
  CONSTRAINT `ingredients` FOREIGN KEY (`id_ingredients`) REFERENCES `ingredients` (`id_ingredient`),
  CONSTRAINT `recette` FOREIGN KEY (`id_recette`) REFERENCES `recette` (`id_recette`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `unit` FOREIGN KEY (`unites`) REFERENCES `unites` (`id_unites`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ingredients_recettes`
--

LOCK TABLES `ingredients_recettes` WRITE;
/*!40000 ALTER TABLE `ingredients_recettes` DISABLE KEYS */;
INSERT INTO `ingredients_recettes` VALUES (5,1,27,1),(12,1,NULL,5),(8,1,67,1),(6,1,NULL,1),(11,1,125,4),(4,1,27,1),(9,1,4,1),(7,1,250,4),(3,1,NULL,5),(1,1,NULL,5),(2,1,NULL,5),(10,1,1,5),(4,2,50,1),(5,2,30,1),(6,2,20,2),(8,2,60,1),(10,2,1,3),(2,2,1,1),(1,2,1,1),(7,2,200,2),(2,2,1,1),(1,2,1,1),(11,3,300,2),(9,3,20,2),(2,3,1,1),(10,4,2,3),(5,4,10,1),(2,4,1,1),(1,4,1,1),(4,5,40,1),(6,5,20,2),(8,5,60,1),(2,5,1,1),(12,6,50,1),(10,6,1,3),(9,6,30,2);
/*!40000 ALTER TABLE `ingredients_recettes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liste_bento`
--

DROP TABLE IF EXISTS `liste_bento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `liste_bento` (
  `id_liste` int NOT NULL,
  `id_bento` int NOT NULL,
  KEY `liste` (`id_liste`),
  CONSTRAINT `liste` FOREIGN KEY (`id_liste`) REFERENCES `liste_courses` (`id_liste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liste_bento`
--

LOCK TABLES `liste_bento` WRITE;
/*!40000 ALTER TABLE `liste_bento` DISABLE KEYS */;
/*!40000 ALTER TABLE `liste_bento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `liste_courses`
--

DROP TABLE IF EXISTS `liste_courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `liste_courses` (
  `id_liste` int NOT NULL AUTO_INCREMENT,
  `date_liste` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_bento` int NOT NULL,
  PRIMARY KEY (`id_liste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `liste_courses`
--

LOCK TABLES `liste_courses` WRITE;
/*!40000 ALTER TABLE `liste_courses` DISABLE KEYS */;
/*!40000 ALTER TABLE `liste_courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `recette`
--

DROP TABLE IF EXISTS `recette`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `recette` (
  `id_recette` int NOT NULL AUTO_INCREMENT,
  `recette_nom` varchar(175) NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_recette`),
  KEY `user recette` (`id_user`),
  CONSTRAINT `user recette` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `recette`
--

LOCK TABLES `recette` WRITE;
/*!40000 ALTER TABLE `recette` DISABLE KEYS */;
INSERT INTO `recette` VALUES (1,'Croquettes belges',1),(2,'Gratin de comté',1),(3,'Pâtes flemme',1),(4,'Riz gras',1),(5,'Omelette douteuse',1),(6,'Gratin de secours',1),(7,'Truc pané',1);
/*!40000 ALTER TABLE `recette` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unites`
--

DROP TABLE IF EXISTS `unites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `unites` (
  `id_unites` int NOT NULL AUTO_INCREMENT,
  `unites` varchar(45) NOT NULL,
  PRIMARY KEY (`id_unites`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unites`
--

LOCK TABLES `unites` WRITE;
/*!40000 ALTER TABLE `unites` DISABLE KEYS */;
INSERT INTO `unites` VALUES (1,'g'),(2,'kg'),(3,'L'),(4,'mL'),(5,' (vide)'),(6,'CàS'),(7,'CàC');
/*!40000 ALTER TABLE `unites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `nom` varchar(70) NOT NULL,
  `prenom` varchar(90) NOT NULL,
  `tag_allergie` text,
  `photo` text,
  `nb_bento` int NOT NULL DEFAULT '1',
  `bio` text,
  `motdepasse` text NOT NULL,
  `mail` text NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `role` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usernames` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','Admi','nistrateur','{}',NULL,1,'Administrateur du site.','$2y$12$Z9Mfo2TFE6umkBGiGSIUx.bL58w76.1PletOLHDEDwh0pBtEy3YzS','leolesimple@icloud.com','2025-12-10 08:51:59','admin');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `vote`
--

DROP TABLE IF EXISTS `vote`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `vote` (
  `id_vote` int NOT NULL,
  `id_bento` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_vote`),
  KEY `bento` (`id_user`),
  CONSTRAINT `bento` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `vote`
--

LOCK TABLES `vote` WRITE;
/*!40000 ALTER TABLE `vote` DISABLE KEYS */;
/*!40000 ALTER TABLE `vote` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'loty'
--

--
-- Dumping routines for database 'loty'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-24 18:21:26
