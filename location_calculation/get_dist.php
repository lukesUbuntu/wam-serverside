<?php
require_once 'calc_distance.php';
//this will be the users location
$point1 = array('lat' => 40.770623, 'long' => -73.964367);
//this will be the events location
$point2 = array('lat' => 40.758224, 'long' => -73.917404);
//pass the points to the get_distance function
$distance = get_distance_between_points($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
//just for testing loop through all unit types and print the values
//this could be an if else to speed it up later on
foreach ($distance as $unit => $value) {
    echo $unit . ': ' . number_format($value, 4) . '<br />';
}
