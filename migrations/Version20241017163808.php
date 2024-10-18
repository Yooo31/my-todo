<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241017163808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE priority (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, color VARCHAR(255) NOT NULL)');
        $this->addSql('DROP TABLE importance');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE importance (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, color VARCHAR(255) NOT NULL COLLATE "BINARY", title VARCHAR(255) NOT NULL COLLATE "BINARY")');
        $this->addSql('DROP TABLE priority');
    }
}
