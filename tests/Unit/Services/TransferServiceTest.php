<?php

namespace Tests\Unit\Services;

use App\Exceptions\NotAuthorizedTransferException;
use App\Exceptions\NotElegibleToTransferException;
use App\Exceptions\NotEnoughBalanceException;
use App\Exceptions\NotificationTransferException;
use App\Services\BalanceService;
use App\Services\FraudCheckService;
use App\Services\NotificationService;
use App\Services\TransferService;
use App\Services\UserService;
use App\User;
use PHPUnit\Framework\TestCase;
use Throwable;

class TransferServiceTest extends TestCase
{
    
    public function testTransferShouldReturnExceptionWhenUserIsNotEligible()
    {
        $this->expectException(NotElegibleToTransferException::class);
        $from = new User();
        $to = new User();
        $amount = 150.00;
        
        
        $fraudCheckService = $this->getMockBuilder(FraudCheckService::class)
        ->setMethods(['check'])
        ->disableOriginalConstructor()
        ->getMock();
        $fraudCheckService->expects($this->never())
        ->method('check')
        ->with($from, $to, $amount)
        ->willReturn(true);
        
        $balanceService = $this->getMockBuilder(BalanceService::class)
        ->setMethods(['check'])
        ->disableOriginalConstructor()
        ->getMock();
        $balanceService->expects($this->never())
        ->method('check')
        ->with($from, $amount)
        ->willReturn(true);
        
        $notificationService = $this->getMockBuilder(NotificationService::class)
        ->setMethods(['sent'])
        ->disableOriginalConstructor()
        ->getMock();
        $notificationService->expects($this->never())        
        ->method('sent')
        ->with($from, $to, $amount)
        ->willReturn(true);
        
        $userService = $this->getMockBuilder(UserService::class)
            ->setMethods(['isEligibleToTransfer'])
            ->disableOriginalConstructor()
            ->getMock();
        $userService->expects($this->once())
            ->method('isEligibleToTransfer')
            ->with($from)
            ->willReturn(true);

        $transferService = new TransferService($fraudCheckService, $balanceService, $notificationService, $userService);
        $transferService->transfer($from, $to, $amount);
    
    }

    public function testTransferShouldReturnExceptionWhenUserDoesNotHaveBalance()
    {
        $this->expectException(NotEnoughBalanceException::class);
        $from = new User();
        $to = new User();
        $amount = 150.00;
        
        
        $fraudCheckService = $this->getMockBuilder(FraudCheckService::class)
            ->setMethods(['check'])
            ->disableOriginalConstructor()
            ->getMock();
        $fraudCheckService->expects($this->never())
            ->method('check')
            ->with($from, $to, $amount)
            ->willReturn(true);
        
        $balanceService = $this->getMockBuilder(BalanceService::class)
            ->setMethods(['check'])
            ->disableOriginalConstructor()
            ->getMock();
        $balanceService->expects($this->once())
            ->method('check')
            ->with($from, $amount)
            ->willReturn(false);
        
        $notificationService = $this->getMockBuilder(NotificationService::class)
            ->setMethods(['sent'])
            ->disableOriginalConstructor()
            ->getMock();
        $notificationService->expects($this->never())        
            ->method('sent')
            ->with($from, $to, $amount)
            ->willReturn(true);
            
        $userService = $this->getMockBuilder(UserService::class)
            ->setMethods(['isEligibleToTransfer'])
            ->disableOriginalConstructor()
            ->getMock();
        $userService->expects($this->once())
            ->method('isEligibleToTransfer')
            ->with($from)
            ->willReturn(false);

        $transferService = new TransferService($fraudCheckService, $balanceService, $notificationService, $userService);
        $transferService->transfer($from, $to, $amount);
    
    }

    public function testTransferShouldReturnExceptionWhenTransferIsNotAuthorized()
    {
        $this->expectException(NotAuthorizedTransferException::class);
        $from = new User();
        $to = new User();
        $amount = 150.00;
        
        
        $fraudCheckService = $this->getMockBuilder(FraudCheckService::class)
            ->setMethods(['check'])
            ->disableOriginalConstructor()
            ->getMock();
        $fraudCheckService->expects($this->once())
            ->method('check')
            ->with($from, $to, $amount)
            ->willReturn(false);
        
        $balanceService = $this->getMockBuilder(BalanceService::class)
            ->setMethods(['check'])
            ->disableOriginalConstructor()
            ->getMock();
        $balanceService->expects($this->once())
            ->method('check')
            ->with($from, $amount)
            ->willReturn(true);
        
        $notificationService = $this->getMockBuilder(NotificationService::class)
            ->setMethods(['sent'])
            ->disableOriginalConstructor()
            ->getMock();
        $notificationService->expects($this->never())        
            ->method('sent')
            ->with($from, $to, $amount)
            ->willReturn(true);
            
        $userService = $this->getMockBuilder(UserService::class)
            ->setMethods(['isEligibleToTransfer'])
            ->disableOriginalConstructor()
            ->getMock();
        $userService->expects($this->once())
            ->method('isEligibleToTransfer')
            ->with($from)
            ->willReturn(false);

        $transferService = new TransferService($fraudCheckService, $balanceService, $notificationService, $userService);
        $transferService->transfer($from, $to, $amount);
    
    }

