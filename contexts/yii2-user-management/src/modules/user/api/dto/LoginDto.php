<?php

namespace grigor\userManagement\modules\user\api\dto;

class LoginDto
{
    public string $username;
    public string $password;
    public bool $rememberMe = true;

    /**
     * LoginDto constructor.
     * @param string $username
     * @param string $password
     * @param bool $rememberMe
     */
    public function __construct(string $username, string $password, bool $rememberMe = true)
    {
        $this->username = $username;
        $this->password = $password;
        $this->rememberMe = $rememberMe;
    }

}