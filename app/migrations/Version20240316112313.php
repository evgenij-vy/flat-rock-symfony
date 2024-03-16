<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240316112313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE "user" (id UUID NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles TEXT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN "user".roles IS \'(DC2Type:array)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE "user"');
    }
}
