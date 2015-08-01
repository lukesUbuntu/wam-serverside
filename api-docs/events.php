<?php
//URL to the API doco http://www.eventfinda.co.nz/api/v2/index
// Request the response in JSON format using the .json extension
//this call will return a list of events within a 5km radius of the specified location
//this location and radius will be set by the user
$url = 'http://api.eventfinda.co.nz/v2/events.json?point=-41.283338,174.778334&radius=5';
//Set username and password for api access
$username = "wip";
$password = "y6w26w93mfbr";
$process = curl_init($url);
curl_setopt($process, CURLOPT_USERPWD, $username . ":" . $password);
curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
$return = curl_exec($process);
//create a collection to iterate over.
$collection = json_decode($return);
// Iterate over the events

foreach ($collection->events as $events) {
    // echo the required fileds
    echo $events->name . "<br>";
    echo $events ->restrictions . "<br>";
    echo $events ->images->{'images'}[0]->transforms->transforms[0]->url. "<br>";
    echo $events->url . "<br>";
    echo $events ->description . "<br>";
    echo $events ->location_summary . "<br>";
    echo $events ->address . "<br>";
    echo $events ->point->lat . "<br>";
    echo $events ->point->lng . "<br>";
    echo $events ->datetime_start . "<br>";
    echo $events ->datetime_end . "<br>";
    echo "<br>";
}