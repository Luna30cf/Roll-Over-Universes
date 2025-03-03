<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250303203703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change phone_number type from INTEGER to VARCHAR(20)';
    }

    public function up(Schema $schema): void
    {
        // Créer une colonne temporaire
        $this->addSql('ALTER TABLE user ADD COLUMN phone_number_new VARCHAR(20) DEFAULT NULL');
        
        // Copier les données existantes
        $this->addSql('UPDATE user SET phone_number_new = CAST(phone_number AS VARCHAR(20))');
        
        // Supprimer l'ancienne colonne
        $this->addSql('ALTER TABLE user DROP COLUMN phone_number');
        
        // Renommer la nouvelle colonne
        $this->addSql('ALTER TABLE user RENAME COLUMN phone_number_new TO phone_number');
    }

    public function down(Schema $schema): void
    {
        // Créer une colonne temporaire
        $this->addSql('ALTER TABLE user ADD COLUMN phone_number_old INTEGER DEFAULT NULL');
        
        // Copier les données existantes
        $this->addSql('UPDATE user SET phone_number_old = CAST(phone_number AS INTEGER)');
        
        // Supprimer la nouvelle colonne
        $this->addSql('ALTER TABLE user DROP COLUMN phone_number');
        
        // Renommer l'ancienne colonne
        $this->addSql('ALTER TABLE user RENAME COLUMN phone_number_old TO phone_number');
    }
}
