<?php

namespace JkOster\CollectionTrend\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use JkOster\CollectionTrend\CollectionTrendServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Factory::guessFactoryNamesUsing(
        //     fn (string $modelName) => 'JkOster\\CollectionTrend\\Database\\Factories\\'.class_basename($modelName).'Factory'
        // );
    }

    protected function getPackageProviders($app)
    {
        return [
            CollectionTrendServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        // config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-collection-trend_table.php.stub';
        $migration->up();
        */
    }
}
