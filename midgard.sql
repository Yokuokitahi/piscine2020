-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le :  jeu. 16 avr. 2020 à 15:20
-- Version du serveur :  10.4.10-MariaDB
-- Version de PHP :  7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `midgard`
--

-- --------------------------------------------------------

--
-- Structure de la table `acheteur`
--

DROP TABLE IF EXISTS `acheteur`;
CREATE TABLE IF NOT EXISTS `acheteur` (
  `ID` int(255) NOT NULL,
  `Pseudo` varchar(255) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Prenom` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Adresse1` text NOT NULL,
  `Adresse2` text DEFAULT NULL,
  `Ville` text NOT NULL,
  `CodePostal` text NOT NULL,
  `Pays` text NOT NULL,
  `Telephone` text NOT NULL,
  `Paiement` text NOT NULL,
  `Panier` text DEFAULT NULL,
  `Etat` int(1) NOT NULL DEFAULT 0,
  `CarteBancaire` text NOT NULL DEFAULT '0',
  `NomCarteB` varchar(255) NOT NULL,
  `DateExpCarteB` date NOT NULL,
  `Crypto` int(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `acheteur`
--

INSERT INTO `acheteur` (`ID`, `Pseudo`, `Nom`, `Prenom`, `Password`, `Email`, `Adresse1`, `Adresse2`, `Ville`, `CodePostal`, `Pays`, `Telephone`, `Paiement`, `Panier`, `Etat`, `CarteBancaire`, `NomCarteB`, `DateExpCarteB`, `Crypto`) VALUES
(0, 'acheteur0', 'first', 'acheteur', 'root', 'firstacheteur@gmail.com', 'adresse bidon', '', 'VilleTest', '5911', 'PaysImaginaire', '0258963254', 'Visa', '', 0, '0', '', '0000-00-00', 0),
(1, 'hina', 'Hina', 'Manolo', 'root', 'hina@ece.fr', 'ECE PARIS', '', 'PARIS', '75015', 'France', '0156875236', 'Ore', NULL, 0, '5194646261964961', 'hina', '2020-04-24', 2556);

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `ID` int(255) NOT NULL,
  `Pseudo` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Etat` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`ID`, `Pseudo`, `Password`, `Etat`) VALUES
(1, 'Drakking', 'root', 0),
(2, 'Skaway', 'root', 0);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `ID` int(255) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Photos` blob NOT NULL,
  `Description` text NOT NULL,
  `Video` blob NOT NULL DEFAULT '0',
  `Prix` text NOT NULL,
  `Categorie` text NOT NULL,
  `IDVendeur` int(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item`
--

INSERT INTO `item` (`ID`, `Nom`, `Photos`, `Description`, `Video`, `Prix`, `Categorie`, `IDVendeur`) VALUES
(0, 'itemInit', 0x496e697469616c69736174696f6e, 'Initialisation', 0x496e697469616c69736174696f6e, '0', '0', 0),
(1, 'Bracelet Fenrir', 0x62726163656c65742d66656e7269722e6a7067, 'Bracelet de l\'Ã©poque celte', '', '3500000', 'relique', 1),
(2, 'Montre en or', 0x6d6f6e7472656f722e6a7067, 'Grosse montre', '', '1000', 'vip', 1),
(3, 'EpÃ©e', 0x657065652e6a7067, 'Ã©pÃ©e ancienne', '', '30', 'relique', 1),
(4, 'Tasse', 0x74617373652e6a7067, 'une tasse normale', '', '2', 'tresor', 1),
(5, 'briquet', 0x627269717565742e6a7067, 'un briquet qui fait du feu', '', '1', 'tresor', 1);

-- --------------------------------------------------------

--
-- Structure de la table `vendeur`
--

DROP TABLE IF EXISTS `vendeur`;
CREATE TABLE IF NOT EXISTS `vendeur` (
  `ID` int(255) NOT NULL,
  `Pseudo` varchar(255) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Photos` blob DEFAULT NULL,
  `Background` blob DEFAULT NULL,
  `Etat` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `vendeur`
--

INSERT INTO `vendeur` (`ID`, `Pseudo`, `Password`, `Nom`, `Email`, `Photos`, `Background`, `Etat`) VALUES
(0, 'client0', 'root', 'firstclient', 'firstclient@gmail.com', '', '', 0),
(1, 'jps', 'root', 'segado', 'segado@ece.fr', 0x73656761646f2e6a7067, 0x6563652e706e67, 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
