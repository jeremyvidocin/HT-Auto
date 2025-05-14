-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 14 mai 2025 à 17:57
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `car_dealership2`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin_sessions`
--

CREATE TABLE `admin_sessions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `admin_sessions`
--

INSERT INTO `admin_sessions` (`id`, `user_id`, `token`, `ip_address`, `user_agent`, `last_activity`, `created_at`) VALUES
(1, 1, '03d3e6e1a5a1693c330cb3b2a11a112ca30fd152d28295dde4fb03b6fad53562', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0', '2025-05-14 15:54:45', '2025-05-14 13:55:39'),
(2, 1, '3e2c6718bae17932a6adf3c62006562fd388f294145a8908bb1f666c04898909', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-14 14:17:07', '2025-05-14 14:17:05'),
(3, 1, '66de5818bc40e663147cf5882f917b24d45d86fcb1080d8c0f3a9d3fe739a540', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-14 14:39:30', '2025-05-14 14:17:31'),
(4, 1, 'bfedcf143ea274a588742d352bfe07cb80a485f1e2ec82400bae24162811ca48', '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', '2025-05-14 14:39:58', '2025-05-14 14:39:56');

-- --------------------------------------------------------

--
-- Structure de la table `bookings`
--

CREATE TABLE `bookings` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `car_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `status` enum('pending','confirmed','completed','cancelled') NOT NULL DEFAULT 'pending',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `car_id`, `booking_date`, `booking_time`, `status`, `notes`, `created_at`) VALUES
(1, 1, 1, '2025-04-26', '14:00:00', 'confirmed', 'Je veux tester', '2025-04-24 16:17:30'),
(2, 1, 13, '2025-05-24', '11:00:00', 'pending', 'test', '2025-04-24 17:20:49');

-- --------------------------------------------------------

--
-- Structure de la table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(100) NOT NULL,
  `model` varchar(100) NOT NULL,
  `year` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `mileage` int(11) NOT NULL,
  `fuel_type` varchar(50) NOT NULL,
  `transmission` varchar(50) NOT NULL,
  `power` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `year`, `price`, `mileage`, `fuel_type`, `transmission`, `power`, `description`, `image`) VALUES
(1, 'Mercedes-Benz', 'C 220d', 2022, 45900.00, 25000, 'Diesel', 'Automatique', 194, 'Magnifique Mercedes Classe C en finition AMG Line. Véhicule français première main avec carnet d\'entretien complet. Équipements: Pack AMG, Toit ouvrant panoramique, Sièges cuir chauffants...', 'images/voitures/c220d.webp'),
(2, 'BMW', 'X3 xDrive20d', 2021, 52500.00, 35000, 'Diesel', 'Automatique', 190, 'BMW X3 en excellent état. Pack M Sport, Suspension adaptative, Toit panoramique, Système de navigation Professional...', 'images\\voitures\\bmw-x3.jpg'),
(3, 'Audi', 'A4 40 TDI', 2023, 48900.00, 15000, 'Diesel', 'Automatique', 204, 'Audi A4 récente en finition S-Line. Véhicule très bien équipé incluant: Virtual Cockpit, Matrix LED, Pack assistance...', 'images\\voitures\\audi_a4_40_tdi.jpg'),
(4, 'Porsche', 'Cayenne S', 2024, 98500.00, 1500, 'Essence', 'Automatique', 440, 'Porsche Cayenne S neuf. Suspension pneumatique adaptative, Pack Sport Chrono, Système audio BOSE®, Toit panoramique.', 'images/voitures/cayennes.jpg'),
(5, 'Audi', 'RS6 Avant', 2023, 125000.00, 8000, 'Essence', 'Automatique', 600, 'Audi RS6 Avant Performance. Pack Dynamic Plus, Système audio Bang & Olufsen, Sièges RS sport plus.', 'images/voitures/audi_rs6_avant.jpg'),
(6, 'Mercedes-Benz', 'AMG GT 63S', 2024, 165000.00, 3000, 'Essence', 'Automatique', 639, 'Mercedes-AMG GT 63 S 4MATIC+. Pack Night AMG, Système audio Burmester® High-End 3D, Toit panoramique.', 'images/voitures/amg-gt63s.jpg'),
(7, 'BMW', 'M5 Competition', 2023, 138000.00, 12000, 'Essence', 'Automatique', 625, 'BMW M5 Competition. M Driver\'s Package, Système audio Bowers & Wilkins Diamond, Pack Carbon.', 'images\\voitures\\bmw-m5-comp.avif'),
(8, 'Bentley', 'Continental GT', 2024, 245000.00, 2500, 'Essence', 'Automatique', 550, 'Bentley Continental GT V8. Spécification Mulliner, Système audio Naim, Toit ouvrant panoramique.', 'images\\voitures\\bentley-continental-gt.jpg'),
(9, 'Range Rover', 'Sport P530', 2024, 155000.00, 5000, 'Essence', 'Automatique', 530, 'Range Rover Sport Autobiography. Pack Dynamic, Système audio Meridian™ Signature, Toit panoramique coulissant.', 'images/voitures/rangeroversport.jpg'),
(10, 'Maserati', 'Grecale Trofeo', 2024, 128000.00, 4500, 'Essence', 'Automatique', 530, 'Maserati Grecale Trofeo. Pack Carbone, Système audio Sonus faber, Toit panoramique.', 'images\\voitures\\grecale.avif'),
(11, 'Aston Martin', 'DBX 707', 2024, 100000.00, 3500, 'Essence', 'Automatique', 707, 'Aston Martin DBX 707. Pack Carbon Exterior, Système audio Aston Martin Premium, Toit panoramique.', 'images\\voitures\\aston-martin-dbx-707.jpg'),
(12, 'Lamborghini', 'Urus S', 2024, 248000.00, 2000, 'Essence', 'Automatique', 666, 'Lamborghini Urus S. Pack Sport exhaust system, Système audio Bang & Olufsen 3D, Toit panoramique.', 'images\\voitures\\urus.jpg'),
(13, 'Ferrari', 'Purosangue', 2024, 385000.00, 1500, 'Essence', 'Automatique', 725, 'Ferrari Purosangue. Pack Feux carbone, Système audio JBL Professional, Toit panoramique électrochromique.', 'images\\voitures\\ferrari-purosangue.jpg'),
(14, 'Porsche', '911 GT3 RS', 2024, 245000.00, 2500, 'Essence', 'Manuelle', 525, 'Porsche 911 GT3 RS. Pack Weissach, Système audio BOSE®, Freins carbone-céramique.', 'images/voitures/gt3rs.jpg'),
(15, 'Mercedes-Benz', 'G 63 AMG', 2024, 185000.00, 5000, 'Essence', 'Automatique', 585, 'Mercedes-AMG G 63. Edition spéciale, Système audio Burmester®, Pack Night AMG.', 'images/voitures/g63.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `token` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `phone`, `address`, `created_at`, `updated_at`, `role`) VALUES
(1, 'Jérémy', 'VIDOCIN', 'jeremyvidocin@gmail.com', '$2y$10$97tAmGp0txpBoufgorSAf.L/aH40AgkyTgqzq.4PNK8AIvfuxEqe2', '0690715309', '5581 routa vaughenlieu', '2025-04-21 16:13:13', '2025-05-14 13:24:58', 'admin'),
(2, 'Jérémy', 'VIDOCIN', 'vidocin@gmail.com', '$2y$10$IfNHet1vicg1Sq7TjDwNJOQD/GqRCBxYBBuXG8DlRAPlkC6swycCC', '0690715309', '5581 routa vaughenlieu', '2025-04-21 16:24:00', '2025-04-21 16:24:00', 'user'),
(3, 'User', 'User', 'user@gmail.com', '$2y$10$RdJsCGukOLQ2PkKzLikLi.cLJZdCVcWAfTedBidAdKN4m0kEWGo3i', '0690876541', 'rue du test', '2025-05-14 02:18:47', '2025-05-14 02:18:47', 'user'),
(4, 'Admin', 'Admin', 'admin@gmail.com', '$2y$10$TWFt9GU/H//zMlAX8pd3tuDVX0/xTDOp2/2ijEZGFApp2cVoTl2m2', '0690123456', 'rue de l\'administration', '2025-05-14 14:47:56', '2025-05-14 14:47:56', 'admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin_sessions`
--
ALTER TABLE `admin_sessions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `booking_date_time_index` (`booking_date`,`booking_time`),
  ADD KEY `status_index` (`status`);

--
-- Index pour la table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_model_index` (`brand`,`model`),
  ADD KEY `price_index` (`price`);

--
-- Index pour la table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `email_password_index` (`email`,`password`),
  ADD KEY `role_index` (`role`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `admin_sessions`
--
ALTER TABLE `admin_sessions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin_sessions`
--
ALTER TABLE `admin_sessions`
  ADD CONSTRAINT `admin_sessions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
