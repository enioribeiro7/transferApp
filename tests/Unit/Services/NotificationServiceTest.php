<?php

namespace Tests\Unit\Services;

use App\Clients\NotificationClient;
use App\Jobs\NotificationTransferEmailJob;
use App\Notification\NotificationResult;
use App\Services\NotificationService;
use App\User;
use PHPUnit\Framework\TestCase;

class NotificationServiceTest extends TestCase
{

    public function testSentShouldReturnTrueWhenNotificationWasSent()
    {
        $amount = 100;
        $from = new User();
        $to = new User();

        $notificationResult = $this->getMockBuilder(NotificationResult::class)
            ->setMethods(['wasSent'])
            ->disableOriginalConstructor()
            ->getMock();
        $notificationResult->expects($this->once())
            ->method('wasSent')
            ->willReturn(true);

        $notificationClient = $this->getMockBuilder(NotificationClient::class)
            ->setMethods(['sentNotification'])
            ->getMock();
        $notificationClient->expects($this->once())
            ->method('sentNotification')
            ->with($from, $to, $amount)
            ->willReturn($notificationResult);

        $notificationTransferEmailJob = $this->getMockBuilder(NotificationTransferEmailJob::class)
            ->setMethods(['trigger'])
            ->disableOriginalConstructor()
            ->getMock();
        $notificationTransferEmailJob->expects($this->never())
            ->method('trigger')
            ->with($from, $to, $amount);
            
        $notificationService = new NotificationService($notificationClient, $notificationTransferEmailJob);
        $result = $notificationService->sent($from, $to, $amount);

        $this->assertEquals(true, $result);
    }

    public function testSentShouldReturnFalseWhenNotificationWasNotSent()
    {
        $amount = 100;
        $from = new User();
        $to = new User();

        $notificationResult = $this->getMockBuilder(NotificationResult::class)
            ->setMethods(['wasSent'])
            ->disableOriginalConstructor()
            ->getMock();
        $notificationResult->expects($this->once())
            ->method('wasSent')
            ->willReturn(false);

        $notificationClient = $this->getMockBuilder(NotificationClient::class)
            ->setMethods(['sentNotification'])
            ->getMock();
        $notificationClient->expects($this->once())
            ->method('sentNotification')
            ->with($from, $to, $amount)
            ->willReturn($notificationResult);

        $notificationService = $this->getMockBuilder(NotificationService::class)
            ->setMethods(['notify'])
            ->setConstructorArgs([$notificationClient])
            ->getMock();
        $notificationService->expects($this->once())
            ->method('notify')
            ->with($from, $to, $amount);
    
        $result = $notificationService->sent($from, $to, $amount);

        $this->assertEquals(false, $result);

    }
  
}
