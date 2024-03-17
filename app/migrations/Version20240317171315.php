<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240317171315 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add correct answer';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz_question ADD correct_answer_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN quiz_question.correct_answer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00BFD2E7CF7 FOREIGN KEY (correct_answer_id) REFERENCES quiz_question_answer_variant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6033B00BFD2E7CF7 ON quiz_question (correct_answer_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz_question DROP CONSTRAINT FK_6033B00BFD2E7CF7');
        $this->addSql('DROP INDEX UNIQ_6033B00BFD2E7CF7');
        $this->addSql('ALTER TABLE quiz_question DROP correct_answer_id');
    }
}
