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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.breed : ~0 rows (environ)
INSERT INTO `breed` (`id`, `breed_name`) VALUES
	(1, 'Scottish fold'),
	(2, 'Ragdoll');

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
	(1, 16),
	(1, 20),
	(1, 21),
	(2, 22);

-- Listage de la structure de table pawtners. cat
CREATE TABLE IF NOT EXISTS `cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_birth` date NOT NULL,
  `coat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `litter` tinyint(1) NOT NULL,
  `is_liked` tinyint(1) NOT NULL,
  `date_profile` datetime NOT NULL,
  `vaccinated` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9E5E43A8A76ED395` (`user_id`),
  CONSTRAINT `FK_9E5E43A8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.cat : ~3 rows (environ)
INSERT INTO `cat` (`id`, `user_id`, `name`, `gender`, `date_birth`, `coat`, `description`, `city`, `litter`, `is_liked`, `date_profile`, `vaccinated`) VALUES
	(16, 16, 'Choumouss', 'femelle', '2023-02-23', 'Noir', 'Mon chat', 'Schiltigheim', 0, 0, '2024-11-07 10:45:19', 0),
	(20, 16, 'test', 'femelle', '2024-11-01', 'test', 'test', 'test', 0, 0, '2024-11-07 15:02:11', 1),
	(21, 16, 'chat', 'femelle', '2024-11-01', 'er', 'er', 'er', 0, 0, '2024-11-07 15:03:03', 1),
	(22, 16, 'portee', 'femelle', '2021-02-12', 'dhsj', 'jdhs', 'hsjh', 1, 0, '2024-11-07 15:05:34', 0);

-- Listage de la structure de table pawtners. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.category : ~0 rows (environ)

-- Listage de la structure de table pawtners. image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cat_id` int NOT NULL,
  `image_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FE6ADA943` (`cat_id`),
  CONSTRAINT `FK_C53D045FE6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `cat` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.image : ~8 rows (environ)
INSERT INTO `image` (`id`, `cat_id`, `image_link`, `image_alt`) VALUES
	(16, 16, '/uploads/pictures/8b6dd6fab460a2ac0f001a0f2f664228-672c9a3f41db8.jpg', 'Choumouss'),
	(17, 16, '/uploads/pictures/a2ce89a6984146c4c8c59952ac6f4b5d-672c9a3f426a2.jpg', 'Choumouss'),
	(18, 16, '/uploads/pictures/7269ed20fa9b540dec924abd9a21d45a-672c9a3f42dd3.jpg', 'Choumouss'),
	(29, 20, '/uploads/pictures/7767a4a11ae28d300e8726c0cb79b952-672cd6736afae.jpg', 'test'),
	(30, 21, '/uploads/pictures/8ff20b194062a9a82ce1fedf98ec930d-672cd6a781ee1.jpg', 'chat'),
	(31, 22, '/uploads/pictures/8ff20b194062a9a82ce1fedf98ec930d-672cd73e2bf61.jpg', 'portee');

-- Listage de la structure de table pawtners. like
CREATE TABLE IF NOT EXISTS `like` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `cat_id` int NOT NULL,
  `date_like` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AC6340B3A76ED395` (`user_id`),
  KEY `IDX_AC6340B3E6ADA943` (`cat_id`),
  CONSTRAINT `FK_AC6340B3A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_AC6340B3E6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `cat` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.like : ~0 rows (environ)

-- Listage de la structure de table pawtners. message
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int NOT NULL,
  `receiver_id` int NOT NULL,
  `message_date` datetime NOT NULL,
  `message_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_read` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF624B39D` (`sender_id`),
  KEY `IDX_B6BD307FCD53EDB6` (`receiver_id`),
  CONSTRAINT `FK_B6BD307FCD53EDB6` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B6BD307FF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.message : ~1 rows (environ)

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
  `user_id` int NOT NULL,
  `topic_id` int NOT NULL,
  `post_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_5A8A6C8DA76ED395` (`user_id`),
  KEY `IDX_5A8A6C8D1F55203D` (`topic_id`),
  CONSTRAINT `FK_5A8A6C8D1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topic` (`id`),
  CONSTRAINT `FK_5A8A6C8DA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.post : ~0 rows (environ)

-- Listage de la structure de table pawtners. review
CREATE TABLE IF NOT EXISTS `review` (
  `id` int NOT NULL AUTO_INCREMENT,
  `reviewer_id` int NOT NULL,
  `reviewee_id` int NOT NULL,
  `review_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `review_rating` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_794381C670574616` (`reviewer_id`),
  KEY `IDX_794381C6BD992930` (`reviewee_id`),
  CONSTRAINT `FK_794381C670574616` FOREIGN KEY (`reviewer_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_794381C6BD992930` FOREIGN KEY (`reviewee_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.review : ~0 rows (environ)

-- Listage de la structure de table pawtners. topic
CREATE TABLE IF NOT EXISTS `topic` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `category_id` int NOT NULL,
  `title` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `topic_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9D40DE1BA76ED395` (`user_id`),
  KEY `IDX_9D40DE1B12469DE2` (`category_id`),
  CONSTRAINT `FK_9D40DE1B12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  CONSTRAINT `FK_9D40DE1BA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.user : ~3 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`, `pseudo`, `avatar`, `ban`, `register_date`) VALUES
	(10, 'test@mail.com', '["ROLE_USER"]', '$2y$13$8ioE7NKWtyUnZvZr27515.bqR6MIPjpfg93Srn6WtvmPRNTzrcxq6', 0, 'test', NULL, 0, '2024-10-30 15:07:34'),
	(11, 'mail@mail.com', '["ROLE_USER"]', '$2y$13$rmWEe.SwOGhV1sPHxkmn0.y0tLdmCtatz1/cJfRcrQ8zeATS4EH4a', 0, 'mail', NULL, 0, '2024-10-31 14:55:58'),
	(15, 'miaou@mail.com', '["ROLE_USER"]', '$2y$13$MApi4WINmxyRWNoLKxQDZeZyHWLRuEawPMSTSJaaYHEFeDJiY4yOy', 0, 'miaou', '/uploads/avatars/0dcf1420c7987f7c8fcf277deb21b189-672c9248e5472.jpg', 0, '2024-11-07 10:11:20'),
	(16, 'haj@mail.com', '["ROLE_ADMIN"]', '$2y$13$sc3hbpi0CSOdCycFjhP/Weo5mWWtwN2K9hstWxhhQ2X7olb2Pzdhu', 0, 'haj', '/uploads/avatars/aba5b608ba738ca0970f3093c4a9f2aa-672c98de5272f.jpg', 0, '2024-11-07 10:39:25');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
