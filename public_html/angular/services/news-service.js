app.constant("NEWS_ENDPOINT", "php/apis/newsarticle/");
app.service("NewsService", function($http, NEWS_ENDPOINT) {
	function getUrl() {
		return(NEWS_ENDPOINT);
	}
	function getUrlForId(newsArticleId) {
		return(getUrl() + newsArticleId);
	}
	function getUrlForUrl(newsArticleUrl) {
		return(getUrl() + newsArticleUrl);
	}
	this.all = function() {
		return($http.get(getUrl()));
	};

	this.fetch = function(newsArticleId) {
		return($http.get(getUrlForId(newsArticleId)));
	};


	this.fetchNews = function() {
		return($http.get(getUrl()))
	}
	
});