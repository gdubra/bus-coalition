myAppControllers.controller('fleetCtrl',['$scope','$state',function($scope,$state) {
    $scope.showErrors=false;
    $scope.company = sessionStorage.company;
    $scope.next = function(){
        if(!$scope.form.$invalid){
            sessionStorage.company = $scope.company;
            $state.go('step4');
        }
        
        $scope.showErrors=true;
    };
}]);