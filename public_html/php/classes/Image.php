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
			throw(new \RangeException("image camera too large"))
		}

		//store the image camera
		$this->imageCamera = $newImageCamera;
	}

	/** accessor method for imageDescription
	 *
	 * @return string value of imageDescription
	 **/
	public function getImageDescription() {
		return($this->getImageDescription);
	}
}