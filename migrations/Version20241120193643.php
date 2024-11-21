<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241120193643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE defect (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE media_object (id SERIAL NOT NULL, defect_id INT DEFAULT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_14D431326C1DAB9B ON media_object (defect_id)');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME ON "user" (email)');
        $this->addSql('ALTER TABLE media_object ADD CONSTRAINT FK_14D431326C1DAB9B FOREIGN KEY (defect_id) REFERENCES defect (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE media_object DROP CONSTRAINT FK_14D431326C1DAB9B');
        $this->addSql('DROP TABLE defect');
        $this->addSql('DROP TABLE media_object');
        $this->addSql('DROP TABLE "user"');
    }
}
