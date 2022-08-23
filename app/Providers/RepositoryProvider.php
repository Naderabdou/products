<?php

namespace App\Providers;

use App\Repository\ApiProductsRepository;
use App\Repository\ApiProductsRepositoryInterface;
use App\Repository\ProductsRepository;
use App\Repository\ProductsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            ProductsRepositoryInterface::class,ProductsRepository::class
        );
        $this->app->bind(
            ApiProductsRepositoryInterface::class,ApiProductsRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
