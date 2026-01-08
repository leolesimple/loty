-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 06 jan. 2026 à 11:53
-- Version du serveur : 9.5.0
-- Version de PHP : 8.5.1

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

CREATE TABLE `bento` (
  `id_bento` int NOT NULL,
  `bento_nom` text NOT NULL,
  `description` text NOT NULL,
  `id_user` int NOT NULL,
  `date_creation` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image_src` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(7, 'Bento random', 'On met ce qu’on trouve et on voit après', 1, '2025-12-27 17:41:36', '');

-- --------------------------------------------------------

--
-- Structure de la table `bento_recettes`
--

CREATE TABLE `bento_recettes` (
  `id_bento` int NOT NULL,
  `id_recette` int NOT NULL
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
(7, 6);

-- --------------------------------------------------------

--
-- Structure de la table `enregistrements`
--

CREATE TABLE `enregistrements` (
  `id_enregistrements` int NOT NULL,
  `nom_enregistrements` varchar(60) NOT NULL,
  `cover` text NOT NULL,
  `description` int NOT NULL,
  `creation_enregistrements` datetime NOT NULL,
  `modification_enregistrements` datetime NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `etapes_recettes`
--

CREATE TABLE `etapes_recettes` (
  `id_recette` int NOT NULL,
  `num_etape` int DEFAULT NULL,
  `description_etape` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `etapes_recettes`
--

INSERT INTO `etapes_recettes` (`id_recette`, `num_etape`, `description_etape`) VALUES
(2, 1, 'Préchauffer le four à 180°C'),
(2, 2, 'Mélanger les ingrédients dans un saladier'),
(2, 3, 'Verser dans un plat et enfourner 25 minutes');

-- --------------------------------------------------------

--
-- Structure de la table `ingredients`
--

CREATE TABLE `ingredients` (
  `id_ingredient` int NOT NULL,
  `nom` text NOT NULL,
  `allergenes` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(12, 'chapelure', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `ingredients_recettes`
--

CREATE TABLE `ingredients_recettes` (
  `id_ingredients` int NOT NULL,
  `id_recette` int NOT NULL,
  `quantite` float DEFAULT NULL,
  `unites` int NOT NULL
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
(9, 6, 30, 2);

-- --------------------------------------------------------

--
-- Structure de la table `liste_bento`
--

CREATE TABLE `liste_bento` (
  `id_liste` int NOT NULL,
  `id_bento` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `liste_courses`
--

CREATE TABLE `liste_courses` (
  `id_liste` int NOT NULL,
  `date_liste` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_bento` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Structure de la table `recette`
--

CREATE TABLE `recette` (
  `id_recette` int NOT NULL,
  `recette_nom` varchar(175) NOT NULL,
  `id_user` int NOT NULL,
  `type` varchar(45) NOT NULL,
  `id_type` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(7, 'Truc pané', 1, '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `type_recette`
--

CREATE TABLE `type_recette` (
  `id_type` int NOT NULL,
  `nom_type` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE `unites` (
  `id_unites` int NOT NULL,
  `unites` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE `user` (
  `id` int NOT NULL,
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
  `role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE `vote` (
  `id_vote` int NOT NULL,
  `id_bento` int NOT NULL,
  `id_user` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bento`
--
ALTER TABLE `bento`
  ADD PRIMARY KEY (`id_bento`),
  ADD KEY `user_bento` (`id_user`);

--
-- Index pour la table `bento_recettes`
--
ALTER TABLE `bento_recettes`
  ADD KEY `fk_bento_recettes_bento` (`id_bento`),
  ADD KEY `fk_recette_bento_recette` (`id_recette`);

--
-- Index pour la table `enregistrements`
--
ALTER TABLE `enregistrements`
  ADD PRIMARY KEY (`id_enregistrements`);

--
-- Index pour la table `etapes_recettes`
--
ALTER TABLE `etapes_recettes`
  ADD KEY `fk_recette_etapes` (`id_recette`);

--
-- Index pour la table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id_ingredient`);

--
-- Index pour la table `ingredients_recettes`
--
ALTER TABLE `ingredients_recettes`
  ADD KEY `ingredients` (`id_ingredients`),
  ADD KEY `recette` (`id_recette`),
  ADD KEY `unit` (`unites`);

--
-- Index pour la table `liste_bento`
--
ALTER TABLE `liste_bento`
  ADD KEY `liste` (`id_liste`);

--
-- Index pour la table `liste_courses`
--
ALTER TABLE `liste_courses`
  ADD PRIMARY KEY (`id_liste`);

--
-- Index pour la table `recette`
--
ALTER TABLE `recette`
  ADD PRIMARY KEY (`id_recette`),
  ADD KEY `user recette` (`id_user`),
  ADD KEY `fk_recette_type` (`id_type`);

--
-- Index pour la table `type_recette`
--
ALTER TABLE `type_recette`
  ADD PRIMARY KEY (`id_type`);

--
-- Index pour la table `unites`
--
ALTER TABLE `unites`
  ADD PRIMARY KEY (`id_unites`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usernames` (`username`);

--
-- Index pour la table `vote`
--
ALTER TABLE `vote`
  ADD PRIMARY KEY (`id_vote`),
  ADD KEY `bento` (`id_user`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bento`
--
ALTER TABLE `bento`
  MODIFY `id_bento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `enregistrements`
--
ALTER TABLE `enregistrements`
  MODIFY `id_enregistrements` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `ingredients`
--
ALTER TABLE `ingredients`
  MODIFY `id_ingredient` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `liste_courses`
--
ALTER TABLE `liste_courses`
  MODIFY `id_liste` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `recette`
--
ALTER TABLE `recette`
  MODIFY `id_recette` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `type_recette`
--
ALTER TABLE `type_recette`
  MODIFY `id_type` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `unites`
--
ALTER TABLE `unites`
  MODIFY `id_unites` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
