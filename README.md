# Graph Connection Manager


[![Latest Version on Packagist][ico-version]][link-packagist]
![run-tests](https://github.com/JustSteveKing/graph-connection/workflows/run-tests/badge.svg)
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]


**This package is still a work in progress, what I have tested works so far but should not be used in a production environment yet**

The purpose of this package is to create a simple to use manager class where you can add graph database connection adapters, and forward calls through to the adapters to query against your graph databases.

## Installation

Using composer:

```bash
$ composer require juststeveking/graph-connection
```

You are then free to use it as needed within your projects.

## Adapters

The first step is to create an adapter that extends the `JustSteveKing\Graph\Connection\Adapters\AdapterInterface` and implements the following methods:

- `public static function getName(): string;`

This of course must return a string, but this string is what is used to alias your adapter when using the `ConnectionManager` class.

- `public function send(string $query);`

This is where you would send your graph query as a string, through to your adapter - the return type is down to the adapter itself (this isn't a PSR).


I am currently building out a `HttpAdapter` to use alongside neo4j and their v4 HTTP API, which will be released as a separate package.


## Usage

Using this library is relatively simple.

You can create a new `ConnectionManager` by providing it with an Adapter that follows `JustSteveKing\Graph\Connection\Adapters\AdapterInterface`:

```php
<?php

use JustSteveKing\Graph\Connection\ConnectionManager;
use JustSteveKing\Tests\Graph\Connection\Stubs\WorkingAdapter;
use JustSteveKing\Tests\Graph\Connection\Stubs\AnotherAdapter;

// the create method takes a variadic argument of adapters
// and returns an instance of the ConnectionManager with registered adapters
$manager = ConnectionManager::create(new WorkingAdapter(), new AnotherAdapter());
```

You may also add another connection once instantiated:

```php
<?php

use JustSteveKing\Graph\Connection\ConnectionManager;
use JustSteveKing\Tests\Graph\Connection\Stubs\WorkingAdapter;
use JustSteveKing\Tests\Graph\Connection\Stubs\AnotherAdapter;

// the create method takes a variadic argument of adapters
// and returns an instance of the ConnectionManager with registered adapters
$manager = ConnectionManager::create(new WorkingAdapter());
$manager->addAdapter(new AnotherAdapter());
```

Once you have created your connection manager, you can then work with the adapters in the following ways:

## The use method to select an adapter to query against

```php
<?php

use JustSteveKing\Graph\Connection\ConnectionManager;
use JustSteveKing\Tests\Graph\Connection\Stubs\WorkingAdapter;
use JustSteveKing\Tests\Graph\Connection\Stubs\AnotherAdapter;

$manager = ConnectionManager::create(new WorkingAdapter(), new AnotherAdapter());

$response = $manager->use('adapter-alias')->query('graph query');
```

## The using method to select an adapter to query against

```php
<?php

use JustSteveKing\Graph\Connection\ConnectionManager;
use JustSteveKing\Tests\Graph\Connection\Stubs\WorkingAdapter;
use JustSteveKing\Tests\Graph\Connection\Stubs\AnotherAdapter;

$manager = ConnectionManager::create(new WorkingAdapter(), new AnotherAdapter());

$response = $manager->using('adapter-alias')->query('graph query');
```

## The getAdapter method to select an adapter to query against

```php
<?php

use JustSteveKing\Graph\Connection\ConnectionManager;
use JustSteveKing\Tests\Graph\Connection\Stubs\WorkingAdapter;
use JustSteveKing\Tests\Graph\Connection\Stubs\AnotherAdapter;

$manager = ConnectionManager::create(new WorkingAdapter(), new AnotherAdapter());

$response = $manager->getAdapter('adapter-alias')->query('graph query');
```

## Writing queries for neo4j

I am currently in the process of publishing a Cypher query builder to use alongside this library, but you are also welcome to use any other library or method to write cypher queries yourself.

[Cypher Query Builder package](https://github.com/JustSteveKing/cypher-query-builder)


## Tests

There is a composer script available to run the tests:

```bash
$ composer run test
```

However, if you are unable to run this please use the following command:

```bash
$ ./vendor/bin/phpunit --testdox
```

## Security

If you discover any security related issues, please email juststevemcd@gmail.com instead of using the issue tracker.

[ico-version]: https://img.shields.io/packagist/v/juststeveking/graph-connection.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/juststeveking/graph-connection.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/JustSteveKing/graph-connection.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/juststeveking/graph-connection
[link-downloads]: https://packagist.org/packages/juststeveking/graph-connection
[link-author]: https://github.com/JustSteveKing
[link-code-quality]: https://scrutinizer-ci.com/g/JustSteveKing/graph-connection