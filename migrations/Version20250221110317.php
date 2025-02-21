<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250221110317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cart_article');
        $this->addSql('DROP TABLE cart_user');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart AS SELECT id FROM cart');
        $this->addSql('DROP TABLE cart');
        $this->addSql('CREATE TABLE cart (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, article_id INTEGER NOT NULL, quantity INTEGER DEFAULT 1 NOT NULL, CONSTRAINT FK_BA388B7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_BA388B77294869C FOREIGN KEY (article_id) REFERENCES article (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cart (id) SELECT id FROM __temp__cart');
        $this->addSql('DROP TABLE __temp__cart');
        $this->addSql('CREATE INDEX IDX_BA388B7A76ED395 ON cart (user_id)');
        $this->addSql('CREATE INDEX IDX_BA388B77294869C ON cart (article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart_article (cart_id INTEGER NOT NULL, article_id INTEGER NOT NULL, PRIMARY KEY(cart_id, article_id), CONSTRAINT FK_F9E0C6611AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F9E0C6617294869C FOREIGN KEY (article_id) REFERENCES article (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F9E0C6617294869C ON cart_article (article_id)');
        $this->addSql('CREATE INDEX IDX_F9E0C6611AD5CDBF ON cart_article (cart_id)');
        $this->addSql('CREATE TABLE cart_user (cart_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(cart_id, user_id), CONSTRAINT FK_6276D6701AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6276D670A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6276D670A76ED395 ON cart_user (user_id)');
        $this->addSql('CREATE INDEX IDX_6276D6701AD5CDBF ON cart_user (cart_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart AS SELECT id FROM cart');
        $this->addSql('DROP TABLE cart');
        $this->addSql('CREATE TABLE cart (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('INSERT INTO cart (id) SELECT id FROM __temp__cart');
        $this->addSql('DROP TABLE __temp__cart');
    }
}
