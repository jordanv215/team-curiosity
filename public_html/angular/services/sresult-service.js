app.constant("SRESULT_ENDPOINT", "php/apis/image/");
app.service("SresultService", function($http, SRESULT_ENDPOINT) {
	function getUrl() {
		return(SRESULT_ENDPOINT);
	}
	function getUrlForId(sresultId) {
		return(getUrl() + sresultId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(sresultId) {
		return($http.get(getUrlForId(sresultId)));
	};

});