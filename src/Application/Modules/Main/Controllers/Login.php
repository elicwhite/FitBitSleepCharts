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
    private $fitbit;

    public function init() {
        $this->fitbit = $GLOBALS["registry"]->fitbit;
        if($this->fitbit->isAuthorized()) {
            // If they aren't signed in, redirect them
            //$this->redirect($GLOBALS["registry"]->utils->makeLink("Index"));
        }
    }

    public function indexAction()
    {
        $this->view->Uri = $GLOBALS["registry"]->utils->makeLink("Login", "login");
    }

    public function loginAction() {
        $this->fitbit->initSession();
    }

    public function callbackAction() {
        $this->fitbit->initSession();

        $this->redirect($GLOBALS["registry"]->utils->makeLink("Index", "info"));
    }
}