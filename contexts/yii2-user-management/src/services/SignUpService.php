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

    public function getName(): string
    {
        return 'SignUp';
    }
}