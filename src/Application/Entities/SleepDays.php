<?php
namespace Application\Entities;

class SleepDays extends \Spot\Entity
{
	protected static $_datasource = 'sleepdays';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary' => true, 'serial' => true),
            'userid' => array('type' => 'string'),
            'day' => array('type' => 'string'),
            'awakeningsCount' => array('type' => 'int'),
            'timeInBed' => array('type' => 'int'),
            'efficiency' => array('type' => 'int'),
            'minutesToFallAsleep' => array('type' => 'int'),
            'minutesAwake' => array('type' => 'int'),
            'startTime' => array('type' => 'datetime')
        );
    }

    public static function relations()
    {
        return array(
            // Each post entity 'hasMany' comment entites
            'minutes' => array(
                'type' => 'HasMany',
                'entity' => '\Application\Entities\SleepMinutes',
                'where' => array('sleepdayid' => ':entity.id'),
                'order' => array('minute' => 'ASC')
            )
        );
    }
}
