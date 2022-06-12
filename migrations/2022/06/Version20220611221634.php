<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220611221634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE account_management_user ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE account_management_user ALTER id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN account_management_user.id IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE account_management_user ALTER id TYPE UUID');
        $this->addSql('ALTER TABLE account_management_user ALTER id DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN account_management_user.id IS \'(DC2Type:uuid)\'');
    }
}
