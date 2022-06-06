<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220606092556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content_management_website_page ADD social_open_graph_title VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_management_website_page ADD social_open_graph_description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content_management_website_page ADD social_open_graph_image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE content_management_website_page DROP social_open_graph_title');
        $this->addSql('ALTER TABLE content_management_website_page DROP social_open_graph_description');
        $this->addSql('ALTER TABLE content_management_website_page DROP social_open_graph_image');
    }
}
