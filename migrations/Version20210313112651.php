<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210313112651 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post ADD image_first_id INT DEFAULT NULL, ADD image_second_id INT DEFAULT NULL, ADD image_last_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D67BDECF7 FOREIGN KEY (image_first_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D2714C098 FOREIGN KEY (image_second_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D44EDC33A FOREIGN KEY (image_last_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8D67BDECF7 ON post (image_first_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8D2714C098 ON post (image_second_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A8A6C8D44EDC33A ON post (image_last_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D67BDECF7');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D2714C098');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D44EDC33A');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8D67BDECF7 ON post');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8D2714C098 ON post');
        $this->addSql('DROP INDEX UNIQ_5A8A6C8D44EDC33A ON post');
        $this->addSql('ALTER TABLE post DROP image_first_id, DROP image_second_id, DROP image_last_id');
    }
}
