<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Api;

class TelegramServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Api::class, function () {
            return new Api(env('TELEGRAM_BOT_TOKEN'));
        });
    }
}