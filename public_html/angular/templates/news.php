<?php require_once("header.php");?>

<div class="container-fluid">
	<h1 class="txt-2" style="text-align:left;float:left;">redrovr</h1>
	<h2 class="txt-3" style="text-align:right;float:right;">News</h2>
	<hr style="clear:both;"/>
	
</div>
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
</div>
