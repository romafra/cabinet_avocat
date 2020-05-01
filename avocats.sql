-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 30 avr. 2020 à 14:40
-- Version du serveur :  5.7.23
-- Version de PHP :  7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `avocats`
--

-- --------------------------------------------------------

--
-- Structure de la table `actu`
--

DROP TABLE IF EXISTS `actu`;
CREATE TABLE IF NOT EXISTS `actu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `imageurl` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `textalt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `actu`
--

INSERT INTO `actu` (`id`, `title`, `description`, `imageurl`, `link`, `textalt`) VALUES
(1, 'Un article sur le licenciement', 'lalalalallalal l lallalal lllllalallalallallallallallla', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `avocats`
--

DROP TABLE IF EXISTS `avocats`;
CREATE TABLE IF NOT EXISTS `avocats` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `init` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `avocats`
--

INSERT INTO `avocats` (`id`, `firstname`, `lastname`, `user_id`, `init`) VALUES
(1, 'Frank', 'romafra', 1, ''),
(2, 'Jacques', 'eee', 3, 'Y');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lastname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `firstname` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `statut` int(11) NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `lastname`, `firstname`, `adress`, `zipcode`, `city`, `phone`, `user_id`, `statut`, `email`) VALUES
(1, 'STICK', 'Ella', 'rue de la poste', '75001', NULL, '01 02 03 04 05', 4, 1, 'f.alba@free.fr'),
(2, 'LEUZE', 'Lara', 'rue de la paramount', '75012', 'Paris', '06 01 03 02 54', 5, 1, NULL),
(3, 'CROC', 'Odile', 'rue du zoo', '83000', 'Toulon', NULL, 11, 1, NULL),
(4, 'ZARELLA', 'Maude', 'rue d\'italie', '84000', 'Avignon', NULL, 12, 1, NULL),
(5, 'DEUF', 'John', 'Rue de la ferme', '78000', 'Versaille', '06258974', 13, 1, 'j.deuf@free.fr'),
(6, 'ONETTE', 'Marie', 'Bd des Guignols', '69000', 'LYON', '06 05 14 87 99', 14, 1, 'm.onette@gmail.com'),
(7, 'ARNE', 'Luc', 'rue de la maison', '13008', 'Marseille', '04 91 87 99 66', 15, 1, 'l.arne@gmail.com'),
(8, 'OUTAN', 'Laurent', 'avenue du zoo', '13210', 'Istres', '01 42 58 96 33', 16, 1, 'l.outan@free.fr'),
(10, 'Client', 'Nouveau', NULL, NULL, NULL, NULL, 10, 1, NULL),
(11, 'ASSIN', 'Marc', 'Bd de la Forêt', '44000', 'Nantes', '05 02 69 88 55', 17, 1, 'm.assin@gmail.com'),
(13, 'TERIEUR', 'Alain', 'Rue du ministére', '75014', 'PARIS', '06 23 58 77 44', 26, 1, 'a.terieur@free.fr'),
(14, 'ORAK', 'Anne', 'rue de la montagne', '04400', 'Brcelonnette', '01 52 69 87 66', 27, 1, 'a.orak2@free.fr'),
(15, 'CROCHE', 'Sarah', 'avenue du telephone', '06000', 'Nice', '44444', 25, 1, 's.croche@gmail.com'),
(16, 'TRANSENE', 'Jean', 'bd du thêatre', '94000', 'CRETEIL', '01 58 69 36 25', 29, 1, 'jean.transene@sfr.fr');

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doctype` int(11) DEFAULT NULL,
  `docsujet` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `docdate` date DEFAULT NULL,
  `docdosid` int(11) NOT NULL,
  `docstatut` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `document`
--

INSERT INTO `document` (`id`, `doctype`, `docsujet`, `docdate`, `docdosid`, `docstatut`) VALUES
(2, 2, 'Audienec eu tribunal administratif', '2020-04-02', 13, 2),
(4, 1, 'Audinec au tribnal de commerce le 12/04/20', '2020-01-03', 14, 0),
(5, 1, 'Experitse médical avec Dc Raoult', '2020-06-16', 6, 0),
(7, 0, 'Audience du Tribunal de commerce à Marseille reportée au 01/07/20', '2020-06-08', 4, 1),
(8, 0, 'Expertise médicale avec le Dr Caumont', '2019-09-06', 7, 2),
(9, 1, 'Test getID', '2020-06-10', 13, 0),
(10, 0, 'expertise medicale', '2020-05-04', 5, 1),
(11, 0, 'expertise medicale avec Dc machin', '2020-06-05', 5, 0),
(12, 2, 'Annulation procédure de recouvrement', '2020-09-09', 7, 1),
(13, 1, 'Lettre Recommandée AR pour prestations sociales', '2020-04-05', 4, 1),
(14, 0, 'Réunion avec le Juge des affaires familiales', '2020-04-05', 4, 1),
(15, 0, 'Mise en demeure père des enfants', '2020-03-05', 13, 0),
(16, 2, 'Proces verbal du commissariat de toulouse', '2020-02-10', 14, 2),
(17, 0, 'Confrontation avec Mr Onette Pierre', '2020-06-14', 6, 1),
(18, 2, 'Ajout d\'un document au dossier ref-1-9257', '2020-04-06', 5, 2),
(19, 0, 'Lettre recommandé AR', '2020-04-06', 18, 0),
(20, 1, 'Lettre RAR au Juge aux affaires familiales', '2020-04-07', 19, 2),
(21, 0, 'Confrontation avec Mr x', '2020-04-10', 5, 0),
(22, 0, 'Test ajout evenement apres nettoyage', '2020-04-11', 7, 0),
(23, 0, 'test redirection vers le dossier', '2020-04-11', 7, 0),
(24, 0, 'test redicettion undossier', '2020-04-11', 5, 0),
(25, 2, 'test redi', '2020-04-11', 5, 2),
(26, 2, 'test appres nettoyage modification', '2020-04-11', 5, 0),
(27, 0, 'test upload', '2020-04-11', 5, 0),
(28, 0, 'ffff', '2020-04-11', 5, 0),
(29, 0, 'ffff', '2020-04-11', 5, 0),
(30, 0, 'ffff', '2020-04-11', 5, 0),
(31, 0, 'toto', '2020-04-11', 5, 0),
(32, 3, 'Etiquette_Retour_Sportposition-5e91f898d86e8.pdf', '2020-04-11', 5, 0),
(34, 3, 'Planning 2017-2018-5e92c0caccd6d.pdf', '2020-04-12', 6, 1),
(35, 3, 'NOTE PARENT GALA Molière 2019 pdf-5e92c2e464826.pdf', '2020-04-12', 6, 0),
(38, 3, 'Ref-3-5381-LPM-FIS-Les-Forfaits-Sim.pdf', '2020-04-12', 18, 2),
(39, 3, 'Ref-3-13-9506-Etiquette_Retour_Sportposition.pdf', '2020-04-12', 19, 0),
(40, 1, 'Evenement sans upload', '2020-04-12', 19, 0),
(41, 3, 'Ref-3-13-9506-chaines-canal.pdf', '2020-04-12', 19, 0),
(42, 1, 'Test modif', '2020-04-01', 19, 1),
(44, 3, 'Ref-1-16-2158-DossierSpecial-Hypertension_20170110.pdf', '2020-03-12', 21, 1),
(45, 0, 'Test sans telecharger un dossier', '2020-01-01', 21, 0),
(46, 0, 'test', '2020-04-12', 19, 0),
(47, 3, 'Ref-3-13-9506-Facture PTH 2018.pdf', '2020-04-12', 19, 1),
(48, 3, 'Ref-3-5381-Dentiste150120.pdf', '2020-04-12', 18, 1),
(49, 3, 'Ref-1-1082-assignation_tribunal_judiciaire.pdf', '2020-04-23', 6, 1),
(50, 3, 'Ref-1-16-2158-assignation_tribunal_judiciaire.pdf', '2020-04-28', 21, 1);

-- --------------------------------------------------------

--
-- Structure de la table `dossier`
--

DROP TABLE IF EXISTS `dossier`;
CREATE TABLE IF NOT EXISTS `dossier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dosref` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dosstatut` int(11) DEFAULT NULL,
  `dosdescription` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dosdate` date DEFAULT NULL,
  `dosavoid` int(11) NOT NULL,
  `doscliid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `dossier`
