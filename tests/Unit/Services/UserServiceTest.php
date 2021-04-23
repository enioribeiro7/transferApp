<?php

namespace Tests\Unit\Services;

use App\Services\UserService;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{

    public function testIsEligibleToTransferShouldReturnTrueWhenUserIsNotAShopkeeper()
    {
        $user = new User();
        $user->user_type_uuid = 'dasdsdasd';

        $repository = new UserService();
        $result = $repository->isEligibleToTransfer($user);

        $this->assertTrue($result);
    }

    public function testIsEligibleToTransferShouldReturnFalseWhenUserIsAShopkeeper()
    {
        $user = new User();
        $user->user_type_uuid = '4abc3646-9f97-49b1-ad30-eaff9b1e0eb3';

        $repository = new UserService();
        $result = $repository->isEligibleToTransfer($user);

        $this->assertfalse($result);
    }    
}
