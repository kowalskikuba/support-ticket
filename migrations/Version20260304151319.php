<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260304151319 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create ticket table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<SQL
            CREATE TABLE ticket (
                id BINARY(16) NOT NULL,
                email VARCHAR(180) NOT NULL,
                subject VARCHAR(255) NOT NULL,
                message LONGTEXT NOT NULL,
                created_at DATETIME NOT NULL,
                status VARCHAR(30) NOT NULL,
                PRIMARY KEY (id)) DEFAULT
                CHARACTER SET utf8mb4
            SQL,
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE ticket');
    }
}
