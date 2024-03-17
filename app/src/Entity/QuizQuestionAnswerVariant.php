<?php

namespace App\Entity;

use ApiPlatform\Action\NotFoundAction;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Filter\IsActiveFilter;
use App\Repository\QuizQuestionAnswerVariantRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;

#[ApiResource]
#[Get(
    controller: NotFoundAction::class,
    openapi: false
)]
#[GetCollection(
    uriVariables: '/quiz_questions/{quizQuestion}//quiz_question_answer_variants',
    filters: [IsActiveFilter::class]
)]
#[Post]
#[Patch]
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