--

INSERT INTO `dossier` (`id`, `dosref`, `dosstatut`, `dosdescription`, `dosdate`, `dosavoid`, `doscliid`) VALUES
(4, 'Ref-3-9547', 0, 'Divorce', '2020-04-06', 2, 1),
(5, 'Ref-1-8754', 0, 'Divorce Mme Onette Marie', '2020-04-05', 1, 6),
(6, 'Ref-1-1082', 0, 'Permise de contruire Mr ARNE', '2020-04-05', 1, 7),
(7, 'Ref-1-9728', 0, 'Succession user 2', '2020-04-05', 1, 1),
(13, 'Ref-3-6535', 0, 'Licenciement Economique Call Center', '2020-04-06', 2, 5),
(14, 'Ref-3-598', 0, 'retrait de permis conduite avec un taux > 1.8 g', '2020-03-10', 2, 11),
(18, 'Ref-3-5381', 0, 'Loyer impayé locataire', '2020-02-02', 2, 1),
(19, 'Ref-3-13-9506', 0, 'Obligations alimentaire', '2020-04-07', 2, 13),
(20, 'Ref-1-10-4106', 0, 'Test date', '2020-04-09', 1, 10),
(21, 'Ref-1-16-2158', 0, 'Test date d/m/y', '2020-04-10', 1, 16),
(22, 'Ref-1-7-7785', 0, 'Pension alimentaire', '2020-04-10', 1, 7),
(23, 'Ref-1-7-8998', 0, 'test création dossier', '2020-04-10', 1, 7),
(24, 'Ref-1-1-2924', 0, 'test du 11-04', '2020-04-11', 1, 1),
(25, 'Ref-1-7-226', 0, 'Demande de retraite anticipée', '2020-04-23', 1, 7);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

