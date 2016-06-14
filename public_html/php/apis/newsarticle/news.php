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


foreach ($xml->channel->item as $item) {
	echo $item->title;
	echo '<br>';
	echo $item->pubDate;
	echo $item->description;
	echo $item->link;
	echo '<br><br>';
	}

