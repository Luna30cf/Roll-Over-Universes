<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250220095016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__invoice AS SELECT id, transaction_date, amount, billing_city, billing_pc FROM invoice');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('CREATE TABLE invoice (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cart_id INTEGER NOT NULL, user_id INTEGER NOT NULL, transaction_date DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, billing_city VARCHAR(255) NOT NULL, billing_pc INTEGER NOT NULL, CONSTRAINT FK_906517441AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_90651744A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO invoice (id, transaction_date, amount, billing_city, billing_pc) SELECT id, transaction_date, amount, billing_city, billing_pc FROM __temp__invoice');
        $this->addSql('DROP TABLE __temp__invoice');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_906517441AD5CDBF ON invoice (cart_id)');
        $this->addSql('CREATE INDEX IDX_90651744A76ED395 ON invoice (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__invoice AS SELECT id, transaction_date, amount, billing_city, billing_pc FROM invoice');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('CREATE TABLE invoice (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, transaction_date DATETIME NOT NULL, amount NUMERIC(10, 2) NOT NULL, billing_city VARCHAR(255) NOT NULL, billing_pc INTEGER NOT NULL)');
        $this->addSql('INSERT INTO invoice (id, transaction_date, amount, billing_city, billing_pc) SELECT id, transaction_date, amount, billing_city, billing_pc FROM __temp__invoice');
        $this->addSql('DROP TABLE __temp__invoice');
    }
}
