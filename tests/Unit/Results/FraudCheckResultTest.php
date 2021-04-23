<?php

namespace Tests\Unit\Results;

use App\FraudCheck\FraudCheckResult;
use Illuminate\Http\Client\Response;
use PHPUnit\Framework\TestCase;

class FraudCheckResultTest extends TestCase
{
    /**
     * @dataProvider isAuthorizedProvider
     */
    public function testIsAuthorized($httpStatusCode, $message, $expected)
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

        $fraudCheckResult = new FraudCheckResult($httpResponse);
        $result = $fraudCheckResult->isAuthorized();
        $this->assertEquals($expected, $result);
    }

    public static function isAuthorizedProvider(): array
    {
        return [
            'should return true when http response is authorized' => [200, 'Autorizado', true],
            'should return false when http code is different from the expected' => [400, 'Autorizado', false],
            'should return false when http response is not authorized' => [401, 'Anything', false],
            'should return false when http message is different from the expected' => [200, 'Anything', false]
        ];
    } 
}
