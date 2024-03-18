<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $code = 401;
            $message = 'Unauthorized';
            $data = null;

            if ($request->input('api_token') && $data = User::where('api_token', $request->input('api_token'))->first()) {
                $code = 200;
                $message = 'success';
            }

            return response()->json([
                'code' => $code,
                'message' => $message,
                'data' => $data
            ]);
        });
    }
}
