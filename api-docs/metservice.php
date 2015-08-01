<?php
  $json_string = file_get_contents("http://api.wunderground.com/api/6915a8c0fb709676/geolookup/conditions/forecast/q/New_Zealand/Wellington.json");
  $parsed_json = json_decode($json_string);
  $location = $parsed_json->{'location'}->{'city'};
  $temp_c = $parsed_json->{'current_observation'}->{'temp_c'};
  echo "Current temperature in ${location} is: ${temp_c}\n";
