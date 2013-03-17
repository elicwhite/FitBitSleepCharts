<?php
namespace Application\Classes;

class Utilities
{
    /**
    * Takes an integer of minutes and returns an array of hours, minutes
    *
    * @param mixed $minutes
    */
    public static function convertTime($minutes) {
        $hours = floor($minutes / 60);
        $min = $minutes % 60;

        return array($hours, $min);
    }
}