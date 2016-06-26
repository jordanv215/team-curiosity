app.controller("resultController", ["$scope", "resultService", function($scope, resultService) {
	$scope.myInterval = 5000;
	$scope.noWrapSlides = false;
	$scope.active = 0;
	var results = $scope.results = [];
	var currIndex = 0;

	$scope.addResult= function() {
		var newWidth = 600 + results.length + 1;
		results.push({
			image: 'http://lorempixel.com/' + newWidth + '/300',
			id: currIndex++
		});
	};

	$scope.randomize = function() {
		var indexes = generateIndexesArray();
		assignNewIndexesToResults(indexes);
	};

	for (var i = 0; i < 4; i++) {
		$scope.addResult();
	}


}]);