<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200622220528 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE character (id UUID NOT NULL, eve_character_id INT NOT NULL, eve_character_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE character_token (id UUID NOT NULL, character_id UUID NOT NULL, access_token VARCHAR(255) NOT NULL, refresh_token VARCHAR(255) NOT NULL, owner_hash VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A1F446591136BE75 ON character_token (character_id)');
        $this->addSql('ALTER TABLE character_token ADD CONSTRAINT FK_A1F446591136BE75 FOREIGN KEY (character_id) REFERENCES character (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE character_token DROP CONSTRAINT FK_A1F446591136BE75');
        $this->addSql('DROP TABLE character');
        $this->addSql('DROP TABLE character_token');
    }
}
