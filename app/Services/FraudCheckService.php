<?php

namespace App\Services;
use App\Clients\FraudCheckClient;
use App\User;

class FraudCheckService 
{

    public function __construct(FraudCheckClient $fraudCheckClient) 
    {
        $this->fraudCheckClient = $fraudCheckClient;
    }

    public function check(User $from, User $to, float $amount): bool
    {
        $result = $this->fraudCheckClient->checkTransfer();

        return $result->isAuthorized();
    }
}
