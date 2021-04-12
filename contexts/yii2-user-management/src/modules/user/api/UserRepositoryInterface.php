<?php

namespace grigor\userManagement\modules\user\api;

use grigor\userManagement\modules\user\api\dto\UserDto;

interface UserRepositoryInterface
{
    public function findByUsernameOrEmail(string $value): ?UserInterface;

    public function get(string $id): UserInterface;

    public function save(UserInterface $user): void;

    public function remove(UserInterface $post): void;
}