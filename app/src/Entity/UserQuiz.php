<?php

namespace App\Entity;

use App\Repository\UserQuizRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: UserQuizRepository::class)]
class UserQuiz
{
    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private ?UuidInterface $id = null;

    #[ORM\ManyToOne(inversedBy: 'userQuizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $customer = null;

    #[ORM\ManyToOne(inversedBy: 'userQuizzes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Quiz $quiz = null;

    #[ORM\Column(type: Types::DATETIMETZ_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\Column]
    private ?int $countOfUnansweredQuestion = null;

    #[ORM\OneToMany(targetEntity: UserAnswer::class, mappedBy: 'userQuiz')]
    private Collection $userAnswers;

    public function __construct()
    {
        $this->userAnswers = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): static
    {
        $this->customer = $customer;

        return $this;
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getCountOfUnansweredQuestion(): ?int
    {
        return $this->countOfUnansweredQuestion;
    }

    public function setCountOfUnansweredQuestion(int $countOfUnansweredQuestion): static
    {
        $this->countOfUnansweredQuestion = $countOfUnansweredQuestion;

        return $this;
    }

    /**
     * @return Collection<int, UserAnswer>
     */
    public function getUserAnswers(): Collection
    {
        return $this->userAnswers;
    }

    public function addUserAnswer(UserAnswer $userAnswer): static
    {
        if (!$this->userAnswers->contains($userAnswer)) {
            $this->userAnswers->add($userAnswer);
            $userAnswer->setUserQuiz($this);
        }

        return $this;
    }

    public function removeUserAnswer(UserAnswer $userAnswer): static
    {
        if ($this->userAnswers->removeElement($userAnswer)) {
            // set the owning side to null (unless already changed)
            if ($userAnswer->getUserQuiz() === $this) {
                $userAnswer->setUserQuiz(null);
            }
        }

        return $this;
    }
}
