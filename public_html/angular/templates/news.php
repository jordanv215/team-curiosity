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
			<div class="col-xs-12" ng-repeat="news in news">
				<h2>{{ news.newsArticleTitle }}</h2>
				<p>{{ news.newsArticleDate | date }}</p>
				<p>{{ news.newsArticleSynopsis }}</p>
				<a href="{{ news.newsArticleUrl }}" target="_blank">Read more&hellip;</a>
				<a href="article">Comment or favorite</a>
			</div>
		</div>
	</div>


</div>
