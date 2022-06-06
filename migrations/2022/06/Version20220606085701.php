<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220606085701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE content_management_website_page_meta');
        $this->addSql('ALTER TABLE content_management_website_page ADD description TEXT DEFAULT \'\' NOT NULL');
        $this->addSql('ALTER TABLE content_management_website_page RENAME COLUMN title_value TO title');
        $this->addSql('ALTER TABLE content_management_website_page RENAME COLUMN seo_crawl_priority_value TO seo_crawl_priority');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE content_management_website_page_meta (id INT NOT NULL, page_id UUID DEFAULT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_dcab67eec4663e4 ON content_management_website_page_meta (page_id)');
        $this->addSql('COMMENT ON COLUMN content_management_website_page_meta.page_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE content_management_website_page_meta ADD CONSTRAINT fk_dcab67eec4663e4 FOREIGN KEY (page_id) REFERENCES content_management_website_page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE content_management_website_page DROP description');
        $this->addSql('ALTER TABLE content_management_website_page RENAME COLUMN title TO title_value');
        $this->addSql('ALTER TABLE content_management_website_page RENAME COLUMN seo_crawl_priority TO seo_crawl_priority_value');
    }
}
