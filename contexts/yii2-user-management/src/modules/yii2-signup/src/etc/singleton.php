<?php

use grigor\accessManagement\AccessManagementContract;
use grigor\library\repositories\strategies\DeleteStrategyInterface;
use grigor\library\repositories\strategies\SaveStrategyInterface;
use grigor\signup\api\SignupFactoryInterface;
use grigor\signup\api\SignupManageServiceInterface;
use grigor\signup\api\SignupRepositoryInterface;
use grigor\signup\SignupManageService;
use grigor\signup\SignupManageServiceProxy;
use grigor\signup\SignupRepository;
use grigor\signup\SignupUserFactory;
use yii\di\Container;
use yii\di\Instance;

return [
    SignupUserFactory::class => function (Container $container) {
        return new SignupUserFactory($container);
    },
    SignupFactoryInterface::class => SignupUserFactory::class,
    SignupRepository::class => [
        ['class' => SignupRepository::class],
        [
            Instance::of(SignupFactoryInterface::class),
            Instance::of(SaveStrategyInterface::class),
            Instance::of(DeleteStrategyInterface::class),
        ]
    ],
    SignupRepositoryInterface::class => SignupRepository::class,
    SignupManageService::class => [
        ['class' => SignupManageService::class],
        [
            Instance::of(SignupRepositoryInterface::class),
            Instance::of(AccessManagementContract::class)
        ]
    ],
    SignupManageServiceProxy::class => [
        ['class' => SignupManageServiceProxy::class],
        [
            Instance::of(SignupManageService::class)
        ]
    ],
    SignupManageServiceInterface::class => SignupManageServiceProxy::class
];