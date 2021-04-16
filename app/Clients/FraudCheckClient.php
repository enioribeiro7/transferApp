<?php

namespace App\Clients;

use App\FraudCheck\FraudCheckResult;
use Illuminate\Support\Facades\Http;


class FraudCheckClient 
{
    public function checkTransfer(): FraudCheckResult
    {
        $url = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

        $response = Http::get($url);

        return new FraudCheckResult($response);
    }

}
