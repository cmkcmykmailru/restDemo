<?php

namespace grigor\userManagement\modules\user\events;

class UserLoggedIn
{
    public string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }
}