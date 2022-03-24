<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220324153119 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("

INSERT INTO contact (id, name, email, message, created_at, is_send) VALUES
(1, 'med bt', 'as@gmail.com', 'lorem', '2021-06-14 23:15:22', 0),
(2, 'boutaiebbb', 'b@gmail.com', 'lorem', '2021-06-14 23:31:58', 0),
(3, 'sara', 'gh@gmail.com', 'abcdefg', '2021-06-14 23:35:44', 0),
(4, 'mohamed', 'abcd@gmail.com', 'abcdefghij', '2021-06-14 23:43:40', 0);
");
        $this->addSql("
INSERT INTO poster (id, price, url, in_stock, label, available, availability) VALUES
(76, 30, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2016/11/20161122-Space-Tourism-Bundle.jpg', 10, 'Space Tourism Bundle', 'In Stock', ''),
(77, 25, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/05/20200504-Hubble-30th-Anniversary-Poster-510x721.jpg', 10, 'Hubble 30th Anniversary Bundle', 'In Stock', ''),
(78, 20, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/09/20201014-AN-Yearbook-2021-247x349.jpg', 10, 'AN Yearbook', 'In Stock', ''),
(79, 20, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/09/20200717-Shooting-Stars-II-247x349.jpg', 7, 'Shooting Stars II', 'In Stock', ''),
(80, 27.99, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Enceladus-Poster-510x721.jpg', 9, 'Enceladus Poster', 'In Stock', ''),
(81, 22, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-PSO-Poster-510x721.jpg', 10, 'PSO Poster', 'In Stock', ''),
(82, 30, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Trappist-1e-Poster-510x721.jpg', 10, 'Trappist 1e Poster', 'In Stock', ''),
(83, 35, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Voyager-Hits-Poster-510x721.jpg', 15, 'Voyager Hits Poster', 'In Stock', ''),
(84, 17.99, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Buzz-Aldrin-Poster-510x721.jpg', 15, 'Buzz Aldrin Poster', 'In Stock', '');
");

        $this->addSql("INSERT INTO merchandise (id, url, price, in_stock, label, type, available) VALUES
(76, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Buzz-Aldrin-Poster-510x721.jpg', 17.99, 14, 'Buzz Aldrin Poster', 'poster', 'In Stock'),
(77, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/09/20201014-AN-Yearbook-2021-247x349.jpg', 20, 9, 'AN Yearbook', 'poster', 'In Stock'),
(78, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/09/20200717-Shooting-Stars-II-247x349.jpg', 20, 6, 'Shooting Stars II', 'poster', 'In Stock'),
(79, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-PSO-Poster-510x721.jpg', 22.99, 10, 'PSO Poster', 'poster', 'In Stock'),
(80, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2020/05/20200504-Hubble-30th-Anniversary-Poster-510x721.jpg', 25, 9, 'Hubble 30th Anniversary Bundle', 'poster', 'In Stock'),
(81, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Enceladus-Poster-510x721.jpg', 27.99, 9, 'Enceladus Poster', 'poster', 'In Stock'),
(82, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2016/11/20161122-Space-Tourism-Bundle.jpg', 30, 10, 'Space Tourism Bundle', 'poster', 'In Stock'),
(83, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2019/02/20190219-Trappist-1e-Poster-510x721.jpg', 35, 15, 'Trappist 1e Poster', 'poster', 'In Stock'),
(84, 'https://mk0astronomynow3e9yu.kinstacdn.com/wp-content/uploads/2017/10/Voyager-Hits-Poster-510x721.jpg', 35, 15, 'Voyager Hits Poster', 'poster', 'In Stock'),
(85, 'https://images-na.ssl-images-amazon.com/images/I/91E3V753QSL.jpg', 30.99, 150, 'Astronomy Magazine January 2017 - 7e edition', 'magazine', 'In Stock'),
(86, 'https://www.magazines88.com/wp-content/uploads/2020/03/Astronomy-Mar-2020.jpg', 25.99, 118, 'Astronomy Magazine March 2018 - 8e edition', 'magazine', 'In Stock'),
(87, 'https://www.jetspeedmedia.com/image/cache/catalog/2017/wat-600x711.jpg', 25.99, 80, 'Astronomy Magazine June 2019 - 9e edition', 'magazine', 'In Stock'),
(88, 'https://mir-s3-cdn-cf.behance.net/project_modules/1400/c3e3e829386506.560556fd0af46.jpg', 27.99, 20, 'Astronomy Magazine July 2019 - 9e edition vol II', 'magazine', 'In Stock'),
(89, 'https://truemagazines.com/6409-large_default/astronomy.jpg', 21.99, 50, 'Astronomy Magazine September 2020 - 10e edition', 'magazine', 'In Stock'),
(91, 'https://images-na.ssl-images-amazon.com/images/I/51e4CvweSeL._SX379_BO1,204,203,200_.jpg', 24.99, 39, 'Astronomy Magazine January 2021 - 11e edition', 'magazine', 'In Stock');");


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
