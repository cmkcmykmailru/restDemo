<?php

namespace grigor\signup\api;

use grigor\signup\api\dto\SignUpDto;
use grigor\userManagement\modules\user\api\UserRepositoryInterface;

interface SignupRepositoryInterface extends UserRepositoryInterface
{
    public function getByEmailConfirmToken(string $token): SignupUserInterface;

    public function createUser(SignUpDto $dto): SignupUserInterface;
}