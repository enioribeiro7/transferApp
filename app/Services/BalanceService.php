<?php

namespace App\Services;

use App\Repositories\BalanceRepository;

class BalanceService 
{

    public function __construct(BalanceRepository $balanceRepository) 
    {
        $this->balanceRepository = $balanceRepository;
    }


    public function check($from, $amount): bool
    {

        //chama o repositorio para devolver o saldo do cliente
        $balanceUser = $this->balanceRepository->getBalanceByUserUuid($from->uuid);
        
        //faz operação para saber se tem saldo
        if (floatval($balanceUser) >= floatval($amount)) {
            return true;
        }
        
        return false;
        
    }
    
    public function remove($from, $amount): bool
    {
        $balanceUser = $this->balanceRepository->removeBalance($from->uuid, $amount);
        
        return true;
    }
    
    public function add($to, $amount): bool
    {
        $balanceUser = $this->balanceRepository->addBalance($to->uuid, $amount);

        return true;
    }
}
