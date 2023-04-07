<?php

namespace Flooris\DpdShipper;

use Spatie\LaravelPackageTools\Package;
use Flooris\DpdShipper\Objects\DpdSender;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class DpdShipperServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('dpd-shipper')
            ->hasConfigFile();
    }

    public function packageBooted(): void
    {
        $this->app->singleton(DpdShipperConnector::class, function ($app) {
            $sandbox = (bool)config('dpd-shipper.sandbox');

            return new DpdShipperConnector(
                config('dpd-shipper.region_accounts.default.id'),
                config('dpd-shipper.region_accounts.default.password'),
                config('dpd-shipper.region_accounts.default.depot_nr'),
                $sandbox ? config('dpd-shipper.base_url.sandbox') : config('dpd-shipper.base_url.production'),
                config('dpd-shipper.auth_url'),
                config('dpd-shipper.message_language'),
            );
        });

        $this->app->singleton(DpdSender::class, function ($app) {
            return new DpdSender(
                name: config('dpd-shipper.sender.company_name'),
                street: config('dpd-shipper.sender.street'),
                houseNumber: config('dpd-shipper.sender.house_nr'),
                countryIso: config('dpd-shipper.sender.country_code'),
                postalCode: config('dpd-shipper.sender.zipcode'),
                city: config('dpd-shipper.sender.city')
            );
        });
    }
}

