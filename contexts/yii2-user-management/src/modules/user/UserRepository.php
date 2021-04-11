<?php

namespace grigor\userManagement\modules\user;

use grigor\library\helpers\DefinitionHelper;
use grigor\userManagement\modules\user\api\UserInterface;
use grigor\userManagement\modules\user\api\UserRepositoryInterface;
use yii\db\ActiveQueryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @param string $value
     * @return UserInterface|null
     */
    public function findByUsernameOrEmail(string $value): ?UserInterface
    {
        $query = $this->getQuery();
        return $query->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    protected function getQuery(): ActiveQueryInterface
    {
        $postClass = DefinitionHelper::getDefinition(UserInterface::class);
        return $postClass::find();
    }
}