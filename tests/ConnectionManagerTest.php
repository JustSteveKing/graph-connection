<?php

declare(strict_types=1);

namespace JustSteveKing\Tests\Graph\Connection;

use JustSteveKing\Tests\Graph\Connection\Stubs\AnotherAdapter;
use PHPUnit\Framework\TestCase;
use JustSteveKing\Graph\Connection\ConnectionManager;
use JustSteveKing\Graph\Connection\Adapters\AdapterInterface;
use JustSteveKing\Tests\Graph\Connection\Stubs\WorkingAdapter;

class ConnectionManagerTest extends TestCase
{
    public function createInstance(AdapterInterface ... $adapters)
    {
        return ConnectionManager::create(...$adapters);
    }

    /**
     * @test
     */
    public function it_can_create_a_new_instance_of_the_connection_manager()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());

        $this->assertInstanceOf(
            ConnectionManager::class,
            $connectionManager
        );
    }

    /**
     * @test
     */
    public function it_registers_adapter_once_instantiated()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());

        $this->assertTrue(
            ! empty($connectionManager->getAdapters())
        );
    }

    /**
     * @test
     */
    public function it_can_only_have_one_of_the_same_adapter_added()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());

        $this->assertEquals(1, count($connectionManager->getAdapters()));

        $connectionManager = $this->createInstance(new WorkingAdapter(), new WorkingAdapter());

        $this->assertEquals(1, count($connectionManager->getAdapters()));
    }

    /**
     * @test
     */
    public function it_can_have_more_that_one_adapter_registered()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter(), new AnotherAdapter());

        $this->assertEquals(2, count($connectionManager->getAdapters()));
    }

    /**
     * @test
     */
    public function it_can_register_additional_adapters_after_instantiated()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());
        $this->assertEquals(1, count($connectionManager->getAdapters()));

        $connectionManager->addAdapter(new AnotherAdapter());
        $this->assertEquals(2, count($connectionManager->getAdapters()));
    }

    /**
     * @test
     */
    public function it_returns_an_array_of_adapters()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());

        $this->assertIsArray(
            $connectionManager->getAdapters()
        );

        $this->assertEquals(
            1,
            count($connectionManager->getAdapters())
        );
    }

    /**
     * @test
     */
    public function it_can_return_an_adapter_by_its_alias()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());

        $this->assertEquals(
            'working',
            $connectionManager->getAdapter('working')->getName()
        );
    }

    /**
     * @test
     */
    public function it_throws_a_runtime_exception_if_the_wrong_alias_is_passed()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());

        $this->expectException(\RuntimeException::class);

        $connectionManager->getAdapter('exception');
    }

    /**
     * @test
     */
    public function it_can_set_the_using_property_when_adapter_is_selected()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());

        $this->assertInstanceOf(
            WorkingAdapter::class,
            $connectionManager->using('working')
        );
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_the_wrong_alias_is_passed_while_selected_an_adapter()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());
        $this->expectException(\RuntimeException::class);

        $connectionManager->using('exception');
    }

    /**
     * @test
     */
    public function it_can_set_the_using_property_when_adapter_is_selected_using_the_helper_method()
    {
        $connectionManager = $this->createInstance(new WorkingAdapter());

        $connectionManager->use('working');

        $this->assertInstanceOf(
            WorkingAdapter::class,
            $connectionManager->getUsing()
        );
    }
}
