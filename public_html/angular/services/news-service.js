app.constant("NEWS_ENDPOINT", "php/apis/newsarticle/");
app.service("NewsService", function($http, NEWS_ENDPOINT) {
	function getUrl() {
		return(NEWS_ENDPOINT);
	}
	function getUrlForId(newsArticleId) {
		return($http.get(getUrl() + newsArticleId));
	}
	
	this.top25 = function() {
		return($http.get(getUrl() + "?top25"));
	};
	
});