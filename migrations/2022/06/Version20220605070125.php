<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220605070125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE content_management_website_page_meta_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE content_management_website_page (id UUID NOT NULL, parent_id UUID DEFAULT NULL, type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title_value VARCHAR(255) NOT NULL, path_value VARCHAR(255) NOT NULL, seo_should_index BOOLEAN NOT NULL, seo_crawl_priority_value INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D1838317727ACA70 ON content_management_website_page (parent_id)');
        $this->addSql('COMMENT ON COLUMN content_management_website_page.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN content_management_website_page.parent_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN content_management_website_page.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN content_management_website_page.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE content_management_website_page_meta (id INT NOT NULL, page_id UUID DEFAULT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DCAB67EEC4663E4 ON content_management_website_page_meta (page_id)');
        $this->addSql('COMMENT ON COLUMN content_management_website_page_meta.page_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE content_management_website_page ADD CONSTRAINT FK_D1838317727ACA70 FOREIGN KEY (parent_id) REFERENCES content_management_website_page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE content_management_website_page_meta ADD CONSTRAINT FK_DCAB67EEC4663E4 FOREIGN KEY (page_id) REFERENCES content_management_website_page (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content_management_website_page DROP CONSTRAINT FK_D1838317727ACA70');
        $this->addSql('ALTER TABLE content_management_website_page_meta DROP CONSTRAINT FK_DCAB67EEC4663E4');
        $this->addSql('DROP SEQUENCE content_management_website_page_meta_id_seq CASCADE');
        $this->addSql('DROP TABLE content_management_website_page');
        $this->addSql('DROP TABLE content_management_website_page_meta');
    }
}
