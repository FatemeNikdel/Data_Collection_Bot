<?php

namespace App\Http\Traits;


trait WebhookTrait
{
    public function setWebhook($url)
    {
        file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/setWebhook?url=https://" . $url . "/voice/public/api/" . env('HASHNUMBER'));
    }

    public function setMacWebhook($url)
    {
        file_get_contents("https://api.telegram.org/bot" . env('APITOKEN') . "/setWebhook?url=https://" . $url . "/api/" . env('HASHNUMBER'));
    }

    public function getWebhook()
    {
        return file_get_contents('https://api.telegram.org/bot' . env('APITOKEN') . '/getWebhookInfo');
    }

    public function deleteWebhook()
    {
        return file_get_contents('https://api.telegram.org/bot'.env('APITOKEN').'/deleteWebhook');
    }
}
