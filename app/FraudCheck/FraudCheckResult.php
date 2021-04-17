<?php

namespace App\FraudCheck;

use Illuminate\Http\Client\Response;

class FraudCheckResult 
{
    protected $httpResponse;

    public function __construct (Response $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    public function isAuthorized(): bool
    {
        
        $body = json_decode($this->httpResponse);

        if ($this->httpResponse->status() == 200 && $body->message == 'Autorizado') {
            return true;
        }
        
        return false;
    }
}
