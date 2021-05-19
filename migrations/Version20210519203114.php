<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210519203114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE magazine (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE merchandise ADD available VARCHAR(255) NOT NULL, ADD availability LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', ADD types LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', CHANGE type type VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE poster ADD available VARCHAR(255) NOT NULL, ADD availability LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE user ADD bio VARCHAR(255) DEFAULT NULL, ADD photo VARCHAR(255) DEFAULT NULL, ADD birthday DATE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE magazine');
        $this->addSql('ALTER TABLE merchandise DROP available, DROP availability, DROP types, CHANGE type type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE poster DROP available, DROP availability');
        $this->addSql('ALTER TABLE user DROP bio, DROP photo, DROP birthday');
    }
}
