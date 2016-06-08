app.constant("IMAGE_ENDPOINT", "../../php/apis/image/");
app.service("ImageService", function($http, IMAGE_ENDPOINT) {
	function getUrl() {
		return(IMAGE_ENDPOINT);
	}


	this.fetchNews = function() {
		return($http.get(getUrl()))
	}
});