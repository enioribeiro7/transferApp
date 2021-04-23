<?php

namespace Tests\Unit\Services;

use App\Balance;
use App\Repositories\BalanceRepository;
use App\Services\BalanceService;
use App\User;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;

class BalanceServiceTest extends TestCase
{
    public function testCheckShouldReturnTrueWhenBalanceUserIsGreaterThanOrEqualToAmountTranfer()
    {
        $uuid = 'uueuwquiieeir';
        $amount = 100;

        $balanceRepository = $this->getMockBuilder(BalanceRepository::class)
            ->setMethods(['getBalanceByUserUuid'])
            ->disableOriginalConstructor()
            ->getMock();

        $balance = new Balance();
        $balance->balance = 100;
        
        $balanceRepository->expects($this->once())
            ->method('getBalanceByUserUuid')
            ->with($uuid)
            ->willReturn($balance);
            
        $user = new User();
        $user->uuid = $uuid;

        $service = new BalanceService($balanceRepository);
        $result = $service->check($user, $amount);

        $this->assertTrue($result);
    
    }

    public function testCheckShouldReturnTrueWhenBalanceUserIsLessThanAmountTranfer()
    {
        $uuid = 'uueuwquiieeir';
        $amount = 100;

        $balanceRepository = $this->getMockBuilder(BalanceRepository::class)
            ->setMethods(['getBalanceByUserUuid'])
            ->disableOriginalConstructor()
            ->getMock();

        $balance = new Balance();
        $balance->balance = 50;
        
        $balanceRepository->expects($this->once())
            ->method('getBalanceByUserUuid')
            ->with($uuid)
            ->willReturn($balance);
            
        $user = new User();
        $user->uuid = $uuid;

        $service = new BalanceService($balanceRepository);
        $result = $service->check($user, $amount);

        $this->assertFalse($result);
    
    }

}
