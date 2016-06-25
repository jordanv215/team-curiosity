app.constant("RESULT_ENDPOINT", "php/apis/image/");
app.service("ResultService", function($http, RESULT_ENDPOINT) {
	function getUrl() {
		return(RESULT_ENDPOINT);
	}
	function getUrlForId(resultId) {
		return(getUrl() + resultId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(resultId) {
		return($http.get(getUrlForId(resultId)));
	};

});