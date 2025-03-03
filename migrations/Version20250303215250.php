<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303215250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "order" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, total_price NUMERIC(10, 2) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart_article AS SELECT cart_id, article_id FROM cart_article');
        $this->addSql('DROP TABLE cart_article');
        $this->addSql('CREATE TABLE cart_article (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, cart_id INTEGER NOT NULL, article_id INTEGER NOT NULL, CONSTRAINT FK_F9E0C6611AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F9E0C6617294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cart_article (cart_id, article_id) SELECT cart_id, article_id FROM __temp__cart_article');
        $this->addSql('DROP TABLE __temp__cart_article');
        $this->addSql('CREATE INDEX IDX_F9E0C6617294869C ON cart_article (article_id)');
        $this->addSql('CREATE INDEX IDX_F9E0C6611AD5CDBF ON cart_article (cart_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, balance, picture_profile, roles, password, phone_number, delivery_address FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, balance NUMERIC(10, 2) DEFAULT NULL, picture_profile VARCHAR(255) DEFAULT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, phone_number INTEGER DEFAULT NULL, delivery_address VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, username, email, balance, picture_profile, roles, password, phone_number, delivery_address) SELECT id, username, email, balance, picture_profile, roles, password, phone_number, delivery_address FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE "order"');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart_article AS SELECT cart_id, article_id FROM cart_article');
        $this->addSql('DROP TABLE cart_article');
        $this->addSql('CREATE TABLE cart_article (cart_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(cart_id, article_id), CONSTRAINT FK_F9E0C6611AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F9E0C6617294869C FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cart_article (cart_id, article_id) SELECT cart_id, article_id FROM __temp__cart_article');
        $this->addSql('DROP TABLE __temp__cart_article');
        $this->addSql('CREATE INDEX IDX_F9E0C6611AD5CDBF ON cart_article (cart_id)');
        $this->addSql('CREATE INDEX IDX_F9E0C6617294869C ON cart_article (article_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, username, email, password, balance, picture_profile, roles, phone_number, delivery_address FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, balance NUMERIC(10, 2) NOT NULL, picture_profile VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , phone_number VARCHAR(255) DEFAULT NULL, delivery_address VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO user (id, username, email, password, balance, picture_profile, roles, phone_number, delivery_address) SELECT id, username, email, password, balance, picture_profile, roles, phone_number, delivery_address FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON user (email)');
    }
}
