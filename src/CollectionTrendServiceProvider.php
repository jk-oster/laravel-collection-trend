<?php

namespace JkOster\CollectionTrend;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CollectionTrendServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-collection-trend');
            // ->hasConfigFile()
            // ->hasViews()
            // ->hasMigration('create_laravel_collection_trend_table')
            // ->hasCommand(CollectionTrendCommand::class);
    }
}
