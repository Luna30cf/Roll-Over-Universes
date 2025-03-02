<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250302153116 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_user (cart_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(cart_id, user_id), CONSTRAINT FK_6276D6701AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6276D670A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6276D6701AD5CDBF ON cart_user (cart_id)');
        $this->addSql('CREATE INDEX IDX_6276D670A76ED395 ON cart_user (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart AS SELECT id FROM cart');
        $this->addSql('DROP TABLE cart');
        $this->addSql('CREATE TABLE cart (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO cart (id) SELECT id FROM __temp__cart');
        $this->addSql('DROP TABLE __temp__cart');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, password, balance, picture_profile, phone_number, delivery_address FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, balance NUMERIC(10, 2) NOT NULL, picture_profile VARCHAR(255) NOT NULL, phone_number INTEGER DEFAULT NULL, delivery_address VARCHAR(255) DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO user (id, username, email, password, balance, picture_profile, phone_number, delivery_address) SELECT id, username, email, password, balance, picture_profile, phone_number, delivery_address FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cart_user');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart AS SELECT id FROM cart');
        $this->addSql('DROP TABLE cart');
        $this->addSql('CREATE TABLE cart (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cart (id) SELECT id FROM __temp__cart');
        $this->addSql('DROP TABLE __temp__cart');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BA388B7A76ED395 ON cart (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, balance, picture_profile, password, phone_number, delivery_address FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, balance NUMERIC(10, 2) NOT NULL, picture_profile VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, phone_number INTEGER DEFAULT NULL, delivery_address VARCHAR(255) DEFAULT NULL, role VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO "user" (id, username, email, balance, picture_profile, password, phone_number, delivery_address) SELECT id, username, email, balance, picture_profile, password, phone_number, delivery_address FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
    }
}
