app.constant("WEATHER_ENDPOINT", "php/apis/weather/");
app.service("WeatherService", function($http, WEATHER_ENDPOINT) {
	function getUrl() {
		
		return(WEATHER_ENDPOINT);

	}


	this.fetchWeather = function() {
		return($http.get(getUrl()))


	}
});