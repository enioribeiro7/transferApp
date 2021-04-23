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
        
        $body = $this->httpResponse->json();

        if ($this->httpResponse->status() == 200 && $body['message'] == 'Autorizado') {
            return true;
        }
        
        return false;
    }
}
