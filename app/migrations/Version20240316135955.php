<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240316135955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user`s quizzes table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_quiz (id UUID NOT NULL, customer_id UUID NOT NULL, quiz_id UUID NOT NULL, date TIMESTAMP(0) WITH TIME ZONE NOT NULL, score INT NOT NULL, count_of_unanswered_question INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DE93B65B9395C3F3 ON user_quiz (customer_id)');
        $this->addSql('CREATE INDEX IDX_DE93B65B853CD175 ON user_quiz (quiz_id)');
        $this->addSql('COMMENT ON COLUMN user_quiz.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_quiz.customer_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_quiz.quiz_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_quiz ADD CONSTRAINT FK_DE93B65B9395C3F3 FOREIGN KEY (customer_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_quiz ADD CONSTRAINT FK_DE93B65B853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_quiz DROP CONSTRAINT FK_DE93B65B9395C3F3');
        $this->addSql('ALTER TABLE user_quiz DROP CONSTRAINT FK_DE93B65B853CD175');
        $this->addSql('DROP TABLE user_quiz');
    }
}
