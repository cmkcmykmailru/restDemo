<?php
namespace common\fixtures;

use grigor\userManagement\modules\user\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
}