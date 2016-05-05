<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("autoload.php");

/**
 *
 **/
class image implements \JsonSerializable {
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
		}	catch(\RangeException $range) {
				//rethrow the exception to the caller
				throw(new \RangeException($range->getMessage(), 0, $range));
		}	catch(\TypeError $typeError) {
				// rethrow the exception to the caller
				throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		}	catch(\Exception $exception) {
				// rethrow the exception to the caller
				throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}
	
	/**