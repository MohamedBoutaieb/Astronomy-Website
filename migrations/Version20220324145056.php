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
        $this->addSql('INSERT INTO address (id, address, city, state, zip, country) VALUES
(1, NULL, NULL, NULL, NULL, NULL),
(2, NULL, NULL, NULL, NULL, NULL),
(3, NULL, NULL, NULL, NULL, NULL),
(4, "21 Avenue Ertiah", "Tunis", "Tunis", "2062", "Tunisia"),
(5, NULL, NULL, NULL, NULL, NULL);

INSERT INTO user1 (username, address_id, password, email, phone_number, credits, firstname, lastname, reset_token, roles, bio, photo, birthday) VALUES
("aaa", 5, "$2y$13$ulnfIXGZh85AJi8fWGvsOuWxVpDrWHOkxC/hhWr0z3KMcgxwqEvh2", "a@b.com", NULL, 23, NULL, NULL, NULL, "[]", NULL, "../default_profile_picture.png", NULL),
("admin", 2, "$argon2id$v=19$m=65536,t=4,p=1$Z0dudmZEeXhiN3JqS1Nkdw$G9crctt5kT06hhvUg9UHnWNF64xW7HbPHcTMJtmPYFE", "admin@gmail.com", NULL, 100, NULL, NULL, NULL, "["ROLE_ADMIN"]", NULL, "../default_profile_picture.png", NULL),
("admin1", 3, "$argon2id$v=19$m=65536,t=4,p=1$dzhaYVV6OG9KTGFJZS5QRA$ePLhTdAnntdq1aDGfqjYGudrClgojN4ZcjbJ45ovMhU", "x@gmail.com", NULL, 100, NULL, NULL, NULL, "["ROLE_ADMIN"]", NULL, "../default_profile_picture.png", NULL),
("boutaieb", 4, "$argon2id$v=19$m=65536,t=4,p=1$SjJLZVdnSThLU2tUa2FjYQ$G5M1J3TsZu2qZLE4/QtTq3kiRZ63DIxFsv0l4H31wDs", "abc@gmail.com", "55366389", 17, "Mohamed", "Bou", NULL, "[]", "lorem ipsum", "138628805-3657499304367754-2132136851098941987-n-60c7c033a379e.jpg", "2000-03-08"),
("sarabriki", 1, "$argon2id$v=19$m=65536,t=4,p=1$eVRBcC5ZdW53Z3doMk1udQ$aE92JLYp4C35i2nHas1Fj4so7d6UZoeRdPSN9GnJTnw", "sb@sb.sb", NULL, 100, NULL, NULL, NULL, "[]", NULL, "../default_profile_picture.png", NULL);


INSERT INTO article (id, username, title, content, active, created_at) VALUES
(1, "sarabriki", "test article", "<p>test</p>", "1", "2021-06-13 20:41:43"),
(4, "boutaieb", "titre test", "<p>sarah briki</p>", "1", "2021-06-14 23:45:49"),
(5, "aaa", "a", "<p>bcd</p>", "", "2022-03-24 12:30:17"),
(6, "aaa", "fd", "<p>f</p>", "", "2022-03-24 12:30:54"),
(7, "aaa", "f", "<p>h</p>", "", "2022-03-24 12:31:18"),
(8, "aaa", "v", "<p>v</p>", "", "2022-03-24 12:40:14");

INSERT INTO commentary (id, article_id, parent_id, user1, content, active, email, pseudo, created_at) VALUES
(1, 1, NULL, "sarabriki", "test comment", 1, "brikisarah21@gmail.com", "sara2", "2021-06-13 20:43:15"),
(2, 1, NULL, "admin", "reply test", 1, "brikisarah21@gmail.com", "sarah", "2021-06-14 00:48:56"),
(3, 1, NULL, "boutaieb", "abcd", 1, "", "", "2021-06-14 23:20:26"),
(4, 4, NULL, "admin1", "merci", 1, "", "", "2021-06-14 23:48:23"),
(5, 4, NULL, "aaa", "dd", 1, "", "", "2022-03-24 12:39:49");

INSERT INTO contact (id, name, email, message, created_at, is_send) VALUES
(1, "med bt", "as@gmail.com", "lorem", "2021-06-14 23:15:22", 0),
(2, "boutaiebbb", "b@gmail.com", "lorem", "2021-06-14 23:31:58", 0),
(3, "sara", "gh@gmail.com", "abcdefg", "2021-06-14 23:35:44", 0),
(4, "mohamed", "abcd@gmail.com", "abcdefghij", "2021-06-14 23:43:40", 0);
INSERT INTO doctrine_migration_versions (version, executed_at, execution_time) VALUES
("DoctrineMigrationsVersion20210515114922", "2021-05-15 13:49:30", 333),
("DoctrineMigrationsVersion20210519143848", "2021-05-19 16:39:09", 226),
("DoctrineMigrationsVersion20210519153738", "2021-05-19 17:37:52", 111),
("DoctrineMigrationsVersion20210519173908", "2021-05-19 19:39:21", 166),
("DoctrineMigrationsVersion20210519175037", "2021-05-19 19:50:45", 96),
("DoctrineMigrationsVersion20210519180110", "2021-05-19 20:01:23", 32),
("DoctrineMigrationsVersion20210613135546", "2021-06-13 15:56:29", 452),
("DoctrineMigrationsVersion20210614092342", "2021-06-14 13:10:55", 227),
("DoctrineMigrationsVersion20210614093124", "2021-06-14 13:10:55", 55),
("DoctrineMigrationsVersion20210614111036", "2021-06-14 13:10:55", 14),
("DoctrineMigrationsVersion20210614112404", "2021-06-14 13:24:23", 102);
INSERT INTO poster (id, price, url, in_stock, label, available, availability) VALUES
(76, 30, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2016/11/20161122-Space-Tourism-Bundle.jpg", 10, "Space Tourism Bundle", "In Stock", ""),
(77, 25, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/05/20200504-Hubble-30th-Anniversary-Poster-510x721.jpg", 10, "Hubble 30th Anniversary Bundle", "In Stock", ""),
(78, 20, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/09/20201014-AN-Yearbook-2021-247x349.jpg", 10, "AN Yearbook", "In Stock", ""),
(79, 20, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/09/20200717-Shooting-Stars-II-247x349.jpg", 7, "Shooting Stars II", "In Stock", ""),
(80, 27.99, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Enceladus-Poster-510x721.jpg", 9, "Enceladus Poster", "In Stock", ""),
(81, 22, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-PSO-Poster-510x721.jpg", 10, "PSO Poster", "In Stock", ""),
(82, 30, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Trappist-1e-Poster-510x721.jpg", 10, "Trappist 1e Poster", "In Stock", ""),
(83, 35, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Voyager-Hits-Poster-510x721.jpg", 15, "Voyager Hits Poster", "In Stock", ""),
(84, 17.99, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Buzz-Aldrin-Poster-510x721.jpg", 15, "Buzz Aldrin Poster", "In Stock", "");
INSERT INTO merchandise (id, url, price, in_stock, label, type, available) VALUES
(76, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Buzz-Aldrin-Poster-510x721.jpg", 17.99, 14, "Buzz Aldrin Poster", "poster", "In Stock"),
(77, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/09/20201014-AN-Yearbook-2021-247x349.jpg", 20, 9, "AN Yearbook", "poster", "In Stock"),
(78, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/09/20200717-Shooting-Stars-II-247x349.jpg", 20, 6, "Shooting Stars II", "poster", "In Stock"),
(79, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-PSO-Poster-510x721.jpg", 22.99, 10, "PSO Poster", "poster", "In Stock"),
(80, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/05/20200504-Hubble-30th-Anniversary-Poster-510x721.jpg", 25, 9, "Hubble 30th Anniversary Bundle", "poster", "In Stock"),
(81, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Enceladus-Poster-510x721.jpg", 27.99, 9, "Enceladus Poster", "poster", "In Stock"),
(82, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2016/11/20161122-Space-Tourism-Bundle.jpg", 30, 10, "Space Tourism Bundle", "poster", "In Stock"),
(83, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Trappist-1e-Poster-510x721.jpg", 35, 15, "Trappist 1e Poster", "poster", "In Stock"),
(84, "https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Voyager-Hits-Poster-510x721.jpg", 35, 15, "Voyager Hits Poster", "poster", "In Stock"),
(85, "https://images-na.ssl-images-amazon.com/images/I/91E3V753QSL.jpg", 30.99, 150, "Astronomy Magazine January 2017 - 7e edition", "magazine", "In Stock"),
(86, "https://www.magazines88.com/wp-content/uploads/2020/03/Astronomy-Mar-2020.jpg", 25.99, 118, "Astronomy Magazine March 2018 - 8e edition", "magazine", "In Stock"),
(87, "https://www.jetspeedmedia.com/image/cache/catalog/2017/wat-600x711.jpg", 25.99, 80, "Astronomy Magazine June 2019 - 9e edition", "magazine", "In Stock"),
(88, "https://mir-s3-cdn-cf.behance.net/project_modules/1400/c3e3e829386506.560556fd0af46.jpg", 27.99, 20, "Astronomy Magazine July 2019 - 9e edition vol II", "magazine", "In Stock"),
(89, "https://truemagazines.com/6409-large_default/astronomy.jpg", 21.99, 50, "Astronomy Magazine September 2020 - 10e edition", "magazine", "In Stock"),
(91, "https://images-na.ssl-images-amazon.com/images/I/51e4CvweSeL._SX379_BO1,204,203,200_.jpg", 24.99, 39, "Astronomy Magazine January 2021 - 11e edition", "magazine", "In Stock");
INSERT INTO order1 (id, username, date, cost, address_id, arrival) VALUES
(1, "boutaieb", "2021-06-14 23:36:46", 65, 4, "2021-06-29"),
(2, "boutaieb", "2021-06-14 23:45:25", 17.99, 4, "2021-06-26"),
(3, "aaa", "2022-03-24 12:22:55", 25.99, 5, "2022-03-28"),
(4, "aaa", "2022-03-24 12:27:55", 25.99, 5, "2022-03-30"),
(5, "aaa", "2022-03-24 12:29:27", 24.99, 5, "2022-03-31");

INSERT INTO merch_order (id, to_order_id, to_merch_id, quantity) VALUES
(1, 1, 77, 1),
(2, 1, 78, 1),
(3, 1, 80, 1),
(4, 2, 76, 1),
(5, 3, 86, 1),
(6, 4, 86, 1),
(7, 5, 91, 1);
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
