myAppControllers.controller('confirmCtrl',['$scope','$state',function($scope,$state) {
    $scope.showErrors=false;
    $scope.company = sessionStorage.company;
    $scope.next = function(){
        if(!$scope.form.$invalid){
            sessionStorage.company = $scope.company;
            $state.go('report');
        }
        
        $scope.showErrors=true;
    };
}]);