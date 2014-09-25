<?php namespace Picardi;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        require 'routes.php';
    }

    public function register()
    {
    }
}
