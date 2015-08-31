myAppControllers.controller('vehicleCtrl',['$scope','$modalInstance','selectedVehicle',function($scope,$modalInstance,selectedVehicle) {
    $scope.selectedVehicle = selectedVehicle;
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
        }else{
            $scope.showErrors = true;
        }
    };
}]);