<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Validator::extend('string_space', function($attribute, $value, $parameters, $validator) {
            if(preg_match("/^[A-ZñÑ ]*$/i",$value)) {
                return true;
            } else {
                return false;
            }
        });

        \Validator::extend('nick', function($attribute, $value, $parameters, $validator) {
            if(preg_match("/^[a-z0-9]*$/",$value)) {
                return true;
            } else {
                return false;
            }
        });
    }
}
