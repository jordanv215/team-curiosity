<?php require_once("header.php");?>


<div class="container-fluid">
<div class="row heading-row">
	<div >
	<h1 class="col-sm-6 txt-2">redrovr</h1>
	</div>
	<div>
	<h2 class="col-sm-6 txt-3">Images</h2>
	</div>
	<hr style="clear:both;" id="heading-hr"/>
</div>

	<div ng-controller="imagesController">
		<div style="height: 305px">
			<div uib-carousel active="active" interval="myInterval" no-wrap="noWrapSlides">
				<div uib-slide ng-repeat="image in images" index="active">
					<img ng-src="{{image.imagePath}}" style="margin:auto;">
				</div>
			</div>
		</div>

	</div>

