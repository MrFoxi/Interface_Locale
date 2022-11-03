-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 19 oct. 2022 à 14:55
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
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `document`
--

INSERT INTO `document` (`id`, `titre`, `description`, `AncienNom`, `token_document`, `num_intervenant`, `num_session`, `created_at`) VALUES
(1, 'on refait encore d\'autre test', 'on test les problÃ¨mes', 'truc de ouf.pptx', 'P3a7OPsGIpBk6dGHU2lrjU1B1CaK18RXoYf4Wsnd3Wnh7oRwv1RqIfNs9pH7.pptx', 3, 4, '2022-10-19 07:17:15'),
(2, 'oidhksdq', 'dcnqs', 'compilation.pptx', 'KBF1zlzNbSTSEMRUkRWRE6qz3mlsusY1rMsz25ofNETscbUcoJdUyh87HLdN.pptx', 2, 3, '2022-10-19 08:01:35'),
(3, 'dqsdqsz', '', 'compilation.pptx', 'D5t7jXebwm8kMPsqJKEkd1nysB8dCtpHWWOG9Z1N9yWeHiYHeUExgmFpFo1h.pptx', 2, 3, '2022-10-19 08:01:58'),
(4, 'daqz', '', 'compilation.pptx', 'TlkjYATbNg0CSolFMim06fkaYbeYZxucrL1jYZfQWo2iOCXaCAlQOx5Drmgz.pptx', 1, 1, '2022-10-19 14:23:23');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `intervenant`
--

INSERT INTO `intervenant` (`id`, `nom`, `prenom`, `token_photo`, `created_at`) VALUES
(1, 'PERDRIX', 'Clement', 'perdrix.jpg', '2022-10-13 09:25:27'),
(2, 'CRENN', 'Xavier', 'test.png', '2022-10-13 09:42:40'),
(3, 'Duval', 'ErlÃ©', '0C8yrobqMu1UTq8wAshpUwk9YFPsM8MPLeqnq2eDuJNNOLZlQduWxMrYNt1e.jpg', '2022-10-17 15:42:33');

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
(1, 0, 4);

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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `session`
--

INSERT INTO `session` (`id`, `titre`, `created_at`) VALUES
(1, 'Session 1', '2022-10-18 12:48:40'),
(2, 'Session2', '2022-10-18 12:48:40'),
(3, 'Session 3', '2022-10-18 12:48:40'),
(4, 'Session 4 ', '2022-10-18 12:48:40'),
(5, 'Session 5', '2022-10-18 12:48:40'),
(6, 'Session 6', '2022-10-18 13:43:31'),
(7, 'Session 7', '2022-10-18 13:53:36');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
