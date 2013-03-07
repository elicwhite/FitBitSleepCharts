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

    public function indexAction()
    {
        $this->view->Uri = $GLOBALS["registry"]->utils->makeLink("Login", "index");
    }

    public function infoAction() {

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
}