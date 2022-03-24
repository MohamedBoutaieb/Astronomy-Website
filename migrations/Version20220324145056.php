<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324145056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO address (id, address, city, state, zip, country) VALUES
(1, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL),
(4, '21 Avenue Ertiah', 'Tunis', 'Tunis', '2062', 'Tunisia'),
(5, NULL, NULL, NULL, NULL, NULL);

");
      ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE contact ALTER is_send TYPE SMALLINT');
        $this->addSql('ALTER TABLE contact ALTER is_send DROP DEFAULT');
        $this->addSql('ALTER TABLE poster ALTER availability TYPE TEXT');
        $this->addSql('ALTER TABLE poster ALTER availability DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN poster.availability IS NULL');
        $this->addSql('ALTER TABLE user1 ALTER roles TYPE TEXT');
        $this->addSql('ALTER TABLE user1 ALTER roles DROP DEFAULT');
        $this->addSql('ALTER INDEX uniq_8c518555f5b7af75 RENAME TO "UNIQ_8D93D649F5B7AF75"');
        $this->addSql('ALTER TABLE commentary ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentary ALTER user1 TYPE VARCHAR(50)');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT "FK_5F9E962A727ACA70" FOREIGN KEY (parent_id) REFERENCES commentary (id) ON UPDATE RESTRICT ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentary ADD CONSTRAINT "FK_5F9E962A8D93D649" FOREIGN KEY (user1) REFERENCES user1 (username) ON UPDATE RESTRICT ON DELETE RESTRICT NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX "IDX_5F9E962A727ACA70" ON commentary (parent_id)');
        $this->addSql('CREATE INDEX "IDX_5F9E962A8D93D649" ON commentary (user1)');
        $this->addSql('ALTER INDEX idx_1cac12ca7294869c RENAME TO "IDX_5F9E962A7294869C"');
        $this->addSql('ALTER INDEX idx_7dfddd52f5b7af75 RENAME TO "IDX_F5299398F5B7AF75"');
        $this->addSql('ALTER INDEX idx_7dfddd52f85e0677 RENAME TO "IDX_F5299398F85E0677"');
    }
}
