<?php

namespace App\Entity;

use App\Repository\QuizQuestionAnswerVariantRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: QuizQuestionAnswerVariantRepository::class)]
class QuizQuestionAnswerVariant
{
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private ?UuidInterface $id = null;

    #[ORM\ManyToOne(inversedBy: 'quizQuestionAnswerVariants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?QuizQuestion $quizQuestion = null;

    #[ORM\Column(length: 1023)]
    private ?string $title = null;

    #[ORM\Column(name: 'is_active')]
    private bool $active = false;

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getQuizQuestion(): ?QuizQuestion
    {
        return $this->quizQuestion;
    }

    public function setQuizQuestion(?QuizQuestion $quizQuestion): static
    {
        $this->quizQuestion = $quizQuestion;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }
}
