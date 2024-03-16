<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240316124230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add quiz';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE quiz (id UUID NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(1024) DEFAULT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN quiz.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE quiz');
    }
}
