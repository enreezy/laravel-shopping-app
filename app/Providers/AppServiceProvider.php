<?php

namespace App\Providers;

use App\Item;
use App\Repository\ItemRepository;
use App\Contracts\ItemRepositoryInterface;
use App\Repository\OrderRepository;
use App\Contracts\OrderRepositoryInterface;
use App\Repository\CategoryRepository;
use App\Contracts\CategoryRepositoryInterface;
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
        $this->app->bind(CategoryRepositoryInterface::class,CategoryRepository::class);
        $this->app->bind(OrderRepositoryInterface::class,OrderRepository::class);
        $this->app->bind('Dataset', \App\Dataset\DatasetBuilder::class);
    }
}
