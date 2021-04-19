<?php

namespace App\Services;

use App\Clients\NotificationClient;
use App\Mail\NotificationTransferReceivedMail;
use App\Mail\NotificationTransferSentMail;
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
            Mail::send(new NotificationTransferSentMail($from, $to, $amount));
            Mail::send(new NotificationTransferReceivedMail($from, $to, $amount));
        }else {

            //Colocar na fila
            Mail::queue(new NotificationTransferSentMail($from, $to, $amount));
            Mail::queue(new NotificationTransferReceivedMail($from, $to, $amount));
        }

        return $result->wasSent();
    }
}    