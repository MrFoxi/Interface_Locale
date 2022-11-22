-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 04 nov. 2022 à 08:27
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `document`
--

-- --------------------------------------------------------

--
-- Structure de la table `document`
--

DROP TABLE IF EXISTS `document`;
CREATE TABLE IF NOT EXISTS `document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `AncienNom` varchar(255) NOT NULL,
  `token_document` varchar(80) NOT NULL,
  `num_intervenant` int(11) DEFAULT NULL,
  `num_session` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `document`
--

INSERT INTO `document` (`id`, `titre`, `description`, `AncienNom`, `token_document`, `num_intervenant`, `num_session`, `created_at`) VALUES
(1, 'gtrghboix', '', 'H0hLyZmilYJoG0DD1V5QJwMKM23cLhhecB4KkqJZAShuqOLxiyjkq1jGgpGL.odp', 'j4KtAxqJzXDjSwZnXXRptMYH9XaFt6n287Jk21pjNgRIG5mHoJwYTEGyNc2H.odp', 2, 2, '2022-11-03 13:31:13'),
(2, 'ffqsdfq', '', 'compilation.pptx', 'MA186ruUDJ41htOjzO942JUwdVXyBBArHbzZVuN1NEUh7vGYi0UBgsUDa0np.pptx', 2, 1, '2022-11-03 13:41:56'),
(3, 'ffqsdfq', '', 'compilation.pptx', 'WsGk4E8rmXtipDYVh0ctGrJsEHeqthdw60YfpL3TrLM53iMMmxHm623UPirC.pptx', 2, 1, '2022-11-03 13:42:27'),
(4, 'psefidhnds', '', 'truc de ouf.pptx', 'slNGFyHoKanAEXDjgC1TlG4GnwFbsn4pCS12XcM9QKg200C5MyrsgcQ0NHGi.pptx', 3, 1, '2022-11-03 15:05:21'),
(5, 'psefidhnds', '', 'truc de ouf.pptx', 'NxjOT5njE62vBoFulTM58m4qJlPNVT0U3rh0e5xzc782G3LKyvozECf3qkYA.pptx', 3, 1, '2022-11-03 15:07:19'),
(6, 'bfvcds', '', 'truc de ouf.pptx', '3GMCyx2uNWSu0oxUfaMZq3mAKDGodhI87SyVA3xPxbk6EWihagF71qSwBOud.pptx', 2, 4, '2022-11-03 15:07:36'),
(7, 'qciujqsdhbij', '', 'compilation.pptx', 'rTeo6tLYfabGsa8nRdpx2rvMKBA4DyICdtr6H5m7LBPGx7ZnXFT7p5sApAOh.pptx', 4, 3, '2022-11-03 15:24:18'),
(8, 'sdihbdsqo', '', 'compilation.pptx', 'TxtJDMMsKLKk4v1CRkUFrhnDtejCwtYibr54d6grFestRDGnE3bFj8447RCL.pptx', 4, 7, '2022-11-03 15:29:19'),
(9, 'qcqbn', '', 'compilation.pptx', '4YcPfdPxaN0nv8rOyQ9Ef8z4DvEHNCeGrF7URU7XZiYdb3Lc0Y92IciyUVkd.pptx', 4, 5, '2022-11-03 15:39:52'),
(10, 'testre', 'reteste', 'truc de ouf.pptx', 'E8fLOzG2xClto5VZQ6na5SOh211X3r9aNA1C70jlUypwsYITY1CLTkrpRwL6.pptx', 3, 6, '2022-11-03 16:12:58'),
(11, 'wjbncqlk', '', 'compilation.pptx', 'vr1HxgqkZHwqtWLvxAKhAaFfZoulF1nQxagRwnUke2ybcyhyL5IADXx50yf9.pptx', 3, 1, '2022-11-03 16:52:46');

-- --------------------------------------------------------

--
-- Structure de la table `intervenant`
--

DROP TABLE IF EXISTS `intervenant`;
CREATE TABLE IF NOT EXISTS `intervenant` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `token_photo` varchar(80) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `intervenant`
--

INSERT INTO `intervenant` (`id`, `nom`, `prenom`, `token_photo`, `created_at`) VALUES
(1, 'PERDRIX', 'Clement', 'perdrix.jpg', '2022-10-13 09:25:27'),
(2, 'CRENN', 'Xavier', 'test.png', '2022-10-13 09:42:40'),
(3, 'Duval', 'ErlÃ©', '0C8yrobqMu1UTq8wAshpUwk9YFPsM8MPLeqnq2eDuJNNOLZlQduWxMrYNt1e.jpg', '2022-10-17 15:42:33'),
(4, 'FortheShoot', 'Production', 'ojdhlL52z0aoet9sc4YUFoG6FWo9a9VUAW2s3J06HiYW9EueCuQLvWyh98I7.jpg', '2022-11-03 15:13:13');

-- --------------------------------------------------------

--
-- Structure de la table `lock_unlock`
--

DROP TABLE IF EXISTS `lock_unlock`;
CREATE TABLE IF NOT EXISTS `lock_unlock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cadenas` tinyint(1) NOT NULL DEFAULT '1',
  `session` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `lock_unlock`
--

INSERT INTO `lock_unlock` (`id`, `cadenas`, `session`) VALUES
(1, 1, 8);

-- --------------------------------------------------------

--
-- Structure de la table `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `titre`, `created_at`) VALUES
(1, 'Jour 1 - Salle 1 -TJBNSDLK ', '2022-11-03 08:12:34'),
(2, 'Session 2', '2022-11-03 08:12:34'),
(3, 'Session 3', '2022-11-03 08:12:34'),
(4, 'Session 4', '2022-11-03 08:12:34'),
(5, 'Session 5', '2022-11-03 08:12:34'),
(6, 'Session 6', '2022-11-03 08:12:34'),
(7, 'Session 7', '2022-11-03 15:12:23'),
(8, 'Session 8 ', '2022-11-03 16:53:08');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
