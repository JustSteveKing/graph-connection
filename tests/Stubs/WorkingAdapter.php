<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Connection\Stubs;

use JustSteveKing\Graph\Connection\Adapters\AdapterInterface;

class WorkingAdapter implements AdapterInterface
{
    protected array $queries;
    
    private static string $name = 'working';

    public static function getName(): string
    {
        return static::$name;
    }

    public function send()
    {
        return [];
    }

    public function query(string $query) : self
    {
        array_push($this->queries, $query);

        return $this;
    }
}