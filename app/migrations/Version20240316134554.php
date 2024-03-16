<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240316134554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add answer variant table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE quiz_question_answer_variant (id UUID NOT NULL, quiz_question_id UUID NOT NULL, title VARCHAR(1023) NOT NULL, is_active BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1CACD123101E51F ON quiz_question_answer_variant (quiz_question_id)');
        $this->addSql('COMMENT ON COLUMN quiz_question_answer_variant.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN quiz_question_answer_variant.quiz_question_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE quiz_question_answer_variant ADD CONSTRAINT FK_1CACD123101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE quiz_question_answer_variant DROP CONSTRAINT FK_1CACD123101E51F');
        $this->addSql('DROP TABLE quiz_question_answer_variant');
    }
}
