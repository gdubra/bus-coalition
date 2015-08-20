myAppControllers.controller('vehicleCtrl',['$scope','$modalInstance','selectedVehicle',function($scope,$modalInstance,selectedVehicle) {
    $scope.selectedVehicle = selectedVehicle;
    
    $scope.actualYear = function(){
        return new Date().getFullYear();
    };
    
    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    };
    
    $scope.submit = function () {
        $modalInstance.close($scope.selectedVehicle);
    };
}]);