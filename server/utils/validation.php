<?php
/**
 * Created by PhpStorm.
 * User: lukeharries
 * Date: 10/03/2018
 * Time: 16:43
 */

function validate_datetime($datetime, $message)
{
    $converted_datetime = DateTime::createFromFormat("Y-m-d H:i:s", $datetime);
    if (!($converted_datetime && $converted_datetime->format("Y-m-d H:i:s") == $datetime)) {
        die('{"message": "Invalid ' . $message . '."}');
    }
}

function validate_auction_times($before_datetime, $after_datetime, $message)
{
    // if dates are in valid format then they can be comapred as strings,
    if ($before_datetime > $after_datetime || $before_datetime < date('Y-m-d H:i:s')) {
        die('{"message": "' . $message . '"}');
    }
}

function validate_positive_int($number, $message)
{
    if ($number < 0) {
        die('{"message": "' . $message . ' cannot be negative"}');
    } else if ($number > 10000000000) {
        die('{"message": "' . $message . ' cannot be higher than 100000000"}');
    }
}
