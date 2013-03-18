<?php
namespace Application\Modules\Main\Controllers;

class Index extends \Saros\Application\Controller
{
    private $storage;

    public function init() {
        $this->storage = $GLOBALS["registry"]->fitbitService->getStorage();

        if(!$this->storage->hasAccessToken()) {
            // If they aren't signed in, redirect them
            $this->redirect($GLOBALS["registry"]->utils->makeLink("Login", "index"));
        }

        if (!isset($this->storage["personal"]))
        {
            $result = json_decode( $GLOBALS["registry"]->fitbitService->request( 'user/-/profile.json') );
            $this->storage["personal"] = $result->{"user"};
        }
    }

    public function indexAction() {
        // Send a request now that we have access token
        $mostRecent = $this->registry->mapper->select('\Application\Entities\SleepDays')
            ->where(array("userid" => $this->storage["personal"]->{"encodedId"}))
            ->order(array("day" => "DESC"))
            ->limit(1);

        $result = $mostRecent->execute();

        if (!count($result)) {
            $this->view->LastDay = false;
        }
        else
        {
            $this->view->LastDay = $result[0]->day;
        }

        $this->view->Data = $this->storage["personal"];
    }

    public function updateAction() {
        $this->view->headScripts()->appendPageFile("js/Index/update.js");

        $updater = new \Application\Classes\Updater($this->storage["personal"]->{"encodedId"});
        $totalUpdated = $updater->buildQueue();

        $this->view->TotalToUpdate = $totalUpdated;
        //$this->getSleepAction();
    }

    public function processAction($num = 3) {
        if (!is_int($num)) {
            die("Invalid parameter. Must be an integer");
        }

        $num = min($num, 3);
        $num = max($num, 1);

        header('Content-type: application/json');
        $this->view->show(false);
        $updater = new \Application\Classes\Updater($this->storage["personal"]->{"encodedId"});
        $result = $updater->processQueue($num);

        if (!$result) {
            // Nothing left in the queue
            http_response_code(204);
        }
        else
        {
            echo json_encode(array("processed" => count($result), "results" => $result));
        }
    }

    public function graphAction() {
        $dayEntity = $this->registry->mapper->all(
            '\Application\Entities\SleepDays',
            array ("userid" => $this->storage["personal"]->{"encodedId"})
        )
        ->order(array("day" => "DESC"))
        ->limit(6);

        $days = array();
        foreach ($dayEntity as $day) {
            $days[] = $day;
        }

        $this->view->Days = $days;
    }

    public function getSleepJsonAction($day = false){
        header('Content-type: application/json');
        if (!$day) {
            die("invalid request");
        }

        $this->view->show(false);

        // Quick and simple cache
        $session = new \Saros\Session("jsonData");
        if (isset($session[$day]))
        {
            echo $session[$day];
            return;
        }

        $dayEntity = $this->registry->mapper->first(
            '\Application\Entities\SleepDays',
            array (
                "userid" => $this->storage["personal"]->{"encodedId"},
                "day" => $day
            )
        );

        // Should throw an error code
        if (!$dayEntity) {
            die("invalid day");
        }

        $array = array();

        foreach($dayEntity->minutes as $minute) {
            $obj = new \stdClass();
            $obj->x = strtotime($minute->minute);
            $obj->y = $minute->value;

            $array[] = $obj;
        }
        $series = new \stdClass();
        $series->name = "Sleep";
        $series->data = $array;

        $wrapper = array();
        $wrapper[] = $series;

        $result = json_encode($wrapper);

        $session[$day] = $result;

        echo $result;
    }

    public function logoutAction() {
        $this->storage->clear();
        $this->redirect($GLOBALS["registry"]->utils->makeLink("Index"));
    }
}