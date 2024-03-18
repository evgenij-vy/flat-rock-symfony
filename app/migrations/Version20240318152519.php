<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240318152519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'correct_answer_id can be null';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz_question ALTER correct_answer_id DROP NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz_question ALTER correct_answer_id SET NOT NULL');
    }
}
