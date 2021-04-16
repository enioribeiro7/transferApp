<?php

namespace App\Services;
use App\Clients\FraudCheckClient;


class FraudCheckService 
{

    public function __construct(FraudCheckClient $fraudCheckClient) 
    {
        $this->fraudCheckClient = $fraudCheckClient;
    }

    public function check($from, $to, $amount): bool
    {
        $result = $this->fraudCheckClient->checkTransfer();

        return $result->isAuthorized();
    }
}
