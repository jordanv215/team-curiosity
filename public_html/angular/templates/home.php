<?php require_once("header.php");?>
<div class="row" ng-if="weather == null" id="earth">
	<h2 class="text-center"><i class="fa fa-globe fa-spin" aria-hidden="true"></i> Loading weather data&hellip;</h2>
</div>
	<div class="row" ng-if="weather != null" id="weather">
		<div class="col-xs-12">
			<div class="col-xs-6 col-sm-3">
				<div class="big-box" id="temp">{{ weather.max_temp }} &deg;<small>F</small></div>
				<div class="mini-box">High</div>
			</div><!-- column for max temperature-->
			<div class="col-xs-6 col-sm-3">
				<div class="big-box" id="temp">{{ weather.min_temp }} &deg;<small>F</small></div>
				<div class="mini-box">Low</div>
			</div><!-- column for min_temp-->
			<div class="col-xs-6 col-sm-3">
				<div class="mini-box" id="date">Sol {{ weather.sol }}</div>
				<div class="row" id="pressure">{{ weather.pressure }} Pa</div>
				<div class="mini-box">Pressure</div>
			</div>
			<div class="col-xs-6 col-sm-3">
				<div class="mini-box" id="date">{{ weather.terrestrial_date }}</div>
				<div class="row" id="pressure">{{ weather.atmo_opacity }}</div>
				<div class="mini-box">Sky</div>
			</div>
		</div><!--main weather column -->
	</div><!-- row for weather-->


<!-- Red Rovr on background -->
<div class="container-fluid">
<div class="bg-1 rr-splash-wrapper">
	<h1 class="rr-splash">redrovr</h1>
</div
</div>

	<!-----------/// Carousels for home page ///------------->
<div class="row carousel-row">

<!--// Image carousel: left on desktop //-->

<div class="col-md-6">
	<div id="imageCarouselSplash" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#imageCarouselSplash" data-slide-to="0" class="active"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="../public_html/image/sunset.gif" alt="sunset">
			</div>

			<div class="item">
				<img src="../public_html/image/mars-landscape.jpg" alt="mars-surface">
			</div>
			
			<div class="item">
				<img src="../public_html/image/above-shot.jpg" alt="above-shot">
			</div>

			<div class="item">
				<img src="../public_html/image/mt-sharp" alt="mt-sharp">
			</div>
			
			<div class="item">
				<img src="../public_html/image/rover-selfie" alt="selfie">
			</div>

		</div>

		<!-- Left and right controls -->
		<a class="left carousel-control" href="#imageCarouselSplash" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#imageCarouselSplash" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</div>
	<!-- Wrapper for slides -->

	<div class="col-md-6">
		<div id="newsCarouselSplash" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#newsCarouselSplash" data-slide-to="0" class="active"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item active">
					<div class="carousel-header">
						<h3>{{newsArticle.title}}</h3>
						<p>{{newsArticle.description}}</p>
					</div>
				</div>

				<!-- Left and right controls -->
				<a class="left carousel-control" href="#newsCarouselSplash" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#newsCarouselSplash" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div>



	




