myAppControllers.controller('fundSourceCtrl',['$q','$scope','$modalInstance','selectedFundSource',function($q,$scope,$modalInstance,selectedFundSource) {
    $scope.selectedFundSource = selectedFundSource;
    
    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    };
    
    $scope.submit = function () {
        $modalInstance.close($scope.selectedFundSource.donations);
    };
}]);