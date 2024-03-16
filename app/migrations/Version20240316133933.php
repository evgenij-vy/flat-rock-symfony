<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240316133933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add quizzes questions';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE quiz_question (id UUID NOT NULL, quiz_id UUID NOT NULL, question VARCHAR(1023) NOT NULL, answer_type VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6033B00B853CD175 ON quiz_question (quiz_id)');
        $this->addSql('COMMENT ON COLUMN quiz_question.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quiz_question.quiz_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz_question DROP CONSTRAINT FK_6033B00B853CD175');
        $this->addSql('DROP TABLE quiz_question');
    }
}
