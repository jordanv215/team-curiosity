<!DOCTYPE html>
<html ng-app="redRovr" lang="en">
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

			<div class="row">
				<div class="col-xs-12">
					<div class="col-xs-3">
						<div class="big-box">{{}}</div>
						<div class="mini-box">High</div>
					</div><!-- column for max temperature-->
					<div class="col-xs-3">
						<div class="big-box">{{}}</div>
						<div class="mini-box">Low</div>
					</div><!-- column for min_temp-->
					<div class="col-xs-3">
						<div class="mini-box">Sol {{1280}}</div>
						<div class="row">{{}}</div>
						<div class="mini-box">Pressure (Pa)</div>
					</div>
					<div class="col-xs-3">
						<div class="mini-box">{{2016-06-05}}</div>
						<div class="row">{{Sunny}}</div>
						<div class="mini-box">Sky</div>
					</div>
				</div><!--main weather column -->
			</div><!-- row for weather-->
		<!--these columbs will contain our two image carousels. They aren't centered right now, but they're there for future needs and they're the same width.-->
		<div class="border row">
			<div class="border col-lg-6">carousel1</div>
			<div class="border col-lg-6">carousel2</div>
		</div>
		<!-- navbar -->
		<nav class="navbar navbar-inverse">
			<div class="container ng-1">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">REDROVR</a>
				</div>
				<div class="collapse navbar-collapse" id="myNavbar">
					<ul class="nav navbar-nav navbar-right">
						<li><a>Images</a></li>
						<li><a>News</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Search
								<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="#">News</a></li>
								<li><a href="#">Images</a></li>
							</ul>
					</ul>
				</div>
			</div>
		</nav>
		<!--this footer is just a copy of the navbar used in the placeholder-header. It will be at the bottom of the page once we add carousels into the main area.-->
	</body>