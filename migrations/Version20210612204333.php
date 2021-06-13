<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210612204333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments ADD user VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A8D93D649 FOREIGN KEY (user) REFERENCES user (username)');
        $this->addSql('CREATE INDEX IDX_5F9E962A8D93D649 ON comments (user)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A8D93D649');
        $this->addSql('DROP INDEX IDX_5F9E962A8D93D649 ON comments');
        $this->addSql('ALTER TABLE comments DROP user');
    }
}
