<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305062659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sector DROP CONSTRAINT FK_4BA3D9E8727ACA70');
        $this->addSql('ALTER TABLE sector ADD path VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE sector ALTER lft DROP DEFAULT');
        $this->addSql('ALTER TABLE sector ALTER rgt DROP DEFAULT');
        $this->addSql('ALTER TABLE sector ADD CONSTRAINT FK_4BA3D9E8727ACA70 FOREIGN KEY (parent_id) REFERENCES sector (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sector DROP CONSTRAINT fk_4ba3d9e8727aca70');
        $this->addSql('ALTER TABLE sector DROP path');
        $this->addSql('ALTER TABLE sector ALTER lft SET DEFAULT 1');
        $this->addSql('ALTER TABLE sector ALTER rgt SET DEFAULT 2');
        $this->addSql('ALTER TABLE sector ADD CONSTRAINT fk_4ba3d9e8727aca70 FOREIGN KEY (parent_id) REFERENCES sector (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
