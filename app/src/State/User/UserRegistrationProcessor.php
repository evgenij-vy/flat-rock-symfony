<?php

declare(strict_types=1);

namespace App\State\User;

use ApiPlatform\Doctrine\Common\State\PersistProcessor;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserRegistrationProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly PersistProcessor $persistProcessor,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $userRepository
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        if (!$data instanceof User) {
            throw new \LogicException();
        }

        $this->persistProcessor->process(
            $data
                ->setPassword($this->passwordHasher->hashPassword($data, $data->getPassword()))
                ->setRoles($this->userRepository->count([]) === 0 ? ['ADMIN'] : ['USER']),
            $operation,
            $uriVariables,
            $context
        );
    }
}