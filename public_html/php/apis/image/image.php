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
			$query = file_get_contents("$baseUrl" . "?sol=0" . "&api_key=" . "$apiKey");
			$queryResult = json_decode($query, true);
			$maxSol = $queryResult["photos"][0]->rover->max_sol;

			// now we make the actual call to retrieve the most recent images
			$call = file_get_contents("$baseUrl" . "?sol=" . "$maxSol" . "&api_key=" . "$apiKey");
			$callResult = json_decode($call, true);

			foreach($callResult->photos->item as $item) {
				$imageSol = $item["sol"];
				$imageCamera = $item["camera"]["name"];
				$imageEarthDate = $item["earth_date"];
				$imageUrl = $item["img_src"];
				$pattern = '/_(F\w+)_\./';
				$str = preg_match($pattern, $item["img_src"]);
				$ext = substr($item["img_src"], -3);
				if($ext === "JPG" || $ext === "jpg" || $ext === "JPEG" || $ext === "jpeg") {
					$imageType = "image/jpeg";
				} else continue;
				$imageTitle = print_r($str[0]);
				if($imageTitle !== null) {
					try {
						$w = 800;
						header('Content-type: image/jpeg');
						list($width, $height) = getimagesize($imageUrl);
						$prop = $w / $width;
						$newWidth = $width * $prop;
						$newHeight = $height * $prop;

						$image_p = imagecreatetruecolor($newWidth, $newHeight);
						$image = imagecreatefromjpeg($imageUrl);
						imagecopyresampled($image_p, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

						imagejpeg($image_p, null, 90);

						if($_FILES['image']['name']) {
							$savePath = "/var/www/html/public_html/red-rover";
							move_uploaded_file($_FILES['image']['tmp_name'], $savePath . $imageTitle);
							$entry = new \Edu\Cnm\TeamCuriosity\Image(null, $imageCamera, null, $imageEarthDate, ($savePath . $imageTitle), $imageSol, $imageTitle, $imageType, $imageUrl);
							$entry = $this->insert($entry);
						}
					}

				} else continue;

			}

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