    public function testTransferShouldReturnExceptionWhenHaveSomeErrorInDataBaseTransaction()
    {
        $this->expectException(Throwable::class);
        $from = new User();
        $to = new User();
        $amount = 150.00;
        
        $emptyFrom = new User();
        
        $fraudCheckService = $this->getMockBuilder(FraudCheckService::class)
            ->setMethods(['check'])
            ->disableOriginalConstructor()
            ->getMock();
        $fraudCheckService->expects($this->once())
            ->method('check')
            ->with($from, $to, $amount)
            ->willReturn(true);
        
        $balanceService = $this->getMockBuilder(BalanceService::class)
            ->setMethods(['check','withdraw','deposit'])
            ->disableOriginalConstructor()
            ->getMock();
        $balanceService->expects($this->once())
            ->method('check')
            ->with($from, $amount)
            ->willReturn(true);
        $balanceService->expects($this->never())
            ->method('withdraw')
            ->with($emptyFrom, $amount);
        $balanceService->expects($this->never())
            ->method('deposit')
            ->with($emptyFrom, $amount);            
        
        $notificationService = $this->getMockBuilder(NotificationService::class)
            ->setMethods(['sent'])
            ->disableOriginalConstructor()
            ->getMock();
        $notificationService->expects($this->never())        
            ->method('sent')
            ->with($from, $to, $amount)
            ->willReturn(false);
            
        $userService = $this->getMockBuilder(UserService::class)
            ->setMethods(['isEligibleToTransfer'])
            ->disableOriginalConstructor()
            ->getMock();
        $userService->expects($this->once())
            ->method('isEligibleToTransfer')
            ->with($from)
            ->willReturn(false);

        $transferService = new TransferService($fraudCheckService, $balanceService, $notificationService, $userService);
        $transferService->transfer($from, $to, $amount);
    
    }
    
    public function testTransferShouldReturnExceptionWhenNotificationWasNotSent()
    {
        $this->expectException(NotificationTransferException::class);

        $from = new User();
        $to = new User();
        $amount = 150.00;
        
        $emptyFrom = new User();
        
        $fraudCheckService = $this->getMockBuilder(FraudCheckService::class)
            ->setMethods(['check'])
            ->disableOriginalConstructor()
            ->getMock();
        $fraudCheckService->expects($this->once())
            ->method('check')
            ->with($from, $to, $amount)
            ->willReturn(true);
        
        $balanceService = $this->getMockBuilder(BalanceService::class)
            ->setMethods(['check','withdraw','deposit'])
            ->disableOriginalConstructor()
            ->getMock();
        $balanceService->expects($this->once())
            ->method('check')
            ->with($from, $amount)
            ->willReturn(true);
        $balanceService->expects($this->once())
            ->method('withdraw')
            ->with($from, $amount);
        $balanceService->expects($this->once())
            ->method('deposit')
            ->with($from, $amount);            
        
        $notificationService = $this->getMockBuilder(NotificationService::class)
            ->setMethods(['sent'])
            ->disableOriginalConstructor()
            ->getMock();
        $notificationService->expects($this->once())        
            ->method('sent')
            ->with($from, $to, $amount)
            ->willReturn(false);
            
        $userService = $this->getMockBuilder(UserService::class)
            ->setMethods(['isEligibleToTransfer'])
            ->disableOriginalConstructor()
            ->getMock();
        $userService->expects($this->once())
            ->method('isEligibleToTransfer')
            ->with($from)
            ->willReturn(false);

        $transferService = $this->getMockBuilder(TransferService::class)
            ->setConstructorArgs([$fraudCheckService, $balanceService, $notificationService, $userService])
            ->setMethods(['beginTransaction', 'commit', 'rollBack'])
            ->getMock();
        $transferService->expects($this->once())
            ->method('beginTransaction');
        $transferService->expects($this->once())
            ->method('commit');
        $transferService->expects($this->never())
            ->method('rollback');

        $transferService->transfer($from, $to, $amount);
    
    }
}
