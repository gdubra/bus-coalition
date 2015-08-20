myAppControllers.controller('fundSourceCtrl',['$q','$scope','$modalInstance','fundSource',function($q,$scope,$modalInstance,foundSource) {
    $scope.foundSource = foundSource;
    
    $scope.cancel = function(){
        $modalInstance.dismiss('cancel');
    };
}]);