<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230329125857 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE OffreUser (IdentifiantOffre INT NOT NULL, IdentifiantUser INT NOT NULL, PRIMARY KEY (IdentifiantOffre, IdentifiantUser))');
        $this->addSql('CREATE INDEX IDX_21DFA07F4657399 ON OffreUser (IdentifiantOffre)');
        $this->addSql('CREATE INDEX IDX_21DFA07B0C83DF6 ON OffreUser (IdentifiantUser)');
        $this->addSql('ALTER TABLE OffreUser ADD CONSTRAINT FK_21DFA07F4657399 FOREIGN KEY (IdentifiantOffre) REFERENCES Offre (Identifiant)');
        $this->addSql('ALTER TABLE OffreUser ADD CONSTRAINT FK_21DFA07B0C83DF6 FOREIGN KEY (IdentifiantUser) REFERENCES [user] (id)');
        $this->addSql('ALTER TABLE offre_user DROP CONSTRAINT FK_CFC1683D4CC8505A');
        $this->addSql('ALTER TABLE offre_user DROP CONSTRAINT FK_CFC1683DA76ED395');
        $this->addSql('DROP TABLE offre_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA db_accessadmin');
        $this->addSql('CREATE SCHEMA db_backupoperator');
        $this->addSql('CREATE SCHEMA db_datareader');
        $this->addSql('CREATE SCHEMA db_datawriter');
        $this->addSql('CREATE SCHEMA db_ddladmin');
        $this->addSql('CREATE SCHEMA db_denydatareader');
        $this->addSql('CREATE SCHEMA db_denydatawriter');
        $this->addSql('CREATE SCHEMA db_owner');
        $this->addSql('CREATE SCHEMA db_securityadmin');
        $this->addSql('CREATE SCHEMA dbo');
        $this->addSql('CREATE TABLE offre_user (id INT NOT NULL, Identifiant INT NOT NULL, PRIMARY KEY (Identifiant, id))');
        $this->addSql('CREATE NONCLUSTERED INDEX IDX_CFC1683D4CC8505A ON offre_user (Identifiant)');
        $this->addSql('CREATE NONCLUSTERED INDEX IDX_CFC1683DA76ED395 ON offre_user (id)');
        $this->addSql('ALTER TABLE offre_user ADD CONSTRAINT FK_CFC1683D4CC8505A FOREIGN KEY (Identifiant) REFERENCES Offre (Identifiant) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offre_user ADD CONSTRAINT FK_CFC1683DA76ED395 FOREIGN KEY (id) REFERENCES [user] (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE OffreUser DROP CONSTRAINT FK_21DFA07F4657399');
        $this->addSql('ALTER TABLE OffreUser DROP CONSTRAINT FK_21DFA07B0C83DF6');
        $this->addSql('DROP TABLE OffreUser');
    }
}
