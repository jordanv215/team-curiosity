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
			<h3 class="modal-title">I'm a modal!</h3>
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


	<button type="button" class="btn btn-default" ng-click="open('lg')">Large modal</button>
	<div ng-show="selected">Selection from a modal: {{ selected }}</div>
</div>

<!-- controller for image modal-->
angular.module('ui.bootstrap.demo', ['ngAnimate', 'ui.bootstrap']);
angular.module('ui.bootstrap.demo').controller('ModalDemoCtrl', function ($scope, $uibModal, $log) {

$scope.items = ['item1', 'item2', 'item3'];

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