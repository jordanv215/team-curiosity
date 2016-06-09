<header ng-include="/header.php">
</header>
	<div class="row">
		<div class="col-xs-12">
			<div class="col-xs-3">
				<div class="big-box">10</div>
				<div class="mini-box">High</div>
			</div><!-- column for max temperature-->
			<div class="col-xs-3">
				<div class="big-box">-90</div>
				<div class="mini-box">Low</div>
			</div><!-- column for min_temp-->
			<div class="col-xs-3">
				<div class="mini-box">Sol 1280</div>
				<div class="row">750</div>
				<div class="mini-box">Pressure (Pa)</div>
			</div>
			<div class="col-xs-3">
				<div class="mini-box">2016-06-05</div>
				<div class="row">Sunny</div>
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

	




