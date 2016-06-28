app.constant("LOGIN_ENDPOINT", "php/apis/loginsource/");
app.service("LoginService", function($http, LOGIN_ENDPOINT) {
	function getUrl() {
		return(LOGIN_ENDPOINT);
	}
	function getUrlForId(loginsourceId) {
		return(getUrl() + loginsourceId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(loginsourceId) {
		return($http.get(getUrlForId(loginsourceId)));
	};

});