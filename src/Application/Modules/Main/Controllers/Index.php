<?php
namespace Application\Modules\Main\Controllers;

class Index extends \Saros\Application\Controller
{
    
    public function init() {
        
    }
    
	public function indexAction()
	{            
        $this->view->Uri = $GLOBALS["registry"]->utils->makeLink("Login", "index");
	}
    
    public function infoAction() {
          
        // Send a request now that we have access token
        $result = json_decode( $GLOBALS["registry"]->fitbitService->request( 'user/-/profile.json') );
        $this->view->Data = $result;
    }
}
