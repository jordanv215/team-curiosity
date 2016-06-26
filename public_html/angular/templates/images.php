<?php require_once("header.php");?>

<!--div class="container-fluid">
	<div class="txt-2">
		<h3 class="txt-2">redrovr</h3>
		<h3 class="txt-3">Images</h3>
	</div
</div-->

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


	<div ng-controller="CarouselDemoCtrl">
		<div style="height: 305px">
			<uib-carousel active="active" interval="myInterval" no-wrap="noWrapSlides">
				<uib-slide ng-repeat="slide in slides track by slide.id" index="slide.id">
					<img ng-src="{{slide.image}}" style="margin:auto;">
				</uib-slide>
			</uib-carousel>
		</div>
		<div class="row">
			<div class="col-md-6">
				<button type="button" class="btn btn-info" ng-click="addSlide()">Add Slide</button>
				<button type="button" class="btn btn-info" ng-click="randomize()">Randomize slides</button>
				<div class="checkbox">
					<label>
						<input type="checkbox" ng-model="noWrapSlides">
						Disable Slide Looping
					</label>
				</div>
			</div>
			<div class="col-md-6">
				Interval, in milliseconds: <input type="number" class="form-control" ng-model="myInterval">
				<br />Enter a negative number or 0 to stop the interval.
			</div>
		</div>
	</div>

	<!-- ui.bootstrap.modal -->
	<div ng-controller="ModalDemoCtrl">
		<script type="text/ng-template" id="myModalContent.html">
			<div class="modal-header">
				<h3 class="modal-title">Comment or Favorite</h3>
				<a href="https://www.reddit.com/" target="_blank"><i class="fa fa-reddit-alien fa-2x"></i></a>
				<a href="#" target="_blank"><i class="fa fa-heart fa-2x"></i></a>
				<a href="#" target="_blank"><i class="fa fa-commenting fa-2x"></i></a>
				<a href="#" target="_blank"><i class="fa fa-commenting fa-2x"></i></a>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button class="btn btn-warning" type="button" ng-click="cancel()">Close</button>
			</div>
		</script>

	</div>
</div>