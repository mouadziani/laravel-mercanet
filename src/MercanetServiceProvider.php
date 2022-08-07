<?php

namespace Mouadziani\Mercanet;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MercanetServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package->name('mercanet')->hasConfigFile();
    }
}
