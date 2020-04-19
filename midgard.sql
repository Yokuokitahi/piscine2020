-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306

-- Généré le :  Dim 19 avr. 2020 à 11:37

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
  `Solde` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `acheteur`
--

INSERT INTO `acheteur` (`ID`, `Pseudo`, `Nom`, `Prenom`, `Password`, `Email`, `Adresse1`, `Adresse2`, `Ville`, `CodePostal`, `Pays`, `Telephone`, `Paiement`, `Panier`, `Etat`, `CarteBancaire`, `NomCarteB`, `DateExpCarteB`, `Crypto`, `Solde`) VALUES
(0, 'acheteur0', 'first', 'acheteur', 'root', 'firstacheteur@gmail.com', 'adresse bidon', '', 'VilleTest', '5911', 'PaysImaginaire', '0258963254', 'Visa', '', 0, '0', '', '0000-00-00', 0, 0),
(1, 'hina', 'Hina', 'Manolo', 'root', 'hina@ece.fr', 'ECE PARIS', '', 'PARIS', '75015', 'France', '0156875236', 'Ore', NULL, 1, '5194646261964961', 'hina', '2020-04-24', 2556, 996547867),
(2, 'phil', 'Hina', 'Manolo', 'root', 'phil@ece.fr', 'ECE PARIS', '', 'PARIS', '75015', 'deutch', '0156875236', 'Visa', NULL, 0, '5156165165161616', 'vazrav', '2222-06-25', 1516, 0);

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
(0, 'Drakking', 'root', 0),
(1, 'Skaway', 'root', 1);

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

DROP TABLE IF EXISTS `item`;
CREATE TABLE IF NOT EXISTS `item` (
  `ID` int(255) NOT NULL,
  `Nom` varchar(255) NOT NULL,
  `Photos` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Video` varchar(255) NOT NULL DEFAULT '''0''',
  `Prix` text NOT NULL,
  `Categorie` text NOT NULL,
  `IDVendeur` varchar(255) NOT NULL,
  `TypeVente` varchar(255) NOT NULL,
  `DureeEnchere` datetime NOT NULL DEFAULT '2050-01-01 00:00:00',
  `IDAcheteur` int(255) NOT NULL DEFAULT 0,
  `prixEnchere` int(255) NOT NULL DEFAULT 0,
  `Offre` int(255) NOT NULL DEFAULT 0,
  `NbOffre` int(255) NOT NULL DEFAULT 0,
  `ContreOffre` int(255) NOT NULL DEFAULT 0,
  `Nego` int(255) NOT NULL DEFAULT 0,
  `EtatEnchere` int(255) NOT NULL DEFAULT 0,
  `IDAcheteurEnchere` int(255) NOT NULL DEFAULT 0,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `item`
--


INSERT INTO `item` (`ID`, `Nom`, `Photos`, `Description`, `Video`, `Prix`, `Categorie`, `IDVendeur`, `TypeVente`, `DureeEnchere`, `IDAcheteur`, `prixEnchere`, `Offre`, `NbOffre`, `ContreOffre`, `Nego`, `EtatEnchere`, `IDAcheteurEnchere`) VALUES
(0, 'init', 'init', 'init', 'init', 'init', 'init', 'init', '', '0000-00-00 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0),
(1, 'Radio', 'radio jbl.png', 'Radio de marque JBL', '', '50', 'tresor', '3', 'comptant', '2050-01-01 00:00:00', 0, 0, 0, 0, 0, 0, 0, 0);


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

(1, 'jps', 'root', 'Segado', 'segado@ece.fr', 0x73656761646f2e6a7067, '', 0),
(2, 'malo', 'root', 'yacinmalo', 'malo@ece.fr', 0x6d616c6f2e504e47, 0x6563652e706e67, 0),
(3, 'Manu', 'root', 'Thibault', 'guisnel@ece.fr', 0x6d616e752e6a7067, 0x666f6e646d616e752e6a7067, 0);

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
