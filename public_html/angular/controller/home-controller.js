app.controller("HomeController", ["$scope", "WeatherService", function($scope, WeatherService) {
	$scope.weather = [];
	
	$scope.getWeather = function() {
		WeatherService.fetchWeather()
			.then(function(result) {
				if(result.status === 200) {
					$scope.weather = result.data.data;
				} else {
					console.log("couldn't load weather data: " + result.data.message);
				}
			});
	};
	// load the array on first view
	if($scope.weather.length === 0) {
		$scope.weather = $scope.getWeather();
	}
}]);