<?php

namespace App\Providers;

use App\CountryListService;
use App\Interfaces\CountryListInterface;
use Illuminate\Support\ServiceProvider;

class CountryListServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CountryListInterface::class,
            CountryListService::class);
    }
}
