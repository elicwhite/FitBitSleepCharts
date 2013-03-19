<?php
namespace Application\Classes;

class AvgSleepData
{
    protected $mapper;
    protected $userId;

    public function __construct($mapper, $userId)
    {
        $this->mapper = $mapper;
        $this->userId = $userId;
    }

    public function getAvgData($days = null) {
        $limit = "";

        // If an integer isn't passed, get data for all time.
        if (is_int($days)) {
            // just for good measure
            $days = intval($days);

            $limit = " LIMIT ".$days;
        }

        $items = $this->mapper->connection()->query(
            "SELECT avg(awakeningsCount) AS awakeningsCount,
                    avg(timeInBed) AS timeInBed,
                    avg(efficiency) AS efficiency,
                    avg(minutesToFallAsleep) AS minutesToFallAsleep,
                    avg(minutesAwake) AS minutesAwake,
                    STDDEV(TIME_TO_SEC(TIME(startTime))) / 60 as stdDevMin
                    FROM (SELECT * FROM sleepdays WHERE `userid` = :userid ORDER BY day DESC".$limit.") AS tbl"
                    ,array("userid" => $this->userId)
        );
        $result = $items->fetch(\PDO::FETCH_OBJ);
        return $result;
    }

}
