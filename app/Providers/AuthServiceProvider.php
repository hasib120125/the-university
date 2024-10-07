<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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

        Auth::resolveUsersUsing(function ($guard = null) {
            if( is_null($guard) ){
                if(Auth::guard('student')->check()) return Auth::guard('student')->user();
                else if( Auth::guard('admin')->check()) return Auth::guard('admin')->user();
            }
            return Auth::guard($guard)->user();
        });
    }
}
