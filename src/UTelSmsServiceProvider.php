<?php

namespace UTel\UTelSms;

use UTel\SDK\UTel as UTelSDK;
use Illuminate\Support\ServiceProvider;
use UTel\UTelSms\Exceptions\InvalidConfiguration;

class UTelSmsServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /**
         * Bootstrap the application services.
         */
        $this->app->when(UTelSmsChannel::class)
            ->needs(UTelSDK::class)
            ->give(function () {

                $baseDomain = config('services.utelsms.baseDomain');
                $token = config('services.utelsms.token');

                if (is_null($baseDomain) || is_null($token)) {
                    throw InvalidConfiguration::configurationNotSet();
                }

                $utel = new UTelSDK(
                    $baseDomain,
                    $token
                );

                return $utel;
            });
    }

    /**
     * Register the application services.
     */
    public function register()
    {

    }

}
