<?php
require_once(dirname(__DIR__, 2) . "/classes/Autoload.php");
require_once(dirname(__DIR__, 2) . "/lib/xsrf.php");
require_once("/etc/apache2/redrovr-conf/encrypted-config.php");
use Redrovr\TeamCuriosity\NewsArticle;

/**
 * api for the NewsArticle class
 *
 * @author Anthony Williams <awilliams144@cnm.edu>
 * @author Kai Garrott <kai@kaigarrott.com>
 **/
//verify the session, start if not active
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
//prepare an empty reply
$reply = new stdClass();
$reply->status = 200;
$reply->data = null;
try {
	//grab the mySQL connection
	$pdo = connectToEncryptedMySQL("/etc/apache2/redrovr-conf/mars.ini");
	//determine which HTTP method was used
	$method = array_key_exists("HTTP_X_HTTP_METHOD", $_SERVER) ? $_SERVER["HTTP_X_HTTP_METHOD"] : $_SERVER["REQUEST_METHOD"];
	//sanitize input
	$newsArticleId = filter_input(INPUT_GET, "newsArticleId", FILTER_VALIDATE_INT);
	$newsArticleTitle = filter_input(INPUT_GET, "newsArticleTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$newsArticleDate = filter_input(INPUT_GET, "newsArticleDate", FILTER_VALIDATE_INT);
	$newsArticleSynopsis = filter_input(INPUT_GET, "newsArticleSynopsis", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$newsArticleUrl = filter_input(INPUT_GET, "newsArticleUrl", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$newsArticleThumbPath = filter_input(INPUT_GET, "newsArticleThumbPath", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	//make sure the id is valid for methods that require it
	if(($method === "DELETE" || $method === "PUT") && (empty($newsArticleId) === true || $newsArticleId < 0)) {
		throw(new InvalidArgumentException("id cannot be empty or negative", 405));
	}
	// handle GET request
	if($method === "GET") {
		//set XSRF cookie
		setXsrfCookie();
		//get a specific NewsArticle, multiple NewsArticles, or all NewsArticles, and update reply
		if(isset($_GET["top25"]) === true) {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'http://mars.nasa.gov/rss/news.cfm?s=msl',
				CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36',
				CURLOPT_TIMEOUT => 120,
				CURLOPT_CONNECTTIMEOUT => 30,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => 'UTF-8'
			));
			$data = curl_exec($curl);
			curl_close($curl);
			$xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
			$xml->channel->item->children("http://search.yahoo.com/mrss/");
			$pdo = connectToEncryptedMySQL("/etc/apache2/redrovr-conf/mars.ini");
			foreach($xml->channel->item as $item) {
				$newsArticleTitle = (string)$item->title;
				$newsArticleDate = (string)$item->pubDate;
				$newsArticleSynopsis = (string)$item->children("media", true)->description;
				$newsArticleUrl = (string)$item->link;
				$newsArticleDate = \DateTime::createFromFormat("D, d M Y H:i:s T", (string)trim($newsArticleDate));
				$urlString = (string)$item->children("media", true)->thumbnail->attributes()->url[0];
				$news = Redrovr\TeamCuriosity\NewsArticle::getNewsArticleByNewsArticleUrl($pdo, $newsArticleUrl);
				if($news === null) {
					$ext = substr($urlString, -4);
					if($ext === ".JPG" || $ext === ".jpg" || $ext === "JPEG" || $ext === "jpeg" || $ext === ".GIF" || $ext === ".gif" || $ext === ".PNG" || $ext === ".png") {
						$thumbTitle = md5($urlString);
						$w = 400;
						$imgOrig = file_get_contents($urlString);
						list($width, $height) = getimagesize($imgOrig);
						$prop = $w / $width;
						$newWidth = $width * $prop;
						$newHeight = $height * $prop;
						var_dump($_FILES);
						switch($ext) {
							/*case (".JPG" || ".jpg" || "JPEG" || "jpeg"):
								header('Content-type: image/jpeg');
								$e = ".jpg";
								$thumb_p = imagecreatetruecolor($newWidth, $newHeight);
								$thumb = imagecreatefromjpeg($_FILES['image']['tmp_name']);
								imagecopyresampled($thumb_p, $thumb, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
								imagejpeg($thumb_p, null, 90);
								var_dump($_FILES);
								break;
							case (".GIF" || ".gif"):
								//header('Content-type: image/gif');
								$e = ".gif";
								$thumb_p = imagecreatetruecolor($newWidth, $newHeight);
								$thumb = imagecreatefromgif($urlString);
								imagecopyresampled($thumb_p, $thumb, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
								imagegif($thumb_p, null);
								break;
							case (".PNG" || ".png"):
								//header('Content-type: image/png');
								$e = ".png";
								$thumb_p = imagecreatetruecolor($newWidth, $newHeight);
								$thumb = imagecreatefrompng($urlString);
								imagecopyresampled($thumb_p, $thumb, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
								imagepng($thumb_p, null, 90);
								break;*/
							default: continue;
						}
						//var_dump($_FILES);
						if($_FILES['image']['name']) {
							// store file on disk
							$savePath = "/var/www/html/media/news-thumbs";
							$addr = $savePath . "/" . $thumbTitle . $e;
							move_uploaded_file($_FILES['image']['tmp_name'], $addr);
							// add to database
							$newsArticleThumbPath = $addr;
							$newsArticle = new NewsArticle(null, $newsArticleTitle, $newsArticleDate, $newsArticleSynopsis, $newsArticleUrl, $newsArticleThumbPath);
							$newsArticle->insert($pdo);
						} else {
							continue;
						}
					} else {
						continue;
					}
				} else {
					continue;
				}
			}
			// grab 25 most recent articles from table
			$reply->data = NewsArticle::getNewsArticles($pdo);

		} else if(empty($newsArticleId) === false) {
			$newsArticle = NewsArticle::getNewsArticleByNewsArticleId($pdo, $newsArticleId);
			if($newsArticle !== null) {
				$reply->data = $newsArticle;
			}
		} else if(empty($newsArticleTitle) === false) {
			$newsArticles = NewsArticle::getNewsArticleByNewsArticleTitle($pdo, $newsArticleTitle);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		} else if(empty($newsArticleDate) === false) {
			$actualDate = DateTime::createFromFormat("U", $newsArticleDate / 1000);
			$newsArticles = NewsArticle::getNewsArticleByNewsArticleDate($pdo, $actualDate);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		} else if(empty($newsArticleSynopsis) === false) {
			$newsArticles = NewsArticle::getNewsArticleByNewsArticleSynopsis($pdo, $newsArticleSynopsis);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		} else if(empty($newsArticleUrl) === false) {
			$newsArticles = NewsArticle::getNewsArticleByNewsArticleUrl($pdo, $newsArticleUrl);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		} else {
			$newsArticles = NewsArticle::getAllNewsArticles($pdo);
			if($newsArticles !== null) {
				$reply->data = $newsArticles;
			}
		}
	} else if($method === "PUT" || $method === "POST") {
		verifyXsrf();
		$requestContent = file_get_contents("php://input");
		$requestObject = json_decode($requestContent);
		//make sure newsArticle is available
		if(empty($requestObject->newsArticleId) === true) {
			throw(new \InvalidArgumentException ("No NewsArticle to update", 405));
		}
		//perform the actual put or post
		if($method === "PUT") {
			// retrieve the newsArticle to update
			$newsArticle = NewsArticle::getNewsArticleByNewsArticleId($pdo, $newsArticleId);
			if($newsArticle === null) {
				throw(new RuntimeException("NewsArticle does not exist", 404));
			}
			// put the new newsArticle data into the newsArticle and update
			$newsArticle->setNewsArticleTitle($requestObject->newsArticleTitle);
			$newsArticle->setNewsArticleDate($requestObject->newsArticleDate);
			$newsArticle->setNewsArticleSynopsis($requestObject->newsArticleSynopsis);
			$newsArticle->setNewsArticleUrl($requestObject->newsArticleUrl);
			$newsArticle->setNewsArticleThumbPath($requestObject->newsArticleThumbPath);
			$newsArticle->update($pdo);
			// update reply
			$reply->message = "NewsArticle updated OK";
		} else if($method === "POST") {
			// make sure newsArticleId is available
			if(empty($requestObject->newsArticleId) === true) {
				throw(new \InvalidArgumentException ("No NewsArticle ID.", 405));
			}
			// create new newsArticle and insert into the database
			$newsArticle = new NewsArticle(null, $requestObject->newsArticleTitle, $requestObject->newsArticleDate, $requestObject->newsArticleSynopsis, $requestObject->newsArticleUrl, $requestObject->newsArticleThumbPath);
			$newsArticle->insert($pdo);
			// update reply
			$reply->message = "NewsArticle created OK";
		}
	} else if($method === "DELETE") {
		verifyXsrf();
		// retrieve the newsArticle to be deleted
		$newsArticle = NewsArticle::getNewsArticleByNewsArticleId($pdo, $newsArticleId);
		if($newsArticle === null) {
			throw(new RuntimeException("NewsArticle does not exist", 404));
		}
		// delete newsArticle
		$newsArticle->delete($pdo);
		// update reply
		$reply->message = "NewsArticle deleted OK";
	} else {
		throw (new InvalidArgumentException("Invalid HTTP method request"));
	}
	// update reply with exception information
} catch(Exception $exception) {
	$reply->status = $exception->getCode();
	$reply->message = $exception->getMessage();
	$reply->trace = $exception->getTraceAsString();
} catch(TypeError $typeError) {
	$reply->status = $typeError->getCode();
	$reply->message = $typeError->getMessage();
}
if($reply->data === null) {
	unset($reply->data);
}
// encode and return reply to front end caller
echo json_encode($reply);