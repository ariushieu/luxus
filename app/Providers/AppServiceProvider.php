<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\SettingRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ProjectRepositoryInterface;
use App\Interfaces\ProjectImageRepositoryInterface;
use App\Interfaces\BookingRepositoryInterface;
use App\Interfaces\QuoteRepositoryInterface;
use App\Repositories\SettingRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\ProjectImageRepository;
use App\Repositories\BookingRepository;
use App\Repositories\QuoteRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Repository Interfaces with their Implementations
        $this->app->bind(SettingRepositoryInterface::class, SettingRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
        $this->app->bind(ProjectImageRepositoryInterface::class, ProjectImageRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(QuoteRepositoryInterface::class, QuoteRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
