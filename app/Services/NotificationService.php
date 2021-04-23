<?php

namespace App\Services;

use App\Clients\NotificationClient;
use App\Jobs\NotificationTransferEmailJob;
use Illuminate\Support\Facades\Mail;
use App\User;

class NotificationService 
{

    public function __construct(NotificationClient $notificationClient) {
        $this->notificationClient = $notificationClient;
    }


    public function sent(User $from,User $to, float $amount)
    {
        $result = $this->notificationClient->sentNotification($from, $to, $amount);
        $wasSent = $result->wasSent();

        if (!$wasSent) {
            $this->notify($from, $to, $amount);
        }
        
        return $wasSent;
    }
    
    protected function notify(User $from,User $to, float $amount)
    {
        NotificationTransferEmailJob::dispatch($from, $to, $amount)
            ->delay(now()->addSeconds('15'));
    }
}    