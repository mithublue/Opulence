<?php
/**
 * Copyright (C) 2014 David Young
 *
 * Defines a user's login credentials
 */
namespace RamODev\Application\Shared\Users\Authentication\Credentials;
use RamODev\Application\Shared\Cryptography;

class LoginCredentials implements ILoginCredentials
{
    /** @var int The Id of the user whose credentials these are */
    private $userId = -1;
    /** @var Cryptography\Token The login token */
    private $loginToken = null;

    /**
     * @param int $userId The Id of the user whose credentials these are
     * @param Cryptography\Token $loginToken The login token
     */
    public function __construct($userId, Cryptography\Token $loginToken)
    {
        $this->userId = $userId;
        $this->loginToken = $loginToken;
    }

    /**
     * @return Cryptography\Token
     */
    public function getLoginToken()
    {
        return $this->loginToken;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param Cryptography\Token $loginToken
     */
    public function setLoginToken(Cryptography\Token $loginToken)
    {
        $this->loginToken = $loginToken;
    }
} 