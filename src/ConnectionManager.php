<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Connection;

use JustSteveKing\Graph\Connection\Adapters\AdapterInterface;

class ConnectionManager
{
    /**
     * @var AdapterInterface[]
     */
    protected array $adapters;

    /**
     * @var AdapterInterface
     */
    protected AdapterInterface $using;

    /**
     * ConnectionManager constructor.
     * @param AdapterInterface ...$adapters
     *
     * @return void
     */
    private function __construct(AdapterInterface ...$adapters)
    {
        $this->adapters = [];

        foreach ($adapters as $adapter) {
            $this->adapters[$adapter::getName()] = $adapter;
        }
    }

    /**
     * Create a new instance of the ConnectionManager
     *
     * @param AdapterInterface ...$adapters
     * @return self
     */
    public static function create(AdapterInterface ...$adapters): self
    {
        return new self(...$adapters);
    }

    /**
     * Add a new Adapter into our ConnectionManager
     *
     * @param AdapterInterface $adapter
     * @return $this
     */
    public function addAdapter(AdapterInterface $adapter): self
    {
        $this->adapters[$adapter::getName()] = $adapter;

        return $this;
    }

    /**
     * Returns an array of Adapters that have been registered
     *
     * @return array|AdapterInterface[]
     */
    public function getAdapters(): array
    {
        return $this->adapters;
    }

    /**
     * Return an Adapter from the ConnectionManager by it's alias
     *
     * @param string $alias
     * @return AdapterInterface
     */
    public function getAdapter(string $alias): AdapterInterface
    {
        if (! array_key_exists($alias, $this->adapters)) {
            throw new \RuntimeException("No Adapter registered using the alias: $alias");
        }

        return $this->adapters[$alias];
    }

    /**
     * Select the Adapter to use for this Connection and allow chaining
     *
     * @param string $alias
     * @return AdapterInterface
     */
    public function using(string $alias): AdapterInterface
    {
        if (! array_key_exists($alias, $this->adapters)) {
            throw new \RuntimeException("No Adapter registered using the alias: $alias");
        }

        $this->using = $this->adapters[$alias];

        return $this->using;
    }

    /**
     * A helper function for convenience
     *
     * @param string $alias
     * @return AdapterInterface
     */
    public function use(string $alias): AdapterInterface
    {
        return $this->using($alias);
    }

    /**
     * A helper method mainly used for testing purposes
     *
     * @return AdapterInterface
     */
    public function getUsing(): AdapterInterface
    {
        return $this->using;
    }
}
