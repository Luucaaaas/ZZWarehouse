-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 21 mars 2024 à 16:39
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `zzwarehouse`
--

-- --------------------------------------------------------

--
-- Structure de la table `commandes`
--

CREATE TABLE `commandes` (
  `id_commande` int(11) NOT NULL,
  `id_utilisateur` int(11) DEFAULT NULL,
  `id_stock` int(11) DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `type_mouvement` enum('Entree','Sortie') DEFAULT NULL,
  `date_commande` datetime DEFAULT current_timestamp(),
  `statut` enum('en attente','validee','invalidée') DEFAULT 'en attente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commandes`
--

INSERT INTO `commandes` (`id_commande`, `id_utilisateur`, `id_stock`, `quantite`, `type_mouvement`, `date_commande`, `statut`) VALUES
(1, 4, 3, 20, 'Entree', '2024-03-20 09:29:04', 'en attente'),
(2, 5, 2, 15, 'Sortie', '2024-03-20 09:29:04', 'validee'),
(3, 6, 1, 10, 'Sortie', '2024-03-20 09:29:04', 'en attente');

-- --------------------------------------------------------

--
-- Structure de la table `details_commande`
--

CREATE TABLE `details_commande` (
  `id_details` int(11) NOT NULL,
  `id_stock` int(11) NOT NULL,
  `quantite` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `details_commande`
--

INSERT INTO `details_commande` (`id_details`, `id_stock`, `quantite`) VALUES
(1, 1, 2),
(2, 2, 1),
(3, 2, 3),
(3, 3, 3);

-- --------------------------------------------------------

--
-- Structure de la table `mouvements`
--

CREATE TABLE `mouvements` (
  `id_mouvement` int(11) NOT NULL,
  `id_stock` int(11) DEFAULT NULL,
  `type_mouvement` enum('Entree','Sortie') DEFAULT NULL,
  `quantite` int(11) DEFAULT NULL,
  `date_mouvement` datetime DEFAULT current_timestamp(),
  `id_commande` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `mouvements`
--

INSERT INTO `mouvements` (`id_mouvement`, `id_stock`, `type_mouvement`, `quantite`, `date_mouvement`, `id_commande`) VALUES
(1, 1, 'Entree', 5, '2024-03-20 09:31:51', 1),
(2, 2, 'Sortie', 2, '2024-03-20 09:31:51', 2),
(3, 3, 'Entree', 10, '2024-03-20 09:31:51', 3);

-- --------------------------------------------------------

--
-- Structure de la table `roles`
--

CREATE TABLE `roles` (
  `id_role` int(11) NOT NULL,
  `nom_role` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `roles`
--

INSERT INTO `roles` (`id_role`, `nom_role`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'client'),
(4, 'Fournisseur');

-- --------------------------------------------------------

--
-- Structure de la table `stocks`
--

CREATE TABLE `stocks` (
  `id_stock` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `quantite_disponible` int(11) DEFAULT NULL,
  `type` enum('medicament','materiel') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `stocks`
--

INSERT INTO `stocks` (`id_stock`, `nom`, `description`, `quantite_disponible`, `type`) VALUES
(1, 'Aspirine', 'Analgésique et antipyrétique', 100, 'medicament'),
(2, 'Stéthoscope', 'Instrument médical pour écouter les sons internes du corps', 10, 'materiel'),
(3, 'Amoxicilline', 'Antibiotique', 50, 'medicament'),
(4, 'Tensiomètre', 'Appareil pour mesurer la pression artérielle', 5, 'materiel'),
(5, 'Ibuprofene', 'Anti-inflammatoire non stéroïdien', 75, 'medicament'),
(6, 'Lampe frontale', 'Source de lumière portable pour les examens médicaux', 15, 'materiel'),
(7, 'Paracétamol', 'Analgésique et antipyrétique', 200, 'medicament'),
(8, 'Seringue', 'Instrument pour l\'injection de médicaments', 50, 'materiel'),
(9, 'Omeprazole', 'Inhibiteur de la pompe à protons', 30, 'medicament'),
(10, 'Thermomètre', 'Appareil pour mesurer la température corporelle', 20, 'materiel'),
(11, 'Ciseaux médicaux', 'Instrument pour la découpe de matériaux médicaux', 8, 'materiel'),
(12, 'Antihistaminique', 'Médicament pour le traitement des allergies', 40, 'medicament'),
(13, 'Gants médicaux', 'Équipement de protection pour les mains', 100, 'materiel'),
(14, 'Antiémétique', 'Médicament pour le traitement des nausées et vomissements', 25, 'medicament'),
(15, 'Oxymètre de pouls', 'Appareil pour mesurer la saturation en oxygène dans le sang', 12, 'materiel'),
(16, 'Fluorouracile', 'Médicament utilisé dans le traitement du cancer', 15, 'medicament'),
(17, 'Cannule nasale', 'Dispositif pour l\'administration d\'oxygène par le nez', 30, 'materiel'),
(18, 'Antibiotique topique', 'Médicament pour le traitement des infections cutanées', 50, 'medicament'),
(19, 'Glucomètre', 'Appareil pour mesurer la glycémie', 9, 'materiel'),
(20, 'Antidépresseur', 'Médicament pour le traitement de la dépression', 35, 'medicament'),
(21, 'Masque facial', 'Équipement de protection pour le visage', 80, 'materiel'),
(22, 'Anticoagulant', 'Médicament pour prévenir la formation de caillots sanguins', 60, 'medicament'),
(23, 'Cathéter', 'Tube médical utilisé pour l\'administration de liquides ou de médicaments', 25, 'materiel'),
(24, 'Antipyrétique', 'Médicament pour réduire la fièvre', 70, 'medicament'),
(25, 'Oxygène portable', 'Dispositif pour l\'administration d\'oxygène en déplacement', 7, 'materiel'),
(26, 'Antihypertenseur', 'Médicament pour le traitement de l\'hypertension artérielle', 45, 'medicament'),
(27, 'Bandage élastique', 'Matériel de bandage extensible', 120, 'materiel'),
(28, 'Antifongique', 'Médicament pour le traitement des infections fongiques', 55, 'medicament'),
(29, 'Glaçons réutilisables', 'Équipement pour l\'application de froid thérapeutique', 18, 'materiel'),
(30, 'Antiviral', 'Médicament pour le traitement des infections virales', 25, 'medicament');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id_utilisateur` int(11) NOT NULL,
  `nom` varchar(255) DEFAULT NULL,
  `prenom` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `mot_de_passe` varchar(255) DEFAULT NULL,
  `id_role` int(11) DEFAULT NULL,
  `login_attempts` int(11) DEFAULT 0,
  `blocked_until` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id_utilisateur`, `nom`, `prenom`, `email`, `mot_de_passe`, `id_role`, `login_attempts`, `blocked_until`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '$2y$10$HOEKqeMinZGoMVkJ23n8J.BSIDe0P7dNpL2fgcsC4ipbqm1fjmz9a', 1, 0, NULL),
(2, 'user', 'user', 'user@gmail.com', '$2y$10$JVWmczTnD6UR85UUUWR0muap6SqVhm./W7gLnxJoBv3GOszVpYQlG', 2, 0, NULL),
(3, 'client', 'client', 'client@gmail.com', '$2y$10$aRLMc/TfeQqla4NLfYfgaeydy.GRsBt1Rmg07p.fVqbeph0/E8Oxa', 3, 0, NULL),
(4, 'Zidane', 'Zinedine', 'zizou@gmail.com', '$2y$10$dvTVZL8MG9Zd4rMxrrAv3OBRcsvIEQAmh5m1TVGGmOzJpuQJXNZMS', 1, 0, NULL),
(5, 'San juan', 'Coco', 'coco92@gmail.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 1, '2024-02-25 14:58:10'),
(6, 'Barbet', 'Nicolas', 'nicoco@gmail.com', '$2y$10$QuNkT/3HzpJ/M5YRK/32JetKFuK6JiD28Xt4l2dvYMo763gSZlRh.', 4, 0, NULL),
(75, 'Smith', 'Emily', 'emilysmith@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(76, 'Johnson', 'Michael', 'michaeljohnson@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(77, 'Davis', 'Jessica', 'jessicadavis@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(78, 'Brown', 'Christopher', 'chrisbrown@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(79, 'Wilson', 'Olivia', 'oliviawilson@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(80, 'Anderson', 'William', 'williamanderson@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(81, 'Taylor', 'Sophia', 'sophiataylor@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(82, 'Thomas', 'Ava', 'avathomas@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(83, 'Miller', 'James', 'jamesmiller@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(84, 'Anderson', 'Isabella', 'isabellaanderson@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(85, 'Wilson', 'Benjamin', 'benjaminwilson@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(86, 'Clark', 'Natalie', 'natalieclark@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(87, 'Parker', 'Daniel', 'danielparker@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 1, 0, NULL),
(88, 'Lewis', 'Sophie', 'sophielewis@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(89, 'Harris', 'Alexander', 'alexanderharris@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(90, 'Adams', 'Victoria', 'victoriaadams@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(91, 'Bell', 'Andrew', 'andrewbell@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(92, 'Carter', 'Grace', 'gracecarter@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(93, 'Butler', 'Henry', 'henrybutler@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(94, 'Baker', 'Lily', 'lilybaker@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpd', 3, 0, NULL),
(95, 'Brooks', 'David', 'davidbrooks@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(96, 'Mitchell', 'Emma', 'emmamitchell@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(97, 'Ward', 'Joseph', 'josephward@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(98, 'Collins', 'Chloe', 'chloecollins@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(99, 'Cook', 'Matthew', 'matthewcook@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(100, 'Gray', 'Ava', 'avagray@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(101, 'Bailey', 'Sophia', 'sophiabailey@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(102, 'Murphy', 'Oliver', 'olivermurphy@icloud.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 3, 0, NULL),
(103, 'Scott', 'Isabella', 'isabellascott@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(104, 'Young', 'Lucas', 'lucasyoung@yahoo.com', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(105, 'Stewart', 'Madison', 'madisonstewart@outlook.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL),
(106, 'Price', 'Ethan', 'ethanprice@gmail.fr', '$2y$10$N4u.LUvm91Wfv4A51WDkIeu4gM4ayanyALFym.q5VUzz2.ZDDLpdK', 2, 0, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `FK_id_stock` (`id_stock`);

--
-- Index pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD PRIMARY KEY (`id_details`,`id_stock`),
  ADD KEY `id_stock` (`id_stock`);

--
-- Index pour la table `mouvements`
--
ALTER TABLE `mouvements`
  ADD PRIMARY KEY (`id_mouvement`),
  ADD KEY `id_stock` (`id_stock`),
  ADD KEY `id_commande` (`id_commande`);

--
-- Index pour la table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id_role`);

--
-- Index pour la table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id_stock`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id_utilisateur`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_role` (`id_role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `commandes`
--
ALTER TABLE `commandes`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `mouvements`
--
ALTER TABLE `mouvements`
  MODIFY `id_mouvement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `roles`
--
ALTER TABLE `roles`
  MODIFY `id_role` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id_stock` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=150;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commandes`
--
ALTER TABLE `commandes`
  ADD CONSTRAINT `FK_id_stock` FOREIGN KEY (`id_stock`) REFERENCES `stocks` (`id_stock`),
  ADD CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateurs` (`id_utilisateur`);

--
-- Contraintes pour la table `details_commande`
--
ALTER TABLE `details_commande`
  ADD CONSTRAINT `details_commande_ibfk_1` FOREIGN KEY (`id_details`) REFERENCES `commandes` (`id_commande`),
  ADD CONSTRAINT `details_commande_ibfk_2` FOREIGN KEY (`id_stock`) REFERENCES `stocks` (`id_stock`);

--
-- Contraintes pour la table `mouvements`
--
ALTER TABLE `mouvements`
  ADD CONSTRAINT `mouvements_ibfk_1` FOREIGN KEY (`id_stock`) REFERENCES `stocks` (`id_stock`),
  ADD CONSTRAINT `mouvements_ibfk_2` FOREIGN KEY (`id_commande`) REFERENCES `commandes` (`id_commande`);

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id_role`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
