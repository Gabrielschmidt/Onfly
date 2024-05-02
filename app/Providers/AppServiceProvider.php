<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\User\{UserRepositoryInterface, UserRepositoryEloquent};
use App\Repository\Card\{CardRepositoryInterface, CardRepositoryEloquent};
use App\Repository\Expense\{ExpenseRepositoryInterface, ExpenseRepositoryEloquent};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepositoryEloquent::class
        );

        $this->app->bind(
            CardRepositoryInterface::class,
            CardRepositoryEloquent::class
        );

        $this->app->bind(
            ExpenseRepositoryInterface::class,
            ExpenseRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
