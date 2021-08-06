<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210806113757 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `options` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_D035FA872B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_option (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, option_id INT NOT NULL, value DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_38FA41144584665A (product_id), INDEX IDX_38FA4114A7C41D6F (option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `products` (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, qty INT NOT NULL, price NUMERIC(10, 3) NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_B3BA5A5A2B36786B (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', first_name VARCHAR(255) DEFAULT NULL, second_name VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA41144584665A FOREIGN KEY (product_id) REFERENCES `products` (id)');
        $this->addSql('ALTER TABLE product_option ADD CONSTRAINT FK_38FA4114A7C41D6F FOREIGN KEY (option_id) REFERENCES `options` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA4114A7C41D6F');
        $this->addSql('ALTER TABLE product_option DROP FOREIGN KEY FK_38FA41144584665A');
        $this->addSql('DROP TABLE `options`');
        $this->addSql('DROP TABLE product_option');
        $this->addSql('DROP TABLE `products`');
        $this->addSql('DROP TABLE user');
    }
}
