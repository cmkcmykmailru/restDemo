<?php

use grigor\userManagement\modules\user\api\AuthManagerInterface;
use grigor\userManagement\modules\user\api\UserManageServiceInterface;
use grigor\userManagement\modules\user\api\UserReadRepositoryInterface;
use grigor\userManagement\modules\user\api\UserRepositoryInterface;
use grigor\userManagement\modules\user\AuthManager;
use grigor\userManagement\modules\user\UserManageService;
use grigor\userManagement\modules\user\UserManageServiceProxy;
use grigor\userManagement\modules\user\UserReadRepository;
use grigor\userManagement\modules\user\UserRepository;
use yii\di\Instance;

return [
    UserReadRepositoryInterface::class => UserReadRepository::class,
    AuthManagerInterface::class => AuthManager::class,
    UserRepositoryInterface::class => UserRepository::class,
    UserManageService::class => [
        ['class' => UserManageService::class],
        [
            Instance::of(UserRepositoryInterface::class),
            Instance::of(AuthManagerInterface::class)
        ]
    ],
    UserManageServiceProxy::class => [
        ['class' => UserManageServiceProxy::class],
        [
            Instance::of(UserManageService::class)
        ]
    ],
    UserManageServiceInterface::class => UserManageServiceProxy::class
];
