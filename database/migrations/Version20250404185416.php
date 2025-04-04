<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250404185416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create jobs table for Laravel queues';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE jobs (id SERIAL NOT NULL, queue VARCHAR(255) NOT NULL, payload TEXT NOT NULL, attempts INT NOT NULL, reserved_at INT DEFAULT NULL, available_at INT NOT NULL, created_at INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_queue ON jobs (queue)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE jobs');
    }
}
