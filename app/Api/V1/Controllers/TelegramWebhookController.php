<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Laravel\Lumen\Routing\Controller as BaseController;

class TelegramWebhookController extends BaseController
{
    public function handle(Request $request)
    {
        $userId = $request->header('User-ID');
        $data = $request->all();
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));
        $wbhook = $telegram->getWebhookInfo();

        return response()->json(['status' => 'success']);
    }
}