<?php

namespace grigor\userManagement\modules\user;

use grigor\library\repositories\strategies\DeleteStrategyInterface;
use grigor\library\repositories\strategies\SaveStrategyInterface;
use grigor\userManagement\modules\user\api\UserInterface;
use grigor\userManagement\modules\user\api\UserRepositoryInterface;
use yii\db\ActiveQueryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $saveStrategy;
    private $deleteStrategy;

    /**
     * UserRepository constructor.
     * @param SaveStrategyInterface $saveStrategy
     * @param DeleteStrategyInterface $deleteStrategy
     */
    public function __construct(
        SaveStrategyInterface $saveStrategy,
        DeleteStrategyInterface $deleteStrategy
    )
    {
        $this->saveStrategy = $saveStrategy;
        $this->deleteStrategy = $deleteStrategy;
    }

    /**
     * @param string $value
     * @return UserInterface|null
     */
    public function findByUsernameOrEmail(string $value): ?UserInterface
    {
        $query = $this->getQuery();
        return $query->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    protected function getBy(array $conditions): UserInterface
    {
        $query = $this->getQuery();
        if (!$user = $query->andWhere($conditions)->limit(1)->one()) {
            throw new \DomainException('User not found.');
        }
        return $user;
    }

    protected function getQuery(): ActiveQueryInterface
    {
        return User::find();
    }

    public function get(string $id): UserInterface
    {
        return $this->getBy(['id' => $id]);
    }

    public function save(UserInterface $user): void
    {
        $this->saveStrategy->save($user);
    }

    public function remove(UserInterface $user): void
    {
        $this->deleteStrategy->delete($user);
    }
}