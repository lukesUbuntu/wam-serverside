<?php
//when passed two sets of location gps points this function will calculate the distance between the two points.
//we have included miles,feet,yards,kilometers and meters so users from other countries can use the mesurment they are comfortable with
function get_distance_between_points($latitude1, $longitude1, $latitude2, $longitude2) {
$theta = $longitude1 - $longitude2;
$miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
$miles = acos($miles);
$miles = rad2deg($miles);
$miles = $miles * 60 * 1.1515;
$feet = $miles * 5280;
$yards = $feet / 3;
$kilometers = $miles * 1.609344;
$meters = $kilometers * 1000;
    //return the requested values
return compact('miles','feet','yards','kilometers','meters');
}