DROP TABLE IF EXISTS `migration_versions`;
CREATE TABLE IF NOT EXISTS `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20200325213944', '2020-03-28 19:47:11'),
('20200325214911', '2020-03-28 19:47:11'),
('20200325220408', '2020-03-28 19:47:12'),
('20200325222206', '2020-03-28 19:47:12'),
('20200326094252', '2020-03-28 19:47:12'),
('20200327235002', '2020-03-28 19:47:13'),
('20200327235122', '2020-03-28 19:47:13'),
('20200327235754', '2020-03-28 19:47:13'),
('20200330211827', '2020-03-31 08:06:04'),
('20200330223028', '2020-03-31 08:06:05'),
('20200331093005', '2020-03-31 09:32:09'),
('20200331130206', '2020-03-31 13:02:53'),
('20200331211631', '2020-04-02 08:36:17'),
('20200331211927', '2020-04-02 08:36:18'),
('20200331213531', '2020-04-02 08:36:19'),
('20200331220149', '2020-04-02 08:36:20'),
('20200331230723', '2020-04-02 08:36:21'),
('20200401113849', '2020-04-01 11:39:11'),
('20200401140116', '2020-04-02 08:36:22'),
('20200401202856', '2020-04-02 08:36:22'),
('20200401211139', '2020-04-02 08:36:23'),
('20200401211326', '2020-04-02 08:36:25'),
('20200401233347', '2020-04-02 08:36:25'),
('20200401234346', '2020-04-02 08:36:26'),
('20200401234727', '2020-04-02 08:36:28'),
('20200404075639', '2020-04-04 07:57:07'),
('20200404083832', '2020-04-04 08:38:45'),
('20200404084103', '2020-04-04 08:41:15'),
('20200404084206', '2020-04-04 08:42:16'),
('20200404090447', '2020-04-04 09:04:57'),
('20200405213952', '2020-04-06 17:51:07'),
('20200405214246', '2020-04-06 17:51:08'),
('20200405215519', '2020-04-06 17:51:08'),
('20200405233435', '2020-04-06 17:51:10'),
('20200406140741', '2020-04-06 17:51:11'),
('20200406155744', '2020-04-06 17:51:13'),
('20200406175234', '2020-04-06 17:52:48'),
('20200406180929', '2020-04-09 16:45:40'),
('20200407151612', '2020-04-09 16:45:41'),
('20200409093120', '2020-04-09 16:45:43');

-- --------------------------------------------------------

--
-- Structure de la table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE IF NOT EXISTS `newsletters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `rdv`
--

