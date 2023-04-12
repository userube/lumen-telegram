<?php

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    $router->post('/subscribe', 'SubscriptionController@subscribe');
    $router->post('/send-message-to-user', 'TelegramMessageController@sendMessageToUser');
    $router->post('/send-message-to-channel', 'TelegramMessageController@sendMessageToChannel');
    $router->post('/subscribe-user', 'TelegramSubscriptionController@subscribe');
    $router->post('/webhooks/telegram', 'TelegramWebhookController@handle');
});