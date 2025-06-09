-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 28 juin 2024 à 14:30
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
-- Base de données : `projet_crypto`
--

-- --------------------------------------------------------

--
-- Structure de la table `consultation`
--

CREATE TABLE `consultation` (
  `idConsultation` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `notesMedecincrypte` text DEFAULT NULL,
  `idMedecin` int(11) NOT NULL,
  `idPatient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consultation`
--

INSERT INTO `consultation` (`idConsultation`, `date`, `notesMedecincrypte`, `idMedecin`, `idPatient`) VALUES
(1, '2024-06-10 09:30:00', 'Patient présente des symptômes grippaux. Température élevée à 38.5°C. Prescription de paracétamol.', 1, 1),
(2, '2024-06-15 14:15:00', 'Contrôle post-opératoire. Cicatrisation normale. Aucune douleur rapportée.', 1, 2),
(3, '2024-06-20 10:00:00', 'Bilan annuel. Tension artérielle légèrement élevée (14/9). Recommandation de réduire la consommation de sel.', 2, 3),
(4, '2024-06-25 16:45:00', 'Consultation pour douleurs articulaires. Prescription d\'anti-inflammatoires et séance de kiné.', 1, 1),
(5, '2024-06-28 11:30:00', 'Vaccination annuelle contre la grippe effectuée. Aucun effet secondaire immédiat.', 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

CREATE TABLE `medecin` (
  `idMedecin` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `specialite` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`idMedecin`, `nom`, `specialite`, `password`) VALUES
(1, 'Dupont', 'Médecine générale', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: "password"
(2, 'Martin', 'Cardiologie', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'), -- password: "password"
(3, 'Leblanc', 'Pédiatrie', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); -- password: "password"

-- --------------------------------------------------------

--
-- Structure de la table `medicament`
--

CREATE TABLE `medicament` (
  `idMedicament` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `medicament`
--

INSERT INTO `medicament` (`idMedicament`, `nom`, `description`) VALUES
(1, 'Paracétamol', 'Antidouleur et antipyrétique. Dosage maximal: 4g/jour'),
(2, 'Ibuprofène', 'Anti-inflammatoire non stéroïdien. Prendre pendant les repas'),
(3, 'Amoxicilline', 'Antibiotique de la famille des pénicillines'),
(4, 'Atorvastatine', 'Traitement de l\'hypercholestérolémie'),
(5, 'Ventoline', 'Traitement de l\'asthme et des bronchospasmes');

-- --------------------------------------------------------

--
-- Structure de la table `ordonnance`
--

CREATE TABLE `ordonnance` (
  `idOrdonnance` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `idMedecin` int(11) NOT NULL,
  `idPatient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ordonnance`
--

INSERT INTO `ordonnance` (`idOrdonnance`, `date`, `idMedecin`, `idPatient`) VALUES
(1, '2024-06-10 09:35:00', 1, 1),
(2, '2024-06-15 14:20:00', 1, 2),
(3, '2024-06-20 10:05:00', 2, 3),
(4, '2024-06-25 16:50:00', 1, 1),
(5, '2024-06-28 11:35:00', 2, 4);

-- --------------------------------------------------------

--
-- Structure de la table `ordonnance_medicament`
--

CREATE TABLE `ordonnance_medicament` (
  `idOrdonnance` int(11) NOT NULL,
  `idMedicament` int(11) NOT NULL,
  `quantite` varchar(100) NOT NULL,
  `duree` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ordonnance_medicament`
--

INSERT INTO `ordonnance_medicament` (`idOrdonnance`, `idMedicament`, `quantite`, `duree`) VALUES
(1, 1, '1g', '6 heures pendant 3 jours'),
(1, 3, '500mg', '3 fois par jour pendant 7 jours'),
(2, 2, '400mg', '2 fois par jour pendant 5 jours'),
(3, 4, '20mg', '1 fois par jour pendant 30 jours'),
(4, 1, '500mg', '4 fois par jour pendant 5 jours'),
(4, 2, '200mg', '3 fois par jour pendant 7 jours'),
(5, 5, '2 bouffées', 'Au besoin');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

CREATE TABLE `patient` (
  `idPatient` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `dateNaissance` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`idPatient`, `nom`, `prenom`, `dateNaissance`) VALUES
(1, 'Durand', 'Jean', '1980-05-15'),
(2, 'Leroy', 'Marie', '1975-11-22'),
(3, 'Moreau', 'Pierre', '1965-03-08'),
(4, 'Petit', 'Sophie', '1992-07-30'),
(5, 'Roux', 'Luc', '1988-09-14');

-- --------------------------------------------------------

--
-- Structure de la table `resultatanalyse`
--

CREATE TABLE `resultatanalyse` (
  `idResultat` int(11) NOT NULL,
  `typeAnalyse` varchar(100) NOT NULL,
  `donneesCryptees` longblob NOT NULL,
  `idConsultation` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `resultatanalyse`
--

INSERT INTO `resultatanalyse` (`idResultat`, `typeAnalyse`, `donneesCryptees`, `idConsultation`) VALUES
(1, 'Analyse sanguine', 0x1f8b0800000000000000130b494d4f2b494d2b010000ffff030000000000, 1),
(2, 'Radiographie pulmonaire', 0x1f8b0800000000000000130b494d4f2b494d2b010000ffff030000000000, 2),
(3, 'ECG', 0x1f8b0800000000000000130b494d4f2b494d2b010000ffff030000000000, 3),
(4, 'IRM articulaire', 0x1f8b0800000000000000130b494d4f2b494d2b010000ffff030000000000, 4),
(5, 'Test allergique', 0x1f8b0800000000000000130b494d4f2b494d2b010000ffff030000000000, 5);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD PRIMARY KEY (`idConsultation`),
  ADD KEY `idMedecin` (`idMedecin`),
  ADD KEY `idPatient` (`idPatient`);

--
-- Index pour la table `medecin`
--
ALTER TABLE `medecin`
  ADD PRIMARY KEY (`idMedecin`);

--
-- Index pour la table `medicament`
--
ALTER TABLE `medicament`
  ADD PRIMARY KEY (`idMedicament`);

--
-- Index pour la table `ordonnance`
--
ALTER TABLE `ordonnance`
  ADD PRIMARY KEY (`idOrdonnance`),
  ADD KEY `idMedecin` (`idMedecin`),
  ADD KEY `idPatient` (`idPatient`);

--
-- Index pour la table `ordonnance_medicament`
--
ALTER TABLE `ordonnance_medicament`
  ADD PRIMARY KEY (`idOrdonnance`,`idMedicament`),
  ADD KEY `idMedicament` (`idMedicament`);

--
-- Index pour la table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`idPatient`);

--
-- Index pour la table `resultatanalyse`
--
ALTER TABLE `resultatanalyse`
  ADD PRIMARY KEY (`idResultat`),
  ADD UNIQUE KEY `idConsultation` (`idConsultation`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `consultation`
--
ALTER TABLE `consultation`
  MODIFY `idConsultation` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `medecin`
--
ALTER TABLE `medecin`
  MODIFY `idMedecin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `medicament`
--
ALTER TABLE `medicament`
  MODIFY `idMedicament` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `ordonnance`
--
ALTER TABLE `ordonnance`
  MODIFY `idOrdonnance` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `patient`
--
ALTER TABLE `patient`
  MODIFY `idPatient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `resultatanalyse`
--
ALTER TABLE `resultatanalyse`
  MODIFY `idResultat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `consultation`
--
ALTER TABLE `consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`idMedecin`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`idPatient`) REFERENCES `patient` (`idPatient`);

--
-- Contraintes pour la table `ordonnance`
--
ALTER TABLE `ordonnance`
  ADD CONSTRAINT `ordonnance_ibfk_1` FOREIGN KEY (`idMedecin`) REFERENCES `medecin` (`idMedecin`),
  ADD CONSTRAINT `ordonnance_ibfk_2` FOREIGN KEY (`idPatient`) REFERENCES `patient` (`idPatient`);

--
-- Contraintes pour la table `ordonnance_medicament`
--
ALTER TABLE `ordonnance_medicament`
  ADD CONSTRAINT `ordonnance_medicament_ibfk_1` FOREIGN KEY (`idOrdonnance`) REFERENCES `ordonnance` (`idOrdonnance`),
  ADD CONSTRAINT `ordonnance_medicament_ibfk_2` FOREIGN KEY (`idMedicament`) REFERENCES `medicament` (`idMedicament`);

--
-- Contraintes pour la table `resultatanalyse`
--
ALTER TABLE `resultatanalyse`
  ADD CONSTRAINT `resultatanalyse_ibfk_1` FOREIGN KEY (`idConsultation`) REFERENCES `consultation` (`idConsultation`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;