<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250404190533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create cache tables for Laravel';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE cache (key VARCHAR(255) NOT NULL, value TEXT NOT NULL, expiration INT NOT NULL, PRIMARY KEY(key))');
        $this->addSql('CREATE TABLE cache_locks (key VARCHAR(255) NOT NULL, owner VARCHAR(255) NOT NULL, expiration INT NOT NULL, PRIMARY KEY(key))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE cache');
        $this->addSql('DROP TABLE cache_locks');
    }
}
