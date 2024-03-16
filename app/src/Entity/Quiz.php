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
use App\Repository\QuizRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    normalizationContext: ['groups' => [self::G_ITEM]],
)]
#[Get(
    security: 'object.isActive() or is_granted("ADMIN")'
)]
#[GetCollection(
    security: 'is_granted("ADMIN")',
)]
#[GetCollection(
    uriTemplate: '/quizzes/for_users',
    security: 'is_granted("USER")'
)]
#[Post(
    denormalizationContext: ['groups' => [self::G_ITEM]],
    security: 'is_granted("ADMIN")',
    validationContext: ['groups' => [self::G_ITEM]]
)]
#[Patch(
    denormalizationContext: ['groups' => [self::G_ITEM]],
    security: 'is_granted("ADMIN")',
)]
#[Delete(
    security: 'is_granted("ADMIN")'
)]
#[ApiFilter(SearchFilter::class, strategy: SearchFilterInterface::STRATEGY_IPARTIAL, properties: ['title', 'description'])]
#[ApiFilter(BooleanFilter::class, properties: ['active'])]
#[ORM\Entity(repositoryClass: QuizRepository::class)]
class Quiz
{
    public const G_ITEM = 'Quiz:item';

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
}
