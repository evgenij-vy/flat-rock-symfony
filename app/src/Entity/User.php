<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use App\State\User\UserRegistrationProcessor;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource]
#[Post(
    uriTemplate: '/users/registration',
    denormalizationContext: ['groups' => [self::DG_REGISTER]],
    validationContext: ['groups' => [self::DG_REGISTER]],
    output: false,
    processor: UserRegistrationProcessor::class

)]
#[UniqueEntity(fields: ['email'], message: 'This email already used', groups: [self::DG_REGISTER])]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    public const DG_REGISTER = 'User:registration';

    #[ORM\Id]
    #[ORM\GeneratedValue('CUSTOM')]
    #[ORM\Column(type: UuidType::NAME)]
    #[ORM\CustomIdGenerator(UuidGenerator::class)]
    private ?UuidInterface $id = null;

    #[Groups([self::DG_REGISTER])]
    #[Assert\NotBlank(allowNull: false, groups: [self::DG_REGISTER])]
    #[Assert\Email(groups: [self::DG_REGISTER])]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[Groups([self::DG_REGISTER])]
    #[Assert\NotBlank(allowNull: false, groups: [self::DG_REGISTER])]
    #[Assert\Length(min: 6, groups: [self::DG_REGISTER])]
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private array $roles = [];

    #[Groups([self::DG_REGISTER])]
    #[Assert\NotBlank(allowNull: false, groups: [self::DG_REGISTER])]
    #[Assert\Length(max: 255, groups: [self::DG_REGISTER])]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[Groups([self::DG_REGISTER])]
    #[Assert\Length(max: 255, groups: [self::DG_REGISTER])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\OneToMany(targetEntity: UserQuiz::class, mappedBy: 'customer', orphanRemoval: true)]
    private Collection $userQuizzes;

    public function __construct()
    {
        $this->userQuizzes = new ArrayCollection();
    }

    public function getId(): ?UuidInterface
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
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
            $userQuiz->setCustomer($this);
        }

        return $this;
    }

    public function removeUserQuiz(UserQuiz $userQuiz): static
    {
        if ($this->userQuizzes->removeElement($userQuiz)) {
            // set the owning side to null (unless already changed)
            if ($userQuiz->getCustomer() === $this) {
                $userQuiz->setCustomer(null);
            }
        }

        return $this;
    }
}
