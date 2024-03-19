<?php

namespace App\Entity;

use ApiPlatform\Action\NotFoundAction;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Doctrine\Enum\AnswerTypeEnumType;
use App\Enum\AnswerType;
use App\Filter\IsActiveFilter;
use App\Repository\QuizQuestionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[Get(
    controller: NotFoundAction::class,
    openapi: false
)]
#[GetCollection(
    uriTemplate: '/quizzes/{quiz}/questions',
    uriVariables: ['quiz' => new Link(toProperty: 'quiz', fromClass: QuizQuestion::class)],
    paginationEnabled: false,
    order: ['active' => 'DESC'],
    security: 'is_granted("ROLE_ADMIN")'
)]
#[Post(
    denormalizationContext: ['groups' => [self::DG_ITEM]],
    security: 'is_granted("ROLE_ADMIN")',
    validationContext: ['groups' => [self::DG_ITEM]],
    output: false
)]
#[Patch]
#[ORM\Entity(repositoryClass: QuizQuestionRepository::class)]
class QuizQuestion
{
    public const DG_ITEM = 'QuizQuestion:create';

    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private ?UuidInterface $id = null;

    #[Groups([self::DG_ITEM])]
    #[Assert\NotNull(groups: [self::DG_ITEM])]
    #[ORM\ManyToOne(inversedBy: 'quizzesQuestions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[Groups([self::DG_ITEM])]
    #[Assert\NotBlank(allowNull: false, groups: [self::DG_ITEM])]
    #[Assert\Length(max: 1023, groups: [self::DG_ITEM])]
    #[ORM\Column(length: 1023)]
    private ?string $question = null;

    #[Groups([self::DG_ITEM])]
    #[Assert\NotBlank(allowNull: false, groups: [self::DG_ITEM])]
    #[Assert\Choice(choices: AnswerType::CASES, groups: [self::DG_ITEM])]
    #[ORM\Column(type: AnswerTypeEnumType::NAME, length: 255)]
    private ?AnswerType $answerType = null;

    #[ORM\Column(name: 'is_active')]
    private bool $active = false;

    #[ORM\OneToMany(targetEntity: QuizQuestionAnswerVariant::class, mappedBy: 'quizQuestion', orphanRemoval: true)]
    private Collection $quizQuestionAnswerVariants;

    #[ORM\OneToOne(targetEntity: QuizQuestionAnswerVariant::class)]
    #[ORM\JoinColumn]
    private ?QuizQuestionAnswerVariant $correctAnswer = null;

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

    public function getAnswerType(): ?AnswerType
    {
        return $this->answerType;
    }

    public function setAnswerType(AnswerType $answerType): static
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

    public function getCorrectAnswer(): ?QuizQuestionAnswerVariant
    {
        return $this->correctAnswer;
    }

    public function setCorrectAnswer(?QuizQuestionAnswerVariant $correctAnswer): self
    {
        $this->correctAnswer = $correctAnswer;

        return $this;
    }
}
