<?php require_once("header.php");?>

	<div class="row">
		<div class="col-sm-6">
	<h1 class="txt-2">redrovr</h1>
			</div>
			<div class="col-sm-6">
	<h2 class="txt-3">News</h2>
				</div>
	<hr style="clear:both;" id="heading-hr"/>

<!--<header ng-include="/news-full.php">-->
<!--</header>-->
<div class="row carousel-row">
<div id="newsCarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
		<div class="item active">
			<div class="carousel-header">
				<h3 class="news-header">Second Cycle of Martian Seasons Completing for Curiosity Rover</h3>
				<p class="news-content">NASA's Curiosity Mars rover has completed its second Martian year since landing in 2012, recording environmental patterns through two full cycles of Martian seasons.</p>
				<div class="news-content">
				<a href="http://mars.jpl.nasa.gov/msl/news/whatsnew/index.cfm?FuseAction=ShowNews&NewsID=1908">Read more&hellip;</a>
					</div>
			</div>
		</div>
		<div class="item">
			<div class="carousel-header">
				<h3 class="news-header">Curiosity Mars Rover Crosses Rugged Plateau</h3>
				</div>
				<p class="news-content">NASA's Curiosity Mars rover has nearly finished crossing a stretch of the most rugged and difficult-to-navigate terrain encountered during the mission's 44 months on Mars.</p>
				<div class="news-content">
				<a href="http://mars.jpl.nasa.gov/msl/news/whatsnew/index.cfm?FuseAction=ShowNews&NewsID=1906">Read more&hellip;</a>
				
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
</div>
