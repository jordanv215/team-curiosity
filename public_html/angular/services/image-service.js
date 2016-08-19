app.constant("IMAGE_ENDPOINT", "php/apis/image/");
app.service("ImagesService", function($http, IMAGE_ENDPOINT) {
	function getUrl() {
		return(IMAGE_ENDPOINT);
	}
	function getUrlForId(imageId) {
		return(getUrl() + imageId);
	}

	this.top25 = function() {
		return($http.get(getUrl() + "?top25"));
	};


	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(imageId) {
		return($http.get(getUrlForId(imageId)));
	};
	this.fetchImages = function() {
		return($http.get(getUrl()))
	}


});