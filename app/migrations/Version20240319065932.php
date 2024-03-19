<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240319065932 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add answer type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TYPE answer_type AS ENUM ('binary', 'multiple')");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TYPE answer_type");
    }
}
