<?php

namespace App\Jobs;

use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TelegramGetUpdates
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $telegramBotApi = \Cache::remember(
            'telegramBotApi',
            360,
            function () {
                $resource = \TwillAppSettings::getGroupDataForSectionAndName('resource', 'resource')->content;

                return isset($resource['telegram_bot_api']) ? $resource['telegram_bot_api'] : false;
            }
        );

        if ($telegramBotApi) {
            $client = new \GuzzleHttp\Client;
            $response = $client->post(
                "https://api.telegram.org/bot{$telegramBotApi}/getUpdates"
            );
            $response = json_decode($response->getBody(), true);

            if (isset($response['ok']) && $response['ok']) {
                $bot = explode(':', $telegramBotApi)[0];

                foreach ($response['result'] as $message) {
                    if(isset($message['message'])) {
                        $chat_id = $message['message']['chat']['id'];
                        $username = $message['message']['chat']['username'];

                        \App\Models\TelegramChatUser::firstOrCreate(
                            [
                                'username' => $username,
                                'chat_id' => $chat_id,
                                'bot' => $bot,
                            ]
                        );
                    }
                }
            }

        }
    }
}
