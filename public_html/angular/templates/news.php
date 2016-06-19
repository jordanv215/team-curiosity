<?php require_once("header.php");?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-6">
	<h1 class="txt-2">redrovr</h1>
			</div>
			<div class="col-sm-6">
	<h2 class="txt-3">News</h2>
				</div>
	<hr style="clear:both;" id="heading-hr"/>
	</div>

<!--<header ng-include="/news-full.php">-->
<!--</header>-->
<div class="row carousel-row" ngController="newsController">
<div id="newsCarousel" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
	</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox" >
		<div class="item" ng-class="{active: $index == 0}" ng-repeat="news in news">
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