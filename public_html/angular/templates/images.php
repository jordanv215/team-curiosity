<?php require_once("header.php");?>

<!--div class="container-fluid">
	<div class="txt-2">
		<h3 class="txt-2">redrovr</h3>
		<h3 class="txt-3">Images</h3>
	</div
</div-->


<div class="container-fluid">
	<h1 class="txt-2" style="text-align:left;float:left;">redrovr</h1>
	<h2 class="txt-3" style="text-align:right;float:right;">Images</h2>
	<hr style="clear:both;"/>
</div>

<div class="row carousel-row">
<div id="imageCarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#imageCarousel" data-slide-to="0" class="active"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<div class="item active">
			<img src="../public_html/image/above-shot.jpg" alt="Above-Mars">
			<div class="carousel-caption">
				<h3>Orbit Shot</h3>
				<p>This picture was taken by an orbiting satellite around Mars.</p>
			</div>
		</div>
		
		

		<div class="item">
			<img src="../public_html/image/mars-landscape.jpg" alt="landscape-mars">
			<div class="carousel-caption">
				<h3>Sand and Rock</h3>
				<p>Here you can see a wideshot picture of the landscape of Mars' surface, covered in sand dunes and bits of rock.</p>
			</div>
		</div>

		<div class="item">
			<img src="../public_html/image/sunset.gif" alt="Mars-sunset">
			<div class="carousel-caption">
				<h3>A Sunset On Mars</h3>
				<p>Due to atmospheric differences between Earth and Mars, sunsets look a bit more bland and unexciting on the Red Planet.</p>
			</div>
		</div>


		<div class="item">
			<img src="../public_html/image/selfie-optimized.jpg" alt="selfie">
			<div class="carousel-caption">
				<h3>Rover Selfie</h3>
				<p>The Curiosity Rover takes a full-shot selfie while traveling on the surface of Mars. I'd like to see 10 year olds with $700 iPhones compete with that.</p>
			</div>
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
