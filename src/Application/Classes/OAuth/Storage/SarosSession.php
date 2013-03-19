<?php
namespace Application\Classes\OAuth\Storage;

use \OAuth\Common\Storage\TokenStorageInterface;
use \OAuth\Common\Storage\Exception\TokenNotFoundException;
use \OAuth\Common\Token\TokenInterface;

class SarosSession extends \Saros\Session implements TokenStorageInterface
{
    private $tokenVariableName;

    public function __construct($sessionVariableName = 'fitbit_oauth_data', $tokenVariableName = 'oauth_token')
    {
        parent::__construct($sessionVariableName);
        $this->tokenVariableName = $tokenVariableName;
    }

    public function retrieveAccessToken()
    {
        if (isset($this->{$this->tokenVariableName})) {
            return $this->{$this->tokenVariableName};
        }

        throw new TokenNotFoundException('Token not found in session, are you sure you stored it?');
    }

    public function storeAccessToken(TokenInterface $token)
    {
        $this->{$this->tokenVariableName} = $token;
    }

    /**
    * @return bool
    */
    public function hasAccessToken()
    {
        return isset($this->{$this->tokenVariableName});
    }

    /**
    * Delete the users token. Aka, log out.
    */
    public function clearToken()
    {
        unset($this->{$this->tokenVariableName});
    }
}
