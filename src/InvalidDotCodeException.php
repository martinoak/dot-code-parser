<?php

declare(strict_types=1);

namespace Martinoak\DotCodeParser;

use InvalidArgumentException;

/**
 * Thrown when a string cannot be parsed as a valid tire DOT code.
 */
class InvalidDotCodeException extends InvalidArgumentException
{
    public static function forCode(string $code): self
    {
        return new self(sprintf('Invalid DOT code: "%s".', $code));
    }
}
