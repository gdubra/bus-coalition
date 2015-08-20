myAppControllers.controller('basicInfoCtrl',['$scope','$state',function($scope,$state) {
    $scope.showErrors=false;
    $scope.next = function(){
        if(!$scope.form.$invalid){
            sessionStorage.setObject('company',$scope.company);
            $state.go('step2');
        }
        
        $scope.showErrors=true;
    };
}]);
