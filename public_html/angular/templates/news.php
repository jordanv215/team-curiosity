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
	<div ng-controller="newsController">
		<div class="item" style="height: 300px">
			<uib-carousel  interval="myInterval" no-wrap="noWrapNews">
				<uib-slide ng-repeat="news in news" index=["0"]>
					<div class="carousel-header">
						<h3 class="news-header">{{ news.newsArticleTitle }}</h3>
					</div>
					<p class="news-content">{{ news.newsArticleDate | date }}</p>
					<p class="news-content">{{ news.newsArticleSynopsis }}</p>
					<div class="news-content">
						<a href="{{ news.newsArticleUrl }}" target="_blank">Read more&hellip;</a>
					</div>
					<div class="text-center"><a href="news-modal.php">Click to comment or favorite</a></div>
		</div>
		</uib-slide>
		</uib-carousel>
	</div>
</div>