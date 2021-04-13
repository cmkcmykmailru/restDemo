<?php

namespace grigor\userManagement\services;

use grigor\library\contexts\AbstractContract;
use grigor\signup\api\dto\SignUpDto;
use grigor\signup\api\SignupManageServiceInterface;
use grigor\userManagement\services\forms\SignupForm;
use grigor\userManagement\SignupContract;
use RuntimeException;

class SignUpService extends AbstractContract implements SignupContract
{

    public function getDefinitionOf(string $className): string
    {
        $this->container();
        $definitions = \Yii::$container->getDefinitions();

        if (!\Yii::$container->has($className)) {
            throw new RuntimeException('Class ' . $className . ' is not registered correctly.');
        }

        return $definitions[$className]['class'];
    }

    public function request(SignupForm $form): void
    {
        $this->container()
            ->get(SignupManageServiceInterface::class)
            ->request(new SignupDto($form->username, $form->email, $form->password));
    }

    public function confirm(string $token): void
    {
        $this->container()
            ->get(SignupManageServiceInterface::class)->confirm($token);
    }
}