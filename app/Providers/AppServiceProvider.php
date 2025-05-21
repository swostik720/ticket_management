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

        Gate::define('head_of_department', function (User $user) {
            return $user->isHeadOfDepartment();
        });

        Gate::define('staff', function (User $user) {
            return $user->isStaff();
        });

        Gate::define('head_office_staff', function (User $user) {
            return $user->isHeadOfficeStaff();
        });

        Gate::define('assign_tickets', function (User $user) {
            return $user->canAssignTickets();
        });

        // Define Blade directives for roles
        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->isAdmin();
        });

        Blade::if('headofdepartment', function () {
            return auth()->check() && auth()->user()->isHeadOfDepartment();
        });

        Blade::if('staff', function () {
            return auth()->check() && auth()->user()->isStaff();
        });

        Blade::if('headofficestaff', function () {
            return auth()->check() && auth()->user()->isHeadOfficeStaff();
        });

        Blade::if('canassigntickets', function () {
            return auth()->check() && auth()->user()->canAssignTickets();
        });
    }
}
