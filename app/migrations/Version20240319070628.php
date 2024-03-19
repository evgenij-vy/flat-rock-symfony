<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240319070628 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'migrate to enum type';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("DELETE FROM quiz_question WHERE answer_type not in ('binary', 'multiple')");
        $this->addSql('ALTER TABLE quiz_question ALTER answer_type TYPE answer_type USING answer_type::answer_type');
        $this->addSql('COMMENT ON COLUMN quiz_question.answer_type IS \'(DC2Type:answer_type)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz_question ALTER answer_type TYPE VARCHAR(255) USING answer_type::text');
        $this->addSql('COMMENT ON COLUMN quiz_question.answer_type IS NULL');
    }
}
