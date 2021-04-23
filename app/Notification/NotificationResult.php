<?php

namespace App\Notification;

use Illuminate\Http\Client\Response;

class NotificationResult 
{
    protected $httpResponse;

    public function __construct (Response $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    public function wasSent(): bool
    {
        
        $body = $this->httpResponse->json();

        if ($this->httpResponse->status() == 200 && $body['message'] == 'Enviado') {
            return true;
        }
        
        return false;
    }
}
