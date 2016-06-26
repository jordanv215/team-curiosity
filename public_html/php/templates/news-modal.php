<!-- ui.bootstrap.modal -->
<div ng-controller="NewsController">
	<script type="text/ng-template" id="myModalContent.html">
		<div class="modal-header">
			<h3 class="modal-title">Comment or Favorite</h3>
		</div>
		<div class="modal-body">
			<ul>
				<li ng-repeat="item in items">
					<a href="#" ng-click="$event.preventDefault(); selected.item = item">{{ item }}</a>
				</li>
			</ul>
			Selected: <b>{{ selected.item }}</b>
		</div>
		<div class="modal-footer">
			<button class="btn btn-warning" type="button" ng-click="cancel()">Close</button>
		</div>
	</script>


	<button type="button" class="btn btn-default" ng-click="open('lg')">Login to comment or favorite</button>
	<div ng-show="selected">Selection from a modal: {{ selected }}</div>
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