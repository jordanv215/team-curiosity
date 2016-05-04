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
	 */
}