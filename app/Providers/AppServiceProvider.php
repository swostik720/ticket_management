<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Define gates for roles
        Gate::define('admin', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('staff', function (User $user) {
            return $user->isStaff();
        });

        Gate::define('user', function (User $user) {
            return $user->isUser();
        });

        // Define Blade directives for roles
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        Blade::if('staff', function () {
            return auth()->check() && auth()->user()->isStaff();
        });

        Blade::if('user', function () {
            return auth()->check() && auth()->user()->isUser();
        });
    }
}
