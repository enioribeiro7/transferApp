<?php

namespace App\Services;

use App\Exceptions\NotEnoughBalanceException;
use App\Repositories\BalanceRepository;
use App\User;

class BalanceService 
{

    public function __construct(BalanceRepository $balanceRepository) 
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function check(User $from, float $amount): bool
    {
        $balanceUser = $this->balanceRepository->getBalanceByUserUuid($from->uuid);
        
        if (floatval($balanceUser->balance) >= floatval($amount)) {
            return true;
        }
        
        return false;
    }
    
    public function withdraw(User $from, float $amount): void
    {
        $balance = $this->balanceRepository->getBalanceByUserUuid($from->uuid);
        
        if($balance == null){
            throw new NotEnoughBalanceException('Not Balance Suficient for withdraw');
        }
        
        $balance->balance = floatval($balance->balance) - $amount;
        $this->balanceRepository->save($balance);
    }
    
    public function deposit(User $to, float $amount): void
    {
        $balance = $this->balanceRepository->getBalanceByUserUuid($to->uuid);
        
        if($balance == null){
            throw new NotEnoughBalanceException('Not Balance Suficient for Deposit');
        }

        $balance->balance = floatval($balance->balance) + $amount;
        $this->balanceRepository->save($balance);
    }
}
