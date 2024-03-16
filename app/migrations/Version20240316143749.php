<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240316143749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user answer table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user_answer (id UUID NOT NULL, user_quiz_id UUID NOT NULL, user_choice_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BF8F5118DD31CF7F ON user_answer (user_quiz_id)');
        $this->addSql('CREATE INDEX IDX_BF8F51189966EB35 ON user_answer (user_choice_id)');
        $this->addSql('COMMENT ON COLUMN user_answer.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_answer.user_quiz_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_answer.user_choice_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F5118DD31CF7F FOREIGN KEY (user_quiz_id) REFERENCES user_quiz (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_answer ADD CONSTRAINT FK_BF8F51189966EB35 FOREIGN KEY (user_choice_id) REFERENCES quiz_question_answer_variant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE user_answer DROP CONSTRAINT FK_BF8F5118DD31CF7F');
        $this->addSql('ALTER TABLE user_answer DROP CONSTRAINT FK_BF8F51189966EB35');
        $this->addSql('DROP TABLE user_answer');
    }
}
