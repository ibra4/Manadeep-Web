<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Gate::define('manage-website', function ($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-estates', function ($user) {
            return $user->hasAnyRoles(['provider', 'admin']);
        });

        Gate::define('test', function ($user) {
            return $user->hasAnyRoles(['user', 'admin']);
        });
    }
}
