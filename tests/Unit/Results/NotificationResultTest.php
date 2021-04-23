<?php

namespace Tests\Unit\Results;   

use App\Notification\NotificationResult;
use Illuminate\Http\Client\Response;
use PHPUnit\Framework\TestCase;

class NotificationResultTest extends TestCase
{
    /**
     * @dataProvider wasSentProvider
     */

    public function testWasSent($httpStatusCode, $message, $expected)
    {
        $httpResponse = $this->getMockBuilder(Response::class)
            ->setMethods(['json', 'status'])
            ->disableOriginalConstructor()
            ->getMock();
        $httpResponse->expects($this->once())
            ->method('json')
            ->willReturn(['message' => $message]);
        $httpResponse->expects($this->once())
            ->method('status')
            ->willReturn($httpStatusCode);

        $fraudCheckResult = new NotificationResult($httpResponse);
        $result = $fraudCheckResult->wasSent();
        $this->assertEquals($expected, $result);
    }

    public static function wasSentProvider(): array
    {
        return [
            'should return true when http response is authorized' => [200, 'Enviado', true],
            'should return false when http code is different from the expected' => [400, 'Enviado', false],
            'should return false when http response is not authorized' => [401, 'Anything', false],
            'should return false when http message is different from the expected' => [200, 'Anything', false]
        ];
    }    
}