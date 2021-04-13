<?php

namespace grigor\userManagement\services\forms;

use grigor\signup\api\SignupUserInterface;
use grigor\userManagement\SignupContract;
use yii\base\Model;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $contract = \Yii::$container->get(SignupContract::class);
        return [
            ['username', 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => $contract->getDefinitionOf(SignupUserInterface::class), 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => $contract->getDefinitionOf(SignupUserInterface::class), 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 1, 'max' => 255],
        ];
    }
}
