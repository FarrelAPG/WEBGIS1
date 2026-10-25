<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Paksa HTTPS di production agar aset CSS/JS dan form termuat dengan aman
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        // Gate akses panel admin damkar (hanya user ber-role damkar)
        Gate::define('damkar', fn (User $user): bool => $user->role === 'damkar');
    }
}
