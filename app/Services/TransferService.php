<?php

namespace App\Services;

use App\User;
use App\Services\FraudCheckService;
use App\Services\CheckBalanceService;

class TransferService 
{

    
    public function __construct(FraudCheckService $fraudCheckService, CheckBalanceService $checkBalanceService) 
    {
        $this->fraudCheckService = $fraudCheckService;
        $this->checkBalanceService = $checkBalanceService;
    }

    public function transfer(User $from, User $to, float $amount) {
        
        //check saldo
        $hasBalance = $this->checkBalanceService->check($from, $amount);

        if ($hasBalance == false) {
            throw new \App\Exceptions\NotEnoughBalanceException('Not Enough Balance');
        }

        //service de autorização
        $authorization = $this->fraudCheckService->check($from, $to, $amount);


        if ($authorization == false) {
            return response()->json([
                "message" => "Tranferência não autorizada"
            ], 401);

        }


        $notification = $this->NotificationTransferController->sentNotification();

    }


}