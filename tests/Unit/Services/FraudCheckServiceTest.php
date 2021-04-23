<?php

namespace Tests\Unit\Services;

use App\Clients\FraudCheckClient;
use App\FraudCheck\FraudCheckResult;
use App\Services\FraudCheckService;
use App\User;
use PHPUnit\Framework\TestCase;

class FraudCheckServiceTest extends TestCase
{
    /**
     * @dataProvider checkProvider
     */
    public function testCheck($isAuthorized, $expected)
    {
        $fraudCheckResult = $this->getMockBuilder(FraudCheckResult::class)
            ->setMethods(['isAuthorized'])
            ->disableOriginalConstructor()
            ->getMock();
        $fraudCheckResult->expects($this->once())
            ->method('isAuthorized')
            ->willReturn($isAuthorized);

        $fraudCheckClient = $this->getMockBuilder(FraudCheckClient::class)
            ->setMethods(['checkTransfer'])
            ->getMock();
        $fraudCheckClient->expects($this->once())
            ->method('checkTransfer')
            ->willReturn($fraudCheckResult);
        
        $fraudCheckService = new FraudCheckService($fraudCheckClient);
        $result = $fraudCheckService->check(new User(), new User(), 0);
        $this->assertEquals($expected, $result);
    }

    public static function checkProvider(): array
    {
        return [
            'when Fraud Check Authorizes' => [true, true],
            'when Fraud Check does not Authorize' => [false, false]
        ];
    } 
}
