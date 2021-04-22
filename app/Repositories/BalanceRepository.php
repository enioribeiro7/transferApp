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

	public function getBalanceByUserUuid(string $uuid): ?Balance
	{
        $collection = $this->balance->where('user_uuid', $uuid);

        return $collection->first();
	}
	
	public function save(Balance $balance): void
	{
		$balance->save();
	}

}