<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220316110105 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bearings (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INT NOT NULL, is_mandatory TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE budgets (id INT AUTO_INCREMENT NOT NULL, initial_value INT NOT NULL, consumed_value INT NOT NULL, still_to_do INT NOT NULL, landing INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE highlights (id INT AUTO_INCREMENT NOT NULL, bearing_id INT DEFAULT NULL, projects_id INT DEFAULT NULL, created_at DATE NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, INDEX IDX_3A73A36671D25DD1 (bearing_id), INDEX IDX_3A73A3661EDE0F55 (projects_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE portfolios (id INT AUTO_INCREMENT NOT NULL, manager_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_B81B226F783E3463 (manager_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, team_project_id INT DEFAULT NULL, team_customers_id INT DEFAULT NULL, status_id INT DEFAULT NULL, portfolio_id INT DEFAULT NULL, budget_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, code INT NOT NULL, started_at DATE NOT NULL, ended_at DATE DEFAULT NULL, is_archived TINYINT(1) NOT NULL, INDEX IDX_5C93B3A428B46D59 (team_project_id), INDEX IDX_5C93B3A4CBD08682 (team_customers_id), INDEX IDX_5C93B3A46BF700BD (status_id), INDEX IDX_5C93B3A4B96B5643 (portfolio_id), UNIQUE INDEX UNIQ_5C93B3A436ABA6B8 (budget_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE risks (id INT AUTO_INCREMENT NOT NULL, severity_id INT DEFAULT NULL, projects_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, identified_at DATE NOT NULL, resolved_at DATE DEFAULT NULL, probability VARCHAR(255) NOT NULL, INDEX IDX_1AACB8D8F7527401 (severity_id), INDEX IDX_1AACB8D81EDE0F55 (projects_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE severities (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value INT NOT NULL, slug VARCHAR(255) NOT NULL, color VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teams (id INT AUTO_INCREMENT NOT NULL, manager_id INT DEFAULT NULL, parent_team_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_96C22258783E3463 (manager_id), INDEX IDX_96C222585B24ACE8 (parent_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, team_id INT DEFAULT NULL, last_name VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, role VARCHAR(255) NOT NULL, INDEX IDX_1483A5E9296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE highlights ADD CONSTRAINT FK_3A73A36671D25DD1 FOREIGN KEY (bearing_id) REFERENCES bearings (id)');
        $this->addSql('ALTER TABLE highlights ADD CONSTRAINT FK_3A73A3661EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE portfolios ADD CONSTRAINT FK_B81B226F783E3463 FOREIGN KEY (manager_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A428B46D59 FOREIGN KEY (team_project_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4CBD08682 FOREIGN KEY (team_customers_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A46BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4B96B5643 FOREIGN KEY (portfolio_id) REFERENCES portfolios (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A436ABA6B8 FOREIGN KEY (budget_id) REFERENCES budgets (id)');
        $this->addSql('ALTER TABLE risks ADD CONSTRAINT FK_1AACB8D8F7527401 FOREIGN KEY (severity_id) REFERENCES severities (id)');
        $this->addSql('ALTER TABLE risks ADD CONSTRAINT FK_1AACB8D81EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE teams ADD CONSTRAINT FK_96C22258783E3463 FOREIGN KEY (manager_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE teams ADD CONSTRAINT FK_96C222585B24ACE8 FOREIGN KEY (parent_team_id) REFERENCES teams (id)');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9296CD8AE FOREIGN KEY (team_id) REFERENCES teams (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE highlights DROP FOREIGN KEY FK_3A73A36671D25DD1');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A436ABA6B8');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4B96B5643');
        $this->addSql('ALTER TABLE highlights DROP FOREIGN KEY FK_3A73A3661EDE0F55');
        $this->addSql('ALTER TABLE risks DROP FOREIGN KEY FK_1AACB8D81EDE0F55');
        $this->addSql('ALTER TABLE risks DROP FOREIGN KEY FK_1AACB8D8F7527401');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A46BF700BD');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A428B46D59');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4CBD08682');
        $this->addSql('ALTER TABLE teams DROP FOREIGN KEY FK_96C222585B24ACE8');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9296CD8AE');
        $this->addSql('ALTER TABLE portfolios DROP FOREIGN KEY FK_B81B226F783E3463');
        $this->addSql('ALTER TABLE teams DROP FOREIGN KEY FK_96C22258783E3463');
        $this->addSql('DROP TABLE bearings');
        $this->addSql('DROP TABLE budgets');
        $this->addSql('DROP TABLE highlights');
        $this->addSql('DROP TABLE portfolios');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE risks');
        $this->addSql('DROP TABLE severities');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE teams');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
