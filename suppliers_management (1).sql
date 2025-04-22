-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 13 déc. 2024 à 17:40
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
-- Base de données : `suppliers_management`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nom_categorie` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom_categorie`, `created_at`, `updated_at`) VALUES
(1, 'dératisation', '2024-12-13 13:08:39', '2024-12-13 13:08:39'),
(2, 'sanitaire', '2024-12-13 13:08:45', '2024-12-13 13:08:45'),
(3, 'plomberie', '2024-12-13 13:08:50', '2024-12-13 13:08:50'),
(4, 'fff', '2024-12-13 14:53:59', '2024-12-13 14:53:59'),
(5, 'ffffffff', '2024-12-13 14:54:05', '2024-12-13 14:54:05');

-- --------------------------------------------------------

--
-- Structure de la table `categorie_clients`
--

CREATE TABLE `categorie_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `client_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_client_fournisseurs`
--

CREATE TABLE `categorie_client_fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `clientFournisseur_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie_client_fournisseurs`
--

INSERT INTO `categorie_client_fournisseurs` (`id`, `categorie_id`, `clientFournisseur_id`, `created_at`, `updated_at`) VALUES
(7, 1, 7, NULL, NULL),
(8, 2, 8, NULL, NULL),
(9, 3, 9, NULL, NULL),
(10, 2, 10, NULL, NULL),
(11, 2, 11, NULL, NULL),
(12, 3, 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categorie_fournisseurs`
--

CREATE TABLE `categorie_fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `fournisseur_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `categorie_prospects`
--

CREATE TABLE `categorie_prospects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL,
  `prospect_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `groupId_client` char(36) DEFAULT NULL,
  `nomSociete_client` varchar(255) NOT NULL,
  `GSM1_client` varchar(255) NOT NULL,
  `GSM2_client` varchar(255) NOT NULL,
  `nom_client` varchar(255) NOT NULL,
  `tele_client` varchar(255) NOT NULL,
  `email_client` varchar(255) NOT NULL,
  `adresse_client` varchar(255) NOT NULL,
  `ville_client` varchar(255) NOT NULL,
  `version_client` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `groupId_fournisseur` char(36) DEFAULT NULL,
  `nomSociete_fournisseur` varchar(255) NOT NULL,
  `GSM1_fournisseur` varchar(255) NOT NULL,
  `GSM2_fournisseur` varchar(255) NOT NULL,
  `nom_fournisseur` varchar(255) NOT NULL,
  `tele_fournisseur` varchar(255) NOT NULL,
  `email_fournisseur` varchar(255) NOT NULL,
  `adresse_fournisseur` varchar(255) NOT NULL,
  `ville_fournisseur` varchar(255) NOT NULL,
  `version_fournisseur` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur_clients`
--

CREATE TABLE `fournisseur_clients` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `groupId_fournisseurClient` char(36) DEFAULT NULL,
  `nomSociete_fournisseurClient` varchar(255) NOT NULL,
  `GSM1_fournisseurClient` varchar(255) NOT NULL,
  `GSM2_fournisseurClient` varchar(255) NOT NULL,
  `nom_fournisseurClient` varchar(255) NOT NULL,
  `tele_fournisseurClient` varchar(255) NOT NULL,
  `email_fournisseurClient` varchar(255) NOT NULL,
  `adresse_fournisseurClient` varchar(255) NOT NULL,
  `ville_fournisseurClient` varchar(255) NOT NULL,
  `version_fournisseurClient` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseur_clients`
--

INSERT INTO `fournisseur_clients` (`id`, `groupId_fournisseurClient`, `nomSociete_fournisseurClient`, `GSM1_fournisseurClient`, `GSM2_fournisseurClient`, `nom_fournisseurClient`, `tele_fournisseurClient`, `email_fournisseurClient`, `adresse_fournisseurClient`, `ville_fournisseurClient`, `version_fournisseurClient`, `created_at`, `updated_at`) VALUES
(7, '5ac59942-fbb6-41e4-b769-ec018853cc3f', '', '', '', 'mohamed', '0600000000', 'med@gmail.com', 'medina', 'rabat', 1, '2024-12-13 15:28:17', '2024-12-13 15:28:17'),
(8, '5ac59942-fbb6-41e4-b769-ec018853cc3f', '', '', '', 'mohamed', '0600000000', 'med@gmail.com', 'medina', 'rabat', 1, '2024-12-13 15:28:17', '2024-12-13 15:28:17'),
(9, 'ddc0af6d-ed21-44b1-9b71-221fd480375d', '', '', '', 'rabab', '0633333333', 'rabab@gmail.com', 'medina', 'rabat', 1, '2024-12-13 15:28:20', '2024-12-13 15:28:20'),
(10, 'ddc0af6d-ed21-44b1-9b71-221fd480375d', '', '', '', 'rabab', '0633333333', 'rabab@gmail.com', 'medina', 'rabat', 1, '2024-12-13 15:28:20', '2024-12-13 15:28:20'),
(11, 'f8163798-6fe2-4660-8b5c-2fbf4fffd88a', '', '', '', 'sanaa', '66666666666', 'sanaa@gmail.com', 'medina', 'casablanca', 1, '2024-12-13 15:28:24', '2024-12-13 15:28:24'),
(12, 'f8163798-6fe2-4660-8b5c-2fbf4fffd88a', '', '', '', 'sanaa', '66666666666', 'sanaa@gmail.com', 'medina', 'casablanca', 1, '2024-12-13 15:28:24', '2024-12-13 15:28:24');

-- --------------------------------------------------------

--
-- Structure de la table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(129, '2014_10_12_000000_create_users_table', 1),
(130, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(131, '2019_08_19_000000_create_failed_jobs_table', 1),
(132, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(133, '2024_10_14_123110_create_fournisseurs_table', 1),
(134, '2024_10_14_140044_create_categories_table', 1),
(135, '2024_10_16_122637_create_sous_categories_table', 1),
(136, '2024_10_21_094523_add_categorie_id_to_sous_categories_table', 1),
(137, '2024_11_25_165117_create_categorie_fournisseurs_table', 1),
(138, '2024_12_05_112048_create_prospects_table', 1),
(139, '2024_12_05_112126_create_clients_table', 1),
(140, '2024_12_05_112213_create_fournisseur_clients_table', 1),
(141, '2024_12_06_110251_create_categorie_prospects_table', 1),
(142, '2024_12_10_154301_create_categorie_clients_table', 1),
(143, '2024_12_10_155018_create_categorie_client_fournisseurs_table', 1);

-- --------------------------------------------------------

--
-- Structure de la table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `prospects`
--

CREATE TABLE `prospects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `groupId_prospect` char(36) DEFAULT NULL,
  `nomSociete_prospect` varchar(255) NOT NULL,
  `GSM1_prospect` varchar(255) NOT NULL,
  `GSM2_prospect` varchar(255) NOT NULL,
  `nom_prospect` varchar(255) NOT NULL,
  `tele_prospect` varchar(255) NOT NULL,
  `email_prospect` varchar(255) NOT NULL,
  `adresse_prospect` varchar(255) NOT NULL,
  `ville_prospect` varchar(255) NOT NULL,
  `version_prospect` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `sous_categories`
--

CREATE TABLE `sous_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `nom_produit` varchar(255) NOT NULL,
  `texte` varchar(255) NOT NULL,
  `categorie_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `sous_categories`
--

INSERT INTO `sous_categories` (`id`, `created_at`, `updated_at`, `nom_produit`, `texte`, `categorie_id`) VALUES
(1, '2024-12-13 13:09:34', '2024-12-13 13:09:34', 'Coupe-tuyaux', 'ccccc', 3),
(2, '2024-12-13 13:09:44', '2024-12-13 13:09:44', 'Chalumaux', 'vcc', 3),
(3, '2024-12-13 13:09:58', '2024-12-13 13:09:58', 'sanitaire1', 'ssss', 2),
(4, '2024-12-13 13:10:15', '2024-12-13 13:10:15', 'derat1', 'dddd', 1),
(5, '2024-12-13 14:53:27', '2024-12-13 14:53:27', 'ddd', 'ddd', 1),
(6, '2024-12-13 14:53:39', '2024-12-13 14:53:39', 'ddddd', 'ddd', 1),
(9, '2024-12-13 15:36:47', '2024-12-13 15:36:47', 'dera3', 'deke iehze ojie deke iehze ojiedeke iehze ojiedeke iehze ojiedeke', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `contact`, `adresse`, `role`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'habiba', '0699999999', 'casablanca', 'super-admin', 'habiba@gmail.com', NULL, '$2y$12$AYLZdqzUQbJ47SXjMntSlOPIicL9uyKsv2Ffg303oOrpHkzL9R6LO', NULL, NULL, NULL),
(2, 'ilham', '0600000000', 'rahma', 'admin', 'ilham@gmail.com', NULL, '$2y$12$C0/H/GORy3h6afXlWstKaOU3G5gjQa9GOuW90phgdbVeLDnEbo7WO', NULL, '2024-12-13 10:50:55', '2024-12-13 10:50:55'),
(3, 'asmaa', '78945612352', 'fghfg', 'utilisateur', 'asmaa@gmail.com', NULL, '$2y$12$gudwrhMPcaWzgWTpFgFzju0eU7yRh1GYZH51Jb/ghwifwbAJ2bvBq', NULL, '2024-12-13 10:51:32', '2024-12-13 10:51:32'),
(4, 'ahmad', '060000000066', 'rahma', 'utilisateur', 'ahmad@gmail.com', NULL, '$2y$12$eutfRUtxxk4EyMl6npKBp.ePbQYXxBGJDjWT/7PHUpvs9Rh6ynlxe', NULL, '2024-12-13 10:52:16', '2024-12-13 10:52:16'),
(5, 'admin2', '060000000055', 'fghfg', 'admin', 'admin1@admin1.com', NULL, '$2y$12$HadO2gVdLJIsmfh1M7J6he3rOkNhrrSac5/QaSE9BEQEHhgu3WvwO', NULL, '2024-12-13 15:22:21', '2024-12-13 15:22:21');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categorie_clients`
--
ALTER TABLE `categorie_clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorie_clients_categorie_id_client_id_unique` (`categorie_id`,`client_id`),
  ADD KEY `categorie_clients_client_id_foreign` (`client_id`);

--
-- Index pour la table `categorie_client_fournisseurs`
--
ALTER TABLE `categorie_client_fournisseurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorie_client_fournisseurs_unique` (`categorie_id`,`clientFournisseur_id`),
  ADD KEY `categorie_client_fournisseurs_clientfournisseur_id_foreign` (`clientFournisseur_id`);

--
-- Index pour la table `categorie_fournisseurs`
--
ALTER TABLE `categorie_fournisseurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorie_fournisseurs_categorie_id_fournisseur_id_unique` (`categorie_id`,`fournisseur_id`),
  ADD KEY `categorie_fournisseurs_fournisseur_id_foreign` (`fournisseur_id`);

--
-- Index pour la table `categorie_prospects`
--
ALTER TABLE `categorie_prospects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categorie_prospects_categorie_id_prospect_id_unique` (`categorie_id`,`prospect_id`),
  ADD KEY `categorie_prospects_prospect_id_foreign` (`prospect_id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `fournisseur_clients`
--
ALTER TABLE `fournisseur_clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Index pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Index pour la table `prospects`
--
ALTER TABLE `prospects`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `sous_categories`
--
ALTER TABLE `sous_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sous_categories_categorie_id_foreign` (`categorie_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `categorie_clients`
--
ALTER TABLE `categorie_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `categorie_client_fournisseurs`
--
ALTER TABLE `categorie_client_fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `categorie_fournisseurs`
--
ALTER TABLE `categorie_fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `categorie_prospects`
--
ALTER TABLE `categorie_prospects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pour la table `fournisseur_clients`
--
ALTER TABLE `fournisseur_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `prospects`
--
ALTER TABLE `prospects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `sous_categories`
--
ALTER TABLE `sous_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categorie_clients`
--
ALTER TABLE `categorie_clients`
  ADD CONSTRAINT `categorie_clients_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categorie_clients_client_id_foreign` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `categorie_client_fournisseurs`
--
ALTER TABLE `categorie_client_fournisseurs`
  ADD CONSTRAINT `categorie_client_fournisseurs_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categorie_client_fournisseurs_clientfournisseur_id_foreign` FOREIGN KEY (`clientFournisseur_id`) REFERENCES `fournisseur_clients` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `categorie_fournisseurs`
--
ALTER TABLE `categorie_fournisseurs`
  ADD CONSTRAINT `categorie_fournisseurs_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categorie_fournisseurs_fournisseur_id_foreign` FOREIGN KEY (`fournisseur_id`) REFERENCES `fournisseurs` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `categorie_prospects`
--
ALTER TABLE `categorie_prospects`
  ADD CONSTRAINT `categorie_prospects_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `categorie_prospects_prospect_id_foreign` FOREIGN KEY (`prospect_id`) REFERENCES `prospects` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sous_categories`
--
ALTER TABLE `sous_categories`
  ADD CONSTRAINT `sous_categories_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
