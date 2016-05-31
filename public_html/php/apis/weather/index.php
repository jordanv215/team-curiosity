<?php
// get content from weather JSON data
$str = file_get_contents("http://cab.inta-csic.es/rems/wp-content/plugins/marsweather-widget/api.php");
// decode the JSON into an associative array
$json = json_decode($str, true);
echo "<pre>".print_r($json, true)."</pre>";
$terrestrial_date = $json["soles"][0]["terrestrial_date"];
$sol = $json["soles"][0]["sol"];
$min_temp = $json["soles"][0]["min_temp"];
$max_temp = $json["soles"][0]["max_temp"];
$pressure = $json["soles"][0]["pressure"];
$atmo_opacity = $json["soles"][0]["atmo_opacity"];

