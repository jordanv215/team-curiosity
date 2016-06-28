// Get profile information of google user after sign in
function onSignIn(googleUser) {
	var profile = googleUser.getBasicProfile();
	console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
	console.log('Name: ' + profile.getName());
	console.log('Image URL: ' + profile.getImageUrl());
	console.log('Email: ' + profile.getEmail());
}

// auth2 is initialized with gapi.auth2.init() and a user is signed in.
if (auth2.isSignedIn.get()) {
	var profile = auth2.currentUser.get().getBasicProfile();
	console.log('ID: ' + profile.getId());
	console.log('Full Name: ' + profile.getName());
	console.log('Given Name: ' + profile.getGivenName());
	console.log('Family Name: ' + profile.getFamilyName());
	console.log('Image URL: ' + profile.getImageUrl());
	console.log('Email: ' + profile.getEmail());
}

// get the user's ID token
function onSignIn(googleUser) {
	var id_token = googleUser.getAuthResponse().id_token;
}

// send the ID token to your server with an HTTPS POST request
var xhr = new XMLHttpRequest();
xhr.open('POST', 'php/apis/googleapi');
xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
xhr.onload = function() {
	console.log('Signed in as: ' + xhr.responseText);
};
xhr.send('idtoken=' + id_token);



