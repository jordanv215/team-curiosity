<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RedRovr.io</title>

		<meta charset="utf-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
				integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">


		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
				integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- fontawesome -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css">

		<!-- HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- CUSTOM CSS -->
		<link rel="stylesheet" href="css/style.css" type="text/css">

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-2.2.3.min.js"
				  integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
				  integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
				  crossorigin="anonymous"></script>
	</head>

	<body>


		<div ng-controller="newsController">
			<div class="item" style="height: 300px">
				<uib-carousel active="active" interval="myInterval" no-wrap="noWrapSlides">
					<uib-slide ng-class="{active: $index == 0}" ng-repeat="news in news">
						<div class="carousel-header">
							<h3 class="news-header">{{ news.newsArticleTitle }}</h3>
						</div>
						<p class="news-content">{{ news.newsArticleDate | date }}</p>
						<p class="news-content">{{ news.newsArticleSynopsis }}</p>
						<div class="news-content">
							<a href="{{ news.newsArticleUrl }}" target="_blank">Read more&hellip;</a>
						</div>
						<div class="text-center"><a href="news-modal.php">Click to comment or favorite</a></div>
			</div>
					</uib-slide>
				</uib-carousel>
			</div>
		</div>

		<!-- This is controller for Angular carousel for news -->


		app.controller("newsController", ["$scope", "NewsService", function($scope, NewsService) {
		$scope.myInterval = 5000;
		$scope.noWrapSlides = false;
		$scope.active = 0;
		var news = $scope.news = [];
		var currIndex = 0;

		$scope.addNew = function() {
		var newWidth = 600 + news.length + 1;
		news.push({
		id: currIndex++
		});
		};

		$scope.randomize = function() {
		var indexes = generateIndexesArray();
		assignNewIndexesToNews(indexes);
		};

		for (var i = 0; i < 25; i++) {
		$scope.addNew();
		}

		// Randomize logic below

		function assignNewIndexesToNews(indexes) {
		for (var i = 0, l = news.length; i < l; i++) {
		news[i].id = indexes.pop();
		}
		}

		function generateIndexesArray() {
		var indexes = [];
		for (var i = 0; i < currIndex; ++i) {
		indexes[i] = i;
		}
		return shuffle(indexes);
		}

		// http://stackoverflow.com/questions/962802#962890
		function shuffle(array) {
		var tmp, current, top = array.length;

		if (top) {
		while (--top) {
		current = Math.floor(Math.random() * (top + 1));
		tmp = array[current];
		array[current] = array[top];
		array[top] = tmp;
		}
		}

		return array;
		}
		});