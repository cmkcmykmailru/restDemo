<?php

namespace grigor\userManagement\modules\user;

use common\identities\WebIdentity;
use grigor\userManagement\modules\user\api\AuthManagerInterface;
use grigor\userManagement\modules\user\api\UserInterface;
use Yii;

class AuthManager implements AuthManagerInterface
{
    public function auth(UserInterface $user, bool $rememberMe): void
    {
        $identity = Yii::$container->get(WebIdentity::class, [$user]);
        Yii::$app->user->login($identity, $rememberMe ? 3600 * 24 * 30 : 0);
        $user->loginNotify();
    }
}