<?php

declare(strict_types=1);

namespace App\State\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Exception\InsufficientAuthenticationException;

class MyProfileProvider implements ProviderInterface
{
    public function __construct(
        private readonly Security $security
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): User
    {
        return $this->security->getUser() ?? throw new InsufficientAuthenticationException();
    }
}