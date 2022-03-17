<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316142903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE teams DROP FOREIGN KEY FK_96C22258783E3463');
        $this->addSql('DROP INDEX UNIQ_96C22258783E3463 ON teams');
        $this->addSql('ALTER TABLE teams DROP manager_id');
        $this->addSql('ALTER TABLE users ADD is_team_manager TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE teams ADD manager_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE teams ADD CONSTRAINT FK_96C22258783E3463 FOREIGN KEY (manager_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_96C22258783E3463 ON teams (manager_id)');
        $this->addSql('ALTER TABLE users DROP is_team_manager');
    }
}
