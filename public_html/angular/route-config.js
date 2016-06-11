// configure our routes
app.config(function($routeProvider, $locationProvider) {
	$routeProvider

	// route for the home page
		.when('/', {
			controller  : 'homeController',
			templateUrl : 'angular/templates/home.php'
		})

		// route for the images page
		.when('/images', {
			controller  : 'imagesController',
			templateUrl : 'angular/templates/images.php'
		})

		// route for the news page
		.when('/news', {
			controller  : 'newsController',
			templateUrl : 'angular/templates/news.php'
		})

		// route for the about page
		.when('/about', {
			controller  : 'aboutController',
			templateUrl : 'angular/templates/about.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: '/'
		});

	//use the HTML5 History API

	$locationProvider.html5Mode(true);

});