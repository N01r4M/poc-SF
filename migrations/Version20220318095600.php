<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220318095600 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A436ABA6B8');
        $this->addSql('DROP TABLE budgets');
        $this->addSql('DROP INDEX UNIQ_5C93B3A436ABA6B8 ON projects');
        $this->addSql('ALTER TABLE projects ADD initial_value INT NOT NULL, ADD consumed_value INT NOT NULL, ADD still_to_do INT NOT NULL, ADD landing INT NOT NULL, DROP budget_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE budgets (id INT AUTO_INCREMENT NOT NULL, initial_value INT NOT NULL, consumed_value INT NOT NULL, still_to_do INT NOT NULL, landing INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE projects ADD budget_id INT DEFAULT NULL, DROP initial_value, DROP consumed_value, DROP still_to_do, DROP landing');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A436ABA6B8 FOREIGN KEY (budget_id) REFERENCES budgets (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A436ABA6B8 ON projects (budget_id)');
    }
}
