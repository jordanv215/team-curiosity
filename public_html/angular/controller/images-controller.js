app.controller("imagesController", ["$scope", "ImagesService", function($scope, ImagesService) {
	$scope.images = [];
	
	$scope.getImages = function() {
		ImagesService.fetchImage()
			.then(function(result) {
				if(result.status === 200) {
					$scope.images = result.data;
				} else {
					console.log("couldn't load images: " + result.data.message);
				}
			});
	};
	// load the array on first view
	if($scope.images.length === 0) {
		$scope.images = $scope.getImages();
	}
	data.local="#imageCarousel"
}]);
