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
				<div style="background:url(../public_html/img/sunset.gif) center center;
          background-size:cover;" class="slider-size">
					</div>
			</div>

			<div class="item">
				<div style="background:url(../public_html/img/mars-landscape.jpg) center center;
          background-size:cover;" class="slider-size">
					</div>
			</div>
			
			<div class="item">
				<div style="background:url(../public_html/img/above-shot.jpg) center center;
          background-size:cover;" class="slider-size">
				</div>
			</div>

			<div class="item">
				<div style="background:url(../public_html/img/mt-sharp.jpg) center center;
          background-size:cover;" class="slider-size">
				</div>
			</div>
			
			<div class="item">
				<div style="background:url(../public_html/img/selfie-optimized.jpg) center center;
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

	<div class="col-md-6" ngController="homeController">
		<div id="newsCarouselSplash" class="carousel slide" data-ride="carousel">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#newsCarouselSplash" data-slide-to="$index" class="active"></li>
			</ol>

			<!-- Wrapper for slides -->
			<div class="carousel-inner" role="listbox">
				<div class="item" ng-class="{active: $index == 0}" ng-repeat="news in news">
					<div style="background:linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url({{ news. newsArticleThumbPath }}) center center;
          background-size:cover;" class="slider-size">
					<div class="carousel-header">
						<h3 class="news-header">{{ news.newsArticleTitle }}</h3>
						</div>
						<p class="news-content">{{ news.newsArticleDate | date }}</p>
						<p class="news-content">{{ news.newsArticleSynopsis }}</p>
						<div class="news-content">
							<a href="{{ news.newsArticleUrl }}" target="_blank">Read more&hellip;</a>
						</div>
					</div>
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





