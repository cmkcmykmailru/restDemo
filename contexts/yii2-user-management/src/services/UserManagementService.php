<?php

namespace grigor\userManagement\services;

use grigor\library\contexts\AbstractContract;
use grigor\userManagement\modules\user\api\dto\LoginDto;
use grigor\userManagement\modules\user\api\UserInterface;
use grigor\userManagement\modules\user\api\UserManageServiceInterface;
use grigor\userManagement\modules\user\api\UserReadRepositoryInterface;
use grigor\userManagement\services\forms\LoginForm;
use grigor\userManagement\UserManagementContract;

class UserManagementService extends AbstractContract implements UserManagementContract
{

    public function findActiveUserById(string $id): ?UserInterface
    {
        return $this->container()->get(UserReadRepositoryInterface::class)->findActiveById($id);
    }

    public function findActiveUserByUsername(string $username): ?UserInterface
    {
        return $this->container()->get(UserReadRepositoryInterface::class)->findActiveByUsername($username);
    }

    public function login(LoginForm $form): UserInterface
    {
        $dto = new LoginDto($form->username, $form->password, $form->rememberMe);
        return $this->container()->get(UserManageServiceInterface::class)->login($dto);
    }
}