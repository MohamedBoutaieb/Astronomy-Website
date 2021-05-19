<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210519152422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_merchandise');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_merchandise (order_id INT NOT NULL, merchandise_id INT NOT NULL, INDEX IDX_CBF1AE22CFC6D428 (merchandise_id), INDEX IDX_CBF1AE228D9F6D38 (order_id), PRIMARY KEY(order_id, merchandise_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_merchandise ADD CONSTRAINT FK_CBF1AE228D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_merchandise ADD CONSTRAINT FK_CBF1AE22CFC6D428 FOREIGN KEY (merchandise_id) REFERENCES merchandise (id) ON DELETE CASCADE');
    }
}
