<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210517213747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_merchandise (order_id INT NOT NULL, merchandise_id INT NOT NULL, INDEX IDX_CBF1AE228D9F6D38 (order_id), INDEX IDX_CBF1AE22CFC6D428 (merchandise_id), PRIMARY KEY(order_id, merchandise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_merchandise ADD CONSTRAINT FK_CBF1AE228D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_merchandise ADD CONSTRAINT FK_CBF1AE22CFC6D428 FOREIGN KEY (merchandise_id) REFERENCES merchandise (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE address ADD country VARCHAR(30) DEFAULT NULL');
        $this->addSql('ALTER TABLE article CHANGE content content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE `order` CHANGE quantity total_quantity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD roles VARCHAR(55) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_merchandise');
        $this->addSql('ALTER TABLE address DROP country');
        $this->addSql('ALTER TABLE article CHANGE content content VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE `order` CHANGE total_quantity quantity INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP roles');
    }
}
