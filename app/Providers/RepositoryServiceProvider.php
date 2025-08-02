<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\Contracts\FormRepositoryInterface;
use App\Repositories\EloquentFormRepository;
use Illuminate\Support\ServiceProvider;

/**
 * Repository Service Provider.
 *
 * Following DIP (Dependency Inversion Principle):
 * Binding interfaces to concrete implementations
 */
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FormRepositoryInterface::class, EloquentFormRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
    }
}
