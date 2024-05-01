<?php

namespace App\Services;

use App\Interfaces\SendMessageInterface;
use Illuminate\Support\Facades\Http;

class SMsService implements SendMessageInterface
{
    protected $smsProvider;

    public function __construct()
    {
        $this->smsProvider = config('services.sms.provider');
    }

    public function sendSms($phoneNumber, $message)
    {
        $url = $this->getProviderUrl();
        $response = Http::post($url, [
            'phone_number' => $phoneNumber,
            'message' => $message
        ]);
        return $response->successful();
    }

    protected function getProviderUrl()
    {
        if ($this->smsProvider === 'provider1') {
            return 'https://run.mocky.io/v3/8eb88272-d769-417c-8c5c-159bb023ec0a';
        } elseif ($this->smsProvider === 'provider2') {
            return 'https://run.mocky.io/v3/268d1ff4-f710-4aad-b455-a401966af719';
        }
    }
}
