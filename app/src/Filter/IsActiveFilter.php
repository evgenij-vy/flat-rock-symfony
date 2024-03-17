<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\FilterInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\ActivableInterface;
use Doctrine\ORM\QueryBuilder;

class IsActiveFilter implements FilterInterface
{

    public function apply(
        QueryBuilder $queryBuilder,
        QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass,
        ?Operation $operation = null,
        array $context = []
    ): void
    {
        if (!is_a($resourceClass, ActivableInterface::class, true)) {
            return;
        }

        $queryBuilder
            ->andWhere(sprintf('%.active = :trueValue', $queryBuilder->getRootAliases()[0]))
            ->setParameter('trueValue', true);
    }

    public function getDescription(string $resourceClass): array
    {
        return [];
    }
}