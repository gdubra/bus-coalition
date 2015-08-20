myAppControllers.controller('vehicleTypeCtrl',['$scope','$modalInstance',function($scope,$modalInstance) {
    $scope.vehicleType = {};
    
    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    };
    
    $scope.submit = function () {
        $modalInstance.close($scope.vehicleType);
    };
}]);