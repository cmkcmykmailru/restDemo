<?php

namespace grigor\userManagement;

use grigor\library\contexts\ContractInterface;
use grigor\userManagement\modules\user\api\UserInterface;
use grigor\userManagement\services\forms\LoginForm;

interface UserManagementContract extends ContractInterface
{
    public function findActiveUserById(string $id): ?UserInterface;

    public function findActiveUserByUsername(string $username): ?UserInterface;

    public function login(LoginForm $form): UserInterface;

    public function getDefinitionOf(string $className): string;
}