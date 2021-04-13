<?php

namespace grigor\accessManagement\modules\manager;

use grigor\accessManagement\modules\manager\api\RoleManagerInterface;
use yii\rbac\ManagerInterface;

class RoleManager implements RoleManagerInterface
{
    private $manager;

    public function __construct(ManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function assign(string $userId, string $name): void
    {
        if (!$role = $this->manager->getRole($name)) {
            throw new \DomainException('Role "' . $name . '" does not exist.');
        }
        $this->manager->revokeAll($userId);
        $this->manager->assign($role, $userId);
    }
}