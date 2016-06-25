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
	if(time() - $this->time > 3600) {
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
			$pdo = connectToEncryptedMySQL("/etc/apache2/capstone-mysql/mars.ini");

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
				$imageUrl = $item["img_src"];
				// check if image already exists locally
				$duplicate = \Edu\Cnm\TeamCuriosity\Image::getImageByImageUrl($pdo, $imageUrl);
				if($duplicate === null) {
					// grab data fields
					$imageSol = $item["sol"];
					$imageCamera = $item["camera"]["name"];
					$imageEarthDate = $item["earth_date"];
					$pattern = '/_(F\w+)_\./';
					$str = preg_match($pattern, $item["img_src"]);
					$ext = substr($item["img_src"], -3);
					if($ext === "JPG" || $ext === "jpg" || $ext === "JPEG" || $ext === "jpeg") {
						$imageType = "image/jpeg";
					} else continue;
					$imageTitle = print_r($str[0]);
					if($imageTitle !== null) {
						try {
							// resample image @ width: 800px & quality: 90%
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
								// store file on disk
								$savePath = "/var/www/html/public_html/red-rover";
								move_uploaded_file($_FILES['image']['tmp_name'], $savePath . $imageTitle);
								// add to database
								$entry = new \Edu\Cnm\TeamCuriosity\Image(null, $imageCamera, null, $imageEarthDate, ($savePath . $imageTitle), $imageSol, $imageTitle, $imageType, $imageUrl);
								$entry = $this->insert($entry);
							}
						}

				} else continue;

				}
			}
		}

	} else {

	}
}
