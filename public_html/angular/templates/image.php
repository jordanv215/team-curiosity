<?php require_once("header.php");?>
<div ng-controller="ImageController">

</div>

<div class="row">
	<div class="h4 col-sm-6 col-sm-offset-1"">Share, Favorite or Comment<br>
	<a href="#" data-toggle="modal" data-target="#redditModal"><i class="fa fa-reddit-square fa-2x"></i></a>
	<a href="#" data-toggle="modal" data-target="#facebookModal"><i class="fa fa-facebook-square fa-2x"></i></a>
	<a href="#" data-toggle="modal" data-target="#googleModal"><i class="fa fa-google-plus-square fa-2x"></i></a>
	<a href="#" data-toggle="modal" data-target="#instagramModal"><i class="fa fa-instagram fa-2x"></i></a>
	<a href="#"><i class="fa fa-heart fa-2x"></i></a>
	<a href="#" data-toggle="modal" data-target="#commentModal"><i class="fa fa-commenting fa-2x"></i></a>
</div>
</div>

<!-- Modal for Reddit-->
<div class="modal fade" id="redditModal" tabindex="-1" role="dialog" aria-labelledby="redditModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="redditModalLabel">Log in with Reddit</h4>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Log in</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal for Facebook-->
<div class="modal fade" id="facebookModal" tabindex="-1" role="dialog" aria-labelledby="facebookModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="facebookModalLabel">Log in with Facebook</h4>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Log in</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal for Google-->
<div class="modal fade" id="googleModal" tabindex="-1" role="dialog" aria-labelledby="googleModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="googleModalLabel">Log in with Google</h4>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Log in</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal for Instagram-->
<div class="modal fade" id="instagramModal" tabindex="-1" role="dialog" aria-labelledby="instagramModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="instagramModalLabel">Log in with Instagram</h4>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Log in</button>
			</div>
		</div>
	</div>
</div>
<!-- Modal for comment-->
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="commentModalLabel">Log in to comment</h4>
			</div>
			<div class="modal-body">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Log in</button>
			</div>
		</div>
	</div>
</div>