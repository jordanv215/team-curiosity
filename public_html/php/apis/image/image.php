<?php
// This is a place to write the image retrieval script before it's approved as actually being usable.
// this will be run upon loading of the Image view? Home view? wat? location TBD based on speed of execution

function getLastRan() {
	$fh = fopen('php/last-ran.txt', 'r+');
	$time = fgets($fh);
	fclose($fh);
	return $time;
}

if(time() - $this->time > 60) {
	$timeRan = time();
	function setTimeRan() {
		$fh = fopen('php/last-ran.txt', 'w+');
		fwrite($fh, $this->timeRan);
		fclose($fh);
	}
}