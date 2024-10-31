<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031124424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cat (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(50) NOT NULL, gender VARCHAR(50) NOT NULL, date_birth DATE NOT NULL, coat VARCHAR(50) NOT NULL, breed VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, city VARCHAR(50) NOT NULL, litter TINYINT(1) NOT NULL, is_liked TINYINT(1) NOT NULL, INDEX IDX_9E5E43A8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cat_vaccine (id INT AUTO_INCREMENT NOT NULL, cat_id INT NOT NULL, vaccine_id INT NOT NULL, date_vaccine DATE NOT NULL, INDEX IDX_876C12E7E6ADA943 (cat_id), INDEX IDX_876C12E72BFE75C3 (vaccine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, category_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, cat_id INT NOT NULL, image_link VARCHAR(255) NOT NULL, image_alt VARCHAR(50) NOT NULL, INDEX IDX_C53D045FE6ADA943 (cat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, cat_id INT NOT NULL, date_like DATETIME NOT NULL, INDEX IDX_AC6340B3A76ED395 (user_id), INDEX IDX_AC6340B3E6ADA943 (cat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, receiver_id INT NOT NULL, message_date DATETIME NOT NULL, message_content LONGTEXT NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307FCD53EDB6 (receiver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, topic_id INT NOT NULL, post_content LONGTEXT NOT NULL, post_date DATETIME NOT NULL, INDEX IDX_5A8A6C8DA76ED395 (user_id), INDEX IDX_5A8A6C8D1F55203D (topic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, reviewer_id INT NOT NULL, reviewee_id INT NOT NULL, review_content LONGTEXT NOT NULL, review_rating INT NOT NULL, INDEX IDX_794381C670574616 (reviewer_id), INDEX IDX_794381C6BD992930 (reviewee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topic (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, title VARCHAR(50) NOT NULL, locked TINYINT(1) NOT NULL, topic_date DATETIME NOT NULL, INDEX IDX_9D40DE1BA76ED395 (user_id), INDEX IDX_9D40DE1B12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vaccine (id INT AUTO_INCREMENT NOT NULL, vaccine_name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cat ADD CONSTRAINT FK_9E5E43A8A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE cat_vaccine ADD CONSTRAINT FK_876C12E7E6ADA943 FOREIGN KEY (cat_id) REFERENCES cat (id)');
        $this->addSql('ALTER TABLE cat_vaccine ADD CONSTRAINT FK_876C12E72BFE75C3 FOREIGN KEY (vaccine_id) REFERENCES vaccine (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FE6ADA943 FOREIGN KEY (cat_id) REFERENCES cat (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B3E6ADA943 FOREIGN KEY (cat_id) REFERENCES cat (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D1F55203D FOREIGN KEY (topic_id) REFERENCES topic (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C670574616 FOREIGN KEY (reviewer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6BD992930 FOREIGN KEY (reviewee_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1BA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE topic ADD CONSTRAINT FK_9D40DE1B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user CHANGE avatar avatar VARCHAR(255) DEFAULT NULL, CHANGE ban ban TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cat DROP FOREIGN KEY FK_9E5E43A8A76ED395');
        $this->addSql('ALTER TABLE cat_vaccine DROP FOREIGN KEY FK_876C12E7E6ADA943');
        $this->addSql('ALTER TABLE cat_vaccine DROP FOREIGN KEY FK_876C12E72BFE75C3');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FE6ADA943');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3A76ED395');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B3E6ADA943');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCD53EDB6');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D1F55203D');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C670574616');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6BD992930');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1BA76ED395');
        $this->addSql('ALTER TABLE topic DROP FOREIGN KEY FK_9D40DE1B12469DE2');
        $this->addSql('DROP TABLE cat');
        $this->addSql('DROP TABLE cat_vaccine');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE topic');
        $this->addSql('DROP TABLE vaccine');
        $this->addSql('ALTER TABLE `user` CHANGE avatar avatar VARCHAR(150) DEFAULT NULL, CHANGE ban ban TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
