<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210513175027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE merchandise (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, in_stock INT NOT NULL, label VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, date DATETIME DEFAULT NULL, cost DOUBLE PRECISION DEFAULT NULL, total_quantity INT DEFAULT NULL, INDEX IDX_F5299398F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_merchandise (order_id INT NOT NULL, merchandise_id INT NOT NULL, INDEX IDX_CBF1AE228D9F6D38 (order_id), INDEX IDX_CBF1AE22CFC6D428 (merchandise_id), PRIMARY KEY(order_id, merchandise_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F85E0677 FOREIGN KEY (username) REFERENCES user (username)');
        $this->addSql('ALTER TABLE order_merchandise ADD CONSTRAINT FK_CBF1AE228D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_merchandise ADD CONSTRAINT FK_CBF1AE22CFC6D428 FOREIGN KEY (merchandise_id) REFERENCES merchandise (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE magazine');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_merchandise DROP FOREIGN KEY FK_CBF1AE22CFC6D428');
        $this->addSql('ALTER TABLE order_merchandise DROP FOREIGN KEY FK_CBF1AE228D9F6D38');
        $this->addSql('CREATE TABLE magazine (id INT AUTO_INCREMENT NOT NULL, price DOUBLE PRECISION NOT NULL, instock INT NOT NULL, label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE merchandise');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_merchandise');
    }
}
