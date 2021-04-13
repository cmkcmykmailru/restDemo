<?php

namespace grigor\userManagement\modules\user;

use grigor\userManagement\modules\user\api\AuthManagerInterface;
use grigor\userManagement\modules\user\api\dto\LoginDto;
use grigor\userManagement\modules\user\api\UserInterface;
use grigor\userManagement\modules\user\api\UserManageServiceInterface;
use grigor\userManagement\modules\user\api\UserRepositoryInterface;

class UserManageService implements UserManageServiceInterface
{
    private UserRepositoryInterface $users;
    private AuthManagerInterface $manager;

    public function __construct(UserRepositoryInterface $users, AuthManagerInterface $manager)
    {
        $this->users = $users;
        $this->manager = $manager;
    }

    public function login(LoginDto $form): UserInterface
    {
        $user = $this->users->findByUsernameOrEmail($form->username);
        if (!$user || !$user->isActive() || !$user->validatePassword($form->password)) {
            throw new \DomainException('Undefined user or password.');
        }
        $this->manager->auth($user, $form->rememberMe);
        return $user;
    }
}