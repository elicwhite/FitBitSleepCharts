<?php
namespace Application\Classes;

class Utilities
{
    /**
    * Takes an integer of minutes and returns an array of hours, minutes
    *
    * @param mixed $minutes
    */
    private static function convertTime($minutes) {
        $hours = floor($minutes / 60);
        $min = $minutes % 60;

        return array($hours, $min);
    }

    public static function formatTime($minutes) {
        $time = self::convertTime($minutes);

        $str = "";
        if ($time[0] > 0) {
            $str = $time[0]." hours, ";
        }

        $str .= $time[1]." minutes";

        return $str;
    }
}