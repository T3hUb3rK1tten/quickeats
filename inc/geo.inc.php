<?php

/**
 * Calculates distance between two coordinates.
 * Credit to https://www.marketingtechblog.com/calculate-distance/
 *
 * @param $latitude1 Latitude of first coordinate
 * @param $longitude1 Longitude of first coordinate
 * @param $latitude2 Latitude of second coordinate
 * @param $longitude2 Longitude for second coordinate
 * @param string $unit Specify return units in Mi (miles) or Km (kilometers), defaults to miles
 * @return float Distance in specified unit
 */
function distanceBetweenPoints($latitude1, $longitude1, $latitude2, $longitude2, $unit = 'Mi') {
    $theta = $longitude1 - $longitude2;
    $distance = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
    $distance = acos($distance);
    $distance = rad2deg($distance);
    $distance = $distance * 60 * 1.1515; switch($unit) {
        case 'Mi': break; case 'Km' : $distance = $distance * 1.609344;
    }
    return (round($distance,2));
}

?>