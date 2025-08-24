<?php

use Litepie\Hashids\HashidsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

uses(Orchestra::class)
    ->beforeEach(function () {
        // This will run before each test
    })
    ->in('Unit', 'Feature');

function getPackageProviders($app)
{
    return [
        HashidsServiceProvider::class,
    ];
}

function getEnvironmentSetUp($app)
{
    $app['config']->set('app.key', 'base64:ZNvWpMbCNRGZIxnYgzJSwhvdKF3p8m8HhZdvUgzNgFM=');
    $app['config']->set('hashids.salt', 'test-salt');
    $app['config']->set('hashids.length', 10);
}
