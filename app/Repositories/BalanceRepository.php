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

}