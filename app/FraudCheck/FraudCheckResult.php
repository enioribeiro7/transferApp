<?php

namespace App\FraudCheck;

use Illuminate\Http\Response;

class FraudCheckResult 
{
    protected $httpResponse;

    public function __construct (Response $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    public function isAuthorized(): bool
    {
        $this->payLoad->status;
        $body = json_decode($this->payLoad->getBody());

        if ($this->payLoad->status == 200 && $body['message'] == 'Enviado') {
            return true;
        }
        
        return false;
    }
}
