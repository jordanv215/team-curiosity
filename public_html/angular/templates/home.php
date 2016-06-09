<?php require_once("header.php");?>
<div class="row" ng-if="weather == null">
	<h2 class="text-center"><i class="fa fa-space-shuttle fa-spin" aria-hidden="true"></i> Loading weather data&hellip;</h2>
</div>
	<div class="row" ng-if="weather != null">
		<div class="col-xs-12">
			<div class="col-xs-3">
				<div class="big-box">{{ weather.max_temp }}F</div>
				<div class="mini-box">High</div>
			</div><!-- column for max temperature-->
			<div class="col-xs-3">
				<div class="big-box">{{ weather.min_temp }}F</div>
				<div class="mini-box">Low</div>
			</div><!-- column for min_temp-->
			<div class="col-xs-3">
				<div class="mini-box">Sol {{ weather.sol }}</div>
				<div class="row">{{ weather.pressure }}</div>
				<div class="mini-box">Pressure (Pa)</div>
			</div>
			<div class="col-xs-3">
				<div class="mini-box">{{ weather.terrestrial_date }}</div>
				<div class="row">{{ weather.atmo_opacity }}</div>
				<div class="mini-box">Sky</div>
			</div>
		</div><!--main weather column -->
	</div><!-- row for weather-->
<!--these columns will contain our two content carousels. They aren't centered right now, but they're there for future needs and they're the same width.-->
<div id="imageCarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<div class="item active">
			<img src="../public_html/image/mars.png" alt="Mars">
		</div>

	</div>

	<!-- Left and right controls -->
	<a class="left carousel-control" href="#imageCarousel" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="right carousel-control" href="#imageCarousel" role="button" data-slide="next">
		<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
</div>

			<!-- Wrapper for slides -->
<div id="newsCarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
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
		<a class="left carousel-control" href="#newsCarousel" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#newsCarousel" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
</div>

	




