<?php

declare(strict_types=1);

namespace JustSteveKing\Graph\Connection;

use JustSteveKing\ParameterBag\ParameterBag;
use JustSteveKing\Graph\Connection\Adapters\AdapterInterface;

class ConnectionManager
{
    /**
     * @var ParameterBag
     */
    protected ParameterBag $adapters;

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
        $this->adapters = new ParameterBag();

        foreach ($adapters as $adapter) {
            $this->adapters->set($adapter::getName(), $adapter);
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
        $this->adapters->set($adapter::getName(), $adapter);

        return $this;
    }

    /**
     * Returns an array of Adapters that have been registered
     *
     * @return array|AdapterInterface[]
     */
    public function getAdapters(): array
    {
        return $this->adapters->all();
    }

    /**
     * Return an Adapter from the ConnectionManager by it's alias
     *
     * @param string $alias
     * @return AdapterInterface
     */
    public function getAdapter(string $alias): AdapterInterface
    {
        if (! $this->adapters->has($alias)) {
            throw new \RuntimeException("No Adapter registered using the alias: $alias");
        }

        return $this->adapters->get($alias);
    }

    /**
     * Select the Adapter to use for this Connection and allow chaining
     *
     * @param string $alias
     * @return AdapterInterface
     */
    public function using(string $alias): AdapterInterface
    {
        if (! $this->adapters->has($alias)) {
            throw new \RuntimeException("No Adapter registered using the alias: $alias");
        }

        $this->using = $this->adapters->get($alias);

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

    /**
     * Pass the query through to the adapter and return
     *
     * @param string $query
     * @return mixed
     */
    public function query(string $query)
    {
        return $this->using->query($query);
    }
}
