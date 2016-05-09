<?php
namespace Edu\Cnm\TeamCuriosity;

require_once("Autoload.php");

/**
 * FavoriteImage class for the curiosity team
 *
 * This class will use the user's social media accounts to favorite certain images in order to view a list of the images they enjoyed most
 * @author Jordan Vinson <jvinson3@cnm.edu>
 * version 1.0.0
 */

class FavoriteImage implements \JsonSerializable {

	/**
	 * id for this favorited image; this is part of the composite key
	 * @var int $favoriteImageId
	 **/
	private $favoriteImageId;

	/**
	 * id for the user id who favorites image; this is part of the composite key
	 * @var int $favoriteImageUserId
	 **/
	private $favoriteImageUserId;

	/**
	 * date and time for the image; this is a foreign key
	 * @var \DateTime $favoriteImageDateTime
	 **/
	private $favoriteImageDateTime;


	/**
	 * constructor for this favoriteImage
	 *
	 * @param int|null $newFavoriteImageId id of this image or null if a new image
	 * @param int $newFavoriteImageUserId id of the user who favorited the image
	 * @param \DateTime|string|null $newFavoriteImageDateTime date and time image was posted or null if set to current date and time
	 * @throws \InvalidArgumentException if data types are not valid
	 * @throws \RangeException if data values are out of bounds (e.g., strings too long, negative integers)
	 * @throws \TypeError if data types violate type hints
	 * @throws \Exception if some other exception occurs
	 **/
	public function __construct(int $newFavoriteImageId = null, int $newFavoriteImageUserId, $newFavoriteImageDateTime = null) {
		try {
			$this->setFavoriteImageId($newFavoriteImageId);
			$this->setFavoriteImageUserId($newFavoriteImageUserId);
			$this->setFavoriteImageDateTime($newFavoriteImageDateTime);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow the exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow the exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow the exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow the exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}













}
