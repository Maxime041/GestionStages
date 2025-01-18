<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109154356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_17A5529912B2DC9C ON professeur (matricule)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C27C936977153098 ON stage (code)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_17A5529912B2DC9C ON professeur');
        $this->addSql('DROP INDEX UNIQ_C27C936977153098 ON stage');
    }
}
