<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324152008 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("

INSERT INTO user1 (username, address_id, password, email, phone_number, credits, firstname, lastname, reset_token, roles, bio, photo, birthday) VALUES
('aaa', 5, '$2y$13$ulnfIXGZh85AJi8fWGvsOuWxVpDrWHOkxC/hhWr0z3KMcgxwqEvh2', 'a@b.com', NULL, 23, NULL, NULL, NULL, '[]', NULL, '../default_profile_picture.png', NULL),
('admin', 2, '$argon2id$v=19$m=65536,t=4,p=1$Z0dudmZEeXhiN3JqS1Nkdw$G9crctt5kT06hhvUg9UHnWNF64xW7HbPHcTMJtmPYFE', 'admin@gmail.com', NULL, 100, NULL, NULL, NULL, '[ROLE_ADMIN]', NULL, '../default_profile_picture.png', NULL),
('admin1', 3, '$argon2id$v=19$m=65536,t=4,p=1$dzhaYVV6OG9KTGFJZS5QRA$ePLhTdAnntdq1aDGfqjYGudrClgojN4ZcjbJ45ovMhU', 'x@gmail.com', NULL, 100, NULL, NULL, NULL, '[ROLE_ADMIN]', NULL, '../default_profile_picture.png', NULL),
('boutaieb', 4, '$argon2id$v=19$m=65536,t=4,p=1$SjJLZVdnSThLU2tUa2FjYQ$G5M1J3TsZu2qZLE4/QtTq3kiRZ63DIxFsv0l4H31wDs', 'abc@gmail.com', '55366389', 17, 'Mohamed', 'Bou', NULL, '[]', 'lorem ipsum', '138628805-3657499304367754-2132136851098941987-n-60c7c033a379e.jpg', '2000-03-08'),
('sarabriki', 1, '$argon2id$v=19$m=65536,t=4,p=1$eVRBcC5ZdW53Z3doMk1udQ$aE92JLYp4C35i2nHas1Fj4so7d6UZoeRdPSN9GnJTnw', 'sb@sb.sb', NULL, 100, NULL, NULL, NULL, '[]', NULL, '../default_profile_picture.png', NULL);

");

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
