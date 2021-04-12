<?php

namespace grigor\signup\events;

class UserSignUpConfirmed
{
    public $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }
}