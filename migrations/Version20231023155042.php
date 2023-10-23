<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023155042 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE film (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, views INT NOT NULL, INDEX IDX_8244BE2212469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE film ADD CONSTRAINT FK_8244BE2212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE author CHANGE username username VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE book CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE film DROP FOREIGN KEY FK_8244BE2212469DE2');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE film');
        $this->addSql('ALTER TABLE author CHANGE username username VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE book CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
