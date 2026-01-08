-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : jeu. 08 jan. 2026 à 23:12
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `loty`
--

-- --------------------------------------------------------

--
-- Structure de la table `bento`
--

DROP TABLE IF EXISTS `bento`;
CREATE TABLE IF NOT EXISTS `bento` (
  `id_bento` int NOT NULL AUTO_INCREMENT,
  `bento_nom` text NOT NULL,
  `description` text NOT NULL,
  `id_user` int NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_src` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  PRIMARY KEY (`id_bento`),
  KEY `user_bento` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bento`
--

INSERT INTO `bento` (`id_bento`, `bento_nom`, `description`, `id_user`, `date_creation`, `image_src`) VALUES
(1, 'Lion', 'Dame un grrr (⸘un qué?)\r\nUn grrr (⸘un qué, un qué?)\r\nUn grrr (⸘un qué?)\r\nUn grrr', 1, '2025-12-27 17:41:36', ''),
(2, 'Bento du midi', 'Un bento simple et efficace pour le déjeuner', 1, '2025-12-27 17:41:36', ''),
(3, 'Bento rapide', 'Bento fait à l’arrache mais ça nourrit', 1, '2025-12-27 17:41:36', ''),
(4, 'Bento comfort', 'Du gras, du chaud, du bonheur', 1, '2025-12-27 17:41:36', ''),
(5, 'Bento test', 'Bento uniquement là pour casser le front', 1, '2025-12-27 17:41:36', ''),
(6, 'Bento zéro motivation', 'Quand t’as faim mais aucune envie de cuisiner', 1, '2025-12-27 17:41:36', ''),
(7, 'Bento random', 'On met ce qu’on trouve et on voit après', 1, '2025-12-27 17:41:36', ''),
(8, 'Bento Italien', 'Mamma mia dans ton bento!', 1, '2026-01-08 13:54:58', NULL),
(9, 'Bento Oriental', 'ça sent bon avant même d\'ouvrir la boîte.', 1, '2026-01-08 13:54:58', NULL),
(10, 'Bento Végétarien', '0% viande, 100% bonheur.', 1, '2026-01-08 13:54:58', NULL),
(11, 'Bento Méditerranéen', 'Le soleil a décidé de venir manger avec toi.', 1, '2026-01-08 13:54:58', NULL),
(12, 'Bento Italien classique', 'Un air d\'Italie dans chaque bouchée!', 1, '2026-01-08 13:54:58', NULL),
(13, 'Bento Fraîcheur', 'Le bento qui respire!', 1, '2026-01-08 13:54:58', NULL),
(14, 'Bento Teriyaki', 'Sucré,salé, juste parfait!', 1, '2026-01-08 13:54:58', NULL),
(15, 'Bento Léger', 'Léger mais lourd en plaisir!', 1, '2026-01-08 13:54:58', NULL),
(16, 'Bento Croque', 'Simple et efficace!', 1, '2026-01-08 13:54:58', NULL),
(17, 'Bento Protéiné', 'Mange-le, il fait le travail.', 1, '2026-01-08 13:54:58', NULL),
(18, 'Bento Snack', 'Petit snack, grande faim réglée.', 1, '2026-01-08 13:54:58', NULL),
(19, 'Végé et Pâtes', 'Des pâtes, des légumes, du goût!', 1, '2026-01-08 13:54:58', NULL),
(20, 'Bento Réconfort', 'Comme à la maison!', 1, '2026-01-08 13:54:58', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `bento_recettes`
--

DROP TABLE IF EXISTS `bento_recettes`;
CREATE TABLE IF NOT EXISTS `bento_recettes` (
  `id_bento` int NOT NULL,
  `id_recette` int NOT NULL,
  KEY `fk_bento_recettes_bento` (`id_bento`),
  KEY `fk_recette_bento_recette` (`id_recette`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `bento_recettes`
--

INSERT INTO `bento_recettes` (`id_bento`, `id_recette`) VALUES
(1, 1),
(2, 2),
(3, 2),
(4, 3),
(5, 4),
(6, 5),
(7, 6),
(8, 11),
(8, 19),
(8, 40),
(8, 24),
(17, 14),
(17, 25),
(17, 22),
(17, 41),
(9, 10),
(9, 23),
(9, 38),
(9, 39),
(10, 8),
(10, 40),
(10, 43),
(11, 16),
(11, 35),
(12, 11),
(12, 20),
(12, 40),
(12, 43),
(13, 9),
(13, 24),
(13, 42),
(14, 30),
(14, 18),
(15, 15),
(15, 26),
(15, 41),
(15, 43),
(16, 8),
(16, 36),
(16, 44),
(19, 19),
(19, 43),
(19, 41),
(19, 17),
(18, 16),
(18, 17),
(18, 45),
(18, 44),
(20, 21),
(20, 15),
(10, 50),
(11, 50),
(18, 50),
(19, 50),
(14, 49),
(20, 51);

-- --------------------------------------------------------

--
-- Structure de la table `enregistrements`
--

DROP TABLE IF EXISTS `enregistrements`;
CREATE TABLE IF NOT EXISTS `enregistrements` (
  `id_enregistrements` int NOT NULL AUTO_INCREMENT,
  `nom_enregistrements` varchar(60) NOT NULL,
  `cover` text NOT NULL,
  `description` int NOT NULL,
  `creation_enregistrements` datetime NOT NULL,
  `modification_enregistrements` datetime NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_enregistrements`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etapes_recettes`
--

DROP TABLE IF EXISTS `etapes_recettes`;
CREATE TABLE IF NOT EXISTS `etapes_recettes` (
  `id_recette` int NOT NULL,
  `num_etape` int DEFAULT NULL,
  `description_etape` text NOT NULL,
  KEY `fk_recette_etapes` (`id_recette`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `etapes_recettes`
--

INSERT INTO `etapes_recettes` (`id_recette`, `num_etape`, `description_etape`) VALUES
(2, 1, 'Préchauffer le four à 180°C'),
(2, 2, 'Mélanger les ingrédients dans un saladier'),
(2, 3, 'Verser dans un plat et enfourner 25 minutes'),
(8, 1, 'Laver le concombre'),
(8, 2, 'Le couper en tranches très fines'),
(8, 3, 'Mélanger le yaourt, l’huile et le vinaigre'),
(8, 4, 'Poivrer'),
(8, 5, 'Ciseler la ciboulette et l’ajouter'),
(8, 6, 'Mélanger la sauce avec le concombre'),
(8, 7, 'Mettre au frais 20 à 30 minutes'),
(9, 1, 'Saler et poivrer le poulet'),
(9, 2, 'Chauffer une poêle avec l’huile'),
(9, 3, 'Cuire le poulet 6 minutes par face'),
(9, 4, 'Laisser reposer puis couper en lamelles'),
(9, 5, 'Laver et essorer la salade'),
(9, 6, 'Mélanger la salade avec la sauce César'),
(9, 7, 'Ajouter poulet, croûtons et parmesan'),
(10, 1, 'Rincer et égoutter les pois chiches'),
(10, 2, 'Couper la tomate en petits dés'),
(10, 3, 'Émincer finement l’oignon'),
(10, 4, 'Mettre tous les ingrédients dans un bol'),
(10, 5, 'Ajouter huile, citron, sel et poivre'),
(10, 6, 'Mélanger et réserver au frais'),
(11, 1, 'Couper les tomates et la mozzarella en tranches'),
(11, 2, 'Disposer dans une assiette'),
(11, 3, 'Saler et poivrer'),
(11, 4, 'Arroser d’huile d’olive'),
(11, 5, 'Ajouter le basilic'),
(12, 1, 'Cuire le riz dans l’eau salée'),
(12, 2, 'Égoutter et laisser refroidir'),
(12, 3, 'Couper la tomate en dés'),
(12, 4, 'Mettre le riz dans un bol'),
(12, 5, 'Ajouter thon, maïs et tomate'),
(12, 6, 'Ajouter la sauce et mélanger'),
(13, 1, 'Cuire les pâtes dans l’eau salée'),
(13, 2, 'Égoutter et laisser refroidir'),
(13, 3, 'Couper les tomates et la mozzarella'),
(13, 4, 'Mélanger tous les ingrédients'),
(13, 5, 'Ajouter la sauce'),
(14, 1, 'Mettre les œufs dans une casserole d’eau froide'),
(14, 2, 'Porter à ébullition'),
(14, 3, 'Cuire 10 minutes'),
(14, 4, 'Refroidir immédiatement dans l’eau froide'),
(14, 5, 'Écaler et servir avec la mayonnaise'),
(15, 1, 'Éplucher les carottes'),
(15, 2, 'Les râper finement'),
(15, 3, 'Ajouter citron, huile et sel'),
(15, 4, 'Mélanger'),
(16, 1, 'Mettre tous les ingrédients dans un mixeur'),
(16, 2, 'Mixer jusqu’à obtenir une texture lisse'),
(16, 3, 'Ajuster le sel et le citron'),
(16, 4, 'Réserver au frais'),
(17, 1, 'Râper le concombre'),
(17, 2, 'Presser pour enlever l’eau'),
(17, 3, 'Mélanger avec le yaourt'),
(17, 4, 'Ajouter ail, huile et sel'),
(17, 5, 'Mettre au frais 20 minutes'),
(18, 1, 'Cuire les nouilles dans l’eau bouillante'),
(18, 2, 'Égoutter et réserver'),
(18, 3, 'Mélanger beurre de cacahuète, sauce soja et eau chaude'),
(18, 4, 'Hacher l’ail'),
(18, 5, 'Faire revenir l’ail dans l’huile'),
(18, 6, 'Ajouter les nouilles'),
(18, 7, 'Verser la sauce et mélanger'),
(19, 1, 'Cuire les pâtes dans l’eau salée'),
(19, 2, 'Égoutter en gardant un peu d’eau de cuisson'),
(19, 3, 'Ajouter le pesto'),
(19, 4, 'Mélanger'),
(19, 5, 'Ajouter le parmesan si souhaité'),
(20, 1, 'Cuire les pâtes dans l’eau salée'),
(20, 2, 'Faire revenir les lardons'),
(20, 3, 'Battre l’œuf avec la crème'),
(20, 4, 'Égoutter les pâtes'),
(20, 5, 'Ajouter lardons hors du feu'),
(20, 6, 'Verser le mélange œuf/crème'),
(20, 7, 'Poivrer et mélanger rapidement'),
(21, 1, 'Émincer l’oignon'),
(21, 2, 'Chauffer l’huile'),
(21, 3, 'Faire revenir l’oignon'),
(21, 4, 'Ajouter la viande'),
(21, 5, 'Ajouter la sauce tomate'),
(21, 6, 'Saler, poivrer et mijoter'),
(21, 7, 'Cuire les pâtes et mélanger'),
(22, 1, 'Porter l’eau salée à ébullition'),
(22, 2, 'Ajouter le riz'),
(22, 3, 'Cuire 10 à 12 minutes'),
(22, 4, 'Égoutter'),
(24, 1, 'Sortir le poulet du frigo'),
(24, 2, 'Saler et poivrer'),
(24, 3, 'Chauffer la poêle avec l’huile'),
(24, 4, 'Cuire 6 à 7 minutes par face'),
(24, 5, 'Laisser reposer avant de servir'),
(25, 1, 'Saler le steak'),
(25, 2, 'Cuire le steak à feu vif'),
(25, 3, 'Réserver au chaud'),
(25, 4, 'Ajouter beurre et crème'),
(25, 5, 'Ajouter le poivre'),
(25, 6, 'Remettre le steak et napper'),
(26, 1, 'Saler le poisson'),
(26, 2, 'Passer dans la farine'),
(26, 3, 'Tremper dans l’œuf'),
(26, 4, 'Enrober de chapelure'),
(26, 5, 'Cuire à la poêle'),
(27, 1, 'Nettoyer et couper les champignons'),
(27, 2, 'Cuire l’escalope'),
(27, 3, 'Réserver'),
(27, 4, 'Cuire les champignons'),
(27, 5, 'Ajouter la crème'),
(27, 6, 'Remettre l’escalope'),
(28, 1, 'Saler l’escalope'),
(28, 2, 'Passer dans la farine'),
(28, 3, 'Tremper dans l’œuf'),
(28, 4, 'Enrober de chapelure'),
(28, 5, 'Cuire à la poêle'),
(29, 1, 'Nettoyer et couper les champignons'),
(29, 2, 'Les faire revenir'),
(29, 3, 'Battre les œufs'),
(29, 4, 'Verser sur les champignons'),
(29, 5, 'Cuire doucement'),
(30, 1, 'Couper le poulet'),
(30, 2, 'Chauffer l’huile'),
(30, 3, 'Cuire le poulet'),
(30, 4, 'Ajouter la sauce'),
(30, 5, 'Laisser caraméliser'),
(31, 1, 'Émincer l’oignon'),
(31, 2, 'Chauffer l’huile'),
(31, 3, 'Faire revenir le bœuf'),
(31, 4, 'Ajouter l’oignon'),
(31, 5, 'Ajouter la sauce soja'),
(32, 1, 'Battre les œufs'),
(32, 2, 'Faire fondre le beurre'),
(32, 3, 'Verser les œufs'),
(32, 4, 'Remuer constamment'),
(33, 1, 'Saler et poivrer le saumon'),
(33, 2, 'Chauffer l’huile'),
(33, 3, 'Cuire côté peau'),
(33, 4, 'Retourner et finir la cuisson'),
(34, 1, 'Couper et cuire le poulet'),
(34, 2, 'Couper la tomate'),
(34, 3, 'Chauffer la galette'),
(34, 4, 'Garnir et rouler'),
(35, 1, 'Mélanger yaourt, ail et épices'),
(35, 2, 'Ajouter le poulet'),
(35, 3, 'Laisser mariner'),
(35, 4, 'Cuire le poulet'),
(35, 5, 'Garnir le pain'),
(36, 1, 'Beurrer le pain'),
(36, 2, 'Ajouter jambon et fromage'),
(36, 3, 'Cuire à la poêle'),
(37, 1, 'Mixer tous les ingrédients'),
(37, 2, 'Former des boulettes'),
(37, 3, 'Frire'),
(37, 4, 'Égoutter'),
(38, 1, 'Mélanger semoule et sel'),
(38, 2, 'Ajouter l’eau'),
(38, 3, 'Pétrir'),
(38, 4, 'Former une galette'),
(38, 5, 'Cuire'),
(39, 1, 'Griller les poivrons'),
(39, 2, 'Peler et couper'),
(39, 4, 'Ajouter l’huile d’olive et le sel'),
(40, 1, 'Couper les courgettes'),
(40, 2, 'Mélanger avec l’huile'),
(40, 3, 'Griller'),
(41, 1, 'Cuire à l’eau'),
(41, 2, 'Égoutter'),
(41, 3, 'Faire revenir'),
(42, 1, 'Couper les haricots'),
(42, 2, 'Cuire à l’eau'),
(42, 3, 'Égoutter'),
(42, 4, 'Faire revenir avec l’ail'),
(43, 1, 'Nettoyer les champignons'),
(43, 2, 'Chauffer l’huile'),
(43, 3, 'Cuire'),
(43, 4, 'Saler en fin'),
(44, 1, 'Préchauffer le four'),
(44, 2, 'Couper les patates'),
(44, 3, 'Mélanger avec l’huile'),
(44, 4, 'Cuire au four'),
(44, 5, 'Saler'),
(45, 1, 'Éplucher et couper'),
(45, 2, 'Rincer et sécher'),
(45, 3, 'Frire'),
(45, 4, 'Saler'),
(46, 1, 'Rincer les lentilles'),
(46, 2, 'Mettre dans l’eau froide'),
(46, 3, 'Porter à ébullition'),
(46, 4, 'Cuire'),
(46, 5, 'Saler'),
(47, 1, 'Éplucher et couper les pommes de terre'),
(47, 2, 'Cuire à l’eau salée'),
(47, 3, 'Égoutter'),
(47, 4, 'Écraser'),
(47, 5, 'Ajouter beurre et lait'),
(23, 1, 'Faire chauffer l’huile d’olive dans une marmite'),
(23, 2, 'Ajouter l’oignon finement haché et l’ail'),
(23, 3, 'Faire revenir 2 à 3 minutes'),
(23, 4, 'Couper la courgette, la carotte, le navet et le céleri en gros morceaux'),
(23, 5, 'Ajouter les légumes dans la marmite'),
(23, 6, 'Ajouter la tomate et le concentré de tomate'),
(23, 7, 'Incorporer le ras el hanout, le paprika, le sel et le poivre'),
(23, 8, 'Ajouter les pois chiches'),
(23, 9, 'Verser l’eau chaude'),
(23, 10, 'Laisser cuire à feu moyen 25 à 30 minutes'),
(23, 11, 'Mettre le couscous dans un grand saladier'),
(23, 12, 'Verser l’eau chaude salée'),
(23, 13, 'Couvrir et laisser gonfler 5 minutes'),
(23, 14, 'Ajouter l’huile d’olive et égrener le couscous'),
(23, 15, 'Faire cuire le couscous 15 minutes à la vapeur'),
(23, 16, 'Égrener de nouveau et ajouter un peu d’huile d’olive et de sel'),
(23, 17, 'Remettre à cuire 15 minutes à la vapeur'),
(23, 18, 'Égrener une dernière fois et incorporer le beurre délicatement');

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

DROP TABLE IF EXISTS `ingredients`;
CREATE TABLE IF NOT EXISTS `ingredients` (
  `id_ingredient` int NOT NULL AUTO_INCREMENT,
  `nom` text NOT NULL,
  `allergenes` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_ingredient`)
) ENGINE=InnoDB AUTO_INCREMENT=152 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ingredients`
--

INSERT INTO `ingredients` (`id_ingredient`, `nom`, `allergenes`) VALUES
(1, 'poivre', NULL),
(2, 'sel', NULL),
(3, 'muscade', NULL),
(4, 'farine', NULL),
(5, 'beurre', NULL),
(6, 'crème fraîche', NULL),
(7, 'lait entier', NULL),
(8, 'comté', NULL),
(9, 'huile', NULL),
(10, 'œuf', NULL),
(11, 'eau', NULL),
(12, 'chapelure', NULL),
(13, 'concombre', NULL),
(14, 'Yaourt grec', 0),
(15, 'Ciboulette', NULL),
(16, 'Huile d’olive', NULL),
(17, 'Vinaigre de cidre', NULL),
(18, 'Salade iceberg', NULL),
(19, 'émincés de poulet rôti', NULL),
(20, 'Parmesan', NULL),
(21, 'Croûtons', NULL),
(22, 'Sauce César', NULL),
(23, 'Pois chiches', NULL),
(24, 'Tomate', NULL),
(25, 'Oignon rouge', NULL),
(26, 'Persil', NULL),
(27, 'Jus de citron', NULL),
(28, 'Tomates', NULL),
(29, 'Mozzarella', NULL),
(30, 'Basilic', NULL),
(31, 'Riz', NULL),
(32, 'Thon', NULL),
(33, 'Maïs', NULL),
(34, 'vinaigrette', NULL),
(35, 'Pâtes', NULL),
(36, 'Tomates cerises', NULL),
(37, 'Olives', NULL),
(38, 'Pesto', NULL),
(39, 'Mayonnaise', NULL),
(40, 'Carottes', NULL),
(41, 'Tahini', NULL),
(42, 'Ail', NULL),
(43, 'Nouilles', NULL),
(44, 'Beurre de cacahuète', NULL),
(45, 'Sauce soja', NULL),
(46, 'Eau chaude', NULL),
(47, 'Lardons(de volaille ou de porc)', NULL),
(48, 'Viande hachée', NULL),
(49, 'Sauce tomate', NULL),
(50, 'Oignon', NULL),
(51, 'Semoule', NULL),
(52, 'Blanc de poulet', NULL),
(53, 'Filet de cabillaud', NULL),
(54, 'Escalope de poulet', NULL),
(55, 'Champignons', NULL),
(56, 'Sauce teriyaki', NULL),
(57, 'Bœuf émincé', NULL),
(58, 'Pavé de saumon', NULL),
(59, 'Galette wrap', NULL),
(60, 'cream cheese', NULL),
(61, 'Paprika', NULL),
(62, 'Cumin', NULL),
(63, 'Pain pita', NULL),
(64, 'Pain de mie', NULL),
(65, 'Tranche de Jambon', NULL),
(66, 'Tranche de blanc de blanc de poulet', NULL),
(67, 'Fromage râpé', NULL),
(68, 'Semoule fine', NULL),
(69, 'Poivrons', NULL),
(70, 'Courgette', NULL),
(71, 'Haricots verts', NULL),
(72, 'Haricots plats', NULL),
(73, 'Champignons', NULL),
(74, 'Patate douce', NULL),
(75, 'Pommes de terre', NULL),
(76, 'Lentilles', NULL),
(77, 'Navet', NULL),
(78, 'Ras el-hanout', NULL),
(79, 'concentrée de tomate', NULL),
(80, 'purée de tomate', NULL),
(81, 'couscous', NULL),
(82, '', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ingredients_recettes`
--

DROP TABLE IF EXISTS `ingredients_recettes`;
CREATE TABLE IF NOT EXISTS `ingredients_recettes` (
  `id_ingredients` int NOT NULL,
  `id_recette` int NOT NULL,
  `quantite` float DEFAULT NULL,
  `unites` int NOT NULL,
  KEY `ingredients` (`id_ingredients`),
  KEY `recette` (`id_recette`),
  KEY `unit` (`unites`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `ingredients_recettes`
--

INSERT INTO `ingredients_recettes` (`id_ingredients`, `id_recette`, `quantite`, `unites`) VALUES
(5, 1, 27, 1),
(12, 1, NULL, 5),
(8, 1, 67, 1),
(6, 1, NULL, 1),
(11, 1, 125, 4),
(4, 1, 27, 1),
(9, 1, 4, 1),
(7, 1, 250, 4),
(3, 1, NULL, 5),
(1, 1, NULL, 5),
(2, 1, NULL, 5),
(10, 1, 1, 5),
(4, 2, 50, 1),
(5, 2, 30, 1),
(6, 2, 20, 2),
(8, 2, 60, 1),
(10, 2, 1, 3),
(2, 2, 1, 1),
(1, 2, 1, 1),
(7, 2, 200, 2),
(2, 2, 1, 1),
(1, 2, 1, 1),
(11, 3, 300, 2),
(9, 3, 20, 2),
(2, 3, 1, 1),
(10, 4, 2, 3),
(5, 4, 10, 1),
(2, 4, 1, 1),
(1, 4, 1, 1),
(4, 5, 40, 1),
(6, 5, 20, 2),
(8, 5, 60, 1),
(2, 5, 1, 1),
(12, 6, 50, 1),
(10, 6, 1, 3),
(9, 6, 30, 2),
(13, 8, 150, 1),
(14, 8, 100, 1),
(15, 8, 5, 1),
(16, 8, 1, 7),
(17, 8, 1, 7),
(1, 8, NULL, 5),
(18, 9, 100, 1),
(52, 9, 120, 1),
(20, 9, 15, 1),
(21, 9, 15, 1),
(22, 9, 30, 1),
(16, 9, 1, 7),
(2, 9, NULL, 5),
(1, 9, NULL, 5),
(23, 10, 120, 1),
(24, 10, 100, 1),
(25, 10, 20, 1),
(26, 10, 1, 6),
(16, 10, 1, 6),
(27, 10, 1, 6),
(2, 10, NULL, 5),
(1, 10, NULL, 5),
(28, 11, 150, 1),
(29, 11, 60, 1),
(16, 11, 1, 6),
(2, 11, NULL, 5),
(1, 11, NULL, 5),
(30, 11, NULL, 5),
(31, 12, 60, 1),
(32, 12, 80, 1),
(33, 12, 50, 1),
(24, 12, 100, 1),
(39, 12, 2, 6),
(35, 13, 75, 1),
(36, 13, 80, 1),
(29, 13, 60, 1),
(37, 13, 15, 1),
(38, 13, 2, 6),
(10, 14, 2, 5),
(39, 14, 2, 6),
(40, 15, 200, 1),
(27, 15, 1, 6),
(9, 15, 1, 6),
(2, 15, NULL, 5),
(23, 16, 120, 1),
(41, 16, 15, 1),
(42, 16, 0.5, 5),
(27, 16, 1, 6),
(16, 16, 1, 6),
(2, 16, NULL, 5),
(14, 17, 100, 1),
(13, 17, 100, 1),
(42, 17, 0.5, 5),
(16, 17, 1, 7),
(2, 17, NULL, 5),
(43, 18, 80, 1),
(44, 18, 20, 1),
(45, 18, 15, 4),
(46, 18, 2, 6),
(42, 18, 0.5, 5),
(9, 18, 1, 7),
(35, 19, 80, 1),
(38, 19, 30, 1),
(20, 19, 10, 1),
(35, 20, 80, 1),
(47, 20, 80, 1),
(10, 20, 1, 5),
(6, 20, 50, 4),
(1, 20, NULL, 5),
(35, 21, 80, 1),
(48, 21, 100, 1),
(49, 21, 150, 1),
(50, 21, 30, 1),
(9, 21, 1, 7),
(2, 21, NULL, 5),
(1, 21, NULL, 5),
(31, 22, 70, 1),
(11, 22, 700, 4),
(2, 22, NULL, 5),
(52, 24, 150, 1),
(16, 24, 1, 7),
(2, 24, NULL, 5),
(1, 24, NULL, 5),
(48, 25, 125, 1),
(6, 25, 50, 4),
(5, 25, 10, 1),
(1, 25, 1, 7),
(2, 25, NULL, 5),
(53, 26, 150, 1),
(4, 26, 20, 1),
(10, 26, 1, 5),
(12, 26, 30, 1),
(9, 26, 2, 6),
(2, 26, NULL, 5),
(54, 27, 150, 1),
(55, 27, 120, 1),
(6, 27, 80, 4),
(5, 27, 10, 1),
(2, 27, NULL, 5),
(1, 27, NULL, 5),
(54, 28, 150, 1),
(4, 28, 20, 1),
(10, 28, 1, 5),
(12, 28, 30, 1),
(9, 28, 3, 6),
(2, 28, NULL, 5),
(10, 29, 2, 5),
(55, 29, 100, 1),
(5, 29, 10, 1),
(2, 29, NULL, 5),
(1, 29, NULL, 5),
(52, 30, 150, 1),
(56, 30, 45, 4),
(9, 30, 1, 7),
(57, 31, 150, 1),
(50, 31, 80, 1),
(45, 31, 2, 6),
(9, 31, 1, 6),
(10, 32, 2, 5),
(5, 32, 10, 1),
(2, 32, NULL, 5),
(58, 33, 150, 1),
(9, 33, 1, 7),
(2, 33, NULL, 5),
(1, 33, NULL, 5),
(59, 34, 60, 1),
(52, 34, 120, 1),
(18, 34, 30, 1),
(24, 34, 80, 1),
(39, 34, 2, 6),
(9, 34, 1, 7),
(2, 34, NULL, 5),
(1, 34, NULL, 5),
(52, 35, 150, 1),
(14, 35, 50, 1),
(42, 35, 0.5, 5),
(61, 35, 0.5, 7),
(62, 35, 0.5, 7),
(63, 35, 1, 5),
(9, 35, 1, 7),
(2, 35, NULL, 5),
(64, 36, 2, 5),
(65, 36, 40, 1),
(67, 36, 40, 1),
(5, 36, 10, 1),
(23, 37, 80, 1),
(42, 37, 0.5, 5),
(26, 37, 10, 1),
(62, 37, 0.5, 7),
(9, 37, NULL, 5),
(68, 38, 100, 1),
(11, 38, 60, 4),
(2, 38, 0.25, 7),
(9, 38, 1, 7),
(69, 39, 200, 1),
(24, 39, 100, 1),
(42, 39, 0.5, 5),
(16, 39, 1, 6),
(2, 39, NULL, 5),
(70, 40, 200, 1),
(9, 40, 1, 6),
(2, 40, NULL, 5),
(1, 40, NULL, 5),
(71, 41, 200, 1),
(9, 41, 1, 6),
(2, 41, NULL, 5),
(72, 42, 200, 1),
(9, 42, 1, 6),
(42, 42, 0.5, 5),
(2, 42, NULL, 5),
(55, 43, 200, 1),
(9, 43, 1, 6),
(2, 43, NULL, 5),
(1, 43, NULL, 5),
(74, 44, 250, 1),
(9, 44, 1, 6),
(2, 44, NULL, 5),
(75, 45, 300, 1),
(9, 45, NULL, 5),
(2, 45, NULL, 5),
(76, 46, 80, 1),
(11, 46, 800, 4),
(2, 46, NULL, 5),
(75, 47, 300, 1),
(7, 47, 80, 4),
(5, 47, 20, 1),
(2, 47, NULL, 5),
(16, 39, 1, 6),
(50, 23, 1, 5),
(42, 23, 1, 5),
(70, 23, 150, 1),
(40, 23, 100, 1),
(77, 23, 100, 1),
(78, 23, 50, 1),
(24, 23, 100, 1),
(79, 23, 1, 6),
(80, 23, 1, 7),
(81, 23, 1, 7),
(2, 23, NULL, 5),
(1, 23, NULL, 5),
(23, 23, 100, 1),
(11, 23, 750, 4),
(16, 23, 2, 6),
(82, 23, 250, 1),
(11, 23, 150, 4),
(16, 23, 1, 6),
(5, 23, 20, 1),
(2, 23, 0.5, 7);

-- --------------------------------------------------------

--
-- Structure de la table `liste_bento`
--

DROP TABLE IF EXISTS `liste_bento`;
CREATE TABLE IF NOT EXISTS `liste_bento` (
  `id_liste` int NOT NULL,
  `id_bento` int NOT NULL,
  KEY `liste` (`id_liste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `liste_courses`
--

DROP TABLE IF EXISTS `liste_courses`;
CREATE TABLE IF NOT EXISTS `liste_courses` (
  `id_liste` int NOT NULL AUTO_INCREMENT,
  `date_liste` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_bento` int NOT NULL,
  PRIMARY KEY (`id_liste`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

DROP TABLE IF EXISTS `recette`;
CREATE TABLE IF NOT EXISTS `recette` (
  `id_recette` int NOT NULL AUTO_INCREMENT,
  `recette_nom` varchar(175) NOT NULL,
  `id_user` int NOT NULL,
  `type` varchar(45) NOT NULL,
  `id_type` int NOT NULL,
  PRIMARY KEY (`id_recette`),
  KEY `user recette` (`id_user`),
  KEY `fk_recette_type` (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `recette`
--

INSERT INTO `recette` (`id_recette`, `recette_nom`, `id_user`, `type`, `id_type`) VALUES
(1, 'Croquettes belges', 1, '', 2),
(2, 'Gratin de comté', 1, '', 1),
(3, 'Pâtes flemme', 1, '', 1),
(4, 'Riz gras', 1, '', 1),
(5, 'Omelette douteuse', 1, '', 1),
(6, 'Gratin de secours', 1, '', 1),
(7, 'Truc pané', 1, '', 1),
(8, 'Concombre au yaourt', 1, 'Entrée', 1),
(9, 'Salade César', 1, 'Entrée', 1),
(10, 'Salade de pois chiches', 1, 'Entrée', 1),
(11, 'Tomates mozzarella', 1, 'Entrée', 1),
(12, 'Salade de riz', 1, 'Entrée', 1),
(13, 'Salade de pâtes', 1, 'Entrée', 1),
(14, 'Œufs durs mayonnaise', 1, 'Entrée', 1),
(15, 'Salade de carottes râpées', 1, 'Entrée', 1),
(16, 'Houmous', 1, 'à coté', 4),
(17, 'Tzatziki', 1, 'à coté', 4),
(18, 'Nouilles au beurre de cacahuète', 1, 'Plat', 2),
(19, 'Pâtes au pesto', 1, 'Plat', 2),
(20, 'Pâtes carbonara', 1, 'Plat', 2),
(21, 'Pâtes à la bolognaise', 1, 'Plat', 2),
(22, 'Riz nature', 1, 'à coté', 4),
(23, 'Couscous', 1, 'Plat', 2),
(24, 'Poulet grillé', 1, 'Plat', 2),
(25, 'Steak haché sauce au poivre', 1, 'Plat', 2),
(26, 'Poisson pané', 1, 'Plat', 2),
(27, 'Escalope à la crème de champignons', 1, 'Plat', 2),
(28, 'Escalope de poulet panée', 1, 'Plat', 2),
(29, 'Omelette aux champignons', 1, 'Plat', 2),
(30, 'Poulet teriyaki', 1, 'Plat', 2),
(31, 'Bœuf aux oignons', 1, 'Plat', 2),
(32, 'Œufs brouillés', 1, 'Plat', 2),
(33, 'Saumon grillé', 1, 'Plat', 2),
(34, 'Wrap au poulet', 1, 'Plat', 2),
(35, 'Shawarma de poulet', 1, 'Plat', 2),
(36, 'Croque-monsieur', 1, 'Plat', 2),
(37, 'Falafels', 1, 'à coté', 4),
(38, 'Kesra', 1, 'à coté', 4),
(39, 'Felfel', 1, 'à coté', 4),
(40, 'Courgettes grillées', 1, 'à coté', 4),
(41, 'Haricots verts grillés', 1, 'à coté', 4),
(42, 'Haricots plats', 1, 'à coté', 4),
(43, 'Champignons grillés', 1, 'à coté', 4),
(44, 'Frites de patates douces', 1, 'à coté', 4),
(45, 'Frites', 1, 'à coté', 4),
(46, 'Lentilles', 1, 'à coté', 4),
(47, 'Purée', 1, 'à coté', 4),
(48, 'Galette légumes pomme de terre', 1, 'Plat', 2),
(49, 'Gyoza', 1, 'à coté', 4),
(50, 'Bâtonnet de légumes', 1, 'à coté', 4),
(51, 'Pain', 1, 'à coté', 4);

-- --------------------------------------------------------

--
-- Structure de la table `type_recette`
--

DROP TABLE IF EXISTS `type_recette`;
CREATE TABLE IF NOT EXISTS `type_recette` (
  `id_type` int NOT NULL AUTO_INCREMENT,
  `nom_type` varchar(40) NOT NULL,
  PRIMARY KEY (`id_type`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `type_recette`
--

INSERT INTO `type_recette` (`id_type`, `nom_type`) VALUES
(1, 'Entrée'),
(2, 'Plat'),
(3, 'Dessert'),
(4, 'Autre');

-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

DROP TABLE IF EXISTS `unites`;
CREATE TABLE IF NOT EXISTS `unites` (
  `id_unites` int NOT NULL AUTO_INCREMENT,
  `unites` varchar(45) NOT NULL,
  PRIMARY KEY (`id_unites`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `unites`
--

INSERT INTO `unites` (`id_unites`, `unites`) VALUES
(1, 'g'),
(2, 'kg'),
(3, 'L'),
(4, 'mL'),
(5, ' (vide)'),
(6, 'CàS'),
(7, 'CàC');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `nom`, `prenom`, `tag_allergie`, `photo`, `nb_bento`, `bio`, `motdepasse`, `mail`, `date_creation`, `role`) VALUES
(1, 'admin', 'Admi', 'nistrateur', '{}', NULL, 1, 'Administrateur du site.', '$2y$12$Z9Mfo2TFE6umkBGiGSIUx.bL58w76.1PletOLHDEDwh0pBtEy3YzS', 'leolesimple@icloud.com', '2025-12-10 08:51:59', 'admin'),
(2, 'leolesimple', 'Lesimple', 'Léo', NULL, 'uploads/profiles/loty_leolesimple_1766770009.png', 1, 'Développeur du site LOTY', '$2y$12$.IYGqN8z6JBrsBzw7ygCbe9qK/0O0hdoEuuUnPDdRPPhGVB2s9C1e', 'leo.lesimple@edu.univ-eiffel.fr', '2025-12-26 18:26:49', 'user');

-- --------------------------------------------------------

--
-- Structure de la table `vote`
--

DROP TABLE IF EXISTS `vote`;
CREATE TABLE IF NOT EXISTS `vote` (
  `id_vote` int NOT NULL,
  `id_bento` int NOT NULL,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id_vote`),
  KEY `bento` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bento`
--
ALTER TABLE `bento`
  ADD CONSTRAINT `user_bento` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `bento_recettes`
--
ALTER TABLE `bento_recettes`
  ADD CONSTRAINT `fk_bento_recettes_bento` FOREIGN KEY (`id_bento`) REFERENCES `bento` (`id_bento`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `fk_recette_bento_recette` FOREIGN KEY (`id_recette`) REFERENCES `recette` (`id_recette`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `etapes_recettes`
--
ALTER TABLE `etapes_recettes`
  ADD CONSTRAINT `fk_recette_etapes` FOREIGN KEY (`id_recette`) REFERENCES `recette` (`id_recette`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `ingredients_recettes`
--
ALTER TABLE `ingredients_recettes`
  ADD CONSTRAINT `ingredients` FOREIGN KEY (`id_ingredients`) REFERENCES `ingredients` (`id_ingredient`),
  ADD CONSTRAINT `recette` FOREIGN KEY (`id_recette`) REFERENCES `recette` (`id_recette`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `unit` FOREIGN KEY (`unites`) REFERENCES `unites` (`id_unites`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `liste_bento`
--
ALTER TABLE `liste_bento`
  ADD CONSTRAINT `liste` FOREIGN KEY (`id_liste`) REFERENCES `liste_courses` (`id_liste`);

--
-- Contraintes pour la table `recette`
--
ALTER TABLE `recette`
  ADD CONSTRAINT `fk_recette_type` FOREIGN KEY (`id_type`) REFERENCES `type_recette` (`id_type`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `user recette` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Contraintes pour la table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `bento` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
