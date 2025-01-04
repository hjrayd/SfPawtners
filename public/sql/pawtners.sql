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
  `breed_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.breed : ~2 rows (environ)
INSERT INTO `breed` (`id`, `breed_name`) VALUES
	(1, 'Ragdoll'),
	(2, 'Scottish fold');

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

-- Listage des données de la table pawtners.breed_cat : ~2 rows (environ)
INSERT INTO `breed_cat` (`breed_id`, `cat_id`) VALUES
	(1, 34),
	(2, 13);

-- Listage de la structure de table pawtners. cat
CREATE TABLE IF NOT EXISTS `cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_birth` date NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `litter` tinyint(1) NOT NULL,
  `date_profile` datetime NOT NULL,
  `vaccinated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9E5E43A8A76ED395` (`user_id`),
  CONSTRAINT `FK_9E5E43A8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.cat : ~2 rows (environ)
INSERT INTO `cat` (`id`, `user_id`, `name`, `gender`, `date_birth`, `description`, `city`, `litter`, `date_profile`, `vaccinated`) VALUES
	(13, 1, 'Choumouss', 'femelle', '2023-02-23', 'Belle', 'Schiltigheim', 0, '2024-11-28 13:32:29', 0),
	(34, 1, 'Chat test', 'Femelle', '2025-01-01', 'sd', 'sd', 0, '2025-01-02 15:32:04', 0);

-- Listage de la structure de table pawtners. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.category : ~2 rows (environ)
INSERT INTO `category` (`id`, `category_name`) VALUES
	(19, 'Santé'),
	(20, 'dfg');

-- Listage de la structure de table pawtners. coat
CREATE TABLE IF NOT EXISTS `coat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `coat_name` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
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

-- Listage des données de la table pawtners.coat_cat : ~2 rows (environ)
INSERT INTO `coat_cat` (`coat_id`, `cat_id`) VALUES
	(1, 13),
	(3, 34);

-- Listage de la structure de table pawtners. image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cat_id` int NOT NULL,
  `image_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FE6ADA943` (`cat_id`),
  CONSTRAINT `FK_C53D045FE6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `cat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.image : ~2 rows (environ)
INSERT INTO `image` (`id`, `cat_id`, `image_link`, `image_alt`) VALUES
	(17, 13, '/uploads/pictures/chat-674870ed40a48.jpg', 'Choumouss'),
	(43, 34, '/uploads/pictures/cat-8239223-1280-6776b17455e2d.jpg', 'Chat test');

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
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.like : ~0 rows (environ)

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
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.matche : ~0 rows (environ)

-- Listage de la structure de table pawtners. message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message_date` datetime NOT NULL,
  `message_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF624B39D` (`sender_id`),
  KEY `IDX_B6BD307FCD53EDB6` (`receiver_id`),
  CONSTRAINT `FK_B6BD307FCD53EDB6` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B6BD307FF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.message : ~0 rows (environ)

-- Listage de la structure de table pawtners. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DA76ED395` (`user_id`),
  KEY `IDX_5A8A6C8D1F55203D` (`topic_id`),
  CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.post : ~4 rows (environ)
INSERT INTO `post` (`id`, `user_id`, `topic_id`, `post_content`, `post_date`) VALUES
	(15, NULL, 16, 'dfg', '2024-12-23 10:33:39'),
	(16, 32, 15, 'fdg', '2024-12-23 13:57:10'),
	(17, 33, 15, 'test', '2024-12-23 13:58:46'),
	(19, NULL, 19, 'xc', '2024-12-23 14:15:39');

-- Listage de la structure de table pawtners. review
CREATE TABLE IF NOT EXISTS `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reviewer_id` int DEFAULT NULL,
  `reviewee_id` int DEFAULT NULL,
  `review_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_rating` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_794381C670574616` (`reviewer_id`),
  KEY `IDX_794381C6BD992930` (`reviewee_id`),
  CONSTRAINT `FK_794381C670574616` FOREIGN KEY (`reviewer_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_794381C6BD992930` FOREIGN KEY (`reviewee_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.review : ~1 rows (environ)
INSERT INTO `review` (`id`, `reviewer_id`, `reviewee_id`, `review_content`, `review_rating`) VALUES
	(11, NULL, 1, 'rt', 5);

-- Listage de la structure de table pawtners. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `category_id` int NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `topic_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BA76ED395` (`user_id`),
  KEY `IDX_9D40DE1B12469DE2` (`category_id`),
  CONSTRAINT `FK_9D40DE1B12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_9D40DE1BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.topic : ~5 rows (environ)
INSERT INTO `topic` (`id`, `user_id`, `category_id`, `title`, `locked`, `topic_date`) VALUES
	(15, NULL, 19, 'tes', 0, '2024-12-23 09:57:23'),
	(16, NULL, 19, 'dfg', 0, '2024-12-23 10:33:35'),
	(18, 32, 19, 'Test', 0, '2024-12-23 13:56:06'),
	(19, NULL, 20, 'fvx', 0, '2024-12-23 14:15:34'),
	(20, NULL, 19, 'sef', 0, '2024-12-25 14:24:16');

-- Listage de la structure de table pawtners. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban` tinyint(1) NOT NULL,
  `register_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.user : ~5 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`, `pseudo`, `avatar`, `ban`, `register_date`) VALUES
	(1, 'haj@mail.com', '["ROLE_ADMIN"]', '$2y$13$BBukkD4Xe5S9r6OC4GEF8OI7QRCMmseDN3E8SH.gDEtLShCpgURh.', 0, 'haj', '/uploads/avatars/OIP-672dee90b2614.jpg', 0, '2024-11-08 10:57:20'),
	(32, 'mail@mail.com', '["ROLE_USER"]', '$2y$13$d/yASDenFVA.9iS7v25rXeeUx7DNcErwVyxJJT.5rL/jojwXzqP42', 0, 'mail', NULL, 1, '2024-12-23 13:47:55'),
	(33, 'chat@mail.com', '["ROLE_USER"]', '$2y$13$H48S7mZv/9MA3sWpcQB/B.96z/j95eUN2tjcxEH1r2a7.SzbCPK1C', 0, 'chat', NULL, 0, '2024-12-23 13:48:24'),
	(47, 'chou@mail.com', '["ROLE_USER"]', '$2y$13$Ld19KKD18FNomzoxXpR6suUz5ntY0n.RSqXKswt.odk1tGuXRtxHi', 0, 'chou@mail.com', NULL, 0, '2025-01-03 13:04:16'),
	(48, 'test@mail.com', '["ROLE_USER"]', '$2y$13$WM5QljjhX.wbcXTAD25kvePdQWjNRejDetMDZ5SvQI64A7cMZRiCW', 0, 'test', NULL, 0, '2025-01-03 13:05:46');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
