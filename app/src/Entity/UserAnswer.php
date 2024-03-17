<?php

namespace App\Entity;

use App\Repository\UserAnswerRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: UserAnswerRepository::class)]
class UserAnswer
{
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private ?UuidInterface $id = null;

    #[ORM\ManyToOne(inversedBy: 'userAnswers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?UserQuiz $userQuiz = null;

    #[ORM\ManyToOne]
    private ?QuizQuestionAnswerVariant $userChoice = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuizQuestion $quizQuestion = null;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getUserQuiz(): ?UserQuiz
    {
        return $this->userQuiz;
    }

    public function setUserQuiz(?UserQuiz $userQuiz): static
    {
        $this->userQuiz = $userQuiz;

        return $this;
    }

    public function getUserChoice(): ?QuizQuestionAnswerVariant
    {
        return $this->userChoice;
    }

    public function setUserChoice(?QuizQuestionAnswerVariant $userChoice): static
    {
        $this->userChoice = $userChoice;

        return $this;
    }

    public function getQuizQuestion(): ?QuizQuestion
    {
        return $this->quizQuestion;
    }

    public function setQuizQuestion(?QuizQuestion $quizQuestion): self
    {
        $this->quizQuestion = $quizQuestion;

        return $this;
    }
}
