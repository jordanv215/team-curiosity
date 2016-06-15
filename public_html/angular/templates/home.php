<?php require_once("header.php");?>
<div class="container-fluid">
	<div class="row" ng-if="weather == null" id="earth">
		<h2 class="text-center"><i class="fa fa-globe fa-spin" aria-hidden="true"></i> Loading weather data&hellip;</h2>
	</div>
</div>
<div class="container-fluid">
	<div class="row" ng-if="weather != null" id="weather">
		<div class="col-xs-3">
			<div class="big-box" id="temp">{{ weather.max_temp }} <small>&deg;F</small></div>
			<div class="mini-box weather-label">High</div>
		</div><!-- column for max temperature-->
		<div class="col-xs-3">
			<div class="big-box" id="temp">{{ weather.min_temp }} <small>&deg;F</small></div>
			<div class="mini-box weather-label">Low</div>
		</div><!-- column for min_temp-->
		<div class="col-xs-3">
			<div class="mini-box" id="date">Sol {{ weather.sol }}</div>
			<div class="row" id="pressure">{{ weather.pressure }} <small>Pa</small></div>
			<div class="mini-box weather-label">Pressure</div>
		</div>
		<div class="col-xs-3">
			<div class="mini-box" id="date">{{ weather.terrestrial_date }}</div>
			<div class="row" id="pressure">{{ weather.atmo_opacity }}</div>
			<div class="mini-box weather-label">Sky</div>
		</div>
	</div><!-- row for weather-->
</div>


<!-- Red Rovr on background -->
<div class="container-fluid">
<div class="bg-1 rr-splash-wrapper">
	<h1 class="rr-splash">redrovr</h1>
</div
</div>

	<!-----------/// Carousels for home page ///------------->
<div class="row carousel-row">

<!------// Image carousel: left on desktop //------->

<div class="col-md-6">
	<div id="imageCarouselSplash" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#imageCarouselSplash" data-slide-to="0" class="active"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<div style="background:url(../public_html/image/sunset.gif) center center;
          background-size:cover;" class="slider-size">
					</div>
			</div>

			<div class="item">
				<div style="background:url(../public_html/image/mars-landscape.jpg) center center;
          background-size:cover;" class="slider-size">
					</div>
			</div>
			
			<div class="item">
				<div style="background:url(../public_html/image/above-shot.jpg) center center;
          background-size:cover;" class="slider-size">
				</div>
			</div>

			<div class="item">
				<div style="background:url(../public_html/image/mt-sharp.jpg) center center;
          background-size:cover;" class="slider-size">
				</div>
			</div>
			
			<div class="item">
				<div style="background:url(../public_html/image/selfie-optimized.jpg) center center;
          background-size:cover;" class="slider-size">
				</div>
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
	<!--------// News carousel: right on desktop //-------------->
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
						<h3 class="news-header">Second Cycle of Martian Seasons Completing for Curiosity Rover</h3>
						</div>
						<p class="news-content">May 11, 2016</p>
						<p class="news-content">NASA's Curiosity Mars rover has completed its second Martian year since landing in 2012, recording environmental patterns through two full cycles of Martian seasons.</p>
						<div class="news-content">
							<a href="http://mars.jpl.nasa.gov/msl/news/whatsnew/index.cfm?FuseAction=ShowNews&NewsID=1908" target="_blank">Read more&hellip;</a>
						</div>
					</div>
				
				<div class="item">
					<div class="carousel-header">
						<h3 class="news-header">Curiosity Mars Rover Crosses Rugged Plateau</h3>
						<p class="news-content">April 27, 2016</p>
						<p class="news-content">NASA's Curiosity Mars rover has nearly finished crossing a stretch of the most rugged and difficult-to-navigate terrain encountered during the mission's 44 months on Mars.</p>
						<div class="news-content">
							<a<a href="http://mars.jpl.nasa.gov/msl/news/whatsnew/index.cfm?FuseAction=ShowNews&NewsID=1908" target="_blank">Read more&hellip;</a>
						</div>
					</div>
				</div>
				<!-- Left and right controls -->
				<a class="left carousel-control" href="#imageCarouselSplash" role="button" data-slide="prev" data-target="#imageCarousel">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#imageCarouselSplash" role="button" data-slide="next" data-target="#imageCarousel">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a> 
			</div>
		</div>
	</div>
</div>





