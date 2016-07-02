app.controller("newsController", ["$scope", "NewsService", function($scope, NewsService) {
	$scope.myInterval = 5000;
	$scope.noWrapSlides = false;
	$scope.active = 0;
	$scope.news = [];
	var currIndex = 0;

	$scope.getNews = function() {
		NewsService.top25()
			.then(function(result) {
				if(result.status === 200) {
					$scope.news = result.data.data;
				} else {
					console.log("couldn't load news articles: " + result.data.message);
				}
			});
	};


	// load the array on first view
	if($scope.news.length === 0) {
		$scope.news = $scope.getNews();
	}

}]);

//----------------- Controller for uib-modal test --------------------//
app.service('modalService',['$uibModal', function ($uibModal) {
	this.openModal = function() {
		var modalInstance = $uibModal.open({
			templateUrl: '../templates/modal.php',
			controller: 'ModalInstanceCtrl'
		});
	};
}

]);
app.controller('ModalDemoCtrl',[modalService, function ($scope, $uibModal, $log, modalService) {

	$scope.items = [];

	$scope.animationsEnabled = true;

	$scope.open = function (size) {

		var modalInstance = $uibModal.open({
			animation: $scope.animationsEnabled,
			templateUrl: 'modal.php',
			controller: 'ModalInstanceCtrl',
			size: size,
			resolve: {
				items: function () {
					return $scope.items;
				}
			}
		});

		$scope.check = function() {
			modalService.openModal();
		};

		modalInstance.result.then(function (selectedItem) {
			$scope.selected = selectedItem;
		}, function () {
			$log.info('Modal dismissed at: ' + new Date());
		});
	};

	$scope.toggleAnimation = function () {
		$scope.animationsEnabled = !$scope.animationsEnabled;
	};

}]);

// Please note that $uibModalInstance represents a modal window (instance) dependency.
// It is not the same as the $uibModal service used above.

app.controller('ModalInstanceCtrl', function ($scope, modalInstance, items) {

	$scope.items = items;
	$scope.selected = {
		item: $scope.items[0]
	};

	$scope.ok = function () {
		modalInstance.close($scope.selected.item);
	};

	$scope.cancel = function () {
		modalInstance.dismiss('cancel');
	};
	



});