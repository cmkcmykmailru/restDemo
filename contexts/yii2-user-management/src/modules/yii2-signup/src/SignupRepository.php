<?php

namespace grigor\signup;

use grigor\signup\api\dto\SignUpDto;
use grigor\signup\api\SignupFactoryInterface;
use grigor\signup\api\SignupRepositoryInterface;
use grigor\signup\api\SignupUserInterface;
use grigor\userManagement\modules\user\UserRepository;

class SignupRepository extends UserRepository implements SignupRepositoryInterface
{
    protected SignupFactoryInterface $factory;

    /**
     * SignupRepository constructor.
     * @param SignupFactoryInterface $factory
     */
    public function __construct(SignupFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param string $token
     * @return SignupUserInterface
     */
    public function getByEmailConfirmToken(string $token): SignupUserInterface
    {
        return $this->getBy(['email_confirm_token' => $token]);
    }

    public function createUser(SignUpDto $dto): SignupUserInterface
    {
        return $this->factory->create($dto);
    }
}