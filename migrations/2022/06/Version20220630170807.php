<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220630170807 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content_management_website_page ADD image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_management_website_page DROP social_open_graph_title');
        $this->addSql('ALTER TABLE content_management_website_page DROP social_open_graph_description');
        $this->addSql('ALTER TABLE content_management_website_page DROP social_open_graph_image');
        $this->addSql('ALTER TABLE content_management_website_page RENAME COLUMN seo_crawl_priority TO crawl_priority');
        $this->addSql('ALTER TABLE content_management_website_page RENAME COLUMN seo_should_index TO crawl_should_index');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE content_management_website_page ADD social_open_graph_description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_management_website_page ADD social_open_graph_image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_management_website_page RENAME COLUMN crawl_should_index TO seo_should_index');
        $this->addSql('ALTER TABLE content_management_website_page RENAME COLUMN crawl_priority TO seo_crawl_priority');
        $this->addSql('ALTER TABLE content_management_website_page RENAME COLUMN image_url TO social_open_graph_title');
    }
}
