<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Connection\Adapters;

interface AdapterInterface
{
    /**
     * This method is used to set an alias within the connection manager
     *
     * @return string
     */
    public static function getName(): string;

    /**
     * Send the request to the database
     *
     * @return mixed
     */
    public function send();

    /**
     * Add a query to the call stack
     *
     * @param string $query
     *
     * @return self
     */
    public function query(string $query): self;
}
