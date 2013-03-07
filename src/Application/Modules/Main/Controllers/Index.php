<?php
namespace Application\Modules\Main\Controllers;

class Index extends \Saros\Application\Controller
{
    private $personal;

    public function init() {
        if(!$GLOBALS["registry"]->fitbitService->getStorage()->hasAccessToken()) {
            // If they aren't signed in, redirect them
            $this->redirect($GLOBALS["registry"]->utils->makeLink("Login", "index"));
        }

        $result = json_decode( $GLOBALS["registry"]->fitbitService->request( 'user/-/profile.json') );
        $this->personal = $result->{"user"};
    }

    public function indexAction() {
        // Send a request now that we have access token
        $this->view->Data = $this->personal;
    }

    public function getSleepAction() {
        $results = json_decode( $GLOBALS["registry"]->fitbitService->request( 'user/-/sleep/minutesAsleep/date/today/3m.json') );
        $daysData = $results->{"sleep-minutesAsleep"};

        $totalValid = 0;
        $totalUpdated = 0;

        foreach($daysData as $dayData)
        {
            if ($dayData->{"value"} > 0) {
                $totalValid++;

                // Check if this is already in the database
                $current = $this->registry->mapper->first(
                    '\Application\Entities\SleepDays',
                    array (
                        "userid" => $this->personal->{"encodedId"},
                        "day" => $dayData->{"dateTime"}
                    )
                );

                if (!$current) {
                    $totalUpdated++;
                    // It's not, add it

                    $detailed = $this->getDaySleep($dayData->{"dateTime"});

                    $dayId = $GLOBALS["registry"]->mapper->insert(
                        '\Application\Entities\SleepDays',
                        array(
                            "userid" => $this->personal->{"encodedId"},
                            "day" => $dayData->{"dateTime"},
                            "awakeningsCount" => $detailed->{"awakeningsCount"},
                            "timeInBed" => $detailed->{"timeInBed"},
                            "efficiency" => $detailed->{"efficiency"},
                            "minutesToFallAsleep" => $detailed->{"minutesToFallAsleep"},
                        )
                    );

                    foreach($detailed->{"minuteData"} as $minute){
                        $GLOBALS["registry"]->mapper->insert(
                            '\Application\Entities\SleepMinutes',
                            array(
                                "sleepdayid" => $dayId,
                                "minute" => $minute->{"dateTime"},
                                "value" => $minute->{"value"}
                            )
                        );
                    }
                }
            }
        }

        $this->view->TotalValid = $totalValid;
        $this->view->TotalUpdated = $totalUpdated;
    }

    private function getDaySleep($day) {
        $results = json_decode($GLOBALS["registry"]->fitbitService->request('user/-/sleep/date/'.$day.'.json'));

        // We only care about the main sleep
        foreach($results->{"sleep"} as $sleep) {
            if ($sleep->{"isMainSleep"}){
                return $sleep;
            }
        }
    }

    public function graphAction() {
        $dayEntity = $this->registry->mapper->all(
            '\Application\Entities\SleepDays',
            array ("userid" => $this->personal->{"encodedId"})
        )
        ->order(array("day" => "DESC"))
        ->limit(6);

        $days = array();
        foreach ($dayEntity as $day) {
            $days[] = $day->day;
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
                "userid" => $this->personal->{"encodedId"},
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
}