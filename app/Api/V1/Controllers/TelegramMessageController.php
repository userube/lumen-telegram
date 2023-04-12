<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Laravel\Lumen\Routing\Controller as BaseController;

class TelegramMessageController extends BaseController
{
    /**
     * Send a message to a specific user.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    
    /**
     * @OA\Get(
     *     path="/api/v1/send-message-to-user",
     *     summary="Send message to a user",
     *     description="Send message to a user",
     *     operationId="sendMessageToUser",
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
     * 
     */

    public function sendMessageToUser(Request $request)
    {
        $userId = $request->header('User-ID');
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $chatId = $request->input('chat_id');
        $message = $request->input('message');

        try {
            $response = $telegram->sendMessage([
                'chat_id' => $chatId,
                'text' => $message,
            ]);
            return response()->json(['success' => true, 'message' => 'Message sent successfully.', 'response' => $response]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error sending message.', 'error' => $e->getMessage()]);
        }
    }

    /**
     * Send a message to a channel.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    */

    public function sendMessageToChannel(Request $request)
    {
        $userId = $request->header('User-ID');
        $telegram = new Api(env('TELEGRAM_BOT_TOKEN'));

        $channelUsername = $request->input('channel_username');
        $message = $request->input('message');

        try {
            $response = $telegram->sendMessage([
                'chat_id' => '@' . $channelUsername,
                'text' => $message,
            ]);
            return response()->json(['success' => true, 'message' => 'Message sent successfully.', 'response' => $response]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error sending message.', 'error' => $e->getMessage()]);
        }
    }
}