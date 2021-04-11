<?php

namespace common\identities;

use filsh\yii2\oauth2server\Module;
use OAuth2\Storage\UserCredentialsInterface;
use Yii;

class RestIdentity extends WebIdentity implements  UserCredentialsInterface
{

    public static function findIdentityByAccessToken($token, $type = null)
    {
        $data = self::getOauth()->getServer()->getResourceController()->getToken();
        return !empty($data['user_id']) ? static::findIdentity($data['user_id']) : null;
    }

    public function checkUserCredentials($username, $password): bool
    {
        if (!$user = static::contract()->findActiveUserByUsername($username)) {
            return false;
        }
        return $user->validatePassword($password);
    }

    public function getUserDetails($username): array
    {
        $user = static::contract()->findActiveUserByUsername($username);
        return ['user_id' => $user->id];
    }

    private static function getOauth(): Module
    {
        return Yii::$app->getModule('oauth2');
    }
}