DROP TABLE IF EXISTS `rdv`;
CREATE TABLE IF NOT EXISTS `rdv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `user_id` int(11) NOT NULL,
  `mode` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avocat_id` int(11) DEFAULT NULL,
  `forname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_10C31F86EDBF2DB2` (`avocat_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `rdv`
--

INSERT INTO `rdv` (`id`, `subject`, `date`, `time`, `user_id`, `mode`, `status`, `avocat_id`, `forname`) VALUES
(2, 'Test prise de RDV avce Frank', '2020-07-02', '08:06:00', 1, 'Au cabinet', 'En attente', 1, ''),
(3, 'Test prise de RDV avce Frank', '2020-07-02', '08:06:00', 1, 'Au cabinet', 'En attente', 1, ''),
(4, 'test rdv modif', '2020-08-03', '03:04:00', 1, 'Par téléphone', 'Nouvelle date/heure', 1, ''),
(5, 'Consultation d\'informations', '2020-06-15', '08:30:00', 26, 'Par téléphone', 'Reporté par le client', 1, 'Alain Terieur'),
(6, 'test rdv', '2020-04-06', '09:15:00', 26, 'En visioconférence', 'En attente', 1, 'François');

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

DROP TABLE IF EXISTS `test`;
CREATE TABLE IF NOT EXISTS `test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `roles`, `password`) VALUES
(1, 'frank@gmail.com', '[\"ROLE_AVOCAT\"]', '$2y$13$oj24uNuKCIDZPOd2ryqWQehCr4yh2I6ZR3/GXoU2udmDrtzK4xH1q'),
(3, 'admin@gmail.com', '[\"ROLE_AVOCAT\"]', '$2y$13$ZZB0wgnJz/6cvxEQy/XRvevmlGrOrAdtAb/jNxnbhL6XoYVkiwj0K'),
(4, 'fanny@gmail.com', '[]', '$2y$13$tHZLu0mzIYcwZx15nQiqq.O6.a47aYDo1nYDjR2IQUNwlEnrJTg5.'),
(5, 'fanny2@gmail.com', '[\"ROLE_USER\", \"ROLE_AVOCAT\"]', '$2y$13$ldFq1vyQs84zyCbfn1EWDO92F1cPD3hIedPjErV5Fzu/myq73/MzG'),
(10, 'new.client@gmail.com', '[]', 'Newclient1234*'),
(11, 'c.odile', '[]', 'codile'),
(12, 'z.maude', '[]', 'zmaude'),
(13, 'd.john', '[]', 'djohn'),
(14, 'o.marie', '[]', 'omarie'),
(15, 'a.luc', '[]', 'aluc'),
(16, 'o.laurent', '[]', 'olaurent'),
(17, 'a.marc', '[]', 'amarc'),
(18, 's.ella', '[]', 'sella'),
(19, 'l.lara', '[]', 'llara'),
(20, 'c.nouveau', '[]', 'cnouveau'),
(21, 'client0704@gmail.com', '[]', '$2y$13$HevoAPakOVfTQ.y/pyGjBuPApUk47mMsvKqnqxq53oJsz/.n66eG2'),
(25, 'client0704b@gmail.com', '[]', '$2y$13$Z1vzbWLtEvXCaS6g0ZbNuuUKbsYwu5qllB71j.0Xyf/umrUinCr0.'),
(26, 'a.terieur@gmail.com', '[]', '$2y$13$beCiB3RZwpVvsni.PzOG3.Inv0Du1fgMoQKmzrbAbIht39E0nk6Vm'),
(27, 'orak@gmail.com', '[]', '$2y$13$S3bAExQD0zj7uzE13/b3B.yjAIhYLIjtXQAFAdUPqmeVkU.6009Ii'),
(28, 'a.versaire@gmail.com', '[]', '$2y$13$A.nYS3rXgMl32PbG1umfr.F8hqqXr74hacT1a2YaKNLkzW0DDAZtW'),
(29, 'j.transene@sfr.fr', '[]', '$2y$13$lRQWUa8Jwui1l6.ZWNq3BuREhfcI66l5NZij190wZjfw1WpFYnaRe'),
(30, 'frank13@gmail.com', '[]', '$2y$13$Z0E26YRJgiqCYFOoeq5PH.3J5Hei5IVstzQK85uETm/E3Eh1nRSgS'),
(31, 'j.v@gmail.com', '[]', '$2y$13$f6.0F0NGYIrjXrRKIbWecer5TquF2jw7vZKWoNt.pTWpzFXAOIoKC');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `rdv`
--
ALTER TABLE `rdv`
  ADD CONSTRAINT `FK_10C31F86EDBF2DB2` FOREIGN KEY (`avocat_id`) REFERENCES `avocats` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
