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

}