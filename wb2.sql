-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 15 juin 2021 à 00:07
-- Version du serveur :  10.4.18-MariaDB
-- Version de PHP : 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `wb2`
--

-- --------------------------------------------------------

--
-- Structure de la table `address`
--

CREATE TABLE `address` (
  `id` int(11) NOT NULL,
  `address` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `address`
--

INSERT INTO `address` (`id`, `address`, `city`, `state`, `zip`, `country`) VALUES
(1, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL),
(4, '21 Avenue Ertiah', 'Tunis', 'Tunis', '2062', 'Tunisia');

-- --------------------------------------------------------

--
-- Structure de la table `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `article`
--

INSERT INTO `article` (`id`, `username`, `title`, `content`, `active`, `created_at`) VALUES
(1, 'sarabriki', 'test article', '<p>test</p>', '1', '2021-06-13 20:41:43'),
(4, 'boutaieb', 'titre test', '<p>sarah briki</p>', '1', '2021-06-14 23:45:49');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `user` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `article_id`, `parent_id`, `user`, `content`, `active`, `email`, `pseudo`, `created_at`) VALUES
(1, 1, NULL, 'sarabriki', 'test comment', 1, 'brikisarah21@gmail.com', 'sara2', '2021-06-13 20:43:15'),
(2, 1, NULL, 'admin', 'reply test', 1, 'brikisarah21@gmail.com', 'sarah', '2021-06-14 00:48:56'),
(3, 1, NULL, 'boutaieb', 'abcd', 1, '', '', '2021-06-14 23:20:26'),
(4, 4, NULL, 'admin1', 'merci', 1, '', '', '2021-06-14 23:48:23');

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `is_send` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`, `created_at`, `is_send`) VALUES
(1, 'med bt', 'as@gmail.com', 'lorem', '2021-06-14 23:15:22', 0),
(2, 'boutaiebbb', 'b@gmail.com', 'lorem', '2021-06-14 23:31:58', 0),
(3, 'sara', 'gh@gmail.com', 'abcdefg', '2021-06-14 23:35:44', 0),
(4, 'mohamed', 'abcd@gmail.com', 'abcdefghij', '2021-06-14 23:43:40', 0);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210515114922', '2021-05-15 13:49:30', 333),
('DoctrineMigrations\\Version20210519143848', '2021-05-19 16:39:09', 226),
('DoctrineMigrations\\Version20210519153738', '2021-05-19 17:37:52', 111),
('DoctrineMigrations\\Version20210519173908', '2021-05-19 19:39:21', 166),
('DoctrineMigrations\\Version20210519175037', '2021-05-19 19:50:45', 96),
('DoctrineMigrations\\Version20210519180110', '2021-05-19 20:01:23', 32),
('DoctrineMigrations\\Version20210613135546', '2021-06-13 15:56:29', 452),
('DoctrineMigrations\\Version20210614092342', '2021-06-14 13:10:55', 227),
('DoctrineMigrations\\Version20210614093124', '2021-06-14 13:10:55', 55),
('DoctrineMigrations\\Version20210614111036', '2021-06-14 13:10:55', 14),
('DoctrineMigrations\\Version20210614112404', '2021-06-14 13:24:23', 102);

-- --------------------------------------------------------

--
-- Structure de la table `magazine`
--

CREATE TABLE `magazine` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `merchandise`
--

