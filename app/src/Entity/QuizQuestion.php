<?php

namespace App\Entity;

use ApiPlatform\Action\NotFoundAction;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\QuizQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    uriTemplate: '/quizzes/{quiz}/questions'
)]
#[Post]
#[Patch]
#[ORM\Entity(repositoryClass: QuizQuestionRepository::class)]
class QuizQuestion
{
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private ?UuidInterface $id = null;

    #[ORM\ManyToOne(inversedBy: 'quizzesQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[ORM\Column(length: 1023)]
    private ?string $question = null;

    #[ORM\Column(length: 255)]
    private ?string $answerType = null;

    #[ORM\Column(name: 'is_active')]
    private bool $active = false;

    #[ORM\OneToMany(targetEntity: QuizQuestionAnswerVariant::class, mappedBy: 'quizQuestion', orphanRemoval: true)]
    private Collection $quizQuestionAnswerVariants;

    public function __construct()
    {
        $this->quizQuestionAnswerVariants = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswerType(): ?string
    {
        return $this->answerType;
    }

    public function setAnswerType(string $answerType): static
    {
        $this->answerType = $answerType;

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

    /**
     * @return Collection<int, QuizQuestionAnswerVariant>
     */
    public function getQuizQuestionAnswerVariants(): Collection
    {
        return $this->quizQuestionAnswerVariants;
    }

    public function addQuizQuestionAnswerVariant(QuizQuestionAnswerVariant $quizQuestionAnswerVariant): static
    {
        if (!$this->quizQuestionAnswerVariants->contains($quizQuestionAnswerVariant)) {
            $this->quizQuestionAnswerVariants->add($quizQuestionAnswerVariant);
            $quizQuestionAnswerVariant->setQuizQuestion($this);
        }

        return $this;
    }

    public function removeQuizQuestionAnswerVariant(QuizQuestionAnswerVariant $quizQuestionAnswerVariant): static
    {
        if ($this->quizQuestionAnswerVariants->removeElement($quizQuestionAnswerVariant)) {
            // set the owning side to null (unless already changed)
            if ($quizQuestionAnswerVariant->getQuizQuestion() === $this) {
                $quizQuestionAnswerVariant->setQuizQuestion(null);
            }
        }

        return $this;
    }
}
