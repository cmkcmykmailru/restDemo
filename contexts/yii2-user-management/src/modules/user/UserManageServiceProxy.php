<?php

namespace grigor\userManagement\modules\user;

use Exception;
use grigor\library\services\ServiceEventsProxy;
use grigor\userManagement\modules\user\api\dto\LoginDto;
use grigor\userManagement\modules\user\api\UserInterface;
use grigor\userManagement\modules\user\api\UserManageServiceInterface;

class UserManageServiceProxy extends ServiceEventsProxy implements UserManageServiceInterface
{

    public function __construct(
        UserManageServiceInterface $realService,
        $config = []
    )
    {
        parent::__construct($realService, $config);
    }

    /**
     * @param LoginDto $dto
     * @return UserInterface
     * @throws Exception
     */
    public function login(LoginDto $dto): UserInterface
    {
        return $this->wrap([$this->realService, 'login'], ['dto' => $dto], [
            ServiceEventsProxy::EVENT_BEFORE_METHOD_EXECUTE => 'login',
            ServiceEventsProxy::EVENT_AFTER_METHOD_EXECUTE => 'loggedIn',
            ServiceEventsProxy::EVENT_ERROR_METHOD_EXECUTE => 'loggedInError',
        ]);
    }
}