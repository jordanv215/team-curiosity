<?php
$curl = curl_init();
curl_setopt_array($curl, Array(
	CURLOPT_URL            => 'http://mars.nasa.gov/rss/news.cfm?s=msl',
	CURLOPT_USERAGENT      => 'spider',
	CURLOPT_TIMEOUT        => 120,
	CURLOPT_CONNECTTIMEOUT => 30,
	CURLOPT_RETURNTRANSFER => TRUE,
	CURLOPT_ENCODING       => 'UTF-8'
));
$data = curl_exec($curl);
curl_close($curl);
$xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
//die('<pre>' . print_r($xml], TRUE) . '</pre>');
?>
<!DOCTYPE html>
<html>
	<head>
		<title></title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	</head>
	<body>

		<?php foreach ($xml->channel->item as $item) {
			$creator = $item->children('dc', TRUE);
			echo '<h2>' . $item->title . '</h2>';
			echo '<p>Created: ' . $item->pubDate . '</p>';
			echo '<p>Author: ' . $creator . '</p>';
			echo '<p>' . $item->description . '</p>';
			echo '<p><a href="' . $item->link . '">Read more: ' . $item->title . '</a></p>';
		}
		?>

	</body>
</html>