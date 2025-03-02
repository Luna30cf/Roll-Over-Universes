<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250302165935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart_user AS SELECT cart_id, user_id FROM cart_user');
        $this->addSql('DROP TABLE cart_user');
        $this->addSql('CREATE TABLE cart_user (cart_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(cart_id, user_id), CONSTRAINT FK_6276D6701AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6276D670A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cart_user (cart_id, user_id) SELECT cart_id, user_id FROM __temp__cart_user');
        $this->addSql('DROP TABLE __temp__cart_user');
        $this->addSql('CREATE INDEX IDX_6276D670A76ED395 ON cart_user (user_id)');
        $this->addSql('CREATE INDEX IDX_6276D6701AD5CDBF ON cart_user (cart_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__cart_user AS SELECT cart_id, user_id FROM cart_user');
        $this->addSql('DROP TABLE cart_user');
        $this->addSql('CREATE TABLE cart_user (cart_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(cart_id, user_id), CONSTRAINT FK_6276D6701AD5CDBF FOREIGN KEY (cart_id) REFERENCES cart (id) ON UPDATE NO ACTION ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6276D670A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cart_user (cart_id, user_id) SELECT cart_id, user_id FROM __temp__cart_user');
        $this->addSql('DROP TABLE __temp__cart_user');
        $this->addSql('CREATE INDEX IDX_6276D6701AD5CDBF ON cart_user (cart_id)');
        $this->addSql('CREATE INDEX IDX_6276D670A76ED395 ON cart_user (user_id)');
    }
}
