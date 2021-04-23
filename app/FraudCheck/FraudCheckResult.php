<?php

namespace App\FraudCheck;

use Illuminate\Http\Client\Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

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

        if ($this->httpResponse->status() === HttpFoundationResponse::HTTP_OK && $body['message'] == 'Autorizado') {
            return true;
        }
        
        return false;
    }
}
