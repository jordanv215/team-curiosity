app.controller("homeController", ["$scope", "WeatherService", function($scope, WeatherService) {
	$scope.weather = null;
	
	$scope.getWeather = function() {
		WeatherService.fetchWeather()
			.then(function(result) {
				if(result.status === 200) {
					$scope.weather = result.data;
				}
			});
	};
	// load the array on first view
	if($scope.weather === null) {
		$scope.weather = $scope.getWeather();
	}
}]);