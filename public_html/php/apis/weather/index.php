<?php
// get content from weather JSON data
$str = file_get_contents("http://cab.inta-csic.es/rems/wp-content/plugins/marsweather-widget/api.php");
// decode the JSON into an associative array
$json = json_decode($str, true);
$result = new stdClass();
//echo "<pre>".print_r($json, true)."</pre>";
$result->terrestrial_date = $json["soles"][0]["terrestrial_date"];
$result->sol = $json["soles"][0]["sol"];
$result->min_temp = $json["soles"][0]["min_temp"];
$result->max_temp = $json["soles"][0]["max_temp"];
$result->pressure = $json["soles"][0]["pressure"];
$result->atmo_opacity = $json["soles"][0]["atmo_opacity"];

header("Content-type: application/json");
echo json_encode($result);