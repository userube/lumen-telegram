<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @SWG\Swagger(
 *     schemes={"http"},
 *     host="localhost:8000",
 *     basePath="/api/v1",
 *     @SWG\Info(
 *         version="1.0",
 *         title="Communication Service",
 *         description="Telegram Channel",
 *         @SWG\Contact(name="Samuel Erube ", email="skwarus@yahoo.com"),
 *     ),
 * )
 */
class SubscriptionController extends BaseController
{
    /**
     * @OA\Get(
     *     path="/api/v1/subscribe",
     *     summary="Subscribe to bot",
     *     description="Subscribe to bot",
     *     operationId="subscribe",
     *     tags={"Telegram"},
     *     security={{"api_key": {}}},
     *     @OA\Parameter(
     *         name="User-ID",
     *         in="header",
     *         required=true,
     *         description="User ID",
     *         schema={"type": "integer"}
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *     )
     * )
    */
    public function subscribe(Request $request)
    {
        // Get the user's chat ID from the request
        $userId = $request->header('User-ID');
        $chatId = $request->input('chat_id');

        // Create a new Telegram API instance
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        // Send a message to the user to confirm their subscription
        $telegram->sendMessage([
            'chat_id' => $chatId,
            'text' => 'Thank you for subscribing to our chat bot!'
        ]);

        // Return a success response
        return response()->json([
            'success' => true,
            'message' => 'User subscribed successfully'
        ]);
    }
}