app.controller("NavController", ["$http", "$scope", function($http, $scope) {
	$scope.breakpoint = null;
	$scope.navCollapsed = null;
	$scope.pages = [];

	// collapse the navbar if the screen is changed to a extra small screen
	$scope.$watch("breakpoint", function() {
		$scope.navCollapsed = ($scope.breakpoint === "xs");
	});
}]);