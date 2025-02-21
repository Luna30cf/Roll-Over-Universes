<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220083435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, picture_profile VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE themes (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE types (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('DROP TABLE stock');
        $this->addSql('ALTER TABLE article ADD COLUMN items_stored INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stock (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE themes');
        $this->addSql('DROP TABLE types');
        $this->addSql('CREATE TEMPORARY TABLE __temp__article AS SELECT id, name, cover, description, price, publication_date FROM article');
        $this->addSql('DROP TABLE article');
        $this->addSql('CREATE TABLE article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, cover VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price NUMERIC(10, 2) NOT NULL, publication_date DATETIME NOT NULL)');
        $this->addSql('INSERT INTO article (id, name, cover, description, price, publication_date) SELECT id, name, cover, description, price, publication_date FROM __temp__article');
        $this->addSql('DROP TABLE __temp__article');
    }
}