CREATE TABLE `merchandise` (
  `id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double NOT NULL,
  `in_stock` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `merchandise`
--

INSERT INTO `merchandise` (`id`, `url`, `price`, `in_stock`, `label`, `type`, `available`) VALUES
(76, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Buzz-Aldrin-Poster-510x721.jpg', 17.99, 14, 'Buzz Aldrin Poster', 'poster', 'In Stock'),
(77, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/09/20201014-AN-Yearbook-2021-247x349.jpg', 20, 9, 'AN Yearbook', 'poster', 'In Stock'),
(78, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/09/20200717-Shooting-Stars-II-247x349.jpg', 20, 6, 'Shooting Stars II', 'poster', 'In Stock'),
(79, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-PSO-Poster-510x721.jpg', 22.99, 10, 'PSO Poster', 'poster', 'In Stock'),
(80, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/05/20200504-Hubble-30th-Anniversary-Poster-510x721.jpg', 25, 9, 'Hubble 30th Anniversary Bundle', 'poster', 'In Stock'),
(81, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Enceladus-Poster-510x721.jpg', 27.99, 9, 'Enceladus Poster', 'poster', 'In Stock'),
(82, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2016/11/20161122-Space-Tourism-Bundle.jpg', 30, 10, 'Space Tourism Bundle', 'poster', 'In Stock'),
(83, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Trappist-1e-Poster-510x721.jpg', 35, 15, 'Trappist 1e Poster', 'poster', 'In Stock'),
(84, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Voyager-Hits-Poster-510x721.jpg', 35, 15, 'Voyager Hits Poster', 'poster', 'In Stock'),
(85, 'https://images-na.ssl-images-amazon.com/images/I/91E3V753QSL.jpg', 30.99, 150, 'Astronomy Magazine January 2017 - 7e edition', 'magazine', 'In Stock'),
(86, 'https://www.magazines88.com/wp-content/uploads/2020/03/Astronomy-Mar-2020.jpg', 25.99, 120, 'Astronomy Magazine March 2018 - 8e edition', 'magazine', 'In Stock'),
(87, 'https://www.jetspeedmedia.com/image/cache/catalog/2017/wat-600x711.jpg', 25.99, 80, 'Astronomy Magazine June 2019 - 9e edition', 'magazine', 'In Stock'),
(88, 'https://mir-s3-cdn-cf.behance.net/project_modules/1400/c3e3e829386506.560556fd0af46.jpg', 27.99, 20, 'Astronomy Magazine July 2019 - 9e edition vol II', 'magazine', 'In Stock'),
(89, 'https://truemagazines.com/6409-large_default/astronomy.jpg', 21.99, 50, 'Astronomy Magazine September 2020 - 10e edition', 'magazine', 'In Stock'),
(91, 'https://images-na.ssl-images-amazon.com/images/I/51e4CvweSeL._SX379_BO1,204,203,200_.jpg', 24.99, 40, 'Astronomy Magazine January 2021 - 11e edition', 'magazine', 'In Stock');

-- --------------------------------------------------------

--
-- Structure de la table `merch_order`
--

CREATE TABLE `merch_order` (
  `id` int(11) NOT NULL,
  `to_order_id` int(11) NOT NULL,
  `to_merch_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `merch_order`
--

INSERT INTO `merch_order` (`id`, `to_order_id`, `to_merch_id`, `quantity`) VALUES
(1, 1, 77, 1),
(2, 1, 78, 1),
(3, 1, 80, 1),
(4, 2, 76, 1);

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE `order` (
  `id` int(11) NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` datetime DEFAULT NULL,
  `cost` double DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `arrival` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `order`
--

INSERT INTO `order` (`id`, `username`, `date`, `cost`, `address_id`, `arrival`) VALUES
(1, 'boutaieb', '2021-06-14 23:36:46', 65, 4, '2021-06-29'),
(2, 'boutaieb', '2021-06-14 23:45:25', 17.99, 4, '2021-06-26');

-- --------------------------------------------------------

--
-- Structure de la table `poster`
--

CREATE TABLE `poster` (
  `id` int(11) NOT NULL,
  `price` double NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `in_stock` int(11) NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `available` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `availability` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:array)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `poster`
--

INSERT INTO `poster` (`id`, `price`, `url`, `in_stock`, `label`, `available`, `availability`) VALUES
(76, 30, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2016/11/20161122-Space-Tourism-Bundle.jpg', 10, 'Space Tourism Bundle', 'In Stock', ''),
(77, 25, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/05/20200504-Hubble-30th-Anniversary-Poster-510x721.jpg', 10, 'Hubble 30th Anniversary Bundle', 'In Stock', ''),
(78, 20, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/09/20201014-AN-Yearbook-2021-247x349.jpg', 10, 'AN Yearbook', 'In Stock', ''),
(79, 20, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/09/20200717-Shooting-Stars-II-247x349.jpg', 7, 'Shooting Stars II', 'In Stock', ''),
(80, 27.99, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Enceladus-Poster-510x721.jpg', 9, 'Enceladus Poster', 'In Stock', ''),
(81, 22, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-PSO-Poster-510x721.jpg', 10, 'PSO Poster', 'In Stock', ''),
(82, 30, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Trappist-1e-Poster-510x721.jpg', 10, 'Trappist 1e Poster', 'In Stock', ''),
(83, 35, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Voyager-Hits-Poster-510x721.jpg', 15, 'Voyager Hits Poster', 'In Stock', ''),
(84, 17.99, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Buzz-Aldrin-Poster-510x721.jpg', 15, 'Buzz Aldrin Poster', 'In Stock', '');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_id` int(11) DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `credits` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `reset_token` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `bio` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birthday` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`username`, `address_id`, `password`, `email`, `phone_number`, `credits`, `firstname`, `lastname`, `reset_token`, `roles`, `bio`, `photo`, `birthday`) VALUES
('admin', 2, '$argon2id$v=19$m=65536,t=4,p=1$Z0dudmZEeXhiN3JqS1Nkdw$G9crctt5kT06hhvUg9UHnWNF64xW7HbPHcTMJtmPYFE', 'admin@gmail.com', NULL, 100, NULL, NULL, NULL, '[\"ROLE_ADMIN\"]', NULL, '../default_profile_picture.png', NULL),
('admin1', 3, '$argon2id$v=19$m=65536,t=4,p=1$dzhaYVV6OG9KTGFJZS5QRA$ePLhTdAnntdq1aDGfqjYGudrClgojN4ZcjbJ45ovMhU', 'x@gmail.com', NULL, 100, NULL, NULL, NULL, '[\"ROLE_ADMIN\"]', NULL, '../default_profile_picture.png', NULL),
('boutaieb', 4, '$argon2id$v=19$m=65536,t=4,p=1$SjJLZVdnSThLU2tUa2FjYQ$G5M1J3TsZu2qZLE4/QtTq3kiRZ63DIxFsv0l4H31wDs', 'abc@gmail.com', '55366389', 17, 'Mohamed', 'Bou', NULL, '[]', 'lorem ipsum', '138628805-3657499304367754-2132136851098941987-n-60c7c033a379e.jpg', '2000-03-08'),
('sarabriki', 1, '$argon2id$v=19$m=65536,t=4,p=1$eVRBcC5ZdW53Z3doMk1udQ$aE92JLYp4C35i2nHas1Fj4so7d6UZoeRdPSN9GnJTnw', 'sb@sb.sb', NULL, 100, NULL, NULL, NULL, '[]', NULL, '../default_profile_picture.png', NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_23A0E66F85E0677` (`username`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5F9E962A7294869C` (`article_id`),
  ADD KEY `IDX_5F9E962A727ACA70` (`parent_id`),
  ADD KEY `IDX_5F9E962A8D93D649` (`user`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `magazine`
--
ALTER TABLE `magazine`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `merchandise`
--
ALTER TABLE `merchandise`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `merch_order`
--
ALTER TABLE `merch_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_31B235C940C6F396` (`to_order_id`),
  ADD KEY `IDX_31B235C9C5F1F576` (`to_merch_id`);

--
-- Index pour la table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_F5299398F85E0677` (`username`),
  ADD KEY `IDX_F5299398F5B7AF75` (`address_id`);

--
-- Index pour la table `poster`
--
ALTER TABLE `poster`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `UNIQ_8D93D649F5B7AF75` (`address_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `magazine`
--
ALTER TABLE `magazine`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `merchandise`
--
ALTER TABLE `merchandise`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT pour la table `merch_order`
--
ALTER TABLE `merch_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `order`
--
ALTER TABLE `order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `poster`
--
ALTER TABLE `poster`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `article`
--
ALTER TABLE `article`
  ADD CONSTRAINT `FK_23A0E66F85E0677` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_5F9E962A727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `comments` (`id`),
  ADD CONSTRAINT `FK_5F9E962A7294869C` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`),
  ADD CONSTRAINT `FK_5F9E962A8D93D649` FOREIGN KEY (`user`) REFERENCES `user` (`username`);

--
-- Contraintes pour la table `merch_order`
--
ALTER TABLE `merch_order`
  ADD CONSTRAINT `FK_31B235C940C6F396` FOREIGN KEY (`to_order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `FK_31B235C9C5F1F576` FOREIGN KEY (`to_merch_id`) REFERENCES `merchandise` (`id`);

--
-- Contraintes pour la table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `FK_F5299398F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`),
  ADD CONSTRAINT `FK_F5299398F85E0677` FOREIGN KEY (`username`) REFERENCES `user` (`username`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D649F5B7AF75` FOREIGN KEY (`address_id`) REFERENCES `address` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
