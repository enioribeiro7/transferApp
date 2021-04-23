<?php

namespace App\Services;

use App\User;

class UserService {

    protected const USER_UUID_SHOPKEEPER = '4abc3646-9f97-49b1-ad30-eaff9b1e0eb3';

    public function isEligibleToTransfer(User $user): bool
    {
        return $user->user_type_uuid !== self::USER_UUID_SHOPKEEPER;
    }
}