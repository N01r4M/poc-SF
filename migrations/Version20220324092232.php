<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324092232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects ADD phase_id INT NOT NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A499091188 FOREIGN KEY (phase_id) REFERENCES phases (id)');
        $this->addSql('CREATE INDEX IDX_5C93B3A499091188 ON projects (phase_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A499091188');
        $this->addSql('DROP INDEX IDX_5C93B3A499091188 ON projects');
        $this->addSql('ALTER TABLE projects DROP phase_id');
    }
}
