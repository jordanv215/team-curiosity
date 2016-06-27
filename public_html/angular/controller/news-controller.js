app.controller("newsController", ["$scope", "NewsService", function($scope, NewsService) {
	$scope.myInterval = 5000;
	$scope.noWrapSlides = false;
	$scope.active = 0;
	var news = $scope.news = [];
	var currIndex = 0;

	$scope.getNews = function() {
		NewsService.top25()
			.then(function(result) {
				if(result.status === 200) {
					$scope.news = result.data.data;
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

