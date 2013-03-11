<?php
namespace Application\Classes;

class Updater
{
    private $session;

    private $encodedId;

    public function __construct($encodedId)
    {
        $this->session = new \Saros\Session("updateQueue");
        $this->encodedId = $encodedId;
    }

    public function buildQueue() {
        $results = json_decode( $GLOBALS["registry"]->fitbitService->request( 'user/-/sleep/minutesAsleep/date/today/3m.json') );
        $daysData = $results->{"sleep-minutesAsleep"};

        $totalToUpdate = 0;

        $this->session->queue = array();

        foreach($daysData as $dayData)
        {
            if ($dayData->{"value"} > 0) {

                // Check if this is already in the database
                $current = $GLOBALS["registry"]->mapper->first(
                    '\Application\Entities\SleepDays',
                    array (
                        "userid" => $this->encodedId,
                        "day" => $dayData->{"dateTime"}
                    )
                );

                if (!$current) {
                    $totalToUpdate++;

                    // building up the queue
                    $this->session->queue[] = $dayData->{"dateTime"};
                }
            }
        }

        return $totalToUpdate;
    }

    public function hasItems() {
        return count($this->session->queue) > 0;
    }

    // Run the first item
    public function processQueue($per = 2) {
        if (!$this->hasItems()) {
            return false;
        }

        $results = array();

        // load up our array while we keep our session lock
        $days = array();
        for ($i = 1; $i <= $per; $i++) {
            $days[] = array_shift($this->session->queue);
        }
        // release the session lock.
        session_write_close();

        foreach ($days as $day) {
            $detailed = $this->getDaySleep($day);

            $cols = array(
                "userid" => $this->encodedId,
                "day" => $day,
                "awakeningsCount" => $detailed->{"awakeningsCount"},
                "timeInBed" => $detailed->{"timeInBed"},
                "efficiency" => $detailed->{"efficiency"},
                "minutesToFallAsleep" => $detailed->{"minutesToFallAsleep"},
            );

            $dayId = $GLOBALS["registry"]->mapper->insert(
                '\Application\Entities\SleepDays',
                $cols
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

            $results[] = $cols;
        }

        return $results;
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
