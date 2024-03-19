<?php

declare(strict_types = 1);

namespace App\Doctrine\Enum;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class AbstractEnumType extends Type
{
    /**
     * @return class-string
     */
    abstract protected function getEnum(): string;

    abstract public function getSQLDeclaration(array $column, AbstractPlatform $platform): string;

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): mixed
    {
        $enumClass = $this->getEnum();

        return $value ? $enumClass::from($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (is_string($value)) {
            return $value;
        }

        return $value ? $value->value : null;
    }
}
