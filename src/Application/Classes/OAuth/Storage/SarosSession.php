<?php
namespace Application\Classes\OAuth\Storage;

use \OAuth\Common\Storage\TokenStorageInterface;
use \OAuth\Common\Storage\Exception\TokenNotFoundException;
use \OAuth\Common\Token\TokenInterface;

class SarosSession extends \Saros\Session implements TokenStorageInterface
{
    private $session;
    private $sessionVariableName;
    private $tokenVariableName;

    public function __construct($startSession = true, $sessionVariableName = 'fitbit_oauth_data', $tokenVariableName = 'oauth_token')
    {
        $this->session = new \Saros\Session($sessionVariableName);
        $this->sessionVariableName = $sessionVariableName;
        $this->tokenVariableName = $tokenVariableName;
    }

    public function retrieveAccessToken()
    {
        if (isset($this->session[$this->tokenVariableName])) {
            return $this->session[$this->tokenVariableName];
        }

        throw new TokenNotFoundException('Token not found in session, are you sure you stored it?');
    }

    public function storeAccessToken(TokenInterface $token)
    {
        $this->session[$this->tokenVariableName] = $token;
    }

    /**
    * @return bool
    */
    public function hasAccessToken()
    {
        return isset($this->session[$this->tokenVariableName]);
    }
}
