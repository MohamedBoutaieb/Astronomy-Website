<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210517221625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F817BE036FC');
        $this->addSql('DROP INDEX IDX_D4E6F817BE036FC ON address');
        $this->addSql('ALTER TABLE address DROP shipment_id');
        $this->addSql('ALTER TABLE `order` ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_F5299398F5B7AF75 ON `order` (address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD shipment_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F817BE036FC FOREIGN KEY (shipment_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F817BE036FC ON address (shipment_id)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F5B7AF75');
        $this->addSql('DROP INDEX IDX_F5299398F5B7AF75 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP address_id');
    }
}
