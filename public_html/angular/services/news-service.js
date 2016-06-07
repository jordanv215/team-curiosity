app.constant("NEWS_ENDPOINT", "../../php/apis/newsarticle/");
app.service("NewsService", function($http, NEWS_ENDPOINT) {
	function getUrl() {
		return(NEWS_ENDPOINT);
	}


	this.fetchNews = function() {
		return($http.get(getUrl()))
	}
});