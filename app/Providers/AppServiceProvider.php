<?php

namespace App\Providers;

use App\Item;
use App\Repository\ItemRepository;
use App\Repository\ItemRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ItemRepositoryInterface::class,ItemRepository::class);
    }
}
