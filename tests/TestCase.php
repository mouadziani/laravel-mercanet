<?php

namespace Mouadziani\Mercanet\Tests;

use Mouadziani\Mercanet\MercanetServiceProvider;
use Mouadziani\Mercanet\Tests\Traits\AssertThrows;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use AssertThrows;

    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            MercanetServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');
    }

    public function fillDefaultConfig()
    {
        config()->set('mercanet.test', [
            'merchant_id' => '12342442',
            'key_version' => '1',
            'secret_key' => 'abcdef',
        ]);

        config()->set('mercanet.normal_return_url', 'https://example.com/payments/callback');
    }
}
