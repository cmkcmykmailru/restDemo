<?php

namespace grigor\userManagement\modules\user\api;

interface UserRepositoryInterface
{
    public function findByUsernameOrEmail(string $value): ?UserInterface;
}