<?php

namespace App\Services;

use App\Clients\NotificationClient;
use App\Jobs\NotificationTransferEmailJob;
use Illuminate\Support\Facades\Mail;

class NotificationService 
{

    public function __construct(NotificationClient $notificationClient) 
    {
        $this->notificationClient = $notificationClient;
    }


    public function sent($from, $to, $amount)
    {
        $result = $this->notificationClient->sentNotification($from, $to, $amount);

        if ($result->wasSent() != true) {

            NotificationTransferEmailJob::dispatch($from, $to, $amount)->delay( now()->addSeconds('15'));
        }

        return $result->wasSent();
    }
}    