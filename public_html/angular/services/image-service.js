app.constant("IMAGE_ENDPOINT", "php/apis/image/");
app.service("ImageService", function($http, IMAGE_ENDPOINT) {
	function getUrl() {
		return(IMAGE_ENDPOINT);
	}
	function getUrlForId(imageId) {
		return(getUrl() + imageId);
	}

	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(imageId) {
		return($http.get(getUrlForId(imageId)));
	};

});