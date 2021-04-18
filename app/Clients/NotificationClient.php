<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;
use App\Notification\NotificationResult;



class NotificationClient 
{
    public function sentNotification($from, $to, $amount): NotificationResult
    {
        $url = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04?from='.$from->uuid.'&to='.$to->uuid.'&amount='.$amount;

        $response = Http::get($url);

        return new NotificationResult($response);
    }

}
