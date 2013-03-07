<?php
namespace Application\Entities;

class SleepMinutes extends \Spot\Entity
{
    protected static $_datasource = 'sleepminutes';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'int', 'primary'=> true, 'serial' => true),
            'sleepdayid' => array('type' => 'int'),
            'minute' => array('type' => 'string'),
            'value' => array('type' => 'int'),
        );
    }

    public static function relations()
    {
        return array(
        );
    }
}
