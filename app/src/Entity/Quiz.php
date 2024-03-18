<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Common\Filter\SearchFilterInterface;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Filter\IsActiveFilter;
use App\Repository\QuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    normalizationContext: ['groups' => [self::G_ITEM]],
    security: 'is_granted("ROLE_ADMIN")'
)]
#[Get]
#[GetCollection(
    order: ['active' => 'DESC', 'title' => 'ASC']
)]
#[GetCollection(
    uriTemplate: '/quizzes/for_users',
    security: 'true',
    filters: [IsActiveFilter::class]
)]
#[Post(
    denormalizationContext: ['groups' => [self::G_ITEM]],
    validationContext: ['groups' => [self::G_ITEM]]
)]
#[Patch(
    denormalizationContext: ['groups' => [self::G_ITEM]]
)]
#[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_IPARTIAL, properties: ['title', 'description'])]
#[ApiFilter(BooleanFilter::class, properties: ['active'])]
#[UniqueEntity(fields: ['title'])]
#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    public const G_ITEM = 'Quiz:item';

    #[Groups([self::G_ITEM])]
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private ?UuidInterface $id = null;

    #[Groups([self::G_ITEM])]
    #[Assert\NotBlank(allowNull: false, groups: [self::G_ITEM])]
    #[Assert\Length(max: 255, groups: [self::G_ITEM])]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Groups([self::G_ITEM])]
    #[Assert\Length(max: 1024, groups: [self::G_ITEM])]
    #[ORM\Column(length: 1024, nullable: true)]
    private ?string $description = null;

    #[Groups([self::G_ITEM])]
    #[ORM\Column(name: 'is_active')]
    private bool $active = false;

    #[ORM\OneToMany(targetEntity: QuizQuestion::class, mappedBy: 'quiz', orphanRemoval: true)]
    private Collection $quizQuestions;

    #[ORM\OneToMany(targetEntity: UserQuiz::class, mappedBy: 'quiz')]
    private Collection $userQuizzes;

    public function __construct()
    {
        $this->quizQuestions = new ArrayCollection();
        $this->userQuizzes = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    /**
     * @return Collection<int, QuizQuestion>
     */
    public function getQuizQuestions(): Collection
    {
        return $this->quizQuestions;
    }

    public function addQuizQuestion(QuizQuestion $quizzesQuestion): static
    {
        if (!$this->quizQuestions->contains($quizzesQuestion)) {
            $this->quizQuestions->add($quizzesQuestion);
            $quizzesQuestion->setQuiz($this);
        }

        return $this;
    }

    public function removeQuizQuestion(QuizQuestion $quizzesQuestion): static
    {
        if ($this->quizQuestions->removeElement($quizzesQuestion)) {
            // set the owning side to null (unless already changed)
            if ($quizzesQuestion->getQuiz() === $this) {
                $quizzesQuestion->setQuiz(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserQuiz>
     */
    public function getUserQuizzes(): Collection
    {
        return $this->userQuizzes;
    }

    public function addUserQuiz(UserQuiz $userQuiz): static
    {
        if (!$this->userQuizzes->contains($userQuiz)) {
            $this->userQuizzes->add($userQuiz);
            $userQuiz->setQuiz($this);
        }

        return $this;
    }

    public function removeUserQuiz(UserQuiz $userQuiz): static
    {
        if ($this->userQuizzes->removeElement($userQuiz)) {
            // set the owning side to null (unless already changed)
            if ($userQuiz->getQuiz() === $this) {
                $userQuiz->setQuiz(null);
            }
        }

        return $this;
    }
}
