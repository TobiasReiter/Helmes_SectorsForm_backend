<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304225655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sector ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sector ADD CONSTRAINT FK_4BA3D9E8727ACA70 FOREIGN KEY (parent_id) REFERENCES sector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_4BA3D9E8727ACA70 ON sector (parent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sector DROP CONSTRAINT FK_4BA3D9E8727ACA70');
        $this->addSql('DROP INDEX IDX_4BA3D9E8727ACA70');
        $this->addSql('ALTER TABLE sector DROP parent_id');
    }
}
