<?php

namespace App\Services;

use App\Clients\NotificationClient;

class NotificationService 
{

    public function __construct(NotificationClient $notificationClient) 
    {
        $this->notificationClient = $notificationClient;
    }


    public function sent($from, $to, $amount)
    {
        $result = $this->notificationClient->sentNotification($from, $to, $amount);

        return $result->wasSent();
    }
}    