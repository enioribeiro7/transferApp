<?php

namespace App\Services;

use App\User;
use App\Services\FraudCheckService;
use App\Services\BalanceService;
use App\Services\NotificationService;

class TransferService 
{

    
    public function __construct(FraudCheckService $fraudCheckService, BalanceService $balanceService, NotificationService $notificationService) 
    {
        $this->fraudCheckService = $fraudCheckService;
        $this->balanceService = $balanceService;
        $this->notificationService = $notificationService;
    }

    public function transfer(User $from, User $to, float $amount) {
        
        //check saldo
        $hasBalance = $this->balanceService->check($from, $amount);

        if ($hasBalance == false) {
            throw new \App\Exceptions\NotEnoughBalanceException('Saldo Insuficiente');
        }
        
        //service de autorização
        $authorization = $this->fraudCheckService->check($from, $to, $amount);

        if ($authorization == false) {
            
            throw new \App\Exceptions\NotAuthorizedTransferException('Transferência não Autorizada');
        }
        
        //Envia notificação
        $notification = $this->notificationService->sent($from, $to, $amount);
        
        if ($notification == false) {
            throw new \App\Exceptions\NotAuthorizedTransferException('Transferência realizada, notificação agendada');
        }

    }


}