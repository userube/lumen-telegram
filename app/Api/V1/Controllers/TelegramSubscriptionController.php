<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Swagger(
 *     schemes={"http"},
 *     host="localhost:8000",
 *     basePath="/api/v1",
 *     @OA\Info(
 *         version="1.0",
 *         title="Telegram Subscription",
 *         description="Telegram Channel",
 *         @OA\Contact(name="Samuel Erube", email="skwarus@yahoo.com"),
 *     ),
 * )
 */
class TelegramSubscriptionController extends BaseController
{
    /**
     * Subscribe a user to a Telegram channel or chat.
     *
     * @param Request $request
     * @return mixed
     */

     /**
     * @OA\Post(
     *     path="/api/v1/subscribe",
     *     summary="Subscribe user to chat bot",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             required={"chat_id"},
     *             @OA\Property(property="chat_id", type="integer", example="1234567890", description="Unique chat ID of user"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Successful operation",
     *     ),
     *     @OA\Parameter(
     *         name="User-ID",
     *         in="header",
     *         description="User ID",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     )
     * )
     */

    public function subscribe(Request $request)
    {
        $userId = $request->header('User-ID');
        $chatId = $request->input('chat_id');
        $username = $request->input('username');

        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        try {
            $result = $telegram->getChatMember($chatId, $username);
        } catch (\Exception $e) {
            // Handle exception
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        if ($result->isOk() && $result->isMember()) {
            // User is already a member
            return response()->json([
                'status' => 'success',
                'message' => 'User is already subscribed to the chat/channel',
            ]);
        }

        try {
            $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => 'Please click on the following link to join the chat/channel: t.me/' . $username,
            ]);
        } catch (\Exception $e) {
            // Handle exception
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Please check your Telegram messages for instructions on how to subscribe',
        ]);
    }
}