<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305102131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, name VARCHAR(255) NOT NULL, agree_to_terms BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_sector (user_id INT NOT NULL, sector_id INT NOT NULL, PRIMARY KEY(user_id, sector_id))');
        $this->addSql('CREATE INDEX IDX_2EF1C2D5A76ED395 ON user_sector (user_id)');
        $this->addSql('CREATE INDEX IDX_2EF1C2D5DE95C867 ON user_sector (sector_id)');
        $this->addSql('ALTER TABLE user_sector ADD CONSTRAINT FK_2EF1C2D5A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_sector ADD CONSTRAINT FK_2EF1C2D5DE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE user_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_sector DROP CONSTRAINT FK_2EF1C2D5A76ED395');
        $this->addSql('ALTER TABLE user_sector DROP CONSTRAINT FK_2EF1C2D5DE95C867');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE user_sector');
    }
}
