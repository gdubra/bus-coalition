myAppControllers.controller('AlertsCtrl',['$rootScope','$scope',function($rootScope,$scope) {
    $rootScope.alerts=null;
	$scope.close = function($index){$rootScope.alerts.splice($index, 1);};
}]);
