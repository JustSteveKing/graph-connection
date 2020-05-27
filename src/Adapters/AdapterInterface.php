<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Connection\Adapters;

interface AdapterInterface
{
    public static function getName(): string;

    public function send(string $query);
}
