<?php

namespace App\Services;

use App\Clients\NotificationClient;
use App\Jobs\NotificationTransferEmailJob;
use Illuminate\Support\Facades\Mail;
use App\User;

class NotificationService 
{

    public function __construct(
        NotificationClient $notificationClient,
        NotificationTransferEmailJob $notificationTransferEmailJob
    ) {
        $this->notificationClient = $notificationClient;
        $this->notificationTransferEmailJob = $notificationTransferEmailJob;
    }


    public function sent(User $from,User $to, float $amount)
    {
        $result = $this->notificationClient->sentNotification($from, $to, $amount);
        $wasSent = $result->wasSent();

        if (!$wasSent) {
            $this->notificationTransferEmailJob->trigger($from, $to, $amount);
        }

        return $wasSent;
    }
}    