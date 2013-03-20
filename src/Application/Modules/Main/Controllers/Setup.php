<?php
namespace Application\Modules\Main\Controllers;

class Setup extends \Saros\Application\Controller
{

    public function init() {
        if (isset($_SERVER["PRODUCTION"]) && $_SERVER["PRODUCTION"]) {
            $this->redirect($GLOBALS["registry"]->utils->makeLink("Index"));
        }
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

    public function clearAction() {

        $this->view->show(false);

        $this->registry->mapper->truncateDatasource('\Application\Entities\SleepDays');
        $this->registry->mapper->truncateDatasource('\Application\Entities\SleepMinutes');
    }

    public function deleteAction() {

        $this->view->show(false);

        $this->registry->mapper->dropDatasource('\Application\Entities\SleepDays');
        $this->registry->mapper->dropDatasource('\Application\Entities\SleepMinutes');
    }
}
