<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\BaseRepositoryInterface;
use App\Repositories\Eloquent\BaseEloquentRepository;
use App\Repositories\Eloquent\PasienRepository;
use App\Models\Pasien;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bindings will be added here
        $this->app->bind(PasienRepository::class, function ($app) {
            return new PasienRepository(new Pasien());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
