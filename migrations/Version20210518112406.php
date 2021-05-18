<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518112406 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE merch_order DROP FOREIGN KEY FK_31B235C9774FB1B0');
        $this->addSql('DROP INDEX IDX_31B235C9774FB1B0 ON merch_order');
        $this->addSql('ALTER TABLE merch_order CHANGE toorder_id to_order_id INT NOT NULL');
        $this->addSql('ALTER TABLE merch_order ADD CONSTRAINT FK_31B235C940C6F396 FOREIGN KEY (to_order_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_31B235C940C6F396 ON merch_order (to_order_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE merch_order DROP FOREIGN KEY FK_31B235C940C6F396');
        $this->addSql('DROP INDEX IDX_31B235C940C6F396 ON merch_order');
        $this->addSql('ALTER TABLE merch_order CHANGE to_order_id toorder_id INT NOT NULL');
        $this->addSql('ALTER TABLE merch_order ADD CONSTRAINT FK_31B235C9774FB1B0 FOREIGN KEY (toorder_id) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_31B235C9774FB1B0 ON merch_order (toorder_id)');
    }
}
