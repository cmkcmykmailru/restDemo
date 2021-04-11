<?php

namespace grigor\userManagement\modules\user\api;

use grigor\library\services\Service;
use grigor\userManagement\modules\user\api\dto\LoginDto;

interface UserManageServiceInterface extends Service
{
    public function login(LoginDto $dto): UserInterface;
}