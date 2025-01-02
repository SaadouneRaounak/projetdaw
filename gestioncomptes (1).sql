-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 02 jan. 2025 à 23:03
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
-- Base de données : `gestioncomptes`
--

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('teacher','student') NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `phone` varchar(20) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `status`, `phone`, `specialization`, `profile_picture`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', 'adminadmin', '', 'active', NULL, NULL, NULL, '2024-12-31 14:53:23'),
(6, 'ens', 'ens1@gmail.com', '$2y$10$HA2xxGYSdY1WCfegBwgCV.q.DuOO6IwwMP6qsRcV3cpgRHmrcmNZa', 'teacher', 'active', '0561579143', '', 'uploads/manager.png', '2024-12-30 23:03:52'),
(7, 'bourekha amani amani', 'loca@gmail.com', '$2y$10$ycMVsLPb8l.jU.lVEeYMSONNvmb/QM9Pwl008Qiqkq9LLop46DQ4C', 'student', 'active', '0561579143', 'sd', 'uploads/pexels-goumbik-669619.jpg', '2024-12-31 01:52:42'),
(13, 'active', 'active@gmail.com', '$2y$10$g6leeRQAMI8FHrrHPkRY0.acRh2MX/L9SmJjEUDL6XI8FYVTV9jRe', 'teacher', 'active', '0561579143', 'active', '', '2024-12-31 23:31:11'),
(15, 'diactive', 'diactive@gmail.com', '$2y$10$n3UZwKdMeJTTbsGo2Esr4ezQfli/kFXr4q0wB.S7Z.MWiWHUfpHAS', 'teacher', 'active', '0561579143', 'diactive', '', '2024-12-31 23:34:05'),
(18, 'koukou', 'koukou@gmail.com', '$2y$10$RxRrmz1MUm23W3kXTsgr8usRMKOM1Rwsu.q0gip3YJ7HG9KGdYsKO', 'student', 'active', '0561579143', 'koukou', '', '2024-12-31 23:37:35');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
