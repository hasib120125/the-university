<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (Auth::guard('student')->check())
            Broadcast::routes(['middleware' => [ 'api', 'auth:student']]);
        elseif (Auth::guard('admin')->check())
            Broadcast::routes(['middleware' => [ 'api', 'auth:admin']]);

        require base_path('routes/channels.php');
        /*Broadcast::routes();

        require base_path('routes/channels.php');*/
    }
}
