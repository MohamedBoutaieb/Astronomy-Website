<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518112225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE merch_order (id INT AUTO_INCREMENT NOT NULL, toorder_id INT NOT NULL, to_merch_id INT NOT NULL, quantity INT NOT NULL, INDEX IDX_31B235C9774FB1B0 (toorder_id), INDEX IDX_31B235C9C5F1F576 (to_merch_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE merch_order ADD CONSTRAINT FK_31B235C9774FB1B0 FOREIGN KEY (toorder_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE merch_order ADD CONSTRAINT FK_31B235C9C5F1F576 FOREIGN KEY (to_merch_id) REFERENCES merchandise (id)');
        $this->addSql('ALTER TABLE merchandise DROP FOREIGN KEY FK_D043D1A481FED13F');
        $this->addSql('DROP INDEX IDX_D043D1A481FED13F ON merchandise');
        $this->addSql('ALTER TABLE merchandise DROP orderedby_id');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988A86BD8');
        $this->addSql('DROP INDEX IDX_F52993988A86BD8 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP merch_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE merch_order');
        $this->addSql('ALTER TABLE merchandise ADD orderedby_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE merchandise ADD CONSTRAINT FK_D043D1A481FED13F FOREIGN KEY (orderedby_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_D043D1A481FED13F ON merchandise (orderedby_id)');
        $this->addSql('ALTER TABLE `order` ADD merch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988A86BD8 FOREIGN KEY (merch_id) REFERENCES merchandise (id)');
        $this->addSql('CREATE INDEX IDX_F52993988A86BD8 ON `order` (merch_id)');
    }
}
