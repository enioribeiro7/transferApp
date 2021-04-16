<?php

namespace App\Services;

use App\User;
use App\Services\FraudCheckService;

class TransferService 
{

    
    public function __construct(FraudCheckService $fraudCheckService) 
    {
        $this->fraudCheckService = $fraudCheckService;
    }

    public function transfer(User $from, User $to, float $amount) {
        
        //cherck saldo

        //service de autorização
        $authorization = $this->fraudCheckService->check($from, $to, $amount);

        if ($authorization == true) {

            return response()->json([
                "message" => "Tranferência não autorizada"
            ], 401);

        }

/* 
        $newBalancePayer = floatval($balancePayer->balance) - floatval($request->valor);
        $balance = Balance::find($balancePayer->id);
        $balance->balance =  $newBalancePayer;
        $balance->save(); */

        $notification = $this->NotificationTransferController->sentNotification();

    }


}