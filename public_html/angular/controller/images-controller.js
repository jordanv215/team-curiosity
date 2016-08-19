app.controller("imagesController", ["$scope", "ImagesService", function($scope, ImagesService) {
	$scope.myInterval = 5000;
	$scope.noWrapSlides = false;
	$scope.active = 0;
	var slides = $scope.slides = [];
	var currIndex = 0;
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
	$scope.addSlide = function() {
		var newWidth = 600 + slides.length + 1;
		slides.push({
			id: currIndex++
		});
	};

	$scope.randomize = function() {
		var indexes = generateIndexesArray();
		assignNewIndexesToSlides(indexes);
	};

	for (var i = 0; i < 25; i++) {
		$scope.addSlide();
	}

	// Randomize logic below

	function assignNewIndexesToSlides(indexes) {
		for (var i = 0, l = slides.length; i < l; i++) {
			slides[i].id = indexes.pop();
		}
	}

	function generateIndexesArray() {
		var indexes = [];
		for (var i = 0; i < currIndex; ++i) {
			indexes[i] = i;
		}
		return shuffle(indexes);
	}

	// http://stackoverflow.com/questions/962802#962890
	function shuffle(array) {
		var tmp, current, top = array.length;

		if (top) {
			while (--top) {
				current = Math.floor(Math.random() * (top + 1));
				tmp = array[current];
				array[current] = array[top];
				array[top] = tmp;
			}
		}

		return array;
	}

}]);
