<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Connection\Stubs;

use JustSteveKing\Graph\Connection\Adapters\AdapterInterface;

class WorkingAdapter implements AdapterInterface
{
    private static string $name = 'working';

    public static function getName(): string
    {
        return static::$name;
    }
}