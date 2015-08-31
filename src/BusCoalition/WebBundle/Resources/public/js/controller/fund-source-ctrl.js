myAppControllers.controller('fundSourceCtrl',['$q','$scope','$modalInstance','$filter','selectedFundSource',function($q,$scope,$modalInstance,$filter,selectedFundSource) {
    $scope.selectedFundSource = selectedFundSource;
    $scope.showErrors=false;
    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    };
    
    $scope.submit = function () {
//        var years = $filter('fundSourceLifetime')($scope.selectedFundSource);
//        for(var i=0;i < years.length; i++){
//            if(!angular.isDefined($scope.selectedFundSource.donations[years[i]])){
//                $scope.selectedFundSource.donations[years[i]] = 0;
//            }
//        }
        if(!$scope.form.$invalid){
            $modalInstance.close($scope.selectedFundSource.donations);
        }
        
        $scope.showErrors=true;
    };
}]);