-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 03 mai 2022 à 05:35
-- Version du serveur : 5.7.36
-- Version de PHP : 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `achat`
--

-- --------------------------------------------------------

--
-- Structure de la table `achat_a_faire`
--

DROP TABLE IF EXISTS `achat_a_faire`;
CREATE TABLE IF NOT EXISTS `achat_a_faire` (
  `id_achat` int(255) NOT NULL AUTO_INCREMENT,
  `id_produit` int(255) NOT NULL,
  `quantite` varchar(255) NOT NULL,
  `profil` int(11) NOT NULL,
  PRIMARY KEY (`id_achat`)
) ENGINE=MyISAM AUTO_INCREMENT=126 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `achat_realiser`
--

DROP TABLE IF EXISTS `achat_realiser`;
CREATE TABLE IF NOT EXISTS `achat_realiser` (
  `id_achar_realiser` int(255) NOT NULL AUTO_INCREMENT,
  `id_produit` int(255) NOT NULL,
  `quantite` varchar(255) NOT NULL,
  `prix` double NOT NULL,
  `date_achat` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `profil` int(11) NOT NULL,
  PRIMARY KEY (`id_achar_realiser`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id_produit` int(255) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `remarque` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `profil` int(255) NOT NULL,
  PRIMARY KEY (`id_produit`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;




/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
