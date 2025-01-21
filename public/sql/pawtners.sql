-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour pawtners
CREATE DATABASE IF NOT EXISTS `pawtners` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `pawtners`;

-- Listage de la structure de table pawtners. breed
CREATE TABLE IF NOT EXISTS `breed` (
  `id` int NOT NULL AUTO_INCREMENT,
  `breed_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=173 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.breed : ~67 rows (environ)
INSERT INTO `breed` (`id`, `breed_name`) VALUES
	(106, 'Abyssinian'),
	(107, 'Aegean'),
	(108, 'American Bobtail'),
	(109, 'American Curl'),
	(110, 'American Shorthair'),
	(111, 'American Wirehair'),
	(112, 'Arabian Mau'),
	(113, 'Australian Mist'),
	(114, 'Balinese'),
	(115, 'Bambino'),
	(116, 'Bengal'),
	(117, 'Birman'),
	(118, 'Bombay'),
	(119, 'British Longhair'),
	(120, 'British Shorthair'),
	(121, 'Burmese'),
	(122, 'Burmilla'),
	(123, 'California Spangled'),
	(124, 'Chantilly-Tiffany'),
	(125, 'Chartreux'),
	(126, 'Chausie'),
	(127, 'Cheetoh'),
	(128, 'Colorpoint Shorthair'),
	(129, 'Cornish Rex'),
	(130, 'Cymric'),
	(131, 'Cyprus'),
	(132, 'Devon Rex'),
	(133, 'Donskoy'),
	(134, 'Dragon Li'),
	(135, 'Egyptian Mau'),
	(136, 'European Burmese'),
	(137, 'Exotic Shorthair'),
	(138, 'Havana Brown'),
	(139, 'Himalayan'),
	(140, 'Japanese Bobtail'),
	(141, 'Javanese'),
	(142, 'Khao Manee'),
	(143, 'Korat'),
	(144, 'Kurilian'),
	(145, 'LaPerm'),
	(146, 'Maine Coon'),
	(147, 'Malayan'),
	(148, 'Manx'),
	(149, 'Munchkin'),
	(150, 'Nebelung'),
	(151, 'Norwegian Forest Cat'),
	(152, 'Ocicat'),
	(153, 'Oriental'),
	(154, 'Persian'),
	(155, 'Pixie-bob'),
	(156, 'Ragamuffin'),
	(157, 'Ragdoll'),
	(158, 'Russian Blue'),
	(159, 'Savannah'),
	(160, 'Scottish Fold'),
	(161, 'Selkirk Rex'),
	(162, 'Siamese'),
	(163, 'Siberian'),
	(164, 'Singapura'),
	(165, 'Snowshoe'),
	(166, 'Somali'),
	(167, 'Sphynx'),
	(168, 'Tonkinese'),
	(169, 'Toyger'),
	(170, 'Turkish Angora'),
	(171, 'Turkish Van'),
	(172, 'York Chocolate');

-- Listage de la structure de table pawtners. breed_cat
CREATE TABLE IF NOT EXISTS `breed_cat` (
  `breed_id` int NOT NULL,
  `cat_id` int NOT NULL,
  PRIMARY KEY (`breed_id`,`cat_id`),
  KEY `IDX_659D8209A8B4A30F` (`breed_id`),
  KEY `IDX_659D8209E6ADA943` (`cat_id`),
  CONSTRAINT `FK_659D8209A8B4A30F` FOREIGN KEY (`breed_id`) REFERENCES `breed` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_659D8209E6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `cat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.breed_cat : ~0 rows (environ)
INSERT INTO `breed_cat` (`breed_id`, `cat_id`) VALUES
	(108, 61);

-- Listage de la structure de table pawtners. cat
CREATE TABLE IF NOT EXISTS `cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_birth` date NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `litter` tinyint(1) NOT NULL,
  `date_profile` datetime NOT NULL,
  `vaccinated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9E5E43A8A76ED395` (`user_id`),
  CONSTRAINT `FK_9E5E43A8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.cat : ~13 rows (environ)
INSERT INTO `cat` (`id`, `user_id`, `name`, `gender`, `date_birth`, `description`, `city`, `litter`, `date_profile`, `vaccinated`) VALUES
	(48, 57, 'Choumouss', 'Femelle', '2023-02-23', 'Mon chat', '67447', 0, '2025-01-13 07:45:24', 0),
	(49, 57, 'Mimir', 'Femelle', '2025-01-03', 'chat', '67482', 0, '2025-01-13 08:03:51', 0),
	(51, 60, 'Miaou', 'Mâle', '2023-08-11', 'chat', '67506', 0, '2025-01-13 12:33:40', 0),
	(52, 60, 'Popoy', 'Femelle', '2023-02-23', 'Chat', '67447', 0, '2025-01-13 14:06:08', 0),
	(53, 60, 'Minou', 'Femelle', '2024-07-12', 'd', '67482', 0, '2025-01-13 14:06:40', 0),
	(54, 60, 'Miaou', 'Mâle', '2024-07-12', 'Chat', '82137', 0, '2025-01-13 14:07:23', 0),
	(55, 62, 'Chouchou', 'Femelle', '2023-03-10', 'Chat', '42218', 0, '2025-01-13 14:08:40', 0),
	(56, 62, 'Poupouche', 'Mâle', '2022-06-09', 'Chat', '67462', 0, '2025-01-13 14:09:23', 0),
	(57, 62, 'Loubia', 'Femelle', '2023-07-06', 'Chat', '75056', 0, '2025-01-13 14:10:03', 0),
	(58, 62, 'Mimi', 'Mâle', '2023-06-07', 'Chat', '67482', 0, '2025-01-13 14:10:37', 0),
	(59, 57, 'chacha', 'Femelle', '2024-03-08', 'gggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggggg', '67447', 0, '2025-01-20 07:45:23', 0),
	(60, 57, 'chacha', 'Femelle', '2024-03-01', 'x', '67480', 0, '2025-01-20 09:55:39', 0),
	(61, 63, 'Bibou', 'Femelle', '2024-03-07', 'Chat', '67482', 1, '2025-01-20 14:47:53', 0);

-- Listage de la structure de table pawtners. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.category : ~4 rows (environ)
INSERT INTO `category` (`id`, `category_name`) VALUES
	(19, 'Santé'),
	(20, 'dfg'),
	(23, 'Categorie');

-- Listage de la structure de table pawtners. coat
CREATE TABLE IF NOT EXISTS `coat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coat_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.coat : ~6 rows (environ)
INSERT INTO `coat` (`id`, `coat_name`) VALUES
	(1, 'Noir'),
	(2, 'Blanc'),
	(3, 'Roux'),
	(4, 'Gris'),
	(5, 'Marron'),
	(6, 'Gris bleu');

-- Listage de la structure de table pawtners. coat_cat
CREATE TABLE IF NOT EXISTS `coat_cat` (
  `coat_id` int NOT NULL,
  `cat_id` int NOT NULL,
  PRIMARY KEY (`coat_id`,`cat_id`),
  KEY `IDX_7B335B8379F419D` (`coat_id`),
  KEY `IDX_7B335B83E6ADA943` (`cat_id`),
  CONSTRAINT `FK_7B335B8379F419D` FOREIGN KEY (`coat_id`) REFERENCES `coat` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_7B335B83E6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `cat` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.coat_cat : ~13 rows (environ)
INSERT INTO `coat_cat` (`coat_id`, `cat_id`) VALUES
	(1, 48),
	(1, 53),
	(1, 57),
	(2, 49),
	(2, 51),
	(2, 52),
	(2, 54),
	(2, 56),
	(2, 58),
	(2, 59),
	(3, 55),
	(3, 61),
	(4, 60);

-- Listage de la structure de table pawtners. image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cat_id` int NOT NULL,
  `image_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FE6ADA943` (`cat_id`),
  CONSTRAINT `FK_C53D045FE6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `cat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.image : ~19 rows (environ)
INSERT INTO `image` (`id`, `cat_id`, `image_link`, `image_alt`) VALUES
	(57, 48, '/uploads/pictures/pexels-pixabay-57416-6784c495199e5.jpg', 'Choumouss'),
	(58, 49, '/uploads/pictures/pexels-ihsanaditya-1056251-6784c8e74e375.jpg', 'Mimir'),
	(59, 49, '/uploads/pictures/pexels-pixabay-57416-6784c8e74f59d.jpg', 'Mimir'),
	(60, 49, '/uploads/pictures/chat-6784c8e74fee7.jpg', 'Mimir'),
	(62, 51, '/uploads/pictures/pexels-pixabay-57416-67850824f3bed.jpg', 'Miaou'),
	(63, 52, '/uploads/pictures/pexels-pixabay-57416-67851dd110f51.jpg', 'Popoy'),
	(64, 53, '/uploads/pictures/chat-67851df113f23.jpg', 'Minou'),
	(65, 54, '/uploads/pictures/pexels-pixabay-57416-67851e1c01971.jpg', 'Miaou'),
	(66, 55, '/uploads/pictures/chat-67851e690391a.jpg', 'Chouchou'),
	(67, 56, '/uploads/pictures/pexels-pixabay-416160-67851e93ac31d.jpg', 'Poupouche'),
	(68, 57, '/uploads/pictures/pexels-pixabay-57416-67851ebbdf808.jpg', 'Loubia'),
	(69, 58, '/uploads/pictures/pexels-kmerriman-20787-67851edd3bdf2.jpg', 'Mimi'),
	(70, 59, '/uploads/pictures/pexels-pixabay-416160-678dff135fd3b.jpg', 'chacha'),
	(71, 59, '/uploads/pictures/pexels-ihsanaditya-1056251-678dff1360a6d.jpg', 'chacha'),
	(72, 59, '/uploads/pictures/pexels-pixabay-57416-678dff136146a.jpg', 'chacha'),
	(73, 60, '/uploads/pictures/pexels-pixabay-416160-678e1d9e61b71.jpg', 'chacha'),
	(74, 61, '/uploads/pictures/pexels-pixabay-416160-678e6219a64fa.jpg', 'Bibou'),
	(75, 61, '/uploads/pictures/pexels-ihsanaditya-1056251-678e6219a75d3.jpg', 'Bibou'),
	(76, 61, '/uploads/pictures/pexels-pixabay-57416-678e6219a7fce.jpg', 'Bibou');

-- Listage de la structure de table pawtners. like
CREATE TABLE IF NOT EXISTS `like` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date_like` datetime NOT NULL,
  `cat_one_id` int NOT NULL,
  `cat_two_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AC6340B3259D2B66` (`cat_one_id`),
  KEY `IDX_AC6340B34EC1CCA9` (`cat_two_id`),
  CONSTRAINT `FK_AC6340B3259D2B66` FOREIGN KEY (`cat_one_id`) REFERENCES `cat` (`id`),
  CONSTRAINT `FK_AC6340B34EC1CCA9` FOREIGN KEY (`cat_two_id`) REFERENCES `cat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.like : ~11 rows (environ)
INSERT INTO `like` (`id`, `date_like`, `cat_one_id`, `cat_two_id`) VALUES
	(98, '2025-01-20 12:46:44', 58, 48),
	(99, '2025-01-20 12:46:54', 57, 49),
	(100, '2025-01-20 12:47:05', 56, 59),
	(101, '2025-01-20 13:09:06', 52, 48),
	(102, '2025-01-20 13:09:52', 48, 52),
	(103, '2025-01-20 13:37:26', 48, 55),
	(104, '2025-01-20 13:40:50', 48, 56),
	(105, '2025-01-20 14:41:09', 57, 48),
	(106, '2025-01-20 14:41:35', 48, 57),
	(107, '2025-01-20 14:48:07', 48, 61),
	(108, '2025-01-20 14:48:32', 61, 48);

-- Listage de la structure de table pawtners. matche
CREATE TABLE IF NOT EXISTS `matche` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cat_one_id` int NOT NULL,
  `cat_two_id` int NOT NULL,
  `date_match` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9FCAD510259D2B66` (`cat_one_id`),
  KEY `IDX_9FCAD5104EC1CCA9` (`cat_two_id`),
  CONSTRAINT `FK_9FCAD510259D2B66` FOREIGN KEY (`cat_one_id`) REFERENCES `cat` (`id`),
  CONSTRAINT `FK_9FCAD5104EC1CCA9` FOREIGN KEY (`cat_two_id`) REFERENCES `cat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.matche : ~2 rows (environ)
INSERT INTO `matche` (`id`, `cat_one_id`, `cat_two_id`, `date_match`) VALUES
	(40, 48, 52, '2025-01-20 13:09:53'),
	(41, 48, 57, '2025-01-20 14:41:36'),
	(42, 61, 48, '2025-01-20 14:48:32');

-- Listage de la structure de table pawtners. message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message_date` datetime NOT NULL,
  `message_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF624B39D` (`sender_id`),
  KEY `IDX_B6BD307FCD53EDB6` (`receiver_id`),
  CONSTRAINT `FK_B6BD307FCD53EDB6` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B6BD307FF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.message : ~5 rows (environ)
INSERT INTO `message` (`id`, `sender_id`, `receiver_id`, `message_date`, `message_content`) VALUES
	(20, 60, 57, '2025-01-20 13:10:47', 'test'),
	(21, 57, 60, '2025-01-20 13:55:35', 'test'),
	(22, 62, 57, '2025-01-20 14:42:01', 'test'),
	(23, 57, 63, '2025-01-20 14:48:50', 'test'),
	(24, 57, 60, '2025-01-21 07:42:16', 'jouoph'),
	(25, 57, 60, '2025-01-21 14:46:27', 'coucou'),
	(26, 60, 57, '2025-01-21 14:46:51', 'test');

-- Listage de la structure de table pawtners. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table pawtners. post
CREATE TABLE IF NOT EXISTS `post` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `topic_id` int NOT NULL,
  `post_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DA76ED395` (`user_id`),
  KEY `IDX_5A8A6C8D1F55203D` (`topic_id`),
  CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.post : ~0 rows (environ)

-- Listage de la structure de table pawtners. review
CREATE TABLE IF NOT EXISTS `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reviewer_id` int DEFAULT NULL,
  `reviewee_id` int DEFAULT NULL,
  `review_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_rating` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_794381C670574616` (`reviewer_id`),
  KEY `IDX_794381C6BD992930` (`reviewee_id`),
  CONSTRAINT `FK_794381C670574616` FOREIGN KEY (`reviewer_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_794381C6BD992930` FOREIGN KEY (`reviewee_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.review : ~4 rows (environ)
INSERT INTO `review` (`id`, `reviewer_id`, `reviewee_id`, `review_content`, `review_rating`) VALUES
	(15, 60, 57, 'très bien', 5),
	(16, 63, 57, 'très bien', 5),
	(17, 57, 63, 'très bien', 5),
	(18, 57, 62, 'très bien', 5);

-- Listage de la structure de table pawtners. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `category_id` int NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `topic_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BA76ED395` (`user_id`),
  KEY `IDX_9D40DE1B12469DE2` (`category_id`),
  CONSTRAINT `FK_9D40DE1B12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_9D40DE1BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.topic : ~0 rows (environ)

-- Listage de la structure de table pawtners. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `pseudo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban` tinyint(1) NOT NULL,
  `register_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.user : ~3 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`, `pseudo`, `avatar`, `ban`, `register_date`) VALUES
	(57, 'haj@mail.com', '["ROLE_ADMIN"]', '$2y$13$hZ98aVgDNC4nb1LJqPs2OuVD.w0o87QQCnOKqRxrvPZKXSALeoa.i', 1, 'haj', NULL, 0, '2025-01-09 10:03:29'),
	(60, 'test@mail.com', '["ROLE_USER"]', '$2y$13$hxp9xIZPV/Di01duPVEo3.ySbbrejpbad2ZrFXAo4uxi6cMgjt6Wq', 0, 'test', NULL, 0, '2025-01-13 07:51:42'),
	(61, 'miaou@mail.com', '["ROLE_USER"]', '$2y$13$bQ3UGf3wpmZrTx2QL7E4buUJSCkg6FODxqpdEQGcYQGnGzFefDRxy', 0, 'miaou', NULL, 0, '2025-01-13 07:54:23'),
	(62, 'chou@mail.com', '["ROLE_USER"]', '$2y$13$.VuVHuVssvSfuhaue0W4sOpbQeyqOvLrzsoO0HPFA1hYem8Wt/S4a', 0, 'chou', NULL, 0, '2025-01-13 09:52:41'),
	(63, 'hajjj@mail.com', '["ROLE_USER"]', '$2y$13$X9UUVWVJe6kZ9XNQf1PdYOzyBANL79dO42DxdoznpBp4x1ygDkZPm', 1, 'hajar', NULL, 0, '2025-01-13 12:24:14'),
	(64, 'chat@mail.com', '["ROLE_USER"]', '$2y$13$v/hLKOLnzRpeUHB9VEQOlODn14pBSRB/DkSiY8aTuF2Z9xVVigQU.', 1, 'chat', '/uploads/avatars/OIP-678e46553c77d.jpg', 0, '2025-01-20 12:49:24');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
