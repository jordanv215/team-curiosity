<?php require_once("header.php"); ?>
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

	<div>

		<div class="row">
			<div class="col-md-8 col-md-offset-2 panel panel-primary panel-transparent" ng-repeat="news in news"
				  style="background:linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)), url({{news.newsArticleThumbPath}}) center center; background-size: cover;">
				<h2 class="news-header">{{ news.newsArticleTitle }}</h2>
				<p class="news-content">{{ news.newsArticleDate | date }}</p>
				<p class="news-content">{{ news.newsArticleSynopsis }}</p>
				<div class="news-link">
					<a href="{{ news.newsArticleUrl }}" target="_blank">Read more&hellip;</a>
					<br/>
					<a href="article">Comment or favorite</a>
				</div>
			</div>
		</div>
	</div>


</div>
