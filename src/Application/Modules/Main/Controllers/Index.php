<?php
namespace Application\Modules\Main\Controllers;

class Index extends \Saros\Application\Controller
{
    public function init() {
        //die(phpinfo());
    }
    
	public function indexAction()
	{
        
        $fitbit = new \FitBit\FitBit("d309d935df0b415e84721ef9c40c2379", "64cff6931e0547a8b403dad81c5ba664");

        $fitbit->initSession('http://example.com/callback.php');
        $xml = $fitbit->getProfile();

        print_r($xml);

		$this->view->Version = \Saros\Version::getVersion();
	}
}
