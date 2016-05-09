<?php
namespace Edu\Cnm\TeamCuriosity

require_once("Autoload.php");

/**
 * Comment Image Class
 *
 * This contains the accessor and mutator methods for the CommentImage table
 *
 * @author Kai Garrott <garrottkai@gmail.com>
 * @version 1.0.0
 */

class CommentImage implements \JsonSerializable {
	use ValidateDate;
	/**
	 * Unique ID of the image comment - this is the primary key
	 * @var int $commentImageId
	 */
	private $commentImageId;
	/**
	 * content of the image comment; maximum 1024B
	 * @var string $commentImageContent
	 */
	private $commentImageContent;
	/**
	 * timestamp of the image comment, as a DateTime object
	 * @var \DateTime $commentImageDateTime
	 */
	private $commentImageDateTime;
	/**
	 * ID of the image commented on - a foreign key
	 * @var $commentImageImageId
	 */
	private $commentImageImageId;
	/**
	 * ID of the user who created the comment - a foreign key
	 * @var $commentImageUserId
	 */
	private $commentImageUserId;

	/**
	 * Constructor for the image comment
	 * @param int|null $commentImageId primary key assigned by mySQL; empty until inserted
	 * @param string $commentImageContent content of the comment
	 * @param \DateTime|null $commentImageDateTime timestamp of the comment as assigned by mySQL
	 * @param int $commentImageImageId id of the image commented on
	 * @param int $commentImageUserId id of the user who created the comment
	 * @throws \InvalidArgumentException if entry is not valid
	 * @throws \RangeException if entry is negative or too long
	 * @throws \TypeError if type hint is violated
	 * @throws \Exception if some other exception occurs
	 */
	public function __construct(int $newCommentImageId = null, string $newCommentImageContent, $newCommentImageDateTime = null, int $newCommentImageImageId; int $newCommentImageUserId) {
		try {
			$this->setCommentImageId($newCommentImageId);
			$this->setCommentImageContent($newCommentImageContent);
			$this->setCommentImageDateTime($newCommentImageDateTime);
			$this->setCommentImageImageId($newCommentImageImageId);
			$this->setCommentImageUserId($newCommentImageUserId);
		} catch(\InvalidArgumentException $invalidArgument) {
			// rethrow exception to the caller
			throw(new \InvalidArgumentException($invalidArgument->getMessage(), 0, $invalidArgument));
		} catch(\RangeException $range) {
			// rethrow exception to the caller
			throw(new \RangeException($range->getMessage(), 0, $range));
		} catch(\TypeError $typeError) {
			// rethrow exception to the caller
			throw(new \TypeError($typeError->getMessage(), 0, $typeError));
		} catch(\Exception $exception) {
			// rethrow exception to the caller
			throw(new \Exception($exception->getMessage(), 0, $exception));
		}
	}

	/**
	 * accessor method for commentImageId
	 *
	 * @return int|null value of commentImageId
	 */
	public function getCommentImageId()
}