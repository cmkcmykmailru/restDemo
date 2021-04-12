<?php

namespace grigor\signup\api;

use grigor\userManagement\modules\user\api\UserInterface;

interface SignupUserInterface extends UserInterface
{
    public function confirmSignup(): void;
}