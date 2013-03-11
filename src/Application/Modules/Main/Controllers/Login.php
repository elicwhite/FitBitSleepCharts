<?php
namespace Application\Modules\Main\Controllers;
/*
use OAuth\OAuth1\Signature\Signature;
use OAuth\Common\Storage\Session;
use OAuth\Common\Consumer\Credentials;
use OAuth\Common\Http\Uri\Uri;
    */
class Login extends \Saros\Application\Controller
{
    private $fitbitService;

    public function init() {
        if($GLOBALS["registry"]->fitbitService->getStorage()->hasAccessToken()) {
            // If they aren't signed in, redirect them
            //$this->redirect($GLOBALS["registry"]->utils->makeLink("Index"));
        }

        $this->fitbitService = $GLOBALS["registry"]->fitbitService;
    }

    public function indexAction()
    {
        $this->view->Uri = $GLOBALS["registry"]->utils->makeLink("Login", "login");
    }

    public function loginAction() {
        $token = $this->fitbitService->requestRequestToken();

        $url = $this->fitbitService->getAuthorizationUri(['oauth_token' => $token->getRequestToken()]);
        $this->redirect($url);
    }

    public function callbackAction() {
        $token = $this->fitbitService->getStorage()->retrieveAccessToken();
        // This was a callback request from fitbit, get the token
        $this->fitbitService->requestAccessToken(
            $_GET['oauth_token'],
            $_GET['oauth_verifier'],
            $token->getRequestTokenSecret() );

        $this->redirect($GLOBALS["registry"]->utils->makeLink("Index", "info"));
    }
}