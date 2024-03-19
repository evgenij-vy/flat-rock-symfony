<?php

declare(strict_types=1);

namespace App\Doctrine\Enum;

use App\Enum\AnswerType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class AnswerTypeEnumType extends AbstractEnumType
{
    const NAME = 'answer_type';

    protected function getEnum(): string
    {
        return AnswerType::class;
    }

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return self::NAME;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}