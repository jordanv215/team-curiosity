app.controller("newsController", ["$scope", "NewsService", function($scope, NewsService) {
	$scope.news = [];

	$scope.getNews = function() {
		NewsService.fetchNews()
			.then(function(result) {
				if(result.status === 200) {
					$scope.news = result.data;
				} else {
					console.log("couldn't load news articles: " + result.data.message);
				}
			});
	};
	// load the array on first view
	if($scope.news.length === 0) {
		$scope.news = $scope.getNews();
	}
}]);