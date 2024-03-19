<?php

declare(strict_types=1);

namespace App\Enum;

enum AnswerType: string
{
    case BINARY = 'binary';
    case MULTIPLE = 'multiple';

    const CASES = [
        self::BINARY,
        self::MULTIPLE
    ];
}