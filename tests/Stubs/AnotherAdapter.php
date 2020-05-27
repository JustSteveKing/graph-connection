<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Connection\Stubs;

use JustSteveKing\Graph\Connection\Adapters\AdapterInterface;

class AnotherAdapter implements AdapterInterface
{
    private static string $name = 'another';

    public static function getName(): string
    {
        return static::$name;
    }
}
