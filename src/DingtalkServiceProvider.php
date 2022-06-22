<?php

namespace Buoor\Dingtalk;

use Illuminate\Support\ServiceProvider;

class DingtalkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/dingtalk.php', 'dingtalk');
        $this->app->singleton('buoor_dingtalk', function () {
            return new Dingtalk();
        });
    }

    public function boot()
    {
        // $this->publishes([
        //     __DIR__ . '' => config_path('dingtalk.php')
        // ]);
    }
}
