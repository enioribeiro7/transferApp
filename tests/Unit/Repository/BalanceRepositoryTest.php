<?php

namespace Tests\Unit\Repository;

use App\Repositories\BalanceRepository;
use PHPUnit\Framework\TestCase;
use App\Balance;
use Illuminate\Database\Eloquent\Collection;
use stdClass;

class BalanceRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testGetBalanceByUserUuidShouldReturnNullWhenBalanceNotFound()
    {
        
        $uuid = 'erwrwerwrwer';
        $collection = new Collection([]);
        
        $balance = $this->getMockBuilder(Balance::class)
            ->setMethods(['where'])
            ->getMock();


        $balance->expects($this->once())
            ->method('where')
            ->with('user_uuid', $uuid)
            ->willReturn($collection);

        $repository = new BalanceRepository($balance);
        $result = $repository->getBalanceByUserUuid($uuid);
                
        $this->assertNull($result);
    }

    public function testGetBalanceByUserUuidShouldReturnBalanceWhenBalanceFound()
    {
        
        $uuid = 'erwrwerwrwer';
        $balance = $this->getMockBuilder(Balance::class)
            ->setMethods(['where'])
            ->getMock();

        $foundBalance = new Balance();
        $collection = new Collection([$foundBalance]);

        $balance->expects($this->once())
            ->method('where')
            ->with('user_uuid', $uuid)
            ->willReturn($collection);

        $repository = new BalanceRepository($balance);
        $result = $repository->getBalanceByUserUuid($uuid);

        $this->assertSame($foundBalance, $result);
    }
}
