-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 19 déc. 2024 à 17:59
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
(1, 'dératisation', '2024-12-19 12:10:44', '2024-12-19 12:10:44'),
(2, 'plomberie', '2024-12-19 12:12:37', '2024-12-19 12:12:37');

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

--
-- Déchargement des données de la table `categorie_clients`
--

INSERT INTO `categorie_clients` (`id`, `categorie_id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 2, 2, NULL, NULL);

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

--
-- Déchargement des données de la table `categorie_fournisseurs`
--

INSERT INTO `categorie_fournisseurs` (`id`, `created_at`, `updated_at`, `categorie_id`, `fournisseur_id`) VALUES
(6, NULL, NULL, 1, 6),
(7, NULL, NULL, 2, 7);

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

--
-- Déchargement des données de la table `categorie_prospects`
--

INSERT INTO `categorie_prospects` (`id`, `categorie_id`, `prospect_id`, `created_at`, `updated_at`) VALUES
(3, 1, 3, NULL, NULL),
(4, 2, 4, NULL, NULL),
(7, 1, 7, NULL, NULL),
(8, 2, 8, NULL, NULL);

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
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `groupId_client`, `nomSociete_client`, `GSM1_client`, `GSM2_client`, `nom_client`, `tele_client`, `email_client`, `adresse_client`, `ville_client`, `version_client`, `user_id`, `remark`, `created_at`, `updated_at`) VALUES
(1, 'e045e4b2-0f4e-4263-bff0-821cdaabeafa', '', '', '', 'malak', '0644556611', 'malak@gmail.com', 'oulfa', 'casablanca', 1, 2, 'asmaa', '2024-12-19 14:01:13', '2024-12-19 14:08:22'),
(2, 'e045e4b2-0f4e-4263-bff0-821cdaabeafa', '', '', '', 'malak', '0644556611', 'malak@gmail.com', 'oulfa', 'casablanca', 2, 2, 'asmaa', '2024-12-19 14:01:17', '2024-12-19 14:08:22');

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
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `groupId_fournisseur`, `nomSociete_fournisseur`, `GSM1_fournisseur`, `GSM2_fournisseur`, `nom_fournisseur`, `tele_fournisseur`, `email_fournisseur`, `adresse_fournisseur`, `ville_fournisseur`, `version_fournisseur`, `user_id`, `remark`, `created_at`, `updated_at`) VALUES
(6, '236ac27e-c0b2-473e-ae95-d89016ccfd26', '', '', '', 'rabab', '0633333333', 'rabab@gmail.com', 'medina', 'rabat', 1, NULL, NULL, '2024-12-19 14:11:15', '2024-12-19 14:11:15'),
(7, '236ac27e-c0b2-473e-ae95-d89016ccfd26', '', '', '', 'rabab', '0633333333', 'rabab@gmail.com', 'medina', 'rabat', 1, NULL, NULL, '2024-12-19 14:11:15', '2024-12-19 14:11:15');

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
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `historiques`
--

CREATE TABLE `historiques` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `login_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `historiques`
--

INSERT INTO `historiques` (`id`, `user_id`, `login_at`, `created_at`, `updated_at`) VALUES
(1, 1, '2024-12-19 15:49:37', '2024-12-19 15:49:37', '2024-12-19 15:49:37'),
(2, 1, '2024-12-19 15:49:37', '2024-12-19 15:49:37', '2024-12-19 15:49:37'),
(3, 2, '2024-12-19 15:49:52', '2024-12-19 15:49:52', '2024-12-19 15:49:52'),
(4, 2, '2024-12-19 15:49:52', '2024-12-19 15:49:52', '2024-12-19 15:49:52'),
(5, 1, '2024-12-19 15:50:03', '2024-12-19 15:50:03', '2024-12-19 15:50:03'),
(6, 1, '2024-12-19 15:50:03', '2024-12-19 15:50:03', '2024-12-19 15:50:03'),
(7, 1, '2024-12-19 15:51:46', '2024-12-19 15:51:46', '2024-12-19 15:51:46'),
(8, 1, '2024-12-19 15:51:46', '2024-12-19 15:51:46', '2024-12-19 15:51:46'),
(9, 2, '2024-12-19 15:54:42', '2024-12-19 15:54:42', '2024-12-19 15:54:42'),
(10, 2, '2024-12-19 15:54:43', '2024-12-19 15:54:43', '2024-12-19 15:54:43'),
(11, 1, '2024-12-19 15:54:53', '2024-12-19 15:54:53', '2024-12-19 15:54:53'),
(12, 1, '2024-12-19 15:54:53', '2024-12-19 15:54:53', '2024-12-19 15:54:53');

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
(168, '2014_10_12_000000_create_users_table', 1),
(169, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(170, '2019_08_19_000000_create_failed_jobs_table', 1),
(171, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(172, '2024_10_14_123110_create_fournisseurs_table', 1),
(173, '2024_10_14_140044_create_categories_table', 1),
(174, '2024_10_16_122637_create_sous_categories_table', 1),
(175, '2024_10_21_094523_add_categorie_id_to_sous_categories_table', 1),
(176, '2024_11_25_165117_create_categorie_fournisseurs_table', 1),
(177, '2024_12_05_112048_create_prospects_table', 1),
(178, '2024_12_05_112126_create_clients_table', 1),
(179, '2024_12_05_112213_create_fournisseur_clients_table', 1),
(180, '2024_12_06_110251_create_categorie_prospects_table', 1),
(181, '2024_12_10_154301_create_categorie_clients_table', 1),
(182, '2024_12_10_155018_create_categorie_client_fournisseurs_table', 1),
(183, '2024_12_19_112101_make_user_id_nullable_on_fournisseurs', 1),
(186, '2024_12_19_153203_create_historiques_table', 2);

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
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `prospects`
--

INSERT INTO `prospects` (`id`, `groupId_prospect`, `nomSociete_prospect`, `GSM1_prospect`, `GSM2_prospect`, `nom_prospect`, `tele_prospect`, `email_prospect`, `adresse_prospect`, `ville_prospect`, `version_prospect`, `user_id`, `remark`, `created_at`, `updated_at`) VALUES
(3, 'd9dae9fb-1c89-4d35-bd3c-72bf37d63926', '', '', '', 'youssef', '0600112233', 'youssef@gmail.com', 'oulfa', 'casablanca', 1, 2, 'ghjghj', '2024-12-19 14:13:55', '2024-12-19 14:13:55'),
(4, 'd9dae9fb-1c89-4d35-bd3c-72bf37d63926', '', '', '', 'youssef', '0600112233', 'youssef@gmail.com', 'oulfa', 'casablanca', 1, 2, 'ghjghj', '2024-12-19 14:13:55', '2024-12-19 14:13:55'),
(7, '81a9fd06-ac25-48d9-a92b-3e5539afe96b', '', '', '', 'sanaa', '66666666622', 'sanaa@gmail.com', 'medina', 'casablanca', 1, 3, 'fcahmad', '2024-12-19 14:25:38', '2024-12-19 14:25:38'),
(8, '81a9fd06-ac25-48d9-a92b-3e5539afe96b', '', '', '', 'sanaa', '66666666622', 'sanaa@gmail.com', 'medina', 'casablanca', 1, 3, 'fcahmad', '2024-12-19 14:25:38', '2024-12-19 14:25:38');

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
(1, 'Iva Fay', '+17742176808', '6730 Solon Pike\nPort Jovanny, VT 78683-4235', 'super-admin', 'ilham@gmail.com', '2024-12-19 12:04:59', '$2y$12$Yd3M16jJ23JogP7BZtoqbeLoaeVbAYdqsK6FEWqjpYQzFddVcY8wi', 'kKtK1zpo6w', '2024-12-19 12:04:59', '2024-12-19 12:04:59'),
(2, 'asmaa', '0600000000', 'rahma', 'utilisateur', 'asmaa@gmail.com', NULL, '$2y$12$bzdTn2FgmdNa5iURbkotdOIdjrVu261jYZUn.uB8errEUS4TrdirW', NULL, '2024-12-19 12:07:56', '2024-12-19 12:07:56'),
(3, 'ahmad', '78999', 'rahma', 'utilisateur', 'ahmad@gmail.com', NULL, '$2y$12$ZMiLV.pIEsHV2wP//JVyBe7DM2W.QgusnibLeARyOacP1gPa9RS7y', NULL, '2024-12-19 12:26:01', '2024-12-19 12:26:01');

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `clients_user_id_foreign` (`user_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fournisseurs_user_id_foreign` (`user_id`);

--
-- Index pour la table `fournisseur_clients`
--
ALTER TABLE `fournisseur_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fournisseur_clients_user_id_foreign` (`user_id`);

--
-- Index pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD PRIMARY KEY (`id`),
  ADD KEY `historiques_user_id_foreign` (`user_id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `prospects_user_id_foreign` (`user_id`);

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
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `categorie_clients`
--
ALTER TABLE `categorie_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `categorie_client_fournisseurs`
--
ALTER TABLE `categorie_client_fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `categorie_fournisseurs`
--
ALTER TABLE `categorie_fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `categorie_prospects`
--
ALTER TABLE `categorie_prospects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `fournisseur_clients`
--
ALTER TABLE `fournisseur_clients`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `historiques`
--
ALTER TABLE `historiques`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- AUTO_INCREMENT pour la table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `prospects`
--
ALTER TABLE `prospects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `sous_categories`
--
ALTER TABLE `sous_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Contraintes pour la table `clients`
--
ALTER TABLE `clients`
  ADD CONSTRAINT `clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD CONSTRAINT `fournisseurs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `fournisseur_clients`
--
ALTER TABLE `fournisseur_clients`
  ADD CONSTRAINT `fournisseur_clients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `historiques`
--
ALTER TABLE `historiques`
  ADD CONSTRAINT `historiques_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `prospects`
--
ALTER TABLE `prospects`
  ADD CONSTRAINT `prospects_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `sous_categories`
--
ALTER TABLE `sous_categories`
  ADD CONSTRAINT `sous_categories_categorie_id_foreign` FOREIGN KEY (`categorie_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
