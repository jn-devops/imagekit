<?php

namespace Homeful\Imagekit;

use Homeful\Imagekit\Commands\ImagekitCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ImagekitServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('imagekit')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_imagekit_table')
            ->hasCommand(ImagekitCommand::class);
    }
}
