<?php

namespace Litepie\Hashids\Tests;

use Litepie\Hashids\HashidsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            HashidsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'base64:ZNvWpMbCNRGZIxnYgzJSwhvdKF3p8m8HhZdvUgzNgFM=');
        $app['config']->set('hashids.salt', 'test-salt');
        $app['config']->set('hashids.length', 10);
    }
}
