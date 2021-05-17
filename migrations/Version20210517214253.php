<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210517214253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE merchandise ADD orderedby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE merchandise ADD CONSTRAINT FK_D043D1A481FED13F FOREIGN KEY (orderedby_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_D043D1A481FED13F ON merchandise (orderedby_id)');
        $this->addSql('ALTER TABLE `order` ADD merch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988A86BD8 FOREIGN KEY (merch_id) REFERENCES merchandise (id)');
        $this->addSql('CREATE INDEX IDX_F52993988A86BD8 ON `order` (merch_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE merchandise DROP FOREIGN KEY FK_D043D1A481FED13F');
        $this->addSql('DROP INDEX IDX_D043D1A481FED13F ON merchandise');
        $this->addSql('ALTER TABLE merchandise DROP orderedby_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988A86BD8');
        $this->addSql('DROP INDEX IDX_F52993988A86BD8 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP merch_id');
    }
}
