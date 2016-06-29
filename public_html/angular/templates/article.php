<?php require_once("header.php");?>
<div ng-controller="ArticleController">

</div>

<div class="row">
	<div class="h4 col-sm-4 col-sm-offset-2">Share, Favorite or Comment<br>
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
				<script>
					// This is called with the results from from FB.getLoginStatus().
					function statusChangeCallback(response) {
						console.log('statusChangeCallback');
						console.log(response);
						// The response object is returned with a status field that lets the
						// app know the current login status of the person.
						// Full docs on the response object can be found in the documentation
						// for FB.getLoginStatus().
						if (response.status === 'connected') {
							// Logged into your app and Facebook.
							testAPI();
						} else if (response.status === 'not_authorized') {
							// The person is logged into Facebook, but not your app.
							document.getElementById('status').innerHTML = 'Please log ' +
								'into this app.';
						} else {
							// The person is not logged into Facebook, so we're not sure if
							// they are logged into this app or not.
							document.getElementById('status').innerHTML = 'Please log ' +
								'into Facebook.';
						}
					}

					// This function is called when someone finishes with the Login
					// Button.  See the onlogin handler attached to it in the sample
					// code below.
					function checkLoginState() {
						FB.getLoginStatus(function(response) {
							statusChangeCallback(response);
						});
					}

					window.fbAsyncInit = function() {
						FB.init({
							appId      : '1701694373430554',
							cookie     : true,  // enable cookies to allow the server to access
													  // the session
							xfbml      : true,  // parse social plugins on this page
							version    : 'v2.5' // use graph api version 2.5
						});

						// Now that we've initialized the JavaScript SDK, we call
						// FB.getLoginStatus().  This function gets the state of the
						// person visiting this page and can return one of three states to
						// the callback you provide.  They can be:
						//
						// 1. Logged into your app ('connected')
						// 2. Logged into Facebook, but not your app ('not_authorized')
						// 3. Not logged into Facebook and can't tell if they are logged into
						//    your app or not.
						//
						// These three cases are handled in the callback function.

						FB.getLoginStatus(function(response) {
							statusChangeCallback(response);
						});

					};

					// Load the SDK asynchronously
					(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/en_US/sdk.js";
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));

					// Here we run a very simple test of the Graph API after login is
					// successful.  See statusChangeCallback() for when this call is made.
					function testAPI() {
						console.log('Welcome!  Fetching your information.... ');
						FB.api('/me', function(response) {
							console.log('Successful login for: ' + response.name);
							document.getElementById('status').innerHTML =
								'Thanks for logging in, ' + response.name + '!';
						});
					}
				</script>
				<div id="fb-root"></div>
				<script>(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.6";
						fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>

				<div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false"></div>

			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
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
				<h4 class="modal-title" id="googleModalLabel">Log in to your Google Account</h4>
			</div>
			<div class="modal-body" id="googleModal">
				<div id="my-signin2"></div>
				<script>
					function onSuccess(googleUser) {
						console.log('Logged in as: ' + googleUser.getBasicProfile().getName());
					}
					function onFailure(error) {
						console.log(error);
					}
					function renderButton() {
						gapi.signin2.render('my-signin2', {
							'scope': 'profile email',
							'width': 240,
							'height': 50,
							'longtitle': true,
							'theme': 'dark',
							'onsuccess': onSuccess,
							'onfailure': onFailure
						});
					}
				</script>

				<script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>
			<div class="modal-footer">
				<botton type="button" class="btn btn-info"><a href="#" onclick="signOut();">Sign out with Google</a>
					<script>
						function signOut() {
							var auth2 = gapi.auth2.getAuthInstance();
							auth2.signOut().then(function () {
								console.log('User signed out.');
							});
						}
					</script></botton>
				<button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
			</div>	
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