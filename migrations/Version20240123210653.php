<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240123210653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medecin (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, specialite_id INTEGER NOT NULL, nom VARCHAR(200) NOT NULL, prenom VARCHAR(200) NOT NULL, photos VARCHAR(200) DEFAULT NULL, adresse VARCHAR(200) NOT NULL, CONSTRAINT FK_1BDA53C62195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1BDA53C62195E0F0 ON medecin (specialite_id)');
        $this->addSql('CREATE TABLE patient (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, nom VARCHAR(200) NOT NULL, prenom VARCHAR(200) DEFAULT NULL, photos VARCHAR(200) DEFAULT NULL, adresse VARCHAR(200) NOT NULL)');
        $this->addSql('CREATE TABLE specialite (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, specialite VARCHAR(200) NOT NULL)');
        $this->addSql('CREATE TABLE telephone (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, id_patient_id INTEGER NOT NULL, id_medecin_id INTEGER DEFAULT NULL, telephone VARCHAR(10) NOT NULL, CONSTRAINT FK_450FF010CE0312AE FOREIGN KEY (id_patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_450FF010A1799A53 FOREIGN KEY (id_medecin_id) REFERENCES medecin (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_450FF010CE0312AE ON telephone (id_patient_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_450FF010A1799A53 ON telephone (id_medecin_id)');
        $this->addSql('CREATE TABLE messenger_messages (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, body CLOB NOT NULL, headers CLOB NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , available_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , delivered_at DATETIME DEFAULT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE patient');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE telephone');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
