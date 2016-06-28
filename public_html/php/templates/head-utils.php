<!DOCTYPE html>
<html ng-app="redRovr" lang="en">
	<head>
		<meta charset="UTF-8">
		<!-- sets IE rendering to IE-EDGE -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<!-- sets viewport width to device width, scaling 1:1 -->
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<!-- for google sign -->
		<meta name="google-signin-client_id" content="148844505760-ul88sbvg1kppr9emjv1a2bhef0lghjvk.apps.googleusercontent.com">

		<base href="<?php echo dirname($_SERVER["PHP_SELF"]) . "/";?>"/>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
		
		<!-- HTML5 shiv and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- FontAwesome minified -------------->

		<link type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" />

		<!-- Google fonts ---------------------->
		<link href='https://fonts.googleapis.com/css?family=Nova+Square' rel='stylesheet' type='text/css'>
		<!--test for weather -->
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

		<!-- OUR CUSTOM CSS -->
		<link rel="stylesheet" href="css/style.css" type="text/css">

		<!-- jQuery -->
		<script src="https://code.jquery.com/jquery-2.2.3.min.js"   integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<!-- google signin -->
		<script src="https://apis.google.com/js/platform.js" async defer></script>
		<!--Angular JS Libraries-->
		<?php $ANGULAR_VERSION = "1.5.6";?>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular.min.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-route.js"></script>
		<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/angularjs/<?php echo $ANGULAR_VERSION;?>/angular-messages.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular.js/<?php echo $ANGULAR_VERSION;?>/angular-animate.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/1.3.3/ui-bootstrap-tpls.min.js"></script>
		<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/angular.js/<?php echo $ANGULAR_VERSION;?>/angular-touch.min.js"

		

		<!--custom js-->
			<script src="js/carousel-box.js"></script>

		<!--loading Angular app files -->
		<script src="angular/redrovr.js"></script>
		<script src="angular/route-config.js"></script>
		<script src="angular/directives/bootstrap-breakpoint.js"></script>
		<script src="angular/services/weather-service.js"></script>
		<script src="angular/services/image-service.js"></script>
		<script src="angular/services/news-service.js"></script>
		<script src="angular/services/login-service.js"></script>
		<script src="angular/controller/nav-controller.js"></script>
		<script src="angular/controller/home-controller.js"></script>
		<script src="angular/controller/images-controller.js"></script>
		<script src="angular/controller/news-controller.js"></script>
		<script src="angular/controller/about-controller.js"></script>

		<link rel="icon" href="img/favicon-take1.png"/>
		<title>redrovr</title>
	</head>