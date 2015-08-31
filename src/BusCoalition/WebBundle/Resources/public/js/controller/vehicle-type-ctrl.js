myAppControllers.controller('vehicleTypeCtrl',['$scope','$modalInstance',function($scope,$modalInstance) {
    $scope.selectedVehicle = {};
    $scope.showErrors = false;
    $scope.actualYear = function(){
        return new Date().getFullYear();
    };
    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    };
    
    $scope.submit = function () {
        if(!$scope.form.$invalid){
            $modalInstance.close($scope.selectedVehicle);
        }
        
        $scope.showErrors = true;
    };
}]);