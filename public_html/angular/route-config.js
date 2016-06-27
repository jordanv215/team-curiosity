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
		// route for the sresult page
		.when('/result', {
			controller : 'resultController',
			templateUrl : 'angular/templates/result.php'
		})
		// route for the article page
		.when('/article', {
			controller : 'articleController', 
			templateUrl : 'angular/templates/article.php'
		})
		// route for the image page
		.when('/image', {
			controller : 'imageController',
			templateUrl : 'angular/templates/image.php'
		})

		// otherwise redirect to home
		.otherwise({
			redirectTo: '/'
		});

	//use the HTML5 History API

	$locationProvider.html5Mode(true);

});