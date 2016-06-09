app.controller("searchController", ["$scope", "GoogleService", function($scope, GoogleService) {
	$scope.header = [];

	/**
	 * fulfills the promise from retrieving the header and search bar data
	 **/
	$scope.searchHeader = function(name) {
		GoogleService.fetchName(name)
			.then(function(result) {
				if(result.status === 200) {
					$scope.header = result.data;
				} else {
					console.log("couldn't load the header data: " + result.data.message);
				}
			});
	};

	// load the array on first view
	if($scope.header.length === 0) {
		$scope.header = $scope.searchHeader();
	}
}]);