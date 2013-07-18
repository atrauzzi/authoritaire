<?php namespace Atrauzzi\Authoritaire;

use Illuminate\Support\ServiceProvider;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Auth\Guard;

class ServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot() {

        $this->package('atrauzzi/authoritaire');

        \Auth::extend('verify', function() {
            return new Guard(
                new VerifyUserProvider(
                    new BcryptHasher,
                    \Config::get('auth.model')
                ),
                \App::make('session')
            );
        });

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [];
    }

}