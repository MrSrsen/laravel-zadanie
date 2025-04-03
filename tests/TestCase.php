<?php

namespace Tests;

use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    private static bool $fixturesAlreadyExecuted = false;

    protected function runFixturesOnce(): void
    {
        if (self::$fixturesAlreadyExecuted) {
            return; // Do not run fixtures more than once per test
        }

        self::$fixturesAlreadyExecuted = true;

        $config = config('doctrine-data-fixtures')['default'];
        $objectManager = app($config['objectManager']);
        $purger = app($config['purger']);
        $executorClass = $config['executor'];
        $loader = new Loader();

        $executor = new $executorClass($objectManager, $purger);

        foreach ($config['fixtures'] as $fixture) {
            $loader->addFixture(app($fixture));
        }

        $purger->setPurgeMode(ORMPurger::PURGE_MODE_TRUNCATE);

        $executor->execute($loader->getFixtures(), false);
    }
}
