app.controller("newsController", ["$scope", "NewsService", function($scope, NewsService) {
	$scope.myInterval = 5000;
	$scope.noWrapNews = false;
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
	$scope.addNews = function() {
		var newWidth = 600 + news.length + 1;
		news.push({
			id: currIndex++
		});
	};

	$scope.randomize = function() {
		var indexes = generateIndexesArray();
		assignNewIndexesToNews(indexes);
	};

	for (var i = 0; i < 25; i++) {
		$scope.addNews();
	}

// Randomize logic below

	function assignNewIndexesToNews(indexes) {
		for (var i = 0, l = news.length; i < l; i++) {
			news[i].id = indexes.pop();
		}
	}

	function generateIndexesArray() {
		var indexes = [];
		for (var i = 0; i < currIndex; ++i) {
			indexes[i] = i;
		}
		return shuffle(indexes);
	}

// http://stackoverflow.com/questions/962802#962890
	function shuffle(array) {
		var tmp, current, top = array.length;

		if (top) {
			while (--top) {
				current = Math.floor(Math.random() * (top + 1));
				tmp = array[current];
				array[current] = array[top];
				array[top] = tmp;
			}
		}

		return array;
	}
	// load the array on first view
	if($scope.news.length === 0) {
		$scope.news = $scope.getNews();
	}
}]);