<?php

namespace grigor\userManagement\modules\user;

use grigor\library\helpers\DefinitionHelper;
use grigor\userManagement\modules\user\api\UserInterface;
use grigor\userManagement\modules\user\api\UserReadRepositoryInterface;
use yii\db\ActiveQueryInterface;

class UserReadRepository implements UserReadRepositoryInterface
{
    /**
     * @param string $id
     * @return UserInterface|null
     */
    public function find($id): ?UserInterface
    {
        $query = $this->getQuery();
        return $query->andWhere(['id' => $id])->limit(1)->one();
    }

    public function findActiveByUsername(string $username): ?UserInterface
    {
        $query = $this->getQuery();
        return $query->andWhere(['username' => $username, 'status' => UserInterface::STATUS_ACTIVE])->limit(1)->one();
    }

    public function findActiveById(string $id): ?UserInterface
    {
        $query = $this->getQuery();
        return $query->andWhere(['id' => $id, 'status' => UserInterface::STATUS_ACTIVE])->limit(1)->one();
    }

    protected function getQuery(): ActiveQueryInterface
    {
        $postClass = DefinitionHelper::getDefinition(UserInterface::class);
        return $postClass::find();
    }
}