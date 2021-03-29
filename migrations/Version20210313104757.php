<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210313104757 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD image_name VARCHAR(255) NOT NULL, DROP url, DROP caption');
        $this->addSql('ALTER TABLE post ADD cover_image_id INT DEFAULT NULL, DROP cover_image');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DE5A0E336 FOREIGN KEY (cover_image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8DE5A0E336 ON post (cover_image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD caption VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE image_name url VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DE5A0E336');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8DE5A0E336 ON post');
        $this->addSql('ALTER TABLE post ADD cover_image VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP cover_image_id');
    }
}
