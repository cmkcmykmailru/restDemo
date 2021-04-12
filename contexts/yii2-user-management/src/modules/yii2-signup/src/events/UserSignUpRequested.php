<?php

namespace grigor\signup\events;

class UserSignUpRequested
{
    public $userId;

    /**
     * UserSignUpRequested constructor.
     * @param $user
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

}