<?php

/**
 * Integer to day of week
 *
 * @param $number
 * @return string
 *
 */
function intToDayOfWeek($number)
{
    $dayOfWeek = null;
    switch ($number) {
        case 0:
            $dayOfWeek = 'Sunday';
            break;
        case 1:
            $dayOfWeek = 'Monday';
            break;
        case 2:
            $dayOfWeek = 'Tuesday';
            break;
        case 3:
            $dayOfWeek = 'Wednesday';
            break;
        case 4:
            $dayOfWeek = 'Thursday';
            break;
        case 5:
            $dayOfWeek = 'Friday';
            break;
        case 6:
            $dayOfWeek = 'Saturday';
            break;
        default:
            throw new Exception('Number ' . $number . ' is not associated with a day of week');

    }

    return $dayOfWeek;
}

/**
 * convert decimal part of min in a given time float variable to mins
 * and return the time in 'H:i' format
 *
 * @param $time
 * @return string
 */
function floatToHoursMinutes($time)
{
    $hours = (int)$time;
    $minIndecimal = ($time - $hours);

    $stringTime = $hours." hrs";
    $mins = floor($minIndecimal*60);
    if ($mins != 0) {
        $stringTime .= " and ".$mins. " mins";
    }

    return $stringTime;
}