<?php

namespace App\Interfaces;

interface SendMessageInterface
{
    public function sendSms($phoneNumber, $message);
}

