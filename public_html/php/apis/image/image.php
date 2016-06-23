<?php
// This is a place to write the image retrieval script before it's approved as actually being usable.
// this will be run upon loading of the Image view? Home view? wat? location TBD based on speed of execution


// if the parameter exists, proceed
if(isset($_GET["top25"]) === true) {

	// check when NASA api was last called
	public
	function getLastRan() {
		$fh = fopen('php/last-ran.txt', 'r+');
		$time = fgets($fh);
		fclose($fh);
		return $time;
	}

	// proceed only if API not called within last hour (to avoid unnecessary calls & optimize retrieval speed)
	if(time() - $this->time > 60) {
		$timeRan = time();

		// mark the time that the API call is being run
		function setTimeRan() {
			$fh = fopen('php/last-ran.txt', 'w+');
			fwrite($fh, $this->timeRan);
			fclose($fh);
		}

		// grab json with last 25 items (NASA default/maximum per page)
		public
		function NasaCall() {
			$baseUrl = "https://api.nasa.gov/mars-photos/api/v1/rovers/curiosity/photos";
			$config = readConfig("/etc/apache2/capstone-mysql/mars.ini");
			$apiKey = $config["authkeys"]->nasa->secretKey;

			// to get most recent items, we need the highest sol value available
			// initial API call is only for this purpose
			// please, let there be a better way to do this...
			$queryUrl = "$baseUrl" . "?sol=0" . "&api_key=" . "$apiKey";
			$queryResult = json_decode($queryUrl);
			$maxSol = $queryResult["photos"][0]->rover->max_sol;

		}

		$image = \Edu\Cnm\TeamCuriosity\Image::getImageByImageUrl($pdo, $imageUrl);
	} else {
		public
		function getImages(\PDO $pdo, int $imageId) {
			$query = "SELECT imageId, imageCamera, imageDescription, imageEarthDate, imagePath, imageSol, imageTitle, imageType, imageUrl FROM Image WHERE imageId > MAX(imageId) - 25";
			$statement = $pdo->prepare($query);
			$parameters = array("imageId" => $imageId);
			$statement->execute($parameters);

			$images = new \SplFixedArray($statement->rowCount());
			$statement->setFetchMode(\PDO::FETCH_ASSOC);
			while(($row = $statement->fetch()) !== false) {
				try {
					$image = new Edu\Cnm\TeamCuriosity\Image($row["imageId"], $row["imageCamera"], $row["imageDescription"], \DateTime::createFromFormat("Y-m-d H:i:s", $row["imageEarthDate"]), $row["imagePath"], $row["imageSol"], $row["imageTitle"], $row["imageType"], $row["imageUrl"]);
					$images[$images->key()] = $image;
					$images->next();
				} catch(\Exception $exception) {
					// if the row couldn't be converted, rethrow it
					throw(new \PDOException($exception->getMessage(), 0, $exception));
				}
			}
			return ($images);
		}
	}
}
