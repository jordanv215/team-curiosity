app.controller("sresultController", ["$scope", "SresultService", function($scope, sresultService) {
	$scope.myInterval = 5000;
	$scope.noWrapSlides = false;
	$scope.active = 0;
	var sresults = $scope.sresults = [];
	var currIndex = 0;

	$scope.addSresult= function() {
		var newWidth = 600 + sresults.length + 1;
		sresults.push({
			image: 'http://lorempixel.com/' + newWidth + '/300',
			id: currIndex++
		});
	};

	$scope.randomize = function() {
		var indexes = generateIndexesArray();
		assignNewIndexesToSresults(indexes);
	};

	for (var i = 0; i < 4; i++) {
		$scope.addSresult();
	}


}]);