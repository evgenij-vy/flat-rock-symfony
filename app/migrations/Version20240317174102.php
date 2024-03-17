<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240317174102 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add question on user answer table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_answer ADD quiz_question_id UUID NOT NULL');
        $this->addSql('COMMENT ON COLUMN user_answer.quiz_question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F51183101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BF8F51183101E51F ON user_answer (quiz_question_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_answer DROP CONSTRAINT FK_BF8F51183101E51F');
        $this->addSql('DROP INDEX IDX_BF8F51183101E51F');
        $this->addSql('ALTER TABLE user_answer DROP quiz_question_id');
    }
}
