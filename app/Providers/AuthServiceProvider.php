<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            if (Auth::user()->is_admin == Config::get('constants.USER.ADMIN')) {
                return true;
            }
        });
        Gate::define('update-post', 'PostPolicy@update');
        Gate::define('delete-post', 'PostPolicy@delete');
        Gate::define('view-post', 'PostPolicy@view');
    }
}
