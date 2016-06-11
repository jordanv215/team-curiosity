<?php require_once("header.php");?>
<header ng-include="/image-full.php">
</header>
<div class="row carousel-row">
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
</div>

<div class="random-img-wrapper">
	<div class="row">
		<div class="col-xs-4 img-1">
			<img class="img-responsive" src="../public_html/image/mars.png" alt="mars">
		</div>
		<div class="col-xs-4 img-1">
			<img class="img-responsive" src="../public_html/image/mars.png" alt="mars">
		</div>
		<div class="col-xs-4 img-1">
			<img class="img-responsive" src="../public_html/image/mars.png" alt="mars">
		</div>
	</div>
</div>