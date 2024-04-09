<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409003053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, url_img VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, INDEX IDX_23A0E6612469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article_services (article_id INT NOT NULL, services_id INT NOT NULL, INDEX IDX_26DA15027294869C (article_id), INDEX IDX_26DA1502AEF5A6C1 (services_id), PRIMARY KEY(article_id, services_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, name VARCHAR(255) NOT NULL, zip_code VARCHAR(10) NOT NULL, INDEX IDX_2D5B0234F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5373C96677153098 (code), UNIQUE INDEX UNIQ_5373C9665E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT NOT NULL, city_id INT DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, date_creation DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', civility TINYINT(1) DEFAULT NULL, society VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(15) DEFAULT NULL, INDEX IDX_81398E098BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, status_id INT NOT NULL, affected_staff_id INT DEFAULT NULL, deposit_hour DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', recuperation_hour DATETIME DEFAULT NULL, total_price DOUBLE PRECISION NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id), INDEX IDX_F52993986BF700BD (status_id), INDEX IDX_F529939897B86DAE (affected_staff_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_article (order_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F440A72D8D9F6D38 (order_id), INDEX IDX_F440A72D7294869C (article_id), PRIMARY KEY(order_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE staff (id INT NOT NULL, staff_number VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, discr VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E6612469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE article_services ADD CONSTRAINT FK_26DA15027294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article_services ADD CONSTRAINT FK_26DA1502AEF5A6C1 FOREIGN KEY (services_id) REFERENCES services (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE city ADD CONSTRAINT FK_2D5B0234F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E098BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939897B86DAE FOREIGN KEY (affected_staff_id) REFERENCES staff (id)');
        $this->addSql('ALTER TABLE order_article ADD CONSTRAINT FK_F440A72D8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_article ADD CONSTRAINT FK_F440A72D7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE staff ADD CONSTRAINT FK_426EF392BF396750 FOREIGN KEY (id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E6612469DE2');
        $this->addSql('ALTER TABLE article_services DROP FOREIGN KEY FK_26DA15027294869C');
        $this->addSql('ALTER TABLE article_services DROP FOREIGN KEY FK_26DA1502AEF5A6C1');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE city DROP FOREIGN KEY FK_2D5B0234F92F3E70');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E098BAC62AF');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09BF396750');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986BF700BD');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939897B86DAE');
        $this->addSql('ALTER TABLE order_article DROP FOREIGN KEY FK_F440A72D8D9F6D38');
        $this->addSql('ALTER TABLE order_article DROP FOREIGN KEY FK_F440A72D7294869C');
        $this->addSql('ALTER TABLE staff DROP FOREIGN KEY FK_426EF392BF396750');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE article_services');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_article');
        $this->addSql('DROP TABLE services');
        $this->addSql('DROP TABLE staff');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE `user`');
    }
}
