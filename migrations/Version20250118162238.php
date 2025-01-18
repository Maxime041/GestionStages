<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250118162238 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9014574A77153098 ON matiere (code)');
        $this->addSql('ALTER TABLE stagiaire CHANGE adresse adresse VARCHAR(50) DEFAULT NULL, CHANGE code code VARCHAR(255) DEFAULT NULL, CHANGE ville ville VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD stagiaire_id INT DEFAULT NULL, ADD professeur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BBA93DD6 FOREIGN KEY (stagiaire_id) REFERENCES stagiaire (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649BBA93DD6 ON user (stagiaire_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649BAB22EE9 ON user (professeur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_9014574A77153098 ON matiere');
        $this->addSql('ALTER TABLE stagiaire CHANGE adresse adresse VARCHAR(50) NOT NULL, CHANGE code code VARCHAR(255) NOT NULL, CHANGE ville ville VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BBA93DD6');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BAB22EE9');
        $this->addSql('DROP INDEX UNIQ_8D93D649BBA93DD6 ON user');
        $this->addSql('DROP INDEX UNIQ_8D93D649BAB22EE9 ON user');
        $this->addSql('ALTER TABLE user DROP stagiaire_id, DROP professeur_id');
    }
}
