<?php

namespace Tests\Unit\Services;

use App\Balance;
use App\Exceptions\NotEnoughBalanceException;
use App\Repositories\BalanceRepository;
use App\Services\BalanceService;
use App\User;
use Exception;
use PHPUnit\Framework\TestCase;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\ExpectationFailedException;

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

    public function testCheckShouldReturnFalseWhenBalanceUserIsNull()
    {
        $uuid = 'uueuwquiieeir';
        $amount = 100;

        $balanceRepository = $this->getMockBuilder(BalanceRepository::class)
            ->setMethods(['getBalanceByUserUuid'])
            ->disableOriginalConstructor()
            ->getMock();
        
        $balanceRepository->expects($this->once())
            ->method('getBalanceByUserUuid')
            ->with($uuid)
            ->willReturn(null);
            
        $user = new User();
        $user->uuid = $uuid;

        $service = new BalanceService($balanceRepository);
        $result = $service->check($user, $amount);

        $this->assertFalse($result);
    
    }

    public function testWithdraw()
    {
        $uuid = 'uueuwquiieeir';
        $amount = 100;

        $balanceRepository = $this->getMockBuilder(BalanceRepository::class)
            ->setMethods(['getBalanceByUserUuid','save'])
            ->disableOriginalConstructor()
            ->getMock();

        $balance = new Balance();
        $balance->balance = 50;
        
        $balanceRepository->expects($this->once())
            ->method('getBalanceByUserUuid')
            ->with($uuid)
            ->willReturn($balance);

        $balanceRepository->expects($this->once())
            ->method('save')
            ->with($balance);

        $user = new User();
        $user->uuid = $uuid;

        $service = new BalanceService($balanceRepository);
        $result = $service->withdraw($user, $amount);
    }

    public function testWithdrawShouldThrowExceptionWhenBalanceIsNull()
    {
        $this->expectException(NotEnoughBalanceException::class);

        $uuid = 'uueuwquiieeir';
        $amount = 100;

        $balanceRepository = $this->getMockBuilder(BalanceRepository::class)
            ->setMethods(['getBalanceByUserUuid','save'])
            ->disableOriginalConstructor()
            ->getMock();

        $balance = new Balance();
        $balance->balance = 50;
        
        $balanceRepository->expects($this->once())
            ->method('getBalanceByUserUuid')
            ->with($uuid)
            ->willReturn(null);

        $balanceRepository->expects($this->never())
            ->method('save')
            ->with($balance);

        $user = new User();
        $user->uuid = $uuid;

        $service = new BalanceService($balanceRepository);
        $result = $service->withdraw($user, $amount);
    }
    
    public function testDeposit()
    {
        $uuid = 'uueuwquiieeir';
        $amount = 100;

        $balanceRepository = $this->getMockBuilder(BalanceRepository::class)
            ->setMethods(['getBalanceByUserUuid','save'])
            ->disableOriginalConstructor()
            ->getMock();

        $balance = new Balance();
        $balance->balance = 50;
        
        $balanceRepository->expects($this->once())
            ->method('getBalanceByUserUuid')
            ->with($uuid)
            ->willReturn($balance);

        $balanceRepository->expects($this->once())
            ->method('save')
            ->with($balance);

        $user = new User();
        $user->uuid = $uuid;

        $service = new BalanceService($balanceRepository);
        $result = $service->deposit($user, $amount);
    }
    
    public function testDepositShouldThrowExceptionWhenBalanceIsNull()
    {
        $this->expectException(NotEnoughBalanceException::class);

        $uuid = 'uueuwquiieeir';
        $amount = 100;

        $balanceRepository = $this->getMockBuilder(BalanceRepository::class)
            ->setMethods(['getBalanceByUserUuid','save'])
            ->disableOriginalConstructor()
            ->getMock();

        $balance = new Balance();
        $balance->balance = 50;
        
        $balanceRepository->expects($this->once())
            ->method('getBalanceByUserUuid')
            ->with($uuid)
            ->willReturn(null);

        $balanceRepository->expects($this->never())
            ->method('save')
            ->with($balance);

        $user = new User();
        $user->uuid = $uuid;

        $service = new BalanceService($balanceRepository);
        $result = $service->deposit($user, $amount);
    }       
}
