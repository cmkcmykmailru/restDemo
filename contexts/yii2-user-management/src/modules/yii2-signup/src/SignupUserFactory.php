<?php

namespace grigor\signup;

use grigor\signup\api\dto\SignUpDto;
use grigor\signup\api\SignupFactoryInterface;
use grigor\signup\api\SignupUserInterface;
use grigor\signup\events\UserSignUpRequested;
use grigor\userManagement\modules\user\api\UserInterface;
use Ramsey\Uuid\Uuid;
use Yii;
use yii\di\Container;

class SignupUserFactory implements SignupFactoryInterface
{

    /**@var Container $container */
    private Container $container;

    /**
     * PostFactory constructor.
     * @param $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param SignUpDto $dto
     * @return SignupUserInterface
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\di\NotInstantiableException
     */
    public function create(SignUpDto $dto): SignupUserInterface
    {
        $user = $this->container->get(SignupUserInterface::class);
        $user->id = Uuid::uuid4()->toString();
        $user->username =$dto->username;
        $user->email = $dto->email;
        $user->setPassword($dto->password);
        $user->created_at = time();
        $user->status = UserInterface::STATUS_WAIT;
        $user->email_confirm_token = Yii::$app->security->generateRandomString();
        $user->generateAuthKey();
        $user->recordEvent(new UserSignUpRequested($user->id));
        return $user;
    }
}