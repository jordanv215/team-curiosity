<?php require_once("header.php");?>
<div ng-controller="CarouselDemoCtrl">
	<div style="height: 305px">
		<uib-carousel active="active" interval="myInterval" no-wrap="noWrapSlides">
			<uib-slide ng-repeat="slide in slides track by slide.id" index="slide.id">
				<img ng-src="{{slide.image}}" style="margin:auto;">
			</uib-slide>
		</uib-carousel>
	</div>
