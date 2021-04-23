<?php

namespace App\Services;

use App\User;
use App\Services\FraudCheckService;
use App\Services\BalanceService;
use App\Services\NotificationService;
use App\Services\userService;
use Illuminate\Support\Facades\DB;

class TransferService 
{

    
    public function __construct(
        FraudCheckService $fraudCheckService, 
        BalanceService $balanceService,
        NotificationService $notificationService,
        UserService $userService
    ) {
        $this->fraudCheckService = $fraudCheckService;
        $this->balanceService = $balanceService;
        $this->notificationService = $notificationService;
        $this->userService = $userService;
    }

    public function transfer(User $from, User $to, float $amount) {
        
        if($this->userService->isEligibleToTransfer($from)){
            throw new \App\Exceptions\NotElegibleToTransferException('Payer not allowed to tranfer!');
        }
        
        $hasBalance = $this->balanceService->check($from, $amount);
        if (!$hasBalance) {
            throw new \App\Exceptions\NotEnoughBalanceException('Not Balance Suficient');
        }
          
        //service de autorização
        $isAuthorized = $this->fraudCheckService->check($from, $to, $amount);

        if (!$isAuthorized) {
            throw new \App\Exceptions\NotAuthorizedTransferException('Transfer not Allowed');
        }
       
        try {
            $this->beginTransaction();
            $this->balanceService->withdraw($from, $amount);
            $this->balanceService->deposit($to, $amount);
            $this->commit();
        } catch (\Throwable $exception) {            
            $this->rollBack();
            throw $exception;
        }

        
        $notification = $this->notificationService->sent($from, $to, $amount);
        
        if ($notification == false) {
            throw new \App\Exceptions\NotificationTransferException('Transfer success, notification Scheduled');
        }

        return true;

    }

    protected function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    protected function commit(): void
    {
        DB::commit();
    }

    protected function rollBack(): void
    {
        DB::rollBack();
    }      
}