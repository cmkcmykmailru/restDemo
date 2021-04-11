<?php

namespace common\identities;

use grigor\userManagement\modules\user\api\UserInterface;
use grigor\userManagement\UserManagementContract;
use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

class WebIdentity implements IdentityInterface
{
    protected $user;
    public $username;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
        $this->username = $user->username;
    }

    public static function findIdentity($id)
    {
        $user = static::contract()->findActiveUserById($id);
        return $user ? new self($user) : null;
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public function getId()
    {
        return $this->user->id;
    }

    public function getAuthKey(): string
    {
        return $this->user->auth_key;
    }

    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    protected static function contract(): UserManagementContract
    {
        return Yii::$container->get(UserManagementContract::class);
    }
}