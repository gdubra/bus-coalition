myAppControllers.controller('confirmCtrl',['$scope','$state',function($scope,$state) {
    
    $scope.company = sessionStorage.getObject('company');
    
    //if no company object initialized go first step
    if(!angular.isDefined($scope.company)){
        $state.go('step1');
    }
    
    $scope.next = function(){
        $state.go('downloads');
    };
    
    $scope.back = function(){
        $state.go('step3');
    };
}]);