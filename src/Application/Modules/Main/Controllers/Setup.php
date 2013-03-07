<?php
namespace Application\Modules\Main\Controllers;

class Setup extends \Saros\Application\Controller
{

    public function init() {

    }

	public function indexAction()
	{
        $this->view->show(false);
        die("Setup");
	}

    public function installAction() {

        $this->view->show(false);

        $this->registry->mapper->migrate('\Application\Entities\SleepDays');
        $this->registry->mapper->migrate('\Application\Entities\SleepMinutes');
    }
}
