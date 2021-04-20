<?php

namespace App\Repositories;

use App\Balance;

class BalanceRepository
{
	private $balance;

	public function __construct(Balance $balance)
	{
		$this->balance = $balance;
	}

	public function getBalanceByUserUuid($uuid): float
	{

        $balance = $this->balance->where('user_uuid', $uuid)->first();
		
        return $balance->balance;
		
	}
	
	public function removeBalance($uuid, $amount): bool
	{
		$balance = $this->balance->where('user_uuid', $uuid)->first();

		$newBalance = floatval($balance->balance) - floatval($amount);
		$balance->balance = $newBalance;
		$balance->save();
		
		return true;
		
	}
	
	
	public function addBalance($uuid, $amount): bool 
	{
		$balance = $this->balance->where('user_uuid', $uuid)->first();

		$newBalance = floatval($balance->balance) + floatval($amount);
		$balance->balance = $newBalance;
		$balance->save();

		return true;

	}

}