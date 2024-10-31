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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.breed : ~0 rows (environ)
INSERT INTO `breed` (`id`, `breed_name`) VALUES
	(1, 'Scottish fold');

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

-- Listage de la structure de table pawtners. cat
CREATE TABLE IF NOT EXISTS `cat` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_birth` date NOT NULL,
  `coat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `litter` tinyint(1) NOT NULL,
  `is_liked` tinyint(1) NOT NULL,
  `date_profile` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9E5E43A8A76ED395` (`user_id`),
  CONSTRAINT `FK_9E5E43A8A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.cat : ~2 rows (environ)
INSERT INTO `cat` (`id`, `user_id`, `name`, `gender`, `date_birth`, `coat`, `description`, `city`, `litter`, `is_liked`, `date_profile`) VALUES
	(1, 1, 'Choumouss', 'F', '2022-02-23', 'Noir', 'La plus belle des chattounettes', 'Schiltigheim', 1, 0, '2024-10-31 15:14:59'),
	(2, 11, 'Chat', 'F', '2021-03-21', 'Blanc', 'Beau chat', 'Strasbourg', 1, 0, '2024-10-31 15:40:05');

-- Listage de la structure de table pawtners. category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `category_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.category : ~0 rows (environ)

-- Listage de la structure de table pawtners. cat_vaccine
CREATE TABLE IF NOT EXISTS `cat_vaccine` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cat_id` int NOT NULL,
  `vaccine_id` int NOT NULL,
  `date_vaccine` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_876C12E7E6ADA943` (`cat_id`),
  KEY `IDX_876C12E72BFE75C3` (`vaccine_id`),
  CONSTRAINT `FK_876C12E72BFE75C3` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccine` (`id`),
  CONSTRAINT `FK_876C12E7E6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `cat` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.cat_vaccine : ~0 rows (environ)

-- Listage de la structure de table pawtners. image
CREATE TABLE IF NOT EXISTS `image` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cat_id` int NOT NULL,
  `image_link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_alt` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C53D045FE6ADA943` (`cat_id`),
  CONSTRAINT `FK_C53D045FE6ADA943` FOREIGN KEY (`cat_id`) REFERENCES `cat` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.image : ~0 rows (environ)

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
  `message_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6BD307FF624B39D` (`sender_id`),
  KEY `IDX_B6BD307FCD53EDB6` (`receiver_id`),
  CONSTRAINT `FK_B6BD307FCD53EDB6` FOREIGN KEY (`receiver_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_B6BD307FF624B39D` FOREIGN KEY (`sender_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.message : ~0 rows (environ)

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
  `post_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `review_content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
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
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ban` tinyint(1) NOT NULL,
  `register_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.user : ~2 rows (environ)
INSERT INTO `user` (`id`, `email`, `roles`, `password`, `is_verified`, `pseudo`, `avatar`, `ban`, `register_date`) VALUES
	(1, 'haj@mail.com', '[]', '$2y$13$g5czow56STM6QwcW25pDTOZbP.tw9nvxIlPJ8kD7aV1uzmCnEy/VG', 0, 'haj', 'https://th.bing.com/th/id/OIP.tLotgCDtzgTdwJcTiXWRCwHaEK?w=306&h=180&c=7&r=0&o=5&dpr=1.1&pid=1.7', 0, '2024-10-30 13:19:40'),
	(10, 'test@mail.com', '[]', '$2y$13$8ioE7NKWtyUnZvZr27515.bqR6MIPjpfg93Srn6WtvmPRNTzrcxq6', 0, 'test', NULL, 0, '2024-10-30 15:07:34'),
	(11, 'mail@mail.com', '[]', '$2y$13$rmWEe.SwOGhV1sPHxkmn0.y0tLdmCtatz1/cJfRcrQ8zeATS4EH4a', 0, 'mail', NULL, 0, '2024-10-31 14:55:58');

-- Listage de la structure de table pawtners. vaccine
CREATE TABLE IF NOT EXISTS `vaccine` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vaccine_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table pawtners.vaccine : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
