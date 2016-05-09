<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/**
 *
 **/
class Image implements \JsonSerializable {
	use ValidateDate;

	/**
	 * constructor for this image
	 *
	 * @param int | null $newImageId id of this image or null if a new image
	 * @param string $newImageCamera specific camera that took this image
	 * @param string $newImageDescription string containing description of image
	 * @param \DateTime $newImageEarthDate date and time of image was taken
	 * @param string $newImagePath uniform resource identifier(uri) of image
	 * @param int $newImageSol martian solar day of image was taken
	 * @param string $newImageTitle title of image
	 * @param string $newImageType image file format of image
	 * @param string $newImageUrl uniform resource locator(url) of image
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g. strings too long, negarive intergers)
	 * @throws \TypeError if data types violate type hints
	 * @throw  \Exception if some other exception occurs
	 **/
	public function __construct(int $newImageId = null, string $newImageCamera, string $newImageDescription, $newImageEarthDate, string $newImagePath, int $newImageSol, string $newImageTitle, string $newImageType, string $newImageUrl) {
		try {
			$this->setImageId($newImageId);
			$this->setImageCamera($newImageCamera);
			$this->setImageDescription($newImageDescription);
			$this->setImageEarthDate($newImageEarthDate);
			$this->setImagePath($newImagePath);
			$this->setImageSol($newImageSol);
			$this->setImageTitle($newImageTitle);
			$this->setImageType($newImageType);
			$this->setImageUrl($newImageUrl);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			//rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for image id
	 *
	 * @return int | null value of image id
	 **/
	public function getImageId() {
		return ($this->imageId);
	}

	/**
	 * mutator moethod for image id
	 *
	 * @param int | null $newImageId new value of image id
	 * @throws \RangeException if $newImageId is not positive
	 * @throws \TypeError if $newImageId is not an integer
	 **/
	public function setImageId(int $newImageId = null) {
		// base case: if the image id is null, this is a new image without a mySQL assigned id(yet)
		if($newImageId === null) {
			$this->imageId = null;
			return;
		}

		//verify the image id is positive
		if($newImageId <= 0) {
			throw(new \RangeException("image id is not positive"));
		}

		//convert and  store the image id
		$this->imageId = $newImageId;
	}

	/** accessor method for image camera
	 *
	 * @return string value of image camera
	 **/
	public function getImageCamera() {
		return ($this->imageCamera);
	}

	/** matator method for image camera
	 * @param string $newImageCamera new value of image camera
	 * @throws \InvalidArgumentException if $newImageCamera is not a string of insecure
	 * @throws \RangeException is $newImageCamera is > 64 characters
	 * @throws \TypeError is $newImageCamera is not a string
	 **/
	public function setImageCamera() {
		// verify the image camera is secure
		$newImageCamera = trim($newImageCamera);
		$newImageCamera = filter_var($newImageCamera, FILTER_SANITIZE_STRING);
		if(empty($newImageCamera) === true) {
			throw(new \InvalidArgumentException("image camera is empty or insecure"));
		}

		// verify the image camera will fit in the database
		if(strlen($newImageCamera) > 64) {
			throw(new \RangeException("image camera too large"));
		}

		//store the image camera
		$this->imageCamera = $newImageCamera;
	}

	/** accessor method for imageDescription
	 *
	 * @return string value of imageDescription
	 **/
	public function getImageDescription() {
		return ($this->getImageDescription);
	}

	/**
	 * mutator method for image description
	 *
	 * @param string $newImageDescription new value of image description
	 * @throws \InvalidArgumentException if $newImageDescription is not a string or insecure
	 * @throws \RangeException if $newImageDescription is > 5000 characters
	 * @throws \TypeError if $newImageDescription is not a string
	 **/
	public function setImageDescription(string $newImageDescription) {
		// verify the image description is secure
		$newImageDescription = trim($newImageDescription);
		$newImageDescription = filter_var($newImageDescription, FILTER_SANITIZE_STRING);
		if(empty($newImageDescription) === true) {
			throw(new \InvalidArgumentException("image description is empty or insecure"));
		}

		// verify the image description will fit in the database
		if(strlen($newImageDescription) > 5000) {
			throw(new \RangeException("image description too large"));
		}

		//store the image description
		$this->imageDescription = $newImageDescription;
	}

	/**
	 * accessor method for image earth date
	 *
	 * @return \DateTime value of image earth date
	 **/
	public function getImageEarthDate() {
		return ($this->getImageEarthDate);
	}

	/**
	 * mutator method for image earth date
	 *
	 * @param \DateTime | string | null $newImageEarthDate image earth date as a Datetime object or string (or null to load the current time)
	 * @throws \InvalidArgumentException if $newImageEarthDate is
	 * @throws \TypeError a date that does not exist
	 **/

	public function setImageEarthDate($newImageEarthDate = null) {
		//base case: if the date is null, use the current date and time
		if($newImageEarthDate === null) {
			$this->imageEarthDate = new \DateTime();
			return;
		}

		//store the image earth date
		try {
			$newImageEarthDate = $this->validateDate($newImageEarthDate);
		} catch(\InvalidArgumentException $invalidArgument) {
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			throw(new \RangeException($range->getMessage(), 0, $range));
		}
		$this->imageEarthDate = $newImageEarthDate;
	}

	/**
	 * accesor method for image path
	 *
	 * @return string value of image path
	 **/
	public function getImagePath() {
		return ($this->imagePath);
	}

	/**mutator method for image path
	 *
	 * @param string $newImagePath new value  of image path
	 * @throws \InvalidArgumentException if $newImagePath is not a string or insecure
	 * @throws \RangeException if $newImagePath is > 256 characters
	 * @throw \TypeError if $newImagePath is not a string
	 **/
	public function setImagePath(string $newImagePath) {
		// verify the image path is secure
		$newImagePath = trim($newImagePath);
		$newImagePath = filter_var($newImagePath, FILTER_SANITIZE_STRING);
		if(empty($newImagePath) === true) {
			throw(new \InvalidArgumentException("image path is empty or insecure"));
		}

		// verify the image path will fit in the database
		if(strlen($newImagePath) > 256) {
			throw(new \RangeException("image path too large"));
		}

		// store the image path
		$this->imagePath = $newImagePath;
	}

	/**
	 * accessor method for image sol
	 *
	 * @return martian solar day of image
	 */
	public function getimageSol() {
		return ($this->imageSol);
	}

	/**
	 * mutator method for image sol
	 *
	 * @param int $newImageSol new value of image sol
	 * @throws \RangeException if $newImageId is not positive
	 * @throws \TypeError if $newImageId is not an integer
	 **/
	public function setImageSol(int $newImageSol) {
		// verify the image sole is positive
		if($newImageSol <= 0) {
			throw(new \RangeException("image sol is not positive"));
		}
		
		// convert and store the image sol
		$this->imageSol = $newImageSol;
	}
	/**
	 * accessor method for image title
	 *
	 * @return string value of image title
	 **/
	public function getImageTitle() {
		return($this->imageTitle);
	}

	/**
	 * mutator method for image title
	 *
	 * @param string $newImageTitle new value of image title
	 * @throws \InvalidArgumentException if $newImageTitle is not a string or insecure
	 * @throws \RangeException if $newImageTitle is > 128 characters
	 * @throws \TypeError if $newImageTitle is not a string
	 **/
	public function setImageTitle(string $newImageTitle) {
		// verify the image title is secure
		$newImageTitle = trim($newImageTitle);
		$newImageTitle = filter_var($newImageTitle, FILTER_SANITIZE_STRING);
		if(empty($newImageTitle) === true) {
			throw(new \InvalidArgumentException("image title is empty or insecure"));
		}

		// verify the image title will fit in the database
		if(strlen($newImageTitle) > 128) {
			throw(new \RangeException("image title too large"));
		}

		// store the image title
		$this->imageTitle = $newImageTitle;
	}

	/**
	 * accessor method for image type
	 *
	 * @return string value of image type
	 **/
	public function getImageType() {
		return($this->imageType);
	}

	/**
	 * mutator method for image type
	 *
	 * @param string string $newImageType new value of image type
	 * @throws \InvalidArgumentException if $newImageTitle is not a string
	 * @throws \RangeException if $newImageTitle is > 10 characters
	 * @throws \TypeError if $newImageType is not a string
	 **/
	public function setImageType(string $newImageType) {
		// verify the image title is secure
		$newImageTitle = trim($newImageType);
		$newImageType = filter_var($newImageType, FILTER_SANITIZE_STRING);
		if(empty($newImageType) === true) {
			throw(new \InvalidArgumentException("image type is empty or insecure"));
		}

		// store the image title
		$this->imageType = $newImageType;
	}
}