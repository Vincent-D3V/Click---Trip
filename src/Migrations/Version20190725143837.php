<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190725143837 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, agency_id INT NOT NULL, validate TINYINT(1) DEFAULT NULL, destination VARCHAR(255) NOT NULL, reference VARCHAR(255) NOT NULL, name_stage VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, duration INT NOT NULL, deleted TINYINT(1) DEFAULT NULL, best_month INT DEFAULT NULL, details VARCHAR(10000) NOT NULL, INDEX IDX_C27C9369CDEADB2A (agency_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage_history (stage_id INT NOT NULL, history_id INT NOT NULL, INDEX IDX_AD4330062298D193 (stage_id), INDEX IDX_AD4330061E058452 (history_id), PRIMARY KEY(stage_id, history_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agency (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, company VARCHAR(255) NOT NULL, name_agent VARCHAR(255) NOT NULL, surname_agent VARCHAR(255) NOT NULL, year_creation INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, presentation LONGTEXT DEFAULT NULL, flagship LONGTEXT DEFAULT NULL, deleted TINYINT(1) DEFAULT NULL, mobile VARCHAR(255) NOT NULL, validate TINYINT(1) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_70C0C6E6E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE size (id INT AUTO_INCREMENT NOT NULL, people VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE size_stage (size_id INT NOT NULL, stage_id INT NOT NULL, INDEX IDX_13AC515E498DA827 (size_id), INDEX IDX_13AC515E2298D193 (stage_id), PRIMARY KEY(size_id, stage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, histories_id INT NOT NULL, agency_id INT NOT NULL, client_id INT NOT NULL, send_at DATETIME NOT NULL, content VARCHAR(10000) NOT NULL, admin TINYINT(1) DEFAULT NULL, sender VARCHAR(15) NOT NULL, receiver VARCHAR(15) NOT NULL, INDEX IDX_B6BD307F22BC1E8C (histories_id), INDEX IDX_B6BD307FCDEADB2A (agency_id), INDEX IDX_B6BD307F19EB6921 (client_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE style (id INT AUTO_INCREMENT NOT NULL, style VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE style_stage (style_id INT NOT NULL, stage_id INT NOT NULL, INDEX IDX_8A9DD92BACD6074 (style_id), INDEX IDX_8A9DD922298D193 (stage_id), PRIMARY KEY(style_id, stage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, agency_id INT NOT NULL, state_id INT NOT NULL, date_begin DATE DEFAULT NULL, date_end DATE DEFAULT NULL, comments VARCHAR(255) DEFAULT NULL, INDEX IDX_27BA704B19EB6921 (client_id), INDEX IDX_27BA704BCDEADB2A (agency_id), INDEX IDX_27BA704B5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, mobile INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, address VARCHAR(255) DEFAULT NULL, deleted TINYINT(1) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_C7440455E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state_history (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE price (id INT AUTO_INCREMENT NOT NULL, stages_id INT NOT NULL, date_begin DATE DEFAULT NULL, date_end DATE DEFAULT NULL, price INT NOT NULL, persons INT DEFAULT NULL, INDEX IDX_CAC822D98E55E70A (stages_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, theme VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme_stage (theme_id INT NOT NULL, stage_id INT NOT NULL, INDEX IDX_9A5E188C59027487 (theme_id), INDEX IDX_9A5E188C2298D193 (stage_id), PRIMARY KEY(theme_id, stage_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE documents (id INT AUTO_INCREMENT NOT NULL, stage_id INT NOT NULL, image VARCHAR(255) NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A2B072882298D193 (stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369CDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE stage_history ADD CONSTRAINT FK_AD4330062298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stage_history ADD CONSTRAINT FK_AD4330061E058452 FOREIGN KEY (history_id) REFERENCES history (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE size_stage ADD CONSTRAINT FK_13AC515E498DA827 FOREIGN KEY (size_id) REFERENCES size (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE size_stage ADD CONSTRAINT FK_13AC515E2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F22BC1E8C FOREIGN KEY (histories_id) REFERENCES history (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE style_stage ADD CONSTRAINT FK_8A9DD92BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE style_stage ADD CONSTRAINT FK_8A9DD922298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704BCDEADB2A FOREIGN KEY (agency_id) REFERENCES agency (id)');
        $this->addSql('ALTER TABLE history ADD CONSTRAINT FK_27BA704B5D83CC1 FOREIGN KEY (state_id) REFERENCES state_history (id)');
        $this->addSql('ALTER TABLE price ADD CONSTRAINT FK_CAC822D98E55E70A FOREIGN KEY (stages_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE theme_stage ADD CONSTRAINT FK_9A5E188C59027487 FOREIGN KEY (theme_id) REFERENCES theme (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE theme_stage ADD CONSTRAINT FK_9A5E188C2298D193 FOREIGN KEY (stage_id) REFERENCES stage (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE documents ADD CONSTRAINT FK_A2B072882298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stage_history DROP FOREIGN KEY FK_AD4330062298D193');
        $this->addSql('ALTER TABLE size_stage DROP FOREIGN KEY FK_13AC515E2298D193');
        $this->addSql('ALTER TABLE style_stage DROP FOREIGN KEY FK_8A9DD922298D193');
        $this->addSql('ALTER TABLE price DROP FOREIGN KEY FK_CAC822D98E55E70A');
        $this->addSql('ALTER TABLE theme_stage DROP FOREIGN KEY FK_9A5E188C2298D193');
        $this->addSql('ALTER TABLE documents DROP FOREIGN KEY FK_A2B072882298D193');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369CDEADB2A');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCDEADB2A');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704BCDEADB2A');
        $this->addSql('ALTER TABLE size_stage DROP FOREIGN KEY FK_13AC515E498DA827');
        $this->addSql('ALTER TABLE style_stage DROP FOREIGN KEY FK_8A9DD92BACD6074');
        $this->addSql('ALTER TABLE stage_history DROP FOREIGN KEY FK_AD4330061E058452');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F22BC1E8C');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F19EB6921');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B19EB6921');
        $this->addSql('ALTER TABLE history DROP FOREIGN KEY FK_27BA704B5D83CC1');
        $this->addSql('ALTER TABLE theme_stage DROP FOREIGN KEY FK_9A5E188C59027487');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE stage_history');
        $this->addSql('DROP TABLE agency');
        $this->addSql('DROP TABLE size');
        $this->addSql('DROP TABLE size_stage');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE style');
        $this->addSql('DROP TABLE style_stage');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE state_history');
        $this->addSql('DROP TABLE price');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE theme_stage');
        $this->addSql('DROP TABLE documents');
    }
}
