<div class="container">

	<!-- Modal -->
	<div class="modal fade" id="image-modal" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<p>test test test test</p>
				</div>
			</div>

		</div>
	</div>
</div>
<!-- ui.bootstrap.modal -->
<div ng-controller="ModalDemoCtrl">
	<script type="text/ng-template" id="myModalContent.html">
		<div class="modal-header">
			<h3 class="modal-title">Comment or Favorite</h3>
			<a href="https://www.reddit.com/" target="_blank"><i class="fa fa-reddit-alien fa-2x"></i></a>
			<a href="#" target="_blank"><i class="fa fa-heart fa-2x"></i></a>
			<a href="#" target="_blank"><i class="fa fa-commenting fa-2x"></i></a>
			<a href="#" target="_blank"><i class="fa fa-commenting fa-2x"></i></a>
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		</div>
		<div class="modal-body">
				
			</div>
		<div class="modal-footer">
			<button class="btn btn-warning" type="button" ng-click="cancel()">Close</button>
		</div>
	</script>
	
</div>

<!-- controller for image modal-->
angular.module('ui.bootstrap.demo', ['ngAnimate', 'ui.bootstrap']);
angular.module('ui.bootstrap.demo').controller('ModalDemoCtrl', function ($scope, $uibModal, $log) {

$scope.items = [];

$scope.animationsEnabled = true;

$scope.open = function (size) {

var modalInstance = $uibModal.open({
animation: $scope.animationsEnabled,
templateUrl: 'myModalContent.html',
controller: 'ModalInstanceCtrl',
size: size,
resolve: {
items: function () {
return $scope.items;
}
}
});

modalInstance.result.then(function (selectedItem) {
$scope.selected = selectedItem;
}, function () {
$log.info('Modal dismissed at: ' + new Date());
});
};

$scope.toggleAnimation = function () {
$scope.animationsEnabled = !$scope.animationsEnabled;
};

});

// Please note that $uibModalInstance represents a modal window (instance) dependency.
// It is not the same as the $uibModal service used above.

angular.module('ui.bootstrap.demo').controller('ModalInstanceCtrl', function ($scope, $uibModalInstance, items) {

$scope.items = items;
$scope.selected = {
item: $scope.items[0]
};

$scope.ok = function () {
$uibModalInstance.close($scope.selected.item);
};

$scope.cancel = function () {
$uibModalInstance.dismiss('cancel');
};
});